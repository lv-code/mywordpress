<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Categories Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget thats displays two columns categories
 	Version: 1.0
 	Author: ZERGE
 	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'ct_categories_widget');

function ct_categories_widget()
{
	register_widget('CT_Categories_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
	class CT_Categories_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CT_Categories_Widget() {

		/* Widget settings. */
		$widget_ops = array(	'classname'		=> 'ct-categories-widget',
								'description'	=> esc_html__( 'Categories widget', 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct_categories_widget', esc_html__( 'CT: Categories Widget' , 'color-theme-framework' ), $widget_ops );
	}

/*-----------------------------------------------------------------------------------*/
/*	Display Widget
/*-----------------------------------------------------------------------------------*/

	function widget( $args, $instance ) {
		extract( $args );

		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$num_cats			= ! empty ( $instance['num_cats'] ) ? $instance['num_cats'] : '0';
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#222b31';

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
			$args = array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'hide_empty' => 1,
			  'hierarchical' => 1,
			  'parent' => 0
			  );
			$categories = get_categories($args);
			$category_count = 0;

			echo '<ul class="ct-category-list">';

			foreach ($categories as $category ) {
				if ( !empty( $category->name ) ) {
					$category_count ++;

					$category_id = get_cat_ID( $category->name );
					$category_link = get_category_link( $category_id );

					$category_bg = get_option("category_$category_id");
					if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';

					$postsInCat = get_term_by('name',$category->name,'category');
					$postsInCat = $postsInCat->count;

					echo '<li>';
						echo '<a style="color:'.$category_bg['category_color'].'" href="' . get_category_link( $category->term_id ). '" title="'. esc_attr( sprintf( esc_html__( 'View all posts in %s', 'color-theme-framework' ), $category->name ) ) .'">' . $category->name .'<span class="category-count">' . $postsInCat . '</span></a>';
					echo '</li>';

				}
				if ( ( $category_count >= $num_cats ) and  ( $num_cats != 0 ) ) { break; }
			}

			echo '</ul> <!-- .ct-category-list -->';
		?>

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
	$instance['num_cats'] 			= $new_instance['num_cats'];
	$instance['background_title'] 	= $new_instance['background_title'];

	return $instance;
}


/*-----------------------------------------------------------------------------------*/
/*	Widget Settings (Displays the widget settings controls on the widget panel)
/*-----------------------------------------------------------------------------------*/

	function form($instance)
	{
		/* Set up some default widget settings. */
		$defaults = array(
							'title'				=> esc_html__( 'Categories' , 'color-theme-framework' ),
							'icon_class' 		=> 'list-ul',
							'num_cats'			=> '0',
							'background_title'		=> '#222b31'
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
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title:', 'color-theme-framework') ?></label>
		<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank">All Icons</a></label>
		<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('num_cats'); ?>"><?php esc_html_e( 'Number of first categories for display (0 - all categories):' , 'color-theme-framework' ); ?></label>
		<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_cats'); ?>" name="<?php echo $this->get_field_name('num_cats'); ?>" value="<?php echo esc_attr( $instance['num_cats'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
		<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
	</p>

	<?php
	}
}
?>