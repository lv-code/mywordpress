<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

get_header(); ?>

<?php global $ct_options, $post, $wpdb; ?>

<?php
	isset( $ct_options['featured_image_post'] ) ? $featured_image_post = $ct_options['featured_image_post'] : $featured_image_post = 1;
	isset( $ct_options['single_category'] ) ? $single_category = $ct_options['single_category'] : $single_category = 1;
	isset( $ct_options['single_comments'] ) ? $single_comments = $ct_options['single_comments'] : $single_comments = 1;

	$soundcloud = get_post_meta( get_the_ID(), 'ct_mb_post_soundcloud', true );
	$audio_thumb_type = get_post_meta( get_the_ID(), 'ct_mb_post_audio_thumb', true );
	$post_copyright = get_post_meta( get_the_ID(), 'ct_mb_post_copyright', true );


	if ( !empty( $soundcloud ) && ( $audio_thumb_type == '' ) ) {
		$audio_thumb_type = 'player';
	}

	$mb_sidebar_position = get_post_meta( get_the_ID(), 'ct_mb_sidebar_position', true);

	if ( ($mb_sidebar_position == '') and is_rtl() ) : $mb_sidebar_position = 'left';
	elseif ($mb_sidebar_position == '') : $mb_sidebar_position = 'right'; endif;

	$push_content = "";
	$sidebar_pull  = "";

	if ( $mb_sidebar_position == 'left' ) {
			$push_content = 'col-md-push-4';
			$sidebar_pull  = 'col-md-pull-8';
	}

		isset( $ct_options['single_about_author'] ) ? $single_about_author = $ct_options['single_about_author'] : $single_about_author = 1;
		isset( $ct_options['single_share_enable'] ) ? $single_share_enable = $ct_options['single_share_enable'] : $single_share_enable = 1;
		isset( $ct_options['single_likes'] ) ? $single_likes = $ct_options['single_likes'] : $single_likes = 1;

		$content_full = 'col-md-9';
		if ( !$single_about_author and !$single_share_enable and !$single_likes) {
			$content_full = 'col-md-12';
		}

?>

<?php ct_get_breadcrumbs(); ?>

<div id="primary" class="content-area">
	<div id="main" class="site-main" role="main">
		<?php if ( is_active_sidebar( 'ct_single_top' ) ) : ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="ct-sidebar top_sidebars" role="complementary">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_single_top') ) : ?>
							<?php endif; ?>
						</div> <!-- #sidebar -->
					</div> <!-- .col-md-12 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		<?php endif; ?>
		<div class="container">
					<div class="row">
						<div class="col-md-8 <?php echo esc_attr( $push_content ); ?>">
								<?php while ( have_posts() ) : the_post(); ?>
									<?php ct_setPostViews(get_the_ID()); ?>

									<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post ct-custom-page clearfix' ); ?> itemscope itemtype="http://schema.org/BlogPosting">
										<div class="content-wrapper clearfix">

											<div class="entry-header">
												<?php if ( $single_category ) :
														$categories = get_the_category();

														if ( !empty( $categories[0]->cat_name ) ) {
															$category_id = get_cat_ID( $categories[0]->cat_name );
															$category_link = get_category_link( $category_id );
														}

														$category_bg = get_option("category_$category_id");
														if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';
													?>
													<div class="entry-header-meta clearfix">
														<?php
															$cat_index = 0;
															foreach ($categories as $category) {
																if ( !empty( $category->cat_name ) ) {
																	$category_id = get_cat_ID( $category->cat_name );
																	$category_link = get_category_link( $category_id );

																	if ( $cat_index > 0 ) {
																		echo esc_html__(', ', 'color-theme-framework');
																	}
																	echo '<a style="color: '. esc_attr( $category_bg['category_color'] ).'" href="'. $category_link .'">'. $category->cat_name .'</a>';
																	$cat_index++;
																}
															}
														?>
													</div>
												<?php endif; ?>
												<div class="single-title"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></div>
												<?php ct_get_meta_single(); ?>
											</div> <!-- .single-header-meta -->

											<?php
												/**
												 * POST FORMAT: Image and Standard
												 *
												 */
												if ( has_post_format('image') || !get_post_format() ) : ?>

													<?php
														if ( has_post_thumbnail() and $featured_image_post ) {
															$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb');
														?>
														<div class="post-thumbnail">
															<img src="<?php echo esc_url( $thumb_image_url[0] ); ?>" title="<?php echo esc_attr( sprintf( esc_html__( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
															<span class="img-caption"><?php echo get_post(get_post_thumbnail_id())->post_excerpt; ?></span>
														</div> <!-- .post-thumbnail -->
														<?php
														}
													?>
												<?php endif; ?>

												<?php
												/**
												 * POST FORMAT: Audio
												 *
												 */
												if ( has_post_format('audio') ) : ?>
													<?php
													$soundcloud = get_post_meta( $post->ID, 'ct_mb_post_soundcloud', true );
													if ( !empty( $soundcloud ) ) { ?>
														<div class="post-thumbnail">
															<?php echo $soundcloud; ?>
														</div> <!-- .post-thumbnail -->
													<?php } ?>
												<?php endif; ?>


												<?php
												/**
												 * POST FORMAT: Video
												 *
												 */
												if( has_post_format('video') ) : ?>
													<?php
														$video_type = get_post_meta( $post->ID, 'ct_mb_post_video_type', true );
														$thumb_type = get_post_meta( $post->ID, 'ct_mb_post_video_thumb', true );
														$videoid = get_post_meta( $post->ID, 'ct_mb_post_video_file', true );
														$custom_code = get_post_meta( get_the_ID(), 'ct_mb_post_video_custom_code', true );

														if ( !empty( $videoid ) ) {
													?>

													<div itemprop="video" class="post-thumbnail entry-thumb video-post-widget" >
														<?php
															if ( $video_type == 'youtube' ) echo '<iframe src="http://www.youtube.com/embed/' . esc_attr( $videoid ) .'?wmode=opaque"></iframe>';
															if ( $video_type == 'vimeo' ) echo '<iframe src="http://player.vimeo.com/video/' . esc_attr( $videoid ) . '"></iframe>';
															if ( $video_type == 'dailymotion' ) echo '<iframe src="http://www.dailymotion.com/embed/video/' . esc_attr( $videoid ) . '"></iframe>';
														?>
													</div>
													<?php } ?>
												<?php endif; ?>

												<?php
												/**
												 * POST FORMAT: Gallery
												 *
												 */
												if( has_post_format('gallery') ) : ?>

													<?php
													$time_id = rand();
													$meta_gallery = get_post_meta(get_the_ID(), 'ct_mb_gallery', false);

													if (!is_array($meta_gallery)) $meta_gallery = (array) $meta_gallery; ?>

													<?php
													if (!empty($meta_gallery)) {
														$rtl = 'false';

														if ( is_rtl() ) {
															$rtl = 'true';
														} else {
															$rtl = 'false';
														}
													?>

														<script type="text/javascript">
														/* <![CDATA[ */
															jQuery.noConflict()(function($){
																$(window).load(function () {
																	$('#slider-<?php echo $post->ID . '-' . esc_js( $time_id ); ?>').flexslider({
																			animation: "slide",
																			directionNav: true,
																			controlNav: false,
																			slideshow: false,
																			animationLoop: false,
																			smoothHeight: true,
																			prevText: "",
																			nextText: "",
																			rtl: <?php echo esc_js( $rtl ); ?>
																	});
																});
															});
														/* ]]> */
														</script>

													<!-- START FLEXSLIDER -->
													<div class="post-thumbnail single-page-slider">
														<div id="slider-<?php echo $post->ID . '-' . esc_attr( $time_id ); ?>" class="flexslider clearfix">
															<ul class="slides clearfix">
																<?php
																$meta_gallery = implode(',', $meta_gallery);
																$order_key = 'attachment';

																$images = $wpdb->get_col( $wpdb->prepare( "
																		SELECT ID FROM $wpdb->posts
																		WHERE post_type = %s
																		AND ID in ($meta_gallery)
																		ORDER BY menu_order ASC
																", $order_key ) );

																foreach ($images as $att) {
																	$src = wp_get_attachment_image_src($att, 'single-thumb');
																	$src = $src[0];
																?>

																	<?php
																	echo '<li>';
																	echo '<img src="' . esc_attr( $src ) . '" alt="' . the_title('','',false) . '">';
																	echo '</li>';
																} // end foreach ?>
															</ul><!-- .slides -->
														</div><!-- .flexSlider -->
													</div> <!-- .entry-thumb -->
													<?php } ?>

												<?php endif; ?>

												<div class="row">
													<div class="col-md-3 col-sm-3">
														<?php ct_get_author_share(); ?>

														<?php if ( is_active_sidebar( 'ct_single_ads' ) ) : ?>
															<div class="widget-ads clearfix">
																<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_single_ads') ) : ?>
																<?php endif; ?>
															</div> <!-- .widget-ads -->
														<?php endif; ?>
													</div> <!-- .col-md-3 -->

													<div class="<?php echo esc_attr( $content_full ); ?> col-sm-9">
														<div class="single-content">
															<?php the_content(); ?>
														</div> <!-- .single-content -->

														<?php ct_get_single_tags(); ?>

														<?php if( !empty( $post_copyright ) ) : ?>
															<div class="article-copyright">
																<?php echo $post_copyright; ?>
															</div> <!-- .article-copyright -->
														<?php endif; ?>

														<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( '<span>Pages:</span>', 'color-theme-framework' ), 'after' => '</div>' ) ); ?>

														<?php ct_get_edit_link(); ?>

													</div> <!-- .col-md-9 -->
												</div> <!-- .row -->
												<?php ct_post_nav(); ?>

											</div> <!-- .content-wrapper -->
													<?php if ( comments_open() ) : ?>
														<div class="entry-comments-form clearfix">
															<div class="comments-wrapper">
																<?php $comments_count = wp_count_comments(get_the_ID()); ?>
																	<?php
																		wp_reset_postdata();
																		comments_template( '', true );
																	?>
															</div> <!-- .comments-wrapper -->
														</div> <!-- .entry-comments-form -->
													<?php endif; ?>

									</article><!-- #post-ID -->
								<?php endwhile; // end of the loop. ?>

						</div> <!-- .col-md-8 -->

						<?php if ( is_active_sidebar( 'ct_single_sidebar' ) ) : ?>
							<div id="sidebar" class="col-md-4 <?php echo esc_attr( $sidebar_pull ); ?> ct-sidebar" role="complementary">
								<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_single_sidebar') ) : ?>
								<?php endif; ?>
							</div> <!-- .col-md-4 -->
						<?php endif; ?>

					</div> <!-- .row -->
		</div> <!-- .container -->

		<?php if ( is_active_sidebar( 'ct_single_bottom' ) ) : ?>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="ct-sidebar bottom_sidebars" role="complementary">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('ct_single_bottom') ) : ?>
							<?php endif; ?>
						</div> <!-- #sidebar -->
					</div> <!-- .col-md-12 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		<?php endif; ?>

	</div> <!--#main -->
</div> <!-- #primary -->

<?php get_footer(); ?>