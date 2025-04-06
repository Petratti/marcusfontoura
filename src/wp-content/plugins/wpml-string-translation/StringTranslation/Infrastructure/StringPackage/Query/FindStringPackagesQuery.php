<?php

namespace WPML\StringTranslation\Infrastructure\StringPackage\Query;

use WPML\StringTranslation\Application\StringPackage\Query\Criteria\StringPackageCriteria;
use WPML\StringTranslation\Application\StringPackage\Query\Dto\StringPackageWithTranslationStatusDto;
use WPML\StringTranslation\Application\StringPackage\Query\FindStringPackagesQueryInterface;
use WPML\StringTranslation\Infrastructure\Translation\TranslationStatusesParser;

class FindStringPackagesQuery implements FindStringPackagesQueryInterface {

	/** @var \wpdb */
	private $wpdb;

	/** @var \SitePress */
	private $sitepress;

	/** @var FindStringPackagesQueryBuilder */
	private $findStringPackagesQueryBuilder;

	/** @var TranslationStatusesParser */
	private $translationStatusesParser;

	public function __construct(
		FindStringPackagesQueryBuilder $findStringPackagesQueryBuilder,
		TranslationStatusesParser $translationStatusesParser
	) {
		global $wpdb, $sitepress;
		$this->wpdb = $wpdb;
		$this->sitepress = $sitepress;
		$this->findStringPackagesQueryBuilder = $findStringPackagesQueryBuilder;
		$this->translationStatusesParser = $translationStatusesParser;
	}

	/**
	 * @param StringPackageCriteria $criteria
	 *
	 * @return StringPackageWithTranslationStatusDto[]
	 */
	public function execute( StringPackageCriteria $criteria ) {
		$query = $this->findStringPackagesQueryBuilder->build( $criteria );

		$packages = $this->wpdb->get_results( $query, ARRAY_A);
		$results = [];

		$jobsQuery = $this->findStringPackagesQueryBuilder->buildJobsQuery( $packages );
		$jobs = $this->wpdb->get_results( $jobsQuery, ARRAY_A );
		$indexedJobs = [];
		if ( $jobs ) {
			foreach( $jobs as $job ) {
				$indexedJobs[(int)$job['rid']] = $job;
			}
		}

		foreach ( $packages as $package ) {
			$translationStatuses = $this->translationStatusesParser->parse( $package['translation_statuses'], $indexedJobs );

			$packageDto = new StringPackageWithTranslationStatusDto(
				$package['ID'],
				$package['title'],
				$package['name'],
				1,
				$package['kind_slug'],
				$translationStatuses,
				is_numeric( $package['word_count'] ) ? (int) $package['word_count'] : 0,
				$package['translator_note']
			);
			$results[] = $packageDto;
		}
		return $results;
	}

}
