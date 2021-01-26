<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewsBook
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-5S0EKGT9CG"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-5S0EKGT9CG');
	</script><!-- GA4 tag end -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>	
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php do_action( 'newsbook_before_page' ); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'newsbook' ); ?></a>
	
	<div id="FGaamm">
		<p>
			Dear user, Football Guru is made possible by displaying online ads to our visitors.<br>
			We extremely value your user experience and don't display annoying or intrusive ads.<br>
			Please consider supporting us by disabling your ad blocker. Cheers!
		</p>
	</div>

	<?php do_action( 'newsbook_before_header' ); ?>

	<?php newsbook_display_main_header_design_1(); ?>

	<?php do_action( 'newsbook_after_header' ); ?>
