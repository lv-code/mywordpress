<?php
/**
 *
 * This is the template that displays pages with left/Right sidebar.
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

	get_header();
?>

<?php
    global $ct_options;
    $page_desc = get_post_meta( get_the_ID(), 'ct_mb_page_desc', true);


	$mb_sidebar_position = get_post_meta( $post->ID, 'ct_mb_sidebar_position', true);

	if ( ($mb_sidebar_position == '') and is_rtl() ) $mb_sidebar_position = 'left';
	else if ( $mb_sidebar_position == '' ) $mb_sidebar_position = 'right';

	$push_content = "";
	$sidebar_pull  = "";

	if ( $mb_sidebar_position == 'right' ) {
			$push_content = "";
			$sidebar_pull  = "";
	} else {
			$push_content = "col-md-push-4";
			$sidebar_pull  = 'col-md-pull-8';
	}
?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<div class="container">
			<div class="row">
					<div class="col-md-8 <?php echo esc_attr( $push_content ); ?>">
						<div class="page-content ct-custom-page clearfix">
							<?php
								// Start the Loop.
								while ( have_posts() ) : the_post();

									// Include the page content template.
									get_template_part( 'content', 'page' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) {
										comments_template();
									}
								endwhile;
							?>
						</div> <!-- .page-content -->
					</div> <!-- .col-md-9 -->
					<?php if ( is_active_sidebar( 'ct_page_sidebar' ) ) : ?>
						<div id="sidebar" class="col-md-4 ct-sidebar <?php echo esc_attr( $sidebar_pull ); ?>" role="complementary">
							<div class="sidebar-inner">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_page_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .sidebar -->
						</div> <!-- .col-md-3 -->
					<?php endif; ?>
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>