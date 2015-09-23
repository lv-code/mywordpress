<?php
/*
-----------------------------------------------------------------------------------

	Plugin Name: CT Recent Posts Widget
	Plugin URI: http://www.color-theme.com
	Description: A widget that show recent posts ( Specified by cat-id )
	Version: 1.0
	Author: ZERGE
	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'ct_recents_load_widgets' );

function ct_recents_load_widgets()
{
	register_widget('CT_Recent_Posts_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Recent_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CT_Recent_Posts_Widget()
	{
		/* Widget settings. */
		$widget_ops = array(
								'classname' => 'ct_recent_posts_widget',
								'description' => esc_html__( 'Display recent posts by categories' , 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct_recent_posts_widget', esc_html__( 'CT: Recent Posts' , 'color-theme-framework' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$time_id = rand();

		/* Our variables from the widget settings. */
		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$num_posts			= ! empty ( $instance['num_posts'] ) ? $instance['num_posts'] : '5';
		$categories 		= $instance['categories'];
		$categories_exclude = $instance['categories_exclude'];
		$show_date 			= isset($instance['show_date']) ? '1' : '0';
		$show_likes 		= isset($instance['show_likes']) ? '1' : '0';
		$show_views 		= isset($instance['show_views']) ? '1' : '0';
		$show_comments 		= isset($instance['show_comments']) ? '1' : '0';
		$show_author 		= isset($instance['show_author']) ? '1' : '0';
		$show_thumb 		= isset($instance['show_thumb']) ? '1' : '0';
		$background_title 	= ! empty ( $instance['background_title'] ) ? $instance['background_title'] : '#222b31';


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
			global $post, $ct_options;

			$recent_posts = new WP_Query(array(
				'showposts'				=> $num_posts,
				'ignore_sticky_posts'	=> 1,
				'cat'					=> $categories,
				'category__not_in'		=> $categories_exclude
			));
	?>

	<?php if ( $recent_posts->have_posts() ) : ?>
		<ul class="ct-custom-widget recent-posts-widget recent-widget-<?php echo esc_attr( $time_id ); ?>">
			<?php while( $recent_posts->have_posts() ): $recent_posts->the_post(); ?>
					<li class="clearfix">
						<div class="widget-content">
						 	<?php if ( has_post_thumbnail() and $show_thumb ) : ?>
						 		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small-thumb'); ?>
								<div class="widget-post-thumbnail">
									<a href='<?php the_permalink(); ?>'><img src="<?php echo esc_url( $image[0] ); ?>" alt="<?php the_title(); ?>" /></a>
								</div><!-- widget-post-small-thumb -->
							<?php endif; ?>
							<div class="box-content <?php if( !has_post_thumbnail() or !$show_thumb ) echo 'no-right-padding'; ?>">
								<h4 class="entry-title"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></h4>
								<?php ct_get_widget_meta( $show_date, $show_comments, $show_likes, $show_views, $show_author ); ?>
							</div> <!-- .box-content -->
						</div> <!-- .widget-content -->
					</li>
			<?php endwhile; ?>
		</ul>
	<?php else : esc_html_e('No posts were found for display','color-theme-framework');
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
		$instance['title'] 				= strip_tags( $new_instance['title'] );
		$instance['icon_class'] 		= $new_instance['icon_class'];
		$instance['num_posts'] 			= $new_instance['num_posts'];
		$instance['categories'] 		= $new_instance['categories'];
		$instance['categories_exclude'] = $new_instance['categories_exclude'];
		$instance['show_date'] 			= $new_instance['show_date'];
		$instance['show_likes'] 		= $new_instance['show_likes'];
		$instance['show_views'] 		= $new_instance['show_views'];
		$instance['show_comments'] 		= $new_instance['show_comments'];
		$instance['show_author'] 		= $new_instance['show_author'];
		$instance['show_thumb'] 		= $new_instance['show_thumb'];
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
		$defaults = array(
			'title'					=>	esc_html__( 'Recent Posts' , 'color-theme-framework' ),
			'icon_class' 			=> 'image',
			'num_posts'				=>	4,
			'categories'			=>	'all',
			'categories_exclude'	=>	'',
			'show_date' 			=> 'on',
			'show_likes' 			=> 'off',
			'show_views'			=> 'off',
			'show_comments'			=> 'on',
			'show_author' 			=> 'off',
			'show_thumb'			=> 'on',
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
		<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php esc_html_e( 'Number of posts:' , 'color-theme-framework' ); ?></label>
		<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" value="<?php echo esc_attr( $instance['num_posts'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('categories'); ?>"><?php esc_html_e( 'Filter by Category:' , 'color-theme-framework' ); ?></label>
		<select id="<?php echo $this->get_field_id('categories'); ?>" name="<?php echo $this->get_field_name('categories'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['categories'] ) echo 'selected="selected"'; ?>>all categories</option>
			<?php $categories = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
			<?php foreach( $categories as $category ) { ?>
			<option value='<?php echo esc_attr( $category->term_id ); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
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
		<input class="checkbox" type="checkbox" <?php checked($instance['show_thumb'], 'on'); ?> id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" />
		<label for="<?php echo $this->get_field_id('show_thumb'); ?>"><?php esc_html_e( 'Show thumbnail image' , 'color-theme-framework' ); ?></label>
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
		<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
		<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
	</p>

	<?php
	}
}

?>