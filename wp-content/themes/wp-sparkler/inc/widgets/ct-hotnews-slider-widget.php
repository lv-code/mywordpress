<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Hot News Slider Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show carousel with latest posts.
 	Version: 1.0
 	Author: Zerge
 	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init','CT_hotnews_slider_load_widgets');

function CT_hotnews_slider_load_widgets(){
		register_widget("CT_hotnews_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_hotnews_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */
	function CT_hotnews_Widget(){

		/* Widget settings. */
		$widget_ops = array(
								'classname' => 'ct_hotnews_slider_widget',
								'description' => esc_html__( 'Carousel widget' , 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct_hotnews_slider_widget', esc_html__( 'CT: Hot News Slider Widget' , 'color-theme-framework' ) ,  $widget_ops );

	}

	function widget($args,$instance){
		extract($args);

		$title 				= apply_filters ('widget_title', $instance ['title']);
		$categories 		= $instance['categories'];
		$categories_exclude = $instance['categories_exclude'];
		$posts 				= $instance['posts'];
		$show_featured		= isset($instance['show_featured']) ? '1' : '0';
		$show_date 			= isset($instance['show_date']) ? '1' : '0';
		$show_likes 		= isset($instance['show_likes']) ? '1' : '0';
		$show_views 		= isset($instance['show_views']) ? '1' : '0';
		$show_comments 		= isset($instance['show_comments']) ? '1' : '0';
		$show_author 		= isset($instance['show_author']) ? '1' : '0';
		$slideshow 			= isset($instance['slideshow']) ? 'true' : 'false';
		$show_random 		= isset($instance['show_random']) ? '1' : '0';
		$excerpt_lenght 	= isset( $instance['excerpt_lenght'] ) ? $excerpt_lenght = $instance['excerpt_lenght'] : $instance['excerpt_lenght'] = '120';

		/* Before widget (defined by themes). */
		echo $before_widget;
		?>

<?php
	global $post;
	$time_id = rand();
	$orderby = 'date';

	if ( $show_random ) { $orderby = 'rand'; }

	$recent_posts = new WP_Query(array(	    'orderby'			=> $orderby,
	  										'showposts'			=> $posts,
	  										'post_type'			=> 'post',
	  										'cat'				=> $categories,
	  										'category__not_in'		=> $categories_exclude,
	  										'ignore_sticky_posts' => 1
	  									)
									);
?>

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
		$('.next-slide').click( function() {
			$('#carousel-<?php echo esc_js($time_id); ?>').flexslider('next');
		});

		$('.prev-slide').click( function() {
			$('#carousel-<?php echo esc_js($time_id); ?>').flexslider('prev');
		});

	  $('#carousel-<?php echo esc_js($time_id); ?>').flexslider({
	    animation: "slide",
	    animationLoop: true,
	    slideshow: <?php echo esc_js( $slideshow ); ?>,
		controlNav: false,
		smoothHeight: true,
		directionNav: false,
		prevText: "",
		nextText: "",
		rtl: <?php echo esc_js( $rtl ); ?>
	  });

	});
	});
	/* ]]> */
	</script>
<div id="carousel-widget">
	<div class="row">
		<?php if ( $recent_posts->have_posts() ) : ?>
	<div class="col-md-12">

		<div id="carousel-<?php echo $time_id; ?>" class="flexslider flex-carousel">
		  <ul class="slides">
			<?php
			  global $post;
			  while($recent_posts->have_posts()): $recent_posts->the_post();
			?>

		    <li>
		    	<article class="entry-post">
					<div class="entry-content">
						<?php
							if ( has_post_thumbnail() and $show_featured ) :
								$carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'widget-thumb'); ?>
								<div class="hotnews-thumb">
				          			<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $carousel_image_url[0] ); ?>" alt="<?php the_title(); ?>" /></a>
				          		</div> <!-- .hotnews-thumb -->
				        <?php endif; ?>

						<h3 class="entry-title"><a href='<?php the_permalink(); ?>' title='<?php esc_html_e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h3>
						<?php ct_excerpt_max_charlength( $excerpt_lenght ); ?>
						<?php ct_get_widget_meta( $show_date, $show_comments, $show_likes, $show_views, $show_author ); ?>
					</div> <!-- .entry-content -->
				</article>
		    </li>

		<?php endwhile; ?>

		  </ul>
		</div> <!-- .flexslider -->
	</div> <!-- col-md-12 -->
		<div class="col-md-12">
			<div class="carousel-header">
				<?php if ( $title ) : ?>
					<h3 class="entry-title"><?php echo esc_attr( $title ); ?></h3>
				<?php endif; ?>
				<div class="prev-slide"><i class="fa fa-chevron-left"></i></div>
				<div class="next-slide"><i class="fa fa-chevron-right"></i></div>
			</div> <!-- .carousel-header -->
		</div>

	</div> <!-- .row -->
	<?php else : ?>
		<div class="col-md-12">
			<span class="ct-no-related-posts"><?php esc_html_e('No posts were found for display','color-theme-framework'); ?></span>
		</div>
	<?php endif; ?>
</div> <!-- #carousel-widget -->
		<?php

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

		$instance['title'] 				= $new_instance['title'];
		$instance['categories'] 		= $new_instance['categories'];
		$instance['categories_exclude'] = $new_instance['categories_exclude'];
		$instance['posts'] 				= $new_instance['posts'];
		$instance['slideshow'] 			= $new_instance['slideshow'];
		$instance['show_featured'] 		= $new_instance['show_featured'];
		$instance['show_date'] 			= $new_instance['show_date'];
		$instance['show_likes'] 		= $new_instance['show_likes'];
		$instance['show_views'] 		= $new_instance['show_views'];
		$instance['show_comments'] 		= $new_instance['show_comments'];
		$instance['show_author'] 		= $new_instance['show_author'];
		$instance['show_random'] 		= $new_instance['show_random'];
		$instance['excerpt_lenght'] 	= $new_instance['excerpt_lenght'];

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
			$defaults = array(
				'title' 				=> esc_html__( 'Latest Articles', 'color-theme-framework' ),
				'slideshow' 			=> 'off',
				'categories' 			=> 'all',
				'categories_exclude'	=>	'',
				'posts' 				=> '10',
				'show_date' 			=> 'on',
				'show_likes' 			=> 'off',
				'show_views'			=> 'off',
				'show_comments'			=> 'on',
				'show_author' 			=> 'off',
				'show_random' 			=> 'off',
				'excerpt_lenght'		=> '120',
				'show_featured'			=> 'off'
			);

			$instance = wp_parse_args((array) $instance, $defaults);
			$categories_exclude = $instance['categories_exclude'];
			?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:' , 'color-theme-framework' ) ?></label>
			<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('posts'); ?>"><?php _e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo esc_attr( $instance['posts'] ); ?>" />

		</p>

		<p>
			<label for="<?php echo $this->get_field_id('excerpt_lenght'); ?>"><?php esc_html_e( 'Length of post excerpt (chars):' , 'color-theme-framework' ); ?></label>
			<input type="number" min="1" max="500" class="widefat" id="<?php echo $this->get_field_id('excerpt_lenght'); ?>" name="<?php echo $this->get_field_name('excerpt_lenght'); ?>" value="<?php echo esc_attr( $instance['excerpt_lenght'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories'); ?>"><?php _e( 'Filter by Category:' , 'color-theme-framework' ); ?></label>
			<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat" style="width:100%;">
				<option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>all categories</option>
				<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($categories as $category) { ?>
				<option value='<?php echo $category->term_id; ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('categories_exclude'); ?>"><?php _e( 'Categories to exclude: (<em><strong>Use the CTRL key (PC) or COMMAND key (Mac) to select multiple items.</strong></em>)' , 'color-theme-framework' ); ?></label>
			<select size="10" multiple="multiple" id="<?php echo $this->get_field_id('categories_exclude'); ?>" name="<?php echo $this->get_field_name('categories_exclude'); ?>[]" class="widefat" style="width:100%;">
				<?php $cat = get_categories('hide_empty=0&depth=1&type=post'); ?>
				<?php foreach($cat as $category) { ?>
				<option value='<?php echo esc_attr( $category->term_id ); ?>' <?php if ( is_array( $categories_exclude ) && in_array( $category->term_id, $categories_exclude ) ) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
				<?php } ?>
			</select>
		</p>

		<p style="margin-top: 20px;">
			<label style="font-weight: bold;"><?php esc_html_e( 'Post meta info' , 'color-theme-framework' ); ?></label>
		</p>


		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_featured'], 'on'); ?> id="<?php echo $this->get_field_id('show_featured'); ?>" name="<?php echo $this->get_field_name('show_featured'); ?>" />
			<label for="<?php echo $this->get_field_id('show_featured'); ?>"><?php esc_html_e( 'Show Featured Image' , 'color-theme-framework' ); ?></label>
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
			<input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" />
			<label for="<?php echo $this->get_field_id('show_comments'); ?>"><?php esc_html_e( 'Show Comments' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_author'], 'on'); ?> id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" />
			<label for="<?php echo $this->get_field_id('show_author'); ?>"><?php esc_html_e( 'Show Author' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_random'], 'on'); ?> id="<?php echo $this->get_field_id('show_random'); ?>" name="<?php echo $this->get_field_name('show_random'); ?>" />
			<label for="<?php echo $this->get_field_id('show_random'); ?>"><?php esc_html_e( 'Random order' , 'color-theme-framework' ); ?></label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['slideshow'], 'on'); ?> id="<?php echo $this->get_field_id('slideshow'); ?>" name="<?php echo $this->get_field_name('slideshow'); ?>" />
			<label for="<?php echo $this->get_field_id('slideshow'); ?>"><?php esc_html_e( 'Animate carousel automatically' , 'color-theme-framework' ); ?></label>
		</p>

		<?php

	}
}
?>