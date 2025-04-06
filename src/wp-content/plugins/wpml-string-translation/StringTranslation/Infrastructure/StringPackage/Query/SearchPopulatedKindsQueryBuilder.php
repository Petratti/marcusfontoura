<?php

namespace WPML\StringTranslation\Infrastructure\StringPackage\Query;

use WPML\StringTranslation\Application\Setting\Repository\SettingsRepositoryInterface as SettingsRepository;
use WPML\StringTranslation\Application\StringPackage\Query\Criteria\SearchPopulatedKindsCriteria;

class SearchPopulatedKindsQueryBuilder {
	use SearchQueryBuilderTrait;

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

	public function build( SearchPopulatedKindsCriteria $criteria, $stringPackageId ): string {
		return $this->buildQueryWithFields( $criteria, $stringPackageId );
	}

	private function buildQueryWithFields( SearchPopulatedKindsCriteria $criteria, $stringPackageId ): string {
		$sourceLanguage = $criteria->getSourceLanguageCode()
			?
			$this->wpdb->prepare( $criteria->getSourceLanguageCode() )
			: $this->getDefaultLanguageCode();


		$languageCodes = $criteria->getTargetLanguageCode() ?
			[ $this->wpdb->prepare( $criteria->getTargetLanguageCode() ) ] :
			$this->getDefaultSecondaryLanguageCodes();

		$sql = "
			SELECT sp.kind_slug
			FROM {$this->wpdb->prefix}icl_string_packages sp
			INNER JOIN {$this->wpdb->prefix}icl_translations source_t
			  ON source_t.element_id = sp.ID
			  AND source_t.element_type = CONCAT('package_', sp.kind_slug)
			  AND source_t.language_code = '{$sourceLanguage}'
			{$this->buildTargetLanguageJoins( $languageCodes )}
			WHERE
				{$this->buildTranslationStatusConditionWrapper( $criteria, $languageCodes )}
				AND sp.kind_slug = '{$stringPackageId}'
			LIMIT 0,1;
    ";

		return $sql;
	}


	private function getDefaultLanguageCode() {
		return $this->sitepress->get_default_language() ?: 'en';
	}

	private function getDefaultSecondaryLanguageCodes() {
		$defaultLanguageCode = $this->getDefaultLanguageCode();
		$secondaryLanguages = $this->sitepress->get_active_languages();
		$secondaryLanguages = array_filter( $secondaryLanguages, function ( $language ) use ( $defaultLanguageCode ) {
			return $language['code'] !== $defaultLanguageCode;
		} );

		return array_keys( array_map( function ( $language ) {
			return $language['code'];
		}, $secondaryLanguages ) );
	}

	private function prepareArray( array $value ) {
		foreach ( $value as $key => $val ) {
			$value[ $key ] = $this->wpdb->prepare( $val );
		}
		return $value;
	}


	private function buildTranslationStatusConditionWrapper(
		SearchPopulatedKindsCriteria $criteria,
		array $languageCodes
	) : string {
		return $this->buildTranslationStatusCondition( $criteria, $languageCodes );
	}
}
