<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Soarkler
 * @since Soarkler 1.0
 */
?>
<?php
    global $ct_options, $post;
    $page_desc = get_post_meta( $post->ID, 'ct_mb_page_desc', true);
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('entry-page'); ?>>
	<?php if( !empty( $page_desc ) ) : ?>
		<div class="ct-page-description">
		<?php echo $page_desc; ?>
		</div> <!-- .ct-page-description -->
	<?php endif; ?>
	<div class="entry-content clearfix">
			<div class="single-title"><?php the_title( '<h1 class="entry-title">', '</h1>' ); ?></div>
			<?php the_content(); ?>
			<div class="clear"></div>

			<?php
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'color-theme-framework' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );

				edit_post_link( __( 'Edit', 'color-theme-framework' ), '<span class="edit-link">', '</span>' );
			?>
	</div><!-- .entry-content -->
</div><!-- #post-## -->