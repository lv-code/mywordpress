<?php
/**
 * Header area - full width
 */

global $pls_logo_align;

$logo_class = ( 'none' !== $pls_logo_align ) ? ' text-' . $pls_logo_align : ''; ?>

<div class="brand column full<?php echo $logo_class; ?>">
	<?php
    if ( 'none' !== $pls_logo_align ) {
            newsplus_logo();
    }
    else {
        if ( is_active_sidebar( 'default-header-col-1' ) ) :
                dynamic_sidebar( 'default-header-col-1' );
        endif;
    } ?>
</div><!-- .column full -->