<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */
?>
<?php global $ct_options, $wpdb, $post; ?>

<?php isset( $ct_options['blog_layout'] ) ? $blog_layout = $ct_options['blog_layout'] : $blog_layout = 'two_columns'; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( "entry-post clearfix" ); ?> itemscope itemtype="http://schema.org/BlogPosting">
	<?php if ( $blog_layout == 'two_columns' ) : ?>
		<div class="row">
		<?php
			$time_id = rand();
			$meta = get_post_meta( get_the_ID(), 'ct_mb_gallery', false);

			if (!is_array($meta)) $meta = (array) $meta;

			if ( !empty( $meta ) and !has_post_thumbnail() ) : ?>
				<div class="col-md-6">
					<figure class="post-thumbnail">
						<?php
							$meta = implode(',', $meta);
							$order_key = 'attachment';

							$images = $wpdb->get_col( $wpdb->prepare( "
								SELECT ID FROM $wpdb->posts
								WHERE post_type = %s
								AND ID in ($meta)
								ORDER BY menu_order ASC
							", $order_key ) );
								$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

						?>
						<a href="<?php echo esc_url( the_permalink() ); ?>">
							<?php ct_get_post_format(); ?>
							<div class="thumb-mask"></div>
							<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
						</a>
					</figure> <!-- .post-thumbnail -->
				</div> <!-- .col-md-6 -->
			<?php else : ?>
				<div class="col-md-6">
					<?php ct_get_featured_image(); ?>
				</div> <!-- .col-md-6 -->
			<?php endif; ?>
			<div class="<?php if ( !empty( $meta ) or has_post_thumbnail() ) { echo 'col-md-6'; } else { echo 'col-md-12'; } ?>">
				<?php ct_get_content(); ?>
			</div> <!-- .col-md-* -->
		</div> <!-- .row -->
	<?php else : ?>
		<div class="row">
		<?php
			$meta = get_post_meta( get_the_ID(), 'ct_mb_gallery', false);

			if (!is_array($meta)) $meta = (array) $meta;

			if ( !empty( $meta ) and !has_post_thumbnail() ) : ?>
				<div class="col-md-12">
					<figure class="post-thumbnail">
						<?php
							$meta = implode(',', $meta);
							$order_key = 'attachment';

							$images = $wpdb->get_col( $wpdb->prepare( "
								SELECT ID FROM $wpdb->posts
								WHERE post_type = %s
								AND ID in ($meta)
								ORDER BY menu_order ASC
							", $order_key ) );
								$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

						?>
						<a href="<?php echo esc_url( the_permalink() ); ?>">
							<?php ct_get_post_format(); ?>
							<div class="thumb-mask"></div>
							<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
						</a>
					</figure> <!-- .post-thumbnail -->
				</div> <!-- .col-md-12 -->
			<?php else : ?>
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