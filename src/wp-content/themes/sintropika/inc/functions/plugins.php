<?php
// remove update notice for forked plugins
function remove_update_notifications( $value ) {

	if ( isset( $value ) && is_object( $value ) ) {
		unset( $value->response[ 'advanced-custom-fields-pro\acf.php' ] );
		unset( $value->response[ 'hello.php' ] );
		unset( $value->response[ 'akismet/akismet.php' ] );
	}
 
	return $value;
 }
 add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );