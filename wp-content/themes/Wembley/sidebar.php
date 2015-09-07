<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package web2feel
 */
?>
	<div class="searchbox">
		<?php get_search_form(); ?>
	</div>
	
	<div id="secondary" class="widget-area" role="complementary">
		<?php do_action( 'before_sidebar' ); ?>
		<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

		<?php endif; // end sidebar widget area ?>
		<?php get_template_part( 'sponsors' ); ?>
	</div><!-- #secondary -->
