<?php
/* Post Format - Standard */

global $pls_archive_template, $grid_width, $grid_height, $grid_crop, $classic_width, $classic_height, $classic_crop;

echo '<div class="post-thumb">';
	if ( function_exists( 'aq_resize' ) ) {
		$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		$img = $img_src[0];
		
		if ( is_archive() && 'classic-style' == $pls_archive_template ) {
			$crop = ! empty( $classic_crop ) ? true : false;
			$thumbnail = aq_resize( $img, $classic_width, $classic_height, $crop, true, true );
		}
		else {
			$crop = ! empty( $grid_crop ) ? true : false;
			$thumbnail = aq_resize( $img, $grid_width, $grid_height, $crop, true, true );
		}
		
		$thumbnail = ! empty( $thumbnail ) ? $thumbnail : $img;
		
	}
	else {										
		$thumbnail = get_the_post_thumbnail( 'grid_thumb' );
	}
	
	$alt_text = basename( get_attached_file( get_post_thumbnail_id( get_the_ID() ) ) );
	
	echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '"><img src="' . $thumbnail . '" class="attachment-post-thumbnail wp-post-image" alt="' . $alt_text . '"></a>';
echo '</div>';