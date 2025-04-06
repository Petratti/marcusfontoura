<?php
/**
 * Modelo de footer
 * 
 * @package Sintropika
 */
 ?>
    <?php
    wp_reset_query();
    ?>

    <?php //include(locate_template('inc/components/block-social-newsletter.php')); ?>
    
    <a href="#" class="btn icon-button" id="top"><i><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none"><path d="M10.9996 17.3889V4.94446M10.9996 4.94446L4.77734 11.1667M10.9996 4.94446L17.2218 11.1667" stroke="#7A3D01" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"/></svg></i></a>
    
    <footer id="footer">
        <?php include(locate_template('inc/components/menu-footer.php'));?>
        <?php //include(locate_template('inc/components/footer-outros.php'));?>
        <?php include(locate_template('inc/components/footer-termos.php'));?>
    </footer>

    <?php //include(locate_template('inc/components/modal-video.php'));?>




    <?php wp_footer(); ?>
    <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/assets/minjs/html5shiv.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/assets/minjs/html5shiv-printshiv.js"></script>
    <![endif]-->

    <!-- GREEN SOCK -->
    <!-- <script defer src="<?= get_template_directory_uri(); ?>/dist/gsap.min.js"></script>
    <script defer src="<?= get_template_directory_uri(); ?>/dist/ScrollTrigger.min.js"></script>
    <script defer src="<?= get_template_directory_uri(); ?>/dist/transitions.min.js?v=<?= THEME_VERSION ?>"></script> -->

    </body>
</html>