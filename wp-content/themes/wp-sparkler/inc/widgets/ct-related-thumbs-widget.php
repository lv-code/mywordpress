<?php
/*
-----------------------------------------------------------------------------------

	Plugin Name: CT Related Posts Widget
	Plugin URI: http://www.color-theme.com
	Description: A widget that show Related posts by tags or category ).
	Version: 1.0
	Author: ZERGE
	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'ct_related_thumbs_widget' );

function ct_related_thumbs_widget() {
	register_widget( 'CT_Related_Thumbs' );
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Related_Thumbs extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function  CT_Related_Thumbs() {
		/* Widget settings. */
		$widget_ops = array(	'classname'		=> 'ct-related-thumbs-widget',
								'description'	=> esc_html__( 'A widget that show related posts by tags or category' , 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct-related-thumbs-widget', esc_html__('CT: Related Posts Widget', 'color-theme-framework'), $widget_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		global $post, $wpbd;
		$time_id = rand();

		/* Our variables from the widget settings. */
		$title 				= apply_filters ('widget_title', $instance ['title']);
		$num_posts			= ! empty ( $instance['num_posts'] ) ? $instance['num_posts'] : '5';
		$num_query_posts	= ! empty ( $instance['num_query_posts'] ) ? $instance['num_query_posts'] : '10';
		$show_random 		= isset($instance['show_random']) ? 'true' : 'false';
		$posts_by 			= $instance['posts_by'];
		$show_date 			= isset($instance['show_date']) ? '1' : '0';
		$show_comments 		= isset($instance['show_comments']) ? '1' : '0';
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#222b31';

		$is_have_posts = 0;

		/* Before widget (defined by themes). */
		echo $before_widget;

		?>
			<div class="widget-title clearfix" style="background: <?php echo esc_attr( $background_title ); ?>">
				<?php if ( $title ) : ?>
					<h3 class="entry-title"><?php echo esc_attr( $title ); ?></h3>
				<?php endif; ?>
				<div class="prev-related-slide"><i class="fa fa-chevron-left"></i></div>
				<div class="next-related-slide"><i class="fa fa-chevron-right"></i></div>
			</div> <!-- .carousel-header -->
		<?php
			/* Flex Slider */
			wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
			wp_enqueue_script('flex-min-jquery',array('jquery'));
		?>

		<?php
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
			$(document).ready(function() {
			$('.next-related-slide').click( function() {
				$('#carousel-<?php echo $time_id; ?>').flexslider('next');
			});

			$('.prev-related-slide').click( function() {
				$('#carousel-<?php echo $time_id; ?>').flexslider('prev');
			});

			$('#carousel-<?php echo $time_id; ?>').flexslider({
			    animation: "slide",
			    animationLoop: true,
			    slideshow: 'slide',
				controlNav: false,
				smoothHeight: true,
				directionNav: false,
				itemWidth: 280,
				itemMargin: 20,
				minItems: 2,
				maxItems: 4,
				prevText: "",
				nextText: "",
				rtl: <?php echo esc_js( $rtl ); ?>
			});

		});
		});
		/* ]]> */
		</script>

		<?php
			$orderby = 'date';
			if ( $show_random == 'true' ) { $orderby = 'rand'; }

		// show related posts by tags
		if ( $posts_by == 'tags') :
			$tags = get_the_tags();

			if( $tags):
				$related_posts = ct_get_related_posts( $post->ID, $tags, $num_query_posts, $orderby); ?>

				<?php if ( $related_posts->have_posts() ) : ?>
					<div id="carousel-<?php echo $time_id; ?>" class="flexslider flex-carousel clearfix">
						<ul class="slides ct-related-posts-widget related-posts-widget-<?php echo esc_attr( $time_id ); ?> clearfix">
							<?php $num_post = 0; ?>
							<?php while($related_posts->have_posts()): $related_posts->the_post(); ?>
							    <li>
							    	<article class="ct-related-posts clearfix">
											<?php if(has_post_thumbnail()): $num_post++; $is_have_posts++; ?>
													<?php $carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'related-thumb'); ?>
													<div class="related-thumb">
														<div class="post-thumbnail">
										          			<a href="<?php the_permalink(); ?>">
										          				<?php ct_get_post_format_video(); ?>
										          				<div class="thumb-mask"></div>
										          				<img src="<?php echo esc_url( $carousel_image_url[0] ); ?>" alt="<?php the_title(); ?>" />
										          			</a>
										          		</div> <!-- .post-thumbnail -->
										          	</div> <!-- .related-thumb -->
									        <?php endif; ?>

									        <div class="content-box">
												<h3 class="entry-title"><a href='<?php the_permalink(); ?>' title='<?php esc_html_e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h3>
												<?php ct_get_widget_meta( $show_date, $show_comments, false, false, false ); ?>
											</div>
									</article>
							    </li>

								<?php if ( $num_post == $num_posts ) : break; endif; ?>
							<?php endwhile;

							if ( $is_have_posts == 0 ) {
								echo '<div class="no-related-posts">';
								echo esc_html__('No related posts were found','color-theme-framework');
								echo '</div>';
							} ?>
						</ul> <!-- .slides -->
					</div> <!-- .flexslider -->
				<?php else :
					echo '<div class="no-related-posts">';
					echo esc_html__('No related posts were found','color-theme-framework');
					echo '</div>';
				endif; ?>
			<?php
			else :
				echo '<div class="no-related-posts">';
				echo esc_html__('No related posts were found','color-theme-framework');
				echo '</div>';
			endif;

		// else, show related posts by category
		else :
			if ( is_category() ) :
				$current_category = single_cat_title('', false);
				$related_category_id = get_cat_ID($current_category);
			else :
				foreach((get_the_category($post->ID)) as $category) {
					$related_category_id[] = $category->cat_ID;
				}
			endif;
			$related_posts = new WP_Query(array(	'orderby'				=> $orderby,
													'showposts'				=> $num_query_posts,
													'post_type'				=> 'post',
													'category__in'			=> $related_category_id,
													'ignore_sticky_posts'	=> 1,
													'post__not_in'			=> array( $post->ID )
												));

			if ($related_posts->have_posts()) : ?>
					<div id="carousel-<?php echo $time_id; ?>" class="flexslider flex-carousel clearfix">
						<ul class="slides ct-related-posts-widget related-posts-widget-<?php echo esc_attr( $time_id ); ?> clearfix">
							<?php $num_post = 0; ?>
							<?php while($related_posts->have_posts()): $related_posts->the_post(); ?>
							    <li>
							    	<article class="ct-related-posts clearfix">
											<?php if(has_post_thumbnail()): $num_post++; $is_have_posts++; ?>
													<?php $carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'widget-thumb'); ?>
													<div class="related-thumb">
														<div class="post-thumbnail">
										          			<a href="<?php the_permalink(); ?>">
										          				<?php ct_get_post_format_video(); ?>
										          				<div class="thumb-mask"></div>
										          				<img src="<?php echo esc_url( $carousel_image_url[0] ); ?>" alt="<?php the_title(); ?>" />
										          			</a>
										          		</div> <!-- .post-thumbnail -->
										          	</div> <!-- .related-thumb -->
									        <?php endif; ?>

									        <div class="content-box">
												<h3 class="entry-title"><a href='<?php the_permalink(); ?>' title='<?php esc_html_e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h3>
												<?php ct_get_widget_meta( $show_date, $show_comments, false, false, false ); ?>
											</div>
									</article>
							    </li>
								<?php if ( $num_post == $num_posts ) : break; endif; ?>
							<?php endwhile;

							if ( $is_have_posts == 0 ) {
								echo '<div class="no-related-posts">';
								echo esc_html__('No related posts were found','color-theme-framework');
								echo '</div>';
							} ?>
						</ul> <!-- .slides -->
					</div> <!-- .flexslider -->
			<?php
			else :
				echo '<div class="no-related-posts">';
				echo esc_html__('No related posts were found','color-theme-framework');
				echo '</div>';
			endif;
		endif; ?>

		<?php
		/* After widget (defined by themes). */
		echo $after_widget;

		// Restor original Post Data
		wp_reset_postdata();
		}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title']		 		= strip_tags( $new_instance['title'] );
		$instance['num_posts'] 			= $new_instance['num_posts'];
		$instance['num_query_posts'] 	= $new_instance['num_query_posts'];
		$instance['show_random'] 		= $new_instance['show_random'];
		$instance['posts_by'] 			= $new_instance['posts_by'];
		$instance['show_date'] 			= $new_instance['show_date'];
		$instance['show_comments'] 		= $new_instance['show_comments'];
		$instance['background_title'] 	= $new_instance['background_title'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance)
	{
		/* Set up some default widget settings. */
		$defaults = array(	'title'				=> esc_html__( 'Related Posts' , 'color-theme-framework' ),
							'num_posts'			=> '6',
							'num_query_posts'	=> '10',
							'show_random'		=> 'off',
							'posts_by'			=> 'tags',
							'show_date' 			=> 'on',
							'show_comments'			=> 'on',
							'background_title'	=> '#222b31'
					);

		$instance = wp_parse_args((array) $instance, $defaults);
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
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:' , 'color-theme-framework' ); ?></label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php esc_html_e( 'Number of posts to display:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo esc_attr( $instance['num_posts'] ); ?>" />
			<i style=" font-size: 11px; color: #777; ">Will display only posts with Featured images</i>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('num_query_posts'); ?>"><?php esc_html_e( 'Number of posts in query:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_query_posts'); ?>" name="<?php echo $this->get_field_name('num_query_posts'); ?>" value="<?php echo esc_attr( $instance['num_query_posts'] ); ?>" />
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_random'], 'on'); ?> id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" />
			<label for="<?php echo $this->get_field_id('show_random'); ?>"><?php esc_html_e( 'Random order' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_by' ); ?>"><?php esc_html_e('Show related posts by:', 'color-theme-framework'); ?></label>
			<select id="<?php echo $this->get_field_id( 'posts_by' ); ?>" name="<?php echo $this->get_field_name( 'posts_by' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'tags' == $instance['posts_by'] ) echo 'selected="selected"'; ?>>tags</option>
				<option <?php if ( 'category' == $instance['posts_by'] ) echo 'selected="selected"'; ?>>category</option>
			</select>
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php esc_html_e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php esc_html_e( 'Show Date' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php esc_html_e( 'Show Comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
			<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
		</p>

	<?php
	}
}
?>