<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NewsBook
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'newsbook' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'newsbook' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'It looks loke nothing matched your search terms. Please try again with some different keywords.', 'newsbook' ); ?></p>
			<img src="https://www.football.guru/wp-content/uploads/2021/01/american-football-155961_640.png" style="width=100%;margin-bottom:20px;"/>
			<?php

		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'newsbook' ); ?></p>
			<img src="https://www.football.guru/wp-content/uploads/2021/01/american-football-155961_640.png" style="width=100%;margin-bottom:20px;"/>
			<?php
			

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
