<?php
/**
 * The sidebar for the category page - category ID 5 (Misc)
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NewsBook
 */

if ( ! is_active_sidebar( 'sidebar-5' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-5' ); ?>
</aside><!-- #secondary -->