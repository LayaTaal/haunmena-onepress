<?php
/**
 * The sidebar for 3m case containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */

if ( ! is_active_sidebar( 'claim' ) ) {
	return;
}

?>

<div id="secondary" class="widget-area sidebar sidebar-claim" role="complementary">
	<?php dynamic_sidebar( 'claim' ); ?>
</div><!-- #secondary -->


