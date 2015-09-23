<?php
/**
 *
 * Template name: Page Full Width
 *
 * This is the template that displays full width page.
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

	get_header();
?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
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
				</div> <!-- .col-md-12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>