<?php 
    /**
     * Template Name: Resume
     */
?>
<?php 
    get_header();
    the_post();

    //pegar imagem destacada
    $imagemDestacada = get_the_post_thumbnail_url();
    //pegar alt da imagem destacada
    $altImagemDestacada = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

    $introducao = get_field('introducao');
    $blocos = get_field('blocos');
    $cookieMonster = get_field('cookie_monster');
?>

<main id="main">

    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <header>
                        <h1 class="-line-top"><?= get_the_title(); ?></h1>
                    </header>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="columns">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="-img">
                        <img src="<?php echo $imagemDestacada; ?>" alt="<?php echo $altImagemDestacada; ?>" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="content">

        <section id="intro">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <?=$introducao; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php if ($blocos && count($blocos)): ?>
            <?php include_once('inc/components/block-conteudo.php'); ?>
        <?php endif; ?>

        <section id="cookie-monster">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="columns">
                            <div class="left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="117" height="60" viewBox="0 0 117 60" fill="none">
                                <circle cx="29.25" cy="30" r="29.25" fill="white"/>
                                <ellipse cx="29.25" cy="42.5356" rx="16.1173" ry="16.7143" fill="#180A00"/>
                                <circle cx="87.75" cy="30" r="29.25" fill="white"/>
                                <ellipse cx="87.75" cy="42.5356" rx="16.1173" ry="16.7143" fill="#180A00"/>
                                </svg>
                            </div>
                            <div class="right">
                                <h2><?=$cookieMonster['titulo']?></h2>
                                <p><?=$cookieMonster['texto']?></p>
                            </div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalDefault" class="stretched-link" data-titulo="<?=$cookieMonster['titulo']?>" data-imagem="<?=$cookieMonster['imagem']['url']?>" ></a>
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