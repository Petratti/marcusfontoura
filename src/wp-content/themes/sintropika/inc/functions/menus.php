<?php
/*
    Registro de menus
*/

function sintropika_registra_menus() {
    register_nav_menus(array(
        'menu_principal' => __('Menu Principal', 'sintropika'),
        //'submenu_temas' => __('Submenu Temas', 'sintropika'),
        'rodape_coluna_1' => __('Rodapé - Coluna 1', 'sintropika'),
        'rodape_coluna_2' => __('Rodapé - Coluna 2', 'sintropika'),
        'rodape_coluna_3' => __('Rodapé - Coluna 3', 'sintropika'),
        'rodape_coluna_4' => __('Rodapé - Coluna 4', 'sintropika'),
        'rodape_coluna_5' => __('Rodapé - Coluna 5', 'sintropika'),
        'rodape_coluna_6' => __('Rodapé - Coluna 6', 'sintropika'),
        'rodape_outros' => __('Rodapé - Outros', 'sintropika'),
        'rodape_politicas' => __('Rodapé - Políticas', 'sintropika'),
    ));
}
add_action('after_setup_theme', 'sintropika_registra_menus');


/*
    Walker para montar o menu principal
*/

class Bootstrap_NavWalker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

        if ($args->walker->has_children) {
            $class_names .= ' dropdown';
        }

        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names .'>';

        $atts = array();
        $atts['title']  = !empty($item->title) ? $item->title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        if ($args->walker->has_children) {
            $atts['class'] = 'nav-link dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
        } else {
            $atts['class'] = 'nav-link';
        }

        //se for um link externo
        $is_external = ($item->target === '_blank'); // Verifica se o link tem target="_blank"

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes;
        if ($is_external) {
            $item_output .= ' rel="noopener noreferrer"';
        }
        $item_output .= '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        if ($is_external) {
            $item_output .= ' <i><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 20 20" fill="none"><path d="M16 11.1074V17.1074C16 17.6379 15.7893 18.1466 15.4142 18.5216C15.0391 18.8967 14.5304 19.1074 14 19.1074H3C2.46957 19.1074 1.96086 18.8967 1.58579 18.5216C1.21071 18.1466 1 17.6379 1 17.1074V6.10742C1 5.57699 1.21071 5.06828 1.58579 4.69321C1.96086 4.31814 2.46957 4.10742 3 4.10742H9M13 1.10742H19M19 1.10742V7.10742M19 1.10742L8 12.1074" stroke="#042F35" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="bevel"/></svg></i>'; // Ícone de link externo
        }
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}


/*
    Walker para incluir ícones em links externos
*/

class Menu_Link_Externo_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $url = $item->url;
        //$is_external = (strpos($url, home_url()) === false && strpos($url, '#') !== 0);
        $is_external = ($item->target === '_blank'); // Verifica se o link tem target="_blank"

        $output .= '<li>';

        $output .= '<a href="' . esc_url($url) . '"';
        if ($is_external) {
            $output .= ' target="_blank" rel="noopener noreferrer"';
        }
        $output .= '>';
        $output .= esc_html($item->title);
        
        if ($is_external) {
            $output .= ' <i><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 20 20" fill="none"><path d="M16 11.1074V17.1074C16 17.6379 15.7893 18.1466 15.4142 18.5216C15.0391 18.8967 14.5304 19.1074 14 19.1074H3C2.46957 19.1074 1.96086 18.8967 1.58579 18.5216C1.21071 18.1466 1 17.6379 1 17.1074V6.10742C1 5.57699 1.21071 5.06828 1.58579 4.69321C1.96086 4.31814 2.46957 4.10742 3 4.10742H9M13 1.10742H19M19 1.10742V7.10742M19 1.10742L8 12.1074" stroke="#042F35" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="bevel"/></svg></i>'; // Ícone de link externo
        }

        $output .= '</a></li>';
    }
}

?>