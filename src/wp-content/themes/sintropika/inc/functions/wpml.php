<?php
// WPML CUSTOM SWITCHER DESKTOP
function custom_language_switcher($screen) {
    $languages = apply_filters( 'wpml_active_languages', NULL, array( 'skip_missing' => 0 ) );
    //$languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
 
    if( !empty( $languages ) ) {

        foreach( $languages as $language ){
            $native_name = $language['active'] ? strtoupper( $language['native_name'] ) : $language['native_name'];
            $tag = $language['tag'];
            if($tag == "pt-br"){
                $tag = "pt";
            }
            if( $language['active'] ) :
                $active = "active";
            else :
                $active = "";
            endif;
            if($screen == "desktop"):
                echo '<li>';
                echo '<a href="' . esc_url( $language['url'] ) . '" class="btn button-drop '.$active.'">';
                echo esc_html( strtoupper($tag) );
                echo '</a>';
                echo '</li>';
            else:
                echo '<li>';
                echo '<a href="' . esc_url( $language['url'] ) . '" class="btn button-drop '.$active.'">';
                echo esc_html( strtoupper($tag) );
                echo '</a>';
                echo '</li>';
            endif;
        }
    }
}

?>