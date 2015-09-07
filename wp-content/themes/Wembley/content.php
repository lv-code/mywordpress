<?php
/**
 * @package web2feel
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 col-sm-4 pbox'); ?>>

		<?php
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 720, 560, true ); //resize & crop the image
		?>
					
		<?php if($image) : ?>
		<a href="<?php the_permalink(); ?>"> <img class="img-responsive" src="<?php echo $image ?>"/></a>
		<?php endif; ?>	
		
		<h2 class="box-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<div class="box-meta"><?php the_category(', '); ?></div>	
</article><!-- #post-## -->
