<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */
?>
<?php
	global $ct_options, $post;

	isset( $ct_options['blog_layout'] ) ? $blog_layout = $ct_options['blog_layout'] : $blog_layout = 'two_columns';

	$soundcloud = get_post_meta( $post->ID, 'ct_mb_post_soundcloud', true );
	$audio_thumb_type = get_post_meta( $post->ID, 'ct_mb_post_audio_thumb', true );

	if ( !empty( $soundcloud ) && ( $audio_thumb_type == '' ) ) {
		$audio_thumb_type = 'player';
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-post scrollflow -slide-top -opacity clearfix" ); ?> data-scrollflow-start="20" itemscope itemtype="http://schema.org/BlogPosting">
    <?php if ( $blog_layout == 'two_columns' ) : ?>
	    <div class="row">
		    <?php if ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) : ?>
		    	<div class="col-md-6">
					<div class="post-thumbnail">
						<?php echo $soundcloud; ?>
					</div> <!-- .post-thumbnail -->
				</div> <!-- .col-md-6 -->
			<?php elseif ( has_post_thumbnail() ) : ?>
					<div class="col-md-6">
						<?php ct_get_featured_image(); ?>
					</div> <!-- .col-md-6 -->
			<?php endif; ?>

			<div class="<?php if ( has_post_thumbnail() or ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-* -->
		</div> <!-- .row -->
	<?php else : ?>
	    <div class="row">
		    <?php if ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) : ?>
		    	<div class="col-md-12">
					<div class="post-thumbnail">
						<?php echo $soundcloud; ?>
					</div> <!-- .post-thumbnail -->
				</div> <!-- .col-md-12 -->
			<?php elseif ( has_post_thumbnail() ) : ?>
					<div class="col-md-12">
						<?php ct_get_featured_image(); ?>
					</div> <!-- .col-md-12 -->
			<?php endif; ?>

			<div class="col-md-12">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-12 -->
		</div> <!-- .row -->
	<?php endif; ?>
</article><!-- #post-## -->