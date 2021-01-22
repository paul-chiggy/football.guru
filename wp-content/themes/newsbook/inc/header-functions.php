<?php
/**
 * Functions which enhance the theme header
 *
 * @package NewsBook
 */

if ( ! function_exists( 'newsbook_display_main_header_design_1' ) ) :
	/**
	 * Display header design 1.
	 *
	 * @return void
	 */
	function newsbook_display_main_header_design_1() {
		?>
		<header id="masthead" class="site-header">
			<div class="main-header-bar nb-header-design-1">
				<div class="container">
					<div class="row align-items-center site-header-row">
						<div class="col-md-4">
							<div class="site-branding">
								<?php
								the_custom_logo();
								 ?>
							</div><!-- .site-branding -->
						</div>

						<div class="col-md-8">
							<div class="header-right-widgets">
								<div class="widget">
									<nav id="site-navigation" class="main-navigation">
										<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'newsbook' ); ?></button>
										<?php
										wp_nav_menu(
											array(
												'theme_location' => 'users-menu',
												'menu_id'        => 'users-menu',
											)
										);
										?>
									</nav>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header><!-- #masthead -->

		<div class="main-header-nav-bar nb-header-design-1">
			<div class="container">
				<div class="row align-items-center primary-nav-row">
					<div class="col-md-12">
						<nav id="site-navigation" class="main-navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'newsbook' ); ?></button>
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
								)
							);
							?>
						</nav><!-- #site-navigation -->
						<div class="menu-search">
							<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form searchform clearfix" method="get">
								<div class="search-wrap">
									<input type="text" placeholder="<?php esc_attr_e( 'Ask Football Guru', 'newsbook' ); ?>" class="s field" name="s">
									<button class="search-icon" type="submit">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
											<path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
										</svg>
									</button>
								</div>
							</form><!-- .searchform -->
						</div><!-- .menu-search -->
					</div>
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- /.main-header-nav-bar -->
		<?php
	}
endif;
