<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT 2 Columns Magazine Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show recent posts by categories
 	Version: 1.0
 	Author: Zerge
 	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/

/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init', 'ct_2columns_load_widgets');

function ct_2columns_load_widgets()
{
	register_widget('CT_2Columns_Widget');
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_2Columns_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CT_2Columns_Widget()
	{
		/* Widget settings. */
		$widget_ops = array('classname' => 'ct_2columns_widget', 'description' => __( '2 Columns Vertical Magazine Widget (show recent posts).' , 'color-theme-framework' ) );

		/* Create the widget. */
		parent::__construct( 'ct_2columns_widget', __( 'CT: 2 Columns Magazine Widget' , 'color-theme-framework' ), $widget_ops);
	}

	function widget($args, $instance)
	{
		extract($args);

		/* First Column */
		$title 					= apply_filters ('widget_title', $instance ['title']);
		$icon_class 			= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$categories 			= $instance['categories'];
		$categories_exclude 	= $instance['categories_exclude'];
		$posts 					= $instance['posts'];
		$excerpt_lenght 		= $instance['excerpt_lenght'];
		$background_title 		= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#222b31';

		/* Second Column */
		$title2 				= apply_filters ('widget_title', $instance ['title2']);
		$icon_class2 			= ! empty ( $instance['icon_class2'] ) ? $instance['icon_class2'] : '';
		$categories2 			= $instance['categories2'];
		$categories_exclude2 	= $instance['categories_exclude2'];
		$posts2 				= $instance['posts2'];
		$excerpt_lenght2 		= $instance['excerpt_lenght2'];
		$background_title2 		= ! empty ( $instance['background_title2'] ) ? $instance['background_title2'] : '#222b31';

		/* For the both columns */
		$show_first_views 		= isset($instance['show_first_views']) ? '1' : '0';
		$show_first_likes 		= isset($instance['show_first_likes']) ? '1' : '0';
		$show_first_date 		= isset($instance['show_first_date']) ? '1' : '0';
		$show_first_author 		= isset($instance['show_first_author']) ? '1' : '0';
		$show_first_comments 	= isset($instance['show_first_comments']) ? '1' : '0';
		$show_first_category 	= isset($instance['show_first_category']) ? '1' : '0';

		/* Meta Information */
		$show_image 			= isset($instance['show_image']) ? '1' : '0';
		$show_views 			= isset($instance['show_views']) ? '1' : '0';
		$show_likes 			= isset($instance['show_likes']) ? '1' : '0';
		$show_date 				= isset($instance['show_date']) ? '1' : '0';
		$show_author 			= isset($instance['show_author']) ? '1' : '0';
		$show_comments 			= isset($instance['show_comments']) ? '1' : '0';


		echo $before_widget;

		global $post;
		?>

		<?php
			$recent_posts = new WP_Query(array(
				'showposts' => 1,
				'post_type' => 'post',
				'cat' => $categories,
				'category__not_in'	=> $categories_exclude
			));
		?>
			<div class="row">
			  <!-- START FIRST COLUMN -->
			  <div class="col-md-6">
				<?php
				/* Display the widget title if one was input (before and after defined by themes). */
				if( $title ) : ?>
					<div class="widget-title clearfix" style="background: <?php echo esc_attr( $background_title ); ?>">
						<h3 class="entry-title"><?php echo esc_attr( $title ); ?></h3>
						<i class="fa fa-<?php echo esc_attr( $icon_class ); ?>"></i>
					</div>
				<?php endif; ?>
			  	<div class="first-big-post">
					<?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
						<?php
							if ( has_post_format('video') ) :
								// Get Video Types
								$video_type = get_post_meta( get_the_ID(), 'ct_mb_post_video_type', true );
								$videoid = get_post_meta( get_the_ID(), 'ct_mb_post_video_file', true );
								$video_thumb = get_post_meta( get_the_ID(), 'ct_mb_post_video_thumb', true );
								?>
									<?php if ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) :
											echo '<div class="entry-video-post post-thumbnail">';
										    	if ( $video_type == 'youtube' ) {
													echo '<iframe src="http://www.youtube.com/embed/' . $videoid .'?wmode=opaque"></iframe>';
												} else if ( $video_type == 'vimeo' ) {
													echo '<iframe src="http://player.vimeo.com/video/' . $videoid . '"></iframe>';
												} else if ( $video_type == 'dailymotion' ) {
													echo '<iframe src="http://www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
												}
											echo '</div><!-- .entry-video-post -->';
										elseif ( has_post_thumbnail() ) : ?>
												<?php ct_get_featured_image(); ?>
									<?php endif;
							elseif ( has_post_format('audio') ) :
									// Get Audio Types
									$soundcloud = get_post_meta( get_the_ID() , 'ct_mb_post_soundcloud', true );
									$audio_thumb_type = get_post_meta( get_the_ID() , 'ct_mb_post_audio_thumb', true );

									if ( !empty( $soundcloud ) && ( $audio_thumb_type == '' ) ) {
										$audio_thumb_type = 'player';
									}
									?>
									    <?php if ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) : ?>
											<div class="post-thumbnail">
												<?php echo $soundcloud; ?>
											</div> <!-- .post-thumbnail -->
										<?php elseif ( has_post_thumbnail() ) : ?>
											<?php ct_get_featured_image(); ?>
										<?php endif;
							elseif ( has_post_format( 'gallery' ) ) :
								if ( has_post_thumbnail() ) {
										$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb');
										$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
									?>
									<div class="post-thumbnail">
										<a href="<?php echo esc_url( the_permalink() ); ?>">
											<div class="thumb-mask"></div>
											<img src="<?php echo esc_url( $thumb_image_url[0] ); ?>" alt="<?php the_title(); ?>" />
										</a>
									</div> <!-- .post-thumbnail -->
								<?php } else { ?>
										<?php
											global $wpdb;

											$meta = get_post_meta(get_the_ID(), 'ct_mb_gallery', false);

											if (!is_array($meta)) $meta = (array) $meta;

											if (!empty($meta)) {
												$meta = implode(',', $meta);

												$images = $wpdb->get_col("
													SELECT ID FROM $wpdb->posts
													WHERE post_type = 'attachment'
													AND ID in ($meta)
													ORDER BY menu_order ASC
												");

												$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

											} else {
												$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb');
											}

										?>
											<?php if ( !empty( $src[0] ) ) : ?>
												<div class="post-thumbnail">
													<a href="<?php echo esc_url( the_permalink() ); ?>" rel="bookmark">
														<div class="thumb-mask"></div>
														<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
													</a>
												</div> <!-- .post-thumbnail -->
											<?php endif; ?>

								<?php } ?>
							<?php
							elseif ( has_post_thumbnail() ) :
								$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-thumb'); ?>

									<div class="post-thumbnail">
										<a href='<?php the_permalink(); ?>' title='<?php the_title_attribute(); ?>'>
											<div class="thumb-mask"></div>
											<img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title_attribute(); ?>" />
										</a>
									</div><!-- .post-thumbnail -->
							<?php endif; ?>

							<?php ct_get_category( $show_first_category ); ?>

							<h3 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __('Permalink to ','color-theme-framework') ) ); ?>"><?php the_title(); ?></a>
							</h3><!-- .entry-title -->

							<?php if ( $excerpt_lenght != 0 ) : ?>
								<div class="entry-content-widget">
									<?php ct_excerpt_max_charlength($excerpt_lenght); ?>
								</div><!-- .entry-content -->
							<?php endif; ?>

							<?php ct_get_widget_meta( $show_first_date, $show_first_comments, $show_first_likes, $show_first_views, $show_first_author ); ?>

					<?php endwhile; ?>
					</div> <!-- .first-big-post -->


			  <?php
			    $recent_posts = new WP_Query(array(
				  'showposts' => $posts,
				  'post_type' => 'post',
				  'cat' => $categories,
				  'category__not_in'	=> $categories_exclude
			    ));

				$counter = 0;
			  ?>

			    <ul class="widget-two-columns-vertical ct-first-column">
				  <?php while($recent_posts->have_posts()): $recent_posts->the_post();
				    if($counter >= 1 ) { ?>

						<li class="clearfix">
							<?php
								if( $show_image ):
									if ( has_post_thumbnail() ) :
										$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small-thumb');
										 ?>
										<div class="widget-post-small-thumb">
											<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>" /></a>
										</div><!-- widget-post-small-thumb -->
									<?php endif; ?>
								<?php endif; //show_image ?>

								<div class="widget-right-content <?php if ( !has_post_thumbnail() or !$show_image ) echo 'no-left-padding'; ?>">
									<h4 class="entry-title"><a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h4>
									<?php ct_get_widget_meta( $show_date, $show_comments, $show_likes, $show_views, $show_author ); ?>
								</div> <!-- .widget-right-content -->
						</li>

					<?php
					}
				    $counter++;
					endwhile; ?>
				</ul>
			</div><!-- .col-md-6 -->

			<!-- START SECOND COLUMN -->
				<?php
					$recent_posts2 = new WP_Query(array(
						'showposts' => 1,
						'post_type' => 'post',
						'cat' => $categories2,
						'category__not_in'	=> $categories_exclude2
					));
				?>
			  <div class="col-md-6">
				<?php
				/* Display the widget title if one was input (before and after defined by themes). */
				if( $title2 ) : ?>
					<div class="widget-title clearfix" style="background: <?php echo esc_attr( $background_title2 ); ?>">
						<h3 class="entry-title"><?php echo esc_attr( $title2 ); ?></h3>
						<i class="fa fa-<?php echo esc_attr( $icon_class2 ); ?>"></i>
					</div>
				<?php endif; ?>
			  	<div class="first-big-post">
					<?php while($recent_posts2->have_posts()): $recent_posts2->the_post(); ?>
						<?php
							if ( has_post_format('video') ) :
								// Get Video Types
								$video_type = get_post_meta( get_the_ID(), 'ct_mb_post_video_type', true );
								$videoid = get_post_meta( get_the_ID(), 'ct_mb_post_video_file', true );
								$video_thumb = get_post_meta( get_the_ID(), 'ct_mb_post_video_thumb', true );
								?>
									<?php if ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) :
											echo '<div class="entry-video-post post-thumbnail">';
										    	if ( $video_type == 'youtube' ) {
													echo '<iframe src="http://www.youtube.com/embed/' . $videoid .'?wmode=opaque"></iframe>';
												} else if ( $video_type == 'vimeo' ) {
													echo '<iframe src="http://player.vimeo.com/video/' . $videoid . '"></iframe>';
												} else if ( $video_type == 'dailymotion' ) {
													echo '<iframe src="http://www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
												}
											echo '</div><!-- .entry-video-post -->';
										elseif ( has_post_thumbnail() ) : ?>
												<?php ct_get_featured_image(); ?>
									<?php endif;
							elseif ( has_post_format('audio') ) :
									// Get Audio Types
									$soundcloud = get_post_meta( get_the_ID() , 'ct_mb_post_soundcloud', true );
									$audio_thumb_type = get_post_meta( get_the_ID() , 'ct_mb_post_audio_thumb', true );

									if ( !empty( $soundcloud ) && ( $audio_thumb_type == '' ) ) {
										$audio_thumb_type = 'player';
									}
									?>
									    <?php if ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) : ?>
											<div class="post-thumbnail">
												<?php echo $soundcloud; ?>
											</div> <!-- .post-thumbnail -->
										<?php elseif ( has_post_thumbnail() ) : ?>
											<?php ct_get_featured_image(); ?>
										<?php endif;
							elseif ( has_post_format( 'gallery' ) ) :
								if ( has_post_thumbnail() ) {
										$thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb');
										$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
									?>
									<div class="post-thumbnail">
										<a href="<?php echo esc_url( the_permalink() ); ?>">
											<div class="thumb-mask"></div>
											<img src="<?php echo esc_url( $thumb_image_url[0] ); ?>" alt="<?php the_title(); ?>" />
										</a>
									</div> <!-- .post-thumbnail -->
								<?php } else { ?>
										<?php
											global $wpdb;

											$meta = get_post_meta(get_the_ID(), 'ct_mb_gallery', false);

											if (!is_array($meta)) $meta = (array) $meta;

											if (!empty($meta)) {
												$meta = implode(',', $meta);

												$images = $wpdb->get_col("
													SELECT ID FROM $wpdb->posts
													WHERE post_type = 'attachment'
													AND ID in ($meta)
													ORDER BY menu_order ASC
												");

												$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

											} else {
												$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb');
											}

										?>
											<?php if ( !empty( $src[0] ) ) : ?>
												<div class="post-thumbnail">
													<a href="<?php echo esc_url( the_permalink() ); ?>" rel="bookmark">
														<div class="thumb-mask"></div>
														<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
													</a>
												</div> <!-- .post-thumbnail -->
											<?php endif; ?>

								<?php } ?>
							<?php
							elseif ( has_post_thumbnail() ) :
								$image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'single-thumb'); ?>

									<div class="post-thumbnail">
										<a href='<?php the_permalink(); ?>' title='<?php the_title_attribute(); ?>'>
											<div class="thumb-mask"></div>
											<img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title_attribute(); ?>" />
										</a>
									</div><!-- .post-thumbnail -->
							<?php endif; ?>

							<?php ct_get_category( $show_first_category ); ?>

							<h3 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __('Permalink to ','color-theme-framework') ) ); ?>"><?php the_title(); ?></a>
							</h3><!-- .entry-title -->

							<?php if ( $excerpt_lenght != 0 ) : ?>
								<div class="entry-content-widget">
									<?php ct_excerpt_max_charlength($excerpt_lenght); ?>
								</div><!-- .entry-content -->
							<?php endif; ?>

							<?php ct_get_widget_meta( $show_first_date, $show_first_comments, $show_first_likes, $show_first_views, $show_first_author ); ?>

					<?php endwhile; ?>
					</div> <!-- .first-big-post -->


			  <?php
			    $recent_posts2 = new WP_Query(array(
				  'showposts' => $posts2,
				  'post_type' => 'post',
				  'cat' => $categories2,
				  'category__not_in'	=> $categories_exclude2
			    ));

				$counter = 0;
			  ?>

			    <ul class="widget-two-columns-vertical ct-second-column">
				  <?php while($recent_posts2->have_posts()): $recent_posts2->the_post();
				    if($counter >= 1 ) { ?>

						<li class="clearfix">
							<?php
								if( $show_image ):
									if ( has_post_thumbnail() ) :
										$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small-thumb');
										 ?>
										<div class="widget-post-small-thumb">
											<a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>" /></a>
										</div><!-- widget-post-small-thumb -->
									<?php endif; ?>
								<?php endif; //show_image ?>

								<div class="widget-right-content <?php if ( !has_post_thumbnail() or !$show_image ) echo 'no-left-padding'; ?>">
									<h4 class="entry-title"><a href='<?php the_permalink(); ?>' title='<?php _e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h4>
									<?php ct_get_widget_meta( $show_date, $show_comments, $show_likes, $show_views, $show_author ); ?>
								</div> <!-- .widget-right-content -->
						</li>

					<?php
					}
				    $counter++;
					endwhile; ?>
				</ul>
			</div><!-- .col-md-6 -->

		</div><!-- .row -->

		<?php
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		/* FIRST COLUMN */
		$instance['title'] 					= $new_instance['title'];
		$instance['icon_class'] 			= $new_instance['icon_class'];
		$instance['categories'] 			= $new_instance['categories'];
		$instance['categories_exclude'] 	= $new_instance['categories_exclude'];
		$instance['posts'] 					= $new_instance['posts'];
		$instance['excerpt_lenght'] 		= $new_instance['excerpt_lenght'];
		$instance['background_title'] 		= $new_instance['background_title'];

		/* SECOND COLUMN */
		$instance['title2'] 				= $new_instance['title2'];
		$instance['icon_class2'] 			= $new_instance['icon_class2'];
		$instance['categories2']			= $new_instance['categories2'];
		$instance['categories_exclude2']	= $new_instance['categories_exclude2'];
		$instance['posts2'] 				= $new_instance['posts2'];
		$instance['excerpt_lenght2'] 		= $new_instance['excerpt_lenght2'];
		$instance['background_title2'] 		= $new_instance['background_title2'];

		/* For the both columns */
		$instance['show_first_views'] 		= $new_instance['show_first_views'];
		$instance['show_first_likes'] 		= $new_instance['show_first_likes'];
		$instance['show_first_date'] 		= $new_instance['show_first_date'];
		$instance['show_first_author'] 		= $new_instance['show_first_author'];
		$instance['show_first_comments'] 	= $new_instance['show_first_comments'];
		$instance['show_first_category'] 	= $new_instance['show_first_category'];

		/* Meta Infromation */
		$instance['show_image'] 			= $new_instance['show_image'];
		$instance['show_views'] 			= $new_instance['show_views'];
		$instance['show_likes'] 			= $new_instance['show_likes'];
		$instance['show_date'] 				= $new_instance['show_date'];
		$instance['show_comments'] 			= $new_instance['show_comments'];
		$instance['show_author'] 			= $new_instance['show_author'];

		return $instance;
	}


	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance)
	{
		$defaults = array(
							'title' 					=> esc_html__( 'First Column' , 'color-theme-framework' ),
							'icon_class' 				=> 'picture-o',
							'categories' 				=> 'all',
							'posts' 					=> 3,
							'excerpt_lenght'			=> '100',
							'show_first_views'			=> 'off',
							'show_first_likes'			=> 'off',
							'show_first_date'			=> 'on',
							'show_first_author'			=> 'off',
							'show_first_comments'		=> 'on',
							'show_first_category'		=> 'on',
							'categories_exclude' 		=> '',
							'background_title'			=> '#222b31',

							'title2' 					=> esc_html__( 'Second Column' , 'color-theme-framework' ),
							'icon_class2' 				=> 'picture-o',
							'categories2' 				=> 'all',
							'posts2' 					=> 3,
							'excerpt_lenght2'			=> '100',
							'categories_exclude2' 		=> '',
							'background_title2'			=> '#222b31',

							'show_image'				=> 'on',
							'show_views'				=> 'off',
							'show_likes'				=> 'off',
							'show_date'					=> 'on',
							'show_comments'				=> 'on',
							'show_author'				=> 'off',
						);

		$instance = wp_parse_args((array) $instance, $defaults);
		$categories_exclude 	= $instance['categories_exclude'];
		$categories_exclude2 	= $instance['categories_exclude2'];
		$background_title 		= esc_attr($instance['background_title']);
		$background_title2 		= esc_attr($instance['background_title2']);
	?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($) {
				$('.ct-color-picker').wpColorPicker();
				$('.ct-color-picker2').wpColorPicker();
			});
			//]]>
		</script>

		<!-- First Column -->
		<p style="margin-top: 20px;">
			<label style="font-weight: bold; text-transform: uppercase; color: #F05B4F;"><?php esc_html_e( 'Settings for the First Column' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" type="text" style="width: 100%" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank"><?php esc_html_e( 'All Icons', 'color-theme-framework' ); ?></a></label>
			<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php esc_html_e( 'Filter by Category:' , 'color-theme-framework' ); ?></label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ( 'all' == $instance['categories'] ) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
				<?php foreach( $categories as $category ) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories_exclude'); ?>"><?php esc_html_e( 'Categories to exclude:' , 'color-theme-framework' ); ?></label>
			<select size="5" multiple="multiple" id="<?php echo $this->get_field_id('categories_exclude'); ?>" name="<?php echo $this->get_field_name('categories_exclude'); ?>[]" class="widefat" style="width:100%;">
				<?php $cat = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($cat as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ( is_array( $categories_exclude ) && in_array( $category->term_id, $categories_exclude ) ) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php esc_html_e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="0" max="999" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo esc_attr( $instance['posts'] ); ?>" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php esc_html_e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo $instance['excerpt_lenght']; ?>" />
		</p>

		<!-- for first post -->
		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php esc_html_e( 'Post meta info for the first post (for the two columns)' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_first_category'], 'on'); ?> id="<?php echo $this->get_field_id('show_first_category'); ?>" name="<?php echo $this->get_field_name('show_first_category'); ?>" />
			<label for="<?php echo $this->get_field_id('show_first_category'); ?>"><?php esc_html_e( 'Show category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_first_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_first_date'); ?>" name="<?php echo $this->get_field_name('show_first_date'); ?>" />
			<label for="<?php echo $this->get_field_id('show_first_date'); ?>"><?php esc_html_e( 'Show date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_first_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_first_comments'); ?>" name="<?php echo $this->get_field_name('show_first_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('show_first_comments'); ?>"><?php esc_html_e( 'Show comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_first_author'], 'on'); ?> id="<?php echo $this->get_field_id('show_first_author'); ?>" name="<?php echo $this->get_field_name('show_first_author'); ?>" />
			<label for="<?php echo $this->get_field_id('show_first_author'); ?>"><?php esc_html_e( 'Show author' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_first_views'], 'on'); ?> id="<?php echo $this->get_field_id('show_first_views'); ?>" name="<?php echo $this->get_field_name('show_first_views'); ?>" />
			<label for="<?php echo $this->get_field_id('show_first_views'); ?>"><?php esc_html_e( 'Show views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_first_likes'], 'on'); ?> id="<?php echo $this->get_field_id('show_first_likes'); ?>" name="<?php echo $this->get_field_name('show_first_likes'); ?>" />
			<label for="<?php echo $this->get_field_id('show_first_likes'); ?>"><?php esc_html_e( 'Show likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
			<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
		</p>

		<!-- START SECOND COLUMN -->
		<p style="margin-top: 20px;">
			<label style="font-weight: bold; text-transform: uppercase; color: #F05B4F;"><?php esc_html_e( 'Settings for the Second Column' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('title2'); ?>"><?php esc_html_e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" type="text" style="width: 100%" id="<?php echo $this->get_field_id('title2'); ?>" name="<?php echo $this->get_field_name('title2'); ?>" value="<?php echo esc_attr( $instance['title2'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('icon_class2'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank"><?php esc_html_e( 'All Icons', 'color-theme-framework' ); ?></a></label>
			<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class2'); ?>" name="<?php echo $this->get_field_name('icon_class2'); ?>" value="<?php echo esc_attr( $instance['icon_class2'] ); ?>" />
		</p>


		<p>
			<label for="<?php echo $this->get_field_id('categories2'); ?>"><?php esc_html_e( 'Filter by Category:' , 'color-theme-framework' ); ?></label>
			<select id="<?php echo $this->get_field_id('categories2'); ?>" name="<?php echo $this->get_field_name('categories2'); ?>" class="widefat categories" style="width:100%;">
				<option value='all' <?php if ( 'all' == $instance['categories2'] ) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories2 = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
				<?php foreach( $categories2 as $category ) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories2']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories_exclude2'); ?>"><?php esc_html_e( 'Categories to exclude:' , 'color-theme-framework' ); ?></label>
			<select size="5" multiple="multiple" id="<?php echo $this->get_field_id('categories_exclude2'); ?>" name="<?php echo $this->get_field_name('categories_exclude2'); ?>[]" class="widefat" style="width:100%;">
				<?php $cat2 = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($cat2 as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ( is_array( $categories_exclude2 ) && in_array( $category->term_id, $categories_exclude2 ) ) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts2'); ?>"><?php esc_html_e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="0" max="999" class="widefat" id="<?php echo $this->get_field_id('posts2'); ?>" name="<?php echo $this->get_field_name('posts2'); ?>" value="<?php echo esc_attr( $instance['posts2'] ); ?>" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght2'); ?>"><?php esc_html_e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght2'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght2'); ?>" value="<?php echo esc_attr( $instance['excerpt_lenght2'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('background_title2'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
			<input class="ct-color-picker2" type="text" id="<?php echo $this->get_field_id( 'background_title2' ); ?>" name="<?php echo $this->get_field_name( 'background_title2' ); ?>" value="<?php echo esc_attr( $instance['background_title2'] ); ?>" data-default-color="#222b31" />
		</p>

		<!-- for list -->
		<p style="margin-top: 20px;">
			<label style="font-weight: bold; text-transform: uppercase; color: #F05B4F;"><?php esc_html_e( 'Meta information for the lists of posts (the both columns)' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" />
			<label for="<?php echo $this->get_field_id('show_image'); ?>"><?php esc_html_e( 'Show thumbnail images for the List' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php esc_html_e( 'Show date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php esc_html_e( 'Show comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_author'], 'on'); ?> id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" />
			<label for="<?php echo $this->get_field_id('show_author'); ?>"><?php esc_html_e( 'Show author' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views'], 'on'); ?> id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" />
			<label for="<?php echo $this->get_field_id('show_views'); ?>"><?php esc_html_e( 'Show views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes'); ?>" name="<?php echo $this->get_field_name('show_likes'); ?>" />
			<label for="<?php echo $this->get_field_id('show_likes'); ?>"><?php esc_html_e( 'Show likes' , 'color-theme-framework' ); ?></label>
		</p>

	<?php }
}
?>