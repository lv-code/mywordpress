<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Small Flex Slider Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show slider with latest posts.
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','CT_small_slider_load_widgets');

function CT_small_slider_load_widgets(){
		register_widget("CT_small_slider_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_small_slider_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */
	function CT_small_slider_Widget(){

		/* Widget settings. */
		$widget_ops = array(
								'classname' => 'ct_small_slider_widget',
								'description' => esc_html__( 'Small Flex Slider widget' , 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct_small_slider_widget', esc_html__( 'CT: Small Slider Widget' , 'color-theme-framework' ) ,  $widget_ops );

	}

	function widget($args,$instance){
		extract($args);

		global $ct_options, $post;

		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$show_category 		= isset($instance['show_category']) ? '1' : '0';
		$show_date 			= isset($instance['show_date']) ? '1' : '0';
		$show_author 		= isset($instance['show_author']) ? '1' : '0';
		$show_comments 		= isset($instance['show_comments']) ? '1' : '0';
		$show_likes 		= isset($instance['show_likes']) ? '1' : '0';
		$show_views 		= isset($instance['show_views']) ? '1' : '0';
		$show_thumb 		= isset($instance['show_thumb']) ? '1' : '0';
		$categories 		= $instance['categories'];
		$categories_exclude = $instance['categories_exclude'];
		$num_posts 			= $instance['num_posts'];
		$animation_speed	= $instance['animation_speed'];
		$slideshow_speed 	= $instance['slideshow_speed'];
		$animation_type 	= $instance['animation_type'];
		$excerpt_lenght 	= isset( $instance['excerpt_lenght'] ) ? $excerpt_lenght = $instance['excerpt_lenght'] : $instance['excerpt_lenght'] = '120';
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#ff9e47';

		?>

		<?php

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if( $title ) : ?>
			<div class="widget-title clearfix" style="background: <?php echo esc_attr( $background_title ); ?>">
				<h3 class="entry-title"><?php echo esc_attr( $title ); ?></h3>
				<i class="fa fa-<?php echo $icon_class; ?>"></i>
			</div>
		<?php endif; ?>

		<?php
		$time_id = rand();
		$orderby = 'date';

		$slider_posts = new WP_Query(array(
			'orderby' 			=> 'ASC',
			'showposts' 		=> $num_posts,
			'post_type' 		=> 'post',
			'cat'				=> $categories,
			'category__not_in'	=> $categories_exclude
		));


		if ( $slider_posts->have_posts() ) : ?>

		<?php
			/* Flex Slider */
			wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
			wp_enqueue_script('flex-min-jquery',array('jquery'));

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
			$(window).load(function() {
				$('.next-nav').click( function() {
					$('#slider-<?php echo $time_id; ?>').flexslider('next');
				});

				$('.prev-nav').click( function() {
					$('#slider-<?php echo $time_id; ?>').flexslider('prev');
				});

				$(".slider-preloader").css("display","none");

  	  			$('#slider-<?php echo $time_id; ?>').flexslider({
					animation: "<?php echo esc_js( $animation_type ); ?>",
					directionNav: false,
					controlNav: false,
					slideshowSpeed: <?php echo esc_js( $slideshow_speed ); ?>,
					animationSpeed: <?php echo esc_js( $animation_speed ); ?>,
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

		<!-- #########  SLIDER  ######### -->
		<div id="slider-<?php echo $time_id; ?>" class="small-slider flex-main flexslider">
	  		<div class="slider-preloader"><img src="<?php echo get_template_directory_uri().'/img/slider_preloader.gif'; ?> " alt="preloader"></div>
 	  		<ul class="slides">
				<?php while($slider_posts->have_posts()): $slider_posts->the_post(); ?>
		    			<li class="clearfix">
		    				<?php if( has_post_thumbnail() and $show_thumb ): ?>
								<?php $thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb'); ?>
								<div class="post-thumbnail">
									<a href="<?php echo esc_url( the_permalink() ); ?>">
										<?php ct_get_post_format_video(); ?>
										<div class="thumb-mask"></div>
										<img src="<?php echo esc_url( $thumb_image_url[0] ); ?>" alt="<?php the_title(); ?>" />
									</a>
								</div> <!-- .entry-thumbnail -->
							<?php endif; ?>
							<!-- title -->
							<div class="box-content clearfix <?php if( !has_post_thumbnail() or !$show_thumb ) echo 'no-right-padding'; ?>">
								<?php ct_get_category( $show_category ); ?>
								<h4 class="entry-title"><a href='<?php echo esc_url( the_permalink() ); ?>'><?php the_title(); ?></a></h4>
								<?php
									if( $excerpt_lenght != 0 ) :
									 	ct_excerpt_max_charlength( $excerpt_lenght );
									endif;
								?>
								<?php ct_get_widget_meta( $show_date, $show_comments, $show_likes, $show_views, $show_author ); ?>
							</div> <!-- .box-content -->
		    			</li>

				<?php endwhile; ?>
	  		</ul><!-- slides -->
		</div><!-- slider -->
	  		<div class="slider-nav clearfix">
	  			<div class="nav-wrapper">
	  				<div class="prev-nav"><i class="fa fa-chevron-left"></i></div>
	  				<div class="next-nav"><i class="fa fa-chevron-right"></i></div>
	  			</div>
	  		</div>
		<?php
		else :
			echo esc_html__( 'No related posts were found','color-theme-framework' );
		endif;

	  	// Restor original Query & Post Data
	  	wp_reset_postdata();


		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update($new_instance, $old_instance){
		$instance = $old_instance;

		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['icon_class'] 		= $new_instance['icon_class'];
		$instance['categories'] 		= $new_instance['categories'];
		$instance['categories_exclude'] = $new_instance['categories_exclude'];
		$instance['show_category'] 			= $new_instance['show_category'];
		$instance['show_date'] 			= $new_instance['show_date'];
		$instance['show_author'] 		= $new_instance['show_author'];
		$instance['show_comments'] 		= $new_instance['show_comments'];
		$instance['show_likes'] 		= $new_instance['show_likes'];
		$instance['show_views'] 		= $new_instance['show_views'];
		$instance['show_thumb'] 		= $new_instance['show_thumb'];
		$instance['num_posts'] 			= $new_instance['num_posts'];
		$instance['animation_speed'] 	= $new_instance['animation_speed'];
		$instance['slideshow_speed'] 	= $new_instance['slideshow_speed'];
		$instance['animation_type'] 	= $new_instance['animation_type'];
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
		?>
		<?php
		$defaults = array(	'title'					=> esc_html__( 'Small Slider', 'color-theme-framework' ),
							'icon_class' 			=> 'film',
							'categories'			=> 'all',
							'categories_exclude'	=> '',
							'num_posts' 			=> '5',
							'show_category'			=> 'on',
							'show_date' 			=> 'on',
							'show_author' 			=> 'off',
							'show_comments' 		=> 'on',
							'show_likes' 			=> 'off',
							'show_views'			=> 'off',
							'show_thumb'			=> 'on',
							'animation_speed' 		=> '600',
							'slideshow_speed' 		=> '7000',
							'animation_type' 		=> 'slide',
							'excerpt_lenght'		=> '120',
							'background_title'		=> '#222b31',
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
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php esc_html_e( 'Number of the posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo esc_attr( $instance['num_posts'] ); ?>" />
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

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php esc_html_e( 'Length of post excerpt (chars). 0 - excerpt will not be display ' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo esc_attr( $instance['excerpt_lenght'] ); ?>" />
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php esc_html_e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_thumb'], 'on'); ?> id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" />
			<label for="<?php echo $this->get_field_id('show_thumb'); ?>"><?php esc_html_e( 'Show thumbnail image' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_category'], 'on'); ?> id="<?php echo $this->get_field_id('show_category'); ?>" name="<?php echo $this->get_field_name('show_category'); ?>" />
			<label for="<?php echo $this->get_field_id('show_category'); ?>"><?php esc_html_e( 'Show category' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" />
			<label for="<?php echo $this->get_field_id('show_date'); ?>"><?php esc_html_e( 'Show Date' , 'color-theme-framework' ); ?></label>
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
			<input class="checkbox" type="checkbox" <?php checked($instance['show_likes'], 'on'); ?> id="<?php echo $this->get_field_id('show_likes'); ?>" name="<?php echo $this->get_field_name('show_likes'); ?>" />
			<label for="<?php echo $this->get_field_id('show_likes'); ?>"><?php esc_html_e( 'Show Likes' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_views'], 'on'); ?> id="<?php echo $this->get_field_id('show_views'); ?>" name="<?php echo $this->get_field_name('show_views'); ?>" />
			<label for="<?php echo $this->get_field_id('show_views'); ?>"><?php esc_html_e( 'Show Views' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('slideshow_speed'); ?>"><?php esc_html_e( 'Slideshow speed, in millisec:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100000" class="widefat" id="<?php echo $this->get_field_id('slideshow_speed'); ?>" name="<?php echo $this->get_field_name('slideshow_speed'); ?>" value="<?php echo esc_attr( $instance['slideshow_speed'] ); ?>" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id('animation_speed'); ?>"><?php esc_html_e( 'Animation speed, in millisec:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100000"class="widefat" id="<?php echo $this->get_field_id('animation_speed'); ?>" name="<?php echo $this->get_field_name('animation_speed'); ?>" value="<?php echo esc_attr( $instance['animation_speed'] ); ?>" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'animation_type' ); ?>"><?php esc_html_e('Animation type:', 'color-theme-framework'); ?></label>
			<select id="<?php echo $this->get_field_id( 'animation_type' ); ?>" name="<?php echo $this->get_field_name( 'animation_type' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'fade' == $instance['animation_type'] ) echo 'selected="selected"'; ?>>fade</option>
				<option <?php if ( 'slide' == $instance['animation_type'] ) echo 'selected="selected"'; ?>>slide</option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
			<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
		</p>

		<?php

	}
}
?>