<?php
/**
 * Template Sintropika configuração iniciais do template
 *
 * @package Sintropika
 */

$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version); //gets version written in your style.css


add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-excerpt' );


// Adiciona o link do feed no head.
add_theme_support( 'automatic-feed-links' );

// Add theme support for selective refresh for widgets.
add_theme_support( 'customize-selective-refresh-widgets' );

/*
* Switch default core markup for search form, comment form, and comments
* to output valid HTML5.
*/
add_theme_support(
	'html5',
	array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	)
);

add_theme_support( 'responsive-embeds' );
add_theme_support( 'wp-block-styles' );
// Fix embeds inside Gutenberg saved blocks.
// Move priority of `do_blocks` to be earlier than `\WP_Embed::run_shortcode`.
add_action( 'init', function() {
	global $wp_embed;

	if (
		has_filter( 'the_content', 'do_blocks' ) === 9 &&
		has_filter( 'the_content', [ $wp_embed, 'run_shortcode' ] ) === 8
	) {
		remove_filter( 'the_content', 'do_blocks', 9 );
		add_filter( 'the_content', 'do_blocks', 7 );
	}
} );



if ( ! function_exists( 'custom_excerpt_more' ) ) {
	/**
	 * Removes the ... from the excerpt read more link
	 *
	 * @param string $more The excerpt.
	 *
	 * @return string
	 */
	function custom_excerpt_more( $more ) {
		return '...';
	}
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

if ( ! function_exists( 'all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function all_excerpts_get_more_link( $post_excerpt ) {

		return $post_excerpt .'...';
	}
}
//add_filter( 'wp_trim_excerpt', 'all_excerpts_get_more_link' );


/**
 * Verifica se é uma página mobile
 * 
 * Adiciona a class 'ismobile' na tag <body>
 */
if ( wp_is_mobile() ) {
	add_filter( 'body_class', function ( $classes ) {
		$classes[] = 'ismobile';
		return $classes;
	} );
}

//remover margem adicional do admin bar
/* add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
} */


$arrContextOptions=array(
	"ssl"=>array(
		"verify_peer"=>false,
		"verify_peer_name"=>false,
	),
);


//enqueue admin styles with version
function custom_admin_style() {
	wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/assets/css/admin.css', array(), THEME_VERSION);
}
add_action('admin_enqueue_scripts', 'custom_admin_style');
