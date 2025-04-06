<?php

namespace WPML\StringTranslation\Infrastructure\StringPackage\Query;

use WPML\StringTranslation\Application\StringPackage\Query\Criteria\StringPackageCriteria;
use WPML\StringTranslation\Application\Setting\Repository\SettingsRepositoryInterface as SettingsRepository;

class FindStringPackagesQueryBuilder {
	use SearchQueryBuilderTrait;

	const SP_COLUMNS = '
        sp.ID,
        sp.name,
        sp.kind_slug,
        sp.title,
        sp.word_count,
        sp.translator_note
    ';

	/** @var \SitePress */
	private $sitepress;

	/** @var SettingsRepository */
	private $settingsRepository;

	/** @var \wpdb */
	private $wpdb;

	// todo: this is depending on wpml/wpml, handle exception.
	public function __construct(
		SettingsRepository $settingsRepository
	) {
		global $wpdb, $sitepress;
		$this->wpdb               = $wpdb;
		$this->sitepress          = $sitepress;
		$this->settingsRepository = $settingsRepository;
	}


	public function build( StringPackageCriteria $criteria ): string {

		return $this->buildQueryWithFields( $criteria );
	}

	/**
	 * @param array[] $packages
	 * @return string|null
	 */
	public function buildJobsQuery( $packages ) {
		$rids = [];

		foreach ( $packages as $package ) {
			$translationStatuses = $package['translation_statuses'];
			$languageStatuses    = explode( ';', $translationStatuses );
			foreach ( $languageStatuses as $languageStatus ) {
				$rid = $this->getRidFromTranslationStatus( $languageStatus );
				if ( $rid ) {
					$rids[] = $rid;
				}
			}
		}

		$rids = array_unique( $rids );
		if ( empty( $rids ) ) {
			return null;
		}
		return "
			SELECT
				tj.rid,
				tj.job_id,
				tj.translator_id,
				ts.status,
				ts.review_status,
				ts.needs_update,
				tj.automatic,
				ts.translation_service,
				tj.editor,
				tj.translated
			FROM {$this->wpdb->prefix}icl_translate_job tj
			LEFT JOIN {$this->wpdb->prefix}icl_translation_status ts
			    ON tj.rid = ts.rid
			INNER JOIN (
			SELECT
			  rid,
			  MAX(job_id) AS max_job_id
			FROM {$this->wpdb->prefix}icl_translate_job
			WHERE rid IN (" . implode( ',', $rids ) . ')
			GROUP BY rid
			) latest_jobs
			ON tj.rid = latest_jobs.rid
			AND tj.job_id = latest_jobs.max_job_id';
	}

	/**
	 * @param string[] $languageCodes
	 * @return string
	 */
	private function getTranslationStatuesColumns( $languageCodes ): string {
		$columns = [];

		foreach ( $languageCodes as $languageCode ) {
			$slugLanguageCode = $this->getLanguageJoinColumName( $languageCode );
			$languageCode     = $this->wpdb->prepare( $languageCode );

			$columns[] = "CONCAT(
        'languageCode:{$languageCode},status:',
        CASE 
            WHEN target_ts_{$slugLanguageCode}.needs_update = 1 THEN 3
            WHEN target_t_{$slugLanguageCode}.trid IS NOT NULL
	            AND (
	                target_t_{$slugLanguageCode}.source_language_code IS NULL
	                    OR target_ts_{$slugLanguageCode}.status = 0
	                ) THEN 10
            ELSE IFNULL(target_ts_{$slugLanguageCode}.status, 0)
        END,
        ', reviewStatus:', 
        IFNULL(target_ts_{$slugLanguageCode}.review_status, ''),
        ',rid:', 
        IFNULL(target_ts_{$slugLanguageCode}.rid, '')
      )";
		}
		return 'CONCAT(' . implode( ", '; ', ", $columns ) . ') AS translation_statuses';
	}

	/**
	 * @param array<string> $escapedLanguageCodes
	 * @return string
	 */
	private function getFields( array $escapedLanguageCodes ): string {
		$spColumns                  = self::SP_COLUMNS;
		$translationStatusesColumns = $this->getTranslationStatuesColumns( $escapedLanguageCodes );

		return "
        {$spColumns},
        {$translationStatusesColumns}
		";
	}

	private function buildSortingQueryPart( StringPackageCriteria $criteria ): string {
		$allowedSortingDirections = [ 'DESC', 'ASC' ];
		$direction                = $allowedSortingDirections[0];

		$queryPart = 'ORDER BY sp.ID';

		if ( $criteria->getSorting() ) {
			$sortingCriteria = $criteria->getSorting();
			$sortingOrder    = strtoupper( $sortingCriteria['order'] );

			if ( $sortingCriteria['by'] === 'title' ) {
				$direction = in_array( $sortingOrder, $allowedSortingDirections ) ?
					$sortingOrder :
					$direction;

				$queryPart = 'ORDER BY sp.title';
			}
		}

		return $queryPart . ' ' . $direction;
	}

	private function buildQueryWithFields( StringPackageCriteria $criteria, $fields = null, bool $withPagination = true ): string {
		$sourceLanguage       = $criteria->getSourceLanguageCode();
		$escapedLanguageCodes = $this->getEscapedLanguageCodes( $criteria, $sourceLanguage );
		$fields               = $fields ?? $this->getFields( $escapedLanguageCodes );

		$sql = "
      SELECT
          {$fields}
      FROM {$this->wpdb->prefix}icl_string_packages sp
      INNER JOIN {$this->wpdb->prefix}icl_translations source_t
      	ON source_t.element_id = sp.ID
        AND source_t.element_type = CONCAT('package_', sp.kind_slug)
        AND source_t.language_code = '{$sourceLanguage}'
      {$this->buildTargetLanguageJoins( $escapedLanguageCodes )}
      WHERE sp.kind_slug = '{$criteria->getType()}'
          {$this->buildPostTitleCondition( $criteria )}
      {$this->buildTranslationStatusConditionWrapper( $criteria, $escapedLanguageCodes )}
          GROUP BY sp.ID
      {$this->buildSortingQueryPart( $criteria )}
    ";

		if ( $withPagination ) {
			$sql .= ' ' . $this->buildPagination( $criteria );
		}

		return $sql;
	}


	private function buildPostTitleCondition(
		StringPackageCriteria $criteria
	): string {
		if ( $criteria->getTitle() ) {
			return $this->wpdb->prepare(
				'AND sp.title LIKE %s',
				'%' . $this->wpdb->esc_like( $criteria->getTitle() ) . '%'
			);
		}

		return '';
	}


	private function buildPagination( StringPackageCriteria $criteria ): string {
		return $this->wpdb->prepare(
			'LIMIT %d OFFSET %d',
			$criteria->getLimit(),
			$criteria->getOffset()
		);
	}


	/**
	 * @param StringPackageCriteria $criteria
	 * @param string                $sourceLanguage
	 * @return array|string[]
	 */
	private function getEscapedLanguageCodes( StringPackageCriteria $criteria, string $sourceLanguage ): array {
		$languageCodes = $criteria->getTargetLanguageCode() ?
			[ $criteria->getTargetLanguageCode() ] :
			$this->settingsRepository->getActiveLanguageCodes();

		$languageCodes = array_filter(
			$languageCodes,
			function ( $languageCode ) use ( $sourceLanguage ) {
				return $languageCode !== $sourceLanguage;
			}
		);

		$languageCodes = array_unique( $languageCodes );

		$escapedLanguageCodes = array_map(
			function ( $languageCode ) {
				return $this->wpdb->prepare( $languageCode );
			},
			$languageCodes
		);
		return $escapedLanguageCodes;
	}

	/**
	 * @param string $translationStatus
	 * @return int|null
	 */
	private function getRidFromTranslationStatus( string $translationStatus ) {
		$matches = [];
		preg_match( '/rid:(\d+)/', $translationStatus, $matches );

		return count( $matches ) > 0 ? intval( $matches[1] ) : null;
	}

	private function buildTranslationStatusConditionWrapper(
		StringPackageCriteria $criteria,
		array $targetLanguageCodes
	) : string {
		return 'AND ' . $this->buildTranslationStatusCondition( $criteria, $targetLanguageCodes );
	}

}
