<?php
/**
 * Template Name: Homepage
 *
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

	get_header();

	global $ct_options;
?>

<?php
	isset( $ct_options['main_layout'] ) ? $main_layout = $ct_options['main_layout'] : $main_layout = "2";
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<div class="container">
			<div class="row">
			<?php if ( is_active_sidebar( 'ct_magazine_top' ) ) : ?>
				<div class="col-md-12 ct-sidebar top_sidebars">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_top') ) : ?>
					<?php endif; ?>
				</div> <!-- .col-md-12 -->
			<?php endif; ?>
			<?php
				switch( $main_layout ) {
					// Left Sidebar + Content
					case '1':
					?>
						<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
							<div class="col-md-8 col-md-push-4 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-8 -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'ct_magazine_left_sidebar' ) ) : ?>
							<div class="col-md-4 col-md-pull-8 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_left_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-4 -->
						<?php endif; ?>
					<?php
					break;

					// Content + Right Sidebar
					case '2':
					?>
						<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
							<div class="col-md-8 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-8 -->
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'ct_magazine_right_sidebar' ) ) : ?>
							<div class="col-md-4 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_right_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-4 -->
						<?php endif; ?>
					<?php
					break;

					// Left Sidebar + Content + Right Sidebar
					case '3':
					?>
						<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
							<div class="col-md-6 col-md-push-3 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-6 -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'ct_magazine_left_sidebar' ) ) : ?>
							<div class="col-md-3 col-md-pull-6 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_left_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'ct_magazine_right_sidebar' ) ) : ?>
							<div class="col-md-3 ct-sidebar <?php if ( !is_active_sidebar( 'ct_magazine_left_sidebar' ) ) { echo 'col-md-push-3'; } ?>">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_right_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>
					<?php
					break;

					case '4':
					?>
						<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
							<div class="col-md-6 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-6 -->
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'ct_magazine_left_sidebar' ) ) : ?>
							<div class="col-md-3 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_left_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'ct_magazine_right_sidebar' ) ) : ?>
							<div class="col-md-3 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_right_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>
					<?php
					break;

					case '5':
					?>
						<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
							<div class="col-md-6 col-md-push-6 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-6 -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'ct_magazine_left_sidebar' ) ) : ?>
							<div class="col-md-3 col-md-pull-6 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_left_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>
						<?php if ( is_active_sidebar( 'ct_magazine_right_sidebar' ) ) : ?>
							<div class="col-md-3 col-md-pull-6 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_right_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>

					<?php
					break;

					case '6':
					?>
						<div class="col-md-9 col-md-push-3">
							<div class="row">

								<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
									<div class="col-md-8 col-md-push-4 ct-sidebar">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
										<?php endif; ?>
									</div> <!-- .col-md-8 -->
								<?php endif; ?>

								<?php if ( is_active_sidebar( 'ct_magazine_right_sidebar' ) ) : ?>
									<div class="col-md-4 col-md-pull-8 ct-sidebar">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_right_sidebar') ) : ?>
										<?php endif; ?>
									</div> <!-- .col-md-4 -->
								<?php endif; ?>

								<?php if ( is_active_sidebar( 'ct_magazine_center_bottom' ) ) : ?>
									<div class="col-md-12 ct-sidebar bottom_sidebars">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center_bottom') ) : ?>
										<?php endif; ?>
									</div> <!-- .col-md-12 -->
								<?php endif; ?>

							</div> <!-- .row -->
						</div> <!-- .col-md-9 -->
						<?php if ( is_active_sidebar( 'ct_magazine_left_sidebar' ) ) : ?>
							<div class="col-md-3 col-md-pull-9 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_left_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>
					<?php
					break;

					case '7':
					?>
						<div class="col-md-9">
							<div class="row">
								<?php if ( is_active_sidebar( 'ct_magazine_center' ) ) : ?>
									<div class="col-md-8 col-md-push-4 ct-sidebar">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center') ) : ?>
										<?php endif; ?>
									</div> <!-- .col-md-8 -->
								<?php endif; ?>

								<?php if ( is_active_sidebar( 'ct_magazine_left_sidebar' ) ) : ?>
									<div class="col-md-4 col-md-pull-8 ct-sidebar">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_left_sidebar') ) : ?>
										<?php endif; ?>
									</div> <!-- .col-md-4 -->
								<?php endif; ?>


								<?php if ( is_active_sidebar( 'ct_magazine_center_bottom' ) ) : ?>
									<div class="col-md-12 ct-sidebar bottom_sidebars">
										<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_center_bottom') ) : ?>
										<?php endif; ?>
									</div> <!-- .col-md-12 -->
								<?php endif; ?>

							</div> <!-- .row -->
						</div> <!-- .col-md-9 -->
						<?php if ( is_active_sidebar( 'ct_magazine_right_sidebar' ) ) : ?>
							<div class="col-md-3 ct-sidebar">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_right_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-3 -->
						<?php endif; ?>
					<?php
					break;
				}
			?>

			<?php if ( is_active_sidebar( 'ct_magazine_bottom' ) ) : ?>
				<div class="col-md-12 ct-sidebar bottom_sidebars">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_magazine_bottom') ) : ?>
					<?php endif; ?>
				</div> <!-- .col-md-12 -->
			<?php endif; ?>
			</div> <!-- .row -->
		</div> <!-- .container -->
	</main> <!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>