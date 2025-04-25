<?php
    /**
 * botao-acao Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$itens = get_field('itens');
    
?>

<?php if($itens):?>
<div class="lista-destacada">
    <?php
        foreach($itens as $item):
            $tipo = $item['tipo'];
            $numero = $item['numero'];
            $imagem = $item['imagem'];
            $conteudo = $item['conteudo'];
    ?>
    <div class="item <?=$tipo?>">
        <?php if(($tipo == 'numero' && $numero) || ($tipo == 'imagem' && $imagem)):?>
        <div class="left">
            <?php if($tipo == 'numero' && $numero):?>
                <span class="item-numero"><?=$numero?></span>
            <?php endif;?>
            <?php if($tipo == 'imagem' && $imagem):?>
                <img src="<?=$imagem['sizes']['medium']?>" alt="<?=$imagem['alt']?>" class="img-fluid" />
            <?php endif;?>
        </div>
        <?php endif;?>
        <div class="right">
            <?=$conteudo?>
        </div>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>