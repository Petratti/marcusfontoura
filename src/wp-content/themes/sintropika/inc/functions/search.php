<?php

//Classe de busca
require_once get_template_directory() . '/inc/classes/search.class.php';
//BUSCA POSTS

add_action('wp_ajax_nopriv_search_conteudos', 'search_conteudos');
add_action('wp_ajax_search_conteudos', 'search_conteudos');

function search_conteudos() {
    
    //Parametros de busca
    $search = $_POST['search'];
    $postTypes = ['post'];
    $filtros = $_POST['filtros'] ?? ['paged' => 1, 'posts_per_page' => 9];
    $taxonomy = $_POST['taxonomy'] ?? [];
    $orderBy = $_POST['ob'];
    $livre = 'true';
    $paged = $filtros['paged'] ?? 1;
    $posts_per_page = $filtros['posts_per_page'] ?? 9;

    if($orderBy == 'date'){
        $order = 'DESC';
    }else{
        $order = 'ASC';
    }

    // Instancia a classe SEARCH
    if (class_exists('SEARCH')) {
        $search_instance = new SEARCH($postTypes, $filtros, $taxonomy, $orderBy, $paged, $posts_per_page, $search);
        $search_instance->search();
        $html_content = $search_instance->get_html_content();
        $total = $search_instance->get_total();
        $numero_de_resultado = $search_instance->get_numero_de_resultados();
        $numero_de_paginas = $search_instance->get_numero_de_paginas();
        $carregar_mais = $search_instance->get_carregar_mais();
        $args = $search_instance->get_args();

        $retorno = array();
        $retorno['search'] = $search;
        $retorno['total'] = $total;
        $retorno['html'] = $html_content;
        $retorno['numero_resultados'] = $numero_de_resultado;
        $retorno['carregar_mais'] = $carregar_mais;
        $retorno['paged'] = $paged + 1;
        $retorno['filtros'] = $filtros;
        $retorno['origem'] = 'posts';
        $retorno['numero_de_paginas'] = $numero_de_paginas;
        $retorno['livre'] = 'true';
        $retorno['args'] = $args;



        echo json_encode($retorno);
        wp_die();

    } else {
        wp_send_json_error(['message' => 'Classe SEARCH não encontrada']);
        wp_die();
    }

}


//BUSCA GERAL

add_action('wp_ajax_nopriv_search', 'search');
add_action('wp_ajax_search', 'search');

function search() {
    
    /* if ( ! wp_verify_nonce( $_POST['nonce'], 'search_nonce' ) ) {
        wp_send_json_error( 'Nonce inválido' );
        wp_die();
        echo json_encode('Nonce inválido');
    } */

    //Parametros de busca
    $search = $_POST['search'];
    $orderBy = $_POST['orderby'];
    $filtros = $_POST['filtros'];
    $postTypes = ['post'];

    $paged = $filtros['paged'];
    $posts_per_page = $filtros['posts_per_page'];

    if($orderBy == 'date'){
        $order = 'DESC';
    }else{
        $order = 'ASC';
    }

    // Instancia a classe SEARCH
    if (class_exists('SEARCH')) {
        $search_instance = new SEARCH($postTypes, $filtros, [], $orderBy, $paged, $posts_per_page, $search,'busca');
        $search_instance->search();
        $html_content = $search_instance->get_html_content();
        $total = $search_instance->get_total();
        $numero_de_resultado = $search_instance->get_numero_de_resultados();
        $numero_de_paginas = $search_instance->get_numero_de_paginas();
        $carregar_mais = $search_instance->get_carregar_mais();
        $args = $search_instance->get_args();

        $retorno = array();
        $retorno['search'] = $search;
        $retorno['total'] = $total;
        $retorno['html'] = $html_content;
        $retorno['numero_resultados'] = $numero_de_resultado;
        $retorno['carregar_mais'] = $carregar_mais;
        $retorno['paged'] = $paged + 1;
        $retorno['filtros'] = $filtros;
        $retorno['origem'] = 'search';
        $retorno['args'] = $args;
        $retorno['numero_de_paginas'] = $numero_de_paginas;

        echo json_encode($retorno);
        wp_die();

    } else {
        wp_send_json_error(['message' => 'Classe SEARCH não encontrada']);
        wp_die();
    }
}
