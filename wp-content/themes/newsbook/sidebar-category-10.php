<?php
/**
 * The sidebar for the category page - category ID 10 Germany
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewsBook
 */

if ( ! is_active_sidebar( 'newsbook_sidebar_1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-10' ); ?>
</aside><!-- #secondary -->