<?php
/**
 * The template for displaying Search page.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

	get_header();
?>

<?php
	global $ct_options, $wp_query;

	$count_posts = $wp_query->found_posts;

	isset( $ct_options['blog_sidebar'] ) ? $sidebar_position = $ct_options['blog_sidebar'] : $sidebar_position = 'right';
	isset( $ct_options['blog_pagination'] ) ? $blog_pagination = $ct_options['blog_pagination'] : $blog_pagination = 'standard';

	$push_content = '';
	$pull_sidebar = '';

	if ( $sidebar_position == 'left' ) {
		$push_content = 'col-md-push-4';
		$pull_sidebar = 'col-md-pull-8';
	}
?>

<?php ct_get_breadcrumbs(); ?>

<div id="main-content" class="main-content clearfix">
	<div id="primary" role="main">
			<?php if ( have_posts() ) : ?>

			<div class="container">
				<div class="row">
					<div class="col-md-8 <?php echo esc_attr( $push_content ); ?>">

						<header class="ptbar-content clearfix">
							<span class="sub-title"><?php echo esc_html( $count_posts ) . '&nbsp;' . esc_html__('articles found', 'color-theme-framework'); ?></span>
							<h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'color-theme-framework' ), get_search_query() ); ?></h1>
							<i class="fa fa-search"></i>
						</header>

						<div id="blog-entry" class="clearfix">
							<?php
							while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile;
							?>
						</div> <!-- #blog-entry -->

						<?php ct_get_pagintaion(); ?>

					</div> <!-- .col-md-12 -->
						<?php if ( is_active_sidebar( 'ct_archive_sidebar' ) ) : ?>
							<div id="sidebar" class="col-md-4 ct-sidebar <?php echo esc_attr( $pull_sidebar ); ?>" role="complementary">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_archive_sidebar') ) : ?>
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
