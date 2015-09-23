<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Flickr Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget thats displays your projects from flickr.com
 	Version: 1.0
 	Author: ZERGE
 	Author URI: http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init', 'ct_flickr_widget');

function ct_flickr_widget() {
	register_widget('CT_Flickr_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Flickr_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CT_Flickr_Widget() {

		/* Widget settings. */
		$widget_ops = array( 'classname'		=> 'ct-flickr-widget',
							 'description'		=> esc_html__( 'CT: Flickr Widget', 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct-flickr-widget', esc_html__('CT: Flickr Widget', 'color-theme-framework' ), $widget_ops );
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
	/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );

		if ( !is_admin() ) {
			/* Flickr */
			wp_register_script('jquery-flickr',get_template_directory_uri().'/js/jflickrfeed.min.js',false, null , true);
			wp_enqueue_script('jquery-flickr',array('jquery'));

			wp_register_script('ct-prettyphoto-js',get_template_directory_uri().'/js/jquery.prettyphoto.js',false, null , true);
			wp_enqueue_script('ct-prettyphoto-js',array('jquery'));

		}
		?>

	<?php
		// Our variables from the widget settings
		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$user_id 			= ! empty( $instance['user_id'] ) ? $instance['user_id'] : '';
		$num_images 		= ! empty( $instance['num_images'] ) ? absint( $instance['num_images'] ) : '10';
		$feed_type 			= $instance['feed_type'];
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#0063dc';

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
		// Display widget
		$time_id = rand();
		?>

		<script type="text/javascript">
		/* <![CDATA[ */
		jQuery.noConflict()(function($){
			$(document).ready(function() {
				$(".ct-flickr-<?php echo esc_js( $time_id ); ?>").jflickrfeed({
					limit: <?php echo esc_js( $instance['num_images'] ); ?>,
					feedapi:"<?php echo esc_js( $instance['feed_type'] ); ?>",
					qstrings: {
						id: "<?php echo esc_js( $instance['user_id'] ); ?>"
					},
					itemTemplate: '<li>'+
								'<a rel="prettyPhoto[flickr]" href="{{image_b}}" title="{{title}}">' +
								'<img src="{{image_s}}" alt="{{title}}" />' +
								'</a>' +
								'</li>'
				},  function(data) {
						$('.ct-flickr-<?php echo esc_js( $time_id ); ?> a').prettyPhoto({
							animationSpeed: 'normal', /* fast/slow/normal */
							opacity: 0.80, /* Value between 0 and 1 */
							showTitle: true, /* true/false */
							deeplinking: false,
							theme:'light_square'
						});
				});

			});
		});
		/* ]]> */
		</script>

		<ul class="ct-flickr-<?php echo esc_attr( $time_id ); ?> fooo clearfix"></ul>

		<?php
		// After widget (defined by theme functions file)
		echo $after_widget;
	}


/*-----------------------------------------------------------------------------------*/
/*	Update Widget
/*-----------------------------------------------------------------------------------*/

function update( $new_instance, $old_instance ) {
	$instance = $old_instance;

	$instance['title'] 				= strip_tags( $new_instance['title'] );
	$instance['icon_class'] 		= $new_instance['icon_class'];
	$instance['user_id'] 			= stripslashes( $new_instance['user_id']);
	$instance['num_images'] 		= stripslashes( $new_instance['num_images']);
	$instance['feed_type'] 			= $new_instance['feed_type'];
	$instance['background_title'] 	= $new_instance['background_title'];

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/

function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(
						'title'				=> esc_html__( 'Photostream' , 'color-theme-framework' ),
						'icon_class' 		=> 'flickr',
						'user_id'			=> '52617155@N08',
						'num_images'		=> '8',
						'feed_type'			=> 'photos_public.gne',
						'background_title'	=> '#0063dc'
	);

	$instance 			= wp_parse_args((array) $instance, $defaults);
	$background_title 	= esc_attr($instance['background_title']);
	?>
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready(function($) {
			$('.ct-color-picker').wpColorPicker();
		});
		//]]>
	</script>

	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank">All Icons</a></label>
		<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'user_id' ); ?>"><?php esc_html_e('User ID:', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'user_id' ); ?>" name="<?php echo $this->get_field_name( 'user_id' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['user_id'] ), ENT_QUOTES)); ?>" />
		<span><?php esc_html_e('Can be found here:', 'color-theme-framework') . 'http://idgettr.com'; ?> </span>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'num_images' ); ?>"><?php esc_html_e('The number of displayed images:', 'color-theme-framework') ?></label>
		<input type="number" min="1" max="50" class="widefat" id="<?php echo $this->get_field_id( 'num_images' ); ?>" name="<?php echo $this->get_field_name( 'num_images' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['num_images'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'feed_type' ); ?>"><?php esc_html_e('Feed type:', 'color-theme-framework'); ?></label>
		<select id="<?php echo $this->get_field_id( 'feed_type' ); ?>" name="<?php echo $this->get_field_name( 'feed_type' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'photos_public.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>photos_public.gne</option>
			<option <?php if ( 'photos_friends.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>photos_friends.gne</option>
			<option <?php if ( 'photos_faves.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>photos_faves.gne</option>
			<option <?php if ( 'groups_pool.gne' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>groups_pool.gne</option>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
		<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#0063dc" />
	</p>

	<?php
	}
}
?>