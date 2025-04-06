<?php
    /**
 * botao-acao Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
    $tipo = get_field('tipo');
    $titulo = get_field('titulo');
    $texto_botao = get_field('texto_botao');
    $link = get_field('link');
    $nova_aba = get_field('nova_aba');
    $icone = "";
    if($tipo == 'link' && !$nova_aba){
        $icone = '<i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M12 5.55176V19.5518M5 12.5518H19" stroke="#830071" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/></svg></i>';
    }
    if($tipo == 'link' && $nova_aba){
        $icone = '<i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M18 13.7441V19.7441C18 20.2746 17.7893 20.7833 17.4142 21.1584C17.0391 21.5334 16.5304 21.7441 16 21.7441H5C4.46957 21.7441 3.96086 21.5334 3.58579 21.1584C3.21071 20.7833 3 20.2746 3 19.7441V8.74414C3 8.21371 3.21071 7.705 3.58579 7.32993C3.96086 6.95485 4.46957 6.74414 5 6.74414H11M15 3.74414H21M21 3.74414V9.74414M21 3.74414L10 14.7441" stroke="#830071" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/></svg></i>';
    }
    if($tipo == 'download'){
        $icone = '<i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none"><path d="M18 13.7441V19.7441C18 20.2746 17.7893 20.7833 17.4142 21.1584C17.0391 21.5334 16.5304 21.7441 16 21.7441H5C4.46957 21.7441 3.96086 21.5334 3.58579 21.1584C3.21071 20.7833 3 20.2746 3 19.7441V8.74414C3 8.21371 3.21071 7.705 3.58579 7.32993C3.96086 6.95485 4.46957 6.74414 5 6.74414H11M15 3.74414H21M21 3.74414V9.74414M21 3.74414L10 14.7441" stroke="#830071" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/></svg></i>';
    }
    
?>

<div class="-buttons">
    <a href="<?=$link?>" <?php if($tipo == 'download' || ($tipo == 'link' && $nova_aba)):?>target="_blank"<?php endif;?> class="btn button-icon"><?=$icone?><?=$texto_botao?></a>
</div>