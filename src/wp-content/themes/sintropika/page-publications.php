<?php 
    /**
     * Template Name: Publications
     */
?>
<?php 
    get_header();
    the_post();

    //pegar imagem destacada
    $imagemDestacada = get_the_post_thumbnail_url();
    //pegar alt da imagem destacada
    $altImagemDestacada = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

    $aba1Titulo = get_field('aba_1_titulo');
    $aba2Titulo = get_field('aba_2_titulo');
    $blocos1 = get_field('blocos');
    $blocos2 = get_field('blocos_2');
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
        </div>
    </section>

    <div class="container">
        <nav class="nav nav-pills nav-justified" id="myTab" role="tablist">
            <a class="nav-link active" href="#" id="tab01" data-bs-toggle="tab" data-bs-target="#content01" type="button" role="tab" aria-controls="content01" aria-selected="true"><?=$aba1Titulo?></a>
            <a class="nav-link" href="#" id="tab02" data-bs-toggle="tab" data-bs-target="#content02" type="button" role="tab" aria-controls="content02" aria-selected="false"><?=$aba2Titulo?></a>
        </nav>
    </div>

    <section id="content" class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="content01" role="tabpanel" aria-labelledby="tab01">
        <?php if ($blocos1 && count($blocos1)): ?>
            <?php $blocos = $blocos1;?>
            <?php include('inc/components/block-conteudo.php'); ?>
        <?php endif; ?>
        </div>

        <div class="tab-pane fade" id="content02" role="tabpanel" aria-labelledby="tab02">
        <?php if ($blocos2 && count($blocos2)): ?>
            <?php $blocos = $blocos2;?>
            <?php include('inc/components/block-conteudo.php'); ?>
        <?php endif; ?>
        </div>
        
    </section>

</main>
    


<?php
    get_footer();
?>