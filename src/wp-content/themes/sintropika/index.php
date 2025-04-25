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

    $notIn = array();
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
                            <h2>My book, A Platform Mindset: Building a Culture of collaboration is now available</h2>
                        </header>
                        <div class="columns">
                            <div class="left d-none d-lg-flex">
                                <div class="-img d-none d-lg-flex">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home-books.png" alt="Tecnologia Intencional" class="img-fluid" />
                                </div>
                            </div>
                            <div class="right">
                                <p>The book provides a practical and thoughtful perspective on technology management, drawing from the my extensive twenty-year career at leading companies like IBM, Yahoo, Google, and Microsoft, and, more recently, at the Brazilian fintech Stone, where I strove to drive deep technological transformation.</p>
                                <p>All author proceeds will be donated to organizations supported by Microsoft Philanthropies. The book appeared first in Portuguese with the title <link para https://www.amazon.com.br/Tecnologia-Intencional-Bicicletas-Transformam-Carreiras/dp/6550475147>Tecnologia Intencional</link>, and with proceeds  donated to <link to https://www.estudar.org.br/>Fundação Estudar.</link></p>
                                <div class="-img d-lg-none">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/home-books.png" alt="Tecnologia Intencional" class="img-fluid" />
                                </div>
                                <a href="#" class="btn button-cta-alternative">Explore more</a>
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
                                <h2>Bio snapshot</h2>
                                <p>I'm currently in my second tenure as Technical Fellow at Microsoft, where I work as CTO for Azure Core.</p>
                                <p>Most recently, I was the CTO at Stone (2022-2025), where I led the engineering organization. I focused on building highly efficient financial platforms and an amazing engineering culture. I continue to serve as an advisor to the company.</p>
                                <p>Previously, in in my first tenure as Technical Fellow and Corporate Vice President at Microsoft (2013-2022), I worked as the chief architect for Azure Compute and led  the Azure efficiency team. In my previous roles at Microsoft, I worked on the production infrastructure for Bing and in several Bing Ads projects.</p>
                                <a href="<?=site_url()?>/full-resume" class="btn button-cta-alternative d-none d-lg-flex">See my full resume</a>
                            </div>
                            <div class="right">
                                <p>From 2011 to 2013 I was a Staff Research Scientist at Google focusing on search infrastructure. I acted as Pricipal Research Scientist at Yahoo! Research (2005-2010), Before joining Google, I was a Principal Research Scientist at Yahoo! Research (2005-2010) working on several projects in the area of computational advertising. I've also worked as the architect for a large-scale software platform for indexing and content serving.</p>
                                <p>I worked as a Research Staff Member at the IBM Almaden Research Center (2000-2005), where I co-developed a query processor for XPath queries over XML streams, and helped developing an Enterprise Search Engine that resulted in the IBM OmniFind Enterprise Search. </p>
                                <a href="<?=site_url()?>/full-resume" class="btn button-cta-alternative d-lg-none">See my full resume</a>
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
                                <h2>Academic background and research contribuition</h2>
                                <p>I've finished my Ph.D. studies in 1999, at the Pontifical Catholic University of Rio de Janeiro, Brazil (PUC-Rio), in a joint program with the Computer Systems Group, University of Waterloo, Canada.</p>
                                <a href="<?=site_url()?>/publications" class="btn button-cta-alternative d-none d-lg-flex">See my selected publications</a>
                            </div>
                            <div class="right">
                                <p>My Ph.D. work was in the area of object-oriented design and software architecture. The main contributions from my Ph.D. thesis have been condensed in the book The UML Profile for Framework Architectures, published by Addison-Wesley in 2001. After finishing my Ph.D. I was a post-doctoral researcher in the Computer Science Department at Princeton University for one year (1999-2000).</p>
                                <p>During my scientific journey I've obtained more than 50 patents (and many others filed) and published more than 50 papers. I've also been in several program committees over the years, including SIGIR, WWW, WSDM, KDD, and CIKM, and I'm an ACM Distinguished Member and an IEEE Senior Member.</p>
                                <a href="<?=site_url()?>/publications" class="btn button-cta-alternative d-lg-none">See my selected publications</a>
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
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-tecnologia-intencional.png" alt="Tecnologia Intencional" class="img-fluid" />
                        </div>
                        <div class="columns">
                            <div class="left">
                                <h2>The Tecnologia Intencional Plataform</h2>
                                <a href="#" class="btn button-cta-alternative d-none d-lg-flex">Explore more</a>
                            </div>
                            <div class="right">
                                <p>The Tecnologia Intencional online platform is intended to the Brazilian audience with the goal of deepening and amplifying the innovation, platform, managament and use of tools ideas from my book, providing a public space where one can think about how to think about technology.</p>
                                <p>The site aims to address technology-related topics in a way that is easy to understand and apply, always keeping the human factor as both the starting point and the ultimate goal.</p>
                                <a href="#" class="btn button-cta-alternative d-lg-none">Explore more</a>
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