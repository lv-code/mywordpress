<?php
/** 
 * WooCommerce custom hooks and functions used by the theme
 */

/* Disable WooCommerce CSS files
 * All styles are included in theme
 */

add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// Change number or products per row to 3
add_filter( 'loop_shop_columns', 'newsplus_loop_columns' );
if ( ! function_exists( 'newsplus_loop_columns' ) ) {
	function newsplus_loop_columns() {
		return 3; // 3 products per row
	}
}


/* Update WooCommerce cart contents when products are added to the cart via AJAX */

if ( ! function_exists( 'woocommerce_header_add_to_cart_fragment' ) ) {
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;	
		ob_start(); ?>
		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'newsplus' ); ?>"><?php echo sprintf( _n( '%d item - ', '%d items - ', $woocommerce->cart->cart_contents_count, 'newsplus' ), $woocommerce->cart->cart_contents_count); echo $woocommerce->cart->get_cart_subtotal(); ?></a>
		<?php	
		$fragments['a.cart-contents'] = ob_get_clean();	
		return $fragments;
	}
}
add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');


/* Change number of related products and upsell products in WooCommerce */

if ( ! function_exists( 'woocommerce_output_related_products' ) ) {
	function woocommerce_output_related_products() {
		$args = array(
			'posts_per_page' => 3,
			'columns' => 3,
			'orderby' => 'rand'
		);
		woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
	}
}

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
		woocommerce_upsell_display( 3, 3 );
	}
}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );

/** Redefine number of product thumbnail columns on single product page */
add_filter ( 'woocommerce_product_thumbnails_columns', 'xx_thumb_cols' );
function xx_thumb_cols() {
	return 4; // .last class applied to every 4th thumbnail
}
?>