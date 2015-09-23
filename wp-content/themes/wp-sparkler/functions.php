<?php
/**
 * Sparkler functions and definitions
 *
 * @package Sparkler
 */

global $ct_options;

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

if ( class_exists( 'ReduxFramework' ) ) {
	require_once (dirname(__FILE__) . '/inc/theme-options.php' );
}

/*-----------------------------------------------------------------------------------*/
/* Activate ColorTheme Plugin via TGM Activation
/*-----------------------------------------------------------------------------------*/
require_once('inc/class-tgm-plugin-activation.php');
add_action('tgmpa_register', 'ct_register_required_plugins');


/*-----------------------------------------------------------------------------------*/
/* TGM Plugin Activation
/*-----------------------------------------------------------------------------------*/
function ct_register_required_plugins() {
	$plugins = array(
		array(
			'name'     				=> 'Redux Framework', // The plugin name
			'slug'     				=> 'redux-framework', // The plugin slug (typically the folder name)
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name'     				=> 'AJAX Thumbnail Rebuild', // The plugin name
			'slug'     				=> 'ajax-thumbnail-rebuild', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name'     				=> 'Meta Box', // The plugin name
			'slug'     				=> 'meta-box', // The plugin slug (typically the folder name)
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		)
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'ct-tgmpa',              // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to pre-packaged plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );

}


/**
 * Enable all HTML Tags in Profile Bios
 */
//disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
remove_filter('pre_user_description', 'wp_filter_kses');
//add sanitization for WordPress posts
add_filter( 'pre_user_description', 'wp_filter_post_kses');

/**
 * Transfer Theme Setup
 */
if ( !function_exists( 'ct_theme_setup') ) :
	function ct_theme_setup() {
		/* Register Menu */
		register_nav_menus(
		array(
			'primary_menu' => esc_html__( 'Primary Navigation' , 'color-theme-framework' ),
			'footer_menu' => esc_html__( 'Footer Navigation' , 'color-theme-framework' )
			)
		);

		/* Enable support for Post Formats */
		add_theme_support( 'post-formats', array( 'image', 'audio', 'video', 'gallery' ) );

		/* Makes theme available for translation. */
		load_theme_textdomain( 'color-theme-framework', get_template_directory() . '/languages' );

		/* This automatically adds the relevant feed links everywhere on the whole site. */
		add_theme_support( 'automatic-feed-links' );

		/* This theme uses a custom image size for featured images, displayed on "standard" posts. */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions

		// Registers a new image sizes.
		/*add_image_size( 'large-thumb', 558, 600, true );*/
		add_image_size( 'single-thumb', 793, 581, true );
		add_image_size( 'widget-thumb', 400, 400, true );
		add_image_size( 'related-thumb', 75, 75, true );

		add_image_size( 'small-thumb', 60, 60, true ); // small thumbnail

		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( "title-tag" );
	}
	add_action( 'after_setup_theme', 'ct_theme_setup' );
endif;


/**
 * Register Areas for the Widgets.
 *
 */
if( !function_exists( 'ct_widgets_init' ) ) :
	function ct_widgets_init() {
		global $ct_options;

		register_sidebar(array(
			'name' => 'Magazine Top Widget Area',
			'id' => 'ct_magazine_top',
			'description' => esc_html__( 'Appears on the homepage ( top section ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Magazine Center Widget Area',
			'id' => 'ct_magazine_center',
			'description' => esc_html__( 'Appears on the homepage ( main content section ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Magazine Center Bottom Widget Area',
			'id' => 'ct_magazine_center_bottom',
			'description' => esc_html__( 'Appears on the homepage ( bottom section after content + sidebar ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Magazine Left Sidebar',
			'id' => 'ct_magazine_left_sidebar',
			'description' => esc_html__( 'Appears on the homepage ( magazine left sidebar ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Magazine Right Sidebar',
			'id' => 'ct_magazine_right_sidebar',
			'description' => esc_html__( 'Appears on the homepage ( magazine right sidebar ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Magazine Bottom Widget Area (full width)',
			'id' => 'ct_magazine_bottom',
			'description' => esc_html__( 'Appears on the homepage ( bottom section at full width ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));


		register_sidebar(array(
			'name' => 'Blog Sidebar',
			'id' => 'ct_blog_sidebar',
			'description' => esc_html__( 'Appears on the blog page.', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Single Page Sidebar',
			'id' => 'ct_single_sidebar',
			'description' => esc_html__( 'Appears on the single pages (left or right).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Single Top Widgets',
			'id' => 'ct_single_top',
			'description' => esc_html__( 'Appears on the single pages (before content).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Single Bottom Widgets',
			'id' => 'ct_single_bottom',
			'description' => esc_html__( 'Appears on the single pages (after content).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Single Page ADS Sidebar',
			'id' => 'ct_single_ads',
			'description' => esc_html__( 'Appears on the single pages (below likes and share icons).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Page Sidebar',
			'id' => 'ct_page_sidebar',
			'description' => esc_html__( 'Appears on the Pages (left or right).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

		register_sidebar(array(
			'name' => 'Archives Page Sidebar',
			'id' => 'ct_archive_sidebar',
			'description' => esc_html__( 'Appears on the archives pages ( category, archive, tag, search and etc... ).', 'color-theme-framework' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
			'after_widget' => '</aside>',
			'before_title' => '<div class="widget-title"><h3 class="entry-title">',
			'after_title' => '</h3></div>',
		));

	}
	add_action( 'widgets_init', 'ct_widgets_init' );
endif;

/**
 * Get Header
 *
 */
if ( !function_exists( 'ct_get_header' ) ) :
	function ct_get_header() {
		global $ct_options;

		isset( $ct_options['header_logo_width'] ) ? $header_logo_width = $ct_options['header_logo_width'] : $header_logo_width ='col-md-3';
		isset( $ct_options['header_banner_width'] ) ? $header_banner_width = $ct_options['header_banner_width'] : $header_banner_width = 'col-md-9';
		isset( $ct_options['banner_enable'] ) ? $banner_enable = $ct_options['banner_enable'] : $banner_enable = 1;

		if ( is_single() ) { ct_get_post_publisher(); } // Get post publisher link
	?>
	<header id="masthead" class="site-header">

		<?php ct_get_topbar(); ?>

		<div class="container">
			<div class="row">
				<div class="<?php if( $banner_enable ) { echo esc_attr( $header_logo_width ); } else { echo 'col-md-12'; } ?>">
					<?php ct_get_logo(); ?>
				</div>
				<div class="<?php echo esc_attr( $header_banner_width ); ?>">
					<?php ct_get_banner(); ?>
				</div>
			</div> <!-- .row -->
		</div> <!-- .container -->

		<div id="ct-primary-menu">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<nav class="navigation-main navigation clearfix">
							<div id="site-nav" class="clearfix">
								<?php ct_get_main_menu(); ?>
								<div class="search-block">
									<i class="fa fa-search"></i>
									<div class="inner-search">
										<?php get_search_form(); ?>
									</div> <!-- .inner-search -->
								</div> <!-- .search-block -->
							</div>
						</nav> <!-- .navigation-main -->
					</div> <!-- .col-md-12 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		</div> <!-- .ct-primary-menu -->

	</header><!-- #masthead -->
	<?php
	}
endif;

/**
 * Get Gallery
 *
 */
if ( !function_exists('ct_get_gallery') ) :
	function ct_get_gallery( $media_width ) {
		global $ct_options, $wpdb, $post;

			$time_id = rand();
			$meta = get_post_meta( get_the_ID(), 'ct_mb_gallery', false);

			if (!is_array($meta)) $meta = (array) $meta;

			if ( !empty( $meta ) and !has_post_thumbnail() ) : ?>
				<div class="<?php echo esc_attr( $media_width ); ?>">
					<figure class="post-thumbnail">
						<?php
							$meta = implode(',', $meta);
							$order_key = 'attachment';

							$images = $wpdb->get_col( $wpdb->prepare( "
								SELECT ID FROM $wpdb->posts
								WHERE post_type = %s
								AND ID in ($meta)
								ORDER BY menu_order ASC
							", $order_key ) );
								$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

						?>
						<a href="<?php echo esc_url( the_permalink() ); ?>">
							<?php ct_get_post_format(); ?>
							<div class="thumb-mask"></div>
							<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
						</a>
					</figure> <!-- .post-thumbnail -->
				</div> <!-- .col-md-* -->
			<?php else : ?>
				<div class="<?php echo esc_attr( $media_width ); ?>">
					<?php ct_get_featured_image(); ?>
				</div> <!-- .col-md-* -->
			<?php endif; ?>
	<?php
	}
endif;


/**
 * Get Widget Video
 *
 */
if ( !function_exists( 'ct_get_widget_video' ) ) :
	function ct_get_widget_video() {
		// Get Video Types
		$video_type = get_post_meta( get_the_ID(), 'ct_mb_post_video_type', true );
		$videoid = get_post_meta( get_the_ID(), 'ct_mb_post_video_file', true );
		$video_thumb = get_post_meta( get_the_ID(), 'ct_mb_post_video_thumb', true );
		?>
			<?php if ( ( $video_thumb == 'player' ) and !empty( $videoid ) ) :
					echo '<div class="col-md-6">';
						echo '<div class="entry-video-post post-thumbnail">';
					    	if ( $video_type == 'youtube' ) {
								echo '<iframe src="http://www.youtube.com/embed/' . $videoid .'?wmode=opaque"></iframe>';
							} else if ( $video_type == 'vimeo' ) {
								echo '<iframe src="http://player.vimeo.com/video/' . $videoid . '"></iframe>';
							} else if ( $video_type == 'dailymotion' ) {
								echo '<iframe src="http://www.dailymotion.com/embed/video/' . $videoid . '"></iframe>';
							}
						echo '</div><!-- .entry-video-post -->';
					echo '</div> <!-- .col-md-6 -->';
				elseif ( has_post_thumbnail() ) : ?>
					<div class="col-md-6">
						<?php ct_get_featured_image(); ?>
					</div> <!-- .col-md-6 -->
			<?php endif; ?>
	<?php
	}
endif;

/**
 * Get Widget Audio
 *
 */
if ( !function_exists( 'ct_get_widget_audio' ) ) :
	function ct_get_widget_audio() {
		// Get Audio Types
		$soundcloud = get_post_meta( get_the_ID() , 'ct_mb_post_soundcloud', true );
		$audio_thumb_type = get_post_meta( get_the_ID() , 'ct_mb_post_audio_thumb', true );

		if ( !empty( $soundcloud ) && ( $audio_thumb_type == '' ) ) {
			$audio_thumb_type = 'player';
		}
		?>
		    <?php if ( ( $soundcloud != '' ) && ( $audio_thumb_type == 'player' ) ) : ?>
		    	<div class="col-md-6">
					<div class="post-thumbnail">
						<?php echo do_shortcode( $soundcloud ); ?>
					</div> <!-- .post-thumbnail -->
				</div> <!-- .col-md-6 -->
			<?php elseif ( has_post_thumbnail() ) : ?>
					<div class="col-md-6">
						<?php ct_get_featured_image(); ?>
					</div> <!-- .col-md-6 -->
			<?php endif; ?>
	<?php
	}
endif;

/**
 * Get Widget Gallery
 *
 */
if ( !function_exists( 'ct_get_widget_gallery' ) ) :
	function ct_get_widget_gallery() {
		global $wpdb;
		// Get Gallery Images
		$time_id = rand();
		$meta = get_post_meta( get_the_ID(), 'ct_mb_gallery', false);

		if (!is_array($meta)) $meta = (array) $meta;
	?>
		<?php
		if ( !empty( $meta ) and !has_post_thumbnail() ) : ?>
			<div class="col-md-6">
				<figure class="post-thumbnail">
					<?php
						$meta = implode(',', $meta);
						$order_key = 'attachment';

						$images = $wpdb->get_col( $wpdb->prepare( "
							SELECT ID FROM $wpdb->posts
							WHERE post_type = %s
							AND ID in ($meta)
							ORDER BY menu_order ASC
						", $order_key ) );
							$src = wp_get_attachment_image_src( $images[0], 'single-thumb');

					?>
					<a href="<?php echo esc_url( the_permalink() ); ?>">
						<?php ct_get_post_format(); ?>
						<div class="thumb-mask"></div>
						<img src="<?php echo esc_url( $src[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
					</a>
				</figure> <!-- .post-thumbnail -->
			</div> <!-- .col-md-6 -->
		<?php else : ?>
			<div class="col-md-6">
				<?php ct_get_featured_image(); ?>
			</div> <!-- .col-md-6 -->
		<?php endif; ?>
	<?php
	}
endif;

/**
 * Get News Ticker
 *
 */
if ( !function_exists( 'ct_get_news_ticker' ) ) :
	function ct_get_news_ticker() {
		global $post, $ct_options;

			isset( $ct_options['break_news'] ) ? $break_news = $ct_options['break_news'] : $break_news = 1;
			isset( $ct_options['breaknews_category'] ) ? $breaknews_category = $ct_options['breaknews_category'] : $breaknews_category = '';
			isset( $ct_options['breaknews_num_posts'] ) ? $breaknews_num_posts = $ct_options['breaknews_num_posts'] : $breaknews_num_posts = '5';
			isset( $ct_options['breaknews_title'] ) ? $breaknews_title = $ct_options['breaknews_title'] : $breaknews_title = __( 'Stories from the Albatros &nbsp;&nbsp;/', 'color-theme-framework' );
			isset( $ct_options['breaknews_pause'] ) ? $breaknews_pause = $ct_options['breaknews_pause'] : $breaknews_pause = '1500';
			isset( $ct_options['breaknews_fadein'] ) ? $breaknews_fadein = $ct_options['breaknews_fadein'] : $breaknews_fadein = '600';
			isset( $ct_options['breaknews_fadeout'] ) ? $breaknews_fadeout = $ct_options['breaknews_fadeout'] : $breaknews_fadeout = '300';
		?>
		<?php if ( $break_news ) : ?>
				<div class="ticker-block clearfix">
						<span class="hot-title">
							<?php echo esc_html( $breaknews_title ); ?>
						</span>
					<?php
						$news_posts = new WP_Query( array('showposts' => $breaknews_num_posts, 'post_type' => 'post', 'category__in' => $breaknews_category ));
					?>
					<script type="text/javascript">
						//<![CDATA[
					jQuery.noConflict()(function($){
						"use strict";
						$(document).ready(function() {
							$('#js-news').ticker({
								ajaxFeed:false,
								feedUrl:false,
								speed: 0.10,
								feedType:'xml',
								htmlFeed:true,
								debugMode:false,
								controls: false,
								titleText:'',
								displayType:'fade',
								direction:'ltr',
								pauseOnItems: <?php echo esc_js( $breaknews_pause ); ?>,
								fadeInSpeed: <?php echo esc_js( $breaknews_fadein ); ?>,
								fadeOutSpeed: <?php echo esc_js( $breaknews_fadeout ); ?>
							});
						});
					});
						//]]>
					</script>

					<ul id="js-news" class="js-hidden">
					  <?php
					  	while($news_posts->have_posts()): $news_posts->the_post();
					  ?>
						<?php
							$category = get_the_category();

							if ( !empty( $category[0]->cat_name ) ) {
								$category_id = get_cat_ID( $category[0]->cat_name );
								$category_link = get_category_link( $category_id );
							}
						?>
					    <li class="news-item">
					    	<h3 class="entry-title">
					    		<a href="<?php the_permalink(); ?>">
					    			<?php the_title(); ?>
					    		</a>
					    		<?php echo '<a href="' . esc_url( $category_link ) . '" class="break-category-link" title="'. esc_attr( sprintf( esc_html__( 'All posts from %s', 'color-theme-framework' ), $category[0]->cat_name ) ) .'">' .esc_html__(' / ', 'color-theme-framework' ). $category[0]->cat_name . '</a>'; ?>
					    	</h3>
					    </li>
					  <?php endwhile; ?>
					</ul> <!-- js-news -->

					<?php wp_reset_postdata(); ?>
			</div> <!-- .ticker-block -->
		<?php endif; ?>
		<?php
	}
endif;

/**
 * Get Top Bar
 *
 */
if ( !function_exists( 'ct_get_topbar' ) ) :
	function ct_get_topbar() {
		global $ct_options;

		isset( $ct_options['topbar_enable'] ) ? $topbar_enable = $ct_options['topbar_enable'] : $topbar_enable = 1;
		isset( $ct_options['break_news'] ) ? $break_news = $ct_options['break_news'] : $break_news = 1;
		isset( $ct_options['top_social'] ) ? $top_social = $ct_options['top_social'] : $top_social = 1;
		isset( $ct_options['top_date'] ) ? $top_date = $ct_options['top_date'] : $top_date = 1;

		isset( $ct_options['topbar_break_width'] ) ? $topbar_break_width = $ct_options['topbar_break_width'] : $topbar_break_width = 'col-md-7';
		isset( $ct_options['topbar_social_width'] ) ? $topbar_social_width = $ct_options['topbar_social_width'] : $topbar_social_width = 'col-md-5';

	?>
	<?php if ( $topbar_enable and ( $break_news or $top_social or $top_date ) ) : ?>
		<div id="ct-topbar" class="clearfix">
			<div class="container">
				<div class="row">
					<div class="<?php echo esc_attr( $topbar_break_width ); ?> clearfix">
						<?php ct_get_news_ticker(); ?>
					</div> <!-- .col-md-6 -->
					<div class="<?php echo esc_attr( $topbar_social_width ); ?> clearfix">
						<?php if ( $top_date ) : ?>
							<div class="entry-today"><?php echo date_i18n( 'l / F d, Y' ); ?></div>
						<?php endif; ?>
						<?php
							if ( $top_social ) :
								ct_get_social_icons();
							endif;
						?>
					</div> <!-- .col-md-3 -->
				</div> <!-- .row -->
			</div> <!-- .container -->
		</div> <!-- #ct-topbar -->
	<?php endif; ?>
	<?php
	}
endif;

/**
 * Get Social Icons
 *
 */
if ( !function_exists( 'ct_get_social_icons' ) ) {
	function ct_get_social_icons() {
		global $ct_options;

		isset( $ct_options['follow_icons'] ) ? $show_social_icons = $ct_options['follow_icons'] : $show_social_icons = 1;

		isset( $ct_options['android_url'] ) ? $android_url = $ct_options['android_url'] : $android_url = '';
		isset( $ct_options['apple_url'] ) ? $apple_url = $ct_options['apple_url'] : $apple_url = '';
		isset( $ct_options['dribbble_url'] ) ? $dribbble_url = $ct_options['dribbble_url'] : $dribbble_url = '';
		isset( $ct_options['github_url'] ) ? $github_url = $ct_options['github_url'] : $github_url = '';
		isset( $ct_options['flickr_url'] ) ? $flickr_url = $ct_options['flickr_url'] : $flickr_url = '';
		isset( $ct_options['youtube_url'] ) ? $youtube_url = $ct_options['youtube_url'] : $youtube_url = '';
		isset( $ct_options['instagram_url'] ) ? $instagram_url = $ct_options['instagram_url'] : $instagram_url = '';
		isset( $ct_options['skype_url'] ) ? $skype_url = $ct_options['skype_url'] : $skype_url = '';
		isset( $ct_options['pinterest_url'] ) ? $pinterest_url = $ct_options['pinterest_url'] : $pinterest_url = '';
		isset( $ct_options['google_url'] ) ? $google_url = $ct_options['google_url'] : $google_url = '';
		isset( $ct_options['twitter_url'] ) ? $twitter_url = $ct_options['twitter_url'] : $twitter_url = '';
		isset( $ct_options['facebook_url'] ) ? $facebook_url = $ct_options['facebook_url'] : $facebook_url = '';

	?>
	<?php if ( $show_social_icons ) : ?>
		<div id="entry-social" class="clearfix">
			<ul class="entry-social-list clearfix">
				<?php if ( !empty( $android_url ) ) { ?>
					<li class="android-icon hovicon border-blur"><a href="<?php echo esc_url( $android_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Android' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-android"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $apple_url ) ) { ?>
					<li class="apple-icon hovicon border-blur"><a href="<?php echo esc_url( $apple_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Apple' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-apple"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $dribbble_url ) ) { ?>
					<li class="dribbble-icon hovicon border-blur"><a href="<?php echo esc_url( $dribbble_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Dribbble' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $github_url ) ) { ?>
					<li class="github-icon hovicon border-blur"><a href="<?php echo esc_url( $github_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Github' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-github"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $flickr_url ) ) { ?>
					<li class="flickr-icon hovicon border-blur"><a href="<?php echo esc_url( $flickr_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Flickr' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-flickr"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $youtube_url ) ) { ?>
					<li class="youtube-icon hovicon border-blur"><a href="<?php echo esc_url( $youtube_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Youtube' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-youtube"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $instagram_url ) ) { ?>
					<li class="instagram-icon hovicon border-blur"><a href="<?php echo esc_url( $instagram_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Instagram' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-instagram"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $skype_url ) ) { ?>
					<li class="skype-icon hovicon border-blur"><a href="<?php echo esc_url( $skype_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Skype' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-skype"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $pinterest_url ) ) { ?>
					<li class="pinterest-icon hovicon border-blur"><a href="<?php echo esc_url( $pinterest_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Pinterest' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $google_url ) ) { ?>
					<li class="googleplus-icon hovicon border-blur"><a href="<?php echo esc_url( $google_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Google Plus' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $twitter_url ) ) { ?>
					<li class="twitter-icon hovicon border-blur"><a href="<?php echo esc_url( $twitter_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Twitter' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if ( !empty( $facebook_url ) ) { ?>
					<li class="facebook-icon hovicon border-blur"><a href="<?php echo esc_url( $facebook_url ); ?>" data-placement="bottom" data-toggle="tooltip" title="<?php esc_html_e( 'Facebook' , 'color-theme-framework' ); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
			</ul> <!-- .entry-social-list -->
		</div> <!-- #entry-social -->
	<?php endif;
	}
}

/**
 * Get Logo
 *
 */
if ( !function_exists( 'ct_get_logo') ) {
	function ct_get_logo() {
		global $ct_options;

		if ( isset( $ct_options['logo_type'] ) ) { $logo_type = $ct_options['logo_type']; } else { $logo_type = 'image'; }
		if ( isset( $ct_options['logo_text'] ) ) { $logo_text = $ct_options['logo_text']; } else { $logo_text = __( 'Logo Text', 'color-theme-framework' ); }
		if ( isset( $ct_options['logo_slogan'] ) ) { $logo_slogan = $ct_options['logo_slogan']; } else { $logo_slogan = __( 'Some logo slogan', 'color-theme-framework' ); }
		if ( isset( $ct_options['logo_upload']['url'] ) ) { $logo_url = $ct_options['logo_upload']['url']; } else { $logo_url = get_template_directory_uri() . '/img/logo.png'; }

		?>

		<div class="entry-logo">
			<?php if ( $logo_type == 'image' ) { ?>
				<?php if ( is_home() or is_front_page() ) echo '<h1>'; ?>
						<a href="<?php echo esc_url( home_url() ); ?>" ><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo('name'); ?>" /></a>
						<span class="alt-logo"><?php bloginfo('name'); ?></span>
				<?php if ( is_home() or is_front_page() ) echo '</h1>'; ?>
			<?php }	?>

			<?php if ( $logo_type == "text" ) { ?>
				<h1 class="text-logo"><a href="<?php echo esc_url( home_url() ); ?>" ><?php echo esc_html( $logo_text ); ?></a></h1>
				<span class="logo-slogan"><?php echo esc_html( $logo_slogan ); ?></span>
			<?php } ?>
		</div> <!-- .logo -->
	<?php }
}

/**
 * Get Featured Image.
 *
 */
if ( !function_exists( 'ct_get_featured_image' ) ) :
	function ct_get_featured_image() {
		global $ct_options;

		if ( has_post_thumbnail() ) : ?>
			<?php $thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-thumb'); ?>
			<figure class="post-thumbnail blog-thumb">
				<a href="<?php echo esc_url( the_permalink() ); ?>">
					<?php ct_get_post_format_video(); ?>
					<div class="thumb-mask"></div>
					<img src="<?php echo esc_url( $thumb_image_url[0] ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>" alt="<?php the_title(); ?>" />
				</a>
			</figure>
	<?php endif;

	}
endif;

/**
 * This is function gets the post views and display it in admin panel.
 *
 */
if ( !function_exists( 'ct_getPostViews' ) ) :
	function ct_getPostViews( $postID ){
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);

		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return '0';
		}
		return '<span class="entry-views">'. $count . ' ' . esc_html__( 'Views', 'color-theme-framework' ) . '</span>';
	}
endif;

if ( !function_exists( 'ct_getPostViews_widget' ) ) :
	function ct_getPostViews_widget( $postID ){
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);

		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return '0';
		}
		return '<span class="entry-views"><i class="fa fa-eye"></i>'. $count . '</span>';
	}
endif;

if ( !function_exists( 'ct_setPostViews' ) ) :
	function ct_setPostViews($postID) {
	if (!current_user_can('administrator') ) :
		$count_key = 'post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	endif;
	}
endif;

if ( !function_exists( 'ct_posts_column_views' ) ) :
	function ct_posts_column_views($defaults){
		$defaults['post_views'] = esc_html__( 'Views' , 'color-theme-framework' );
		return $defaults;
	}
endif;

if ( !function_exists( 'ct_posts_custom_column_views' ) ) :
	function ct_posts_custom_column_views($column_name, $id) {
		if( $column_name === 'post_views' ) {
			echo ct_getPostViews( get_the_ID() );
		}
	}
endif;

add_filter('manage_posts_columns', 'ct_posts_column_views');
add_action('manage_posts_custom_column', 'ct_posts_custom_column_views',5,2);


/**
 * Get Author and Share.
 *
 */
if ( !function_exists( 'ct_get_author_share' ) ) :
	function ct_get_author_share() {
		global $ct_options;

		isset( $ct_options['single_about_author'] ) ? $single_about_author = $ct_options['single_about_author'] : $single_about_author = 1;
		isset( $ct_options['single_share_enable'] ) ? $single_share_enable = $ct_options['single_share_enable'] : $single_share_enable = 1;
		isset( $ct_options['single_likes'] ) ? $single_likes = $ct_options['single_likes'] : $single_likes = 1;

		if ( $single_about_author or $single_share_enable or $single_likes ) :
	?>
		<div class="ct-share-author clearfix">
			<?php if ( $single_about_author ) : ?>
				<div class="about-text"><?php echo esc_html__( 'About Author', 'color-theme-framework'); ?></div>
				<span class="single-author-name"><?php the_author_meta( 'first_name' ); ?> <?php the_author_meta( 'last_name' ); ?></span>
				<meta itemprop="name" content="<?php the_author_meta( 'first_name' ); ?> <?php the_author_meta( 'last_name' ); ?>">
				<meta itemprop="url" content="<?php the_author_meta( 'user_url' ); ?>">

				<div id="author-avatar" class="clearfix" title="<?php esc_html_e( 'Click to view info', 'color-theme-framework' ); ?>">
					<?php
						$user_email = get_the_author_meta( 'user_email' );
						$hash = md5( strtolower( trim ( $user_email ) ) );
					?>
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'color_theme_author_bio_avatar_size', 75 ) ); ?>
				</div><!-- #author-avatar -->

				<div id="author-description" class="clearfix">
					<a class="single-author-name" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a>
					<i class="fa fa-close clearfix" title="<?php esc_html_e( 'Close Description', 'color-theme-framework'); ?>"></i>
					<p><?php the_author_meta( 'description' ); ?></p>
					<?php ct_get_author_social(); ?>
				</div><!-- #author-description	-->
			<?php endif; ?>

			<?php
				if ( $single_likes ) :
					getPostLikeLink( get_the_ID() );
				endif;
			?>
			<?php
				if ( $single_share_enable ) :
					ct_get_single_share();
				endif;
			?>
		</div> <!-- .ct-share-author -->
	<?php
		endif;
	}
endif;

/**
 * Get Post Format
 *
 */
if ( !function_exists( 'ct_get_post_format') ) :
	function ct_get_post_format() {
		?>
		<div class="post-format">
			<?php
				if ( !is_sticky() ) :

					if( has_post_format('image') ) {
						echo '<i class="fa fa-picture-o"></i>';
					} else if( has_post_format('video') ) {
						echo '<i class="fa fa-video-camera"></i>';
					} else if( has_post_format('audio') ) {
						echo '<i class="fa fa-music"></i>';
					} else if( has_post_format('gallery') ) {
						echo '<i class="fa fa-film"></i>';
					} else {
						echo '<i class="fa fa-file-text"></i>';
					}
				else :
					echo '<i class="fa fa-thumb-tack"></i>';
				endif;
			?>
		</div> <!-- .post-format -->
	<?php
	}
endif;

/**
 * Gallery, Video, Audio Post Format
 *
 */
if ( !function_exists( 'ct_get_post_format_video') ) :
	function ct_get_post_format_video() {
		?>
		<div class="post-format">
			<?php
				if ( !is_sticky() ) {

					if( has_post_format('video') ) {
						echo '<i class="fa fa-video-camera"></i>';
					}
					if( has_post_format('audio') ) {
						echo '<i class="fa fa-music"></i>';
					}
					if( has_post_format('gallery') ) {
						echo '<i class="fa fa-film"></i>';
					}

				} else {
					echo '<i class="fa fa-thumb-tack"></i>';
				}

			?>
		</div> <!-- .post-format -->
	<?php
	}
endif;

/**
 * Add Thumbnails in Manage Posts/Pages List
 *
 */
add_filter('manage_posts_columns', 'ct_add_post_thumbnail_column', 5);
add_filter('manage_pages_columns', 'ct_add_post_thumbnail_column', 5);

function ct_add_post_thumbnail_column($cols){
  $cols['tcb_post_thumb'] = esc_html__('Featured Image', 'color-theme-framework');
  return $cols;
}

add_action('manage_posts_custom_column', 'ct_display_post_thumbnail_column', 5, 2);
add_action('manage_pages_custom_column', 'ct_display_post_thumbnail_column', 5, 2);

function ct_display_post_thumbnail_column($col, $id){
  switch($col){
	case 'tcb_post_thumb':
	  if( function_exists('the_post_thumbnail') )
		echo the_post_thumbnail( 'small-thumb' );
	  else
		esc_html_e( 'Not supported in theme', 'color-theme-framework' );
	  break;
  }
}

/**
 * Fav and Touch icons.
 *
 */
if ( ! function_exists( 'ct_fav_icons' ) ) :
	function ct_fav_icons() {
		global $ct_options;
		isset( $ct_options['custom_favicon']['url'] ) ? $custom_favicon = $ct_options['custom_favicon']['url'] : $custom_favicon = get_template_directory_uri() . '/img/favicon.ico';
		isset( $ct_options['ios_60_upload']['url'] ) ? $ios_60_upload = $ct_options['ios_60_upload']['url'] : $ios_60_upload = get_template_directory_uri() . '/img/icons/apple-touch-icon-60-precomposed.png';
		isset( $ct_options['ios_76_upload']['url'] ) ? $ios_76_upload = $ct_options['ios_76_upload']['url'] : $ios_76_upload = get_template_directory_uri() . '/img/icons/apple-touch-icon-76-precomposed.png';
		isset( $ct_options['ios_120_upload']['url'] ) ? $ios_120_upload = $ct_options['ios_120_upload']['url'] : $ios_120_upload = get_template_directory_uri() . '/img/icons/apple-touch-icon-120-precomposed.png';
		isset( $ct_options['ios_152_upload']['url'] ) ? $ios_152_upload = $ct_options['ios_152_upload']['url'] : $ios_152_upload = get_template_directory_uri() . '/img/icons/apple-touch-icon-152-precomposed.png';

		echo "<!-- Fav and touch icons -->\n";
		echo "<link rel=\"shortcut icon\" href=\"" . esc_url( $custom_favicon ) . "\">\n";
		echo '<link href="' . esc_url( $ios_60_upload ) . '" rel="apple-touch-icon" />';
		echo '<link href="' . esc_url( $ios_76_upload ) . '" rel="apple-touch-icon" sizes="76x76" />';
		echo '<link href="' . esc_url( $ios_120_upload ) . '" rel="apple-touch-icon" sizes="120x120" />';
		echo '<link href="' . esc_url( $ios_152_upload ) . '" rel="apple-touch-icon" sizes="152x152" />';
	}
	add_action('wp_enqueue_scripts','ct_fav_icons');
endif;

/**
 * Add custom CSS code.
 *
 */
if ( ! function_exists( 'ct_custom_css' ) ) :
	function ct_custom_css() {
		global $ct_options;

		$custom_css = stripslashes( $ct_options['custom_css'] );

		if ( !empty( $custom_css ) ) {
			echo '<style type="text/css">';
				echo $custom_css;
			echo '</style>';
		}

	}
	add_action('wp_enqueue_scripts','ct_custom_css');
endif;

/**
 * Add custom JS code.
 *
 */
if ( ! function_exists( 'ct_custom_js' ) ) :
	function ct_custom_js() {
		global $ct_options;

		isset( $ct_options['js_code'] ) ? $js_code = $ct_options['js_code'] : $js_code = '';

		if ( !empty( $js_code ) ) {
			echo '<script  type="text/javascript">';
				echo esc_js( $js_code );
			echo '</script>';
		}
	}
	add_action('wp_enqueue_scripts','ct_custom_js');
endif;

/**
 * Enqueue scripts for front end.
 *
 */
if ( !function_exists( 'ct_theme_load_scripts' ) ) :
	function ct_theme_load_scripts() {

		wp_enqueue_script('jquery');

		if( !is_admin() ) {

			global $ct_options;


			// Retina
			isset( $ct_options['retina_js'] ) ? $enable_retina = $ct_options['retina_js'] : $enable_retina = 0;
			if ( $enable_retina ) {
				wp_register_script('ct-retina-js',get_template_directory_uri().'/js/retina.min.js',false, null , true);
				wp_enqueue_script('ct-retina-js',array('jquery'));
			}

			/* Bootstrap */
			isset( $ct_options['bootstrap_js'] ) ? $enable_bootstrap = $ct_options['bootstrap_js'] : $enable_bootstrap = 1;

			if ( $enable_bootstrap ) {
				wp_register_script('ct-jquery-bootstrap-min',get_template_directory_uri().'/js/bootstrap.min.js',false, null , true);
				wp_enqueue_script('ct-jquery-bootstrap-min',array('jquery'));
			}

			/* Breaking News */
			isset( $ct_options['break_news'] ) ? $break_news = $ct_options['break_news'] : $break_news = 1;

			if ( $break_news ) :
				wp_register_script('ct-jquery-ticker-min',get_template_directory_uri().'/js/jquery.ticker.js',false, null , true);
				wp_enqueue_script('ct-jquery-ticker-min',array('jquery'));
			endif;


			// Custom JS
			wp_register_script('ct-custom-js',get_template_directory_uri().'/js/custom.js',false, null , true);
			wp_enqueue_script('ct-custom-js',array('jquery'));


			/* IE Fix JS */
			global $wp_scripts;

			wp_enqueue_script( 'ct-html5shiv-js', '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js', array(), '', true );
			$wp_scripts->add_data( 'ct-html5shiv-js', 'conditional', 'lt IE 9' );

			wp_enqueue_script( 'ct-respond-js', '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js', array(), '', true );
			$wp_scripts->add_data( 'ct-respond-js', 'conditional', 'lt IE 9' );


			if ( is_home() or is_archive() or is_search() or is_page_template( 'template-blog.php' ) ) :

				isset( $ct_options['blog_pagination'] ) ? $blog_pagination = $ct_options['blog_pagination'] : $blog_pagination = 'infinite_scroll';


				if ( $blog_pagination == 'infinite_scroll' ) :
					/* Infinite */
					wp_register_script('ct-infinitescroll-js',get_template_directory_uri().'/js/jquery.infinitescroll.min.js',false, null , true);
					wp_enqueue_script('ct-infinitescroll-js',array('jquery'));

			   		$ct_localization_infinite_array = array(	'loading_posts'	=> esc_html__('Loading the next set of posts...','color-theme-framework'),
			   													'no_posts'		=> esc_html__('No more posts to show.', 'color-theme-framework')
			   												);

					wp_localize_script( 'ct-infinitescroll-js', 'ct_localization_infinite', $ct_localization_infinite_array );
				endif;



			endif;
					/* Images Load */
					wp_register_script('ct-imagesloaded-js',get_template_directory_uri().'/js/imagesloaded.pkgd.min.js',false, null , true);
					wp_enqueue_script('ct-imagesloaded-js',array('jquery'));

			isset( $ct_options['add_prettyphoto'] ) ? $add_prettyphoto = $ct_options['add_prettyphoto'] : $add_prettyphoto = 0;

			if ( $add_prettyphoto and is_singular() ) {
				// PrettyPhoto
				wp_register_script('ct-prettyphoto-js',get_template_directory_uri().'/js/jquery.prettyphoto.js',false, null , true);
				wp_enqueue_script('ct-prettyphoto-js',array('jquery'));

		   		$ct_pretty_array = array( 'script_pretty' => '1' );
				wp_localize_script( 'ct-custom-js', 'ct_pretty', $ct_pretty_array );
			} else {
		   		$ct_pretty_array = array( 'script_pretty' => '0' );
				wp_localize_script( 'ct-custom-js', 'ct_pretty', $ct_pretty_array );

			}

			$subsets = 'latin,latin-ext';

			$protocol = is_ssl() ? 'https' : 'http';
			$query_args = array(
				'family' => 'Open+Sans:400,300,400italic,600,600italic,700italic,700,800',
				'subset' => $subsets,
			);
			wp_enqueue_style( 'ct-open-sans-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );

			$protocol = is_ssl() ? 'https' : 'http';
			$query_args = array(
				'family' => 'Roboto+Condensed:400,300,400italic,700,700italic,300italic',
				'subset' => $subsets,
			);
			wp_enqueue_style( 'ct-roboto-condensed-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		if ( is_single() ) :
			wp_enqueue_script('like_post', get_template_directory_uri().'/js/post-like.js', array('jquery'), '1.0', true );
			wp_localize_script('like_post', 'ajax_var', array(
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('ajax-nonce')
			));
		endif;

		}
  	}
  add_action( 'wp_enqueue_scripts', 'ct_theme_load_scripts' );
endif;


/**
 * This will add rel=lightbox[postid] to the href of the image link
 *
 */

isset( $ct_options['add_prettyphoto'] ) ? $add_prettyphoto = $ct_options['add_prettyphoto'] : $add_prettyphoto = 0;

if ( $add_prettyphoto ) :
	if ( !function_exists( 'ct_add_prettyphoto_rel' ) ) {
		function ct_add_prettyphoto_rel ($content)
		{
			global $post;
			$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
			$replacement = '<a$1href=$2$3.$4$5 rel="prettyphoto['.$post->ID.']"$6>$7</a>';
			$content = preg_replace($pattern, $replacement, $content);
			return $content;
		}
		add_filter('the_content', 'ct_add_prettyphoto_rel', 12);
	}
endif;


/**
 * Enqueue styles for front end.
 *
 */
if ( !function_exists ('ct_theme_load_styles' ) ) :
	function ct_theme_load_styles() {
		global $ct_options;

		wp_enqueue_style( 'bootstrap-main-style',get_template_directory_uri().'/css/bootstrap.min.css','','','all');
		wp_enqueue_style( 'font-awesome-style',get_template_directory_uri().'/css/font-awesome.min.css','','','all');
		wp_enqueue_style( 'ct-style',get_stylesheet_directory_uri().'/style.css','','','all');

		wp_enqueue_style( 'options-css-style', get_stylesheet_directory_uri().'/css/options.css','','','all');

		// add responsive CSS
		isset( $ct_options['responsive_layout'] ) ? $responsive_layout = $ct_options['responsive_layout'] : $responsive_layout = 1;
		if ( $responsive_layout ) {
			wp_enqueue_style( 'ct-rwd-style',get_template_directory_uri().'/css/rwd-styles.css','','','all');
		}

	}
	add_action('wp_enqueue_scripts', 'ct_theme_load_styles');
endif;


/**
 * Load JS
 *
 */
function ct_load_js() {
		global $ct_options, $wp_query;

		isset( $ct_options['blog_pagination'] ) ? $blog_pagination = $ct_options['blog_pagination'] : $blog_pagination = 'load_more';

	?>

	<?php if ( is_home() or is_archive() or is_search() or is_page_template( 'template-blog.php' ) ) : ?>

	<script type="text/javascript">
	/* <![CDATA[ */

	// Masonry
	jQuery.noConflict()(function($){
		$(document).ready(function() {

			<?php if( ($blog_pagination == 'infinite_scroll') and ( is_home() or is_archive() or is_search() ) ) : ?>
			var $container = $('#blog-entry');
			$container.infinitescroll({
				navSelector  : '.pagination',    // selector for the paged navigation
				nextSelector : '.pagination a',  // selector for the NEXT link (to page 2)
				itemSelector : '.entry-post',     // selector for all items you'll retrieve
				<?php $ct_pages = $wp_query->max_num_pages; ?>
				maxPage: <?php echo esc_js( $ct_pages ); ?>,
				loading: {
					finishedMsg: ( typeof ct_localization_infinite != 'undefined' || ct_localization_infinite != null ) ? ct_localization_infinite.no_posts : "No more posts to show.",
					msgText: ( typeof ct_localization_infinite != 'undefined' || ct_localization_infinite != null ) ? ct_localization_infinite.loading_posts : "Loading the next set of posts...",
					img: ''
				}
			});

		 <?php endif; ?>

 });
});
/* ]]> */
	</script>
<?php
	endif;
}
add_action('wp_footer', 'ct_load_js');


/**
 * Custom Background and Custom CSS
 *
 */
if ( !function_exists( 'ct_custom_head_css' ) ) {
	function ct_custom_head_css() {

		$output = '';

		global $wp_query, $ct_options;
		if( is_home() ) {
			$postid = get_option('page_for_posts');
		} elseif( is_search() || is_404() || is_category() || is_tag() || is_author() || is_attachment() ) {
			$postid = 0;
		} else {
			$postid = $wp_query->post->ID;
		}

		/* -- Get the unique custom background image for page --------------------*/
		$bg_img = get_post_meta($postid, 'ct_mb_background_image', true);

		$src = wp_get_attachment_image_src( $bg_img, 'full' );
		$bg_img = $src[0];

		if ( is_archive() || is_attachment() ) {
			$bg_img = '';
		}

		if( empty( $bg_img ) ) {
			/* -- Background image not defined, fallback to default background -- */
			$bg_pos = strtolower ( stripslashes ( $ct_options['default_bg_position'] ) );

			if ( $bg_pos == 'full screen' ) {
				$bg_pos = 'full';
			}
			$bg_type = stripslashes ( $ct_options['default_bg_type'] );

			if( $bg_pos != 'full' ) {
				/* -- Setup body backgroung image, if not fullscreen -- */

				if ( $bg_type == 'uploaded' ) {
					$bg_img = stripslashes ( $ct_options['default_bg_image']['url'] );
				} else if ( $bg_type == 'predefined' ) {
					if ( isset( $ct_options['default_predefined_bg'] ) ) $bg_img = stripslashes ( $ct_options['default_predefined_bg'] );
				}

				$bg_repeat = strtolower ( stripslashes ( $ct_options['default_bg_repeat'] ) );
				$bg_attachment = strtolower ( stripslashes ( $ct_options['default_bg_attachment'] ) );
				$bg_color = get_post_meta($postid, 'ct_mb_background_color', true);

				if( !empty($bg_img) and empty( $bg_color ) ) {
					$bg_img = " url($bg_img)";
				} else {
					$bg_img = " none";
				}

				if( empty($bg_color) ) {
					$bg_color = stripslashes ( $ct_options['body_background'] );
				}

				$output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: $bg_attachment;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
			}
		} else {

			/* -- Custom image defined, check default position -------------------- */
			$bg_pos = get_post_meta($postid, 'ct_mb_background_position', true);

			if( $bg_pos != 'full' ) {
				/* -- Setup body backgroung image, if not fullscreen -- */
				$bg_img = " url($bg_img)";

				/* -- Get the repeat and backgroung color options -- */
				$bg_repeat = get_post_meta($postid, 'ct_mb_background_repeat', true);
				$bg_attachment = get_post_meta($postid, 'ct_mb_background_attachment', true);
				$bg_color = get_post_meta($postid, 'ct_mb_background_color', true);

				if( empty($bg_color) ) {
					$bg_color = stripslashes ( $ct_options['body_background'] );
				}

				$output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: $bg_attachment;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
			}
		}

		/* -- Custom CSS from Theme Options --------------------*/
		$custom_css = stripslashes ( $ct_options['custom_css'] );

		if ( !empty($custom_css) ) {
			$output .= esc_html($custom_css) . "\n";
		}

		/* -- Output our custom styles --------------------------*/
		if ($output <> '') {
			$output= "/* Custom Styles */\n" . $output . "\n";
			wp_add_inline_style( 'options-css-style', $output );
		}
	}
}

add_action('wp_enqueue_scripts', 'ct_custom_head_css');

/**
 * Custom Background
 *
 */
if ( !function_exists( 'ct_get_custom_bg' ) ) {
	function ct_get_custom_bg() {
		global $wp_query, $ct_options;
		$output = '';

		if( is_home() ) {
			$postid = get_option('page_for_posts');
		} elseif( is_search() || is_404() || is_archive() || is_tag() || is_author() || is_attachment() ) {
			$postid = 0;
		} else {
			$postid = $wp_query->post->ID;
		}

		// Get the unique background image for page
		$bg_img = get_post_meta($postid, 'ct_mb_background_image', true);


		$src = wp_get_attachment_image_src( $bg_img, 'full' );
		$bg_img = $src[0];

		if ( is_archive() || is_attachment() ) {
			$bg_img = '';
		}

		if( empty($bg_img) ) {
			// Background image not defined, fallback to default background
			$bg_pos = stripslashes ( $ct_options['default_bg_position'] );
			$bg_type = stripslashes ( $ct_options['default_bg_type'] );

			if ( $bg_pos == 'full screen' ) {
				$bg_pos = 'full';
			}

			// Get the fullscreen background image for page
			if ( ( $bg_pos == 'full' ) && ( $bg_type != 'color' ) ) {
				$bg_img = stripslashes ( $ct_options['default_bg_image']['url'] );

				if( !empty($bg_img) ) {
					$output .= "/* Full Screen Bg */\n";
					$output .= "body { \n background: url(" . $bg_img .") no-repeat center center fixed;\n";
					$output .= "-webkit-background-size: cover;\n-moz-background-size: cover;\n-o-background-size: cover;\nbackground-size: cover;filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . $bg_img . "', sizingMethod='scale');-ms-filter: \"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" . $bg_img . "', sizingMethod='scale')\";\n";
					$output .= "}\n";
				}
			}
		} else {
			// else get the unique background image for page
			$bg_pos = get_post_meta($postid, 'ct_mb_background_position', true);

			if( $bg_pos == 'full' ) {
				$output .= "/* Full Screen Bg */\n";
				$output .= "body { \n background: url(" . $bg_img .") no-repeat center center fixed;\n";
				$output .= "-webkit-background-size: cover;\n-moz-background-size: cover;\n-o-background-size: cover;\nbackground-size: cover;\n";
				$output .= "}\n";
			}
		}

		wp_add_inline_style( 'options-css-style', $output );
	}
}

add_action('wp_enqueue_scripts', 'ct_get_custom_bg');

/**
 * Remove Post Types From Search
 */
if ( !function_exists( 'ct_search_filter_page' ) ) :
 function ct_search_filter_page( $query ) {
	global $ct_options;
	isset( $ct_options['exclude_search_page'] ) ? $is_exclude = $ct_options['exclude_search_page'] : $is_exclude = 1;

  if ( $is_exclude ) {

            $post_types = get_post_types();

			unset( $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item'], $post_types['wpcf7_contact_form'] );

        	$key = array_search( 'page', $post_types);
            if( $key !== false) {
            	unset( $post_types[$key] );
        	}

			if ( !$query->is_admin && $query->is_search ) {
				$query->set('post_type', $post_types );
			}

  }
  return $query;
 }
 add_filter('pre_get_posts','ct_search_filter_page');
endif;

/**
 * Add gallery for the Single Page.
 *
 */
if ( !function_exists( 'ct_inc_gallery' ) ) :
	function ct_inc_gallery() {
		global $ct_options;

		if ( is_single() and has_post_format('gallery') ) :
			wp_register_script('flex-min-jquery',get_template_directory_uri().'/js/jquery.flexslider-min.js',false, null , true);
			wp_enqueue_script('flex-min-jquery',array('jquery'));
		endif;
	}
	add_action('wp_enqueue_scripts', 'ct_inc_gallery');
endif;


/**
 * Get Banner
 *
 */
if ( !function_exists( 'ct_get_banner' ) ) :
	function ct_get_banner() {
		global $ct_options;

		isset( $ct_options['banner_enable'] ) ? $banner_enable = $ct_options['banner_enable'] : $banner_enable = 1;
		isset( $ct_options['banner_type'] ) ? $banner_type = $ct_options['banner_type'] : $banner_type = 'banner';
	?>
	<?php if ( $banner_enable ) : ?>
			<div id="entry-ads" class="clearfix" role="banner">
				<?php
					switch( $banner_type ) {
						case 'banner':
							isset( $ct_options['banner_upload'] ) ? $banner_upload = $ct_options['banner_upload'] : $banner_upload = '';
							isset( $ct_options['banner_url'] ) ? $banner_url = $ct_options['banner_url'] : $banner_url = '';
							isset( $ct_options['banner_url_open'] ) ? $banner_url_open = $ct_options['banner_url_open'] : $banner_url_open = '_blank';

							?>
								<a href="<?php echo esc_url( $banner_url ); ?>" target="<?php echo esc_attr( $banner_url_open ); ?>"><img src="<?php echo esc_url( $ct_options['banner_upload']['url'] ); ?>" alt="<?php echo esc_url( $banner_url ); ?>" /></a>
							<?php
						break;

						case 'text':
							isset( $ct_options['banner_text'] ) ? $banner_text = $ct_options['banner_text'] : $banner_text = '';
							echo do_shortcode( $banner_text );
						break;
					}

				?>
			</div> <!-- .entry-ads -->
	<?php endif; ?>
	<?php
	}
endif;

/**
 * Convert Hex Color to RGB.
 *
 */
if ( !function_exists( 'ct_hex2rgb' ) ) :
	function ct_hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}

		$rgb = array($r, $g, $b);

		return $rgb; // returns an array with the rgb values
	}
endif;

/**
 * Show Featured Images in RSS Feed
 *
 */
if ( !function_exists( 'ct_featuredtorss' ) ) :
	function ct_featuredtorss($content) {
		global $post;
		if ( has_post_thumbnail( $post->ID ) ){
			$content = '<div>' . get_the_post_thumbnail( $post->ID, 'thumbnail', array( 'style' => 'margin-bottom: 15px;' ) ) . '</div>' . $content;
		}
		return $content;
	}
	add_filter('the_excerpt_rss', 'ct_featuredtorss');
	add_filter('the_content_feed', 'ct_featuredtorss');
endif;


/**
 * Enable Shortcodes In Sidebar Widgets
 *
 */
add_filter('widget_text', 'do_shortcode');

/* Post Like */
require_once("post-like.php");

/**
 * Theme Metaboxes
 *
 */
require_once("inc/theme-metaboxes.php");

/**
 * Add Theme Widgets
 *
 */
include("inc/widgets/ct-flickr-widget.php");
include("inc/widgets/ct-instagram-widget.php");
include("inc/widgets/ct-recent-posts-widget.php");
include("inc/widgets/ct-blog-widget.php");
include("inc/widgets/ct-popular-posts-widget.php");
include("inc/widgets/ct-categories-widget.php");
include("inc/widgets/ct-hotnews-slider-widget.php");
include("inc/widgets/ct-bydate-posts-widget.php");
include("inc/widgets/ct-posts-bycategories-widget.php");
include("inc/widgets/ct-1-column-magazine-widget.php");
include("inc/widgets/ct-2-columns-magazine-widget.php");
include("inc/widgets/ct-recent-comments-widget.php");
include("inc/widgets/ct-photo-news-widget.php");
include("inc/widgets/ct-small-slider-widget.php");
include("inc/widgets/ct-post-formats-widget.php");
include("inc/widgets/ct-related-thumbs-widget.php");

/*-----------------------------------------------------------------------------------*/
/* Get Related Post function
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_related_posts' ) ) {
	function ct_get_related_posts($post_id, $tags = array(), $posts_number_display, $order_by) {
		$query = new WP_Query();

		$post_types = get_post_types();
		unset($post_types['page'], $post_types['attachment'], $post_types['revision'], $post_types['nav_menu_item']);

		if($tags) {
			foreach($tags as $tag) {
				$tagsA[] = $tag->term_id;
			}
		}
	   $query = new WP_Query( array('orderby'				=> $order_by,
									'showposts'				=> $posts_number_display,
									'post_type'				=> $post_types,
									'post__not_in'			=> array($post_id),
									'tag__in'				=> $tagsA,
									'ignore_sticky_posts'	=> 1
									)
							);
		return $query;
	}
}

/*-----------------------------------------------------------------------------------*/
/*  Adding the Farbtastic Color Picker
/*  register message box widget
/*-----------------------------------------------------------------------------------*/
if ( is_admin() ) {
	if ( !function_exists( 'ct_load_color_picker_script' ) ) {
		function ct_load_color_picker_script() {
		   wp_enqueue_script('farbtastic');
		}

		add_action('admin_print_scripts-widgets.php', 'ct_load_color_picker_script');
	}

	if ( !function_exists( 'ct_load_color_picker_style' ) ) {
		function ct_load_color_picker_style() {
		   wp_enqueue_style('farbtastic');
		}

		add_action('admin_print_styles-widgets.php', 'ct_load_color_picker_style');
	}
}

/**
 * Get author for comment
 *
 */
if ( ! function_exists( 'ct_get_comment_author' ) ) :
function ct_get_comment_author($comment) {
	$author = "";
	if ( empty($comment->comment_author) )
		$author = esc_html__('Anonymous', 'color-theme-framework');
	else
		$author = $comment->comment_author;
	return $author;
}
endif;


/*-----------------------------------------------------------------------------------*/
/* Display navigation to next/previous post when applicable.
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'ct_post_nav' ) ) :
function ct_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	} ?>

	<nav class="post-navigation clearfix">
		<div class="nav-links clearfix">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', esc_html__( '<span class="meta-nav">' . esc_html__('Published In', 'color-theme-framework').'</span>%title', 'color-theme-framework' ) );
			else :
				previous_post_link( '<div class="nav-left">%link</div>', esc_html__( '%title', 'color-theme-framework' ) );
				next_post_link( '<div class="nav-right">%link</div>', esc_html__( '%title', 'color-theme-framework' ) );
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

/**
 * Get Bottom Meta for the posts
 *
 */
if ( !function_exists( 'ct_get_meta') ) :
	function ct_get_meta() {
		global $ct_options;

			isset( $ct_options['blog_post_date'] ) ? $blog_post_date = $ct_options['blog_post_date'] : $blog_post_date = 1;
			isset( $ct_options['blog_post_comments'] ) ? $blog_post_comments = $ct_options['blog_post_comments'] : $blog_post_comments = 1;
			isset( $ct_options['blog_post_likes'] ) ? $blog_post_likes = $ct_options['blog_post_likes'] : $blog_post_likes = 1;
			isset( $ct_options['blog_post_author'] ) ? $blog_post_author = $ct_options['blog_post_author'] : $blog_post_author = 0;
			isset( $ct_options['blog_post_views'] ) ? $blog_post_views = $ct_options['blog_post_views'] : $blog_post_views = 0;

			$vote_count = get_post_meta( get_the_ID() , "votes_count", true);
		?>
			<?php if ( ($blog_post_comments and comments_open() and ( get_comments_number() != 0 ) ) or ($blog_post_likes and !empty( $vote_count ) ) or $blog_post_date or $blog_post_author or $blog_post_views ) : ?>
			<div class="bottom-content">
				<ul class="bottom-meta clearfix">
					<?php if ( $blog_post_date ) : ?>
						<li>
							<span class="entry-date">
								<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php echo the_time( get_option('date_format') ); ?></a>
							</span> <!-- .entry-date -->
						</li>
					<?php endif; ?>

					<?php if ( $blog_post_author ) : ?>
						<?php
							$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">by %3$s</a></span>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
								get_the_author(),
								''
							);
						?>

						<li class="meta-author">
							<?php printf( $author ); ?>
						</li><!-- .meta-author -->
					<?php endif; ?>

					<?php if ( $blog_post_comments and comments_open() and ( get_comments_number() != 0 ) ) : ?>
						<li><?php ct_get_comments(); ?></li>
					<?php endif; ?>

					<?php if ( $blog_post_likes and !empty( $vote_count ) ) : ?>
						<li>
							<?php
								if ( is_single() ) :
									getPostLikeLink( get_the_ID() );
								else :
									getLikeCount( get_the_ID() );
								endif;
							?>
						</li>
					<?php endif; ?>

					<?php if ( $blog_post_views ) : ?>
						<li><?php echo ct_getPostViews( get_the_ID() ); ?></li>
					<?php endif; ?>
				</ul> <!-- .bottom-meta -->
			</div> <!-- .bottom-content -->
			<?php endif; ?>
	<?php
	}
endif;

/**
 * Get Widget Meta for the posts
 *
 */
if ( !function_exists( 'ct_get_widget_meta') ) :
	function ct_get_widget_meta( $show_date, $show_comments, $show_likes, $show_views, $show_author ) {
		global $ct_options;

			$vote_count = get_post_meta( get_the_ID() , "votes_count", true);
		?>
			<?php if ( ($show_comments and comments_open() and ( get_comments_number() != 0 ) ) or ($show_likes and !empty( $vote_count ) ) or $show_date or $show_author  or $show_views ) : ?>
			<div class="bottom-content" <?php if ( !has_post_thumbnail() ) { echo "style='width: 100%'"; } ?>>
				<ul class="bottom-meta clearfix">
					<?php if ( $show_date ) : ?>
						<li>
							<span class="entry-date">
								<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php echo the_time( get_option('date_format') ); ?></a>
							</span> <!-- .entry-date -->
						</li>
					<?php endif; ?>

					<?php if ( $show_author ) : ?>
						<?php
							$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">by %3$s</a></span>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
								get_the_author(),
								''
							);
						?>

						<li class="meta-author">
							<?php printf( $author ); ?>
						</li><!-- .meta-author -->
					<?php endif; ?>

					<?php if ( $show_comments and comments_open() and ( get_comments_number() != 0 ) ) : ?>
						<li><?php ct_get_comments(); ?></li>
					<?php endif; ?>

					<?php if ( $show_likes and !empty( $vote_count ) ) : ?>
						<li>
							<?php getLikeCount( get_the_ID() ); ?>
						</li>
					<?php endif; ?>

					<?php if ( $show_views ) : ?>
						<li><?php echo ct_getPostViews( get_the_ID() ); ?></li>
					<?php endif; ?>

				</ul> <!-- .bottom-meta -->
			</div> <!-- .bottom-content -->
			<?php endif; ?>
	<?php
	}
endif;

if ( !function_exists( 'ct_get_meta_single') ) :
	function ct_get_meta_single() {
		global $ct_options;

			isset( $ct_options['single_date'] ) ? $single_date = $ct_options['single_date'] : $single_date = 1;
			isset( $ct_options['single_comments'] ) ? $single_comments = $ct_options['single_comments'] : $single_comments = 1;
			isset( $ct_options['single_author'] ) ? $single_author = $ct_options['single_author'] : $single_author = 0;
			isset( $ct_options['single_views'] ) ? $single_views = $ct_options['single_views'] : $single_views = 1;

		?>
			<?php if ( ($single_comments and comments_open() and ( get_comments_number() != 0 ) ) or $single_date or $single_author or $single_views ) : ?>
			<div class="header-content clearfix">
				<ul class="header-meta clearfix">
					<?php if ( $single_date ) : ?>
						<li>
							<div class="entry-date">
								<a href="<?php echo get_day_link(get_post_time('Y'), get_post_time('m'), get_post_time('j')); ?>"><?php echo the_time( get_option('date_format') ); ?></a>
								<span class="ct-post-time"><?php echo esc_html__(' / ', 'color-theme-framework' ); ?><?php echo the_time('H:i A'); ?><?php echo esc_html__(' / ', 'color-theme-framework' ); ?></span>
							</div> <!-- .entry-date -->
						</li>
					<?php endif; ?>
					<?php if ( $single_author ) : ?>
						<?php
							$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">by %3$s</a></span>',
								esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
								esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
								get_the_author(),
								''
							);
						?>

						<li class="meta-author">
							<?php printf( $author ); ?>
						</li><!-- .meta-author -->
					<?php endif; ?>

					<?php if ( $single_comments and comments_open() and ( get_comments_number() != 0 ) ) : ?>
						<li><?php ct_get_comments(); ?></li>
					<?php endif; ?>

					<?php if ( $single_views ) : ?>
						<li><?php echo ct_getPostViews( get_the_ID() ); ?></li>
					<?php endif; ?>
				</ul> <!-- .bottom-meta -->
			</div> <!-- .bottom-content -->
			<?php endif; ?>
	<?php
	}
endif;

/**
 * Breadcrumb
 *
 */
if ( !function_exists( 'ct_breadcrumb' ) ) {
	function ct_breadcrumb() {

        if ( !is_front_page() ) {
			echo '<a href="' . esc_url( home_url() ) . '"><i class="fa fa-home"></i></a><span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>';
		}

		if ( (is_category() || is_single() ) and !is_attachment() and ( is_single() && 'post' == get_post_type() ) ) {
			$category = get_the_category();
			$ID = $category[0]->cat_ID;
			if ( is_category() ) :
				global $cat;
				echo get_category_parents($cat, TRUE, '<span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>');

			else :
				$thecats = get_category_parents($ID, TRUE, '<span>&nbsp;&nbsp;/&nbsp;&nbsp;</span>', FALSE );
				if(!is_object($thecats)) echo stripslashes( $thecats );
			endif;
		}

		if(is_single() || is_page()) { the_title(); }
		if(is_tag()){ esc_html_e('Tag Archives ','color-theme-framework').single_tag_title('',FALSE); }
		if(is_404()){ esc_html_e('404 - Page not Found','color-theme-framework'); }
		if(is_search()){ esc_html_e('Search','color-theme-framework'); }
		if(is_year() ){ echo get_the_time('M Y'); }
		if(is_author()){ esc_html_e('Author Archives','color-theme-framework'); }
		else if(is_archive() and !is_tag()){ esc_html_e('Archives','color-theme-framework'); }
	}
}

if ( !function_exists( 'ct_get_breadcrumbs' ) ) :
	function ct_get_breadcrumbs() {
		global $ct_options;

		isset( $ct_options['breadcrumb_enable'] ) ? $breadcrumb_enable = $ct_options['breadcrumb_enable'] : $breadcrumb_enable = 0;
		if ( $breadcrumb_enable ) :
	?>
	<div class="ct-breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php ct_breadcrumb(); ?>
				</div> <!-- .col-md-12 -->
			</div> <!-- .row -->
		</div> <!-- .container -->
	</div> <!-- .breadcrumbs -->
		<?php
		endif;
	}
endif;


/*-----------------------------------------------------------------------------------*/
/* Get post publisher link
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_post_publisher' ) ) {
	function ct_get_post_publisher() {

		global $post;

		$post_id = get_post( $post->postid ); // $id - Post ID
		$google_plus_url = esc_attr ( get_the_author_meta( 'google_plus', $post_id->post_author ) );

		if ( !empty($google_plus_url) ) {
			echo '<a class="ct-publisher" href="'. esc_url( $google_plus_url ) .'?rel=author" rel="publisher">Google+</a>';
			echo '<a class="ct-publisher" href="'. esc_url( $google_plus_url ) .'" rel="publisher">Find us on Google+</a>';
		}

	}
}

/**
 * Get Read More link
 *
 */
if ( !function_exists( 'ct_get_read_more' ) ) :
	function ct_get_read_more() {
		global $ct_options;
		isset( $ct_options['blog_post_readmore'] ) ? $show_readmore = $ct_options['blog_post_readmore'] : $show_readmore = 1;
		isset( $ct_options['readmore_text'] ) ? $readmore_text = $ct_options['readmore_text'] : $readmore_text = __( 'Continue reading...', 'color-theme-framework' );

		if ( $show_readmore ) : ?>
			<a class="more-post-link" href="<?php echo esc_url( the_permalink() ); ?>" title="<?php echo esc_attr( sprintf( __( 'Continue reading', 'color-theme-framework' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php echo esc_html( $readmore_text ); ?></a>
		<?php endif;
	}
endif;

/**
 * Get Author For Posts
 *
 */
if ( !function_exists( 'ct_get_post_author' ) ) {
	function ct_get_post_author() {

			global $ct_options, $post;

			isset( $ct_options['blog_post_author'] ) ? $blog_post_author = $ct_options['blog_post_author'] : $blog_post_author = 1;
		?>

		<?php if ( $blog_post_author ) : ?>
			<?php
				$author = sprintf( '<span class="author vcard">%4$s<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
					get_the_author(),
					''
				);
			?>
			<span class="entry-author">
				<i class="fa fa-user"></i>
				<?php printf( $author ); ?>
			</span> <!-- .entry-author -->
		<?php endif; ?>
	<?php }
}

/**
 * Get Category
 *
 */
if ( !function_exists( 'ct_get_category' ) ) :
	function ct_get_category( $show_category ) {
			global $ct_options;

			if ( $show_category ) :
				$category = get_the_category();

				if ( !empty( $category[0]->cat_name ) ) {
					$category_id = get_cat_ID( $category[0]->cat_name );
					$category_link = get_category_link( $category_id );

					$category_bg = get_option("category_$category_id");
					if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';

					$postsInCat = get_term_by('name',$category[0]->cat_name,'category');

					echo '<span class="ct-post-category">';
						echo '<a style="color:'. $category_bg['category_color'].' " href="' . esc_url( $category_link ) . '">' . $category[0]->cat_name . '</a>';
					echo '</span>';
				}
			endif;

	}
endif;

if ( !function_exists( 'ct_get_category_blog' ) ) :
	function ct_get_category_blog() {
			global $ct_options;

			isset( $ct_options['blog_post_category'] ) ? $blog_post_category = $ct_options['blog_post_category'] : $blog_post_category = 1;

			if ( $blog_post_category ) :
				$category = get_the_category();

				if ( !empty( $category[0]->cat_name ) ) {
					$category_id = get_cat_ID( $category[0]->cat_name );
					$category_link = get_category_link( $category_id );

					$category_bg = get_option("category_$category_id");
					if ( empty( $category_bg['category_color'] ) ) $category_bg['category_color'] = '#ee445f';

					$postsInCat = get_term_by('name',$category[0]->cat_name,'category');

					echo '<span class="ct-post-category">';
						echo '<a style="color:'. $category_bg['category_color'].' " href="' . esc_url( $category_link ) . '">' . $category[0]->cat_name . '</a>';
					echo '</span>';
				}
			endif;

	}
endif;

/**
 * Get Comments For Posts
 *
 */
if ( !function_exists( 'ct_get_comments' ) ) :
	function ct_get_comments() {
			echo '<span class="entry-comments">';
			comments_popup_link(__('No Comments','color-theme-framework'),__('1 Comment','color-theme-framework'),__('% Comments','color-theme-framework'));
			echo '</span>';
	}
endif;

/**
 * Print an excerpt by specifying a maximium number of characters.
 *
 */
function ct_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		?>
		<p>
		<?php
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo esc_html( $subex );
		}
		echo '...</p>';
	} else echo '<p>' . esc_html( $excerpt ) . '</p>';
}

/**
 * Get Author. Used in Single Post
 *
 */
if ( !function_exists( 'ct_get_author' ) ) :
	function ct_get_author() {
		global $ct_options;

		isset( $ct_options['single_category'] ) ? $single_category = $ct_options['single_category'] : $single_category = 0;

			$author = sprintf( '<span class="author">%4$s<a class="url" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( esc_html__( 'View all posts by %s', 'color-theme-framework' ), get_the_author() ) ),
				get_the_author(),
				''
			);
			if ( $single_category ) {
				$author = esc_html__( '&nbsp;by ' , 'color-theme-framework' ) . $author;
			}

		printf( $author );
	}
endif;

/**
 * Get Main Menu
 *
 */
if ( !function_exists( 'ct_get_main_menu' ) ) :
	function ct_get_main_menu() {
		?>
			<?php
				if ( has_nav_menu('primary_menu') ) :
					wp_nav_menu( array('theme_location' => 'primary_menu', 'menu_class' => 'sf-menu' ));
				else :
					echo '<p class="menu-not-defined">' . esc_html__( 'Main Menu not defined. Define your Main Menu in Apperance > Menus' , 'color-theme-framework' ) . '</p>';
				endif;
			?>
	<?php
	}
endif;

/**
 * Get Footer Menu
 *
 */
if ( !function_exists( 'ct_get_footer_menu' ) ) :
	function ct_get_footer_menu() {
		?>
			<?php
				if ( has_nav_menu('footer_menu') ) :
					wp_nav_menu( array('theme_location' => 'footer_menu', 'menu_class' => 'ct-footer-menu clearfix' ));
				else :
					echo '<p class="menu-not-defined">' . esc_html__( 'Footer Menu not defined. Define your Footer Menu in Apperance > Menus' , 'color-theme-framework' ) . '</p>';
				endif;
			?>
	<?php
	}
endif;

/**
 * Get Edit Post Link
 *
 */
if ( !function_exists( 'ct_get_edit_link' ) ) {
	function ct_get_edit_link( $link_name = 'edit article' , $show_icon = true ) {
		$html_icon = '';
		if ( empty( $link_name ) ) { $link_name = esc_html__( 'Edit Article' , 'color-theme-framework' ); }
		if ( $show_icon == true ) {
			$html_icon = '<i class="fa fa-pencil"></i>';
		}
		edit_post_link( esc_html( $link_name ), '<span class="edit-link">'. $html_icon, '</span>' );
	}
}

/**
 * Get Post Content
 *
 */
if ( !function_exists( 'ct_get_content' ) ) :
	function ct_get_content() {
		?>
		<div class="entry-content">
			<?php ct_get_category_blog(); ?>
			<?php ct_get_title(); ?>
			<?php ct_get_post_content(); ?>
			<?php ct_get_meta(); ?>
			<?php ct_get_read_more(); ?>
			<?php ct_get_edit_link(); ?>
		</div> <!-- .entry-content -->
	<?php
	}
endif;


/*-----------------------------------------------------------------------------------*/
/* Get post publisher link
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'ct_get_post_oginfo' ) ) {
	function ct_get_post_oginfo() { ?>

		<?php if ( is_single() ) : ?>
			<?php global $post; ?>

			<?php
			$post_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large');
			$post_description = ct_get_excerpt_by_id( $post->ID );
			$post_id = get_post( $post->postid ); // $id - Post ID
			$site_description = get_bloginfo( 'description', 'display' ); ?>

			<meta property="og:type" content="article">
			<meta property="og:site_name" content="<?php echo esc_html( $site_description ); ?>">
			<meta property="og:url" content="<?php echo post_permalink( $post->ID ); ?>" />
			<meta property="og:title" content="<?php echo get_the_title( $post->ID ); ?>" />
			<meta property="og:image" content="<?php echo esc_url( $post_image_url[0] ); ?>" />
			<meta property="og:description" content="<?php echo esc_html( $post_description ); ?>" />
			<meta property="article:author" content="<?php echo get_author_posts_url(get_the_author_meta( 'ID', $post_id->post_author )); ?>">
		<?php endif; ?>

	<?php }
}

/**
 * Get DailyMotion Thumbnail
 *
 */
if ( !function_exists( 'ct_getDailyMotionThumb' ) ) {
	function ct_getDailyMotionThumb( $id ) {
		if ( ! function_exists( 'curl_init' ) ) {
			return null;
		}
		else {
		  $output = file_get_contents("https://api.dailymotion.com/video/$id?fields=thumbnail_url");
		  $output = json_decode( $output );
		  $output = $output->thumbnail_url;
		  return $output;
		}
	}
}

/**
 * Get social icons for author block
 */
if ( !function_exists( 'ct_get_author_social' ) ) :
	function ct_get_author_social() {
		$facebook_url = esc_attr ( get_the_author_meta( 'facebook' ) );
		$twitter_url = esc_attr ( get_the_author_meta( 'twitter' ) );
		$github_url = esc_attr ( get_the_author_meta( 'github' ) );
		$linkedin_url = esc_attr ( get_the_author_meta( 'linkedin' ) );
		$pinterest_url = esc_attr ( get_the_author_meta( 'pinterest' ) );
		$google_plus_url = esc_attr ( get_the_author_meta( 'google_plus' ) );

		?>
		<ul class="entry-author-icons clearfix">
		<?php if ( !empty( $facebook_url ) ) { ?>
			<li class="facebook"><a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" title="<?php printf( esc_html__( "%s on Facebook", "color-theme-framework" ), get_the_author_meta( "display_name" ) ) ?>"><i class="fa fa-facebook"></i></a></li>
		<?php } ?>

		<?php if ( !empty( $twitter_url ) ) { ?>
			<li class="twitter"><a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" title="<?php printf( esc_html__( "%s on Twitter", "color-theme-framework" ), get_the_author_meta( "display_name" ) ) ?>"><i class="fa fa-twitter"></i></a></li>
		<?php } ?>

		<?php if ( !empty( $github_url ) ) { ?>
			<li class="github"><a href="<?php echo esc_url( $github_url ); ?>" target="_blank" title="<?php printf( esc_html__( "%s on Github", "color-theme-framework" ), get_the_author_meta( "display_name" ) ) ?>"><i class="fa fa-github"></i></a></li>
		<?php } ?>

		<?php if ( !empty( $linkedin_url ) ) { ?>
			<li class="linkedin"><a href="<?php echo esc_url( $linkedin_url ); ?>" target="_blank" title="<?php printf( esc_html__( "%s on Linkedin", "color-theme-framework" ), get_the_author_meta( "display_name" ) ) ?>"><i class="fa fa-linkedin"></i></a></li>
		<?php } ?>

		<?php if ( !empty( $pinterest_url ) ) { ?>
			<li class="pinterest"><a href="<?php echo esc_url( $pinterest_url ); ?>" target="_blank" title="<?php printf( esc_html__( "%s on Pinterest", "color-theme-framework" ), get_the_author_meta( "display_name" ) ) ?>"><i class="fa fa-pinterest"></i></a></li>
		<?php } ?>

		<?php if ( !empty( $google_plus_url ) ) { ?>
			<li class="googleplus"><a href="<?php echo esc_url( $google_plus_url ); ?>" target="_blank" title="<?php printf( esc_html__( "%s on Google Plus", "color-theme-framework" ), get_the_author_meta( "display_name" ) ) ?>"><i class="fa fa-google-plus"></i></a></li>
		<?php } ?>
		</ul>

	<?php
	}
endif;

/**
 * Display "time ago" for Posts or Comments
 *
 */
if ( !function_exists( 'ct_get_time_ago' ) ) :
	function ct_get_time_ago( $type = 'post' ) {
		$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

		return ct_human_time_diff($d('U'), current_time('timestamp')) . " " . esc_html__('ago', 'color-theme-framework');
}
endif;


/**
 * Get Pagination
 *
 */
if ( !function_exists( 'ct_get_pagintaion' ) ) :
	function ct_get_pagintaion() {
			global $ct_options;

			isset( $ct_options['blog_pagination'] ) ? $blog_pagination = $ct_options['blog_pagination'] : $blog_pagination = 'standard';

			if ( $blog_pagination == 'standard' ) {
				ct_content_nav( 'nav-below' );
			}
			if ( ( $blog_pagination == 'numeric' ) || ( $blog_pagination == 'infinite_scroll' ) ) :
				the_posts_pagination( array(
				    'mid_size' => 2,
				    'prev_text' => __( 'Previous', 'color-theme-framework' ),
				    'next_text' => __( 'Next', 'color-theme-framework' ),
				    'screen_reader_text' => __('', 'color-theme-framework')
				) );
			endif;
	}
endif;

/**
 * Get Post Tags for the Single Post
 *
 */
if ( !function_exists( 'ct_get_single_tags' ) ) :
	function ct_get_single_tags() {
		global $ct_options, $post;

		isset( $ct_options['single_tags'] ) ? $single_tags = $ct_options['single_tags'] : $single_tags = 1;

		?>
		<?php if ( $single_tags and has_tag() ) : ?>
			<div class="entry-tags clearfix">
			<?php $post_tags = wp_get_post_tags( $post->ID ); ?>
				<?php foreach ( $post_tags as $tag ) { ?>
					<a href="<?php echo get_tag_link( $tag->term_id ); ?>"><?php echo esc_html('#') . $tag->name; ?></a>
			<?php } ?>
				<meta itemprop="keywords" content="<?php echo strip_tags(get_the_tag_list('',', ','')); ?>">
			</div> <!-- .single-post-tags -->
		<?php endif; ?>
	<?php
	}
endif;

/**
 * Get Entry Share
 *
 */
if ( !function_exists( 'ct_get_single_share' ) ) {
	function ct_get_single_share() {
		global $post, $ct_options;

			isset( $ct_options['single_share_enable'] ) ? $single_share_enable = $ct_options['single_share_enable'] : $single_share_enable = 1;

			if ( $single_share_enable ) :
				$ct_title = get_the_title();
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );

		?>
		<div class="share-wrapper">
						<span class="share-text"><?php esc_html_e( 'Share', 'color-theme-framework' ); ?></span>
			<div class="entry-share-single clearfix">

				<a class="ct-fb" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank" title="<?php esc_attr_e('Share on Facebook', 'color-theme-framework'); ?>">
					<i class="fa fa-facebook"></i>
				</a>
				<a class="ct-twitter" href="https://twitter.com/intent/tweet?text=<?php echo str_replace(" ", "%20", $ct_title); ?>&amp;url=<?php the_permalink(); ?>" target="_blank" title="<?php esc_attr_e('Share on Twitter', 'color-theme-framework'); ?>">
					<i class="fa fa-twitter"></i>
				</a>
				<a class="ct-gplus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" title="<?php esc_attr_e('Share on Google Plus', 'color-theme-framework'); ?>">
					<i class="fa fa-google-plus"></i>
				</a>
				<a class="ct-pinterest" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&amp;media=<?php echo esc_attr( $large_image_url[0] ); ?>&amp;description=<?php echo str_replace(" ", "%20", $ct_title); ?>" target="_blank" title="<?php esc_attr_e('Share on Pinterest', 'color-theme-framework'); ?>">
					<i class="fa fa-pinterest"></i>
				</a>
				<a class="ct-linkedin" href="http://www.linkedin.com/shareArticle?title=<?php echo str_replace(" ", "%20", $ct_title); ?>&amp;url=<?php the_permalink();?>" target="_blank" title="<?php esc_attr_e('Share on Linkedin', 'color-theme-framework'); ?>">
					<i class="fa fa-linkedin"></i>
				</a>
				<a class="ct-reddit" href="http://reddit.com/submit?title=<?php echo str_replace(" ", "%20", $ct_title); ?>&amp;url=<?php the_permalink();?>;amp;summary=<?php ct_get_excerpt_by_id( $post->id )?>" target="_blank" title="<?php esc_attr_e('Share on Reddit', 'color-theme-framework'); ?>">
					<i class="fa fa-reddit"></i>
				</a>
			</div> <!-- .entry-share-block -->
		</div> <!-- share-wrapper -->
		<?php endif; ?>
<?php
	}
}

/**
 * Get Title
 *
 */
if ( !function_exists( 'ct_get_title' ) ) :
	function ct_get_title() {
		?>
			<h3 class="entry-title"><a href='<?php echo esc_url( the_permalink() ); ?>'><?php the_title(); ?></a></h3>
		<?php
	}
endif;

/**
 * Get Content
 *
 */
if ( !function_exists( 'ct_get_post_content' ) ) :
	function ct_get_post_content() {
		global $ct_options;

		isset( $ct_options['blog_type_content'] ) ? $type_of_content = $ct_options['blog_type_content'] : $type_of_content = 'excerpt';
		isset( $ct_options['blog_post_excerpt'] ) ? $blog_post_excerpt = $ct_options['blog_post_excerpt'] : $blog_post_excerpt = '180';

	?>
		<?php
			if ( $type_of_content == 'excerpt' ) {
				ct_excerpt_max_charlength( $blog_post_excerpt );
			} elseif ( $type_of_content == 'content')
				{ the_content( '' , FALSE, '' ); }
		?>
	<?php
	}
endif;

if ( !function_exists( 'ct_get_search' ) ) :
	function ct_get_search() {
	?>
		<div class="top-search">
			<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search this site...', 'color-theme-framework' ); ?>" />
			</form>
		</div> <!-- .search-wrapper -->
	<?php
	}
endif;

/*-----------------------------------------------------------------------------------*/
/* Get Post Likes for single post
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'ct_get_post_like') ) {
	function ct_get_post_like() {
			global $ct_options;

			isset( $ct_options['single_likes'] ) ? $single_likes = $ct_options['single_likes'] : $single_likes = 1;

			if ( $single_likes ) :
		?>
		<span class="ct-meta meta-likes" title="<?php esc_attr_e('Likes','color-theme-framework'); ?>">
			<?php
				getPostLikeLink( get_the_ID() );
			?>
		</span><!-- .meta-likes -->
	<?php
		endif;
	}
}

/**
 * Get Meta for by Category Widget
 *
 */
if( !function_exists( 'ct_get_bycategory_meta' ) ) :
	function ct_get_bycategory_meta( $show_comments, $show_views, $show_likes ) {
		?>
		<h4 class="entry-title"><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a>
			<?php if ( $show_comments and comments_open() and ( get_comments_number() != 0 ) ) : ?>
				<?php
					echo '<span class="entry-comments"><i class="fa fa-comments-o"></i>';
					comments_popup_link(__('0','color-theme-framework'),__('1','color-theme-framework'),__('%','color-theme-framework'));
					echo '</span>';
				?>
			<?php endif; ?>
			<?php
				if ( $show_views ) :
					echo ct_getPostViews_widget( get_the_ID() );
				endif;
			?>
			<?php
				if( $show_likes ) :
					getLikeCount_Widget( get_the_ID() );
				endif;
			?>
		</h4>
	<?php
	}
endif;

/**
 * Get Copyrights Block
 *
 */
if ( !function_exists( 'ct_get_copyrights' ) ) :
	function ct_get_copyrights() {
		global $ct_options;

		isset( $ct_options['enable_copyrights'] ) ? $enable_copyrights = $ct_options['enable_copyrights'] : $enable_copyrights = 1;
		isset( $ct_options['copyright_text'] ) ? $copyright_text = $ct_options['copyright_text'] : $copyright_text = '';
	?>
	<?php if ( $enable_copyrights and !empty( $copyright_text ) ) : ?>
		<div class="entry-copyright">
			<?php echo do_shortcode( $copyright_text ); ?>
		</div> <!-- .entry-copyright -->
	<?php endif;
	}
endif;

/**
 * Sticky Menu.
 *
 */
if ( !function_exists( 'ct_sticky_menu' ) ) {
	function ct_sticky_menu() {
		global $ct_options;

		isset( $ct_options['sticky_menu'] ) ? $sticky_menu = $ct_options['sticky_menu'] : $sticky_menu = 1;
		isset( $ct_options['sticky_bg'] ) ? $sticky_bg = $ct_options['sticky_bg'] : $sticky_bg = '#7e6f66';
		isset( $ct_options['sticky_opacity'] ) ? $sticky_opacity = $ct_options['sticky_opacity'] : $sticky_opacity = '0.50';

		$rgb = ct_hex2rgb( $sticky_bg );
		$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . "," . $sticky_opacity .")";

		if ( $sticky_menu ) { ?>
			<script type="text/javascript">
			/* <![CDATA[ */
				jQuery.noConflict()(function($){
					$(window).load(function() {
						var menuheight = $('#site-nav').height();
						var admin_bar = 0;

						<?php if ( !is_admin_bar_showing() ) : ?>
							admin_bar = 0;
						<?php else : ?>
							admin_bar = 32;
						<?php endif ?>

						var sticky_navigation_offset_top = $('#site-nav').offset().top-admin_bar

						var sticky_navigation = function(){

							var scroll_top = $(window).scrollTop(); // our current vertical position from the top
							var admin_bar = 0;

							<?php if ( !is_admin_bar_showing() ) : ?>
								admin_bar = 0;
							<?php else : ?>
								admin_bar = 32;
							<?php endif ?>

							if (scroll_top > sticky_navigation_offset_top) {
								$('#ct-primary-menu').css({ 'background' : '<?php echo esc_js( $rgba ); ?>', 'box-shadow' : '0 3px 3px rgba(0,0,0,.2)', '-moz-box-shadow' : '0 3px 3px rgba(0,0,0,.2)', '-webkit-box-shadow' : '0 3px 3px rgba(0,0,0,.2)', 'position': 'fixed', 'left': '0', 'top': admin_bar, 'width':'100%', 'z-index' : 99999 });
								$('body').css({ 'padding-top': menuheight });
							} else {
								$('#ct-primary-menu').css({ 'background' : '#222b31', 'box-shadow' : 'none', '-moz-box-shadow' : 'none', '-webkit-box-shadow' : 'none', 'right': '0', 'left' : 'auto', 'top': '0' , 'position': 'relative', 'border-bottom' : 'none', 'width' : 'auto', 'z-index' : 99999 } );
								$('body').css({ 'padding-top': '0px' });
							}
						};

						// run our function on load
						sticky_navigation();

						// and run it again every time you scroll
						$(window).scroll(function() {
							sticky_navigation();
						});
						$(window).resize(function() {
							sticky_navigation();
						});
					});
				});
			/* ]]> */
			</script>
		<?php
		}
	}
	add_action('wp_footer', 'ct_sticky_menu');
}

/**
 * Get Title and Date
 *
 */
if ( !function_exists( 'ct_get_entry_header' ) ) :
	function ct_get_entry_header() {
		if ( !has_post_format( 'link' ) ) :
		?>
		<header class="entry-header">
			<?php
			$post_title = get_the_title();
			if ( strlen ( $post_title ) >= 120 ) {
				$trimmed_content = wp_trim_words( $post_title, 8, '' );
				echo '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $trimmed_content . ' ...</a></h2>';
			} else
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			?>

		</header>
	<?php
		endif;
	}
endif;

/**
 * Displays navigation to next/previous pages when applicable.
 *
 */
if ( ! function_exists( 'ct_content_nav' ) ) :
function ct_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="navigation-block clearfix">
			<nav id="<?php echo esc_attr( $html_id ); ?>">
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"><i class="fa fa-long-arrow-left"></i></span> Older posts', 'color-theme-framework' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav"><i class="fa fa-long-arrow-right"></i></span>', 'color-theme-framework' ) ); ?></div>
			</nav><!-- .navigation-blog -->

			<div class="clear"></div>
		</div>
	<?php endif;
}
endif;

/**
 * Get Relative time format
 *
 */
if ( !function_exists( 'ct_relative_time' ) ) :
	function ct_relative_time($a) {
		//get current timestampt
		$b = strtotime("now");
		//get timestamp when tweet created
		$c = strtotime($a);
		//get difference
		$d = $b - $c;
		//calculate different time values
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;

		if(is_numeric($d) && $d > 0) {
			//if less then 3 seconds
			if($d < 3) return esc_html__('right now', 'color-theme-framework');
			//if less then minute
			if($d < $minute) return floor($d) . esc_html__(' seconds ago', 'color-theme-framework');
			//if less then 2 minutes
			if($d < $minute * 2) return esc_html__('about 1 minute ago', 'color-theme-framework');
			//if less then hour
			if($d < $hour) return floor($d / $minute) . esc_html__(' minutes ago', 'color-theme-framework');
			//if less then 2 hours
			if($d < $hour * 2) return esc_html__('about 1 hour ago', 'color-theme-framework');
			//if less then day
			if($d < $day) return floor($d / $hour) . esc_html__(' hours ago', 'color-theme-framework');
			//if more then day, but less then 2 days
			if($d > $day && $d < $day * 2) return esc_html__('yesterday', 'color-theme-framework');
			//if less then year
			if($d < $day * 365) return floor($d / $day) . esc_html__(' days ago', 'color-theme-framework');
			//else return more than a year
			return esc_html__('over a year ago', 'color-theme-framework');
		}
	}
endif;

/**
 * Twitter - convert links to clickable format
 *
 */
if ( !function_exists( 'ct_convert_links' ) ) :
	function ct_convert_links($status,$targetBlank=true,$linkMaxLen=250){
		// the target
		$target=$targetBlank ? " target=\"_blank\" " : "";

		// convert link to url
		$status = preg_replace("/((http:\/\/|https:\/\/)[^ )
]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',7,$linkMaxLen).'...':substr('$1',7,$linkMaxLen))).'</a>'", $status);

		// convert @ to follow
		$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

		// convert # to search
		$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

		// return the status
		return $status;
	}
endif;

/**
 * Twitter - get connection with Access Token
 *
 */
if ( !function_exists( 'ct_getConnectionWithAccessToken' ) ) :
	function ct_getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
endif;

/**
 * Password Protect Post
 *
 */
if ( !function_exists( 'ct_password_protected_form' ) ) :
	function ct_password_protected_form() {
	    global $post;
	    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	    $o = '<div class="protected-form"><form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
	    <span class="password-title">' . __( "To view this protected post, enter the password below:" , "color-theme-framework" ) . '</span><label class="password-label" for="' . $label . '">' . __( "Password:", "color-theme-framework" ) . ' </label><div class="clear"></div><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" /><div class="clear"></div><input class="btn-password" type="submit" name="Submit" value="' . esc_attr__( "Submit", "color-theme-framework" ) . '" />
	    </form></div><div class="clear"></div>
	    ';
	    return $o;
	}
	add_filter( 'the_password_form', 'ct_password_protected_form' );
endif;




/**
 * Set social fields for the About Author Block.
 *
 */
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3><?php esc_html_e( 'Social icons for the author information' , 'color-theme-framework' ); ?></h3>

	<table class="form-table">

		<tr>
			<th><label for="facebook"><?php esc_html_e( 'Facebook' , 'color-theme-framework' ); ?></label></th>

			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Please enter your Facebook URL' , 'color-theme-framework'); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="twitter"><?php esc_html_e( 'Twitter' , 'color-theme-framework' ); ?></label></th>

			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Please enter your Twitter URL' , 'color-theme-framework'); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="github"><?php esc_html_e( 'Github' , 'color-theme-framework' ); ?></label></th>

			<td>
				<input type="text" name="github" id="github" value="<?php echo esc_attr( get_the_author_meta( 'github', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Please enter your Github URL' , 'color-theme-framework'); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="linkedin"><?php esc_html_e( 'Linkedin' , 'color-theme-framework' ); ?></label></th>

			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Please enter your Linkedin URL' , 'color-theme-framework'); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="pinterest"><?php esc_html_e( 'Pinterest' , 'color-theme-framework' ); ?></label></th>

			<td>
				<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_attr( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Please enter your Pinterest URL' , 'color-theme-framework'); ?></span>
			</td>
		</tr>

		<tr>
			<th><label for="google_plus"><?php esc_html_e( 'Google Plus' , 'color-theme-framework' ); ?></label></th>

			<td>
				<input type="text" name="google_plus" id="google_plus" value="<?php echo esc_attr( get_the_author_meta( 'google_plus', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description"><?php esc_html_e( 'Please enter your Google Plus URL' , 'color-theme-framework'); ?></span>
			</td>
		</tr>
	</table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'github', $_POST['github'] );
	update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_user_meta( $user_id, 'pinterest', $_POST['pinterest'] );
	update_user_meta( $user_id, 'google_plus', $_POST['google_plus'] );

}

/**
 * Get the Excerpt Automatically Using the Post ID Outside of the Loop.
 *
 */
if ( !function_exists( 'ct_get_excerpt_by_id' ) ) :
	function ct_get_excerpt_by_id( $post_id ) {

		$the_post = get_post($post_id); //Gets post ID
		$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
		$excerpt_length = 35; //Sets excerpt length by word count
		$the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
		$words = explode(' ', $the_excerpt, $excerpt_length + 1);

		if(count($words) > $excerpt_length) :
			array_pop($words);
			array_push($words, '...');
			$the_excerpt = implode(' ', $words);
		endif;

		return $the_excerpt;
	}
endif;

/**
 * Template for comments and pingbacks.
 *
 */
if ( ! function_exists( 'ct_comment' ) ) :
function ct_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php esc_html_e( 'Pingback:', 'color-theme-framework' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'color-theme-framework' ), '<i class="fa fa-icon-pencil"></i><span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment clearfix">
			<div class="comment-block">
				<header class="comment-meta comment-author vcard clearfix">
					<?php
						echo '<div class="comment-avatar">' . get_avatar( $comment, 50 );
						echo '</div>';
					?>
				</header><!-- .comment-meta -->

				<div class="comment-body">
					<?php
						printf( '<cite class="fn">%1$s</cite>',
							get_comment_author_link()
						);
						printf( '<a class="comment-time muted-small" href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( esc_html__( '%1$s at %2$s', 'color-theme-framework' ), get_comment_date(), get_comment_time() )
						);
					?>

					<div class="entry-reply clearfix">
						<?php
						if ( is_rtl() ) :
							comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<i class="fa fa-mail-reply"></i> Reply', 'color-theme-framework' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
						else :
							comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <i class="fa fa-mail-reply"></i>', 'color-theme-framework' ), 'before' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
						endif;
						?>
					</div><!-- .reply -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'color-theme-framework' ); ?></p>
					<?php endif; ?>

					<div class="comment-content comment clearfix">
						<?php comment_text(); ?>

						<?php edit_comment_link( esc_html__( 'Edit', 'color-theme-framework' ), '<p class="edit-link"><i class="fa fa-pencil"></i>', '</p>' ); ?>
					</div><!-- .comment-content -->
				</div> <!-- .comment-body -->
			</div> <!-- .comment-block -->
		</div><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/**
 * Determines the difference between two timestamps.
 *
 * The difference is returned in a human readable format such as "1 hour",
 * "5 mins", "2 days".
 *
 * @since 1.5.0
 *
 * @param int $from Unix timestamp from which the difference begins.
 * @param int $to Optional. Unix timestamp to end the time difference. Default becomes time() if not set.
 * @return string Human readable time difference.
 */
function ct_human_time_diff( $from, $to = '' ) {
	if ( empty( $to ) )
		$to = time();

	$diff = (int) abs( $to - $from );

	if ( $diff < HOUR_IN_SECONDS ) {
		$mins = round( $diff / MINUTE_IN_SECONDS );
		if ( $mins <= 1 )
			$mins = 1;
		/* translators: min=minute */
		$since = sprintf( _n( '%s min', '%s mins', $mins, 'color-theme-framework' ), $mins );
	} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
		$hours = round( $diff / HOUR_IN_SECONDS );
		if ( $hours <= 1 )
			$hours = 1;
		$since = sprintf( _n( '%s hour', '%s hours', $hours, 'color-theme-framework' ), $hours );
	} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
		$days = round( $diff / DAY_IN_SECONDS );
		if ( $days <= 1 )
			$days = 1;
		$since = sprintf( _n( '%s day', '%s days', $days, 'color-theme-framework' ), $days );
	} elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
		$weeks = round( $diff / WEEK_IN_SECONDS );
		if ( $weeks <= 1 )
			$weeks = 1;
		$since = sprintf( _n( '%s week', '%s weeks', $weeks, 'color-theme-framework' ), $weeks );
	} elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {
		$months = round( $diff / ( 30 * DAY_IN_SECONDS ) );
		if ( $months <= 1 )
			$months = 1;
		$since = sprintf( _n( '%s month', '%s month', $months, 'color-theme-framework' ), $months );
	} elseif ( $diff >= YEAR_IN_SECONDS ) {
		$years = round( $diff / YEAR_IN_SECONDS );
		if ( $years <= 1 )
			$years = 1;
		$since = sprintf( _n( '%s year', '%s years', $years, 'color-theme-framework' ), $years );
	}

	return $since;
}


/**
 * Fix ColorPicker in the Admin Panel
 *
 */
if ( !function_exists('ct_fix_colorpicker')) :
	function ct_fix_colorpicker() {
	   ?>
        <style type="text/css">
			.rwmb-color-wrapper .wp-picker-holder { z-index: 99999; }
         </style>
	    <?php
	}
	add_action('admin_head', 'ct_fix_colorpicker');
endif;

/**
 * Add New Field To Category
 *
 */
if ( !function_exists( 'ct_extra_category_fields' ) ) :
	function ct_extra_category_fields( $tag ) {
		if ( isset( $tag->term_id ) ) {
	    	$t_id = $tag->term_id;
	    	$cat_meta = get_option( "category_$t_id" );
	    }
	?>
		<tr class="form-field">
		    <th scope="row" valign="top"><label for="meta-color"><?php esc_html_e('Category Color' , 'color-theme-framework'); ?></label></th>
		    <td>
		        <div id="colorpicker">
		            <input type="text" name="cat_meta[category_color]" class="category-colorpicker" size="10" style="width:45%;" data-default-color="#ee445f" value="<?php echo esc_attr (isset($cat_meta['category_color'])) ? $cat_meta['category_color'] : '#ee445f'; ?>" />
		        </div>
		    </td>
		</tr>
	<?php
	}
	add_action ( 'category_add_form_fields', 'ct_extra_category_fields');
	add_action('category_edit_form_fields','ct_extra_category_fields');
endif;

/**
 * Save Category Meta
 *
 */
if ( !function_exists( 'ct_save_extra_category_fileds' ) ) :
	function ct_save_extra_category_fileds( $term_id ) {
	    if ( isset( $_POST['cat_meta'] ) ) {
	        $t_id = $term_id;
	        $cat_meta = get_option( "category_$t_id");
	        $cat_keys = array_keys($_POST['cat_meta']);
	            foreach ($cat_keys as $key){
	            if (isset($_POST['cat_meta'][$key])){
	                $cat_meta[$key] = $_POST['cat_meta'][$key];
	            }
	        }
	        //save the option array
	        update_option( "category_$t_id", $cat_meta );
	    }
	}
	add_action ( 'edited_category', 'ct_save_extra_category_fileds');
endif;

/**
 * Enqueue Color Picker
 *
 */
if ( !function_exists( 'ct_colorpicker_enqueue' ) ) :
	function ct_colorpicker_enqueue() {
	    wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script( 'ct-colorpicker-js', get_template_directory_uri() . '/js/colorpicker.js', array( 'wp-color-picker' ) );
	}
	add_action( 'admin_enqueue_scripts', 'ct_colorpicker_enqueue' );
endif;