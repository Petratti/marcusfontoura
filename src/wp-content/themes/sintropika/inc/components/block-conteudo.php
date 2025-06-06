<?php foreach ($blocos as $bloco): ?>
<?php
    $fundo = $bloco['fundo'];
    $colunas = $bloco['colunas'];
    $colunaClass = "col-lg-12";
    if ($colunas == 2) {
        $colunaClass = "col-lg-6";
    } elseif ($colunas == 3) {
        $colunaClass = "col-lg-4";
    }
?>
<section class="block-conteudo" style="background:<?=$fundo?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="stroke-line">
                    <div class="square" style="background:#ECCD02"></div>
                    <div class="line"></div>
                </div>
                <header>
                    <h2><?=$bloco['titulo']?></h2>
                </header>
            </div>
        </div>
        <?php if ($bloco['itens']): ?>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                <?php foreach ($bloco['itens'] as $item): ?>
                <?php
                    $tags = $bloco['tags'];
                ?>
                    <div class="coluna <?=$colunaClass?>">
                        <?php 
                        $conteudo = $item['item']['conteudo'];
                        $conteudo = preg_replace_callback(
                            '#<a\s+href="([^"]+)">\s*\(pdf\)\s*</a>#i',
                            function ($matches) {
                                $href = $matches[1];
                                return '<a href="' . $href . '" target="_blank" class="tag pdf">PDF</a>';
                            },
                            $conteudo
                        );
                        $conteudo = preg_replace_callback(
                            '#<a\s+href="([^"]+)">\s*\(slides\)\s*</a>#i',
                            function ($matches) {
                                $href = $matches[1];
                                return '<a href="' . $href . '" target="_blank" class="tag slides">SLIDES</a>';
                            },
                            $conteudo
                        );
                        $conteudo = preg_replace_callback(
                            '#<a\s+href="([^"]+)">\s*\(paper\)\s*</a>#i',
                            function ($matches) {
                                $href = $matches[1];
                                return '<a href="' . $href . '" target="_blank" class="tag link">PAPER</a>';
                            },
                            $conteudo
                        );
                        $conteudo = preg_replace_callback(
                            '#<a\s+href="([^"]+)">\s*\(Web publication\)\s*</a>#i',
                            function ($matches) {
                                $href = $matches[1];
                                return '<a href="' . $href . '" target="_blank" class="tag link">LINK</a>';
                            },
                            $conteudo
                        );
                        echo $conteudo;
                        ?>
                        <?php
                        //remove a tag <p> do conteudo
                        /* $conteudo = $item['item']['conteudo'];
                        $conteudo = str_replace('<p>', '', $conteudo);
                        $conteudo = str_replace('</p>', '', $conteudo);
                        echo $conteudo; */
                        ?>
                        <?php if ($item['item']['tags']): ?>
                        <span class="tags">
                            <?php foreach ($item['item']['tags'] as $tag): ?>
                                <span class="tag <?=$tag['value']?>"><?=$tag['label']?></span>
                            <?php endforeach; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endforeach; ?>