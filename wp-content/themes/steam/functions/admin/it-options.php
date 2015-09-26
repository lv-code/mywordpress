<?php
$option_tabs = array(
	'it_generalsettings_tab' => __( 'General Settings', IT_TEXTDOMAIN ),
	'it_menus_tab' => __( 'Menus', IT_TEXTDOMAIN ),
	'it_style_tab' => __( 'Style', IT_TEXTDOMAIN ),	
	'it_front_page_tab' => __( 'Front Page', IT_TEXTDOMAIN ),	
	'it_pages_tab' => __( 'Pages', IT_TEXTDOMAIN ),	
	'it_carousel_tab' => __( 'Content Carousels', IT_TEXTDOMAIN ),
	'it_loop_tab' => __( 'Post Loop', IT_TEXTDOMAIN ),	
	'it_posts_tab' => __( 'Single Articles', IT_TEXTDOMAIN ),
	'it_minisite_tab' => __( 'Minisite Setup', IT_TEXTDOMAIN ),
	'it_sidebar_tab' => __( 'Custom Sidebars', IT_TEXTDOMAIN ),
	'it_signoff_tab' => __( 'Signoffs', IT_TEXTDOMAIN ),
	'it_advertising_tab' => __( 'Advertising', IT_TEXTDOMAIN ),
	'it_footer_tab' => __( 'Footer', IT_TEXTDOMAIN ),
	'it_sociable_tab' => __( 'Social', IT_TEXTDOMAIN ),
	'it_advanced_tab' => __( 'Advanced', IT_TEXTDOMAIN )
);

#add woocommerce tab
if(function_exists('is_woocommerce')) {
	$option_tabs['it_woocommerce_tab'] = __( 'WooCommerce', IT_TEXTDOMAIN );
}

#add buddypress tab
if(function_exists('bp_current_component')) {
	$option_tabs['it_buddypress_tab'] = __( 'BuddyPress', IT_TEXTDOMAIN );
}

# add minisite tabs
$minisite = it_get_setting('minisite');

if ( isset($minisite['keys']) && $minisite['keys'] != '#' ) {
	$minisite_keys = explode(',',$minisite['keys']);
	foreach ($minisite_keys as $mkey) {
		if ( $mkey != '#') {
			$minisite_name = ( !empty( $minisite[$mkey]['name'] ) ) ? $minisite[$mkey]['name'] : '#';
			$minisite_slug = it_get_slug($minisite[$mkey]['slug'], $minisite_name);				
			$option_tabs['it_'.$minisite_slug.'_minisite_tab'] = $minisite_name . __( ' Minisite', IT_TEXTDOMAIN );
		}
	}
}

$options = array(
	
	/**
	 * Navigation
	 */
	array(
		'name' => $option_tabs,
		'type' => 'navigation'
	),
	
	/**
	 * General Settings
	 */
	array(
		'name' => array( 'it_generalsettings_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Logos & Branding', IT_TEXTDOMAIN ),
			'desc' => __( 'General settings for logos and branding of your site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable Logo Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'Disable the area that shows the header ad and larger logo area', IT_TEXTDOMAIN ),
			'id' => 'logobar_disable',
			'options' => array( 'true' => __( 'Hide the logo bar underneath the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo Only', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the logo bar without displaying the logo again', IT_TEXTDOMAIN ),
			'id' => 'logo_disable',
			'options' => array( 'true' => __( 'Hide the logo only from the logo bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Logo Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'You can choose whether you wish to display a custom logo or your site title.', IT_TEXTDOMAIN ),
			'id' => 'display_logo',
			'options' => array(
				'true' => __( 'Custom Image Logo', IT_TEXTDOMAIN ),
				'' => sprintf( __( 'Display Site Title <small><a href="%1$s/wp-admin/options-general.php" target="_blank">(click here to edit site title)</a></small>', IT_TEXTDOMAIN ), esc_url( get_option('siteurl') ) )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Hide Tagline', IT_TEXTDOMAIN ),
			'desc' => __( 'This disables the tagline (site description) from displaying without requiring you to actually delete the Tagline from Settings >> General (good for SEO purposes). The tagline only actually displays if you have the logo bar set to display.', IT_TEXTDOMAIN ),
			'id' => 'description_disable',
			'options' => array( 'true' => __( 'Hide the site Tagline from the logo bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Custom Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo. If you are displaying your logo in the sticky bar, max height is 60px.', IT_TEXTDOMAIN ),
			'id' => 'logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_width',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'logo_height',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Custom HD Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for retina displays. If you are displaying your logo in the sticky bar, max height is 120px.', IT_TEXTDOMAIN ),
			'id' => 'logo_url_hd',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Login Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo for login page.', IT_TEXTDOMAIN ),
			'id' => 'login_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Custom Favicon', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your favicon.', IT_TEXTDOMAIN ),
			'id' => 'favicon_url',
			'type' => 'upload'
		), 
		
		array(
			'name' => __( 'Sticky Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'The fixed bar that displays menus and controls at the top of the site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable Logo', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_disable',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Sticky Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as the logo in your sticky bar. If you leave this blank it will use the main logo.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'HD Sticky Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as the logo in your sticky bar for retina displays. If you leave this blank it will use the main HD logo.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_url_hd',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_width',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
			'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
			'id' => 'sticky_logo_height',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Sticky Menu', IT_TEXTDOMAIN ),
			'id' => 'sticky_menu_disable_global',
			'options' => array( 'true' => __( 'Disable the drop down menu next to the logo.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable New Articles', IT_TEXTDOMAIN ),
			'id' => 'new_articles_disable_global',
			'options' => array( 'true' => __( 'Disable the new articles panel from displaying on the front page.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'New Articles Prefix', IT_TEXTDOMAIN ),
			'desc' => __( 'The prefix to display before the time period in the tooltip. Leave blank to only display the time period.', IT_TEXTDOMAIN ),
			'id' => 'new_prefix',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'New Articles Label Override', IT_TEXTDOMAIN ),
			'desc' => __( 'Roll your own label instead of letting the system generate one - displays in the hover tooltip.', IT_TEXTDOMAIN ),
			'id' => 'new_label_override',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'New Articles Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the new articles section.', IT_TEXTDOMAIN ),
			'id' => 'new_number',
			'target' => 'steam_number',
			'type' => 'select'
		),	
		array(
			'name' => __( 'New Articles Time Period', IT_TEXTDOMAIN ),
			'desc' => __( 'Show count and posts for only this time period.', IT_TEXTDOMAIN ),
			'id' => 'new_timeperiod',
			'target' => 'new_timeperiod',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Random Article', IT_TEXTDOMAIN ),
			'id' => 'random_disable',
			'options' => array( 'true' => __( 'Disable the random article button next to the main menu', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Search', IT_TEXTDOMAIN ),
			'id' => 'search_disable',
			'options' => array( 'true' => __( 'Disable the search box in the sticky bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Login/Register', IT_TEXTDOMAIN ),
			'id' => 'sticky_controls_disable_global',
			'options' => array( 'true' => __( 'Disable the login and register buttons in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Global Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings pertain to elements that are available/visible across your entire site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Disable Responsiveness', IT_TEXTDOMAIN ),
			'desc' => __( 'When you view the site on a tablet or mobile, it will look and function exactly as it does on a large desktop display.', IT_TEXTDOMAIN ),
			'id' => 'responsive_disable',
			'options' => array( 'true' => __( 'Disable responsive layout behavior', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Default Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'The default page layout for all pages and posts.', IT_TEXTDOMAIN ),
			'id' => 'layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Force Global Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally forces the above layout to be used even if specific sections or pages dictate a different layout.', IT_TEXTDOMAIN ),
			'id' => 'layout_global',
			'options' => array( 'true' => __( 'The above layout should override all other settings.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all pages and posts', IT_TEXTDOMAIN ),
			'id' => 'featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'790' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Force Global Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally forces the above featured image size to be used even if specific sections or pages dictate a different size.', IT_TEXTDOMAIN ),
			'id' => 'featured_image_size_global',
			'options' => array( 'true' => __( 'The above featured image size should override all other settings.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Comments Globally', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally disables comments from displaying, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'id' => 'comments_disable_global',
			'options' => array( 'true' => __( 'Completely disable the comments for the entire site', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Views Globally', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally disables view counts from displaying, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'id' => 'views_disable_global',
			'options' => array( 'true' => __( 'Completely disable the view counts for the entire site', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Google Analytics Code', IT_TEXTDOMAIN ),
			'desc' =>  __( 'After signing up with Google Analytics paste the code that it gives you here.', IT_TEXTDOMAIN ),
			'id' => 'analytics_code',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS', IT_TEXTDOMAIN ),
			'desc' => __( 'This is a great place for doing quick custom styles.  For example if you wanted to change the site title color then you would paste this:<br /><br /><code>#logo a { color: blue; }</code>', IT_TEXTDOMAIN ),
			'id' => 'custom_css',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom JavaScript', IT_TEXTDOMAIN ),
			'desc' => __( 'In case you need to add some custom javascript you may insert it here.', IT_TEXTDOMAIN ),
			'id' => 'custom_js',
			'type' => 'textarea'
		),			
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Menus
	 */
	array(
		'name' => array( 'it_menus_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Disable Top Menu', IT_TEXTDOMAIN ),
			'desc' => __( 'This disables the top menu but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite).', IT_TEXTDOMAIN ),
			'id' => 'topmenu_disable',
			'options' => array( 'true' => __( 'Disable the top menu by default', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Top Menu Globally', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally disables the top menu, even if you have it turned on in other areas of the theme (such as for a specific minisite)', IT_TEXTDOMAIN ),
			'id' => 'topmenu_disable_global',
			'options' => array( 'true' => __( 'Completely disable the top menu for the entire site', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Section Menu Type', IT_TEXTDOMAIN ),
			'id' => 'section_menu_type',
			'desc' => __( 'Choosing Mega menu style will enable latest posts from each minisite or category to display directly in the menu on mouse hover.', IT_TEXTDOMAIN ),
			'options' => array( 
				'standard' => __( 'Standard WordPress menu', IT_TEXTDOMAIN ),
				'mega' => __( 'Mega menu', IT_TEXTDOMAIN )
			),
			'default' => 'mega',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Pre-load Mega Menus', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_preload',
			'desc' => __( 'Adds a small amount of initial overhead so users do not have to wait to see posts when hovering over mega menu items. The expense is negligible in most cases.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Mega menu drop downs should populate on page load', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Number of Section Menu Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The total number of posts to display for each menu item in the mega menus', IT_TEXTDOMAIN ),
			'id' => 'section_menu_article_num',
			'target' => 'ad_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Section Menu Images', IT_TEXTDOMAIN ),			
			'id' => 'section_menu_thumbnails_disable',
			'options' => array( 'true' => __( 'Hide the thumbnails in the mega menu post listings', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Section Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays for the menu when in responsive view. If left blank it will display "SECTIONS".', IT_TEXTDOMAIN ),
			'id' => 'section_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Sub Menu Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The label that displays for the menu. If left blank it will display "MORE".', IT_TEXTDOMAIN ),
			'id' => 'sub_menu_label',
			'default' => '',
			'htmlspecialchars' => false,
			'type' => 'text'
		),	
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Styles
	 */
	array(
		'name' => array( 'it_style_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Accents', IT_TEXTDOMAIN ),
			'desc' => __( 'Used for links, titles, buttons, and other accent colors.', IT_TEXTDOMAIN ),
			'id' => 'color_accent',
			'type' => 'color'
		),	
		
		array(
			'name' => __( 'Box Gradients', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose four colors for the diagonal gradients used in image box overlays. The theme will use a combination of these colors to create the gradients. More than four colors causes a busy look no matter how good the color scheme is. We recommend using a site like ColourLovers.com to find a good color scheme. Darker colors are better because they enhance the overlay text. Leave these blank to use the default colors.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => 'Box Gradient 1',
			'id' => 'color_boxes_1',
			'type' => 'color'
		),	
		array(
			'name' => 'Box Gradient 2',
			'id' => 'color_boxes_2',
			'type' => 'color'
		),	
		array(
			'name' => 'Box Gradient 3',
			'id' => 'color_boxes_3',
			'type' => 'color'
		),	
		array(
			'name' => 'Box Gradient 4',
			'id' => 'color_boxes_4',
			'type' => 'color'
		),	
		array(
			'name' => __( 'Fonts', IT_TEXTDOMAIN ),
			'desc' => __( 'You can override the default fonts for several parts of the theme by selecting them below. Leave the font unselected to use the default font, or if you have already made a selection and want to set it back to the default, select "Choose One..." For performance reasons only selected fonts will be imported from Google, which means we cannot display all the actual font faces in this list. To preview what each font looks like without having to activate each one, go to Google Fonts and take a look at it: http://www.google.com/fonts/', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Menus Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font to use for the menus.', IT_TEXTDOMAIN ),
			'id' => 'font_menus',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Section Headers Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font to use for the various section headers throughout the site.', IT_TEXTDOMAIN ),
			'id' => 'font_section_headers',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Content Headers Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font to use for the headers within page and post content.', IT_TEXTDOMAIN ),
			'id' => 'font_content_headers',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Body Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font to use for the body text.', IT_TEXTDOMAIN ),
			'id' => 'font_body',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Body Font Size', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font size to use for the body text.', IT_TEXTDOMAIN ),
			'id' => 'font_body_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Widgets Font Face', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font to use for the widget text.', IT_TEXTDOMAIN ),
			'id' => 'font_widgets',
			'target' => 'fonts',
			'type' => 'select'
		),
		array(
			'name' => __( 'Widgets Font Size', IT_TEXTDOMAIN ),
			'desc' => __( 'Select which font size to use for the widget text.', IT_TEXTDOMAIN ),
			'id' => 'font_widgets_size',
			'target' => 'font_size',
			'type' => 'select'
		),
		array(
			'name' => __( 'Add Subsets', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave this unselected unless you specifically want to add subsets beyond Latin. This will only work for fonts that actually have the specific subset (refer to Google Fonts to see which ones have subsets). This also adds the character sets to the default theme fonts. Be careful! Adding subsets will impact page load times.', IT_TEXTDOMAIN ),
			'id' => 'font_subsets',
			'options' => array(
				'latin' => 'Latin',
				'latin-ext' => 'Latin Extended',
				'cyrillic' => 'Cyrillic',
				'cyrillic-ext' => 'Cyrillic Extended',
				'greek' => 'Greek',
				'greek-ext' => 'Greek Extended'
			),
			'type' => 'checkbox'
		),

	
	array(
		'type' => 'tab_end'
	),	
	
	/**
	 * Front Page
	 */
	array(
		'name' => array( 'it_front_page_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose the content that should populate each section of the front page.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => ' ',
			'id' => 'front_1',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_2',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_3',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_4',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_5',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_6',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_7',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_8',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_9',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_10',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'front_11',
			'target' => 'builder',
			'type' => 'select'
		),
	
		array(
			'name' => __( 'Boxes', IT_TEXTDOMAIN ),
			'desc' => __( 'The toggle panel in the main menu that expands to show latest articles.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'boxes_disable',
			'options' => array( 'true' => __( 'Disable the boxes from the front page.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'desc' => __( 'This globally disables teh boxes from displaying, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'id' => 'boxes_disable_global',
			'options' => array( 'true' => __( 'Force disable boxes for the entire site', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Overlay Type', IT_TEXTDOMAIN ),
			'id' => 'boxes_overlay_type',			
			'options' => array( 
				'color' => __( 'Color gradient overlays', IT_TEXTDOMAIN ),
				'black' => __( 'Flat black overlays', IT_TEXTDOMAIN )
			),
			'default' => 'color',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'id' => 'boxes_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/boxes_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/boxes_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/boxes_c.png',
				'd' => THEME_ADMIN_ASSETS_URI . '/images/boxes_d.png',
				'e' => THEME_ADMIN_ASSETS_URI . '/images/boxes_e.png',
				'f' => THEME_ADMIN_ASSETS_URI . '/images/boxes_f.png',
				'g' => THEME_ADMIN_ASSETS_URI . '/images/boxes_g.png'
			),
			'default' => 'a',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose a category to use to populate the boxes. Only posts within this category will be shown. You can combine a tag and a category to further narrow down the boxes. Leave both category and tag blank to use latest posts.', IT_TEXTDOMAIN ),
			'id' => 'boxes_cat',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Tag', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose a tag to use to populate the boxes. Only posts with this tag will be shown. You can combine a tag and a category to further narrow down the boxes. Leave both category and tag blank to use latest posts.', IT_TEXTDOMAIN ),
			'id' => 'boxes_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		
		array(
			'name' => __( "Exclusive! Headline", IT_TEXTDOMAIN ),
			'desc' => __( 'The bar that displays one article in a bold format.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'exclusive_disable',
			'options' => array( 'true' => __( 'Disable the headline by default', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This disables the headline but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'id' => 'exclusive_disable_global',
			'options' => array( 'true' => __( 'Completely disable the headline', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This globally disables the headline, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Top label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the main label that displays to the left of the article.', IT_TEXTDOMAIN ),
			'id' => 'exclusive_label_top',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Bottom label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the label that displays to the left of the article underneath the top label.', IT_TEXTDOMAIN ),
			'id' => 'exclusive_label_bottom',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your categories to use for the headline, or leave blank to use a different method.', IT_TEXTDOMAIN ),
			'id' => 'exclusive_category',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Use Tag Instead', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your tags to use for the headline, or leave blank to use a different method.', IT_TEXTDOMAIN ),
			'id' => 'exclusive_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable "Full Story"', IT_TEXTDOMAIN ),
			'id' => 'exclusive_more_disable',
			'options' => array( 'true' => __( 'Disable the full story link on the right', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( "Connect", IT_TEXTDOMAIN ),
			'desc' => __( 'The bar that displays the email signup, social counts, and social badges', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'connect_disable',
			'options' => array( 'true' => __( 'Disable the connect bar by default', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This disables the connect bar but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'id' => 'connect_disable_global',
			'options' => array( 'true' => __( 'Completely disable the connect bar', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This globally disables the connect bar, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Top label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the main label that displays to the left of the connect bar.', IT_TEXTDOMAIN ),
			'id' => 'connect_label_top',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Bottom label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the label that displays to the left of the connect bar underneath the top label.', IT_TEXTDOMAIN ),
			'id' => 'connect_label_bottom',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Disable Email Signup', IT_TEXTDOMAIN ),
			'id' => 'connect_email_disable',
			'options' => array( 'true' => __( 'Disable the email signup form right of the main label', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Email label', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the placeholder text that displays in the email singup textbox.', IT_TEXTDOMAIN ),
			'id' => 'email_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Social Counts', IT_TEXTDOMAIN ),
			'id' => 'connect_counts_disable',
			'options' => array( 'true' => __( 'Disable the social counts right of the email singup', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Badges', IT_TEXTDOMAIN ),
			'id' => 'connect_social_disable',
			'options' => array( 'true' => __( 'Disable the social badges at the very right of the connect bar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Page Layouts
	 */
	array(
		'name' => array( 'it_pages_tab' => $option_tabs ),
		'type' => 'tab_start'
	),

		array(
			'name' => __( 'Archive Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'This includes all category, tag, and date listing archive pages as well as search results listings.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => ' ',
			'id' => 'archive_1',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_2',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_3',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_4',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_5',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_6',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_7',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_8',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_9',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_10',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'archive_11',
			'target' => 'builder',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Page Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'All standard pages created in WordPress, including author listing and 404 pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => ' ',
			'id' => 'page_1',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_2',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_3',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_4',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_5',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_6',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_7',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_8',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_9',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_10',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'page_11',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Sticky Logo', IT_TEXTDOMAIN ),
			'id' => 'page_sticky_logo_disable',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo Bar', IT_TEXTDOMAIN ),
			'id' => 'page_logobar_disable',
			'options' => array( 'true' => __( 'Disable the logo bar for all standard pages only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Logo Only', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the logo bar without displaying the logo again', IT_TEXTDOMAIN ),
			'id' => 'page_logo_disable',
			'options' => array( 'true' => __( 'Hide the logo only from the logo bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'page_layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all standard pages only', IT_TEXTDOMAIN ),
			'id' => 'page_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'790' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => 'page_sortbar_views_disable',
			'options' => array( 'true' => __( 'Disable the view count for all standard pages only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
			'id' => 'page_sortbar_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button for all standard pages only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Count', IT_TEXTDOMAIN ),
			'id' => 'page_sortbar_comments_disable',
			'options' => array( 'true' => __( 'Disable the comment count for all standard pages only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Enable Comments', IT_TEXTDOMAIN ),
			'id' => 'page_comments',
			'options' => array( 'true' => __( 'Enable comments on regular pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Author Listing Page', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to any page given the Author Listing page template', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Enable Admins', IT_TEXTDOMAIN ),
			'id' => 'author_admin_enable',
			'options' => array( 'true' => __( 'Allow the admin user role to display in the list', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Hide Empty', IT_TEXTDOMAIN ),
			'id' => 'author_empty_disable',
			'options' => array( 'true' => __( 'Hide authors with zero posts', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Manual Exclude', IT_TEXTDOMAIN ),
			'desc' => __( 'Enter a comma-separated list of usernames to exclude', IT_TEXTDOMAIN ),
			'id' => 'author_exclude',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'User Role', IT_TEXTDOMAIN ),
			'desc' => __( 'Select a user role to display', IT_TEXTDOMAIN ),
			'id' => 'author_role',
			'target' => 'author_role',
			'type' => 'select'
		),
		array(
			'name' => __( 'Order', IT_TEXTDOMAIN ),
			'desc' => __( 'Select how to order the list', IT_TEXTDOMAIN ),
			'id' => 'author_order',
			'target' => 'author_order',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Minisite Directory Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to any page given the Minisite Directory page template', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => ' ',
			'id' => 'directory_1',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_2',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_3',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_4',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_5',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_6',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_7',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_8',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_9',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_10',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'directory_11',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Sticky Logo', IT_TEXTDOMAIN ),
			'id' => 'directory_sticky_logo_disable',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo Bar', IT_TEXTDOMAIN ),
			'id' => 'directory_logobar_disable',
			'options' => array( 'true' => __( 'Disable the logo bar for all directory pages only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Logo Only', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the logo bar without displaying the logo again', IT_TEXTDOMAIN ),
			'id' => 'directory_logo_disable',
			'options' => array( 'true' => __( 'Hide the logo only from the logo bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Unique Sidebar', IT_TEXTDOMAIN ),
			'id' => 'directory_sidebar_unique',
			'options' => array( 'true' => __( 'Use the Minisite Directory Sidebar instead of the Loop Sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		

	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Carousels
	 */
	array(
		'name' => array( 'it_carousel_tab' => $option_tabs ),
		'type' => 'tab_start'
	),		
		
		array(
			'name' => __( 'Featured Slider', IT_TEXTDOMAIN ),
			'desc' => __( 'The carousel that displays a large window scrolling between featured posts and a side-scroller to the right.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'featured_disable',
			'options' => array( 'true' => __( 'Disable the slider by default', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This disables the slider but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'id' => 'featured_disable_global',
			'options' => array( 'true' => __( 'Completely disable the slider', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This globally disables the slider, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'There are three available layouts, the full-width layout completely hides the side scroller.', IT_TEXTDOMAIN ),
			'id' => 'featured_layout',
			'options' => array(
				'small' => THEME_ADMIN_ASSETS_URI . '/images/featured_small.png',
				'medium' => THEME_ADMIN_ASSETS_URI . '/images/featured_medium.png',
				'large' => THEME_ADMIN_ASSETS_URI . '/images/featured_large.png',
			),
			'default' => 'small',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your categories to use for the featured slider. Only posts from this category will be shown.', IT_TEXTDOMAIN ),
			'id' => 'featured_category',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Tag', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your tags to use for the featured slider. Only posts with this tag will be shown.', IT_TEXTDOMAIN ),
			'id' => 'featured_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		array(
			'name' => __( 'Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the carousel.', IT_TEXTDOMAIN ),
			'id' => 'featured_number',
			'target' => 'sizzlin_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Interval', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of seconds to display each item in the carousel before rotating.', IT_TEXTDOMAIN ),
			'id' => 'featured_interval',
			'target' => 'seconds',
			'type' => 'select'
		),
		array(
			'name' => __( 'Transition', IT_TEXTDOMAIN ),
			'desc' => __( 'The effect used to transition from one slide to the next', IT_TEXTDOMAIN ),
			'id' => 'featured_transition',
			'target' => 'featured_transition',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Timer', IT_TEXTDOMAIN ),
			'id' => 'featured_timer_disable',
			'options' => array( 'true' => __( 'Hide the timer bar at the bottom of the carousel', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'The timer is the white progressing bar at the bottom of the carousel that indicates the time left for the current post.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Rating', IT_TEXTDOMAIN ),
			'id' => 'featured_rating_disable',
			'options' => array( 'true' => __( 'Hide the rating (if one exists)', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Category', IT_TEXTDOMAIN ),
			'id' => 'featured_category_disable',
			'options' => array( 'true' => __( 'Hide the category/minisite icon', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Meta', IT_TEXTDOMAIN ),
			'id' => 'featured_meta_disable',
			'options' => array( 'true' => __( 'Hide the likes/views/comments', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Award', IT_TEXTDOMAIN ),
			'id' => 'featured_award_disable',
			'options' => array( 'true' => __( 'Hide the award (if article has an award)', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Caption Label', IT_TEXTDOMAIN ),
			'id' => 'featured_label_disable',
			'options' => array( 'true' => __( 'Hide the "Featured" caption label', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Top Caption label', IT_TEXTDOMAIN ),
			'desc' => __( 'Text that displays at the top right of the featured slider. Default is "Featured".', IT_TEXTDOMAIN ),
			'id' => 'featured_label',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Disable Top Caption', IT_TEXTDOMAIN ),
			'id' => 'featured_caption_disable',
			'options' => array( 'true' => __( 'Completely disable the top caption bar', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Title', IT_TEXTDOMAIN ),
			'id' => 'featured_title_disable',
			'options' => array( 'true' => __( 'Hide the article title', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Disable Video', IT_TEXTDOMAIN ),
			'id' => 'featured_video_disable',
			'options' => array( 'true' => __( 'If this article has a featured video, do not display it in the slider', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Video Style', IT_TEXTDOMAIN ),
			'id' => 'featured_video_style',
			'desc' => __( 'When the featured video is underneath the captions the user cannot interact with the video itself which is why autoplay is turned on. When it is the top most layer the user can freely interact with it so autoplay is turned off.', IT_TEXTDOMAIN ),
			'options' => array( 
				'top' => __( 'On top of captions with autoplay turned off', IT_TEXTDOMAIN ),
				'bottom' => __( 'Underneath captions with autoplay turned on', IT_TEXTDOMAIN ),
			),
			'default' => 'top',
			'type' => 'radio'
		),	
		
		array(
			'name' => __( 'Featured Sidecar', IT_TEXTDOMAIN ),
			'desc' => __( 'The vertically scrolling carousel to the right of the featured slider.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your categories to use. Only posts from this category will be shown.', IT_TEXTDOMAIN ),
			'id' => 'sidecar_category',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Tag', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your tags to use. Only posts with this tag will be shown.', IT_TEXTDOMAIN ),
			'id' => 'sidecar_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		
		
		array(
			'name' => __( 'Top Ten Slider', IT_TEXTDOMAIN ),
			'desc' => __( 'The horizontally scrolling top ten slider.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'topten_disable',
			'options' => array( 'true' => __( 'Disable the slider by default', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This disables the slider but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'id' => 'topten_disable_global',
			'options' => array( 'true' => __( 'Completely disable the slider', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This globally disables the slider, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Label', IT_TEXTDOMAIN ),
			'desc' => __( 'You can overwrite the "Top 10" label that displays by default next to the selector drop down filter.', IT_TEXTDOMAIN ),
			'id' => 'topten_label',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Time Period', IT_TEXTDOMAIN ),
			'desc' => __( 'Limit posts in the Top Ten slider to this time period.', IT_TEXTDOMAIN ),
			'id' => 'topten_timeperiod',
			'target' => 'timeperiod',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Filter Options', IT_TEXTDOMAIN ),
			'desc' => __( 'You can disable individual filter options.', IT_TEXTDOMAIN ),
			'id' => 'topten_disable_filter',
			'options' => array(
				'viewed' => 'Most Views',
				'liked' => 'Most Likes',
				'reviewed' => 'Best Reviewed',
				'rated' => 'Highest Rated',
				'commented' => 'Commented On'
			),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Trending Slider', IT_TEXTDOMAIN ),
			'desc' => __( 'The horizontally scrolling trending slider.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'trending_disable',
			'options' => array( 'true' => __( 'Disable the slider by default', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This disables the slider but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'id' => 'trending_disable_global',
			'options' => array( 'true' => __( 'Completely disable the slider', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This globally disables the slider, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Label', IT_TEXTDOMAIN ),
			'desc' => __( 'You can overwrite the "Trending" label that displays by default next to the selector drop down filter.', IT_TEXTDOMAIN ),
			'id' => 'trending_label',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Sub-Label', IT_TEXTDOMAIN ),
			'desc' => __( 'You can overwrite the "Whats Hot" label that displays by default below the main label.', IT_TEXTDOMAIN ),
			'id' => 'trending_sublabel',
			'htmlentities' => true,
			'type' => 'text'
		),	
		array(
			'name' => __( 'Time Period', IT_TEXTDOMAIN ),
			'desc' => __( 'Limit posts in the Trending slider to this time period.', IT_TEXTDOMAIN ),
			'id' => 'trending_timeperiod',
			'target' => 'timeperiod',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the carousel.', IT_TEXTDOMAIN ),
			'id' => 'trending_number',
			'target' => 'steam_number',
			'type' => 'select'
		),	
		
		array(
			'name' => __( 'Steam Content', IT_TEXTDOMAIN ),
			'desc' => __( 'The carousel that displays posts horizontally with right and left navigation arrows.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable', IT_TEXTDOMAIN ),
			'id' => 'steam_disable',
			'options' => array( 'true' => __( 'Disable the slider by default', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This disables the slider but causes it to be opt in, meaning you can enable it in other areas of the theme and it will override this setting (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Globally', IT_TEXTDOMAIN ),
			'id' => 'steam_disable_global',
			'options' => array( 'true' => __( 'Completely disable the slider', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This globally disables the slider, even if you have it turned on in other areas of the theme (such as for a specific minisite or for archive pages)', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your categories to use for the carousel, or leave blank to use a different method.', IT_TEXTDOMAIN ),
			'id' => 'steam_category',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Use Tag Instead', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your tags to use for the carousel, or leave blank to use a different method.', IT_TEXTDOMAIN ),
			'id' => 'steam_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		array(
			'name' => __( 'Number of Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the carousel.', IT_TEXTDOMAIN ),
			'id' => 'steam_number',
			'target' => 'steam_number',
			'type' => 'select'
		),	
		array(
			'name' => __( 'Disable Rating', IT_TEXTDOMAIN ),
			'id' => 'steam_rating_disable',
			'options' => array( 'true' => __( 'Do not show the rating in the bottom right corner', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Award', IT_TEXTDOMAIN ),
			'id' => 'steam_award_disable',
			'options' => array( 'true' => __( 'Do not show the award in the top right corner', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Post Loop
	 */
	array(
		'name' => array( 'it_loop_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Disable Sticky Logo', IT_TEXTDOMAIN ),
			'id' => 'archive_sticky_logo_disable',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo Bar', IT_TEXTDOMAIN ),
			'id' => 'archive_logobar_disable',
			'options' => array( 'true' => __( 'Disable the logo bar on post loop pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo Only', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the logo bar without displaying the logo again', IT_TEXTDOMAIN ),
			'id' => 'archive_logo_disable',
			'options' => array( 'true' => __( 'Hide the logo only from the logo bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),		
		array(
			'name' => __( 'Control Bar', IT_TEXTDOMAIN ),
			'desc' => __( 'The title and filter buttons at the top of the post loop.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Title Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This is the title text that will display in the control bar.', IT_TEXTDOMAIN ),
			'id' => 'loop_title',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Filtering', IT_TEXTDOMAIN ),
			'id' => 'loop_filtering_disable',
			'options' => array( 'true' => __( 'Disable the filter buttons', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This will disable the filter buttons for all post loops', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Filter Buttons', IT_TEXTDOMAIN ),
			'desc' => __( 'You can disable individual filter buttons.', IT_TEXTDOMAIN ),
			'id' => 'loop_filter_disable',
			'options' => array(
				'liked' => 'Liked',
				'viewed' => 'Viewed',
				'reviewed' => 'Reviewed',
				'rated' => 'Rated',
				'commented' => 'Commented',
				'awarded' => 'Awarded'
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Filter Tooltips', IT_TEXTDOMAIN ),
			'id' => 'loop_tooltips_disable',
			'options' => array( 'true' => __( 'Disable the filter button tooltips', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'This will disable the tooltips that display when you hover over the filter buttons', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Articles', IT_TEXTDOMAIN ),
			'desc' => __( 'Main settings for the articles and layout for the loop.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can select between four main layouts: grid style with and without sidebar, and list style with and without sidebar.', IT_TEXTDOMAIN ),
			'id' => 'loop_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/loop_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/loop_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/loop_c.png',
				'd' => THEME_ADMIN_ASSETS_URI . '/images/loop_d.png',
				'e' => THEME_ADMIN_ASSETS_URI . '/images/loop_e.png',
				'f' => THEME_ADMIN_ASSETS_URI . '/images/loop_f.png',
			),
			'default' => 'a',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Award', IT_TEXTDOMAIN ),
			'id' => 'loop_award_disable',
			'options' => array( 'true' => __( 'Awards will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Badges', IT_TEXTDOMAIN ),
			'id' => 'loop_badge_disable',
			'options' => array( 'true' => __( 'Badges will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Authorship', IT_TEXTDOMAIN ),
			'id' => 'loop_authorship_disable',
			'options' => array( 'true' => __( 'The author and date of the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Excerpt', IT_TEXTDOMAIN ),
			'id' => 'loop_excerpt_disable',
			'options' => array( 'true' => __( 'Only the title will display, no excerpt', IT_TEXTDOMAIN ) ),
			'desc' => __( 'It is helpful to hide this if you have a lot of badges and awards you want to display for your posts in order to present a cleaner layout to the user', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Excerpt Length', IT_TEXTDOMAIN ),
			'desc' => __( 'Leave blank for default excerpt lengths. Or, specify your desired excerpt length in characters (not words). Only applies to excerpts used in post loops (grid and list views). Default is 520 for grid layout and 800 for list layout.', IT_TEXTDOMAIN ),
			'id' => 'loop_excerpt_length',
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Likes', IT_TEXTDOMAIN ),
			'id' => 'loop_likes_disable',
			'options' => array( 'true' => __( 'Likes will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Views', IT_TEXTDOMAIN ),
			'id' => 'loop_views_disable',
			'options' => array( 'true' => __( 'Views will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
			'id' => 'loop_comments_disable',
			'options' => array( 'true' => __( 'Comments will only display on single post pages', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'The number of comments will not display in the main loop. Keep in mind the comments will automatically be hidden if there are no comments for the post even if this option is unselected.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Rating', IT_TEXTDOMAIN ),
			'id' => 'loop_rating_disable',
			'options' => array( 'true' => __( 'Ratings will only display on single post pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable All Meta Info', IT_TEXTDOMAIN ),
			'id' => 'loop_meta_disable',
			'options' => array( 'true' => __( 'Disregard above options and disable entire meta bar', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'The bar at the bottom of each post in the loop containing the views, likes, date, rating, etc. will be completely hidden.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Featured Videos', IT_TEXTDOMAIN ),
			'id' => 'loop_video',
			'options' => array( 'true' => __( 'Show featured videos in place of images', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'When the post has a featured video assigned, display it instead of the featured image.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Show Video Controls', IT_TEXTDOMAIN ),
			'id' => 'loop_video_controls',
			'options' => array( 'true' => __( 'Show video controls for featured videos (youtube only)', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'When the slide has a featured video, display the controls at the bottom of the video (only applies to Youtube videos).', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Pagination', IT_TEXTDOMAIN ),
			'desc' => __( 'The page number buttons and navigation that appear below the post loop.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Range', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of pages to display to the right and left of the current page. Setting this to 3 for example will result in 7 total possible page number buttons generated (3 on the left, 3 on the right, plus the current page) in addition to the arrow navigation (if enabled).', IT_TEXTDOMAIN ),
			'id' => 'page_range',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Range (Mobile)', IT_TEXTDOMAIN ),
			'desc' => __( 'You can set a different range for mobile views so that the pagination fits into one row. If you want the pagination to fit into one row set this to 2.', IT_TEXTDOMAIN ),
			'id' => 'page_range_mobile',
			'target' => 'range_number',
			'type' => 'select',
			'nodisable' => true,
		),	
		array(
			'name' => __( 'Disable Prev/Next Navigation', IT_TEXTDOMAIN ),
			'id' => 'prev_next_disable',
			'options' => array( 'true' => __( 'Hide the next and previous navigation arrows.', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'These arrows display on the right and left of the pagination. They do not navigate to the next and previous pages, but rather the next and previous blocks of page numbers. For instance, if the range is set to 6 the next arrow will increase the current page 8 slots (range + current page + 1).', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable First/Last Navigation', IT_TEXTDOMAIN ),
			'id' => 'first_last_disable',
			'options' => array( 'true' => __( 'Hide the first and last navigation arrows.', IT_TEXTDOMAIN ) ), 
			'desc' => __( 'These arrows display on the right and left of the pagination and they are used for quickly navigating to the first or last page.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Limit Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'Instead of displaying all posts in the loop you can limit to or exclude certain posts based on categories, tags, and minisites.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Limit To Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose a category to use to populate the post loop. Only posts within this category will be shown.', IT_TEXTDOMAIN ),
			'id' => 'loop_limit_cat',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Limit To Tag', IT_TEXTDOMAIN ),
			'desc' => __( 'Choose a tag to use to populate the post loop. Only posts within this tag will be shown.', IT_TEXTDOMAIN ),
			'id' => 'loop_limit_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		array(
			'name' => __( 'Exclude Category', IT_TEXTDOMAIN ),
			'desc' => __( 'Exclude this category from the post loop. Posts within this category will not be shown.', IT_TEXTDOMAIN ),
			'id' => 'loop_exclude_cat',
			'target' => 'cat',
			'type' => 'select'
		),
		array(
			'name' => __( 'Exclude Tag', IT_TEXTDOMAIN ),
			'desc' => __( 'Exclude this tag from the post loop. Posts within this tag will not be shown.', IT_TEXTDOMAIN ),
			'id' => 'loop_exclude_tag',
			'target' => 'tag',
			'type' => 'select'
		),
		array(
			'name' => __( 'Exclude Minisite(s)', IT_TEXTDOMAIN ),
			'desc' => __( 'Exclude selected minisites from the post loop. Posts within these minisites will not be shown.', IT_TEXTDOMAIN ),
			'id' => 'loop_exclude_minisites',
			'target' => 'minisites',
			'type' => 'checkbox'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Single Articles
	 */
	array(
		'name' => array( 'it_posts_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can build out the layout of single article pages just like you can with other areas of the site.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		
		array(
			'name' => ' ',
			'id' => 'single_1',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_2',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_3',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_4',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_5',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_6',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_7',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_8',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_9',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_10',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => ' ',
			'id' => 'single_11',
			'target' => 'builder',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Sticky Logo', IT_TEXTDOMAIN ),
			'id' => 'post_sticky_logo_disable',
			'options' => array( 'true' => __( 'Do not display the logo in the sticky bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Logo Bar', IT_TEXTDOMAIN ),
			'id' => 'post_logobar_disable',
			'options' => array( 'true' => __( 'Disable the logo bar for all single articles', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Disable Logo Only', IT_TEXTDOMAIN ),
			'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the logo bar without displaying the logo again', IT_TEXTDOMAIN ),
			'id' => 'post_logo_disable',
			'options' => array( 'true' => __( 'Hide the logo only from the logo bar.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Sidebar Position', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'post_layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
			'desc' => __( 'The default featured image size for all standard posts only', IT_TEXTDOMAIN ),
			'id' => 'post_featured_image_size',
			'options' => array(
				'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
				'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
				'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
				'790' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
			),
			'default' => '360',
			'type' => 'layout'
		),
		
		array(
			'name' => __( 'Components', IT_TEXTDOMAIN ),
			'desc' => __( 'Show/hide various components on the single article pages.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Disable Post Navigation', IT_TEXTDOMAIN ),
			'id' => 'post_postnav_disable',
			'options' => array( 'true' => __( 'Hide the post navigation at the top of each single article', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Post Nav Random', IT_TEXTDOMAIN ),
			'id' => 'post_postnav_random_disable',
			'options' => array( 'true' => __( 'Hide the random button within the post navigation.', IT_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Date/Author', IT_TEXTDOMAIN ),
			'id' => 'post_authorship_disable',
			'options' => array( 'true' => __( 'Disable the post date and author for all standard posts only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable View Count', IT_TEXTDOMAIN ),
			'id' => 'post_sortbar_views_disable',
			'options' => array( 'true' => __( 'Disable the view count for all standard posts only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
			'id' => 'post_sortbar_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button at the top of the post', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Comment Count', IT_TEXTDOMAIN ),
			'id' => 'post_sortbar_comments_disable',
			'options' => array( 'true' => __( 'Disable the comment count for all standard posts only', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Lightbox Effect', IT_TEXTDOMAIN ),
			'id' => 'colorbox_disable',
			'options' => array( 'true' => __( 'Disable the lightbox when clicking on featured image/galleries', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Lightbox Slideshow', IT_TEXTDOMAIN ),
			'id' => 'colorbox_slideshow',
			'options' => array( 'true' => __( 'Gallery lightboxes should behave as a slideshow', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Post Info Box', IT_TEXTDOMAIN ),
			'id' => 'post_postinfo_disable',
			'options' => array( 'true' => __( 'Disable the post info area (tags, categories, author info...)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Bottom Like Button', IT_TEXTDOMAIN ),
			'id' => 'post_likes_disable',
			'options' => array( 'true' => __( 'Disable the like button in the post info box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Categories', IT_TEXTDOMAIN ),
			'id' => 'post_categories_disable',
			'options' => array( 'true' => __( 'Disable the category list in the post info box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Tags', IT_TEXTDOMAIN ),
			'id' => 'post_tags_disable',
			'options' => array( 'true' => __( 'Disable the tag list in the post info box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Author Info', IT_TEXTDOMAIN ),
			'id' => 'post_author_disable',
			'options' => array( 'true' => __( 'Disable the author information in the post info box', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Recommended', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_disable',
			'options' => array( 'true' => __( 'Disable the recommended posts section', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Recommended Method', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_method',
			'desc' => __( 'For the "Same tags OR same categories" method, use the "Number of Recommended Filters" option below to set how many of EACH will display, rather than how many TOTAL as is applied to the rest of the methods. So setting this to "2" will cause the first two tags and the first two categories to display, resulting in four total filters.', IT_TEXTDOMAIN ),
			'options' => array( 
				'tags' => __( 'Same tags', IT_TEXTDOMAIN ),
				'categories' => __( 'Same categories', IT_TEXTDOMAIN ),
				'tags_categories' => __( 'Same tags OR same categories (tags will appear first in order)', IT_TEXTDOMAIN ),
			),
			'default' => 'tags',
			'type' => 'radio'
		),	
		array(
			'name' => __( 'Recommended Label', IT_TEXTDOMAIN ),
			'desc' => __( 'The title text to display in the title of the recommended section', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_label',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Number of Recommended Filters', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of filter buttons to display in the recommended filter bar.', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_filters_num',
			'target' => 'recommended_filters_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Recommended Filters', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_filters_disable',
			'options' => array( 'true' => __( 'Disable the filter buttons from the recommended section', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Number of Recommended Posts', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of total posts to display in the recommended section.', IT_TEXTDOMAIN ),
			'id' => 'post_recommended_num',
			'target' => 'recommended_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
			'id' => 'post_comments_disable',
			'options' => array( 'true' => __( 'Disable the comments (useful for Facebook comment plugins)', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
	
	array(
		'type' => 'tab_end'
	),

	/**
	 * Minisites
	 */
	array(
		'name' => array( 'it_minisite_tab' => $option_tabs ),
		'type' => 'tab_start'
	),

		array(
			'name' => __( 'Create your minisites here. When you add, edit, or delete minisites, click Confirm Minisites in order to see the changes reflected in the control panel main menu on the left. IMPORTANT: for detailed information about names and slugs of minisites please view the theme documentation.', IT_TEXTDOMAIN ),
			'id' => 'minisite',
			'type' => 'minisite'
		),
		
		array(
			'name' => __( 'Legacy', IT_TEXTDOMAIN ),
			'desc' => __( 'This will cause your review types and taxonomies that you created using Made or Swagger to remain prefixed in such a way that Steam recognizes them. You must click Confirm Minisites if you change this setting in order for it to be applied.', IT_TEXTDOMAIN ),
			'id' => 'legacy',
			'options' => array( 'true' => __( 'Turn on if you are upgrading from either Made or SwagMag', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Standard Permalink Method', IT_TEXTDOMAIN ),
			'desc' => __( 'Selecting this will cause the permalinks of your minisite articles to work the same as normal WordPress posts, meaning the name of the minisite will not be included in the URL before the name of the post (only applies to non-default permalinks structure). You should refresh your permalinks after changing this option (go to Settings >> Permalinks and click Save)', IT_TEXTDOMAIN ),
			'id' => 'no_minisite_urls',
			'options' => array( 'true' => __( 'Do not include the name of the minisite in the URL', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),

	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sidebar
	 */
	array(
		'name' => array( 'it_sidebar_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Sidebar', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create additional sidebars to use. To display your new sidebar then you will need to select it in the &quot;Custom Sidebar&quot; dropdown when editing a post or page.', IT_TEXTDOMAIN ),
			'id' => 'custom_sidebars',
			'type' => 'sidebar'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Signoff
	 */
	array(
		'name' => array( 'it_signoff_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Signoff', IT_TEXTDOMAIN ),
			'desc' => __( 'You can create an unlimited number of signoff text areas and then choose the one you want to use for each post.', IT_TEXTDOMAIN ),
			'id' => 'signoff',
			'type' => 'signoff'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advertising
	 */
	array(
		'name' => array( 'it_advertising_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Header Ad', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays to the right of the logo in the main site header.', IT_TEXTDOMAIN ),
			'id' => 'ad_header',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Footer Ad', IT_TEXTDOMAIN ),
			'desc' => __( 'Displays above the dark footer container but below the main content wrapper.', IT_TEXTDOMAIN ),
			'id' => 'ad_footer',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Background Ad URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL to direct the user to when they click anywhere on the background. Leave this blank to disable it. For the image to use for the ad, use the page background image URL options.', IT_TEXTDOMAIN ),
			'id' => 'ad_background',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Post Loops', IT_TEXTDOMAIN ),
			'desc' => __( 'These ads will get injected into your post loops (article listing pages)', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'AJAX Ads', IT_TEXTDOMAIN ),
			'desc' => __( 'You should turn this off if you are using an ad vendor that does not allow ads to display on dynamically-generated pages such as Google Adsense.', IT_TEXTDOMAIN ),
			'id' => 'ad_ajax',
			'options' => array( 'true' => __( 'Display ads on AJAX (dynamically-loaded) pages.', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Shuffle', IT_TEXTDOMAIN ),
			'id' => 'ad_shuffle',
			'options' => array( 'true' => __( 'Shuffle the display of the ads', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),	
		array(
			'name' => __( 'Number of Ads', IT_TEXTDOMAIN ),
			'desc' => __( 'The total number of ads to display in the loop regardless of how many ad slots are filled out below', IT_TEXTDOMAIN ),
			'id' => 'ad_num',
			'target' => 'ad_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Increment', IT_TEXTDOMAIN ),
			'desc' => __( 'Display an ad every Nth post. For instance, if "3" is selected, every 3rd post will be an ad.', IT_TEXTDOMAIN ),
			'id' => 'ad_increment',
			'target' => 'ad_number',
			'nodisable' => true,
			'type' => 'select'
		),
		array(
			'name' => __( 'Off-set', IT_TEXTDOMAIN ),
			'desc' => __( 'Number of posts to display before the first ad appears', IT_TEXTDOMAIN ),
			'id' => 'ad_offset',
			'target' => 'ad_number',
			'type' => 'select'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'desc' => __( 'Enter the HTML for the ad here', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_1',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_2',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_3',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_4',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_5',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_6',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_7',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_8',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_9',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Ad Slot', IT_TEXTDOMAIN ),
			'id' => 'loop_ad_10',
			'htmlentities' => true,
			'type' => 'textarea'
		),
		
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Footer
	 */
	array(
		'name' => array( 'it_footer_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can select any type of layout you want for the footer columns.', IT_TEXTDOMAIN ),
			'id' => 'footer_layout',
			'options' => array(
				'a' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',
				'b' => THEME_ADMIN_ASSETS_URI . '/images/footer_b.png',
				'c' => THEME_ADMIN_ASSETS_URI . '/images/footer_c.png',
				'd' => THEME_ADMIN_ASSETS_URI . '/images/footer_d.png',
				'e' => THEME_ADMIN_ASSETS_URI . '/images/footer_e.png',
				'f' => THEME_ADMIN_ASSETS_URI . '/images/footer_f.png',
				'g' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'h' => THEME_ADMIN_ASSETS_URI . '/images/footer_h.png',
				'i' => THEME_ADMIN_ASSETS_URI . '/images/footer_i.png',
				'j' => THEME_ADMIN_ASSETS_URI . '/images/footer_j.png',
				'k' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'l' => THEME_ADMIN_ASSETS_URI . '/images/footer_l.png',
				'm' => THEME_ADMIN_ASSETS_URI . '/images/footer_m.png',
				'n' => THEME_ADMIN_ASSETS_URI . '/images/footer_n.png',
				'o' => THEME_ADMIN_ASSETS_URI . '/images/footer_o.png',
				'p' => THEME_ADMIN_ASSETS_URI . '/images/footer_p.png',
				'q' => THEME_ADMIN_ASSETS_URI . '/images/footer_q.png',
				'r' => THEME_ADMIN_ASSETS_URI . '/images/footer_r.png',
				's' => THEME_ADMIN_ASSETS_URI . '/images/footer_s.png',
				't' => THEME_ADMIN_ASSETS_URI . '/images/footer_t.png',
				'u' => THEME_ADMIN_ASSETS_URI . '/images/footer_u.png',
				'v' => THEME_ADMIN_ASSETS_URI . '/images/footer_v.png',
				'w' => THEME_ADMIN_ASSETS_URI . '/images/footer_w.png',
				'x' => THEME_ADMIN_ASSETS_URI . '/images/footer_x.png',
				'y' => THEME_ADMIN_ASSETS_URI . '/images/footer_y.png',
				'z' => THEME_ADMIN_ASSETS_URI . '/images/footer_z.png',
				'aa' => THEME_ADMIN_ASSETS_URI . '/images/footer_aa.png',
				'ab' => THEME_ADMIN_ASSETS_URI . '/images/footer_ab.png',
				'ac' => THEME_ADMIN_ASSETS_URI . '/images/footer_ac.png',
				'ad' => THEME_ADMIN_ASSETS_URI . '/images/footer_ad.png',
			),
			'default' => 'd',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Footer', IT_TEXTDOMAIN ),
			'id' => 'footer_disable',
			'options' => array( 'true' => __( 'Completely disable the entire footer area', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Copyright Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This will overwrite the default automatic copyright text in the left of the subfooter.', IT_TEXTDOMAIN ),
			'id' => 'copyright_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Credits Text', IT_TEXTDOMAIN ),
			'desc' => __( 'This will overwrite the default automatic credits text in the right of the subfooter.', IT_TEXTDOMAIN ),
			'id' => 'credits_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Subfooter', IT_TEXTDOMAIN ),
			'id' => 'subfooter_disable',
			'options' => array( 'true' => __( 'Disable the subfooter area which holds the copyright info', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sociable
	 */
	array(
		'name' => array( 'it_sociable_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Feedburner Feed ID', IT_TEXTDOMAIN ),
			'desc' => __( 'Necessary for the newsletter signup form to function properly. This article explains how to find your feedburner feed name: http://netprofitstoday.com/blog/how-to-find-your-feedburner-id/', IT_TEXTDOMAIN ),
			'id' => 'feedburner_name',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'RSS Feed URL', IT_TEXTDOMAIN ),
			'desc' => __( 'Necessary to connect an RSS button to your actual RSS feed URL.', IT_TEXTDOMAIN ),
			'id' => 'rss_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Twitter Username', IT_TEXTDOMAIN ),
			'desc' => __( 'Not a full URL, just your Twitter username.', IT_TEXTDOMAIN ),
			'id' => 'twitter_username',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Pinterest User URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL for your user profile on Pinterest', IT_TEXTDOMAIN ),
			'id' => 'pinterest_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Google+ Profile URL', IT_TEXTDOMAIN ),
			'desc' => __( "Your actual Google+ profile URL. This is the link users are taken to when they click on the Google+ social count.", IT_TEXTDOMAIN ),
			'id' => 'googleplus_profile_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Youtube User ID', IT_TEXTDOMAIN ),
			'desc' => __( 'To find your ID, sign in to YouTube and check your Advanced Account Settings page. You will see your ID listed in the Account Information section.', IT_TEXTDOMAIN ),
			'id' => 'youtube_username',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
		
		array(
			'name' => __( 'Facebook Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Facebook tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		
		array(
			'name' => __( 'Facebook Page URL', IT_TEXTDOMAIN ),
			'desc' => __( 'The URL of your Facebook page', IT_TEXTDOMAIN ),
			'id' => 'facebook_url',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Color Scheme', IT_TEXTDOMAIN ),
			'desc' => __( 'Light is better for light backgrounds, dark is better for dark backgrounds', IT_TEXTDOMAIN ),
			'id' => 'facebook_color_scheme',
			'options' => array( 
				'light' => __( 'Light', IT_TEXTDOMAIN ),
				'dark' => __( 'Dark', IT_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		
		array(
			'name' => __( 'Show Faces', IT_TEXTDOMAIN ),
			'id' => 'facebook_show_faces',
			'options' => array( 'true' => __( 'Show profile photos at the bottom', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Show Stream', IT_TEXTDOMAIN ),
			'id' => 'facebook_stream',
			'options' => array( 'true' => __( 'Show the profile stream for the public profile', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Show Header', IT_TEXTDOMAIN ),
			'id' => 'facebook_show_header',
			'options' => array( 'true' => __( 'Show the "Find us on Facebook" bar at the top', IT_TEXTDOMAIN ) ),
			'desc' => __( 'Note: this only displays if either the stream or faces are displayed.', IT_TEXTDOMAIN ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Border Color', IT_TEXTDOMAIN ),
			'desc' => __( 'The color of the borders around the Like Box', IT_TEXTDOMAIN ),
			'id' => 'facebook_border_color',
			'type' => 'color'
		),			
		
		array(
			'name' => __( 'Twitter Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Twitter tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),
		array(
			'name' => __( 'Twitter Widget Code', IT_TEXTDOMAIN ),
			'desc' => __( 'Go to https://twitter.com/settings/widgets and create a new widget. Then put the generated widget code into this box.', IT_TEXTDOMAIN ),
			'id' => 'twitter_widget_code',
			'default' => '',
			'type' => 'textarea'
		),
		
		array(
			'name' => __( 'Flickr Widget Settings', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to the Flickr tab in the Social Tabs widget.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		
		array(
			'name' => __( 'Flickr Account ID', IT_TEXTDOMAIN ),
			'desc' => __( 'Your Flickr Account ID. Use this service to find it: http://idgettr.com/', IT_TEXTDOMAIN ),
			'id' => 'flickr_id',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
		
		array(
			'name' => __( 'Number of Photos', IT_TEXTDOMAIN ),
			'desc' => __( 'The number of photos to display in the widget.', IT_TEXTDOMAIN ),
			'id' => 'flickr_number',
			'target' => 'flickr_number',
			'type' => 'select'
		),
		
		array(
			'name' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'These social badges appear in the "Connect" content panel (available via the page builders).', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
	
		array(
			'name' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'desc' => __( 'Social Badges', IT_TEXTDOMAIN ),
			'id' => 'sociable',
			'type' => 'sociable'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advanced
	 */
	array(
		'name' => array( 'it_advanced_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Custom Admin Logo', IT_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to replace the default Steam logo.', IT_TEXTDOMAIN ),
			'id' => 'admin_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Disable Image Sizes', IT_TEXTDOMAIN ),
			'desc' => __( 'If you are not using an image size anywhere in your theme and you want to block WordPress from creating an additional image for that size, you can selectively turn off creation of these images here.', IT_TEXTDOMAIN ),
			'id' => 'image_size_disable',
			'options' => array(
				'tiny' => __('Tiny - mega menus, small format post loops, recommended, etc.',IT_TEXTDOMAIN),
				'widget-post' => __('Small - used primarily in widget post loops',IT_TEXTDOMAIN),
				'grid-post' => __('Post Loops (careful, you are likely using this size)',IT_TEXTDOMAIN),
				'box-short' => __('Short Boxes - used in the Boxes component',IT_TEXTDOMAIN),
				'box-tall' => __('Tall Boxes - used in the Boxes component',IT_TEXTDOMAIN),
				'steam' => __('Steam Scroller',IT_TEXTDOMAIN),
				'featured-small' => __('Small Featured Slider',IT_TEXTDOMAIN),
				'featured-medium' => __('Medium Featured Slider',IT_TEXTDOMAIN),
				'featured-large' => __('Large Featured Slider',IT_TEXTDOMAIN),
				'sidecar' => __('Featured Slider Sidecar',IT_TEXTDOMAIN),
				'single-180' => __('Small Single Post/Page Featured Image',IT_TEXTDOMAIN),
				'single-360' => __('Medium Single Post/Page Featured Image',IT_TEXTDOMAIN),
				'single-790' => __('Large Single Post/Page Featured Image',IT_TEXTDOMAIN),
				'single-1130' => __('Full-Width Single Post/Page Featured Image',IT_TEXTDOMAIN)
			),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Import Options', IT_TEXTDOMAIN ),
			'desc' => __( 'Copy your export code here to import your theme settings.', IT_TEXTDOMAIN ),
			'id' => 'import_options',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Export Options', IT_TEXTDOMAIN ),
			'desc' => __( 'When moving your site to a new Wordpress installation you can export your theme settings here.', IT_TEXTDOMAIN ),
			'id' => 'export_options',
			'type' => 'export_options'
		),
		
		array(
			'name' => __( 'Demo Panel', IT_TEXTDOMAIN ),
			'desc' => __( 'This is for theme preview purposes only and allows users to manipulate select parts of the style from the front-end.', IT_TEXTDOMAIN ),
			'id' => 'show_demo_panel',
			'options' => array( 'true' => __( 'Show the demo settings toggle panel', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		/*array(
			'name' => __( 'Custom Homepage Content', IT_TEXTDOMAIN ),
			'desc' => __( 'You can add some custom content to your homepage. This will display above the post loop on the homepage.', IT_TEXTDOMAIN ),
			'id' => 'homepage_content',
			'type' => 'editor'
		),*/
		
		array(
			'name' => __( 'Turn Off Unique Views', IT_TEXTDOMAIN ),
			'desc' => __( 'This turns off the ip address check so that every time a page is accessed the view count increments by one.', IT_TEXTDOMAIN ),
			'id' => 'unique_views_disable',
			'options' => array( 'true' => __( 'Post views will increment on every page view', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Allow Unlimited User Ratings', IT_TEXTDOMAIN ),
			'desc' => __( 'This is only for development/testing purposes and will continually add user ratings and re-average the total score each time a user rates a criteria.', IT_TEXTDOMAIN ),
			'id' => 'rating_limit_disable',
			'options' => array( 'true' => __( 'TESTING PURPOSES ONLY', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'name' => __( 'Integrated Custom Post Types', IT_TEXTDOMAIN ),
			'desc' => __( 'Add a list of comma-separated custom post types here in order to retain the pre_get_posts minisite injection when viewing the custom post type. For instance if you are using WooCommerce and you are viewing your shop and product archive pages and you want the sliders and widgets to include your minisites, you would need to add the WooCommerce custom post type to this list (WooCommerce uses "product" as the custom post type for reference - no quotes)', IT_TEXTDOMAIN ),
			'id' => 'allowed_post_types',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),	
			
	array(
		'type' => 'tab_end'
	),
	
);

# add woocommerce options
if(function_exists('is_woocommerce')) {
	$woocommerce_options = array(			
		array(
			'name' => array( 'it_woocommerce_tab' => $option_tabs ),
			'type' => 'tab_start'
		),
		array(
			'name' => __( '', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to all WooCommerce related pages. These settings can be overwritten on a per-page basis in the page layout options if needed.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),	
		array(
			'name' => __( 'Disable Breadcrumbs', IT_TEXTDOMAIN ),
			'id' => 'woo_breadcrumb_disable',
			'options' => array( 'true' => __( 'Disable the breadcrumb navigation from all woocommerce pages', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'woo_layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Use "WooCommerce" Sidebar', IT_TEXTDOMAIN ),
			'id' => 'woo_sidebar_unique',
			'options' => array( 'true' => __( 'Use the "WooCommerce" instead of the "Page" sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'type' => 'tab_end'
		)
		
	);
	
	$options = array_merge($options,$woocommerce_options);
}

# add buddypress options
if(function_exists('bp_current_component')) {
	$buddypress_options = array(			
		array(
			'name' => array( 'it_buddypress_tab' => $option_tabs ),
			'type' => 'tab_start'
		),
		array(
			'name' => __( '', IT_TEXTDOMAIN ),
			'desc' => __( 'These settings apply to all BuddyPress related pages. These settings can be overwritten on a per-page basis in the page layout options if needed.', IT_TEXTDOMAIN ),
			'type' => 'heading'
		),			
		array(
			'name' => __( 'Layout', IT_TEXTDOMAIN ),
			'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
			'id' => 'bp_layout',
			'options' => array(
				'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
				'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
				'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
			),
			'default' => 'sidebar-right',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Use "BuddyPress" Sidebar', IT_TEXTDOMAIN ),
			'id' => 'bp_sidebar_unique',
			'options' => array( 'true' => __( 'Use the "BuddyPress" instead of the "Page" sidebar', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Force WordPress Registration', IT_TEXTDOMAIN ),
			'id' => 'bp_register_disable',
			'desc' => __( 'Turn this on if you want to be able to use the registration form in the sticky bar. Otherwise after registering it will take the user to the BuddyPress specific registration page and require them to register again.', IT_TEXTDOMAIN ),
			'options' => array( 'true' => __( 'Fall back to WordPress registration instead of BuddyPress', IT_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		
		array(
			'type' => 'tab_end'
		)
		
	);
	
	$options = array_merge($options,$buddypress_options);
}

# add minisite options to each minisite tab
if ( isset($minisite['keys']) && $minisite['keys'] != '#' ) {
	$minisite_keys = explode(',',$minisite['keys']);
	foreach ($minisite_keys as $mkey) {
		if ( $mkey != '#') {
			$minisite_name = ( !empty( $minisite[$mkey]['name'] ) ) ? $minisite[$mkey]['name'] : '#';
			$minisite_slug = it_get_slug($minisite[$mkey]['slug'], $minisite_name);				
			
			$minisite_options = array(
			
				array(
					'name' => array( 'it_'.$minisite_slug.'_minisite_tab' => $option_tabs ),
					'type' => 'tab_start'
				),
				
				array(
					'name' => __( 'Taxonomies', IT_TEXTDOMAIN ),
					'desc' => __( 'A taxonomy is a way of classifying your minisite articles. WordPress comes with two taxonomies created for you by default: Tags and Categories. But neither of those are specific to an individual minisite because they can be assigned to any type of WordPress post. Think of a taxonomy as a minisite-specific type of grouping mechanism, and you can create as many of them as you want. A lot of times you will only need one taxonomy (for instance "Type" if your minisite is "Products"), but other times you may need more (for instance "Genre", "Developer", and "Platform" if your minisite is "Video Games"). This is not where you actually create and assign your various taxonomy items - do that when you are writing your individual articles. If you are not clear on how to use a taxonomy, take a quick look at the Codex article: http://codex.wordpress.org/Taxonomies.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				
				array(
					'name' => '',
					'id' => 'taxonomies_'.$minisite_slug,
					'type' => 'taxonomies',
					'minisite' => $minisite_slug
				),	
				
				array(
					'name' => __( 'Details', IT_TEXTDOMAIN ),
					'desc' => __( 'Details are additional descriptive data about the article that you want to list in the overview area. They are different than Taxonomies because they are not so much classification data as they are describing data. For instance, if you were writing an article on a movie, a taxonomy might be Director and a detail might be Plot Synopsis, because a director can be assigned to multiple movies but a plot synopsis is descriptive only for a single movie. You can of course dchoose how to use Taxonomies and Details however you want for your articles, these are just suggestions to help you understand the difference between them. It is completely up to you.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
					
				array(
					'name' => '',
					'id' => 'details_'.$minisite_slug,
					'type' => 'details',
					'minisite' => $minisite_slug
				),	
				
				array(
					'name' => __( 'Ratings', IT_TEXTDOMAIN ),
					'desc' => __( 'These settings dictate how you want to rate the articles within this minisite, if at all. Each minisite can have unique rating options, but articles within a minisite all must share the same rating options.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				
				array(
					'name' => __( 'Rating Metric', IT_TEXTDOMAIN ),
					'desc' => __( 'The type of rating metric to use for this minisite', IT_TEXTDOMAIN ),
					'id' => 'rating_metric_'.$minisite_slug,
					'options' => array( 
						'stars' => __( 'Stars', IT_TEXTDOMAIN ),
						'number' => __( 'Numbers', IT_TEXTDOMAIN ),
						'percentage' => __( 'Percentages', IT_TEXTDOMAIN ),
						'letter' => __( 'Letter Grades', IT_TEXTDOMAIN )
					),
					'default' => 'stars',
					'type' => 'radio'
				),
				
				array(
					'name' => __( 'Rating Criteria (automatically averaged into the total score)', IT_TEXTDOMAIN ),
					'id' => 'criteria_'.$minisite_slug,
					'type' => 'criteria',
					'minisite' => $minisite_slug
				),	
				
				array(
					'name' => __( 'Disable Editor Ratings', IT_TEXTDOMAIN ),
					'desc' => __( 'This will disable the editor ratings from appearing anywhere in this minisite.', IT_TEXTDOMAIN ),
					'id' => 'editor_rating_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Do not use editor ratings at all', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				
				array(
					'name' => __( 'Disable User Ratings', IT_TEXTDOMAIN ),
					'desc' => __( 'This will disable the user rating from appearing anywhere in this minisite.', IT_TEXTDOMAIN ),
					'id' => 'user_rating_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Do not use user ratings at all', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				
				array(
					'name' => __( 'Hide Editor Ratings', IT_TEXTDOMAIN ),
					'desc' => __( 'This should be used if you DO want to use editor ratings but ONLY want them to be visible on the full review page.', IT_TEXTDOMAIN ),
					'id' => 'editor_rating_hide_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hides editor rating from image overlays', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				
				array(
					'name' => __( 'Hide User Ratings', IT_TEXTDOMAIN ),
					'desc' => __( 'This should be used if you DO want to use user ratings but ONLY want them to be visible on the full review page.', IT_TEXTDOMAIN ),
					'id' => 'user_rating_hide_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hides user rating from image overlays', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				
				array(
					'name' => __( 'Disable Color Ranges', IT_TEXTDOMAIN ),
					'desc' => __( 'This will disable the various background colors used for each color range.', IT_TEXTDOMAIN ),
					'id' => 'color_ranges_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Do not use background color ranges', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				
				array(
					'name' => __( 'Awards & Badges', IT_TEXTDOMAIN ),
					'desc' => __( 'Each minisite has its own unique award system. Create the award here and then it will be selectable to assign to your articles on the article edit screen.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				
				array(
					'name' => '',
					'id' => 'awards_'.$minisite_slug,
					'type' => 'awards',
					'minisite' => $minisite_slug
				),
				
				array(
					'name' => __( 'Style', IT_TEXTDOMAIN ),
					'desc' => __( 'The look and feel of this minisite.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				array(
					'name' => __( 'Disable Logo Bar', IT_TEXTDOMAIN ),
					'desc' => __( 'Disable the area that shows the header ad and larger logo area', IT_TEXTDOMAIN ),
					'id' => 'logobar_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the logo bar underneath the sticky bar.', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Logo Only', IT_TEXTDOMAIN ),
					'desc' => __( 'This is useful if you want to display the logo in the sticky bar and also display the logo bar without displaying the logo again', IT_TEXTDOMAIN ),
					'id' => 'logo_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the logo only from the logo bar.', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Header Ad', IT_TEXTDOMAIN ),
					'id' => 'ad_header_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the ad from the logo bar.', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Minisite Logo', IT_TEXTDOMAIN ),
					'desc' => __( 'Upload an image to use as your logo.', IT_TEXTDOMAIN ),
					'id' => 'logo_url_'.$minisite_slug,
					'type' => 'upload'
				),	
				array(
					'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
					'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
					'id' => 'logo_width_'.$minisite_slug,
					'default' => '',
					'htmlspecialchars' => true,
					'type' => 'text'
				),		
				array(
					'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
					'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
					'id' => 'logo_height_'.$minisite_slug,
					'default' => '',
					'htmlspecialchars' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'HD Minisite Logo', IT_TEXTDOMAIN ),
					'desc' => __( 'Upload an image to use as your logo for use on HD (hiDPI/retina) displays.', IT_TEXTDOMAIN ),
					'id' => 'logo_url_hd_'.$minisite_slug,
					'type' => 'upload'
				),		
				array(
					'name' => __( 'Sticky Logo', IT_TEXTDOMAIN ),
					'desc' => __( 'Upload an image to use as the logo in your sticky bar. If you leave this blank it will use the main minisite logo.', IT_TEXTDOMAIN ),
					'id' => 'sticky_logo_url_'.$minisite_slug,
					'type' => 'upload'
				),				
				array(
					'name' => __( 'Logo Width (optional)', IT_TEXTDOMAIN ),
					'desc' => __( 'This adds a width attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
					'id' => 'sticky_logo_width_'.$minisite_slug,
					'default' => '',
					'htmlspecialchars' => true,
					'type' => 'text'
				),		
				array(
					'name' => __( 'Logo Height (optional)', IT_TEXTDOMAIN ),
					'desc' => __( 'This adds a height attribute to your logo image tag for page performance purposes. Do not include the "px" part, just the number itself.', IT_TEXTDOMAIN ),
					'id' => 'sticky_logo_height_'.$minisite_slug,
					'default' => '',
					'htmlspecialchars' => true,
					'type' => 'text'
				),	
				array(
					'name' => __( 'HD Sticky Logo', IT_TEXTDOMAIN ),
					'desc' => __( 'Upload an image to use as the logo in your sticky bar for retina displays. If you leave this blank it will use the main HD minisite logo.', IT_TEXTDOMAIN ),
					'id' => 'sticky_logo_url_hd_'.$minisite_slug,
					'type' => 'upload'
				),	
				array(
					'name' => __( 'Icon (16px)', IT_TEXTDOMAIN ),
					'desc' => __( 'Choose a 16px by 16px square image to use as the main icon for this minisite.', IT_TEXTDOMAIN ),
					'id' => 'icon_'.$minisite_slug,
					'type' => 'upload'
				),				
				array(
					'name' => __( 'HD Icon (32px)', IT_TEXTDOMAIN ),
					'desc' => __( 'Choose a 32px by 32px square image to use as the main icon for this minisite on HD (hiDPI/retina) displays.', IT_TEXTDOMAIN ),
					'id' => 'iconhd_'.$minisite_slug,
					'type' => 'upload'
				),				
				array(
					'name' => __( 'Optional White Icon (16px)', IT_TEXTDOMAIN ),
					'desc' => __( 'Optional white version of the 16px icon for use in places with a dark background such as the featured slider. If you leave this blank the icon above will be used.', IT_TEXTDOMAIN ),
					'id' => 'iconwhite_'.$minisite_slug,
					'type' => 'upload'
				),				
				array(
					'name' => __( 'Optional White HD Icon (32px)', IT_TEXTDOMAIN ),
					'desc' => __( 'Optional white version of the 32px icon for use in places with a dark background such as the featured slider. If you leave this blank the icon above will be used.', IT_TEXTDOMAIN ),
					'id' => 'iconhdwhite_'.$minisite_slug,
					'type' => 'upload'
				),		
				array(
					'name' => __( 'Background Color', IT_TEXTDOMAIN ),
					'desc' => __( 'Use a specific background color for this minisite', IT_TEXTDOMAIN ),
					'id' => 'bg_color_'.$minisite_slug,
					'type' => 'color'
				),
				array(
					'name' => __( 'Override Site Background', IT_TEXTDOMAIN ),
					'desc' => __( 'This is useful if you have an image as your main site background but you want this color to show instead for this minisite', IT_TEXTDOMAIN ),
					'id' => 'bg_color_override_'.$minisite_slug,
					'options' => array( 'true' => __( 'Display this color instead of your main site background image', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox'
				),		
				array(
					'name' => __( 'Background Image', IT_TEXTDOMAIN ),
					'desc' => __( 'Use an image for the background of this minisite', IT_TEXTDOMAIN ),
					'id' => 'bg_image_'.$minisite_slug,
					'type' => 'upload'
				),	
				array(
					'name' => __( 'Background Position', IT_TEXTDOMAIN ),
					'id' => 'bg_position_'.$minisite_slug,
					'options' => array( 
						'left' => __( 'Left', IT_TEXTDOMAIN ),
						'center' => __( 'Center', IT_TEXTDOMAIN ),
						'right' => __( 'Right', IT_TEXTDOMAIN )
					),
					'default' => 'center',
					'type' => 'radio'
				),		
				array(
					'name' => __( 'Background Repeat', IT_TEXTDOMAIN ),
					'id' => 'bg_repeat_'.$minisite_slug,
					'options' => array( 
						'no-repeat' => __( 'No Repeat', IT_TEXTDOMAIN ),
						'repeat' => __( 'Tile', IT_TEXTDOMAIN ),
						'repeat-x' => __( 'Tile Horizontally', IT_TEXTDOMAIN ),
						'repeat-y' => __( 'Tile Vertically', IT_TEXTDOMAIN )
					),
					'default' => 'no-repeat',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Background Attachment', IT_TEXTDOMAIN ),
					'id' => 'bg_attachment_'.$minisite_slug,
					'options' => array( 
						'scroll' => __( 'Scroll', IT_TEXTDOMAIN ),
						'fixed' => __( 'Fixed', IT_TEXTDOMAIN )
					),
					'default' => 'scroll',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Accents', IT_TEXTDOMAIN ),
					'desc' => __( 'Used for links, titles, buttons, and other accent colors.', IT_TEXTDOMAIN ),
					'id' => 'color_accent_'.$minisite_slug,
					'type' => 'color'
				),	
				
				array(
					'name' => '',
					'desc' => __( 'Choose four colors for the diagonal gradients used in image box overlays. The theme will use a combination of these colors to create the gradients. More than four colors causes a busy look no matter how good the color scheme is. We recommend using a site like ColourLovers.com to find a good color scheme. Darker colors are better because they enhance the overlay text. Leave these blank to use the default colors.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				array(
					'name' => 'Bax Gradient 1',
					'id' => 'color_boxes_1_'.$minisite_slug,
					'type' => 'color'
				),	
				array(
					'name' => 'Bax Gradient 2',
					'id' => 'color_boxes_2_'.$minisite_slug,
					'type' => 'color'
				),	
				array(
					'name' => 'Bax Gradient 3',
					'id' => 'color_boxes_3_'.$minisite_slug,
					'type' => 'color'
				),	
				array(
					'name' => 'Bax Gradient 4',
					'id' => 'color_boxes_4_'.$minisite_slug,
					'type' => 'color'
				),	
				
				array(
					'name' => __( 'Front Page Layout', IT_TEXTDOMAIN ),
					'desc' => __( 'You can build out the front page of the minisite just like you can with the main site front page', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),	
				array(
					'name' => ' ',
					'id' => 'front_1_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_2_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_3_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_4_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_5_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_6_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_7_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_8_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_9_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),
				array(
					'name' => ' ',
					'id' => 'front_10_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),	
				array(
					'name' => ' ',
					'id' => 'front_11_'.$minisite_slug,
					'target' => 'builder',
					'type' => 'select'
				),	
						
				array(
					'name' => __( 'Targeted Content Panels', IT_TEXTDOMAIN ),
					'desc' => __( 'This will cause the specified component to display articles from within the current minisite only. This includes widgets, so if you set Top Ten to be targeted for instance, both the top ten slider and the top ten widget within this minisite will be targeted.', IT_TEXTDOMAIN ),
					'id' => 'targeted_sliders_'.$minisite_slug,
					'options' => array(
						'sizzlin' => 'Sizzlin',
						'new' => 'New Articles',
						'boxes' => 'Boxes',
						'featured' => 'Featured',
						'topten' => 'Top Ten',
						'trending' => 'Trending',
						'articles' => 'Latest Articles (3 columns)',
						'steam' => 'Steam Scroller',
						'exclusive' => 'Exclusive',
						'mixed' => 'Mixed Panels (widgets)'
					),
					'type' => 'checkbox'
				),		
				array(
					'name' => __( 'Featured Slider Layout', IT_TEXTDOMAIN ),
					'desc' => __( 'There are three available layouts, the full-width layout completely hides the side scroller.', IT_TEXTDOMAIN ),
					'id' => 'featured_layout_'.$minisite_slug,
					'options' => array(
						'small' => THEME_ADMIN_ASSETS_URI . '/images/featured_small.png',
						'medium' => THEME_ADMIN_ASSETS_URI . '/images/featured_medium.png',
						'large' => THEME_ADMIN_ASSETS_URI . '/images/featured_large.png',
					),
					'default' => 'small',
					'type' => 'layout'
				),	
				array(
					'name' => __( 'Boxes Layout', IT_TEXTDOMAIN ),
					'id' => 'boxes_layout_'.$minisite_slug,
					'options' => array(
						'a' => THEME_ADMIN_ASSETS_URI . '/images/boxes_a.png',
						'b' => THEME_ADMIN_ASSETS_URI . '/images/boxes_b.png',
						'c' => THEME_ADMIN_ASSETS_URI . '/images/boxes_c.png',
						'd' => THEME_ADMIN_ASSETS_URI . '/images/boxes_d.png',
						'e' => THEME_ADMIN_ASSETS_URI . '/images/boxes_e.png',
						'f' => THEME_ADMIN_ASSETS_URI . '/images/boxes_f.png',
						'g' => THEME_ADMIN_ASSETS_URI . '/images/boxes_g.png'
					),
					'default' => 'a',
					'type' => 'layout'
				),
				array(
					'name' => __( 'Post Loops', IT_TEXTDOMAIN ),
					'desc' => __( 'Settings that apply to the post loop on the front page and any taxonomy listing pages within this minisite.', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				array(
					'name' => __( 'Disable Title', IT_TEXTDOMAIN ),
					'id' => 'loop_title_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Disable the post loop title next to the filtering buttons', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Filtering', IT_TEXTDOMAIN ),
					'id' => 'filtering_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Disable the filter buttons in the control bar', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),				
				array(
					'name' => __( 'Layout', IT_TEXTDOMAIN ),
					'desc' => __( 'You can select between four main layouts: grid style with and without sidebar, and list style with and without sidebar.', IT_TEXTDOMAIN ),
					'id' => 'layout_'.$minisite_slug,
					'options' => array(
						'a' => THEME_ADMIN_ASSETS_URI . '/images/loop_a.png',
						'b' => THEME_ADMIN_ASSETS_URI . '/images/loop_b.png',
						'c' => THEME_ADMIN_ASSETS_URI . '/images/loop_c.png',
						'd' => THEME_ADMIN_ASSETS_URI . '/images/loop_d.png',
						'e' => THEME_ADMIN_ASSETS_URI . '/images/loop_e.png',
						'f' => THEME_ADMIN_ASSETS_URI . '/images/loop_f.png',
					),
					'default' => 'a',
					'type' => 'layout'
				),
				
				array(
					'name' => __( 'Single Article Pages', IT_TEXTDOMAIN ),
					'desc' => __( 'Settings that apply to the detail view of a single article', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				array(
					'name' => __( 'Default Post Type', IT_TEXTDOMAIN ),
					'id' => 'default_post_type_'.$minisite_slug,
					'desc' => __( 'You can display this panel either above or below the main article content.', IT_TEXTDOMAIN ),
					'options' => array( 
						'article' => __( 'Article', IT_TEXTDOMAIN ),
						'review' => __( 'Review', IT_TEXTDOMAIN )
					),
					'default' => 'review',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Sidebar Position', IT_TEXTDOMAIN ),
					'desc' => __( 'You can specify a layout with or without a sidebar.', IT_TEXTDOMAIN ),
					'id' => 'post_layout_'.$minisite_slug,
					'options' => array(
						'sidebar-right' => THEME_ADMIN_ASSETS_URI . '/images/footer_g.png',
						'sidebar-left' => THEME_ADMIN_ASSETS_URI . '/images/footer_k.png',
						'full' => THEME_ADMIN_ASSETS_URI . '/images/footer_a.png',				
					),
					'default' => 'sidebar-right',
					'type' => 'layout'
				),
				array(
					'name' => __( 'Featured Image Size', IT_TEXTDOMAIN ),
					'desc' => __( 'The default featured image size for minisite articles (can be overwritten per article)', IT_TEXTDOMAIN ),
					'id' => 'post_featured_image_size_'.$minisite_slug,
					'options' => array(
						'none' => THEME_ADMIN_ASSETS_URI . '/images/image_none.png',
						'180' => THEME_ADMIN_ASSETS_URI . '/images/image_small.png',
						'360' => THEME_ADMIN_ASSETS_URI . '/images/image_medium.png',
						'790' => THEME_ADMIN_ASSETS_URI . '/images/image_large.png',
					),
					'default' => '360',
					'type' => 'layout'
				),
				array(
					'name' => __( 'Disable Post Navigation', IT_TEXTDOMAIN ),
					'id' => 'postnav_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the post navigation at the top of each single article', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Minisite Label', IT_TEXTDOMAIN ),
					'id' => 'sortbar_label_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the name of the minisite and icon from the control bar', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Awards', IT_TEXTDOMAIN ),
					'id' => 'sortbar_awards_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the awards from the control bar', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Views', IT_TEXTDOMAIN ),
					'id' => 'sortbar_views_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the view count from the control bar', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
					'desc' => __( 'NOTE: This does not hide the like button from the post info box, just the button at the top', IT_TEXTDOMAIN ),
					'id' => 'sortbar_likes_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the like button from the top of the article', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Comments', IT_TEXTDOMAIN ),
					'desc' => __( 'NOTE: This does not hide the comment area below the article, just the count at the top', IT_TEXTDOMAIN ),
					'id' => 'sortbar_comments_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the comment count from the control bar', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Date/Author', IT_TEXTDOMAIN ),
					'id' => 'date_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the date and author from the control bar', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Details Position', IT_TEXTDOMAIN ),
					'id' => 'details_position_'.$minisite_slug,
					'desc' => __( 'You can display this panel either above or below the main article content.', IT_TEXTDOMAIN ),
					'options' => array( 
						'top' => __( 'Above the article content', IT_TEXTDOMAIN ),
						'bottom' => __( 'Below the article content', IT_TEXTDOMAIN )
					),
					'default' => 'top',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Positives/Negatives Position', IT_TEXTDOMAIN ),
					'id' => 'proscons_position_'.$minisite_slug,
					'desc' => __( 'You can display this panel either above or below the main article content.', IT_TEXTDOMAIN ),
					'options' => array( 
						'top' => __( 'Above the article content', IT_TEXTDOMAIN ),
						'bottom' => __( 'Below the article content', IT_TEXTDOMAIN )
					),
					'default' => 'top',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Ratings Position', IT_TEXTDOMAIN ),
					'id' => 'ratings_position_'.$minisite_slug,
					'desc' => __( 'You can display this panel either above or below the main article content.', IT_TEXTDOMAIN ),
					'options' => array( 
						'top' => __( 'Above the article content', IT_TEXTDOMAIN ),
						'bottom' => __( 'Below the article content', IT_TEXTDOMAIN )
					),
					'default' => 'top',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Bottom Line Position', IT_TEXTDOMAIN ),
					'id' => 'bottomline_position_'.$minisite_slug,
					'desc' => __( 'You can display this panel either above or below the main article content.', IT_TEXTDOMAIN ),
					'options' => array( 
						'top' => __( 'Above the article content', IT_TEXTDOMAIN ),
						'bottom' => __( 'Below the article content', IT_TEXTDOMAIN )
					),
					'default' => 'top',
					'type' => 'radio'
				),	
				
				array(
					'name' => __( 'Positives Label', IT_TEXTDOMAIN ),
					'desc' => __( 'Used as the title for the positives section', IT_TEXTDOMAIN ),
					'id' => 'positives_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'Negatives Label', IT_TEXTDOMAIN ),
					'desc' => __( 'Used as the title for the negatives section', IT_TEXTDOMAIN ),
					'id' => 'negatives_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'Bottom Line Label', IT_TEXTDOMAIN ),
					'desc' => __( 'Used as the title for the bottom line section', IT_TEXTDOMAIN ),
					'id' => 'bottomline_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'Total Score Label', IT_TEXTDOMAIN ),
					'desc' => __( 'Used as the label for the total editor score', IT_TEXTDOMAIN ),
					'id' => 'total_score_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'User Score Label', IT_TEXTDOMAIN ),
					'desc' => __( 'Used as the label for the total user score', IT_TEXTDOMAIN ),
					'id' => 'total_user_score_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'Hide Number of User Ratings', IT_TEXTDOMAIN ),
					'id' => 'user_ratings_number_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide number of user ratings next to the total user score label', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				array(
					'name' => __( 'Disable Rating Animations', IT_TEXTDOMAIN ),
					'id' => 'rating_animations_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the slightly darker animation color that slides in from the left', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				array(
					'name' => __( 'Hide Badges', IT_TEXTDOMAIN ),
					'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
					'id' => 'badges_hide_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the listing of badges in the details box', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				array(
					'name' => __( 'Hide Taxonomies', IT_TEXTDOMAIN ),
					'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
					'id' => 'taxonomies_hide_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the listing of taxonomies in the details box', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				array(
					'name' => __( 'Hide Details', IT_TEXTDOMAIN ),
					'desc' => __( 'If taxonomies, details, and badges are all hidden the entire details box will not be displayed', IT_TEXTDOMAIN ),
					'id' => 'details_hide_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the listing of details in the details box', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				array(
					'name' => __( 'Details Label', IT_TEXTDOMAIN ),
					'desc' => __( 'The title text to display next to the minisite icon in the details section', IT_TEXTDOMAIN ),
					'id' => 'details_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'Hide Post Info Box', IT_TEXTDOMAIN ),
					'id' => 'postinfo_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the post info area (tags, categories, author info...)', IT_TEXTDOMAIN ) ),
					'type' => 'checkbox',
					'minisite' => $minisite_slug
				),
				array(
					'name' => __( 'Disable Like Button', IT_TEXTDOMAIN ),
					'id' => 'likes_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the like button from the post info box', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Categories', IT_TEXTDOMAIN ),
					'id' => 'categories_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the category list from the post info box', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Tags', IT_TEXTDOMAIN ),
					'id' => 'tags_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the tag list from the post info box', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),				
				array(
					'name' => __( 'Disable Author Info', IT_TEXTDOMAIN ),
					'id' => 'author_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the author information from the post info box', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Recommended', IT_TEXTDOMAIN ),
					'id' => 'recommended_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Hide the recommended posts section', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Recommended Method', IT_TEXTDOMAIN ),
					'id' => 'recommended_method_'.$minisite_slug,
					'desc' => __( 'For the "Same tags OR same categories" method, use the "Number of Recommended Filters" option below to set how many of EACH will display, rather than how many TOTAL as is applied to the rest of the methods. So setting this to "2" will cause the first two tags and the first two categories to display, resulting in four total filters.', IT_TEXTDOMAIN ),
					'options' => array( 
						'tags' => __( 'Same tags', IT_TEXTDOMAIN ),
						'categories' => __( 'Same categories', IT_TEXTDOMAIN ),
						'tags_categories' => __( 'Same tags OR same categories (tags will appear first in order)', IT_TEXTDOMAIN ),
						'primary_taxonomy' => __( 'Same taxonomy terms (all assigned terms from primary taxonomy)', IT_TEXTDOMAIN ),
						'taxonomies' => __( 'Same taxonomy terms (first assigned term from each taxonomy)', IT_TEXTDOMAIN ),
						'mixed' => __( 'Mixed: one tab for tag, category, and each taxonomy', IT_TEXTDOMAIN )
					),
					'default' => 'tags',
					'type' => 'radio'
				),	
				array(
					'name' => __( 'Recommended Label', IT_TEXTDOMAIN ),
					'desc' => __( 'The title text to display in the title of the recommended section', IT_TEXTDOMAIN ),
					'id' => 'recommended_label_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),
				array(
					'name' => __( 'Number of Recommended Filters', IT_TEXTDOMAIN ),
					'desc' => __( 'The number of filter buttons to display in the recommended filter bar.', IT_TEXTDOMAIN ),
					'id' => 'recommended_filters_num_'.$minisite_slug,
					'target' => 'recommended_filters_number',
					'type' => 'select'
				),
				array(
					'name' => __( 'Disable Recommended Filters', IT_TEXTDOMAIN ),
					'id' => 'recommended_filters_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Disable the filter buttons from the recommended section', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Number of Recommended Posts', IT_TEXTDOMAIN ),
					'desc' => __( 'The number of total posts to display in the recommended section.', IT_TEXTDOMAIN ),
					'id' => 'recommended_num_'.$minisite_slug,
					'target' => 'recommended_number',
					'type' => 'select'
				),
				array(
					'name' => __( 'Targeted Recommended', IT_TEXTDOMAIN ),
					'id' => 'recommended_targeted_'.$minisite_slug,
					'options' => array( 'true' => __( 'Show only recommended articles from this minisite', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Comment Ratings', IT_TEXTDOMAIN ),
					'id' => 'user_comment_rating_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Do not allow users to rate articles in the comments', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Comment Pros/Cons', IT_TEXTDOMAIN ),
					'id' => 'user_comment_procon_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Do not allow users to enter pros and cons with their comment', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Allow Blank Comments', IT_TEXTDOMAIN ),
					'desc' => __( 'Use this if you want your users to be able to submit ratings and/or pros/cons without having to additionally enter standard comment text. Only applies if user comment ratings are enabled.', IT_TEXTDOMAIN ),
					'id' => 'allow_blank_comments_'.$minisite_slug,
					'options' => array( 'true' => __( 'Allow users to post comments without actual comment text', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				
				array(
					'name' => __( 'General', IT_TEXTDOMAIN ),
					'desc' => __( 'Settings that apply to all areas of the minisite', IT_TEXTDOMAIN ),
					'type' => 'heading'
				),
				array(
					'name' => __( 'Disable Top Menu', IT_TEXTDOMAIN ),
					'id' => 'topmenu_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Disable the top menu for this minisite', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Taxonomy Submenu', IT_TEXTDOMAIN ),
					'id' => 'taxonomy_submenu_'.$minisite_slug,
					'options' => array( 'true' => __( 'Display primary taxonomy terms in place of standard submenu', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Unique Sidebar', IT_TEXTDOMAIN ),
					'id' => 'unique_sidebar_'.$minisite_slug,
					'options' => array( 'true' => __( 'Use minisite-specific sidebars instead of defaults', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Disable Frontpage Content', IT_TEXTDOMAIN ),
					'id' => 'content_disable_'.$minisite_slug,
					'options' => array( 'true' => __( 'Disable the content on the home page and only show the post loop', IT_TEXTDOMAIN ) ), 
					'type' => 'checkbox'
				),
				array(
					'name' => __( 'Background Ad URL', IT_TEXTDOMAIN ),
					'desc' => __( 'The URL to direct the user to when they click anywhere on the background. Leave this blank to disable it. For the image to use for the ad, use the page background image URL options.', IT_TEXTDOMAIN ),
					'id' => 'ad_background_'.$minisite_slug,
					'htmlentities' => true,
					'type' => 'text'
				),						
					
				array(
					'type' => 'tab_end'
				)
				
			);
			
			$options = array_merge($options,$minisite_options);
			
		}
	}
}

return array(
	'load' => true,
	'name' => 'options',
	'options' => $options
);
	
?>
