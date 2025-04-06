<?php
/**
 * Funções do template
 *
 * @package Sintropika
 */

/**
 * Configurações de funções padrão do Wordpress
 */
require_once get_template_directory() . '/inc/functions/setup.php';

/**
 * Função para adicionar scripts e css
 */
require_once get_template_directory() . '/inc/functions/enqueue.php';

/**
 * Funções e classes do menu e do rodapé
 */
require_once get_template_directory() . '/inc/functions/menus.php';

/**
 * Custom post types
 */
require_once get_template_directory() . '/inc/functions/custom-post-types.php';

/**
 * Taxonomy
 */
require_once get_template_directory() . '/inc/functions/taxonomy.php';

/**
 * Plugins obrigatórios
 */
require_once get_template_directory() . '/inc/functions/plugins.php';

/**
 * Widgets sidebar
 */
require_once get_template_directory() . '/inc/functions/widget.php';

/**
 * Embed de vídeos - troca URL por ID
 */
require_once get_template_directory() . '/inc/functions/embed-to-id-youtube.php';

/**
 * Iframe - iframes responsivo Boostrap
 */
require_once get_template_directory() . '/inc/functions/iframe.php';

/**
 * Gutenberg Blocks
 */

 require_once get_template_directory(). '/inc/functions/gutenberg-blocks.php';

/**
 * Request ajax
 */

 require_once get_template_directory(). '/inc/functions/request-ajax.php';

 /**
 * Configurações do WPML
 */

//require_once get_template_directory(). '/inc/functions/wpml.php';

/**
 * Funções de busca por conteudos do site
 */
//require get_template_directory(). '/inc/functions/search.php';
?>