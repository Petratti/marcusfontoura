<?php 
    /**
     * Template Name: Home
     */
?>
<?php 
    get_header();
    the_post();

    //pegar imagem destacada
    $imagemDestacada = get_the_post_thumbnail_url();
    //pegar alt da imagem destacada
    $altImagemDestacada = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

    $books = get_field('books');
    $publications = get_field('publications');
    $platform = get_field('platform');
    $resume = get_field('resume');
?>


<main id="main">

    <h1 class="visually-hidden sr-only">Marcus Fontoura</h1>

    <section id="hero">
        <header>
            <?php the_content()?>
        </header>
        <div class="-img">
            <img src="<?php echo $imagemDestacada; ?>" alt="<?php echo $altImagemDestacada; ?>" class="img-fluid" />
        </div>
        <a href="#content" class="btn button-icon-alternative"><i><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M8 12L16 20L24 12" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg></i></a>
    </section>

    <section id="content">

        <section id="book">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="stroke-line">
                            <div class="square" style="background:#ECCD02"></div>
                            <div class="line"></div>
                        </div>
                        <header>
                            <h2><?=$books['titulo']?></h2>
                        </header>
                        <div class="columns">
                            <div class="left d-none d-lg-flex">
                                <div class="-img d-none d-lg-flex">
                                    <img src="<?=$books['imagem']['url']?>" alt="<?=$books['imagem']['alt']?>" class="img-fluid" />
                                </div>
                            </div>
                            <div class="right">
                                <?=$books['texto']?>
                                <div class="-img d-lg-none">
                                    <img src="<?=$books['imagem']['url']?>" alt="<?=$books['imagem']['alt']?>" class="img-fluid" />
                                </div>
                                <a href="<?=$books['botao']['url']?>" class="btn button-cta-alternative"><?=$books['botao']['title']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="resume">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="stroke-line">
                            <div class="square" style="background:#ECCD02"></div>
                            <div class="line"></div>
                        </div>
                        <div class="columns">
                            <div class="left">
                                <h2><?=$resume['titulo']?></h2>
                                <?=$resume['texto']?>
                                <a href="<?=$resume['botao']['url']?>" class="btn button-cta-alternative d-none d-lg-flex"><?=$resume['botao']['title']?></a>
                            </div>
                            <div class="right">
                                <?=$resume['texto_2']?>
                                <a href="<?=$resume['botao']['url']?>" class="btn button-cta-alternative d-lg-none"><?=$resume['botao']['title']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="publications">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="stroke-line">
                            <div class="square" style="background:#ECCD02"></div>
                            <div class="line"></div>
                        </div>
                        <div class="columns">
                            <div class="left">
                                <h2><?=$publications['titulo']?></h2>
                                <?=$publications['texto']?>
                                <a href="<?=$publications['botao']['url']?>" class="btn button-cta-alternative d-none d-lg-flex"><?=$publications['botao']['title']?></a>
                            </div>
                            <div class="right">
                                <?=$publications['texto_2']?>
                                <a href="<?=$publications['botao']['url']?>" class="btn button-cta-alternative d-lg-none"><?=$publications['botao']['title']?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="platform">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="logo">
                            <img src="<?=$platform['imagem']['url']?>" alt="<?=$platform['imagem']['alt']?>" class="img-fluid" />
                        </div>
                        <div class="columns">
                            <div class="left">
                                <h2><?=$platform['titulo']?></h2>
                                <a href="<?=$platform['botao']['url']?>" class="btn button-cta-alternative d-none d-lg-flex"><?=$platform['botao']['title']?></a>
                            </div>
                            <div class="right">
                                <?=$platform['texto']?>
                                <a href="<?=$platform['botao']['url']?>" class="btn button-cta-alternative d-lg-none"><?=$platform['botao']['title']?></a>
                            </div>
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