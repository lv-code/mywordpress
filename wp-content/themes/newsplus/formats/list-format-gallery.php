<?php
/* List Format - Gallery */

global $list_big_width, $list_big_height, $list_big_crop;
$images = get_children(
	array(
		'post_parent' 		=> $post->ID,
		'post_type'			=> 'attachment',
		'post_mime_type'	=> 'image',
		'orderby'			=> 'menu_order',
		'order'				=> 'ASC',
		'numberposts'		=> 999
	)
);
if ( $images ): ?>
    <div class="entry-list-left">
	<script type="text/javascript">
		jQuery(window).load(function(){
			jQuery('#slider-<?php the_ID();?>').flexslider({
				animation: 'slide',
				easing: 'easeInOutExpo',
				animationSpeed: 400,
				slideshowSpeed: 4000,
				selector: '.slides > .slide',
				pauseOnAction: true,
				useCSS: false,
				prevText: '<?php _e( 'Prev', 'newsplus'); ?>',
				nextText: '<?php _e( 'Next', 'newsplus'); ?>',
				controlsContainer: '#slider-<?php the_ID();?>-controls',
				animationLoop: false,
				smoothHeight: false,
				controlNav: false,
				start: function(slider) {
					jQuery(slider).removeClass("flex-loading");
				}
			});
		});
    </script>
    <div class="flexslider flex-loading" id="slider-<?php the_ID();?>"><ul class="slides">
    <?php foreach ( $images as $image ) {
		if ( function_exists( 'aq_resize' ) ) {
			$img_src = wp_get_attachment_image_src( $image->ID, 'full' );
			$img = $img_src[0];
			$crop = ! empty( $list_big_crop ) ? true : false;
			$thumbnail = aq_resize( $img, $list_big_width, $list_big_height, $crop, true, true );
			
			$thumbnail = ! empty( $thumbnail ) ? $thumbnail : $img;
	
		}
		else {										
			$thumbnail = get_the_post_thumbnail( 'list_big_thumb' );
		}
		
		$alt_text = basename( get_attached_file( $image->ID ) );

		echo '<li class="slide"><img src="' . $thumbnail . '" alt="' . $alt_text . '" /></li>';
    }?>
    </ul></div><!-- #slider-<?php the_ID();?> -->
    <div id="slider-<?php the_ID();?>-controls" class="flex-controls-container"></div><!-- .flex-controls-container -->
    </div><!-- .entry-list-left -->
<?php endif; ?>
<div class="entry-list-right<?php if( ! $images ) echo(' no-image'); ?>">