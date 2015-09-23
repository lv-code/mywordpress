<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<header class="entry-header">
			<div class="comments-title">
				<h3><?php printf( _n( '1 comment', '<span>%1$s</span> comments', get_comments_number(), 'color-theme-framework' ), get_comments_number() );?> <?php esc_html_e( 'on&nbsp;', 'color-theme-framework' ); esc_html_e( '"', "color-theme-framework" ); the_title(); esc_html_e( '"', 'color-theme-framework'); ?></h3>
				<i class="fa fa-comments"></i>
			</div>
		</header>
		<ol class="comment-list clearfix">
			<?php
				wp_list_comments( array(
					'style'      => 'ul',
					'short_ping' => true,
					'avatar_size'=> 60,
					'callback'	=> 'ct_comment'
				) );
			?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>

		<nav class="pagination clearfix">
  			<?php paginate_comments_links(); ?>
 		</nav>

		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php esc_html_e( 'Comments are closed.' , 'color-theme-framework' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->