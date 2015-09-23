<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Sparkler
 * @since Sparkler 1.0
 */
?>
<?php global $ct_options; ?>
<?php
	isset( $ct_options['enable_copyrights'] ) ? $enable_copyrights = $ct_options['enable_copyrights'] : $enable_copyrights = 1;
	isset( $ct_options['copyright_text'] ) ? $copyright_text = $ct_options['copyright_text'] : $copyright_text = '2015 Copyright. Proudly powered by <a href="' . esc_url( __( "http://wordpress.org/","color-theme-framework" ) ). '">WordPress</a>.<br /><a href="' . esc_url( __( "http://themeforest.net/user/ZERGE?ref=zerge", "color-theme-framework" ) ) .'">Sparkler</a> Theme by <a href="' . esc_url( __( "http://color-theme.com/", "color-theme-framework" ) ) . '">Color Theme</a>.';
?>
	<?php if ( $enable_copyrights and !empty( $copyright_text ) or has_nav_menu('footer_menu')  ) : ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<footer id="mainfooter" class="clearfix">
						<a href="#" class="ct-totop" title="<?php esc_html_e('To Top','color-theme-framework'); ?>"><?php esc_html_e( 'To Top', 'color-theme-framework'); ?><i class='fa fa-arrow-circle-o-up'></i></a>
						<?php ct_get_footer_menu(); ?>
						<div class="col-md-12">
							<?php if ( $enable_copyrights and !empty( $copyright_text ) ) : ?>
								<div id="copyright" class="clearfix">
					    			<?php echo do_shortcode( $copyright_text ); ?>
								</div> <!-- #copyright -->
							<?php endif; ?>
						</div> <!-- .col-md-12 -->
					</footer>
				</div> <!-- .col-md-12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	<?php endif; ?>

	<?php wp_footer(); ?>
</body>
</html>