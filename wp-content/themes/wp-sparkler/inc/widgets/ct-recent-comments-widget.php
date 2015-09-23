<?php
/*
-----------------------------------------------------------------------------------

 	Plugin Name: CT Recent Comments Widget
 	Plugin URI: http://www.color-theme.com
 	Description: A widget that show recent comments.
 	Version: 1.0
 	Author: ZERGE
 	Author URI: http://www.color-theme.com

-----------------------------------------------------------------------------------
*/


/**
 * Add function to widgets_init that'll load our widget.
 */

add_action('widgets_init','ct_comments_widget');

function ct_comments_widget() {
	register_widget("CT_comments_Widget");
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class CT_comments_Widget extends WP_widget{

	/**
	 * Widget setup.
	 */
	function CT_comments_Widget(){

		/* Widget settings. */
		$widget_ops = array( 'classname'	=> 'ct-comments-widget',
							 'description'	=> esc_html__( 'Recent Comments' , 'color-theme-framework' )
							);

		/* Create the widget. */
		parent::__construct( 'ct-comments-widget', esc_html__( 'CT: Recent Comments Widget' , 'color-theme-framework' ) ,  $widget_ops );

	}

	function widget($args,$instance){
		extract($args);

		$title 				= apply_filters ('widget_title', $instance ['title']);
		$icon_class 		= ! empty ( $instance['icon_class'] ) ? $instance['icon_class'] : '';
		$num_comments 		= $instance['num_comments'];
		$comment_len 		= $instance['comment_len'];
		$show_avatar 		= isset($instance['show_avatar']) ? '1' : '0';
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
		global $post;
		$time_id = rand();

		$recent_comments = get_comments( array(	'number'	=> $num_comments,
												'status'	=> 'approve'
											));
		?>

		<ul class="recent-comments-widget ct-recent-comments-widget-<?php echo esc_attr( $time_id ); ?> clearfix">
			<?php foreach( $recent_comments as $comment ) { ?>
				<li class="clearfix">
					<div class="widget-content">
						<?php if( $show_avatar ) :
							echo '<div class="user-post-thumbnail">';
							echo get_avatar( $comment, $size='60', $default='', get_comment_author($comment) );
							echo '</div>';
						endif; ?>

						<div class="comment-author">
							<h4 class="entry-title">
								<?php echo ct_get_comment_author($comment); ?>
							</h4>
						</div>

						<div class="comment-text">
							<?php printf( '<a href="%1$s">', esc_url( get_comment_link( $comment->comment_ID ) ) ); ?>
								<?php
								if (is_rtl()) :
									echo strip_tags(mb_substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len ) ) . ' ...';
								else :
									echo strip_tags(mb_substr(apply_filters('get_comment_text', $comment->comment_content), 0, $comment_len ) ) . ' ...';
								endif;
								?>
							</a>
						</div><!-- .comment-text -->


						<div class="comment-time">
							<?php echo ct_get_time_ago( $comment ); ?>
						</div><!-- .comment-time -->

					</div> <!-- .widget-content -->
				</li>
			<?php } ?>
		</ul>

	<?php
	// Restor original Post Data
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
		$instance['num_comments'] 		= $new_instance['num_comments'];
		$instance['comment_len'] 		= $new_instance['comment_len'];
		$instance['show_avatar'] 		= $new_instance['show_avatar'];
		$instance['background_title'] 	= $new_instance['background_title'];

		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form($instance){ ?>
		<?php
		$defaults = array(	'title'				=> esc_html__( 'What People Says' , 'color-theme-framework' ),
							'icon_class' 		=> 'comments-o',
							'num_comments'		=> 3,
							'comment_len'		=> 50,
							'show_avatar'		=> 'on',
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
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:' , 'color-theme-framework' ) ?></label>
		<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('icon_class'); ?>"><?php esc_html_e( 'FontAwesome Icon Class Name:' , 'color-theme-framework' ); ?> <a href="<?php echo esc_url( __( 'http://fortawesome.github.io/Font-Awesome/icons/', 'color-theme-framework' ) ); ?>" target="_blank">All Icons</a></label>
		<input type="text" class="widefat" style="width: 100%" id="<?php echo $this->get_field_id('icon_class'); ?>" name="<?php echo $this->get_field_name('icon_class'); ?>" value="<?php echo esc_attr( $instance['icon_class'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('num_comments'); ?>"><?php esc_html_e( 'Number of comments:' , 'color-theme-framework' ); ?></label>
		<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('num_comments'); ?>" name="<?php echo $this->get_field_name('num_comments'); ?>" value="<?php echo esc_attr( $instance['num_comments'] ); ?>" />

	</p>

	<p>
		<label for="<?php echo $this->get_field_id('comment_len'); ?>"><?php esc_html_e( 'Length of comments:' , 'color-theme-framework' ); ?></label>
		<input type="number" min="1" max="100" class="widefat" id="<?php echo $this->get_field_id('comment_len'); ?>" name="<?php echo $this->get_field_name('comment_len'); ?>" value="<?php echo esc_attr( $instance['comment_len'] ); ?>" />

	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked($instance['show_avatar'], 'on'); ?> id="<?php echo $this->get_field_id('show_avatar'); ?>" name="<?php echo $this->get_field_name('show_avatar'); ?>" />
		<label for="<?php echo $this->get_field_id('show_avatar'); ?>"><?php esc_html_e( 'Show user avatar' , 'color-theme-framework' ); ?></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('background_title'); ?>" style="display:block;"><?php esc_html_e('Title Background Color:', 'color-theme-framework'); ?></label>
		<input class="ct-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_title' ); ?>" name="<?php echo $this->get_field_name( 'background_title' ); ?>" value="<?php echo esc_attr( $instance['background_title'] ); ?>" data-default-color="#222b31" />
	</p>

	<?php

	}
}
?>