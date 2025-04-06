<?php
$headerSticky = 0;
$headerLanguageSwitcher = 0;
$headerSearch = 0;
$headerFluid = 0;

if($headerSticky == 1){
    $headerClass = "sticky-top";
}else{
    $headerClass = "";
}

$headerContainerClass = "";
if($headerFluid == 0){
    $headerContainerClass .= " container-fluid";
}else{
    $headerContainerClass .= " container";
}
//$headerContainerClass = "px-0";
?>

<header id="header" class="<?=$headerClass?>">
    <nav class="navbar navbar-expand-lg">
        <div class="<?=$headerContainerClass?>" style="display: contents;">
            <a class="navbar-brand" href="<?php echo site_url();?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" class="navbar__logo" alt="Logotipo <?php bloginfo('name'); ?>">
            </a>
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <div class="left"></div>
                <div class="center">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'menu_principal',
                        'container'      => false,
                        'menu_class'     => 'navbar-nav',
                        'fallback_cb'    => '__return_false',
                        'depth'          => 2,
                        'walker'         => new Bootstrap_NavWalker()
                    ));
                    ?>
                </div>
                <div class="right">
                    <div class="buttons">
                        <a href="https://www.linkedin.com/company/inesplorato/" target="_blank" class="btn -social"><i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><g clip-path="url(#clip0_2824_154)"><path d="M22.2283 0H1.77167C1.30179 0 0.851161 0.186657 0.518909 0.518909C0.186657 0.851161 0 1.30179 0 1.77167V22.2283C0 22.6982 0.186657 23.1488 0.518909 23.4811C0.851161 23.8133 1.30179 24 1.77167 24H22.2283C22.6982 24 23.1488 23.8133 23.4811 23.4811C23.8133 23.1488 24 22.6982 24 22.2283V1.77167C24 1.30179 23.8133 0.851161 23.4811 0.518909C23.1488 0.186657 22.6982 0 22.2283 0ZM7.15333 20.445H3.545V8.98333H7.15333V20.445ZM5.34667 7.395C4.93736 7.3927 4.53792 7.2692 4.19873 7.04009C3.85955 6.81098 3.59584 6.48653 3.44088 6.10769C3.28591 5.72885 3.24665 5.31259 3.32803 4.91145C3.40941 4.51032 3.6078 4.14228 3.89816 3.85378C4.18851 3.56529 4.55782 3.36927 4.95947 3.29046C5.36112 3.21165 5.77711 3.25359 6.15495 3.41099C6.53279 3.56838 6.85554 3.83417 7.08247 4.17481C7.30939 4.51546 7.43032 4.91569 7.43 5.325C7.43386 5.59903 7.38251 5.87104 7.27901 6.1248C7.17551 6.37857 7.02198 6.6089 6.82757 6.80207C6.63316 6.99523 6.40185 7.14728 6.14742 7.24915C5.893 7.35102 5.62067 7.40062 5.34667 7.395ZM20.4533 20.455H16.8467V14.1933C16.8467 12.3467 16.0617 11.7767 15.0483 11.7767C13.9783 11.7767 12.9283 12.5833 12.9283 14.24V20.455H9.32V8.99167H12.79V10.58H12.8367C13.185 9.875 14.405 8.67 16.2667 8.67C18.28 8.67 20.455 9.865 20.455 13.365L20.4533 20.455Z" fill="#000066"/></g><defs><clipPath id="clip0_2824_154"><rect width="24" height="24" fill="white"/></clipPath></defs></svg></i></a>
                    </div>
                    <?php if($headerLanguageSwitcher == 1): ?>
                        <ul class="navbar-languages list-unstyled">
                            <?php custom_language_switcher("desktop");?>
                            <li><a href="#" class="active">PT</a></li>
                            <li><a href="#">EN</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>