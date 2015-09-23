<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Instagram Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget thats displays your photos from instagram.com
 	Version: 1.0
 	Author: ZERGE
 	Author URI: http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init', 'ct_instagram_widget');

function ct_instagram_widget() {
	register_widget('CT_Instagram_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Instagram_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CT_Instagram_Widget() {

		/* Widget settings. */
		$widget_ops = array(	'classname'		=> 'ct-instagram-widget',
								'description'	=> esc_html__( 'CT: Instagram Widget', 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct-instagram-widget', esc_html__('CT: Instagram Widget','color-theme-framework'), $widget_ops );
	}

	/*-----------------------------------------------------------------------------------*/
	/*	Display Widget
	/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );

		if ( ! is_admin() ) {
			/* Instagram */
			wp_register_script('jquery-instagram',get_template_directory_uri().'/js/spectragram.min.js',false, null , true);
			wp_enqueue_script('jquery-instagram',array('jquery'));
		}

		// Our variables from the widget settings
		$title 				= apply_filters('widget_title', $instance['title'] );
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$access_token 		= ! empty ( $instance['access_token'] ) ? $instance['access_token'] : '';
		$client_id 			= ! empty ( $instance['client_id'] ) ? $instance['client_id'] : '';
		$your_query 		= ! empty ( $instance['your_query'] ) ? $instance['your_query'] : 'awesomeinventions';
		$num_images 		= ! empty ( $instance['num_images'] ) ? $instance['num_images'] : '10';
		$feed_type 			= ! empty ( $instance['feed_type'] ) ? $instance['feed_type'] : 'UserFeed';
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#3f729b';

		$time_id = rand();

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
		if ( $feed_type == 'Popular' ) : $get_feed_type = 'getPopular';
		elseif ( $feed_type == 'RecentTagged' ) : $get_feed_type = 'getRecentTagged';
		else : $get_feed_type = 'getUserFeed';
		endif;
		?>

		<?php if ( empty($access_token) || empty($client_id) ) : ?>
			<p><?php esc_html_e( 'You must define an accessToken and a clientID', 'color-theme-framework' ); ?></p>
		<?php else : ?>
		<script type="text/javascript">
		/* <![CDATA[ */
			jQuery.noConflict()(function($){
				$(document).ready(function() {
					jQuery.fn.spectragram.accessData = {
						accessToken: '<?php echo esc_js( $access_token ); ?>',
						clientID: '<?php echo esc_js( $client_id ); ?>'
					};

					//Call spectagram function on the container element and pass it your query
					$('.ct-instagram-<?php echo esc_js( $time_id ); ?>').spectragram('<?php echo esc_js( $get_feed_type ); ?>', {
						query: '<?php echo esc_js( $your_query ); ?>', //this gets user photo feed
						size: 'small',
						max: <?php echo esc_js( $num_images ); ?>
					});
				});
			});
		/* ]]> */
		</script>
		<?php endif; ?>

		<ul class="ct-instagram-<?php echo esc_attr( $time_id ); ?> clearfix"></ul>

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
		$instance['access_token'] 		= esc_html( $new_instance['access_token']);
		$instance['client_id'] 			= esc_html( $new_instance['client_id']);
		$instance['your_query'] 		= esc_html( $new_instance['your_query']);
		$instance['num_images'] 		= absint( $new_instance['num_images']);
		$instance['feed_type'] 			= $new_instance['feed_type'];
		$instance['background_title'] 	= $new_instance['background_title'];

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/

function form( $instance ) {

	// Set up some default widget settings
	$defaults = array(	'title'				=> esc_html__( 'Instagram Feed' , 'color-theme-framework' ),
						'icon_class' 		=> 'instagram',
						'access_token'		=> '',
						'client_id'			=> '',
						'your_query'		=> 'awesomeinventions',
						'num_images'		=> '8',
						'feed_type'			=> 'UserFeed',
						'background_title'	=> '#3f729b'
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

	<!-- Widget Title: Text Input -->
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank">All Icons</a></label>
		<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'client_id' ); ?>"><?php esc_html_e('Your Instagram application clientID:', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'client_id' ); ?>" name="<?php echo $this->get_field_name( 'client_id' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['client_id'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'access_token' ); ?>"><?php esc_html_e('Your Instagram access token:', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'access_token' ); ?>" name="<?php echo $this->get_field_name( 'access_token' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['access_token'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'your_query' ); ?>"><?php esc_html_e('Query (user name or tag):', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'your_query' ); ?>" name="<?php echo $this->get_field_name( 'your_query' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['your_query'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'num_images' ); ?>"><?php esc_html_e('The number of displayed images:', 'color-theme-framework') ?></label>
		<input type="number" min="1" max="30" class="widefat" id="<?php echo $this->get_field_id( 'num_images' ); ?>" name="<?php echo $this->get_field_name( 'num_images' ); ?>" value="<?php echo stripslashes(htmlspecialchars(( $instance['num_images'] ), ENT_QUOTES)); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id( 'feed_type' ); ?>"><?php esc_html_e('Feed type:', 'color-theme-framework'); ?></label>
		<select id="<?php echo $this->get_field_id( 'feed_type' ); ?>" name="<?php echo $this->get_field_name( 'feed_type' ); ?>" class="widefat" style="width:100%;">
			<option <?php if ( 'UserFeed' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>UserFeed</option>
			<option <?php if ( 'Popular' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>Popular</option>
			<option <?php if ( 'RecentTagged' == $instance['feed_type'] ) echo 'selected="selected"'; ?>>RecentTagged</option>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
		<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#3f729b" />
	</p>

	<?php
	}
}
?>