<?php
/* Post Format - Standard */

global $list_big_width, $list_big_height, $list_big_crop;

	if ( function_exists( 'aq_resize' ) ) {
		$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		$img = $img_src[0];
		$alt_text = basename( get_attached_file( get_post_thumbnail_id( get_the_ID() ) ) );
		$crop = ! empty( $list_big_crop ) ? true : false;
		$thumbnail = aq_resize( $img, $list_big_width, $list_big_height, $crop, true, true );
		
		$thumbnail = ! empty( $thumbnail ) ? $thumbnail : $img;

	}
	else {										
		$thumbnail = get_the_post_thumbnail( 'list_big_thumb' );
	}
	
	if ( $thumbnail ) {
		echo '<div class="entry-list-left">';
			echo '<div class="entry-thumb"><a href="' . get_permalink() . '" title="' . get_the_title() . '"><img src="' . $thumbnail . '" class="attachment-post-thumbnail wp-post-image" alt="' . $alt_text . '"></a></div>';
		echo '</div>';
	}
	?>
	
<div class="entry-list-right<?php if ( ! $thumbnail ) echo(' no-image'); ?>">