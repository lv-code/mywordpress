<?php
/**
 * Header area - three columnar style
 */

global $pls_logo_align;

if ( 'left' == $pls_logo_align ) { ?>
    <div class="brand column one-third" role="banner">
        <?php newsplus_logo(); ?>
    </div><!-- .column one-third -->
<?php }
else {
	if ( is_active_sidebar( 'default-header-col-1' ) ) : ?>
		<div class="column one-third">
			<?php dynamic_sidebar( 'default-header-col-1' ); ?>
		</div><!-- .column one-third -->
	<?php endif;
}

if ( 'center' == $pls_logo_align ) { ?>
    <div class="brand column one-third" role="banner">
        <?php newsplus_logo(); ?>
    </div><!-- .column one-third -->
<?php }
else {
	if ( is_active_sidebar( 'default-header-col-2' ) ) : ?>
		<div class="column one-third">
			<?php dynamic_sidebar( 'default-header-col-2' ); ?>
		</div><!-- .column one-third -->
	<?php endif;
}

if ( 'right' == $pls_logo_align ) { ?>
    <div class="brand column one-third last" role="banner">
        <?php newsplus_logo(); ?>
    </div><!-- .column one-third last -->
<?php }
else {
	if ( is_active_sidebar( 'default-header-col-3' ) ) : ?>
		<div class="column one-third last">
			<?php dynamic_sidebar( 'default-header-col-3' ); ?>
		</div><!-- .column one-third last -->
	<?php endif;
} ?>