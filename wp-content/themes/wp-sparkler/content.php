<?php
/**
 * The template for displaying posts in the Standard post format
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */
?>
<?php global $ct_options; ?>

<?php isset( $ct_options['blog_layout'] ) ? $blog_layout = $ct_options['blog_layout'] : $blog_layout = 'two_columns'; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-post clearfix" ); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<?php if ( $blog_layout == 'two_columns' ) : ?>
		<div class="row">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="col-md-6">
					<?php ct_get_featured_image(); ?>
				</div> <!-- .col-md-6 -->
			<?php endif; ?>
			<div class="<?php if ( has_post_thumbnail() ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-* -->
		</div> <!-- .row -->
	<?php else : ?>
		<div class="row">
			<div class="col-md-12">
				<?php ct_get_featured_image(); ?>
			</div> <!-- .col-md-12 -->
			<div class="col-md-12">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-12 -->
		</div> <!-- .row -->
	<?php endif; ?>
</article><!-- #post-## -->