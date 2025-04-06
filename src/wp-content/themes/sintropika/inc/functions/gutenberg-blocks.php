<?php

add_theme_support( 'align-wide' );

// Limitar os blocos disponíveis no editor
function wpdocs_allowed_block_types( $allowed_blocks, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        return array(
            'core/image',
            'core/paragraph',
            'core/heading',
            'core/list',
            'core/list-item',
            'core/shortcode',
            'core/gallery',
            'core/heading',
            'core/quote',
            'core/embed',
            //'core/separator',
            'core/spacer',
            //'core/more',
            //'core/buttons',
            //'core/button',
            //'core/pullquote',
            'core/table',
            'core/preformatted',
            'core/code',
            'core/html',
            //'core/freeform',
            //'core/latest-posts',
            //'core/categories',
            //'core/cover',
            'core/columns',
            //'core/verse',
            'core/video',
            'core/audio',
            'core/block',
            'core/paragraph',
            'core-embed/twitter',
            'core-embed/youtube',
            //'core-embed/facebook',
            //'core-embed/instagram',
            //'core-embed/wordpress',
            'core/embeds/soundcloud',
            'core-embed/spotify',
            //'core-embed/flickr',
            'core-embed/vimeo',
            //'core-embed/animoto',
            //'core-embed/cloudup',
            //'core-embed/collegehumor',
            //'core-embed/dailymotion',
            //'core-embed/funnyordie',
            //'core-embed/hulu',
            //'core-embed/imgur',
            //'core-embed/issuu',
            //'core-embed/kickstarter',
            //'core-embed/meetup-com',
            //'core-embed/mixcloud',
            //'core-embed/photobucket',
            //'core-embed/polldaddy',
            //'core-embed/reddit',
            //'core-embed/reverbnation',
            //'core-embed/screencast',
            //'core-embed/scribd',
            //'core-embed/slideshare',
            //'core-embed/smugmug',
            //'core-embed/speaker',
            'core-embed/ted',
            //'core-embed/tumblr',
            //'core-embed/videopress',
            //'core-embed/wordpress-tv',
            'acf/botao-acao'
        );
    }
}
add_filter( 'allowed_block_types_all', 'wpdocs_allowed_block_types', 10, 2 );





add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {
    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // botão de ação
        acf_register_block_type(array(
            'name'              => 'botao-acao',
            'title'             => __('Botão de ação'),
            'description'       => __('Bloco de Botão de ação'),
            'render_template'   => 'inc/blocks/botao-acao.php',
            //'enqueue_style'     =>  get_template_directory_uri() .'/template-parts/blocks/bootstrap/css/bootstrap.min.css',
            'category'          => 'formatting',
            'icon'              => 'button',
            'keywords'          => array( 'botao-acao', 'box' ),
            'mode'              => 'edit',
            'category'          => 'custom-blocks',
        ));
    }
}



// Customização do bloco de galeria no frontend
add_filter( 'render_block', 'custom_gallery_block', 10, 2 );

function custom_gallery_block( $block_content, $block ) {
    if ( 'core/gallery' !== $block['blockName'] ) {
        return $block_content;
    }
    // get all images and captions
    $images = $block['innerBlocks'];
    
    //criar numero aleatorio de 1000000 a 9000000
    $random_number = rand(1000000, 9000000);
    $return = "";
    $return .= '<div id="carousel-'.$random_number.'" class="carousel slide carousel-fade carousel-single" data-bs-ride="carousel">';
    $return .= '<div class="carousel-indicators">';
    foreach ( $images as $index => $image ) {
        if($index==0){
            $active = 'active';
        }else {
            $active = '';
        }
        $return .= '<button type="button" data-bs-target="#carousel-'.$random_number.'" data-bs-slide-to="'.$index.'" class="'.$active.'" aria-current="true" aria-label="Slide '.$index.'">'.wp_get_attachment_image( $image['attrs']['id'], 'thumbnail' ).'</button>';
    }
    $return .= '</div>';
    $return .= '<div class="carousel-inner">';
    $i = 0;
    foreach ( $images as $image ) {
        $innerHTML = $image['innerHTML'];
        $dom = new DomDocument();
        @$dom->loadHTML($innerHTML);
        $captions = [];
        foreach($dom->getElementsByTagName('figcaption') as $caption) {
            $captions[] =  utf8_decode($caption->nodeValue);
        }
        //print_r($captions);

        $return .= '<div class="carousel-item';
        if ( 0 === $i ) {
            $return .= ' active';
        }
        $return .= '">';
        $return .= wp_get_attachment_image( $image['attrs']['id'], 'full' );
        if (@$captions[0]) {
            if ($captions[0] || !empty( wp_get_attachment_caption( $image['attrs']['id']) ) ) {
            $return .= '<div class="carousel-caption">';
            if($captions[0]):
                $return .= $captions[0];
            else:
                $return .= wp_get_attachment_caption( $image['attrs']['id']);
            endif;
            $return .= '</div>';
            }
        }
        $return .= '</div>';
        $i++;
    }
    $return .= '</div>';

    $return .= '<button class="carousel-control-prev" type="button" data-bs-target="#carousel-'.$random_number.'" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carousel-'.$random_number.'" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>';

    $return .= '</div>';

    return $return;
}