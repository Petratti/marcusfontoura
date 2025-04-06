<?php


add_action( 'wp_enqueue_scripts', 'secure_enqueue_script' );
function secure_enqueue_script() {
  wp_register_script( 'secure-ajax-access', esc_url( add_query_arg( array( 'js_global' => 1 ), site_url() ) ) );
  wp_enqueue_script( 'secure-ajax-access' );
}

add_action( 'template_redirect', 'javascript_variables' );
function javascript_variables() {
  if ( !isset( $_GET[ 'js_global' ] ) ) return;

  //Cria os nonces que serão utilizados; 
  //$nonce_modelo = wp_create_nonce('nonce_modelo');
  
  //Variaveis que serão passados com o nonce
  $variaveis_javascript = array(
    //'nonce_modelo'     => $nonce_modelo,
    'xhr_url'                    => admin_url('admin-ajax.php'),
    'xhr_url_base'               => get_template_directory_uri() 
  );

  $new_array = array();
  foreach( $variaveis_javascript as $var => $value ) $new_array[] = esc_js( $var ) . " : '" . esc_js( $value ) . "'";

  header("Content-type: application/x-javascript");
  printf('var %s = {%s};', 'js_global', implode( ',', $new_array ) );
  exit;
}