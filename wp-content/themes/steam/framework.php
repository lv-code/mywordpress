<?php
# The IndustrialThemes class. Defines constants and includes files for theme functions.

class IndustrialThemes {
	
	public static function init( $options ) {
		self::constants( $options );
		self::functions();
		self::actions();
		self::filters();
		self::supports();
		self::locale();
		self::admin();
	}
	
	# define constant variables
	public static function constants( $options ) {
		define( 'THEME_NAME', $options['theme_name'] );
		define( 'THEME_SLUG', get_template() );
		define( 'THEME_VERSION', $options['theme_version'] );
		define( 'THEME_URI', get_template_directory_uri() );
		define( 'THEME_DIR', get_template_directory() );
		define( 'FRAMEWORK_VERSION', '1.0' );
		define( 'DEMO_URL', 'http://www.industrialthemes.com/steam' );
		define( 'SUPPORT_URL', DEMO_URL . '/support' );
		define( 'CREDITS_URL', SUPPORT_URL . '/credits' );
		define( 'DOCUMENTATION_URL', THEME_URI . '/documentation' );
		
		define( 'IT_PREFIX', 'it' );
		define( 'IT_TEXTDOMAIN', THEME_SLUG );
		define( 'IT_SETTINGS', 'it_' . THEME_SLUG . '_options' );	
		define( 'IT_WIDGETS', 'sidebars_widgets' );	
		define( 'IT_MODS', 'theme_mods_' . THEME_SLUG );
		define( 'IT_INTERNAL_SETTINGS', 'it_' . THEME_SLUG . '_internal_options' );
		define( 'IT_SIDEBARS', 'it_' . THEME_SLUG . '_sidebars' );
		define( 'IT_LETTER_ARRAY', 'A+,A,A-,B+,B,B-,C+,C,C-,D+,D,D-,F+,F,F-' );
		define( 'IT_META_TOTAL_LIKES', '_total_likes');
		define( 'IT_META_LIKE_IP_LIST', '_like_ip_list');
		define( 'IT_META_TOTAL_VIEWS', '_total_views');
		define( 'IT_META_VIEW_IP_LIST', '_view_ip_list');
		define( 'IT_META_TOTAL_SCORE', '_total_score');
		define( 'IT_META_TOTAL_SCORE_OVERRIDE', '_total_score_override');
		define( 'IT_META_TOTAL_USER_SCORE', '_total_user_score');
		define( 'IT_META_TOTAL_SCORE_NORMALIZED', '_total_score_normalized');
		define( 'IT_META_TOTAL_USER_SCORE_NORMALIZED', '_total_user_score_normalized');
		define( 'IT_META_USER_PROS_IP_LIST', '_user_pros_ip_list');
		define( 'IT_META_USER_CONS_IP_LIST', '_user_cons_ip_list');
		define( 'IT_META_HIDE_EDITOR_RATING', '_hide_editor_rating');
		define( 'IT_META_HIDE_USER_RATING', '_hide_user_rating');
		define( 'IT_META_AWARDS', '_awards');
		define( 'IT_META_BADGES', '_badges');
		define( 'IT_META_POSITIVES', '_positives');
		define( 'IT_META_NEGATIVES', '_negatives');
		define( 'IT_META_BOTTOM_LINE', '_bottom_line');
		define( 'IT_META_DISABLE_REVIEW', '_disable_review');
		define( 'IT_META_DISABLE_TITLE', '_disable_title');
		define( 'IT_TWITTER_CONSUMER_KEY', 'qEbQfoKJrb9dcuKCuDUUSVZ3v');
		define( 'IT_TWITTER_CONSUMER_SECRET', 'T96bm8X6LU4bRMluJdvBytbtQ5pfgMILW9uR6KR2PRHRrIBUJ8');
		define( 'IT_TWITTER_USER_TOKEN', '602882281-SPP5uGM9pB3kbaTvLjj8xiEaq4PUhPoTI3fUi5KY');
		define( 'IT_TWITTER_USER_SECRET', 'UXnGVY1VuoJf2daPAMkb0TSjd6sU7fogDL9dGNHr4f5Bp');
		
		#visible meta fields for testing purposes
		/*
		define( 'IT_META_TOTAL_LIKES', 'total_likes');
		define( 'IT_META_LIKE_IP_LIST', 'like_ip_list');
		define( 'IT_META_TOTAL_VIEWS', 'total_views');
		define( 'IT_META_VIEW_IP_LIST', 'view_ip_list');
		define( 'IT_META_TOTAL_SCORE', 'total_score');
		define( 'IT_META_TOTAL_SCORE_OVERRIDE', 'total_score_override');
		define( 'IT_META_TOTAL_USER_SCORE', 'total_user_score');
		define( 'IT_META_TOTAL_SCORE_NORMALIZED', 'total_score_normalized');
		define( 'IT_META_TOTAL_USER_SCORE_NORMALIZED', 'total_user_score_normalized');
		define( 'IT_META_USER_PROS_IP_LIST', 'user_pros_ip_list');
		define( 'IT_META_USER_CONS_IP_LIST', 'user_cons_ip_list');
		define( 'IT_META_HIDE_EDITOR_RATING', 'hide_editor_rating');
		define( 'IT_META_HIDE_USER_RATING', 'hide_user_rating');
		define( 'IT_META_AWARDS', 'awards');
		define( 'IT_META_BADGES', 'badges');
		define( 'IT_META_POSITIVES', 'positives');
		define( 'IT_META_NEGATIVES', 'negatives');
		define( 'IT_META_BOTTOM_LINE', 'bottom_line');
		define( 'IT_META_DISABLE_REVIEW', 'disable_review');
		define( 'IT_META_DISABLE_TITLE', 'disable_title');
		*/
		
		define( 'THEME_FUNCTIONS', THEME_DIR . '/functions' );
		define( 'THEME_IMAGES', THEME_URI . '/images' );
		define( 'THEME_SHORTCODES', THEME_FUNCTIONS . '/shortcodes' );
		define( 'THEME_WIDGETS', THEME_FUNCTIONS . '/widgets' );
		
		define( 'THEME_STYLES_DIR', THEME_DIR . '/css' );
		define( 'THEME_STYLES_URI', THEME_URI . '/css' );	
		define( 'THEME_JS_URI', THEME_URI . '/js' );	
		
		define( 'THEME_ADMIN', THEME_FUNCTIONS . '/admin' );
		define( 'THEME_ADMIN_ASSETS_URI', THEME_URI . '/functions/admin/assets' );
	}
		
	# get theme functions
	public static function functions() {
		require_once( THEME_FUNCTIONS . '/core.php' );
		require_once( THEME_FUNCTIONS . '/minisites.php' );
		require_once( THEME_FUNCTIONS . '/theme.php' );
		require_once( THEME_FUNCTIONS . '/reviews.php' );
		require_once( THEME_FUNCTIONS . '/loop.php' );
		require_once( THEME_FUNCTIONS . '/minisite-meta-boxes.php' ); #see explanation at top of file
		require_once( THEME_FUNCTIONS . '/options.php' ); #purely utility, not used by the theme directly
	}
	
	# setup theme actions
	public static function actions() {
		#WORDPRESS ACTIONS
		add_action( 'init', 'it_shortcodes_init' );
		add_action( 'init', 'it_add_editor_styles' );
		add_action( 'init', 'it_custom_menus' );
		add_action( 'widgets_init', 'it_sidebars' );
		add_action( 'widgets_init', 'it_widgets' );	
		add_action( 'login_head', 'it_custom_login_logo' );
		add_action( 'wp_enqueue_scripts', 'it_enqueue_scripts' );
		add_action( 'show_user_profile', 'it_user_profile_fields' );
		add_action( 'edit_user_profile', 'it_user_profile_fields' );
		add_action( 'personal_options_update', 'it_save_profile_fields' );
		add_action( 'edit_user_profile_update', 'it_save_profile_fields' );
		add_action( 'comment_form_top', 'it_before_comment_fields' );
		add_action( 'comment_form', 'it_after_comment_fields' ); #appears after textarea (comment_form_after_fields appears BEFORE textarea)
		add_action( 'comment_post', 'it_save_comment_meta');
		add_action( 'pre_comment_on_post', 'it_hide_comment');
		add_action( 'dashboard_glance_items', 'it_add_counts_to_dashboard' ); #add custom post types to dashboard counts
		
		#THEME ACTIONS
		
		#head
		add_action( 'it_head', 'it_header_scripts' );
		add_action( 'it_head', 'it_demo_styles' );
		add_action( 'it_head', 'it_facebook_image' );
		
		#front pages
		#add_action( 'it_before_boxes', '' );	
		#add_action( 'it_after_boxes', '' );	
		#add_action( 'it_before_featured', '' );	
		#add_action( 'it_after_featured', '' );	
		#add_action( 'it_before_articles', '' );	
		#add_action( 'it_after_articles', '' );
		#add_action( 'it_before_steam', '' );	
		#add_action( 'it_after_steam', '' );
		#add_action( 'it_before_exclusive', '' );	
		#add_action( 'it_after_exclusive', '' );
		#add_action( 'it_before_connect', '' );	
		#add_action( 'it_after_connect', '' );
		#add_action( 'it_before_mixed', '' );	
		#add_action( 'it_after_mixed', '' );
		#add_action( 'it_before_topten', '' );	
		#add_action( 'it_after_topten', '' );
		#add_action( 'it_before_trending', '' );	
		#add_action( 'it_after_trending', '' );
		
		#single pages
		add_action( 'it_before_content_page', 'it_user_view' );	
		#add_action( 'it_after_single_page', '' );	
		#add_action( 'it_before_single_main', '' );
		#add_action( 'it_after_single_main', '' );
		#add_action( 'it_before_single_title', '' );
		#add_action( 'it_after_single_title', '' );
		#add_action( 'it_before_single_featured_image', '' );
		#add_action( 'it_after_single_featured_image', '' );
		#add_action( 'it_before_single_content', '' );
		add_action( 'it_after_single_content', 'it_post_pagination' );
		
		#loop
		#add_action( 'it_before_loop', '' );	
		add_action( 'it_after_loop', 'it_hide_pagination' );	
		#add_action( 'it_before_loop_content', '' );
		#add_action( 'it_after_loop_content', 'it_page_like_button' );
		#add_action( 'it_before_loop_title', '' );
		#add_action( 'it_after_loop_title', '' );
		
		#footer		
		add_action( 'it_body_end', 'it_footer_scripts' );
		add_action( 'it_body_end', 'it_demo_panel' );
		add_action( 'it_body_end', 'it_custom_javascript' );
		
		# woocommerce actions
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
		add_action('woocommerce_before_main_content', 'it_wrapper_start', 10);
		add_action('woocommerce_after_main_content', 'it_wrapper_end', 10);
		
		# buddypress actions
		add_action( 'bp_loaded', 'it_disable_bp_registration' );
	}

	# setup theme filters
	public static function filters() {
		# WordPress filters
		remove_filter( 'the_content', 'wpautop' );
		add_filter( 'the_content', 'wpautop' , 99); #move wpautop filter to AFTER shortcode is processed
		add_filter( 'the_content', 'shortcode_unautop',100 );
		add_filter( 'wp_title', 'it_wp_title', 10, 2 );
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'widget_text', 'shortcode_unautop');
		#add_filter( 'the_content', 'it_format_text', 11 );
		#add_filter( 'widget_text', 'it_format_text', 11 );
		add_filter( 'get_comment_author_link', 'author_link_new_window' );
		add_filter( 'nav_menu_css_class' , 'current_type_nav_class' , 10 , 2 );	
		add_filter( 'getarchives_where' , 'it_archives_where' , 10 , 2 ); 
		add_filter( 'pre_get_posts', 'it_query_posts', 99 );
		add_filter( 'post_type_link', 'filterslash_post_type_link', 11, 2); 
		#add_filter( 'wp_redirect', 'wpse12721_wp_redirect' );
		add_filter( 'bp_get_signup_page', "it_redirect_bp_signup_page");
		add_filter( 'no_texturize_shortcodes', 'it_shortcodes_exempt' );
	}
	
	# setup theme supports
	public static function supports() {
		
		add_theme_support( 'menus' );
		add_theme_support( 'widgets' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );		
		add_theme_support( 'bbpress' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'woocommerce' );
		
		$disabled = ( is_array( it_get_setting("image_size_disable") ) ) ? it_get_setting("image_size_disable") : array();
		
		#featured image sizes
		if(!in_array('tiny', $disabled)) add_image_size( 'tiny', 35, 35, true );
		if(!in_array('box-short', $disabled)) add_image_size( 'box-short', 700, 350, true );
		if(!in_array('box-tall', $disabled)) add_image_size( 'box-tall', 700, 700, true );		
		if(!in_array('widget-post', $disabled)) add_image_size( 'widget-post', 85, 85, true );
		if(!in_array('grid-post', $disabled)) add_image_size( 'grid-post', 349, 240, true );
		if(!in_array('steam', $disabled)) add_image_size( 'steam', 272, 188, true );
		#featured slider
		if(!in_array('featured-small', $disabled)) add_image_size( 'featured-small', 672, 348, true );
		if(!in_array('featured-medium', $disabled)) add_image_size( 'featured-medium', 840, 435, true );
		if(!in_array('featured-large', $disabled)) add_image_size( 'featured-large', 1158, 600, true );
		if(!in_array('sidecar', $disabled)) add_image_size( 'sidecar', 480, 170, true );
		#single posts/pages
		if(!in_array('single-180', $disabled)) add_image_size( 'single-180', 180 );
		if(!in_array('single-360', $disabled)) add_image_size( 'single-360', 360 );
		if(!in_array('single-790', $disabled)) add_image_size( 'single-790', 790 );
		if(!in_array('single-1130', $disabled)) add_image_size( 'single-1130', 1130 );

		if ( ! isset( $content_width ) ) $content_width = 820;
	}

	# handles localization file
	public static function locale() {
		# Get the user's locale.
		$locale = get_locale();		
		
		# Load theme textdomain.
		load_theme_textdomain( IT_TEXTDOMAIN, THEME_DIR . '/lang' );
		$locale_file = THEME_DIR . "/lang/$locale.php";
		
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
	}
	
	# setup theme admin
	private static function admin() {
		if( !is_admin() ) return;
			
		require_once( THEME_ADMIN . '/admin.php' );
		itAdmin::init();
	}
	
}
?>