<?php
/**
 * WooCommerce cart nav in header
 */

global $woocommerce; ?>
<ul class="cart-nav">
    <li class="welcome">
<?php if ( is_user_logged_in() ) {
		global $current_user;
		get_currentuserinfo();
		if ( $current_user->user_firstname )
			echo sprintf( __( 'Welcome, %s', 'newsplus' ), $current_user->user_firstname );
		elseif ( $current_user->display_name )
			echo sprintf( __( 'Welcome, %s', 'newsplus' ), $current_user->display_name );
		else
			echo sprintf( __( 'Welcome, %s', 'newsplus' ), $current_user->user_login );
		}
		else {
		_e( 'Welcome, Guest', 'newsplus' );
    } ?>
    </li>
    <?php if ( is_user_logged_in() ) { ?>
    <li><a class="log-out" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e( 'Log out of your account', 'newsplus' ); ?>"><?php _e( 'Logout', 'newsplus' ); ?></a></li>
    <?php }
    else { ?>
    <li><a class="log-in" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e( 'Login or register for a new account', 'newsplus' ); ?>"><?php _e( 'Login / Register', 'newsplus' ); ?></a></li>
    <?php } ?>
    <li class="cart-status"><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'newsplus'); ?>"><?php echo sprintf( _n('%d item - ', '%d items - ', $woocommerce->cart->cart_contents_count, 'newsplus'), $woocommerce->cart->cart_contents_count); echo $woocommerce->cart->get_cart_subtotal(); ?></a></li>
</ul><!-- .account-nav -->