<?php
/**
 * Start Sparkler Theme Options
 * -----------------------------------------------------------------------------
 */

// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode'] = false;

// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'ct_options';

// Setting system info to true allows you to view info useful for debugging.
// Default: false
//$args['system_info'] = true;

$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the option panel stylesheet. Options are 'stahomendard', 'custom', and 'none'
// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
// Default: 'standard'
//$args['admin_stylesheet'] = 'standard';

// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';


// Set a custom menu icon.
//$args['menu_icon'] = '';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Theme Options', "color-theme-framework");

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Theme Options', "color-theme-framework");

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug'] = 'redux_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Add HTML before the form.
if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
	if (!empty($args['global_variable'])) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace("-", "_", $args['opt_name']);
	}
	$args['intro_text'] = sprintf( __('<p>Welcome to the <strong>Sparkler Theme</strong>! Wordpress Magazine/Blog Theme!</p>', "color-theme-framework" ), $v );
} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', "color-theme-framework");
}

$sections = array();

//Background Patterns Reader
$sample_patterns_path = get_template_directory() . '/img/bg/';
$sample_patterns_url  = get_template_directory_uri() . '/img/bg/';

$theme_columns = array ( "col-md-2" => "col-md-2", "col-md-3" => "col-md-3", "col-md-4" => "col-md-4", "col-md-5" => "col-md-5", "col-md-6" => "col-md-6", "col-md-7" => "col-md-7", "col-md-8" => "col-md-8", "col-md-9" => "col-md-9" );

$ct_bg_type = array( "color" => "Color" , "upload" => "Upload" , "predefined" => "Predefined" );

$theme_bg_repeat = array(	'no-repeat'		=> 'No-Repeat',
							'repeat'		=> 'Repeat',
							'repeat-x'		=> 'Repeat-X',
							'repeat-y'		=> 'Repeat-Y'
						);
$theme_bg_position = array(	'left'			=> 'Left',
							'right'			=> 'Right',
							'centered'		=> 'Centered',
							'full screen'	=> 'Full Screen'
						);

$type_of_pagination = array(
							'standard'			=> 'Standard',
							'numeric'			=> 'Numeric',
							'infinite_scroll'	=> 'Infinite Scroll'
							);


$theme_mask_type     = array(		'none'			=> 'None',
									'color'			=> 'Color',
									'uploaded'		=> 'Uploaded Image'
						);

$theme_bg_type = array(		'color'			=> 'Color',
							'uploaded'		=> 'Uploaded Image',
							'predefined'	=> 'Predefined Image'
						);

$theme_bg_type_wrapper = array(
							"none" 			=> "None",
							'color'			=> 'Color',
							'uploaded'		=> 'Uploaded Image',
							'predefined'	=> 'Predefined Image'
						);

$theme_bg_attachment = array(	'scroll'	=> 'Scroll',
								'fixed'		=> 'Fixed'
							);


$theme_sidebar = array( "left" => "Left Sidebar", "right" => "Right Sidebar");

$sample_patterns = array();

if ( is_dir( $sample_patterns_path ) ) :

  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
  	$sample_patterns = array();

    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
      	$name = explode(".", $sample_patterns_file);
      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
      }
    }
  endif;
endif;



/* Color Theme Parameters*/

		$bg_images_path = get_stylesheet_directory() . '/img/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri() . '/img/bg/'; // change this to where you store your bg images

		$ct_theme_patterns = array();

		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) {
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		            	natsort($ct_theme_patterns); //Sorts the array into a natural order
		                $ct_theme_patterns[] = $bg_images_url . $bg_images_file;
		            }
		        }
		    }
		}


$theme_path_images = get_template_directory_uri() . '/img/';
$url =  get_template_directory_uri(). '/img/main_layouts/';

$sections[] = array(
	'title' => __('General Settings', "color-theme-framework"),
	'header' => '',
	'desc' => '',
	'icon_class' => 'icon-large',
    'icon' => 'el-icon-cogs',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(

		array(
		    'id' => 'site_width',
		    'compiler' => true,
		    'type' => 'slider',
		    'title' => __("Magazine Width", "color-theme-framework"),
		    'subtitle' => __('Select width for the theme container (px)', "color-theme-framework"),
		    'desc' => "",
		    "default" => 1280,
		    "min" => 1170,
		    "step" => 10,
		    "max" => 1800,
		    'resolution' => 1,
		    'display_value' => 'text'
		),

	$fields = array(
						"id" =>  "main_layout",
						"type" => "image_select",
						"title" => __( "Layouts of a magazine", "color-theme-framework" ),
						"subtitle" => __( "Select main content and sidebar alignment.", "color-theme-framework" ),
						"default" => "2",
						"compiler" => true,
						"options" => array(
						  		'1'      => array(
						            'alt'   => 'Left Sidebar + Content',
						            'img'   => $url.'2cl.png'
						        ),
						  		'2'      => array(
						            'alt'   => 'Content + Right Sidebar',
						            'img'   => $url.'2cr.png'
						        ),
						  		'3'      => array(
						            'alt'   => 'Left Sidebar + Content + Right Sidebar',
						            'img'   => $url.'3cm.png'
						        ),
						  		'4'      => array(
						            'alt'   => 'Content + Left Sidebar + Right Sidebar',
						            'img'   => $url.'3cr.png'
						        ),
						  		'5'      => array(
						            'alt'   => 'Left Sidebar + Right Sidebar + Content',
						            'img'   => $url.'3lc.png'
						        ),
						  		'6'      => array(
						            'alt'   => '( Left Sidebar + Right Sidebar + Content ) + Bottom',
						            'img'   => $url.'1l_2r.png'
						        ),
						  		'7'      => array(
						            'alt'   => '( Content + Left Sidebar + Bottom ) + Right Sidebar',
						            'img'   => $url.'2l_1r.png'
						        ),
							)
						),

		array(
			'id'=>'breadcrumb_enable',
			'type' => 'switch',
			'title' => __("Breadcrumbs", "color-theme-framework"),
			'subtitle'=> __("Enable/Disable breadcrumbs for the inner pages", "color-theme-framework"),
			"default" => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'scripts-bar-info',
			'type' => 'info',
			'style'=>'warning',
			'desc' => __('Enable/Disable third-party scripts and features.', "color-theme-framework"),
			),

		array(
			'id'=>'responsive_layout',
			'type' => 'switch',
			'title' => __("Responsive layout", "color-theme-framework"),
			'subtitle'=> __("Enable/Disable responsive layout", "color-theme-framework"),
			"default" => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'bootstrap_js',
			'type' => 'switch',
			'title' => __("Bootstrap JS Library", "color-theme-framework"),
			'subtitle'=> __("Enable/Disable bootstrap library", "color-theme-framework"),
			"default" => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'retina_js',
			'type' => 'switch',
			'title' => __("Retina JS Library", "color-theme-framework"),
			'subtitle'=> __("Enable/Disable retina library", "color-theme-framework"),
			"default" => 0,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'exclude_search_page',
			'type' => 'switch',
			'title' => __("Exclude pages from the Search results", "color-theme-framework"),
			'subtitle'=> "",
			"default" => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-cogs',
	'title' => __('Top Bar', "color-theme-framework"),
	'desc' => '',
	'fields' => array(

		array(
			'id'=>'topbar_break_width',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Breaking News Width", "color-theme-framework"),
			'subtitle' => __( "Choose block width for the breaking news" , "color-theme-framework" ),
			'desc' => "",
			'options' => $theme_columns,
			'default' => "col-md-7"
			),

		array(
			'id'=>'topbar_social_width',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Social Icons and Date Width", "color-theme-framework"),
			'subtitle' => __( "Choose block width for the social icons and the date" , "color-theme-framework" ),
			'desc' => "",
			'options' => $theme_columns,
			'default' => "col-md-5"
			),

		array(
			'id'=>'topbar_enable',
			'type' => 'switch',
			'title' => __("Top Bar", "color-theme-framework"),
			'subtitle'=> __("Enable/Disable top bar block (breaking news, social icons, date)", "color-theme-framework" ),
			"default" => 1,
			'on' => 'Enable',
			'off' => 'Disable',
			),

		array(
			'id'=>'top_social',
			'type' => 'switch',
			'title' => __("Social Icons", "color-theme-framework"),
			'subtitle'=> __("Show or Hide the social icons block", "color-theme-framework" ),
			"default" => 1,
			'on' => 'On',
			'off' => 'Off',
			),

		array(
			'id'=>'top_date',
			'type' => 'switch',
			'title' => __("Date", "color-theme-framework"),
			'subtitle'=> __("Show or Hide the date block", "color-theme-framework" ),
			"default" => 1,
			'on' => 'On',
			'off' => 'Off',
			),

		array(
			'id'=>'top_bg_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Background Color for the Top Bar', "color-theme-framework"),
			'subtitle' => __('Select BG color for the top bar.', "color-theme-framework"),
			'default' => '#222b31',
			'validate' => 'color',
			),

	)
);

$sections[] = array(
	'icon' => 'el-icon-leaf',
	'title' => __('Breaking News', "color-theme-framework"),
	'desc' => '',
	'subsection' => true,
	'fields' => array(
		array(
			'id'=>'break_news',
			'type' => 'switch',
			'title' => __("Breaking News Block", "color-theme-framework"),
			'subtitle'=> __("Enable or disable the Breaking News", "color-theme-framework"),
			"default" => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'breaknews_category',
			'required'	=> array( "break_news", "=", "1" ),
			'type' => 'select',
			'data' => 'categories',
			'multi' => true,
			'title' => __("Select a Category for the Breaking News", "color-theme-framework"),
			'desc' => __("Pick a Category for the Breaking News", "color-theme-framework"),
			),

		array(
			'id'=>'breaknews_num_posts',
			'type' => 'text',
			'required' => array('break_news','=','1'),
			'title' => __('Number of Posts to display', "color-theme-framework"),
			'subtitle' => __('Enter the number of posts for displaying.', "color-theme-framework"),
			'default' => '5',
			'desc' => __('Enter the number of posts', "color-theme-framework"),
			),


		array(
			'id'=>'breaknews_color',
			'type' => 'color',
			'required' => array('break_news', '=', '1'),
			'transparent' => false,
			'compiler' => true,
			'title' => __('Title Color', "color-theme-framework"),
			'subtitle' => __('Pick a color for the breaking news.', "color-theme-framework"),
			'default' => "#ee445f",
			'validate' => 'color',
			),

		array(
			'id'=>'breaknews_title',
			'type' => 'text',
			'required' => array('break_news','=','1'),
			'title' => __('Title', "color-theme-framework"),
			'subtitle' => __('Enter text for the Breaking News.', "color-theme-framework"),
			'default' => __('Don\'t Miss', "color-theme-framework"),
			'desc' => ''
			),

		array(
			'id'=>'breaknews_pause',
			'type' => 'text',
			'required' => array('break_news','=','1'),
			'title' => __('Pause on Items', "color-theme-framework"),
			'subtitle' => __('Enter number for the pause in milliseconds.', "color-theme-framework"),
			'default' => '1500',
			'desc' => __('Pause in milliseconds', "color-theme-framework"),
			),

		array(
			'id'=>'breaknews_fadein',
			'type' => 'text',
			'required' => array('break_news','=','1'),
			'title' => __('FadeIn Speed', "color-theme-framework"),
			'subtitle' => __('Enter number for the fadein items in milliseconds.', "color-theme-framework"),
			'default' => '600',
			'desc' => __('FadeIn in milliseconds', "color-theme-framework"),
			),

		array(
			'id'=>'breaknews_fadeout',
			'type' => 'text',
			'required' => array('break_news','=','1'),
			'title' => __('FadeOut Speed', "color-theme-framework"),
			'subtitle' => __('Enter number for the fadeout items in milliseconds.', "color-theme-framework"),
			'default' => '300',
			'desc' => __('FadeOut in milliseconds', "color-theme-framework"),
			),

	)
);

$sections[] = array(
	'icon' => 'el-icon-star',
	'title' => __('Social Settings', "color-theme-framework"),
	'desc' => '',
	'subsection' => true,
	'fields' => array(

		array(
			'id'=>'follow_icons',
			'type' => 'switch',
			'title' => __('Social Icons', "color-theme-framework"),
			'subtitle'=> __("Enable or Disable Social Icons", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'android_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Android', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Android.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'apple_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Apple', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Apple.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'dribbble_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Dribbble', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Dribbble.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'github_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Github', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Github.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'flickr_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Flickr', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Flickr.', "color-theme-framework"),
			'default' => 'http://www.flickr.com',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'youtube_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Youtube', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Youtube.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'instagram_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Instagram', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Instagram.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'skype_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Skype', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Skype.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'pinterest_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Pinterest', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Pinterest.', "color-theme-framework"),
			'default' => '',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'google_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Google', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Google.', "color-theme-framework"),
			'default' => 'http://www.google.com',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'twitter_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Twitter', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Twitter.', "color-theme-framework"),
			'default' => 'http://www.twitter.com',
			'desc' => 'Enter the URL in the text field.'
			),

		array(
			'id'=>'facebook_url',
			'type' => 'text',
			'required' => array('follow_icons','=','1'),
			'title' => __('Facebook', "color-theme-framework"),
			'subtitle' => __('Enter the URL for Facebook.', "color-theme-framework"),
			'default' => 'http://www.facebook.com',
			'desc' => 'Enter the URL in the text field.'
			)
	)
);

$sections[] = array(
	'title' => __('Header Settings', "color-theme-framework"),
	'header' => '',
	'desc' => '',
	'icon_class' => 'icon-large',
    'icon' => 'el-icon-adjust-alt',
    //'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(

		array(
			'id'=>'header_logo_width',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Logo Width", "color-theme-framework"),
			'subtitle' => __( "Choose block width for the logo" , "color-theme-framework" ),
			'desc' => "",
			'options' => $theme_columns,
			'default' => "col-md-3"
			),

		array(
			'id'=>'header_banner_width',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Banner Width", "color-theme-framework"),
			'subtitle' => __( "Choose block width for the banner" , "color-theme-framework" ),
			'desc' => "",
			'options' => $theme_columns,
			'default' => "col-md-9"
			),

		array(
			'id'=>'header_bg_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Background Color for the header', "color-theme-framework"),
			'subtitle' => __('Select BG color for the header.', "color-theme-framework"),
			'default' => '#192226',
			'validate' => 'color',
			),

		),
	);

$sections[] = array(
	'title' => __('Banner Settings', "color-theme-framework"),
	'header' => '',
	'desc' => '',
	'icon_class' => 'icon-large',
    'icon' => 'el-icon-wrench',
    'subsection' => true,
	'fields' => array(

		array(
			'id'=>'banner_enable',
			'type' => 'switch',
			'title' => __("ADS Block", "color-theme-framework"),
			'subtitle'=> "",
			"default" => 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'		=> 'banner_padding',
			'type'		=> 'spacing',
			'compiler'	=> true,
			'units'		=> 'px',
			'display_units' => 'false',
			'title'		=> __('Paddings for the ADS Block', 'color-theme-framework'),
			'default'	=> array('padding-top' => '45px', 'padding-right'=>"0", 'padding-bottom' => '0', 'padding-left'=>'0' )
			),

		array(
			'id'=>'banner_type',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Select Type for the ADS", "color-theme-framework"),
			'subtitle' => __( "Select the type for ADS block" , "color-theme-framework" ),
			'desc' => "",
			'options' => array( "banner" => "Banner", "text" => "Text" ),
			'default' => "banner"
			),

		array(
			'id'=>'banner_upload',
			'type' => 'media',
			'required' => array('banner_type','=', 'banner' ),
			'url'=> true,
			'title' => __('Banner Upload', "color-theme-framework"),
			'desc'=> __('Upload image using the native media uploader, or define the URL directly.', "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'theme_forest_468x60.jpg' ),
			),

		array(
			'id'=>'banner_url',
			'type' => 'text',
			'required' => array('banner_type','=', 'banner' ),
			'title' => __("URL for the Banner", "color-theme-framework"),
			'subtitle' => "",
			'desc' => __( "Enter url for the banner" , "color-theme-framework" ),
			'default' => __( 'http://themeforest.net/user/ZERGE/portfolio?ref=zerge', 'color-theme-framework' )
			),

		array(
			'id'=>'banner_url_open',
			'type' => 'select',
			'required' => array('banner_type','=', 'banner' ),
			'title' => __("How will open the URL?", "color-theme-framework"),
			'subtitle' => __( "Select Current or New window" , "color-theme-framework" ),
			'desc' => "",
			'options' => array( "_self" => "In the Current Window", "_blank" => "In the New Window" ),
			'default' => "_blank"
			),


		array(
			'id'=>'banner_text',
			'type' => 'textarea',
			'required' => array('banner_type','=', 'text' ),
			'title' => __("Text for the ADS section", "color-theme-framework"),
			'subtitle' => "",
			'desc' => __( "Enter text for the ADS block" , "color-theme-framework" ),
			'default' => ''
			),

		),
	);

$sections[] = array(
	'icon' => 'el-icon-tasks',
	'title' => __('Menu Setings', "color-theme-framework"),
	'desc' => '',
	'subsection' => true,
	'fields' => array(

		array(
			'id'=>'main_menu_top_level',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Top Level Links', "color-theme-framework"),
			'subtitle' => __('Select color for the Top Level links.', "color-theme-framework"),
			'default' => '#a3bfc6',
			'validate' => 'color',
			),

		array(
			'id'=>'menu_top_level_active',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Top Level Active Links', "color-theme-framework"),
			'subtitle' => __('Select color for the Top Level active links.', "color-theme-framework"),
			'default' => '#FFFFFF',
			'validate' => 'color',
			),

		array(
			'id'=>'sublevel_link_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Menu Sub-level Links color', "color-theme-framework"),
			'subtitle' => __('Pick a color for the menu sub-level links.', "color-theme-framework"),
			'default' => '#a3bfc6',
			'validate' => 'color',
			),

		array(
			'id'=>'sublevel_link_hover',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Menu Sub-level Links color (hover state)', "color-theme-framework"),
			'subtitle' => __('Pick a color for the menu sub-level links (hover state).', "color-theme-framework"),
			'default' => '#FFFFFF',
			'validate' => 'color',
			),

		array(
			'id'=>'sublevel_bg_color_default',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Menu Sub-level Links BG color', "color-theme-framework"),
			'subtitle' => __('Pick a BG color for the menu sub-level links.', "color-theme-framework"),
			'default' => '#222b31',
			'validate' => 'color',
			),

		array(
			'id'=>'sublevel_bg_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Menu Sub-level Links BG color (hover state)', "color-theme-framework"),
			'subtitle' => __('Pick a BG color for the menu sub-level links (hover state).', "color-theme-framework"),
			'default' => '#192226',
			'validate' => 'color',
			),

		array(
			'id'=>'sticky_menu',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Sticky Menu", "color-theme-framework"),
			'subtitle'=> __("Enable or Disable Sticky menu", "color-theme-framework"),
			"default" => 1,
			'on' => 'Enable',
			'off' => 'Disable',
			),

		array(
			'id'=>'sticky_bg',
			'type' => 'color',
			'compiler' => true,
			'required'	=> array( 'sticky_menu', '=', '1' ),
			'transparent' => false,
			'title' => __('BG Color for the Sticky Menu', "color-theme-framework"),
			'subtitle' => __('Pick a color for the sticky menu', "color-theme-framework"),
			'default' => '#222b31',
			'validate' => 'color',
			),

		array(
		    'id' => 'sticky_opacity',
		    'compiler' => true,
		    'required'	=> array( 'sticky_menu', '=', '1' ),
		    'type' => 'slider',
		    'title' => __("Opacity for the Sticky Menu", "color-theme-framework"),
		    'subtitle' => __('Select opacity for the sticky menu', "color-theme-framework"),
		    'desc' => "",
		    "default" => 0.95,
		    "min" => 0,
		    "step" => .05,
		    "max" => 1,
		    'resolution' => 0.01,
		    'display_value' => 'text'
		),
	)
);

$sections[] = array(
	'icon' => 'el-icon-laptop',
	'icon_class' => 'icon-large',
    'title' => __('Logos and Icons', "color-theme-framework"),
	'fields' => array(

		array(
			'id'		=> 'logo_padding',
			'type'		=> 'spacing',
			'compiler'	=> true,
			'units'		=> 'px',
			'display_units' => 'false',
			'title'		=> __('Paddings for the Logo', 'color-theme-framework'),
			'default'	=> array('padding-top' => '60px', 'padding-right'=>"0", 'padding-bottom' => '60px', 'padding-left'=>'0' )
			),

		array(
			'id'=>'logo_type',
			'type' => 'select',
			'title' => __("Logo's type", "color-theme-framework"),
			'subtitle' => __( "Select the type of logo" , "color-theme-framework" ),
			'desc' => __("Select the type of logo.", "color-theme-framework" ),
			'options' => array( 'image' => 'Image', 'text' => 'Text' ),
			'default' => "image"
			),

		array(
			'id'=>'logo_text',
			'type' => 'text',
			'required' => array( 'logo_type', '=', 'text'),
			'title' => __("Logo's Text", "color-theme-framework"),
			'subtitle' => __('Enter logo text. (only for type of logo: Text)', "color-theme-framework"),
			'desc' => __( "Add your text for the logo" , "color-theme-framework" ),
			'default' => __( "Sparkler" , "color-theme-framework" ),
			),

		array(
			'id'=>'logo_slogan',
			'type' => 'text',
			'required' => array( 'logo_type', '=', 'text'),
			'title' => __("Logo's Slogan", "color-theme-framework"),
			'subtitle' => __("Enter slogan text. (only for type of logo: Text)", "color-theme-framework"),
			'desc' => __( "Add your text for the slogan" , "color-theme-framework" ),
			'default' => __( "Wordpress Magazine Theme" , "color-theme-framework" ),
			),

		array(
			'id'=>'logo_upload',
			'type' => 'media',
			'url'=> true,
			'title' => __('Logo Upload', "color-theme-framework"),
			'desc'=> __('Upload your logo or paste the url', "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'logo.png' ),
			),

		array(
			'id'=>'retina_logo_upload',
			'type' => 'media',
			'url'=> true,
			'title' => __('Retina Logo Upload', "color-theme-framework"),
			'desc'=> __('Upload image using the native media uploader, or define the URL directly.<br> Retina Logo name should be like logo@2x.png and must be placed in the same directory (beside with a standard logo).', "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'logo@2x.png' ),
			),

		array(
			'id'=>'fav_icons',
			'type' => 'info',
			'style'=>'warning',
			'desc' => __('Fav and Touch Icons for iPhone, iPad and Android', "color-theme-framework"),
			),

		array(
			'id'=>'custom_favicon',
			'type' => 'media',
			'url'=> true,
			'title' => __('Custom Favicon', "color-theme-framework"),
			'desc'=> __("Upload a 16px x 16px Png/Gif image that will represent your website's favicon.", "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'favicon.ico' ),
			),

		array(
			'id'=>'ios_60_upload',
			'type' => 'media',
			'url'=> true,
			'title' => __('iPhone/iPod', "color-theme-framework"),
			'desc'=> __("Upload a 60px x 60px Png/Gif image for iPhone/iPod.", "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'icons/apple-touch-icon-60-precomposed.png' ),
			),

		array(
			'id'=>'ios_76_upload',
			'type' => 'media',
			'url'=> true,
			'title' => __('iPad', "color-theme-framework"),
			'desc'=> __("Upload a 76px x 76px Png/Gif image for iPad.", "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'icons/apple-touch-icon-76-precomposed.png' ),
			),

		array(
			'id'=>'ios_120_upload',
			'type' => 'media',
			'url'=> true,
			'title' => __('iPhone/iPod Retina', "color-theme-framework"),
			'desc'=> __("Upload a 120px x 120px Png/Gif image for iPhone/iPod Retina.", "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'icons/apple-touch-icon-120-precomposed.png' ),
			),

		array(
			'id'=>'ios_152_upload',
			'type' => 'media',
			'url'=> true,
			'title' => __('iPad Retina', "color-theme-framework"),
			'desc'=> __("Upload a 152px x 152px Png/Gif image for iPad Retina.", "color-theme-framework"),
			'subtitle' => __('Upload image using the native media uploader, or define the URL directly', "color-theme-framework"),
			'default'=>array('url'=> $theme_path_images . 'icons/apple-touch-icon-152-precomposed.png' ),
			),


	)
);

$sections[] = array(
	'icon' => 'el-icon-pencil',
	'title' => __('Styling Options', "color-theme-framework"),
	'fields' => array(

		array(
			'id'=>'theme_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Theme Color', "color-theme-framework"),
			'subtitle' => __('Select theme color.', "color-theme-framework"),
			'default' => '#ee445f',
			'validate' => 'color',
			),

		array(
			'id'			=> 'body_font',
			'type'			=> 'typography',
			'title'			=> __('Body Font', 'color-theme-framework'),
			'compiler'		=> true,
			'google'		=> true,
			'font-backup'	=> false,
			'font-style'	=> false,
			'font-weight'	=> false,
			'text-align'	=> false,
			'units'			=> 'px',
			'subtitle'		=> __('Specify the body font properties.', 'color-theme-framework'),
			'default'		=> array(
									'color'			=> "#4d5051",
									'font-family'	=> 'Open Sans',
									'google'		=> true,
									'font-size'		=> '14px',
									'line-height'	=> '28px'
									),
			),

		array(
		   'id'  => 'default-bg-bar-info',
		   'type'  => 'info',
		   'style'  => 'success',
		   'desc'  => __('Default Background Settings.', 'color-theme-framework'),
		   ),


		array(
			'id'		=> 'default_bg_type',
			'type'		=> 'select',
			'title'		=> __('Type of Background', 'color-theme-framework'),
			'desc'		=> __('Select the type of background', 'color-theme-framework'),
			'options'	=> $theme_bg_type,
			'default'	=> 'color',
			),

		array(
			'id'		=> 'body_background',
			'type'		=> 'color',
			'required' => array('default_bg_type','=', 'color' ),
			'compiler'	=> 'true',
			'transparent' => false,
			'title'		=> __('Body background Color', 'color-theme-framework'),
			'subtitle'	=> __('Pick a background color', 'color-theme-framework'),
			'default'	=> '#e7f0f4',
			'validate'	=> 'color',
			),

		array(
			'id'		=> 'default_bg_attachment',
			'type'		=> 'select',
			'required' => array('default_bg_type','=', array( 'uploaded', 'predefined' ) ),
			'title'		=> __('Background Attachment', 'color-theme-framework'),
			'desc'		=> __('The background-attachment property sets whether a background image is fixed or scrolls with the rest of the page.', 'color-theme-framework'),
			'options'	=> $theme_bg_attachment,
			'default'	=> 'fixed',
			),

		array(
			'id'		=> 'default_bg_repeat',
			'type'		=> 'select',
			'required' => array('default_bg_type','=', array( 'uploaded', 'predefined' ) ),
			'title'		=> __('Background Attachment', 'color-theme-framework'),
			'desc'		=> __('The background-repeat property sets if/how a background image will be repeated. By default, a background-image is repeated both vertically and horizontally.', 'color-theme-framework'),
			'options'	=> $theme_bg_repeat,
			'default'	=> 'no-repeat',
			),

		array(
			'id'		=> 'default_bg_position',
			'type'		=> 'select',
			'required' => array('default_bg_type','=', array( 'uploaded', 'predefined' ) ),
			'title'		=> __('Background Position', 'color-theme-framework'),
			'desc'		=> __('The background-position property sets the starting position of a background image.', 'color-theme-framework'),
			'options'	=> $theme_bg_position,
			'default'	=> 'left',
			),

		array(
			'id'		=>'default_bg_image',
			'type'		=> 'media',
			'required' => array('default_bg_type','=', 'uploaded' ),
			'url'		=> true,
			'title'		=> __('Uploaded Background Image', 'color-theme-framework'),
			'desc'		=> __('Upload any media using the WordPress native uploader.', 'color-theme-framework'),
			'default'	=> '',
			),

		array(
			'id'		=> 'default_predefined_bg',
			'type'		=> 'image_select',
			'required' => array('default_bg_type','=', 'predefined' ),
			'tiles'		=> true,
			'title'		=> __('Predefined Background Images', 'color-theme-framework'),
			'subtitle'	=> __('Select a background pattern.', 'color-theme-framework'),
			'default'	=> $sample_patterns_url.'bg01.jpg',
			'options'	=> $sample_patterns,
			),

		  array(
		   'id'  => 'custom-code-bar-info',
		   'type'  => 'info',
		   'style'  => 'success',
		   'desc'  => __('Custom CSS and JS Code.', 'color-theme-framework'),
		   ),

		array(
			'id'=>'custom_css',
			'type' => 'ace_editor',
			'mode' => 'css',
			'theme' => 'monokai',
			'title' => __('Custom CSS', "color-theme-framework"),
			'subtitle' => __('Quickly add some CSS to your theme by adding it to this block.', "color-theme-framework"),
			'desc' => __('This field is even CSS validated!', "color-theme-framework"),
			'validate' => "css",
			'default' => "",
			),

		array(
			'id'=>'js_code',
			'type' => 'ace_editor',
			'title' => __('Custom JS Code', "color-theme-framework"),
			'subtitle' => __('Paste your JS code here.', "color-theme-framework"),
			'mode' => 'javascript',
            'theme' => 'chrome',
			'desc' => 'This field is even JS Code validated. Use jQuery(document).ready(function(){ your code }); for your JS code',
            'default' => ""
			),
	)
);

$sections[] = array(
	'icon' => 'el-icon-th-large',
	'title' => __('Blog Options', "color-theme-framework"),
	'fields' => array(

		array(
			'id'=>'blog_num_posts',
			'type' => 'text',
			'title' => __('Number of posts for displaying in the Blog Widget', "color-theme-framework"),
			'subtitle' => "",
			'default' => '3',
			'desc' => __( 'Enter the number of posts', 'color-theme-framework' ),
			),

		  array(
		   'id'  => 'blog-index-info',
		   'type'  => 'info',
		   'style'  => 'success',
		   'desc'  => __('Blog Settings (index.php).', 'color-theme-framework'),
		   ),

		array(
			'id'=>'blog_layout',
			'type' => 'image_select',
			'compiler'	=> true,
			'title' => __('Layouts for the blog', "color-theme-framework"),
			'subtitle' => __('Choose between Two Columns or Full Width', "color-theme-framework"),
			'options' => array(
					'two_columns' => array('alt' => 'Two Columns', 'img' => $theme_path_images . '/main_layouts/two_columns.png'),
					'full_width' => array('alt' => 'Full Width', 'img' => $theme_path_images . '/main_layouts/full_width.png'),
				),
			'default' => 'full_width'
			),

		array(
			'id'=>'blog_sidebar',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Sidebar Position", "color-theme-framework"),
			'subtitle' => __("Select sidebar position for the blog page", "color-theme-framework"),
			'options' => array( "left" => "Left", "right" => "Right" ),
			'default' => "right"
			),

		array(
			'id'=>'blog_pagination',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Type of the pagination for the Blog page", "color-theme-framework"),
			'subtitle' => __("Select Standard/Infinite Scroll for the pagination", "color-theme-framework"),
			'options' => $type_of_pagination,
			'default' => "standard"
			),

		  array(
		   'id'  => 'blog-content-more-info',
		   'type'  => 'info',
		   'style'  => 'success',
		   'desc'  => __('Blog Content.', 'color-theme-framework'),
		   ),

		array(
			'id'=>'blog_type_content',
			'type' => 'select',
			'compiler' => true,
			'title' => __("Type of the blog content", "color-theme-framework"),
			'subtitle' => __("Use Excerpt or Content Function. Select a Excerpt (automatically) or Content (More tag)", "color-theme-framework"),
			'options' => array( "excerpt" => "Excerpt", "content" => "Content", "none" => "None" ),
			'default' => "excerpt"
			),

		array(
			'id'=>'blog_post_excerpt',
			'type' => 'text',
			'required'	=> array( 'blog_type_content', '=', 'excerpt'),
			'title' => __('Length of post excerpt (chars):', "color-theme-framework"),
			'subtitle' => __('Enter length for the post excerpt', "color-theme-framework"),
			'default' => '180',
			),

		  array(
		   'id'  => 'read-more-info',
		   'type'  => 'info',
		   'style'  => 'success',
		   'desc'  => __('Read More Link.', 'color-theme-framework'),
		   ),

		array(
			'id'=>'blog_post_readmore',
			'type' => 'switch',
			'title' => __("Read More Link", "color-theme-framework"),
			'subtitle'=> __("Enable or Disable read more link", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Enable',
			'off' => 'Disable',
			),

		array(
			'id'=>'readmore_text',
			'type' => 'text',
			'required'	=> array( 'blog_post_readmore', '=', '1'),
			'title' => __("Text for the Read more link", "color-theme-framework"),
			'subtitle' => __('Enter text.', "color-theme-framework"),
			'desc' => __( "Enter text for the read more " , "color-theme-framework" ),
			'default' => __( "Continue reading..." , "color-theme-framework" ),
			),

		  array(
		   'id'  => 'blog-post-meta-info',
		   'type'  => 'info',
		   'style'  => 'success',
		   'desc'  => __('Meta Settings for the Posts.', 'color-theme-framework'),
		   ),

		array(
			'id'=>'blog_post_author',
			'type' => 'switch',
			'title' => __("Author", "color-theme-framework"),
			'subtitle'=> __("Show or Hide author", "color-theme-framework"),
			"default" 	=> 0,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'blog_post_category',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Category", "color-theme-framework"),
			'subtitle'=> __("Show or Hide category for the posts", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'blog_post_date',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Date", "color-theme-framework"),
			'subtitle'=> __("Show or Hide date for the posts", "color-theme-framework"),
			"default" 		=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'blog_post_comments',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Comments", "color-theme-framework"),
			'subtitle'=> __("Show or Hide comments for the posts", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'blog_post_likes',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Likes", "color-theme-framework"),
			'subtitle'=> __("Show or Hide likes for the posts", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'blog_post_views',
			'type' => 'switch',
			'title' => __("Views", "color-theme-framework"),
			'subtitle'=> __("Show or Hide views", "color-theme-framework"),
			"default" 	=> 0,
			'on' => 'Show',
			'off' => 'Hide',
			),

	)
);

$sections[] = array(
	'icon' => 'el-icon-file-edit',
	'title' => __('Single Page', "color-theme-framework"),
	'fields' => array(

		array(
			'id'=>'featured_image_post',
			'type' => 'switch',
			'compiler'	=> true,
			'title' => __("Featured image", "color-theme-framework"),
			'subtitle'=> __("Show or Hide featured image in the single post", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'add_prettyphoto',
			'type' => 'switch',
			'title' => __("Add PrettyPhoto feature to all post images", "color-theme-framework"),
			'subtitle'=> __("Add PrettyPhoto feature to all post images with links", "color-theme-framework"),
			"default" 	=> 0,
			'on' => 'Enable',
			'off' => 'Disable',
			),

		array(
			'id'=>'single_date',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Date", "color-theme-framework"),
			'subtitle'=> __("Show or Hide date", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_category',
			'type' => 'switch',
			'title' => __("Categories", "color-theme-framework"),
			'subtitle'=> __("Show or Hide categories", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_author',
			'type' => 'switch',
			'title' => __("Author", "color-theme-framework"),
			'subtitle'=> __("Show or Hide author", "color-theme-framework"),
			"default" 	=> 0,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_comments',
			'type' => 'switch',
			'title' => __("Comments", "color-theme-framework"),
			'subtitle'=> __("Show or Hide categories", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_tags',
			'type' => 'switch',
			'title' => __("Tags", "color-theme-framework"),
			'subtitle'=> __("Show or Hide post tags", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_views',
			'type' => 'switch',
			'title' => __("Views", "color-theme-framework"),
			'subtitle'=> __("Show or Hide views", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_likes',
			'type' => 'switch',
			'title' => __("Likes", "color-theme-framework"),
			'subtitle'=> __("Show or Hide likes", "color-theme-framework"),
			"default" 	=> 0,
			'on' => 'Show',
			'off' => 'Hide',
			),

		array(
			'id'=>'single_share_enable',
			'type' => 'switch',
			'compiler' => true,
			'title' => __("Social Share Icons for the Single Page", "color-theme-framework"),
			'subtitle'=> __("Enable or Disable share icons", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Enabled',
			'off' => 'Disabled',
			),

		array(
			'id'=>'single_about_author',
			'type' => 'switch',
			'title' => __("About Author", "color-theme-framework"),
			'subtitle'=> __("Enable or Disable about author", "color-theme-framework"),
			"default" 	=> 0,
			'on' => 'Enable',
			'off' => 'Disable',
			),
	)
);



$sections[] = array(
	'icon' => 'el-icon-wrench',
	'title' => __('Footer Setings', "color-theme-framework"),
	'desc' => '',
	'fields' => array(

		array(
			'id'=>'footer-bg-info',
			'type' => 'info',
			'style' => 'success',
			'title' => __( "Background Options" , "color-theme-framework" ),
			'desc' => ""
        ),

		array(
			'id'=>'footer_bg_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Background Color for the footer', "color-theme-framework"),
			'subtitle' => __('Select BG color for the footer.', "color-theme-framework"),
			'default' => '#29343b',
			'validate' => 'color',
			),

		array(
		    'id' => 'footer_bg_opacity',
		    'compiler' => true,
		    'type' => 'slider',
		    'title' => __("Opacity for the footer section", "color-theme-framework"),
		    'subtitle' => __('Select opacity for the footer', "color-theme-framework"),
		    'desc' => "",
		    "default" => 1.00,
		    "min" => 0,
		    "step" => .05,
		    "max" => 1,
		    'resolution' => 0.01,
		    'display_value' => 'text'
		),

		array(
			'id'=>'copyright_info',
			'type' => 'info',
			'style' => 'success',
			'title' => __( "Copyrights" , "color-theme-framework" ),
			'desc' => ""
        ),

		array(
			'id'=>'copyright_bg_color',
			'type' => 'color',
			'compiler' => true,
			'transparent' => false,
			'title' => __('Background Color for the Copyrights', "color-theme-framework"),
			'subtitle' => __('Select BG color for the copyrights.', "color-theme-framework"),
			'default' => '#222b31',
			'validate' => 'color',
			),

		array(
			'id'=>'enable_copyrights',
			'type' => 'switch',
			'title' => __("Show Copyrights Information", "color-theme-framework"),
			'subtitle'=> __("Enable or Disable copyrights information", "color-theme-framework"),
			"default" 	=> 1,
			'on' => 'Enabled',
			'off' => 'Disabled'
			),

		array(
			'id'		=> 'copyright_padding',
			'type'		=> 'spacing',
			'required' => array('enable_copyrights','=','1'),
			'compiler'	=> true,
			'units'		=> 'px',
			'display_units' => 'false',
			'title'		=> __('Paddings for the copyright section (px)', 'color-theme-framework'),
			'default'	=> array('padding-top' => '30px', 'padding-right'=>"30px", 'padding-bottom' => '30px', 'padding-left'=>'30px' )
			),

		array(
			'id'=>'copyright_text',
			'type' => 'textarea',
			'required' => array('enable_copyrights','=','1'),
			'title' => __("Text for the Copyrights", "color-theme-framework"),
			'subtitle' => "",
			'desc' => __( "Enter text for the copyrights" , "color-theme-framework" ),
			'default' => '2015 Copyright. Proudly powered by <a href="http://wordpress.org/">WordPress.</a><br /><a href="http://themeforest.net/user/ZERGE?ref=zerge">Sparkler</a> Theme by <a href="http://color-theme.com/">Color Theme</a>.'
			),

		array(
			'id'=>'footer_text_color',
			'type' => 'color',
			'transparent' => false,
			'compiler' => true,
			'title' => __("Text Color", "color-theme-framework"),
			'subtitle' => __("Pick a color for text", "color-theme-framework"),
			'default' => "#56666d",
			'validate' => 'color'
			),

		array(
			'id'=>'footer_link_color',
			'type' => 'color',
			'transparent' => false,
			'compiler' => true,
			'title' => __("Color for the links", "color-theme-framework"),
			'subtitle' => __("Pick a color for the links", "color-theme-framework"),
			'default' => "#6c8088",
			'validate' => 'color'
			),

	)
);


global $ReduxFramework;
if ( !isset( $tabs ) ) $tabs = 0;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

// END Sample Config

function generate_options_css( $newdata ) {
    $smof_data = $newdata;
    $css_dir = get_stylesheet_directory() . '/css/';
    $css_php_dir = get_template_directory() . '/css/';
    ob_start();
    require( $css_php_dir . 'styles.php' );
    $css = ob_get_clean();
    global $wp_filesystem;
    WP_Filesystem();
    if ( ! $wp_filesystem->put_contents( $css_dir . 'options.css', $css, 0644 ) ) {
        return true;
    }
}

function ct_theme_css_compiler() {
	global $ct_options;
	generate_options_css( $ct_options );
}
add_action('redux-compiler-ct_options', 'ct_theme_css_compiler');