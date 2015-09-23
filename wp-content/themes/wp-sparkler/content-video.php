<?php
/**
 * The template for displaying posts in the Video post format
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */
?>
<?php
	global $ct_options, $post;

	isset( $ct_options['blog_layout'] ) ? $blog_layout = $ct_options['blog_layout'] : $blog_layout = 'two_columns';

	$video_type = get_post_meta( get_the_ID(), 'ct_mb_post_video_type', true );
	$videoid = get_post_meta( get_the_ID(), 'ct_mb_post_video_file', true );
	$video_thumb = get_post_meta( get_the_ID(), 'ct_mb_post_video_thumb', true );

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-post clearfix" ); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<?php if ( $blog_layout == 'two_columns' ) : ?>
		<div class="row">
			<?php if ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) :
					echo '<div class="col-md-6">';
						echo '<div class="entry-video-post post-thumbnail">';
					    	if ( $video_type == 'youtube' ) {
								echo '<iframe src="http://www.youtube.com/embed/' . $videoid .'?wmode=opaque"></iframe>';
							} else if ( $video_type == 'vimeo' ) {
								echo '<iframe src="http://player.vimeo.com/video/' . $videoid . '"></iframe>';
							} else if ( $video_type == 'dailymotion' ) {
								echo '<iframe src="http://www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
							}
						echo '</div><!-- .entry-video-post -->';
					echo '</div> <!-- .col-md-6 -->';
				elseif ( has_post_thumbnail() ) : ?>
					<div class="col-md-6">
						<?php ct_get_featured_image(); ?>
					</div> <!-- .col-md-6 -->
			<?php endif; ?>

			<div class="<?php if ( has_post_thumbnail() or ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-* -->
		</div> <!-- .row -->
	<?php else : ?>
		<div class="row">
			<?php if ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) :
					echo '<div class="col-md-12">';
						echo '<div class="entry-video-post post-thumbnail">';
					    	if ( $video_type == 'youtube' ) {
								echo '<iframe src="http://www.youtube.com/embed/' . $videoid .'?wmode=opaque"></iframe>';
							} else if ( $video_type == 'vimeo' ) {
								echo '<iframe src="http://player.vimeo.com/video/' . $videoid . '"></iframe>';
							} else if ( $video_type == 'dailymotion' ) {
								echo '<iframe src="http://www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
							}
						echo '</div><!-- .entry-video-post -->';
					echo '</div> <!-- .col-md-12 -->';
				elseif ( has_post_thumbnail() ) : ?>
					<div class="col-md-12">
						<?php ct_get_featured_image(); ?>
					</div> <!-- .col-md-12 -->
			<?php endif; ?>

			<div class="col-md-12">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-* -->
		</div> <!-- .row -->
	<?php endif; ?>
</article><!-- #post-## -->