<?php
/**
 * The main template file.
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

get_header(); ?>

<?php
	global $ct_options;

	isset( $ct_options['blog_sidebar'] ) ? $sidebar_position = $ct_options['blog_sidebar'] : $sidebar_position = 'right';
	isset( $ct_options['blog_pagination'] ) ? $blog_pagination = $ct_options['blog_pagination'] : $blog_pagination = 'standard';

	$push_content = '';
	$pull_sidebar = '';

	if ( $sidebar_position == 'left' ) {
		$push_content = 'col-md-push-4';
		$pull_sidebar = 'col-md-pull-8';
	}
?>

<div id="main-content" class="main-content clearfix">
	<div id="primary" role="main">
			<?php if ( have_posts() ) : ?>

			<div class="container">
				<div class="row">
					<div class="col-md-8 <?php echo esc_attr( $push_content ); ?>">

						<div id="blog-entry" class="clearfix">
							<?php
							while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile;
							?>
						</div> <!-- #blog-entry -->

						<?php ct_get_pagintaion(); ?>

					</div> <!-- .col-md-12 -->
						<?php if ( is_active_sidebar( 'ct_blog_sidebar' ) ) : ?>
							<div id="sidebar" class="col-md-4 <?php echo esc_attr( $pull_sidebar ); ?>" role="complementary">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_blog_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-4 -->
						<?php endif; ?>

				</div> <!-- .row -->
			</div> <!-- .container -->

			<?php
				else :
					get_template_part( 'content', 'none' );
				endif;
			?>
	</div> <!--#primary -->
</div><!-- #main-content -->

<?php get_footer(); ?>
