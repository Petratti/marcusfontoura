<?php 
    /**
     * Template Name: Books
     */
?>
<?php 
    get_header();
    the_post();

    //pegar imagem destacada
    $imagemDestacada = get_the_post_thumbnail_url();
    //pegar alt da imagem destacada
    $altImagemDestacada = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);

    $botoesHero = get_field('botoes_hero');
    $introducao = get_field('introducao');
    $blocoDepoimentos = get_field('depoimentos');
    $livros = get_field('livros');
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
                        <div class="buttons">
                            <a href="<?=$botoesHero['botao_1']['url']?>" target="<?=$botoesHero['botao_1']['target']?>" class="btn button-cta-alternative"><?=$botoesHero['botao_1']['title']?></a>
                            <a href="<?=$botoesHero['botao_2']['url']?>" target="<?=$botoesHero['botao_2']['target']?>" class="btn button-cta-alternative"><?=$botoesHero['botao_2']['title']?></a>
                        </div>
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

        <?php if ($blocoDepoimentos['mostrar_bloco'] && $blocoDepoimentos['itens']): ?>
        <section id="depoimentos">
            <div id="carouselDepoimentos" class="carousel slide carousel-fade">
                <div class="carousel-inner">
                    <?php $i = 1; ?>
                    <?php foreach ($blocoDepoimentos['itens'] as $item): ?>
                    <?php
                    $texto = ($item['texto']) ? $item['texto'] : "";
                    $nome = ($item['nome']) ? $item['nome'] : "";
                    $imagem = ($item['imagem']) ? $item['imagem'] : "";
                    $classes = "";
                    if ($i == 1):
                        $classes = "active";
                    endif;
                    ?>
                    <div class="carousel-item <?=$classes?>" data-interval="10000" style="background: url(<?php echo $imagem["url"];?>)">
                        <div class="container">
                            <blockquote class="blockquote">
                                <p><?=$texto?></p>
                                <cite><?=$nome?></cite>
                            </blockquote>
                        </div>
                    </div>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </div>
                
                <?php if (count($blocoDepoimentos['itens']) > 1):?>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselDepoimentos" data-bs-slide="prev">
                    <div class="btn"><i><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M25.3334 16.0001H6.66675M6.66675 16.0001L16.0001 25.3334M6.66675 16.0001L16.0001 6.66675" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg></i></div>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselDepoimentos" data-bs-slide="next">
                    <div class="btn"><i><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M6.66675 16.0001H25.3334M25.3334 16.0001L16.0001 6.66675M25.3334 16.0001L16.0001 25.3334" stroke="white" stroke-width="2" stroke-linecap="square" stroke-linejoin="round"/></svg></i></div>
                    <span class="visually-hidden">Next</span>
                </button>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

        <section id="books">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="stroke-line">
                            <div class="square" style="background:#ECCD02"></div>
                            <div class="line"></div>
                        </div>
                        <header>
                            <h2><?=$livros['titulo']?></h2>
                        </header>
                        <div class="columns">
                            <div class="left">
                                <div class="-img">
                                    <img src="<?=$livros['itens'][0]['imagem']['url']?>" alt="<?=$livros['itens'][0]['imagem']['alt']?>" class="img-fluid" />
                                </div>
                                <div class="body">
                                    <h3><?=$livros['itens'][0]['titulo']?></h3>
                                    <p><?=$livros['itens'][0]['texto']?></p>
                                </div>
                                <a href="<?=$livros['itens'][0]['botao']['url']?>" target="<?=$livros['itens'][0]['botao']['target']?>" class="btn button-cta-alternative"><?=$livros['itens'][0]['botao']['title']?></a>
                            </div>
                            <div class="right">
                                <div class="-img">
                                    <img src="<?=$livros['itens'][1]['imagem']['url']?>" alt="<?=$livros['itens'][0]['imagem']['alt']?>" class="img-fluid" />
                                </div>
                                <div class="body">
                                    <h3><?=$livros['itens'][1]['titulo']?></h3>
                                    <p><?=$livros['itens'][1]['titulo']?></p>
                                </div>
                                <a href="<?=$livros['itens'][1]['botao']['url']?>" target="<?=$livros['itens'][1]['botao']['target']?>" class="btn button-cta-alternative"><?=$livros['itens'][1]['botao']['title']?></a>
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