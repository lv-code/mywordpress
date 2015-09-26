<?php
/* Grid Format - Gallery */

global $pls_archive_template, $grid_width, $grid_height, $grid_crop, $classic_width, $classic_height, $sng_width, $sng_height;
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
			$crop = ! empty( $grid_crop ) ? true : false;
			$thumbnail = aq_resize( $img, $grid_width, $grid_height, $crop, true, true );
			
			if ( is_single() ) {
				$thumbnail = aq_resize( $img, $sng_width, $sng_height, true, true, true );
			}
			
			elseif ( is_archive() && 'classic-style' == $pls_archive_template ) {
				$thumbnail = aq_resize( $img, $classic_width, $classic_height, true, true, true );
			}
			
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
<?php endif; ?>