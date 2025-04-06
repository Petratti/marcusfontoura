<?php 
    /**
     * Template Name: Resume
     */
?>
<?php get_header(); ?>

<main id="main">

    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <header>
                        <h1 class="-line-top"><?= get_the_title(); ?></h1>
                        <?php the_content(); ?>
                    </header>
                </div>
            </div>
        </div>
    </section>

    <section id="content">
        
    </section>

</main>
    


<?php
    get_footer();
?>