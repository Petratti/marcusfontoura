<?php

namespace WPML\StringTranslation\Infrastructure\StringPackage\Query;

use WPML\Core\SharedKernel\Component\Translation\Domain\TranslationStatus;
use WPML\StringTranslation\Application\StringPackage\Query\Criteria\SearchPopulatedKindsCriteria;
use WPML\StringTranslation\Application\StringPackage\Query\Criteria\StringPackageCriteria;

trait SearchQueryBuilderTrait {

	/**
	 * @param StringPackageCriteria|SearchPopulatedKindsCriteria $criteria
	 * @param array<string>                                      $targetLanguageCodes
	 *
	 * @return string
	 */
	protected function buildTranslationStatusCondition( $criteria, array $targetLanguageCodes ) : string {
		$isNotTranslated = in_array( TranslationStatus::NOT_TRANSLATED, $criteria->getTranslationStatuses() );
		$needsUpdate     = in_array( TranslationStatus::NEEDS_UPDATE, $criteria->getTranslationStatuses() );
		$complete        = in_array( TranslationStatus::COMPLETE, $criteria->getTranslationStatuses() );

		$languagesCombinedConditions = [];
		foreach ( $targetLanguageCodes as $targetLanguageCode ) {
			$slugTargetLanguageCode = $this->getLanguageJoinColumName( $targetLanguageCode );
			$appendConditions       = [];
			if ( $isNotTranslated ) {
				// Element IDs are null for packages so just check trid.
				$appendConditions[] = sprintf( 'target_t_%1$s.trid IS NULL', $slugTargetLanguageCode );
			}
			if ( $needsUpdate ) {
				$appendConditions[] = sprintf( 'target_ts_%s.needs_update = 1', $slugTargetLanguageCode );
			}
			if ( $complete ) {
				// We want to display package with canceled jobs (status 0) but already translated.
				$appendConditions[] = sprintf(
					'(target_t_%1$s.trid IS NOT NULL AND target_ts_%1$s.status = 0)',
					$slugTargetLanguageCode
				);
			}

			$statuses = [];
			foreach ( $criteria->getTranslationStatuses() as $status ) {
				if ( in_array( $status, [ TranslationStatus::NOT_TRANSLATED, TranslationStatus::NEEDS_UPDATE ] ) ) {
					continue;
				}
				$statuses[] = $this->wpdb->prepare( (string) $status );
			}

			if ( ! empty( $statuses ) ) {
				$appendConditions[] = sprintf(
					'target_ts_%1$s.status IN %2$s' .
						// Make sure "needs_update" is 0 for filter "Translation complete".
						( $complete ? ' AND target_ts_%1$s.needs_update = 0' : '' ),
					$slugTargetLanguageCode,
					'(' . implode( ', ', $statuses ) . ')'
				);
			}

			if ( ! empty( $appendConditions ) ) {
				$languagesCombinedConditions[] = '(' . implode( ' OR ', $appendConditions ) . ')';
			}
		}
		if ( empty( $languagesCombinedConditions ) ) {
			return '1';
		}
		return '(' . implode( ' OR ', $languagesCombinedConditions ) . ')';
	}

	protected function getLanguageJoinColumName( string $languageCode ) : string {
		return preg_replace( '/[^a-zA-Z0-9]/', '_', $languageCode ) ?: $languageCode;
	}

	/**
	 * @param array<string> $targetLanguageCodes
	 * @return string
	 */
	protected function buildTargetLanguageJoins( array $targetLanguageCodes ) : string {
		$joins = [];
		foreach ( $targetLanguageCodes as $languageCode ) {
			$slugLanguageCode = $this->getLanguageJoinColumName( $languageCode );
			$joins[]          = "
	        LEFT JOIN {$this->wpdb->prefix}icl_translations target_t_{$slugLanguageCode}
	          ON target_t_{$slugLanguageCode}.trid = source_t.trid
	              AND target_t_{$slugLanguageCode}.language_code = '{$languageCode}'
	        LEFT JOIN {$this->wpdb->prefix}icl_translation_status target_ts_{$slugLanguageCode}
	          ON target_ts_{$slugLanguageCode}.translation_id = target_t_{$slugLanguageCode}.translation_id
	      ";
		}
		return implode( ' ', $joins );
	}


}
