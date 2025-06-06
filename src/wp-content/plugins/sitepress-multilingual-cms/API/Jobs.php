<?php

namespace WPML\TM\API;

use WPML\Collect\Support\Traits\Macroable;
use WPML\Element\API\PostTranslations;
use WPML\Element\API\TranslationsRepository;
use WPML\FP\Fns;
use WPML\FP\Logic;
use WPML\FP\Maybe;
use WPML\FP\Obj;
use WPML\FP\Str;
use WPML\FP\Lst;
use WPML\Settings\PostType\Automatic;
use WPML\TM\API\ATE\LanguageMappings;
use WPML\TM\API\Job\Map;
use WPML\TM\Records\UpdateTranslationReviewStatus;
use function WPML\Container\make;
use function WPML\FP\curryN;
use function WPML\FP\pipe;

/**
 * Class Jobs
 * @package WPML\TM\API
 *
 * @phpstan-type curried "__CURRIED_PLACEHOLDER__"
 *
 * @method static callable|null|\stdClass getPostJob( ...$postId, ...$postType, ...$language ) : Curried:: int->string->string->null|\stdClass
 * @method static callable|null|\stdClass getTridJob( ...$trid, ...$language ) : Curried:: int->string->null|\stdClass
 * @method static callable|void setNotTranslatedStatus( ...$jobId )  : Curried:: int->int
 * @method static callable|void setTranslationService( ...$jobId, $translationService ) : Curried:: int->int|string->int
 * @method static callable|void clearReviewStatus( ...$jobId ) : Curried:: int->int->int
 * @method static callable|array getTranslation( ...$job ) - Curried :: \stdClass->array
 * @method static callable|int getTranslatedPostId( ...$job ) - Curried :: \stdClass->int
 * @method static callable|void incrementRetryCount( ...$jobId ) : Curried:: int->void
 * @method static callable|void setTranslated( ...$jobId, ...$status ) - Curried :: int->bool->int
 * @method static callable|void clearTranslated( ...$jobId ) - Curried :: int->int
 * @method static callable|int clearAutomatic( ...$jobId ) - Curried :: int->int
 * @method static callable|void delete( ...$jobId ) - Curried :: int->void
 * @method static callable|bool isEligibleForAutomaticTranslations( ...$jobId ) - Curried :: int->bool
 */
class Jobs {
	use Macroable;

	const SENT_MANUALLY      = 1;
	const SENT_VIA_BASKET    = 2;
	const SENT_AUTOMATICALLY = 3;
	const SENT_FROM_REVIEW   = 4;
	const SENT_RETRY         = 5;
	const SENT_VIA_DASHBOARD = 6;

	public static function init() {

		self::macro( 'getPostJob', curryN( 3, function ( $postId, $postType, $language ) {
			return self::getElementJob( $postId, 'post_' . $postType, $language );
		} ) );


		self::macro( 'getTridJob', curryN( 2, function ( $trid, $language ) {
			$result = TranslationsRepository::getByTridAndLanguage( $trid, $language );
			if ( $result ) {
				return $result;
			}
			$jobId = wpml_load_core_tm()->get_translation_job_id( $trid, $language );

			return $jobId ? wpml_tm_load_job_factory()->get_translation_job_as_stdclass( $jobId ) : null;
		} ) );

		self::macro( 'setNotTranslatedStatus', self::setStatus( Fns::__, ICL_TM_NOT_TRANSLATED ) );

		self::macro( 'setTranslationService', curryN( 2, function ( $jobId, $translationService ) {
			return self::updateTranslationStatusField( $jobId, 'translation_service', $translationService, '%s' );
		} ) );

		self::macro( 'clearReviewStatus', self::setReviewStatus( Fns::__, null ) );

		self::macro( 'incrementRetryCount', curryN( 1, function ( $jobId ) {
			$job = self::get( $jobId );

			return $job && isset( $job->ate_comm_retry_count )
				? self::updateTranslationStatusField(
					$jobId,
					'ate_comm_retry_count',
					$job->ate_comm_retry_count + 1
				 )
				: null;
		} ) );

		self::macro( 'getTranslation', curryN( 1, Fns::converge( Obj::prop(), [
			Obj::prop( 'language_code' ),
			pipe( Obj::prop( 'original_doc_id' ), Fns::memorize( PostTranslations::get() ) )
		] ) ) );

		self::macro( 'getTranslatedPostId', curryN( 1, pipe( self::getTranslation(), Obj::prop( 'element_id' ) ) ) );


		self::macro( 'setTranslated', curryN( 2, function ( $jobId, $status ) {
			return self::updateTranslateJobField( $jobId, 'translated', $status );
		} ) );

		/** @phpstan-ignore-next-line */
		self::macro( 'clearTranslated', self::setTranslated( Fns::__, false ) );

		self::macro( 'clearAutomatic', curryN( 1, function ( $jobId ) {
			return self::updateTranslateJobField( $jobId, 'automatic', 0 );
		} ) );

		self::macro( 'delete', curryN( 1, function ( $jobId ) {
			/** @var \wpdb $wpdb */
			global $wpdb;

			$rid           = Map::fromJobId( $jobId );
			$previousState = \WPML_TM_ICL_Translation_Status::makeByRid( $rid )
			                                                ->previous()
			                                                ->getOrElse( null );

			if ( is_object( $previousState ) || is_array( $previousState ) ) {
				$wpdb->update(
					$wpdb->prefix . 'icl_translation_status',
					Obj::pick( [ 'status', 'translator_id', 'needs_update', 'md5 ' ], $previousState ),
					[ 'rid' => $rid ]
				);
			} else {
				$wpdb->delete(
					$wpdb->prefix . 'icl_translation_status',
					[ 'rid' => $rid ],
					[ 'rid' => '%d' ]
				);
			}
			$wpdb->delete(
				$wpdb->prefix . 'icl_translate_job',
				[ 'job_id' => $jobId ],
				[ 'job_id' => '%d' ]
			);
		} ) );

		self::macro( 'isEligibleForAutomaticTranslations', curryN( 1, Fns::memorize( function ( $wpmlJobId ) {
			$getPostType = pipe( Obj::prop( 'original_post_type' ), Str::replace( 'post_', '' ) );

			return Maybe::of( $wpmlJobId )
			            ->map( Jobs::get() )
			            ->map( Logic::both(
				            pipe( $getPostType, [ Automatic::class, 'shouldTranslate' ] ),
				            pipe( Obj::prop( 'language_code' ), LanguageMappings::isCodeEligibleForAutomaticTranslations() )
			            ) )
			            ->getOrElse( false );
		} ) ) );
	}

	/**
	 * @return string
	 */
	public static function getCurrentUrl() {
		$protocol = ( ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) || Obj::prop( 'SERVER_PORT', $_SERVER ) == 443 ) ? "https://" : "http://";

		return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	/**
	 * It checks whether the job must be synced with ATE or not
	 *
	 * @param array{status: int, editor: string}|\stdClass{status: int, editor: string} $job
	 *
	 * @return bool
	 */
	public static function shouldBeATESynced( $job ) {
		$statuses = [ ICL_TM_WAITING_FOR_TRANSLATOR, ICL_TM_IN_PROGRESS ];

		return Lst::includes( (int) Obj::prop( 'status', $job ), $statuses ) &&
		       Obj::prop( 'editor', $job ) === \WPML_TM_Editors::ATE;
	}

	/**
	 * @param int $jobId
	 * @param bool $isAutomatic
	 *
	 * @return void
	 */
	public static function setAutomaticStatus( $jobId, $isAutomatic ) {
		self::updateTranslateJobField( $jobId, 'automatic', $isAutomatic ? 1 : 0 );

		if ( $isAutomatic ) {
			self::updateTranslateJobField( $jobId, 'translator_id', 0 );
			self::updateTranslationStatusField( $jobId, 'translator_id', 0 );
			self::setStatus( $jobId, ICL_TM_IN_PROGRESS );
		}
	}

	/**
	 * @template A as int
	 * @template B as int
	 * @template R as int
	 *
	 * @param ?(int|curried) $jobId
	 * @param ?(int|curried) $status
	 *
	 * @return ($jobId is A
	 *  ? ($status is B ? R : callable(B=):R)
	 *  : ($jobId is curried
	 *    ? ($status is B ? callable(A=):R : callable(A=,B=):R)
	 *    : callable(A=,B=):R
	 *    )
	 *  )
	 */
	public static function setStatus( $jobId = null, $status = null ) {
		return call_user_func_array(
			curryN(
				2,
				function ( $jobId, $status ) {
					return self::updateTranslationStatusField(
						$jobId,
						'status',
						$status
					);
				}
			),
			func_get_args()
		);
	}


	/**
	 * @template A as int
	 * @template B as string
	 * @template R as int
	 *
	 * @param ?(int|curried)    $jobId
	 * @param ?(string|curried) $status
	 *
	 * @return ($jobId is A
	 *  ? ($status is B ? R : callable(B=):R)
	 *  : ($jobId is curried
	 *    ? ($status is B ? callable(A=):R : callable(A=,B=):R)
	 *    : callable(A=,B=):R
	 *    )
	 *  )
	 */
	public static function setReviewStatus( $jobId = null, $status = null ) {
		return call_user_func_array(
			curryN(
				2,
				function ( $jobId, $status ) {
					return self::updateTranslationStatusField(
						$jobId,
						'review_status',
						$status,
						'%s'
					);
				}
			),
			func_get_args()
		);
	}


	/**
	 * @param int $jobId
	 *
	 * @return \stdClass|false
	 *
	 * @phpstan-template V1 of int|curried
	 * @phpstan-template P1 of int
	 * @phpstan-template R of \stdClass|false
	 *
	 * @phpstan-param ?V1 $jobId
	 *
	 * @phpstan-return ($jobId is P1 ? R : callable(P1=):R)
	 */
	public static function get( $jobId = null ) {
		return call_user_func_array(
			curryN(
				1,
				function ( $jobId ) {
					return wpml_tm_load_job_factory()->get_translation_job_as_stdclass( $jobId );
				}
			),
			func_get_args()
		);
	}

	/**
	 * @param string $returnUrl
	 * @param int $jobId
	 *
	 * @return callable|string
	 *
	 * @phpstan-template A1 of string|curried
	 * @phpstan-template A2 of int|curried
	 * @phpstan-template P1 of string
	 * @phpstan-template P2 of int
	 * @phpstan-template R of string
	 *
	 * @phpstan-param ?A1 $returnUrl
	 * @phpstan-param ?A2 $jobId
	 *
	 * @phpstan-return ($returnUrl is P1
	 *  ? ($jobId is P2 ? R : callable(P2=):R)
	 *  : ($jobId is P2 ? callable(P1=):R : callable(P1=,P2=):R)
	 * )
	 */
	public static function getEditUrl( $returnUrl = null, $jobId = null ) {
		return call_user_func_array(
			curryN(
				2,
				function ( $returnUrl, $jobId ) {
					$jobEditUrl = admin_url( 'admin.php?page='
						. WPML_TM_FOLDER
						. '/menu/translations-queue.php&job_id='
						. $jobId
						. '&return_url=' . urlencode( $returnUrl ) );

					return apply_filters( 'icl_job_edit_url', $jobEditUrl, $jobId );
				}
			),
			func_get_args()
		);
	}

	/**
	 * @param int    $postId
	 * @param string $elementType
	 * @param string $language
	 *
	 * @return callable|\stdClass|null
	 *
	 * @phpstan-template A1 of int|curried
	 * @phpstan-template A2 of string|curried
	 * @phpstan-template A3 of string|curried
	 * @phpstan-template P1 of int
	 * @phpstan-template P2 of string
	 * @phpstan-template P3 of string
	 * @phpstan-template R of \stdClass|null
	 *
	 * @phpstan-param ?A1 $postId
	 * @phpstan-param ?A2 $elementType
	 * @phpstan-param ?A3 $language
	 *
	 * @phpstan-return ($postId is P1
	 *  ? ($elementType is P2
	 *    ? ($language is P3
	 *      ? R
	 *      : callable(P3=):R)
	 *    : ($language is P3
	 *      ? callable(P2=):R
	 *      : callable(P2=,P3=):R)
	 *  )
	 *  : ($elementType is P2
	 *    ? ($language is P3
	 *      ? callable(P1=):R
	 *      : callable(P1=,P3=):R)
	 *    : ($language is P3
	 *      ? callable(P1=,P2=):R
	 *      : callable(P1=,P2=,P3=):R)
	 *  )
	 * )
	 */
	public static function getElementJob( $postId = null, $elementType = null, $language = null ) {
		return call_user_func_array(
			curryN(
				3,
				function ( $postId, $elementType, $language ) {
					global $sitepress;

					$trid = $sitepress->get_element_trid( $postId, $elementType );

					return self::getTridJob( $trid, $language );
				}
			),
			func_get_args()
		);
	}

	private static function updateTranslationStatusField( $jobId, $fieldName, $newValue, $fieldType = '%d' ) {
		global $wpdb;

		$newValueSqlString = null === $newValue ? 'NULL' : $fieldType;
		$unpreparedQuery = "
					UPDATE {$wpdb->prefix}icl_translation_status
						SET `{$fieldName}` = {$newValueSqlString}
						WHERE rid = (
						    SELECT rid FROM {$wpdb->prefix}icl_translate_job
						    WHERE job_id = %d
						)
					";

		if ( null === $newValue ) {
			// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
			$query = $wpdb->prepare( $unpreparedQuery, $jobId );
		} else {
			// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
			$query = $wpdb->prepare( $unpreparedQuery, $newValue, $jobId );
		}

		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
		$wpdb->query( $query );

		return $jobId;
	}

	private static function updateTranslateJobField( $jobId, $fieldName, $newValue ) {
		global $wpdb;

		$wpdb->update(
			$wpdb->prefix . 'icl_translate_job',
			[ $fieldName => $newValue ],
			[ 'job_id' => $jobId ]
		);

		return $jobId;
	}

	/**
	 * Returns object of the first found previous translation job if exists.
	 *
	 * @param $jobId
	 *
	 * @return object|null
	 */
	public static function getPreviousJob( $jobId ) {
		global $wpdb;

		$sql = "
			SELECT * FROM {$wpdb->prefix}icl_translate_job job
			WHERE job.job_id < %d AND job.rid = (
				SELECT rid FROM {$wpdb->prefix}icl_translate_job WHERE job_id = %d
			)			
			ORDER BY job.job_id DESC
		";

		return $wpdb->get_row( $wpdb->prepare( $sql, $jobId, $jobId ) );
	}
}

Jobs::init();
