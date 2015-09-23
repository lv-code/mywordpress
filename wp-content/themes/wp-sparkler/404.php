<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

	get_header();
?>

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

<?php ct_get_breadcrumbs(); ?>

<div id="main-content" class="main-content clearfix">
	<div id="primary" role="main">
			<div class="container">
				<div class="row">
					<div class="col-md-8 <?php echo esc_attr( $push_content ); ?>">

						<header class="ptbar-content clearfix">
							<span class="sub-title"><?php esc_html_e( '404 Error', 'color-theme-framework' ); ?></span>
							<h1 class="entry-title"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'color-theme-framework' ); ?></h1>
							<i class="fa fa-search"></i>
						</header>

						<div class="ct-custom-page clearfix">
							<div class="content-wrapper clearfix">
							    <div class="col-md-6">
								  <h3><?php esc_html_e('Last 30 Posts', 'color-theme-framework') ?></h3>
								  <ul class="archives">
								    <?php $archive_30 = get_posts('numberposts=30');
								    foreach($archive_30 as $post) : ?>
									  <li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
								  	<?php endforeach; ?>
								  </ul>
								</div><!-- .col-md-6 -->

								<div class="col-md-6">
								  <h3><?php esc_html_e('Archives by Month:', 'color-theme-framework') ?></h3>
								  <ul class="archives">
								    <?php wp_get_archives('type=monthly'); ?>
								  </ul>
								</div><!-- .col-md-6 -->
							</div>
						</div>
					</div> <!-- .col-md-12 -->

					<?php if ( is_active_sidebar( 'ct_archive_sidebar' ) ) : ?>
						<div id="sidebar" class="col-md-4 ct-sidebar <?php echo esc_attr( $pull_sidebar ); ?>" role="complementary">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_archive_sidebar') ) : ?>
							<?php endif; ?>
						</div> <!-- .col-md-4 -->
					<?php endif; ?>

				</div> <!-- .row -->
			</div> <!-- .container -->
	</div> <!--#primary -->
</div><!-- #main-content -->

<?php get_footer(); ?>
