<?php
/*
-----------------------------------------------------------------------------------

	Plugin Name: CT Recent Posts by Categories Widget
	Plugin URI: http://www.color-theme.com
	Description: A widget that show recent posts by categories ( three columns )
	Version: 1.0
	Author: ZERGE
	Author URI:  http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'ct_posts_bycategories_load_widgets' );

function ct_posts_bycategories_load_widgets()
{
	register_widget('CT_Posts_Bycategories_Widget');
}


/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_Posts_Bycategories_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function CT_Posts_Bycategories_Widget()
	{
		/* Widget settings. */
		$widget_ops = array(
								'classname' => 'ct_recent_posts_bycategories_widget',
								'description' => esc_html__( 'Display recent posts by categories' , 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct_recent_posts_bycategories_widget', esc_html__( 'CT: Posts by Categories (3 columns)' , 'color-theme-framework' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		global $post, $ct_options;

		$time_id = rand();

		/* Our variables from the widget settings. */
		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$num_posts			= ! empty ( $instance['num_posts'] ) ? $instance['num_posts'] : '5';
		$category_one 		= $instance['category_one'];
		$category_two 		= $instance['category_two'];
		$category_three 	= $instance['category_three'];
		$show_likes 		= isset($instance['show_likes']) ? '1' : '0';
		$show_views 		= isset($instance['show_views']) ? '1' : '0';
		$show_comments 		= isset($instance['show_comments']) ? '1' : '0';
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
			/**
			 * First Column
			 *
			 */
			$recent_posts = new WP_Query(array(
				'showposts'				=> $num_posts,
				'ignore_sticky_posts'	=> 1,
				'cat'					=> $category_one
			));
		?>

		<?php if ( $recent_posts->have_posts() ) : ?>
			<?php
				$not_all = false;

				$ct_cat_name = get_cat_name( $category_one );
				if ( empty( $ct_cat_name ) ) {
					$ct_cat_name = esc_html__( 'All categories', 'color-theme-framework' );
					$not_all = false;
				} else {
					$not_all = true;
					$category_link = get_category_link( $category_one );
					$category_bg = get_option("category_$category_one");
					if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';
				}

				$time_id = rand();
			?>

			<ul class="ct-custom-widget recent-posts-by-categories-widget recent-widget-<?php echo esc_attr( $time_id ); ?> clearfix">
				<li class="ct-cat-name">
					<?php if ( !$not_all ) : ?>
						<h3><?php echo esc_attr( $ct_cat_name ); ?></h3>
					<?php else : ?>
						<h3><?php echo '<a href="' . esc_url( $category_link ) . '" style="color: '.$category_bg['category_color'].'">' . $ct_cat_name . '</a>'; ?></h3>
					<?php endif; ?>
				</li>
				<?php while( $recent_posts->have_posts() ): $recent_posts->the_post(); ?>
						<li class="clearfix">
							<?php ct_get_bycategory_meta( $show_comments, $show_views, $show_likes ); ?>
						</li>
				<?php endwhile; ?>
			</ul>
		<?php else : esc_html_e('No posts were found for display','color-theme-framework');
		endif; ?>

		<?php wp_reset_postdata(); ?>

		<?php
			/**
			 * Second Column
			 *
			 */
			$recent_posts = new WP_Query(array(
				'showposts'				=> $num_posts,
				'ignore_sticky_posts'	=> 1,
				'cat'					=> $category_two
			));
		?>

		<?php if ( $recent_posts->have_posts() ) : ?>
			<?php
				$not_all = false;

				$ct_cat_name = get_cat_name( $category_two );

				if ( empty( $ct_cat_name ) ) {
					$ct_cat_name = esc_html__( 'All categories', 'color-theme-framework' );
					$not_all = false;
				} else {
					$not_all = true;
					$category_link = get_category_link( $category_two );
					$category_bg = get_option("category_$category_two");
					if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';
				}

				$time_id = rand();
			?>

			<ul class="ct-custom-widget recent-posts-by-categories-widget recent-widget-<?php echo esc_attr( $time_id ); ?> clearfix">
				<li class="ct-cat-name">
					<?php if ( !$not_all ) : ?>
						<h3><?php echo esc_attr( $ct_cat_name ); ?></h3>
					<?php else : ?>
						<h3><?php echo '<a href="' . esc_url( $category_link ) . '" style="color: '.$category_bg['category_color'].'">' . $ct_cat_name . '</a>'; ?></h3>
					<?php endif; ?>
				</li>
				<?php while( $recent_posts->have_posts() ): $recent_posts->the_post(); ?>
						<li class="clearfix">
							<?php ct_get_bycategory_meta( $show_comments, $show_views, $show_likes ); ?>
						</li>
				<?php endwhile; ?>
			</ul>
		<?php else : esc_html_e('No posts were found for display','color-theme-framework');
		endif; ?>

		<?php wp_reset_postdata(); ?>

		<?php
			/**
			 * Third Column
			 *
			 */
			$recent_posts = new WP_Query(array(
				'showposts'				=> $num_posts,
				'ignore_sticky_posts'	=> 1,
				'cat'					=> $category_three
			));
		?>

		<?php if ( $recent_posts->have_posts() ) : ?>
			<?php
				$not_all = false;

				$ct_cat_name = get_cat_name( $category_three );
				if ( empty( $ct_cat_name ) ) {
					$ct_cat_name = esc_html__( 'All categories', 'color-theme-framework' );
					$not_all = false;
				} else {
					$not_all = true;
					$category_link = get_category_link( $category_three );
					$category_bg = get_option("category_$category_three");
					if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';
				}

				$time_id = rand();
			?>
			<ul class="ct-custom-widget recent-posts-by-categories-widget recent-widget-<?php echo esc_attr( $time_id ); ?> clearfix">
				<li class="ct-cat-name">
					<?php if ( !$not_all ) : ?>
						<h3><?php echo esc_attr( $ct_cat_name ); ?></h3>
					<?php else : ?>
						<h3><?php echo '<a href="' . esc_url( $category_link ) . '" style="color: '.$category_bg['category_color'].'">' . $ct_cat_name . '</a>'; ?></h3>
					<?php endif; ?>
				</li>
				<?php while( $recent_posts->have_posts() ): $recent_posts->the_post(); ?>
						<li class="clearfix">
							<?php ct_get_bycategory_meta( $show_comments, $show_views, $show_likes ); ?>
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
		$instance['category_one'] 		= $new_instance['category_one'];
		$instance['category_two'] 		= $new_instance['category_two'];
		$instance['category_three'] 	= $new_instance['category_three'];
		$instance['show_likes'] 		= $new_instance['show_likes'];
		$instance['show_views'] 		= $new_instance['show_views'];
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
		$defaults = array(
			'title'					=>	esc_html__( 'Recent Posts' , 'color-theme-framework' ),
			'icon_class' 			=> 'picture-o',
			'num_posts'				=>	4,
			'category_one'			=>	'all',
			'category_two'			=>	'all',
			'category_three'		=>	'all',
			'show_likes' 			=> 'off',
			'show_views'			=> 'off',
			'show_comments'			=> 'on',
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
		<label for="<?php echo $this->get_field_id('category_one'); ?>"><?php esc_html_e( 'First Category:' , 'color-theme-framework' ); ?></label>
		<select id="<?php echo $this->get_field_id('category_one'); ?>" name="<?php echo $this->get_field_name('category_one'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['category_one'] ) echo 'selected="selected"'; ?>>all categories</option>
			<?php $category_one = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
			<?php foreach( $category_one as $category ) { ?>
			<option value='<?php echo esc_attr( $category->term_id ); ?>' <?php if ($category->term_id == $instance['category_one']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('category_two'); ?>"><?php esc_html_e( 'Second Category:' , 'color-theme-framework' ); ?></label>
		<select id="<?php echo $this->get_field_id('category_two'); ?>" name="<?php echo $this->get_field_name('category_two'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['category_two'] ) echo 'selected="selected"'; ?>>all categories</option>
			<?php $category_two = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
			<?php foreach( $category_two as $category ) { ?>
			<option value='<?php echo esc_attr( $category->term_id ); ?>' <?php if ($category->term_id == $instance['category_two']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('category_three'); ?>"><?php esc_html_e( 'Third Category:' , 'color-theme-framework' ); ?></label>
		<select id="<?php echo $this->get_field_id('category_three'); ?>" name="<?php echo $this->get_field_name('category_three'); ?>" class="widefat categories" style="width:100%;">
			<option value='all' <?php if ( 'all' == $instance['category_three'] ) echo 'selected="selected"'; ?>>all categories</option>
			<?php $category_three = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
			<?php foreach( $category_three as $category ) { ?>
			<option value='<?php echo esc_attr( $category->term_id ); ?>' <?php if ($category->term_id == $instance['category_three']) echo 'selected="selected"'; ?>><?php echo $category->cat_name; ?></option>
			<?php } ?>
		</select>
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
		<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
		<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
	</p>

	<?php
	}
}

?>