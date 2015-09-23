<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

get_header(); ?>

<div id="content" class="clearfix" role="main">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="page-content ct-custom-page content-area content-not-found">
					<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
						<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'color-theme-framework' ), admin_url( 'post-new.php' ) ); ?></p>
					<?php elseif ( is_search() ) : ?>
						<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'color-theme-framework' ); ?></p>
					<?php else : ?>
						<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'color-theme-framework' ); ?></p>
					<?php endif; ?>
				</div><!-- .page-content -->
			</div> <!-- .col-md-12 -->
			<?php if ( is_active_sidebar( 'ct_archive_sidebar' ) ) : ?>
				<div id="sidebar" class="col-md-4 ct-sidebar" role="complementary">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_archive_sidebar') ) : ?>
					<?php endif; ?>
				</div> <!-- .col-md-4 -->
			<?php endif; ?>
		</div> <!-- .row -->
	</div> <!-- .container -->
</div> <!-- #content -->

