<?php
$menuFooterTipo = 'linha';
//$menuFooterTipo = 'coluna';
?>

<div class="-menu-footer">
    <div class="container">
        <div class="row justify-content-center">
            <!-- <div class="col-lg-6 -logo">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-footer.png" alt="Logotipo <?php bloginfo('name'); ?>">
            </div> -->
            <div class="col-lg-8 -colunas">
                <?php if (has_nav_menu('rodape_coluna_1')): ?>
                <div class="-coluna">
                    <!-- <h3>Mapa do site</h3> -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'rodape_coluna_1',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Menu_Link_Externo_Walker()
                    ));
                    ?>
                </div>
                <?php endif; ?>
                <?php if (has_nav_menu('rodape_coluna_2') && $menuFooterTipo=="coluna"): ?>
                <div class="-coluna">
                    <!-- <h3>Coluna 2</h3> -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'rodape_coluna_2',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Menu_Link_Externo_Walker()
                    ));
                    ?>
                </div>
                <?php endif; ?>
                <?php if (has_nav_menu('rodape_coluna_3') && $menuFooterTipo=="coluna"): ?>
                <div class="-coluna">
                    <!-- <h3>Coluna 3</h3> -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'rodape_coluna_3',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Menu_Link_Externo_Walker()
                    ));
                    ?>
                </div>
                <?php endif; ?>
                <?php if (has_nav_menu('rodape_coluna_4') && $menuFooterTipo=="coluna"): ?>
                <div class="-coluna">
                    <!-- <h3>Coluna 4</h3> -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'rodape_coluna_4',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Menu_Link_Externo_Walker()
                    ));
                    ?>
                </div>
                <?php endif; ?>
                <?php if (has_nav_menu('rodape_coluna_5') && $menuFooterTipo=="coluna"): ?>
                <div class="-coluna">
                    <!-- <h3>Coluna 5</h3> -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'rodape_coluna_5',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Menu_Link_Externo_Walker()
                    ));
                    ?>
                </div>
                <?php endif; ?>
                <?php if (has_nav_menu('rodape_coluna_6') && $menuFooterTipo=="coluna"): ?>
                <div class="-coluna">
                    <!-- <h3>Coluna 6</h3> -->
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'rodape_coluna_6',
                        'menu_class'     => '',
                        'container'      => false,
                        'walker'         => new Menu_Link_Externo_Walker()
                    ));
                    ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>