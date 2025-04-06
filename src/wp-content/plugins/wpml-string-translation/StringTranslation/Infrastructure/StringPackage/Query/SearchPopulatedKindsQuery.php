<?php

namespace WPML\StringTranslation\Infrastructure\StringPackage\Query;

use WPML\StringTranslation\Application\StringPackage\Query\Criteria\SearchPopulatedKindsCriteria;
use WPML\StringTranslation\Application\StringPackage\Query\SearchPopulatedKindsQueryInterface;

class SearchPopulatedKindsQuery implements SearchPopulatedKindsQueryInterface {

	/** @var \wpdb */
	private $wpdb;

	/** @var \SitePress */
	private $sitepress;

	/** @var SearchPopulatedKindsQueryBuilder */
	private $searchPopulatedKindsQueryBuilder;

	public function __construct(
		SearchPopulatedKindsQueryBuilder $searchPopulatedKindsQueryBuilder
	) {
		global $wpdb, $sitepress;
		$this->wpdb = $wpdb;
		$this->sitepress = $sitepress;
		$this->searchPopulatedKindsQueryBuilder = $searchPopulatedKindsQueryBuilder;
	}

	/**
	 * @param SearchPopulatedKindsCriteria $criteria
	 *
	 * @return string[]
	 */
	public function get( SearchPopulatedKindsCriteria $criteria ) {
		$populatedKinds = $criteria->getStringPackageTypeIds();
		foreach( $populatedKinds as $postTypeIndex => $postType ) {
		$query = $this->searchPopulatedKindsQueryBuilder->build( $criteria, $postType );
			if ( ! $this->wpdb->get_col( $query ) ) {
				unset( $populatedKinds[ $postTypeIndex ] );
			}
		}

		return $populatedKinds;
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
}
