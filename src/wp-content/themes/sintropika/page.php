<?php
/**
 * Modelo de página padrão
 * 
 * @package Sintropika
 */
?>
<?php
get_header();
the_post();

$hero_class = "";

//pegar uld e alt da imagem destacada
$thumbnail_id = get_post_thumbnail_id();
if($thumbnail_id) {
    $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'full', true);
    $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
    $hero_class .= 'has-image ';
}


?>

<main id="main">

    <section id="hero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <header>
                        <span class="badge"><span class='divider-top d-md-none'></span><?=$tipos[0]->name?><span class='divider-right d-none d-md-flex'></span></span>
                        <h1><?= get_the_title(); ?></h1>
                    </header>
                </div>
            </div>
        </div>
    </section>

    <?php if($thumbnail_id) { ?>
    <section id="imagem-destaque">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="col-lg-12">
                        <img src="<?=$thumbnail_url[0]?>" alt="<?=$thumbnail_alt[0]?>" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>

    <section id="content">
        <section id="post">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="post-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

</main>
    


<?php
    get_footer();
?>