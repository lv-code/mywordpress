<?php
/**
 * NewsPlus functions and definitions.
 *
 * Contains helper functions used in the theme, along with functions
 * that are attached to action and filter hooks in WordPress.

 * Most functions in this file are pluggable, and can be used in Child Theme.
 * Functions that are not pluggable (not wrapped in function_exists()) are attached
 * to a filter or action hook.
 *
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 660;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * NewsPlus supports.
 */
function newsplus_setup() {

	// Make theme options variables globally available for use
	global $options;
	foreach ( $options as $value ) {
		if( isset( $value['id'] ) && isset( $value['std'] ) ) {
			global $$value['id'];
			if ( get_option( $value['id'] ) === FALSE )
				$$value['id'] = $value['std'];
			else
				$$value['id'] = get_option( $value['id'] );
		}
	}

	// Makes theme available for translation.
	load_theme_textdomain( 'newsplus', get_template_directory() . '/languages' );
	
	// Title tag automatically managed by WordPress
	add_theme_support( 'title-tag' );

	// Add visual editor stylesheet support
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Add post formats
	add_theme_support( 'post-formats', array( 'gallery', 'video' ) );
	
	// Add support for html5 search form
	add_theme_support( 'html5', array( 'search-form' ) );

	// Add navigation menus
	register_nav_menus( array(
		'secondary'	=> __( 'Secondary Top Menu', 'newsplus' ),
		'primary'	=> __( 'Primary Menu', 'newsplus' )
	) );

	// Add support for custom background and set default color
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff',
		'default-image' => ''
	) );

	// Add suport for post thumbnails and set default sizes
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 800, 9999 );

	// Add custom image sizes
	add_image_size( 'size_max', 1000, 9999 );
	
	// One Columnar Grid Posts
	add_image_size( 'grid_thumb', $grid_width, $grid_height, $grid_crop );

	// List Big
	add_image_size( 'list_big_thumb', $list_big_width, $list_big_height, $list_big_crop );

	// List Small
	add_image_size( 'list_small_thumb', $list_small_width, $list_small_height, $list_small_crop );

	// Related Posts
	add_image_size( 'related_posts_thumb', $rp_width, $rp_height, $rp_crop );

	// Minifolio Widget
	add_image_size( 'minifolio_thumb', $mf_width, $mf_height, $mf_crop );
	
	// Single Post
	add_image_size( 'single_thumb', $sng_width, $sng_height, $sng_crop );


	// Declare theme as WooCommerce compatible
	update_option( 'woocommerce_admin_notices', array( 'template_files' ) );

}
add_action( 'after_setup_theme', 'newsplus_setup' );


/**
 * Include widgets and theme option files
 */
require_once( 'includes/post-options.php' );
require_once( 'includes/page-options.php' );
require_once( 'includes/theme-admin-options.php' );
require_once( 'includes/breadcrumbs.php' );
require_once( 'includes/theme-customizer.php' );
require_once( 'includes/class-tgm-plugin-activation.php' );
require_once( 'woocommerce/woocommerce-hooks.php' );


/**
 * Enqueue scripts and styles for front-end.
 */
function newsplus_scripts_styles() {
	global $wp_styles, $pls_archive_template, $pls_scheme, $pls_disable_resp_css, $pls_disable_resp_menu, $pls_enable_rtl_css, $pls_disable_user_css, $pls_disable_prettyphoto, $pls_ss_sharing, $pls_ss_tw, $pls_ss_gp, $pls_ss_pint, $pls_ss_ln, $pls_ss_vk, $pls_ss_yandex, $pls_disable_custom_font, $pls_font_family, $pls_font_subset, $pls_top_bar_sticky, $pls_main_bar_sticky;

	/*
	 * Add JavaScript for threaded comments when required
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Add JavaScript plugins required by the theme
	 */
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jq-hover-intent', get_template_directory_uri() . '/js/jquery.hoverIntent.minified.js', array(), '', true );

	if ( 'true' !== $pls_disable_prettyphoto )
	wp_enqueue_script( 'jq-pretty-photo', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array(), '', true );

	// For contact page template
	if( is_page_template( 'templates/page-contact.php' ) ) {
		wp_register_script( 'jq-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array(), '', true );
		wp_enqueue_script( 'contact-form', get_template_directory_uri() . '/js/contact-form.js', array( 'jq-validate' ), '', true );
	}

	// Load social sharing scripts in footer
	if( is_single() && 'true' == $pls_ss_sharing ) {
		$protocol = is_ssl() ? 'https' : 'http';
		if( 'true' == $pls_ss_tw )
			wp_enqueue_script( 'twitter_share_script', $protocol . '://platform.twitter.com/widgets.js', '', '', true );
		if( 'true' == $pls_ss_gp )
			wp_enqueue_script( 'google_plus_script', $protocol . '://apis.google.com/js/plusone.js', '', '', true );
		if( 'true' == $pls_ss_pint )
			wp_enqueue_script( 'pinterest_script', $protocol . '://assets.pinterest.com/js/pinit.js', '', '', true );
		if( 'true' == $pls_ss_ln )
			wp_enqueue_script( 'linkedin_script', $protocol . '://platform.linkedin.com/in.js', '', '', true );
		if( 'true' == $pls_ss_vk )
			wp_enqueue_script( 'vk_script', $protocol . '://vkontakte.ru/js/api/share.js?9' );
		if( 'true' == $pls_ss_yandex )
			wp_enqueue_script( 'yandex_script', $protocol . '://yandex.st/share/share.js', '', '', true );
	}

	// Custom JavaScript file used to initialize plugins
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array(), '', true );
	
	// Localize responsivene menu check for custom.js file
	$translation_array = array(
		'top_bar_sticky'	=> $pls_top_bar_sticky,
		'main_bar_sticky'	=> $pls_main_bar_sticky,
		'expand_menu_text'	=> __( 'Expand or collapse menu items.', 'newsplus' )
	);
	
	if ( 'true' !== $pls_disable_resp_css ) {
		if ( 'true' !== $pls_disable_resp_menu ) {
			$translation_array[ 'enable_responsive_menu' ] = 'true';
		}
	}
		
	wp_localize_script( 'custom', 'ss_custom', $translation_array );
	
	/*
	 * Google font CSS file
	 *
	 * The use of custom Google fonts can be configured inside Theme Options Panel.
	 */

	if ( 'true' !== $pls_disable_custom_font ) {
		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => $pls_font_family,
			'subset' => $pls_font_subset,
		);
		wp_enqueue_style( 'newsplus-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Load stylesheets required by the theme
	 */

	// Main stylesheet
	wp_enqueue_style( 'newsplus-style', get_stylesheet_uri() );

	// Internet Explorer specific stylesheet
	wp_enqueue_style( 'newsplus-ie', get_template_directory_uri() . '/css/ie.css', array(), '' );
	$wp_styles->add_data( 'newsplus-ie', 'conditional', 'lt IE 9' );

	// WooCommerce Custom stylesheet
	if ( class_exists( 'woocommerce' )  ) {
		wp_register_style( 'woocommerce-custom', get_template_directory_uri() . '/woocommerce/woocommerce-custom.css', array(), '' );
		wp_enqueue_style( 'woocommerce-custom' );
	}
	
	// RTL stylesheet
	if ( 'true' == $pls_enable_rtl_css || is_rtl() ) {
		wp_register_style( 'rtl', get_template_directory_uri() . '/rtl.css', array(), '' );
		wp_enqueue_style( 'rtl' );
	}

	// Responsive stylesheet
	if ( 'true' != $pls_disable_resp_css ) {
		wp_register_style( 'newsplus-responsive', get_template_directory_uri() . '/responsive.css', array(), '' );
		wp_enqueue_style( 'newsplus-responsive' );

		// Load RTL responsive only if RTL version enabled
		if ( 'true' == $pls_enable_rtl_css || is_rtl() ) {
			wp_register_style( 'newsplus-rtl-responsive', get_template_directory_uri() . '/rtl-responsive.css', array(), '' );
			wp_enqueue_style( 'newsplus-rtl-responsive' );
		}
	}
	if ( 'true' !== $pls_disable_prettyphoto ) {
		wp_register_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), '' );
		wp_enqueue_style( 'prettyphoto' );
	}

	// User stylesheet
	if ( 'true' != $pls_disable_user_css  ) {
		wp_register_style( 'newsplus-user', get_template_directory_uri() . '/user.css', array(), '' );
		wp_enqueue_style( 'newsplus-user' );
	}
	
}
add_action( 'wp_enqueue_scripts', 'newsplus_scripts_styles', '20' );

/**
 * Enqueue html5 script in head section for old browsers
 */
function newsplus_layout_width() {
	global $pls_layout_width, $pls_base_font_size;
	$width = floatval( $pls_layout_width );
	$font_size = floatval( $pls_base_font_size );
	
	if ( ( $width >= 800 && $width <= 1600 && $width != 1240 ) || ( $font_size >= 11 && $font_size <= 18 && $font_size != 13 ) ) { ?>
	
		<style type="text/css">
		
		<?php if ( $font_size >= 11 && $font_size <= 18 && $font_size != 13 ) { ?>
		
		body {
			font-size: <?php echo $font_size . 'px'; ?>;
		}		
		
		<?php }
		
		if ( $width >= 800 && $width <= 1600 && $width != 1240 ) { ?>
		
		#page {
			max-width: <?php echo $width . 'px'; ?>;
		}
		
		.wrap,
		.primary-nav,
		.is-stretched .primary-nav .wrap,
		#utility-top {
			max-width: <?php echo floatval( $width - 48 ) . 'px'; ?>;
		}
		
		<?php } ?>
		
		</style>
	
	<?php }
}
add_action( 'wp_head', 'newsplus_layout_width' );

/**
 * Enqueue html5 script in head section for old browsers
 */
function html5_js() {
$protocol = is_ssl() ? 'https' : 'http'; ?>
<!--[if lt IE 9]>
<script src="<?php echo $protocol; ?>://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?php }
add_action( 'wp_head', 'html5_js' );

/**
 * Allow custom head markup to be inserted by user from Theme Options
 */
function custom_head_code() {
global $pls_custom_head_code;
if ( '' != $pls_custom_head_code )
	echo stripslashes( $pls_custom_head_code );
}
add_action( 'wp_head', 'custom_head_code');


/**
 * Register theme widget areas
 */
function newsplus_widget_areas() {

	register_sidebar( array(
		'name' 			=> __( 'Top widget area', 'newsplus' ),
		'id' 			=> 'top-widget-area',
		'description' 	=> __( 'Top widget area', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="twa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="twa-title">',
		'after_title' 	=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Fixed widget area left', 'newsplus' ),
		'id' 			=> 'fixed-widget-bar-left',
		'description' 	=> __( 'Fixed widget area on left side', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="fwa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="fwa-title">',
		'after_title' 	=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Fixed widget area right', 'newsplus' ),
		'id' 			=> 'fixed-widget-bar-right',
		'description' 	=> __( 'Fixed widget area on right side', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="fwa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="fwa-title">',
		'after_title' 	=> '</h3>'
	) );

	register_sidebar( array(
		'name' 			=> __( 'Default Header Bar', 'newsplus' ),
		'id' 			=> 'default-headerbar',
		'description' 	=> __( 'Header Bar', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="hwa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="hwa-title">',
		'after_title' 	=> '</h3>',
		'handler'		=> 'headerbar'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Default Header Column 1', 'newsplus' ),
		'id' 			=> 'default-header-col-1',
		'description' 	=> __( 'Header column 1', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="hwa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="hwa-title">',
		'after_title' 	=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Default Header Column 2', 'newsplus' ),
		'id' 			=> 'default-header-col-2',
		'description' 	=> __( 'Header column 2', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="hwa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="hwa-title">',
		'after_title' 	=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Default Header Column 3', 'newsplus' ),
		'id' 			=> 'default-header-col-3',
		'description' 	=> __( 'Header column 3', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="hwa-wrap %2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="hwa-title">',
		'after_title' 	=> '</h3>'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Widget area before content', 'newsplus' ),
		'id' 			=> 'widget-area-before-content',
		'description' 	=> __( 'Widget area before content', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>'
	) );

	register_sidebar( array(
		'name' 			=> __( 'Default Sidebar', 'newsplus' ),
		'id' 			=> 'default-sidebar',
		'description' 	=> __( 'Sidebar', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="sb-title">',
		'after_title' 	=> '</h3>',
		'handler'		=> 'sidebar'
	) );
	
	register_sidebar( array(
		'name' 			=> __( 'Widget area after content', 'newsplus' ),
		'id' 			=> 'widget-area-after-content',
		'description' 	=> __( 'Widget area after content', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="%2$s">',
		'after_widget'	=> "</aside>",
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>'
	) );

	register_sidebar( array(
		'name' 			=> __( 'Default Secondary Column 1', 'newsplus' ),
		'id' 			=> 'secondary-column-1',
		'description' 	=> __( 'Secondary Column', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="sc-title">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Default Secondary Column 2', 'newsplus' ),
		'id' 			=> 'secondary-column-2',
		'description' 	=> __( 'Secondary Column', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="sc-title">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Default Secondary Column 3', 'newsplus' ),
		'id' 			=> 'secondary-column-3',
		'description' 	=> __( 'Secondary Column', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="sc-title">',
		'after_title' 	=> '</h3>',
	) );

	register_sidebar( array(
		'name' 			=> __( 'Default Secondary Column 4', 'newsplus' ),
		'id' => 'secondary-column-4',
		'description' 	=> __( 'Secondary Column', 'newsplus' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' 	=> "</aside>",
		'before_title' 	=> '<h3 class="sc-title">',
		'after_title' 	=> '</h3>',
	) );

	// Register exclusive widget areas for each page
	$mypages = get_pages();
	foreach ( $mypages as $pp ) {
		$page_opts = get_post_meta( $pp->ID, 'page_options', true );
		$sidebar_a = isset( $page_opts['sidebar_a'] ) ? $page_opts['sidebar_a'] : '';
		$sidebar_h = isset( $page_opts['sidebar_h'] ) ? $page_opts['sidebar_h'] : '';

		if ( 'true' == $sidebar_h ){
			register_sidebar( array(
				'name' 			=> sprintf( __( '%1$s Header Bar', 'newsplus' ), $pp->post_title ),
				'id' 			=> $pp->ID . '-headerbar',
				'description' 	=> 'Header Bar',
				'before_widget' => '<aside id="%1$s" class="hwa-wrap %2$s">',
				'after_widget' 	=> "</aside>",
				'before_title' 	=> '<h3 class="hwa-title">',
				'after_title' 	=> '</h3>',
				'handler'		=> 'headerbar'
			) );
		};
		if ( 'true' == $sidebar_a ){
			register_sidebar( array(
				'name' 			=> sprintf( __( '%1$s Sidebar', 'newsplus' ), $pp->post_title ),
				'id' 			=> $pp->ID . '-sidebar',
				'description' 	=> 'Sidebar',
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' 	=> "</aside>",
				'before_title' 	=> '<h3 class="sb-title">',
				'after_title' 	=> '</h3>',
				'handler'		=> 'sidebar'
			) );
		}
	} // foreach
}
add_action( 'widgets_init', 'newsplus_widget_areas' );

/**
 * Theme Comments
 */
if ( ! function_exists( 'newsplus_comments' ) ) :
	function newsplus_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'newsplus' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'newsplus' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
		break;
		default :
		// Proceed with normal comments.
		global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment">
				<header class="comment-meta comment-author vcard">
					<?php
						echo get_avatar( $comment, 48 );
						printf( '<cite class="fn">%1$s %2$s</cite>',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'newsplus' ) . '</span>' : ''
						);
						printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'newsplus' ), get_comment_date(), get_comment_time() )
						);
					?>
				</header><!-- .comment-meta -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'newsplus' ); ?></p>
				<?php endif; ?>

				<section class="comment-content comment">
					<?php comment_text(); ?>
					<?php edit_comment_link( __( 'Edit', 'newsplus' ), '<p class="edit-link">', '</p>' ); ?>
				</section><!-- .comment-content -->

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'newsplus' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
		<?php
        break;
	endswitch; // end comment_type check
}
endif;

/**
 * Post meta information
 */
if ( ! function_exists( 'newsplus_post_meta' ) ) :
	function newsplus_post_meta() {
		$out = sprintf( __( '<span class="posted-on">Posted on </span><a href="%1$s" title="%2$s" class="post-time"><time class="entry-date updated" datetime="%3$s">%4$s</time></a><span class="by-author"> by </span><span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span><span class="posted-in"> in </span>%8$s ', 'newsplus' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'newsplus' ), get_the_author() ) ),
			get_the_author(),
			get_the_category_list( ', ' )
		);		
		
		$num_comments = get_comments_number();
		if ( comments_open() && ( $num_comments >= 1 ) ) {
			if ( $num_comments > 1 ) {
				$comments = sprintf( __( '%s Comments', 'newsplus' ), $num_comments );
			} else {
				$comments = __( '1 Comment', 'newsplus' );
			}
			$out .= sprintf( __( '<span class="with-comments"> with </span><a href="%1$s" class="post-comment" title="%2$s">%3$s</a>', 'newsplus' ), get_comments_link(), sprintf( __( 'Comment on %s' ), get_the_title() ), $comments );
		}
				
		echo apply_filters( 'newsplus_post_meta_big', $out );
		edit_post_link( __( 'Edit', 'newsplus' ), '<span class="sep edit-sep"> | </span><span class="edit-link">', '</span>' );
	}
endif;

/**
 * Post meta information for smaller sections
 */
if ( ! function_exists( 'newsplus_small_meta' ) ) :
	function newsplus_small_meta() {
		$out = sprintf( __( '<a href="%1$s" title="%2$s" class="post-time"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="sep category-sep"> |  </span><span class="post-category">%5$s</span> ', 'newsplus' ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			get_the_category_list( ', ' )
		);
		
		$num_comments = get_comments_number();
		if ( comments_open() && ( $num_comments >= 1 ) ) {
			if ( $num_comments > 1 ) {
				$comments = sprintf( __( '%s Comments', 'newsplus' ), $num_comments );
			} else {
				$comments = __( '1 Comment', 'newsplus' );
			}
			$out .= sprintf( __( '<span class="sep comment-sep"> | </span><a href="%1$s" class="post-comment" title="%2$s">%3$s</a>', 'newsplus' ), get_comments_link(), sprintf( __( 'Comment on %s' ), get_the_title() ), $comments );
		}
		
		echo apply_filters( 'newsplus_post_meta_small', $out );
	}
endif;

/**
 * Add body class to the theme depending upon options and templates
 */
function newsplus_body_class( $classes ) {
	global $pls_sb_pos, $pls_layout, $pls_enable_rtl_css;

	if ( ( 'left' == $pls_sb_pos || is_page_template( 'templates/page-sb-left.php' ) ) && ! ( is_page_template( 'templates/page-sb-right.php' ) || is_page_template( 'templates/page-full.php' )  ) ) {
		$classes[] = 'sidebar-left';
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'newsplus-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( 'stretched' == $pls_layout ) {
		$classes[] = 'is-stretched';
	}

	if ( 'true' == $pls_enable_rtl_css || is_rtl() ) {
		$classes[] = 'rtl-enabled';
	}

	return $classes;
}
add_filter( 'body_class', 'newsplus_body_class' );

/**
 * next/previous navigation for pages and archives
 */
if ( ! function_exists( 'newsplus_content_nav' ) ) :
function newsplus_content_nav( $html_id ) {
	global $wp_query;
	$html_id = esc_attr( $html_id );
	if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi();
	else {
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'newsplus' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'newsplus' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
	}
}
endif;

/**
 * Related Posts feature for Single Posts
 */
if ( ! function_exists( 'newsplus_related_posts' ) ) :
function newsplus_related_posts( $pls_rp_taxonomy, $pls_rp_style, $pls_rp_num ) {
	global $post, $rp_width, $rp_height, $rp_crop;
	$args = null;
	$related_posts_query = null;
	$temp = ( isset( $post ) ) ? $post : '';
	if ( 'tags' == $pls_rp_taxonomy )
	{
		$tags = wp_get_post_tags( $post->ID );
		if ( $tags ) {
			$tag_ids = array();
			foreach ( $tags as $individual_tag )
				$tag_ids[] = $individual_tag->term_id;
			$args = array(
				'tag__in' 				=> $tag_ids,
				'post__not_in' 			=> array( $post->ID ),
				'posts_per_page'		=> $pls_rp_num,
				'orderby' 				=> 'rand'
			);
		} // if tags
	} // taxonomy tags
	else
	{
		$categories = get_the_category( $post->ID );
		if ( $categories ) {
			$category_ids = array();
			foreach( $categories as $individual_category )
				$category_ids[] = $individual_category->term_id;
				$args = array(
				'category__in' 			=> $category_ids,
				'post__not_in' 			=> array( $post->ID ),
				'posts_per_page'		=> $pls_rp_num,
				'orderby'				=> 'rand'
			);
		} // if categories
	} // taxonomy categories
		
	$related_posts_query = new WP_Query( $args );
	
	if( 'thumbnail' == $pls_rp_style )
		$list_class = 'thumb-style';
	else
		$list_class = 'plain-style';
	if ( $related_posts_query->have_posts() ) : ?>
		<div class="related-posts clear">
			<h3><?php _e( 'Related Posts', 'newsplus' ); ?></h3>
			<ul class="<?php echo $list_class; ?> clear">
			<?php
			while( $related_posts_query->have_posts() ) :
				$related_posts_query->the_post();
				$thumbnail = '';
				if ( has_post_thumbnail() ) {
					$title = get_the_title();
					$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'related_posts_thumb' );
					$img = $img_src[0];
					if ( function_exists( 'aq_resize' ) ) {
						$crop = ! empty( $rp_crop ) ? true : false;
						$thumbnail = aq_resize( $img, $rp_width, $rp_height, $crop, true, true );
					}
					$thumbnail = ! empty( $thumbnail ) ? $thumbnail : $img;
				} ?>
				<li>
				<?php if ( 'thumbnail' == $pls_rp_style ) {
					if ( '' !== $thumbnail ) { ?>
						<a class="post-thumb" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php echo $thumbnail; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/></a>
					<?php } ?>
					<h4><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
				<?php }
				else { ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				<?php } ?>
				</li>
			<?php endwhile; // while have posts ?>
			</ul>
			</div><!-- .related-posts -->
	<?php endif; // if have posts
	$post = $temp;
	wp_reset_query();
	wp_reset_postdata();
}
endif;

/**
 * Social Sharing feature on single posts
 */
if ( ! function_exists( 'ss_sharing' ) ) :
	function ss_sharing() {
	global $pls_ss_fb, $pls_ss_tw, $pls_ss_tw_usrname, $pls_ss_gp, $pls_ss_pint, $pls_ss_ln, $pls_ss_vk, $pls_ss_yandex, $pls_ss_reddit;
		$protocol = is_ssl() ? 'https' : 'http';
		$share_link = get_permalink();
		$share_title = get_the_title();
		$out = '';
		if ( 'true' == $pls_ss_fb ) {
			$out .= '<div class="fb-share-button" data-href="' . $share_link . '" data-layout="button_count"></div>';
		}
		if ( 'true' == $pls_ss_tw ) {
			if( ! empty( $pls_ss_tw_usrname ) ) {
				$out .= '<div class="ss-sharing-btn"><a href="' . $protocol . '://twitter.com/share" class="twitter-share-button" data-url="' . $share_link . '"  data-text="' . $share_title . '" data-via="' . $pls_ss_tw_usrname . '">Tweet</a></div>';
			}
			else {
				$out .= '<div class="ss-sharing-btn"><a href="' . $protocol . '://twitter.com/share" class="twitter-share-button" data-url="' . $share_link . '"  data-text="' . $share_title . '">Tweet</a></div>';
			}
		}
		if ( 'true' == $pls_ss_gp ) {
			$out .= '<div class="ss-sharing-btn"><div class="g-plusone" data-size="medium" data-href="' . $share_link . '"></div></div>';
		}
		if ( 'true' == $pls_ss_pint ) {
			global $post;
			setup_postdata( $post );
			if ( has_post_thumbnail( $post->ID ) ) {
				$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '', '' );
				$image = $src[0];
			}
			else
				$image = '';
			$description = 'Next%20stop%3A%20Pinterest';
			$share_link = get_permalink();
			$out .= '<div class="ss-sharing-btn"><a data-pin-config="beside" href="//pinterest.com/pin/create/button/?url=' . $share_link . '&amp;media=' . $image . '&amp;description=' . $description . '" data-pin-do="buttonPin" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" alt="PinIt" /></a></div>';
			wp_reset_postdata();
		}
		if ( 'true' == $pls_ss_ln ) {
			$out .= '<div class="ss-sharing-btn"><script type="IN/Share" data-url="' . $share_link . '" data-counter="right"></script></div>';
		}
		if ( 'true' == $pls_ss_vk ) {
			global $post;
			setup_postdata( $post );
			if ( has_post_thumbnail( $post->ID ) ) {
				$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '', '' );
				$image = $src[0];
			}
			else
				$image = '';
			$description = strip_tags( get_the_excerpt() );
			$out .= '<div class="ss-sharing-btn">
						<script type="text/javascript">
						document.write(VK.Share.button({
						url: "' . $share_link . '",
						title: "' . $share_title . '",
						description: "' . $description . '",
						image: "' . $image . '",
						noparse: true
						}));
						</script>
                    </div>';
		}
		if ( 'true' == $pls_ss_yandex ) {
			$out .= '<div class="ss-sharing-btn"><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="yaru" data-yashareTheme="counter"></div></div>';
		}
		
		if ( 'true' == $pls_ss_reddit ) {
			$out .= "<a href=\"//www.reddit.com/submit\" onclick=\"window.location = '//www.reddit.com/submit?url=' + encodeURIComponent(window.location); return false\"> <img src=\"//www.redditstatic.com/spreddit7.gif\" alt=\"submit to reddit\" border=\"0\" /> </a>";
		}
		
		echo $out;
	}
endif;

/**
 * Load FaceBook script in footer
 */
function ss_fb_script() {
	global $pls_ss_sharing, $pls_ss_fb;
	if ( is_single() && ( 'true' == $pls_ss_sharing ) && ( 'true' == $pls_ss_fb ) ) { ?>    
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>    
<?php }
}
add_action( 'wp_footer', 'ss_fb_script' );

/**
 * Add FaceBook Open Graph Meta Tags on single post
 */
function add_facebook_open_graph_tags() {
	global $pls_ss_sharing, $pls_ss_fb;
	if ( is_single() && ( 'true' == $pls_ss_sharing ) && ( 'true' == $pls_ss_fb ) ) {
		global $post;
		setup_postdata( $post );
		if ( has_post_thumbnail( $post->ID ) ) {
			$src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '', '' );
			$image = $src[0];
		}
		else
			$image = '';
		?>
		<meta property="og:title" content="<?php the_title(); ?>"/>
		<meta property="og:type" content="article"/>
		<meta property="og:image" content="<?php echo $image; ?>"/>
		<meta property="og:url" content="<?php the_permalink(); ?>"/>
		<meta property="og:description" content="<?php echo strip_tags( get_the_excerpt() ); ?>"/>
		<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>"/>
		<?php wp_reset_postdata();
	}
}
add_action( 'wp_head', 'add_facebook_open_graph_tags', 99 );

/**
 * Add FaceBook OG xmlns in html tag
 */
function add_og_xml_ns( $out ) {
	global $pls_ss_sharing, $pls_ss_fb;
	$protocol = is_ssl() ? 'https' : 'http';
	if ( is_single() && ( 'true' == $pls_ss_sharing ) && ( 'true' == $pls_ss_fb ) ) {
		return $out . ' xmlns:og="' . $protocol . '://ogp.me/ns#" xmlns:fb="' . $protocol . '://www.facebook.com/2008/fbml"';
	}
	else
		return $out;
}
add_filter( 'language_attributes', 'add_og_xml_ns' );

/**
 * Enable short codes inside Widgets
 */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

/**
 * Allow HTML in category and term descriptions
 */
foreach ( array( 'pre_term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_filter_kses' );
}
foreach ( array( 'term_description' ) as $filter ) {
    remove_filter( $filter, 'wp_kses_data' );
}

/**
 * Add span tag to post count of categories and archives widget
 */
function cats_widget_postcount_filter( $out ) {
	$out = str_replace( ' (', '<span class="count">(', $out );
	$out = str_replace( ')', ')</span>', $out );
	return $out;
}
add_filter( 'wp_list_categories', 'cats_widget_postcount_filter' );

function archives_widget_postcount_filter( $out ) {
	$out = str_replace( '&nbsp;(', '<span class="count">(', $out );
	$out = str_replace( ')', ')</span>', $out );
	return $out;
}
add_filter('get_archives_link', 'archives_widget_postcount_filter');

/**
 * Assign appropriate heading tag for blog name (SEO improvement)
 */
if ( ! function_exists( 'site_header_tag' ) ) :
	function site_header_tag( $tag_type ) {
		if ( is_front_page() ) {
			$open_tag = '<h1 class="site-title">';
			$close_tag = '</h1>';
		}
		elseif ( is_archive() || is_page_template( 'templates/archive-2col.php' ) || is_page_template( 'templates/archive-3col.php' ) || is_page_template( 'templates/archive-4col.php' ) || is_page_template( 'templates/blog-classic.php' ) || is_page_template( 'templates/blog-list.php' ) || is_page_template( 'templates/blog-grid.php' ) ) {
			$open_tag = '<h3 class="site-title">';
			$close_tag = '</h3>';
		}
		else {
			$open_tag = '<h4 class="site-title">';
			$close_tag = '</h4>';
		}
		if ( 'open' == $tag_type )
			echo $open_tag;
		if ( 'close' == $tag_type )
			echo $close_tag;
	}
endif;


/**
 * Generate site name and logo in header area
 */
if ( ! function_exists( 'newsplus_logo' ) ) :
	function newsplus_logo() {
	global $pls_logo_check, $pls_custom_title, $pls_logo;
		if ( 'true' !== $pls_logo_check ) :
			site_header_tag( 'open' ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php if ( '' != $pls_custom_title ) echo $pls_custom_title; else bloginfo( 'name' ); ?></a><?php site_header_tag( 'close' ); ?>
			<span class="site-description"><?php bloginfo( 'description' ); ?></span>
		<?php else :
			site_header_tag( 'open' ); ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php if ( '' != $pls_logo ) echo $pls_logo; else { echo get_template_directory_uri() . '/images/logo.png' ; } ?>" alt="<?php bloginfo( 'name' ); ?>" title="<?php bloginfo( 'name' ); ?>" /></a>
			<?php site_header_tag( 'close' );
		endif;
	}
endif;

/**
 * Funtion to shorten any text by characters
 */
if ( ! function_exists( 'short' ) ) :
	function short( $text, $limit )
	{
		$chars_limit = intval( $limit );
		$chars_text = strlen( $text );
		$text = strip_tags( $text );
		$text = $text . '';
		$text = substr( $text, 0, $chars_limit );
		$text = substr( $text, 0, strrpos( $text, ' ' ) );
		if ( $chars_text > $chars_limit )
		{
			$text = $text . " &hellip;";
		}
		return $text;
	}
endif;

/**
 * Remove invalid rel attribute on category lists
 */

add_filter( 'wp_list_categories', 'remove_invalid_rel' );
add_filter( 'the_category', 'remove_invalid_rel' );
function remove_invalid_rel( $output ) {
    return str_replace( 'rel="category tag"', 'rel="tag"', $output );
}


/**
 * Get Excerpt outside of loop
 * http://pippinsplugins.com/a-better-wordpress-excerpt-by-id-function/
 */ 
if ( ! function_exists( 'get_excerpt' ) ) {
	function get_excerpt( $post, $length = 100, $tags = '<a><em><strong>' ) {
	
		if ( is_int($post) ) {
			// get the post object of the passed ID
			$post = get_post($post);
		} elseif ( ! is_object($post) ) {
			return false;
		}
		
		if ( has_excerpt($post->ID) ) {
			$the_excerpt = $post->post_excerpt;
			return apply_filters( 'the_content', $the_excerpt ) . '&nbsp;';
		} else {
			$the_excerpt = $post->post_content . '&nbsp;';
		}
		
		$the_excerpt = strip_shortcodes( strip_tags($the_excerpt), $tags );
		$the_excerpt = preg_split( '/\b/', $the_excerpt, $length * 2+1 );
		$excerpt_waste = array_pop( $the_excerpt );
		$the_excerpt = implode( $the_excerpt );
		return $the_excerpt;
	}
}

/**
 * Get post thumbnail caption
 */

if ( ! function_exists( 'newsplus_post_thumbnail_caption' ) ) { 
	function newsplus_post_thumbnail_caption() {
	  global $post;
	
	  $thumbnail_id    = get_post_thumbnail_id($post->ID);
	  $thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment' ) );
	
	  if ( $thumbnail_image && isset( $thumbnail_image[0] ) && ! empty( $thumbnail_image[0]->post_excerpt ) ) {
		return '<p class="feat-caption">' . $thumbnail_image[0]->post_excerpt . '</p>';
	  }
	}
}

/**
 * Display navigation to next/previous comments when applicable.
 */
if ( ! function_exists( 'newsplus_comment_nav' ) ) :
	function newsplus_comment_nav() {
		// Are there comments to navigate through?
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'newsplus' ); ?></h2>
			<div class="nav-links">
				<?php
					if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'newsplus' ) ) ) :
						printf( '<div class="nav-previous">%s</div>', $prev_link );
					endif;
	
					if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'newsplus' ) ) ) :
						printf( '<div class="nav-next">%s</div>', $next_link );
					endif;
				?>
			</div><!-- /.nav-links -->
		</nav><!-- /.comment-navigation -->
		<?php
		endif;
	}
endif;

/**
 * Add favicon and touch icon in head section
 */
function newsplus_site_icon() {
	global $pls_favicon, $pls_apple_touch_icon;
	
	if ( ! empty( $pls_favicon ) ) {
		echo '<link rel="shortcut icon" href="' . $pls_favicon . '" type="image/x-icon">';
		echo "\n";
	}
	
	if ( ! empty( $pls_apple_touch_icon ) ) {
		echo '<link rel="apple-touch-icon-precomposed" href="' . $pls_apple_touch_icon . '">';
	}
}

add_action( 'wp_head', 'newsplus_site_icon' );


/**
 * Register the required plugins for this theme.
 */
 
add_action( 'tgmpa_register', 'newsplus_register_required_plugins' );
function newsplus_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'NewsPlus Shortcodes', // The plugin name.
            'slug'               => 'newsplus-shortcodes', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/plugins/newsplus-shortcodes.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '2.1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        )
 
    );
 
    tgmpa( $plugins ); 
}
?>