<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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

					<section class="error-404 not-found">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'Nothing was found at this location.', 'newsbook' ); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<p><?php esc_html_e( 'Maybe try one of the links below or a search?', 'newsbook' ); ?></p>
							<img src="https://www.football.guru/wp-content/uploads/2021/01/american-football-155961_640.png" style="width=100%;margin-bottom:20px;"/>

								<?php
								the_widget( 'WP_Widget_Recent_Posts' );
								?>

								<div class="widget widget_categories">
									<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'newsbook' ); ?></h2>
									<ul>
										<?php
										wp_list_categories(
											array(
												'orderby'  => 'count',
												'order'    => 'DESC',
												'show_count' => 1,
												'title_li' => '',
												'number'   => 10,
											)
										);
										?>
									</ul>
								</div><!-- .widget -->

						</div><!-- .page-content -->
					</section><!-- .error-404 -->

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
