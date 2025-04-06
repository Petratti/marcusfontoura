<?php
/**
 * Hook Wordpress
 * Troca do iframe de vídeos
 *
 * @package Sintropika
 */

// add_filter('the_content', function($content) {
// 	return str_replace(array("<iframe", "</iframe>"), array('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item"', "</iframe></div>"), $content);
// });

add_filter('embed_oembed_html', function ($html, $url, $attr, $post_id) {
	if(strpos($html, 'youtube.com') !== false || strpos($html, 'youtu.be') !== false){
  		return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
	} else {
	 return $html;
	}
}, 10, 4);

add_filter('embed_oembed_html', function($code) {
  return str_replace('<iframe', '<iframe class="embed-responsive-item" ', $code);
});