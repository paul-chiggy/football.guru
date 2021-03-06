<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewsBook
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'nb-post-with-content' ); ?>>

	<div class="nb-card-content">
		<header class="entry-header">
			<?php
				
			the_title( '<h1 class="entry-title">', '</h1>' );

			if ( 'post' === get_post_type() ) :
				?>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php newsbook_post_thumbnail(); ?>

		<div class="entry-content">
			<?php
			the_content(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'newsbook' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'newsbook' ),
					'after'  => '</div>',
				)
			);
			?>
		</div><!-- .entry-content -->
		<div class="clearfix"></div>
	</div>
	<div class="entry-meta">
		<?php
		newsbook_posted_on();
		newsbook_posted_by();
		newsbook_cats_list();
		?>
	</div><!-- .entry-meta -->

</article><!-- #post-<?php the_ID(); ?> -->

