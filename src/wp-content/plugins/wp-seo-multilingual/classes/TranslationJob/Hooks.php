<?php

namespace WPML\WPSEO\TranslationJob;

use WPML\WPSEO\Shared\TranslationJob\BaseHooks;

class Hooks extends BaseHooks {

	const OPTION_PREFIX = 'wpseo_';

	/**
	 * @inheritDoc
	 */
	protected function getFieldPrefix() {
		return 'field-_yoast_wpseo_';
	}

	/**
	 * @inheritDoc
	 */
	protected function getTopLevelGroup() {
		return [ self::OPTION_PREFIX => 'Yoast SEO' ];
	}

	/**
	 * @inheritDoc
	 */
	protected function getKeyPurposeMap() {
		return [
			'_yoast_wpseo_title'    => self::PURPOSE_SEO_TITLE,
			'_yoast_wpseo_metadesc' => self::PURPOSE_SEO_META_DESC,
		];
	}
}
