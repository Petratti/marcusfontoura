<?php
/**
 * Header
 * 
 * @package Sintropika
 */
 ?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <!-- INSERIR GOOGLE FONT AQUI -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Funnel+Display:wght@300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <!-- JQUERY -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri(); ?>/dist/style.min.css?v=<?=THEME_VERSION?>">
        <script src="<?= get_template_directory_uri(); ?>/dist/app.min.js?v=<?=THEME_VERSION?>"></script>
        <script src="<?= get_template_directory_uri(); ?>/dist/menu.min.js?v=<?=THEME_VERSION?>"></script>
        <!-- <script src="<?= get_template_directory_uri(); ?>/assets/js/classes/Search.class.js?v=<?=THEME_VERSION?>"></script>
        <script src="<?= get_template_directory_uri(); ?>/dist/buscas.min.js?v=<?=THEME_VERSION?>"></script> -->
        <?php wp_head(); ?>
    </head>
    <body <?php body_class();?>>
        <?php include(locate_template('inc/components/loader.php'));?>

        <?php //include(locate_template('inc/components/menu-acessibilidade.php'));?>
        <?php include(locate_template('inc/components/menu-principal.php'));?>
        
        
        