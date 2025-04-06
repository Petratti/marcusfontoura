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

    $mostrarDestaques = get_field('mostrar_destaques');
    $blocosDestaques = get_field('blocos_destaques');
?>


<main id="main">

    <!-- <section id="hero" style="background-image: url(<?= $imagemDestacada; ?>);"> -->
    <section id="hero">
        <!-- <img src="<?= $imagemDestacada; ?>" alt="..." class="-left-right-bg" /> -->
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <header class="-line-top">
                        <h1 class="visually-hidden sr-only">Página Inicial</h1>
                        <?php the_content(); ?>
                    </header>
                </div>
            </div>
        </div>
    </section>

    <section id="content">
        <?php if($mostrarDestaques):?>
            <section id="destaques">
                <div class="container -content">
                    <?php
                    $tipoDestaque = '';
                    if($blocosDestaques):
                        include(locate_template('inc/components/destaques-blocos.php'));
                    else:
                        $postType = array("campanha", "informe");
                        include(locate_template('inc/components/destaques-blocos-padrao.php'));
                    endif;
                    ?>
                </div>
            </section>
        <?php endif;?>
    
        <section id="book">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <header>
                            <h2>My book, A Platform Mindset: Building a Culture of collaboration is now available</h2>
                        </header>
                        <p>The book was orginally published in Portuguese with the title Tecnologia Intencional. It provides a practical and thoughtful perspective on technology management, drawing from the author's extensive twenty-year career at leading companies like IBM, Yahoo, Google, and Microsoft. More recently, he has played a crucial role in driving technological transformation at the Brazilian fintech, Stone.</p>
                        <p>All author proceeds from English version will be donated to organizations supported by Microsoft Philanthropies. The proceeds from the Portuguese version are donated to Fundacao Estudar.</p>
                    </div>
                </div>
            </div>
        </section>

    </section>



</main>
    


<?php
    get_footer();
?>