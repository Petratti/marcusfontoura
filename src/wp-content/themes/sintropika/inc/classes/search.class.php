<?php

class SEARCH {
    // Atributos privados
    private $post_types;
    private $filters;
    private $taxonomy;
    private $order_by;
    private $order;
    private $paged;
    private $posts_per_page;
    private $search;
    private $args;
    private $livre;
    private $tipo;
    private $html_content;
    private $total;
    private $numero_de_resultados;
    private $numero_de_paginas;
    private $carregar_mais;

    // Construtor
    public function __construct($post_types, $filters = [], $taxonomy = [], $order_by = 'date', $paged = 1, $posts_per_page = 9, $search = '', $tipo = '') {
        $this->set_post_types($post_types);
        $this->set_filters($filters);
        $this->set_taxonomy($taxonomy);
        $this->set_order_by($order_by);
        $this->set_order($order_by);
        $this->set_paged($paged);
        $this->set_posts_per_page($posts_per_page);
        $this->set_search($search);
        $this->set_args();
        $this->set_tipo($tipo);
    }

    // Setters privados
    private function set_post_types($post_types) {
        $this->post_types = $post_types;
    }

    private function set_filters($filters) {
        $this->filters = $filters;
    }

    private function set_taxonomy($taxonomy) {
        $this->taxonomy = $taxonomy;
    }

    private function set_order_by($order_by) {
        $this->order_by = $order_by;
    }

    private function set_order($order_by) {
        $this->order = ($order_by === 'date') ? 'DESC' : 'ASC';
    }

    private function set_paged($paged) {
        $this->paged = $paged ?? 1;
    }

    private function set_posts_per_page($posts_per_page) {
        $this->posts_per_page = $posts_per_page ?? 9;
    }

    private function set_search($search) {
        $this->search = $search;
    }

    private function set_livre($livre) {
        $this->livre = $livre;
    }

    private function set_tipo($tipo) {
        $this->tipo = $tipo;
    }

    private function set_total($total) {
        $this->total = $total;
    }

    private function set_numero_de_resultados($numero_de_resultados) {
        $this->numero_de_resultados = $numero_de_resultados;
    }

    private function set_numero_de_paginas($numero_de_paginas) {
        $this->numero_de_paginas = $numero_de_paginas;
    }

    private function set_args() {
        $args = [
            'post_type'      => $this->post_types,
            'post_status'    => 'publish',
            'posts_per_page' => $this->posts_per_page,
            'paged'          => $this->paged,
            'orderby'        => $this->order_by,
            'order'          => $this->order
        ];

        // Se houver taxonomias, adiciona ao WP_Query
        if (!empty($this->taxonomy)) {
            $this->livre = 'false';
            $args['tax_query'] = ['relation' => 'AND'];
            foreach ($this->taxonomy as $taxonomy => $terms) {
                if (!empty($terms)) {
                    $args['tax_query'][] = [
                        'taxonomy' => $taxonomy,
                        'field'    => 'slug',
                        'terms'    => (array) $terms,
                    ];
                }
            }
        }

        if (!empty($this->search)) {
            $this->livre = 'false';
            $args['s'] = $this->get_search();
        }

        $this->args = $args;
    }

    private function set_html_content($html_content) {
        $this->html_content = $html_content;
    }

    private function set_carregar_mais() {
        $this->carregar_mais = ($this->paged < $this->numero_de_paginas) ? true : false;
    }


    // Método público para pegar os resultados da busca
    // o chapéu deve ser customizado a cada projeto
    public function search($taxonomiaPrincipal = 'category', $taxonomiaPrincipalPrimaria = '_yoast_wpseo_primary_category', $cta = '') {
        $this->set_args();
        $query = new WP_Query($this->args);
        $html_content = '';
        $i = 0;

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $categoriasArray = array();
                $categoriaPrimaria = get_post_meta(get_the_ID(), $taxonomiaPrincipalPrimaria, true );
                $categorias = get_the_terms(get_the_ID(), $taxonomiaPrincipal);
                if($categorias) {
                    foreach($categorias as $categoria) {
                        if($categoria->term_id == $categoriaPrimaria) {
                            //insert at the beginning
                            array_unshift($categoriasArray, $categoria->name);
                        } else {
                            $categoriasArray[] = $categoria->name;
                        }
                        //se não tiver parent
                        if($categoria->parent == 0) {
                            if(!$corTema) {
                                $corTema = corTema($categoria->slug);
                            }
                        }
                    }
                }
                $imagem = get_the_post_thumbnail_url(get_the_ID(), 'medium' );
                $imagemOk = array();
                if($imagem):
                    $imagemOk['url'] = $imagem;
                    $imagemOk['alt'] = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
                else:
                    $imagemOk['url'] = '';
                    $imagemOk['alt'] = '';
                endif;
                $data = get_the_date('d/m/Y');
                if($categoriasArray[0]){
                    $chapeu = $categoriasArray[0];
                } else {
                    $chapeu = "";
                }
                $titulo = get_the_title();
                $resumo = get_the_excerpt();
                $cta  = 'Acessar';
                $permalink = get_the_permalink();
                $proporcao_da_thumb = get_field('proporcao_da_thumb', get_the_ID());
                if($this->tipo == 'busca'){
                    $html_content .= '<div class="col-lg-12 card-content-js">';
                } else {
                    $html_content .= '<div class="col-lg-4 col-md-6 card-content-js">';
                }
                    ob_start();
                    if($this->tipo == 'busca'){
                        $card_template = locate_template('inc/components/card-horizontal.php');
                    } else {
                        $card_template = locate_template('inc/components/card.php');
                    }
                    if (!$card_template) {
                        $html_content .= '<p>Card template não encontrado</p>';
                    }else{
                        include($card_template);
                    }
                    $card = ob_get_clean();
                    $html_content .= $card;
                $html_content .= '</div>';
                $i++;
            }
            
        }else{
            $html_content = '';
        }

        if($query->max_num_pages > $this->paged){
           
            ob_start();
            $html_content .= '<div class="col-lg-4 after-placeholder-card-js d-none">';
                $card_placeholder_template = locate_template('inc/components/card-placeholder.php');
                if (!$card_placeholder_template) {
                    $html_content .= '<p>Card placeholder template não encontrado</p>';
                }else{
                    include($card_placeholder_template);
                }
            $html_content .= ob_get_clean();
            $html_content .= '</div>';
            ob_start();
            $html_content .= '<div class="col-lg-4 after-placeholder-card-js d-none">';
                $card_placeholder_template = locate_template('inc/components/card-placeholder.php');
                if (!$card_placeholder_template) {
                    $html_content .= '<p>Card placeholder template não encontrado</p>';
                }else{
                    include($card_placeholder_template);
                }
            $html_content .= ob_get_clean();
            $html_content .= '</div>';
            ob_start();
            $html_content .= '<div class="col-lg-4 after-placeholder-card-js d-none">';
                $card_placeholder_template = locate_template('inc/components/card-placeholder.php');
                if (!$card_placeholder_template) {
                    $html_content .= '<p>Card placeholder template não encontrado</p>';
                }else{
                    include($card_placeholder_template);
                }
            $html_content .= ob_get_clean();
            $html_content .= '</div>';
        }

        $this->set_html_content($html_content);
        $this->set_total($query->found_posts);
        $this->set_numero_de_resultados($query->post_count);
        $this->set_numero_de_paginas($query->max_num_pages);
        $this->set_carregar_mais();

    }

    // Método público para pegar o total de resultados
    public function get_total() {
        return $this->total;
    }

    // Método público para pegar o total de resultados
    public function get_numero_de_resultados() {
        return $this->numero_de_resultados;
    }

    // Método público para pegar o total de páginas
    public function get_numero_de_paginas() {
        return $this->numero_de_paginas;
    }


    // Método público para pegar o HTML dos resultados
    public function get_html_content() {
        return $this->html_content;
    }

    public function get_carregar_mais() {
        return $this->carregar_mais;
    }

    public function get_search() {
        return $this->search;
    }

    public function get_args() {
        return $this->args;
    }


    

}

