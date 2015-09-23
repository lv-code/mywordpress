<?php
/*
-----------------------------------------------------------------------------------

	Plugin Name: CT Post Formats Widget
	Plugin URI: http://www.color-theme.com
	Description: A widget that show post for selected post format.
	Version: 1.0
	Author: ZERGE
	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/



/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'ct_post_formats_widget' );

function ct_post_formats_widget() {
	register_widget( 'CT_Post_Format' );
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Post_Format extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function  CT_Post_Format() {
		/* Widget settings. */
		$widget_ops = array(	'classname'		=> 'ct-postformats-widget',
								'description'	=> __( 'A widget that shows posts for selected post formats' , 'color-theme-framework' )
					);

		/* Create the widget. */
		parent::__construct( 'ct-postformats-widget', __('CT: Post Formats', 'color-theme-framework'), $widget_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );


		global $wpdb;
		$time_id = rand();

		/* Our variables from the widget settings. */
		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$num_posts 			= $instance['num_posts'];
		$categories 		= $instance['categories'];
		$ct_terms 			= $instance['ct_terms'];
		$categories_exclude = $instance['categories_exclude'];
		$theme_orderby 		= $instance['theme_orderby'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		global $post;

		$time_id = rand();

		if ( ( $theme_orderby == 'comments' ) and ( $ct_terms != 'all' ) )  {
			$recent_posts = new WP_Query(array(
					'showposts'		=> $num_posts,
					'cat'			=> $categories,
					'orderby'		=> 'comment_count',
					'category__not_in'	=> $categories_exclude,
					'ignore_sticky_posts'	=> 1,
					'tax_query'	=> array(
							array(
									'taxonomy' => 'post_format',
									'field'		=> 'slug',
									'terms'		=> $ct_terms
								)
					)
				));
			}
			else if ( ( $theme_orderby == 'likes' ) and ( $ct_terms != 'all' ) ) {
				$recent_posts = new WP_Query(array(
					'showposts'		=> $num_posts,
					'cat'			=> $categories,
					'orderby'		=> 'meta_value_num',
					'meta_key'		=> 'votes_count',
					'category__not_in'	=> $categories_exclude,
					'ignore_sticky_posts'	=> 1,
					'tax_query'	=> array(
							array(
									'taxonomy' => 'post_format',
									'field'		=> 'slug',
									'terms'		=> $ct_terms
								)
					)
				));
			}
			else if ( ( $theme_orderby == 'views' ) and ( $ct_terms != 'all' )  ) {
				$recent_posts = new WP_Query(array(
					'showposts'		=> $num_posts,
					'cat'			=> $categories,
					'orderby'		=> 'meta_value_num',
					'meta_key'		=> 'post_views_count',
					'category__not_in'	=> $categories_exclude,
					'ignore_sticky_posts'	=> 1,
					'tax_query'	=> array(
							array(
									'taxonomy' => 'post_format',
									'field'		=> 'slug',
									'terms'		=> $ct_terms
								)
					)
				));
			} else {
				$recent_posts = new WP_Query(array(
					'showposts'		=> $num_posts,
					'cat'			=> $categories,
					'category__not_in'	=> $categories_exclude,
					'ignore_sticky_posts'	=> 1
				));
			}

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
		$('.next-cat-slide').click( function() {
			$('#carousel-<?php echo $time_id; ?>').flexslider('next');
		});

		$('.prev-cat-slide').click( function() {
			$('#carousel-<?php echo $time_id; ?>').flexslider('prev');
		});

		$('#carousel-<?php echo $time_id; ?>').flexslider({
		    animation: "slide",
		    animationLoop: true,
		    slideshow: 'slide',
			controlNav: false,
			smoothHeight: true,
			directionNav: false,
			itemWidth: 300,
			itemMargin: 0,
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
<div id="post-formats-widget">
	<div class="row">
		<?php if ( $recent_posts->have_posts() ) : ?>
	<div class="col-md-12">

		<div id="carousel-<?php echo $time_id; ?>" class="flexslider flex-carousel">
		  <ul class="slides ct-post-formats-widget post-formats-widget-<?php echo esc_attr( $time_id ); ?>">
			<?php
			  global $post;
			  while($recent_posts->have_posts()): $recent_posts->the_post();
			?>

		    <li>
		    	<article class="ct-post-format">
						<?php
							if ( has_post_thumbnail() ) :
								$carousel_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb'); ?>
								<div class="post-thumbnail">
				          			<a href="<?php the_permalink(); ?>">
				          				<?php ct_get_post_format_video(); ?>
				          				<div class="thumb-mask"></div>
				          				<img src="<?php echo esc_url( $carousel_image_url[0] ); ?>" alt="<?php the_title(); ?>" />
				          			</a>
				          		</div> <!-- .hotnews-thumb -->
				        <?php endif; ?>

				        <div class="content-box">
							<h3 class="entry-title"><a href='<?php the_permalink(); ?>' title='<?php esc_html_e('Permalink to ','color-theme-framework'); the_title(); ?>'><?php the_title(); ?></a></h3>
						</div>
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
				<div class="prev-cat-slide"><i class="fa fa-chevron-left"></i></div>
				<div class="next-cat-slide"><i class="fa fa-chevron-right"></i></div>
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
		/* After widget (defined by themes). */
		echo $after_widget;
		echo "\n<!-- END PHOTO NEWS WIDGET -->\n";

		// Restor original Query & Post Data
		wp_reset_postdata();
		}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['icon_class'] 		= $new_instance['icon_class'];
		$instance['num_posts'] 			= $new_instance['num_posts'];
		$instance['ct_terms'] 			= $new_instance['ct_terms'];
		$instance['categories'] 		= $new_instance['categories'];
		$instance['categories_exclude'] = $new_instance['categories_exclude'];
		$instance['theme_orderby'] 		= $new_instance['theme_orderby'];

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
		$defaults = array(	'title'				=> 	esc_html__( 'News' , 'color-theme-framework' ),
							'icon_class' 		=> 'picture-o',
							'ct_terms'			=> 'post-format-image',
							'num_posts'			=> 10,
							'categories'		=> 'all',
							'categories_exclude'=> '',
							'theme_orderby'		=> 'comments'
					);

		$instance = wp_parse_args((array) $instance, $defaults);
		$categories_exclude = $instance['categories_exclude'];
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
		<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank">All Icons</a></label>
		<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'ct_terms' ); ?>"><?php esc_html_e('Get articles for the post format:', 'color-theme-framework'); ?></label>
		<select id="<?php echo $this->get_field_id( 'ct_terms' ); ?>" name="<?php echo $this->get_field_name( 'ct_terms' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'all' == $instance['ct_terms'] ) echo 'selected="selected"'; ?>>all</option>
			<option <?php if ( 'post-format-image' == $instance['ct_terms'] ) echo 'selected="selected"'; ?>>post-format-image</option>
			<option <?php if ( 'post-format-audio' == $instance['ct_terms'] ) echo 'selected="selected"'; ?>>post-format-audio</option>
			<option <?php if ( 'post-format-video' == $instance['ct_terms'] ) echo 'selected="selected"'; ?>>post-format-video</option>
			<option <?php if ( 'post-format-gallery' == $instance['ct_terms'] ) echo 'selected="selected"'; ?>>post-format-gallery</option>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php esc_html_e( 'Number of posts to display:' , 'color-theme-framework' ); ?></label>
		<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo esc_attr( $instance['num_posts'] ); ?>" />
		<i style=" font-size: 11px; color: #777; "><?php esc_html_e( 'Will display only posts with Featured images', 'color-theme-framework' ); ?></i>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'theme_orderby' ); ?>"><?php esc_html_e('Order by:', 'color-theme-framework'); ?></label>
		<select id="<?php echo $this->get_field_id( 'theme_orderby' ); ?>" name="<?php echo $this->get_field_name( 'theme_orderby' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'comments' == $instance['theme_orderby'] ) echo 'selected="selected"'; ?>>comments</option>
			<option <?php if ( 'likes' == $instance['theme_orderby'] ) echo 'selected="selected"'; ?>>likes</option>
			<option <?php if ( 'views' == $instance['theme_orderby'] ) echo 'selected="selected"'; ?>>views</option>
		</select>
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

	<?php
	}
}

?>