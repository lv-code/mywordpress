<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Blog Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show recent posts as Blog.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','ct_blog_widget');


function ct_blog_widget(){
		register_widget("CT_Blog_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Blog_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */
	function CT_Blog_Widget(){

		/* Widget settings. */
		$widget_ops = array(	'classname'		=> 'ct-blog-widget',
								'description'	=> esc_html__( 'Blog Widget' , 'color-theme-framework' )
						);

		/* Create the widget. */
		parent::__construct( 'ct-blog-widget', esc_html__( 'CT: Blog Widget' , 'color-theme-framework' ) ,  $widget_ops );

	}

	function widget($args,$instance){
		extract($args);

		global $ct_options, $post, $wp_query, $query, $paged, $wpdb;

		$ct_num_blog_posts = $instance['ct_num_blog_posts'];

		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$pagination_type 	= $instance['pagination_type'];
		$blog_type 			= $instance['blog_type'];
		$type_of_content 	= $instance['type_of_content'];
		$categories 		= $instance['categories'];
		$categories_exclude = $instance['categories_exclude'];
		$show_share 		= isset($instance['show_share']) ? '1' : '0';
		$show_category 		= isset($instance['show_category']) ? '1' : '0';
		$show_date 			= isset($instance['show_date']) ? '1' : '0';
		$show_likes 		= isset($instance['show_likes']) ? '1' : '0';
		$show_views 		= isset($instance['show_views']) ? '1' : '0';
		$show_author 		= isset($instance['show_author']) ? '1' : '0';
		$show_comments 		= isset($instance['show_comments']) ? '1' : '0';
		$show_readmore 		= isset($instance['show_readmore']) ? '1' : '0';
		$excerpt_lenght 	= $instance['excerpt_lenght'];
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#222b31';

		// Get number of posts to display from Theme Options
		isset( $ct_options['blog_num_posts'] ) ? $blog_num_posts = $ct_options['blog_num_posts'] : $blog_num_posts = 3;

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if( $title ) : ?>
			<div class="widget-title clearfix" style="background: <?php echo esc_attr( $background_title ); ?>">
				<h3 class="entry-title"><?php echo esc_attr( $title ); ?></h3>
				<i class="fa fa-<?php echo esc_attr( $icon_class ); ?>"></i>
			</div>
		<?php endif; ?>

		<?php

		if ( ! function_exists( 'ct_posts_per_page' ) ) {
		    function ct_posts_per_page( $query ) {
		        global $ct_options;

				isset( $ct_options['blog_num_posts'] ) ? $blog_num_posts = $ct_options['blog_num_posts'] : $blog_num_posts = 3;

		        if ( $query->is_home() && $query->is_main_query() && !is_admin() ) {
		            $query->set( 'posts_per_page', $blog_num_posts );
		        }
		        return $query;
		    }

		    add_filter( 'pre_get_posts', 'ct_posts_per_page' );
		}

		if ( get_query_var('paged') ) {
      		$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
	  		$paged = get_query_var('page');
		} else {
	  		$paged = 1;
		}

		$recent_posts = new WP_Query(array(	'posts_per_page'		=> $blog_num_posts,
											'paged'					=> $paged,
											'post_type'				=> 'post',
											'post_status'			=> 'publish',
											'cat'					=> $categories,
											'category__not_in'		=> $categories_exclude,
											'ignore_sticky_posts'	=> 1
									));

		$max = 0;

		$ct_post_count = $recent_posts->found_posts;
		$max = ceil ($ct_post_count / $blog_num_posts);


		if ( !function_exists( 'ct_blog_pagination' ) ) {
    		function ct_blog_pagination($pages = '', $range = 2)
    		{
        		$showitems = ($range * 2)+1;

		        global $paged;
		        if(empty($paged)) $paged = 1;

		        if($pages == '')
			    {
		            global $wp_query;
            		$pages = $wp_query->max_num_pages;
            		if(!$pages)
            		{
                		$pages = 1;
            		}
        		}

				if(1 != $pages) {
					echo "<div class=\"pagination clearfix\" role=\"navigation\"><span>".__('Page ','color-theme-framework').$paged." ".__('of','color-theme-framework')." ".$pages."</span>";

					if (is_rtl()) {
						if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><i class=\"icon-double-angle-right\"></i> ".__('First','color-theme-framework')."</a>";
					} else {
						if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'><i class=\"icon-double-angle-left\"></i> ".__('First','color-theme-framework')."</a>";
					}


					if (is_rtl()) {
						if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'><i class=\"icon-angle-right\"></i> ".__('Previous','color-theme-framework')."</a>";
					} else {
						if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'><i class=\"icon-angle-left\"></i> ".__('Previous','color-theme-framework')."</a>";
					}

					for ($i=1; $i <= $pages; $i++)
					{
						if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
						{
							echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
						}
					}

					if (is_rtl()) {
						if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">".__('Next','color-theme-framework')." <i class=\"icon-angle-left\"></i></a>";
					} else {
						if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">".__('Next','color-theme-framework')." <i class=\"icon-angle-right\"></i></a>";
					}

					if (is_rtl()) {
						if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__('Last','color-theme-framework')." <i class=\"icon-double-angle-left\"></i></a>";
					} else {
						if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>".__('Last','color-theme-framework')." <i class=\"icon-double-angle-right\"></i></a>";
					}

					echo "</div>\n";
				}
    		}
		}

		if ( $pagination_type == 'load_more' ) :
			wp_enqueue_script(
					'pbd-alp-load-posts',
					get_template_directory_uri() . '/js/load-posts.js',
					array('jquery'),
					'1.0',
					true
			);

 			// Add some parameters for the JS.
 			wp_localize_script(
	 			'pbd-alp-load-posts',
 				'pbd_alp',
 				array(
	 				'startPage' => $paged,
 					'maxPages' => $max,
 					'nextLink' => next_posts($max, false)
 				)
 			);

 			/* Localization JS */
    		$ct_blog_array = array(	'show_more'			=> esc_html__('Show More Posts', 'color-theme-framework'),
									'loading_posts' 	=> esc_html__('Loading Posts...', 'color-theme-framework'),
									'no_posts' 			=> esc_html__('No More Posts to Show', 'color-theme-framework'),
									'blog_type'			=> 'widget'
							);
			wp_localize_script( 'pbd-alp-load-posts', 'ct_blog_localization', $ct_blog_array );
		endif;
		?>


		<!-- START #ENTRY-BLOG -->
		<div id="blog-entry" class="clearfix">

		<?php if ( $recent_posts->have_posts() ) : while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-post clearfix" ); ?> itemscope itemtype="http://schema.org/BlogPosting">
				<div class="row">
					<?php
						// Get Video Types
						$video_type = get_post_meta( get_the_ID(), 'ct_mb_post_video_type', true );
						$videoid = get_post_meta( get_the_ID(), 'ct_mb_post_video_file', true );
						$video_thumb = get_post_meta( get_the_ID(), 'ct_mb_post_video_thumb', true );

						// Get Audio Types
						$soundcloud = get_post_meta( $post->ID, 'ct_mb_post_soundcloud', true );
						$audio_thumb_type = get_post_meta( $post->ID, 'ct_mb_post_audio_thumb', true );

						if ( !empty( $soundcloud ) && ( $audio_thumb_type == '' ) ) {
							$audio_thumb_type = 'player';
						}

						// Get Gallery Images
						$time_id = rand();
						$meta = get_post_meta( get_the_ID(), 'ct_mb_gallery', false);

						if (!is_array($meta)) $meta = (array) $meta;
					?>
					<?php
					// Two Columns Blog
					if ( $blog_type == 'two_columns' ) : ?>

						<?php if ( has_post_format('video') ) :
								ct_get_widget_video();
							elseif ( has_post_format('audio') ) :
								ct_get_widget_audio();
							elseif ( has_post_format('gallery') ) :
								ct_get_widget_gallery();
							else :
								if ( has_post_thumbnail() ) : ?>
									<div class="col-md-6">
										<?php ct_get_featured_image(); ?>
									</div> <!-- .col-md-6 -->
								<?php endif; ?>
						<?php endif; ?>

						<?php if ( has_post_format( 'video' ) ) : ?>
							<div class="<?php if ( has_post_thumbnail() or ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
						<?php elseif ( has_post_format( 'audio' ) ) : ?>
							<div class="<?php if ( has_post_thumbnail() or ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
						<?php elseif ( has_post_format( 'gallery' ) ) : ?>
							<div class="<?php if ( !empty( $meta ) or has_post_thumbnail() ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
						<?php else : ?>
							<div class="<?php if ( has_post_thumbnail() ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
						<?php endif; ?>
							<div class="entry-content">
								<?php if ( $show_category ) :
										$category = get_the_category();

										if ( !empty( $category[0]->cat_name ) ) {
											$category_id = get_cat_ID( $category[0]->cat_name );
											$category_link = get_category_link( $category_id );

											$category_bg = get_option("category_$category_id");
											if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';

											$postsInCat = get_term_by('name',$category[0]->cat_name,'category');

											echo '<span class="ct-post-category">';
												echo '<a href="' . esc_url( $category_link ) . '" style="color: '.$category_bg['category_color'].'">' . $category[0]->cat_name . '</a>';
											echo '</span>';
										}
									endif;
								?>
								<h3 class="entry-title"><a href='<?php echo esc_url( the_permalink() ); ?>'><?php the_title(); ?></a></h3>
								<?php
									if ( $type_of_content == 'excerpt' ) {
										ct_excerpt_max_charlength( $excerpt_lenght );
									} elseif ( $type_of_content == 'content')
										{ the_content( '' , FALSE, '' ); }
								?>

								<?php $vote_count = get_post_meta( get_the_ID() , "votes_count", true); ?>

								<?php if ( ($show_comments and comments_open() and ( get_comments_number() != 0 ) ) or ($show_likes and !empty( $vote_count ) ) or $show_date or $show_author or $show_views ) : ?>
								<div class="bottom-content">
									<ul class="bottom-meta clearfix">
										<?php if ( $show_date ) : ?>
											<li>
												<span class="entry-date">
													<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php echo the_time( get_option('date_format') ); ?></a>
												</span> <!-- .entry-date -->
											</li>
										<?php endif; ?>

										<?php if ( $show_author ) : ?>
											<?php
												$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">by %3$s</a></span>',
													esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
													esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
													get_the_author(),
													''
												);
											?>

											<li class="meta-author">
												<?php printf( $author ); ?>
											</li><!-- .meta-author -->
										<?php endif; ?>

										<?php if ( $show_comments and comments_open() and ( get_comments_number() != 0 ) ) : ?>
											<li><?php ct_get_comments(); ?></li>
										<?php endif; ?>

										<?php if ( $show_likes and !empty( $vote_count ) ) : ?>
											<li><?php getLikeCount( get_the_ID() ); ?>
											</li>
										<?php endif; ?>

										<?php if ( $show_views ) : ?>
											<li><?php echo ct_getPostViews( get_the_ID() ); ?></li>
										<?php endif; ?>
									</ul> <!-- .bottom-meta -->
								</div> <!-- .bottom-content -->
								<?php endif; ?>

								<?php if ( $show_readmore ) : ?>
									<?php isset( $ct_options['readmore_text'] ) ? $readmore_text = $ct_options['readmore_text'] : $readmore_text = esc_html__('Continue Reading', 'color-theme-framework' ); ?>
										<a class="more-post-link" href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( sprintf( __( 'Continue reading', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo esc_html( $readmore_text ); ?></a>
								<?php endif; ?>

								<?php ct_get_edit_link(); ?>
							</div> <!-- .entry-content -->
						</div> <!-- .col-md-* -->


					<?php
						// Full Width Blog
						else : ?>
							<?php if ( has_post_format('video') ) : ?>
									<?php if ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) :
											echo '<div class="col-md-12">';
												echo '<div class="entry-video-post post-thumbnail">';
											    	if ( $video_type == 'youtube' ) {
														echo '<iframe src="http://www.youtube.com/embed/' . $videoid .'?wmode=opaque"></iframe>';
													} else if ( $video_type == 'vimeo' ) {
														echo '<iframe src="http://player.vimeo.com/video/' . $videoid . '"></iframe>';
													} else if ( $video_type == 'dailymotion' ) {
														echo '<iframe src="http://www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
													}
												echo '</div><!-- .entry-video-post -->';
											echo '</div> <!-- .col-md-12 -->';
										elseif ( has_post_thumbnail() ) : ?>
											<div class="col-md-12">
												<?php ct_get_featured_image(); ?>
											</div> <!-- .col-md-12 -->
									<?php endif; ?>

							<?php elseif ( has_post_format('audio') ) : ?>
							    <?php if ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) : ?>
							    	<div class="col-md-12">
										<div class="post-thumbnail">
											<?php echo $soundcloud; ?>
										</div> <!-- .post-thumbnail -->
									</div> <!-- .col-md-12 -->
								<?php elseif ( has_post_thumbnail() ) : ?>
										<div class="col-md-12">
											<?php ct_get_featured_image(); ?>
										</div> <!-- .col-md-12 -->
								<?php endif; ?>

							<?php elseif ( has_post_format('gallery') ) : ?>
								<?php
								if ( !empty( $meta ) and !has_post_thumbnail() ) : ?>
									<div class="col-md-12">
										<figure class="post-thumbnail">
											<?php
												$meta = implode(',', $meta);
												$order_key = 'attachment';

												$images = $wpdb->get_col( $wpdb->prepare( "
													SELECT ID FROM $wpdb->posts
													WHERE post_type = %s
													AND ID in ($meta)
													ORDER BY menu_order ASC
												", $order_key ) );
													$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

											?>
											<a href="<?php echo esc_url( the_permalink() ); ?>">
												<?php ct_get_post_format(); ?>
												<div class="thumb-mask"></div>
												<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
											</a>
										</figure> <!-- .post-thumbnail -->
									</div> <!-- .col-md-12 -->
								<?php else : ?>
									<div class="col-md-12">
										<?php ct_get_featured_image(); ?>
									</div> <!-- .col-md-6 -->
								<?php endif; ?>

							<?php else : ?>
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="col-md-12">
										<?php ct_get_featured_image(); ?>
									</div> <!-- .col-md-12 -->
								<?php endif; ?>
							<?php endif; ?>
								<div class="col-md-12">
									<div class="entry-content">
										<?php if ( $show_category ) :
												$category = get_the_category();

												if ( !empty( $category[0]->cat_name ) ) {
													$category_id = get_cat_ID( $category[0]->cat_name );
													$category_link = get_category_link( $category_id );

													$category_bg = get_option("category_$category_id");
													if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';

													$postsInCat = get_term_by('name',$category[0]->cat_name,'category');

													echo '<span class="ct-post-category">';
														echo '<a href="' . esc_url( $category_link ) . '" style="color: '.$category_bg['category_color'].'">' . $category[0]->cat_name . '</a>';
													echo '</span>';
												}
											endif;
										?>
										<h3 class="entry-title"><a href='<?php echo esc_url( the_permalink() ); ?>'><?php the_title(); ?></a></h3>
										<?php
											if ( $type_of_content == 'excerpt' ) {
												ct_excerpt_max_charlength( $excerpt_lenght );
											} elseif ( $type_of_content == 'content')
												{ the_content( '' , FALSE, '' ); }
										?>

										<?php $vote_count = get_post_meta( get_the_ID() , "votes_count", true); ?>

										<?php if ( ($show_comments and comments_open() and ( get_comments_number() != 0 ) ) or ($show_likes and !empty( $vote_count ) ) or $show_date or $show_author or $show_views ) : ?>
										<div class="bottom-content">
											<ul class="bottom-meta clearfix">
												<?php if ( $show_date ) : ?>
													<li>
														<span class="entry-date">
															<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php echo the_time( get_option('date_format') ); ?></a>
														</span> <!-- .entry-date -->
													</li>
												<?php endif; ?>

												<?php if ( $show_author ) : ?>
													<?php
														$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">by %3$s</a></span>',
															esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
															esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
															get_the_author(),
															''
														);
													?>

													<li class="meta-author">
														<?php printf( $author ); ?>
													</li><!-- .meta-author -->
												<?php endif; ?>

												<?php if ( $show_comments and comments_open() and ( get_comments_number() != 0 ) ) : ?>
													<li><?php ct_get_comments(); ?></li>
												<?php endif; ?>

												<?php if ( $show_likes and !empty( $vote_count ) ) : ?>
													<li><?php getLikeCount( get_the_ID() ); ?>
													</li>
												<?php endif; ?>

												<?php if ( $show_views ) : ?>
													<li><?php echo ct_getPostViews( get_the_ID() ); ?></li>
												<?php endif; ?>
											</ul> <!-- .bottom-meta -->
										</div> <!-- .bottom-content -->
										<?php endif; ?>

										<?php if ( $show_readmore ) : ?>
											<?php isset( $ct_options['readmore_text'] ) ? $readmore_text = $ct_options['readmore_text'] : $readmore_text = esc_html__('Continue Reading', 'color-theme-framework' ); ?>
												<a class="more-post-link" href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( sprintf( __( 'Continue reading', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo esc_html( $readmore_text ); ?></a>
										<?php endif; ?>

										<?php ct_get_edit_link(); ?>
									</div> <!-- .entry-content -->
								</div> <!-- .col-md-12 -->
					<?php endif; ?>

				</div> <!-- .row -->
			</article>
		<?php endwhile; endif; ?>
	    <!-- Begin Navigation -->
			<?php if ( $max > 1 ) : ?>
			  <div class="blog-navigation clearfix" role="navigation">
				<?php if(function_exists('ct_blog_pagination')) { ct_blog_pagination($max); } ?>
			  </div> <!-- blog-navigation -->
			<?php endif; ?>
			<!-- End Navigation -->
		</div><!-- .blog-entry -->

		<?php echo $after_widget;

		// Restor original Query & Post Data
		wp_reset_postdata();
	?>

<?php }

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['ct_num_blog_posts'] 	= $new_instance['ct_num_blog_posts'];
		$instance['categories'] 		= $new_instance['categories'];
		$instance['categories_exclude']	= $new_instance['categories_exclude'];
		$instance['title'] 				= $new_instance['title'];
		$instance['icon_class'] 		= $new_instance['icon_class'];
		$instance['pagination_type'] 	= $new_instance['pagination_type'];
		$instance['blog_type'] 			= $new_instance['blog_type'];
		$instance['type_of_content'] 	= $new_instance['type_of_content'];
		$instance['show_category'] 		= $new_instance['show_category'];
		$instance['show_date'] 			= $new_instance['show_date'];
		$instance['show_likes'] 		= $new_instance['show_likes'];
		$instance['show_views'] 		= $new_instance['show_views'];
		$instance['show_author'] 		= $new_instance['show_author'];
		$instance['show_comments'] 		= $new_instance['show_comments'];
		$instance['show_readmore'] 		= $new_instance['show_readmore'];
		$instance['show_excerpt'] 		= $new_instance['show_excerpt'];
		$instance['excerpt_lenght'] 	= $new_instance['excerpt_lenght'];
		$instance['background_title'] 	= $new_instance['background_title'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance){

		global $ct_options;

		isset( $ct_options['blog_num_posts'] ) ? $blog_num_posts = $ct_options['blog_num_posts'] : $blog_num_posts = 3;

		$defaults = array(	'title'					=> esc_html__( 'Latest Posts', 'color-theme-framework' ),
							'categories'			=> 'all',
							'categories_exclude'	=> '',
							'icon_class' 			=> 'picture-o',
							'ct_num_blog_posts'		=> $blog_num_posts,
							'pagination_type'		=> 'load_more',
							'blog_type'				=> 'full_width',
							'type_of_content'		=> 'excerpt',
							'show_date' 			=> 'on',
							'show_likes' 			=> 'off',
							'show_views'			=> 'off',
							'show_author' 			=> 'off',
							'show_comments' 		=> 'on',
							'show_category' 		=> 'on',
							'show_readmore'			=> 'off',
							'excerpt_lenght'		=> '120',
							'background_title'		=> '#222b31'
						);

		$instance = wp_parse_args((array) $instance, $defaults);
		$categories_exclude = $instance['categories_exclude'];
		$background_title = esc_attr($instance['background_title']);
		?>

		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function($) {
				$('.ct-color-picker').wpColorPicker();
			});
			//]]>
		</script>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:' , 'color-theme-framework' ) ?></label>
			<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank">All Icons</a></label>
			<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'blog_type' ); ?>"><?php esc_html_e('Type of the blog:', 'color-theme-framework'); ?></label>
			<select id="<?php echo $this->get_field_id( 'blog_type' ); ?>" name="<?php echo $this->get_field_name( 'blog_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'full_width' == $instance['blog_type'] ) echo 'selected="selected"'; ?>>full_width</option>
				<option <?php if ( 'two_columns' == $instance['blog_type'] ) echo 'selected="selected"'; ?>>two_columns</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'type_of_content' ); ?>"><?php esc_html_e('Type of content:', 'color-theme-framework'); ?></label>
			<select id="<?php echo $this->get_field_id( 'type_of_content' ); ?>" name="<?php echo $this->get_field_name( 'type_of_content' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'excerpt' == $instance['type_of_content'] ) echo 'selected="selected"'; ?>>excerpt</option>
				<option <?php if ( 'content' == $instance['type_of_content'] ) echo 'selected="selected"'; ?>>content</option>
				<option <?php if ( 'none' == $instance['type_of_content'] ) echo 'selected="selected"'; ?>>none</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php esc_html_e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo esc_attr( $instance['excerpt_lenght'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'pagination_type' ); ?>"><?php esc_html_e('Type of Pagination:', 'color-theme-framework'); ?></label>
			<select id="<?php echo $this->get_field_id( 'pagination_type' ); ?>" name="<?php echo $this->get_field_name( 'pagination_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'load_more' == $instance['pagination_type'] ) echo 'selected="selected"'; ?>>load_more</option>
				<option <?php if ( 'standard_numeric' == $instance['pagination_type'] ) echo 'selected="selected"'; ?>>standard_numeric</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('ct_num_blog_posts'); ?>"><?php esc_html_e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<br/><em><?php esc_html_e( 'Specified in the Theme Options -> Blog Options (Number of posts for displaying in the Blog Widget)','color-theme-framework' ); ?></em>
			<input disabled type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('ct_num_blog_posts'); ?>" name="<?php echo $this->get_field_name('ct_num_blog_posts'); ?>" value="<?php echo esc_attr( $blog_num_posts ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php esc_html_e( 'Filter by Category:' , 'color-theme-framework' ); ?></label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
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


		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php esc_html_e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_category'], 'on'); ?> id="<?php echo $this->get_field_id('show_category'); ?>" name="<?php echo $this->get_field_name('show_category'); ?>" />
			<label for="<?php echo $this->get_field_id('show_category'); ?>"><?php esc_html_e( 'Show Category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php esc_html_e( 'Show Date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes'); ?>" name="<?php echo $this->get_field_name('show_likes'); ?>" />
			<label for="<?php echo $this->get_field_id('show_likes'); ?>"><?php esc_html_e( 'Show Likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views'], 'on'); ?> id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" />
			<label for="<?php echo $this->get_field_id('show_views'); ?>"><?php esc_html_e( 'Show Views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_author'], 'on'); ?> id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" />
			<label for="<?php echo $this->get_field_id('show_author'); ?>"><?php esc_html_e( 'Show Author' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php esc_html_e( 'Show Comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_readmore'], 'on'); ?> id="<?php echo $this->get_field_id('show_readmore'); ?>" name="<?php echo $this->get_field_name('show_readmore'); ?>" />
			<label for="<?php echo $this->get_field_id('show_readmore'); ?>"><?php esc_html_e( 'Show read more' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
			<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
		</p>
		<?php

	}
}
?>