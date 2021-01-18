<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewsBook
 */

get_header();
?>

<div id="main-content">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 content-area">
				<main id="primary" class="site-main">
				<?php
				if ( have_posts() ) :

					if ( is_home() && ! is_front_page() ) :
						?>
						<header>
							<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
						</header>
						<?php
					endif;

					?>

					<div class="row row-cols-1 row-cols-sm-2 nb-posts-row ">

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							?>

							<div class="col">
								<?php
								/*
								* Include the Post-Type-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Type name) and that will be used instead.
								*/
								get_template_part( 'template-parts/content', get_post_type() );

								?>
							</div>

							<?php

						endwhile;
						?>

					</div>

					<?php

					get_template_part( 'template-parts/navigation', 'none' );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

				</main><!-- #main -->
			</div>

			<div class="col-md-4 sidebar-area">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

</div><!-- /#main-content -->

<?php
get_footer();
