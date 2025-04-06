<?php

namespace WPML\WPSEO\RankMathSEO\Sitemap;

use WPML\Element\API\PostTranslations;
use WPML\FP\Fns;
use WPML\FP\Lst;
use WPML\FP\Maybe;
use WPML\FP\Obj;
use WPML\FP\Relation;

class Hooks implements \IWPML_Frontend_Action, \IWPML_DIC_Action {

	/** @var \WPML_URL_Converter $urlConverter */
	private $urlConverter;


	/** @var \SitePress $sitepress */
	private $sitepress;

	/** @var null|array $secondaryHomeUrls */
	private $secondaryHomesById;

	public function __construct( \WPML_URL_Converter $urlConverter, \SitePress $sitepress ) {
		$this->urlConverter = $urlConverter;
		$this->sitepress    = $sitepress;
	}

	public function add_hooks() {
		add_filter( 'rank_math/sitemap/entry', [ $this, 'filterEntry' ], 10, 3 );
	}

	/**
	 * @param array  $url
	 * @param string $type
	 * @param object $object
	 *
	 * @return array|null
	 */
	public function filterEntry( $url, $type, $object ) {
		if ( $url && 'post' === $type ) {
			return $this->replaceHomePageInSecondaryLanguages( $url, $object );
		}

		return $url;
	}

	/**
	 * @param array  $url
	 * @param object $object
	 *
	 * @return array
	 */
	private function replaceHomePageInSecondaryLanguages( $url, $object ) {
		if ( null === $this->secondaryHomesById ) {
			/** @var \callable(object):bool $isInDefaultLang */
			$isInDefaultLang = Relation::propEq( 'language_code', $this->sitepress->get_default_language() );

			// $getIdAndUrl :: \stdClass -> []
			$getIdAndUrl = function( $translation ) {
				return [
					(int) $translation->element_id,
					$this->urlConverter->convert_url( home_url(), $translation->language_code )
				];
			};

			$this->secondaryHomesById = Maybe::fromNullable( get_option( 'page_on_front' ) )
			                                 ->map( PostTranslations::get() )
			                                 ->map( Fns::reject( $isInDefaultLang ) )
			                                 ->map( Fns::map( $getIdAndUrl ) )
			                                 ->map( Lst::fromPairs() )
			                                 ->getOrElse( [] );
		}

		return Obj::assoc(
			'loc',
			Obj::propOr(
				$url['loc'],
				(int) Obj::prop( 'ID', $object ),
				$this->secondaryHomesById
			),
			$url
		);
	}
}
