<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "#main" div.
 */
 
// Global variables
global $pls_disable_resp_css, $pls_disable_resp_menu, $pls_top_bar_hide, $pls_header_style, $pls_cb_item_left, $pls_cb_item_right, $pls_cb_text_left, $pls_cb_text_right;

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( 'true' != $pls_disable_resp_css ) : ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <?php endif; ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php if ( is_active_sidebar( 'top-widget-area' ) ) { ?>
        <div class="wrap top-widget-area">
        <?php dynamic_sidebar( 'top-widget-area' ); ?>
        </div><!-- .top-widget-area -->
    <?php } ?>
    <div id="page" class="hfeed site clear">
    <?php if ( 'true' != $pls_top_bar_hide ) : ?>
        <div id="utility-top">
            <div class="wrap clear">
                <?php if ( 'menu' == $pls_cb_item_left ) : ?>
                <nav id="optional-nav" class="secondary-nav">
                    <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_class' => 'sec-menu clear', 'container' => false ) ); ?>
                </nav><!-- #optional-nav -->
                <?php else : ?>
                <div id="callout-bar" class="callout-left" role="complementary">
                    <div class="callout-inner">
                    <?php echo do_shortcode( stripslashes( $pls_cb_text_left ) ); ?>
                    </div><!-- .callout-inner -->
                </div><!-- #callout-bar -->
                <?php endif;
                if ( 'searchform' == $pls_cb_item_right ) {  ?>
                <div id="search-bar" role="complementary">
                    <?php get_search_form(); ?>
                </div><!-- #search-bar -->
                <?php }
                elseif ( 'cart' == $pls_cb_item_right && class_exists( 'woocommerce' ) ) {
                    get_template_part( 'woocommerce/cart-nav' );			
                }
                else { ?>
                    <div id="callout-bar" role="complementary">
                        <div class="callout-inner">
                        <?php echo do_shortcode( stripslashes( $pls_cb_text_right ) );  ?>
                        </div><!-- .callout-inner -->
                    </div><!-- #callout-bar -->
                <?php } // callout bar item check ?>
            </div><!-- #utility-top .wrap -->
        </div><!-- #utility-top-->
		<?php endif; ?>
        <header id="header" class="site-header" role="banner">
            <div class="wrap full-width clear">
			<?php if ( 'full-width' == $pls_header_style )
				get_template_part( 'includes/header-full-width' );
			elseif ( 'three-col' == $pls_header_style )
				get_template_part( 'includes/header-three-col' );
			else
				get_template_part( 'includes/header-default' );
			?>
            </div><!-- #header .wrap -->
        </header><!-- #header -->
        <?php if ( 'true' != $pls_disable_resp_css ) {
            if ( 'true' != $pls_disable_resp_menu ) { ?>
                <nav id="responsive-menu">
                <h3 id="menu-button-1" class="menu-button"><?php _e( 'Menu', 'newsplus' ); ?><span class="toggle-icon"><span class="bar-1"></span><span class="bar-2"></span><span class="bar-3"></span></span></h3>
                </nav>
            <?php }
            } ?>
        <nav id="main-nav" class="primary-nav<?php if ( 'true' == $pls_disable_resp_menu ) echo ' do-not-hide'; ?>" role="navigation">
            <div class="wrap">
                <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu clear', 'container' => false ) ); ?>
            </div><!-- .primary-nav .wrap -->
        </nav><!-- #main-nav -->
        <?php if ( is_active_sidebar( 'widget-area-before-content' ) ) : ?>
            <div id="widget-area-before-content">
                <div class="wrap">
					<?php dynamic_sidebar( 'widget-area-before-content' ); ?>
                </div><!--.wrap -->
            </div><!-- #widget-area-before-content -->
        <?php endif; ?>
        <div id="main">
            <div class="wrap clear">
            	<div class="content-row">