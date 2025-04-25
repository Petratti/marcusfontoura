<?php 
    /**
     * Template Name: Single
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

//pegar nome do mês por extenso e abreviado da publicação
$data = get_the_date('d/m/Y');
$data = ucfirst($data);

//pegar categorias da publicação (taxonomia)
$categoriaPrimaria = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_category', true );
$categorias = get_the_terms(get_the_ID(), 'category');
$categorias_html = '';
$subcategorias_html = '';
$categoriasArray = array();
$subcategoriasArray = array();
if($categorias) {
    foreach($categorias as $categoria) {
        if($categoria->term_id == $categoriaPrimaria) {
            if($categoria->parent) {
                //inserir no início do array
                array_unshift($subcategoriasArray, $categoria->name);
                $subCategoriaPrincipal = $categoria->slug;
            }else {
                //inserir no início do array
                array_unshift($categoriasArray, $categoria->name);
                $corTema = corTema($categoria->slug);
            }
        } else {
            if($categoria->parent) {
                //inserir no fim do array
                $subcategoriasArray[] = $categoria->name;
                if(!$subCategoriaPrincipal) {
                    $subCategoriaPrincipal = $categoria->slug;
                }
            }else {
                //inserir no fim do array
                $categoriasArray[] = $categoria->name;
                if(!$corTema) {
                    $corTema = corTema($categoria->slug);
                }
            }
        }
    }
}
$categorias_html = @implode(', ', $categoriasArray);
$subcategorias_html = @implode(', ', $subcategoriasArray);

//pegar formatos da publicação (taxonomia)
$formatoPrimario = get_post_meta(get_the_ID(), '_yoast_wpseo_primary_formato', true );
$formatos = get_the_terms(get_the_ID(), 'formato');
$formatos_html = '';
if($formatos) {
    foreach($formatos as $formato) {
        if($formato->term_id == $formatoPrimario) {
            $formatos_html = '<span class="formato">'.$formato->name.'</span>'.$formatos_html;
        } else {
            $formatos_html .= '<span class="formato">'.$formato->name.'</span>';
        }
    }
}


//pegar taxonomia 'autor' da publicação, com descricao e foto
$autor = get_the_terms(get_the_ID(), 'autor');
//se não tiver nenhum autor, pega o autor padrão
if(!$autor) {
    $autor = get_term_by('slug', 'marcus-fontoura', 'autor');
}else {
    $autor = $autor[0];
}
$autor_id = $autor->term_id;
$autor_nome = $autor->name;
$autor_descricao = $autor->description;
$autor_cargo = get_field('cargo', $autor);
$autor_imagem = get_field('foto', $autor);
$autor_imagem_url = $autor_imagem['sizes']['large'];
$autor_imagem_alt = $autor_imagem['alt'];

$label_especial = get_field('label_especial');
$tipo_de_cabecalho = get_field('tipo_de_cabecalho');
$proporcao_da_thumb = get_field('proporcao_da_thumb');

$hero_class .= $tipo_de_cabecalho;

?>

<main id="main">

    <section id="hero" class="<?=$hero_class?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="tags">
                        <?php if($formatos_html):?>
                        <!-- <div class="formatos">
                            <?=$formatos_html?>
                        </div> -->
                        <?php endif;?>
                        <?php if($categorias_html || $subcategorias_html):?>
                        <div class="categorias_subcategorias">
                            <div class="categorias">
                                <div class="square" style="background:<?=$corTema?>"></div>
                                <?=$categorias_html?>
                            </div>
                            <?php if($subcategorias_html):?>
                            <div class="subcategorias">
                                <?=$subcategorias_html?>
                            </div>
                            <?php endif;?>
                        </div>
                        <?php endif;?>
                    </div>
                    
                    <div class="label">
                        <?php if($label_especial):?>
                        <span class="tag"><?=$label_especial?></span>
                        <?php endif;?>
                    </div>
                    
                    <header>
                        <h1><?= get_the_title(); ?></h1>
                    </header>
                    <?php if($autor):?>
                    <div class="autor">
                        <div class="-img">
                        <img src="<?=$autor_imagem_url; ?>" alt="<?=$autor_imagem_alt; ?>" class="img-fluid">
                        </div>
                        <div class="-info">
                            <h2><?=$autor_nome; ?></h2>
                            <p><?=$autor_cargo; ?></p>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php if($thumbnail_id && $tipo_de_cabecalho == "wide"):?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <?php if($thumbnail_id) { ?>
                    <div class="col-lg-12">
                        <section id="imagem-destaque">
                            <img src="<?=$thumbnail_url[0]?>" alt="<?=$thumbnail_alt[0]?>" class="img-fluid">
                        </section>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php endif;?>
        <?php if($thumbnail_id && $tipo_de_cabecalho == "split"):?>
        <section id="imagem-destaque">
            <img src="<?=$thumbnail_url[0]?>" alt="<?=$thumbnail_alt[0]?>" class="img-fluid">
        </section>
        <?php endif;?>
    </section>
    

    <section id="content">
        <section id="post">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="post-content">
                            <?php the_content(); ?>
                            <?php if($autor):?>
                            <div class="autor">
                                <div class="-img">
                                <img src="<?=$autor_imagem_url; ?>" alt="<?=$autor_imagem_alt; ?>" class="img-fluid">
                                </div>
                                <div class="-info">
                                    <span>Sobre o autor</span>
                                    <div class="bottom">
                                        <h2><?=$autor_nome; ?></h2>
                                        <p><?=$autor_descricao; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </section>

    <?php
    //busca por 3 posts do tipo post onde taxonomia 'category' seja a mesma do post atual, exceto o post atual
    $taxonomiaPrincipal = 'category';
    $taxonomiaPrincipalPrimaria = '_yoast_wpseo_primary_category';

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'date',
        'order' => 'DESC',
        'paged' => 1,
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $subCategoriaPrincipal
            )
        )
    );
    $query = new WP_Query($args);
    ?>
    <?php include 'inc/components/relacionados.php'; ?>

</main>

<script>
    $(document).ready(function(){
        var cards = $('.-cards');
        //checar se mansory já existe
        if(cards.data('masonry')){
            //se existir, destruir
            cards.masonry('destroy');
            //cards.removeData('masonry'); // This line to remove masonry's data
        }
        // Initialize masonry again
        cards.masonry({
            itemSelector: '.card-content-js',
            //columnWidth: 340,
        });

        //contar a quantidade de cards paraincluir a linha entre as colunas
        var total = cards.children('.card-content-js').length;
        cards.removeClass('duas-colunas');
        if(total >= 2){
            cards.addClass('tres-colunas');
        }
    });
</script>

<?php
    get_footer();
?>