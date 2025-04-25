<?php
/**
 * Modelo de página Search
 * 
 * @package Sintropika
 */
 ?>
<?php get_header(); ?>

	<main id="main">

		<section id="hero">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12">
						<header>
							<h1><?= get_the_title(); ?></h1>
						</header>
					</div>
				</div>
			</div>
		</section>

		<section id="content">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12" id="search-results">
					</div>
				</div>
			</div>
		</section>

	</main>

<?php get_footer(); ?>