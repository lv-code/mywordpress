<?php 
/*
this file contains functions relating to theme presentation that apply to all areas 
of the theme, including all posts, pages, and post types.
*/

#register sidebars
if ( !function_exists( 'it_sidebars' ) ) :
	function it_sidebars() {
		#setup array of default sidebars
		$sidebars = array(
			'submenu' => array(
				'name' => __( 'Submenu', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the submenu area if you have Submenu widgets selected for the content type of the submenu in theme options.', IT_TEXTDOMAIN )
			),
			'loop-sidebar' => array(
				'name' => __( 'Loop Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar of the main loop.', IT_TEXTDOMAIN )
			),
			'page-sidebar' => array(
				'name' => __( 'Page Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar of the page content.', IT_TEXTDOMAIN )
			),
			'minisite-directory-sidebar' => array(
				'name' => __( 'Minisite Directory Sidebar', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sidebar for minisite directory pages if the unique sidebar option for minisite directory pages is turned on.', IT_TEXTDOMAIN )
			),
			'mixed-column-1' => array(
				'name' => __( 'Mixed Column 1', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the mixed column 1.', IT_TEXTDOMAIN )
			),
			'mixed-column-2' => array(
				'name' => __( 'Mixed Column 2', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the mixed column 2.', IT_TEXTDOMAIN )
			),
			'mixed-column-3' => array(
				'name' => __( 'Mixed Column 3', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the mixed column 3.', IT_TEXTDOMAIN )
			),
			'connect-widgets' => array(
				'name' => __( 'Connect Widgets', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the connect bar to the right of the email signup form.', IT_TEXTDOMAIN )
			),
			'footer-column-1' => array(
				'name' => __( 'Footer Column 1', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the first footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-2' => array(
				'name' => __( 'Footer Column 2', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the second footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-3' => array(
				'name' => __( 'Footer Column 3', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the third footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-4' => array(
				'name' => __( 'Footer Column 4', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the fourth footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-5' => array(
				'name' => __( 'Footer Column 5', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the fifth footer column.', IT_TEXTDOMAIN )
			),
			'footer-column-6' => array(
				'name' => __( 'Footer Column 6', IT_TEXTDOMAIN ),
				'desc' => __( 'These widgets appear in the sixth footer column.', IT_TEXTDOMAIN )
			)
		);
		
		#add woocommerce sidebar
		if(function_exists('is_woocommerce')) {
			$sidebars['woo-sidebar'] = array(
				'name' => __( 'WooCommerce Sidebar', IT_TEXTDOMAIN ), 
				'desc' => __( 'These widgets appear in the sidebar of the WooCommerce pages (if unique WooCommerce sidebars are turned on in the theme options).', IT_TEXTDOMAIN)
			);	
		}
		
		#add buddypress sidebar
		if(function_exists('bp_current_component')) {
			$sidebars['bp-sidebar'] = array(
				'name' => __( 'BuddyPress Sidebar', IT_TEXTDOMAIN ), 
				'desc' => __( 'These widgets appear in the sidebar of the BuddyPress pages (if unique BuddyPress sidebars are turned on in the theme options).', IT_TEXTDOMAIN)
			);	
		}
		
		#add minisite sidebars to array
		global $itMinisites;
		if(is_array($itMinisites->minisites)) {
			foreach($itMinisites->minisites as $minisite){
				if($minisite->enabled) {
					#standard sidebar
					$sidebars[strtolower($minisite->safe_name) . '-sidebar'] = array(
						'name' => ucwords($minisite->name) . __( ' Sidebar', IT_TEXTDOMAIN ), 
						'desc' => __( 'These widgets appear in the sidebar of the ', IT_TEXTDOMAIN) . $minisite->name . __(' minisite pages.', IT_TEXTDOMAIN )
					);
					if(it_targeted('mixed', $minisite)) {
						#mixed columns
						$sidebars['mixed-column-1-' . strtolower($minisite->safe_name)] = array(
							'name' => __( 'Mixed Column 1 ', IT_TEXTDOMAIN ) . $minisite->name, 
							'desc' => __( 'These widgets appear in the mixed column 1 for the ', IT_TEXTDOMAIN) . $minisite->name . __(' minisite front page.', IT_TEXTDOMAIN )
						);
						$sidebars['mixed-column-2-' . strtolower($minisite->safe_name)] = array(
							'name' => __( 'Mixed Column 2 ', IT_TEXTDOMAIN ) . $minisite->name, 
							'desc' => __( 'These widgets appear in the mixed column 2 for the ', IT_TEXTDOMAIN) . $minisite->name . __(' minisite front page.', IT_TEXTDOMAIN )
						);			
						$sidebars['mixed-column-3-' . strtolower($minisite->safe_name)] = array(
							'name' => __( 'Mixed Column 3 ', IT_TEXTDOMAIN ) . $minisite->name, 
							'desc' => __( 'These widgets appear in the mixed column 3 for the ', IT_TEXTDOMAIN) . $minisite->name . __(' minisite front page.', IT_TEXTDOMAIN )
						);	
					}
				}
				
			}	
		}
		
		#register sidebars
		foreach ( $sidebars as $type => $sidebar ){
			register_sidebar(array(
				'name' => $sidebar['name'],
				'id'=> $type,
				'description' => $sidebar['desc'],
				'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="header clearfix">',
				'after_title' => '</div>',
			));
		}
		
		#register custom sidebars areas
		$custom_sidebars = get_option( IT_SIDEBARS );
		if( !empty( $custom_sidebars ) ) {
			foreach ( $custom_sidebars as $id => $name ) {
				register_sidebar(array(
					'name' => $name,
					'id'=> "it_custom_sidebar_{$id}",
					'description' => '"' . $name . '"' . __(' custom sidebar was created in the Theme Options', IT_TEXTDOMAIN),
					'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<div class="header">',
					'after_title' => '</div>',
				));
			}
		}		
	}
endif;

#register widgets
if ( !function_exists( 'it_widgets' ) ) :
	function it_widgets() {
		# Load each widget file.
		require_once( THEME_WIDGETS . '/widget-latest-articles.php' );
		require_once( THEME_WIDGETS . '/widget-top-reviewed.php' );
		require_once( THEME_WIDGETS . '/widget-social-counts.php' );
		require_once( THEME_WIDGETS . '/widget-text-unwrapped.php' );
		require_once( THEME_WIDGETS . '/widget-sections.php' );
		require_once( THEME_WIDGETS . '/widget-all-articles.php' );
		require_once( THEME_WIDGETS . '/widget-top-ten.php' );
		require_once( THEME_WIDGETS . '/widget-clouds.php' );
		require_once( THEME_WIDGETS . '/widget-social-tabs.php' );
		require_once( THEME_WIDGETS . '/widget-reviews.php' );
		require_once( THEME_WIDGETS . '/widget-trending.php' );
	
		# Register each widget.
		register_widget( 'it_latest_articles' );
		register_widget( 'it_top_reviewed' );
		register_widget( 'it_social_counts' );
		register_widget( 'it_text_unwrapped' );
		register_widget( 'it_sections' );
		register_widget( 'it_all_articles' );
		register_widget( 'it_top_ten' );
		register_widget( 'it_clouds' );
		register_widget( 'it_social_tabs' );
		register_widget( 'it_reviews' );
		register_widget( 'it_trending' );
	}
endif;
#head scripts and css
function it_header_scripts() { ?>

	<?php #begin style ?> 
     
	<link media="screen, projection" rel="stylesheet" href="<?php echo THEME_STYLES_URI; ?>/bootstrap.css" type="text/css" />
    <?php if(!it_get_setting('responsive_disable')) { ?>
    	<link media="screen, projection" rel="stylesheet" href="<?php echo THEME_STYLES_URI; ?>/bootstrap-responsive.css" type="text/css" />
    <?php } else { ?>
    	<link media="screen, projection" rel="stylesheet" href="<?php echo THEME_STYLES_URI; ?>/bootstrap-non-responsive.css" type="text/css" />
    <?php } ?>
	<link media="screen, projection" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" /> 
    <?php if(!it_get_setting('responsive_disable')) { ?>
    	<link media="screen, projection" rel="stylesheet" href="<?php echo THEME_STYLES_URI; ?>/responsive.css" type="text/css" />
    <?php } ?>
    <link media="screen, projection" rel="stylesheet" href="<?php echo THEME_STYLES_URI; ?>/retina.css" type="text/css" />
    
    <?php it_get_template_part('css'); # styles with php variables ?>
    
    <?php #end style ?>
    
    <?php #custom favicon ?>	
	<link rel="shortcut icon" href="<?php if( it_get_setting( 'favicon_url' ) ) { ?><?php echo esc_url( it_get_setting( 'favicon_url' ) ); ?><?php } else { ?>/favicon.ico<?php } ?>" />
    
    <?php #google fonts  
	#get specified subsets if any
	$subset = '';
	$subsets = ( is_array( it_get_setting("font_subsets") ) ) ? it_get_setting("font_subsets") : array();
	foreach ($subsets as $s) {
		$subset .= $s . ',';
	}
	#remove last comma
	if(!empty($subset)) $subset = mb_substr($subset, 0, -1);
	#custom typography fonts
	$fonts = array();
	$font_menus = it_get_setting('font_menus');
	$font_menus = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $font_menus)));
	$fonts[$font_menus] = $font_menus;
	$font_section_headers = it_get_setting('font_section_headers');
	$font_section_headers = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $font_section_headers)));
	$fonts[$font_section_headers] = $font_section_headers;
	$font_content_headers = it_get_setting('font_content_headers');
	$font_content_headers = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $font_content_headers)));
	$fonts[$font_content_headers] = $font_content_headers;
	$font_body = it_get_setting('font_body');
	$font_body = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $font_body)));
	$fonts[$font_body] = $font_body;
	$font_widgets = it_get_setting('font_widgets');
	$font_widgets = str_replace(' ', '+', str_replace('"', '', str_replace(', sans-serif', '', $font_widgets)));
	$fonts[$font_widgets] = $font_widgets;
	
	$fonts = array_unique($fonts);
    foreach ($fonts as $font) {
		#exclude web fonts and default google fonts
		if(!empty($font) && (strpos($font, 'Arial')===false && strpos($font, 'Verdana')===false && strpos($font, 'Lucida+Sans')===false && strpos($font, 'Georgia')===false && strpos($font, 'Times+New+Roman')===false && strpos($font, 'Trebuchet+MS')===false && strpos($font, 'Courier+New')===false && strpos($font, 'Haettenschweiler')===false && strpos($font, 'Tahoma')===false && strpos($font, 'Oswald')===false && strpos($font, 'Dosis')===false && strpos($font, 'Roboto+Slab')===false && strpos($font, 'Andada')===false && strpos($font, 'spacer')===false))
			echo "<link href='http://fonts.googleapis.com/css?family=".$font."&subset=".$subset."' rel='stylesheet' type='text/css'> \n";
	}
	#default fonts 
	$family = 'http://fonts.googleapis.com/css?family=Dosis:400,600|Oswald:300,400|Roboto+Slab:400,100,300,700|Source+Sans+Pro:300,400,700&amp;subset=';  
    echo '<link href="'.$family.$subset.'" rel="stylesheet" type="text/css">';
	?>
	
<?php }
#demo panel scripts
function it_demo_styles() { 
	$show_demo = it_get_setting('show_demo_panel');
	if($show_demo) { ?>
    
    <link id="menu-fonts-link" href='#' rel='stylesheet' type='text/css'>
    <link id="content-header-fonts-link" href='#' rel='stylesheet' type='text/css'>
    <link id="section-header-fonts-link" href='#' rel='stylesheet' type='text/css'>
    <link id="body-fonts-link" href='#' rel='stylesheet' type='text/css'>
    <link id="widget-fonts-link" href='#' rel='stylesheet' type='text/css'>
    <style id="menu-fonts-style" type="text/css"></style>
    <style id="content-header-fonts-style" type="text/css"></style>
    <style id="section-header-fonts-style" type="text/css"></style>
    <style id="body-fonts-style" type="text/css"></style>
    <style id="widget-fonts-style" type="text/css"></style>  
    
<?php }
}
#demo panel content
function it_demo_panel() { 
	$show_demo = it_get_setting('show_demo_panel');
	if($show_demo) it_get_template_part('demo-panel');
}
#custom javascript
function it_footer_scripts() { ?>
	<script type="text/javascript" src="<?php echo THEME_JS_URI; ?>/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo THEME_JS_URI; ?>/plugins.min.js"></script>
    
    <?php it_get_template_part('scripts'); # custom js ?>   
    <?php it_get_template_part('scripts-ajax'); # custom js for ajax filtering ?>     

<?php
}
#custom javascript
function it_custom_javascript() {
	$custom_js = it_get_setting( 'custom_js' );
	
	if( empty( $custom_js ) )
		return;
		
	$custom_js = preg_replace( "/(\r\n|\r|\n)\s*/i", '', $custom_js );
	?><script type="text/javascript">
	/* <![CDATA[ */
	<?php echo stripslashes( $custom_js ); ?>
	/* ]]> */
</script>
<?php
}
#after post
function it_hide_pagination() { ?>
<!--
<div class="hide-pagination">
	<?php // there is an error when running ThemeCheck that says this theme does not have pagination when
    // in fact it does (see feed.php >> which calls the pagination function in functions/core.php
    // so this code is added to bypass that error, but it is hidden so it doesn't show up on the page
    paginate_links();
	$args="";
	wp_link_pages( $args );
    ?>
</div>
-->	
<?php }
#html display of background ad
function it_background_ad() {
	$out = '';
	$url = it_get_setting('ad_background');
	global $post;
	$minisite = it_get_minisite($post->id);
	if($minisite) $url = $minisite->ad_background;
	if(!empty($url)) $out .= '<a id="background-ad" href="' . $url .'" target="_blank"></a>';
	return $out;
}
#get custom length excerpts
function it_excerpt($len = 230) {
	$excerpt = get_the_excerpt();		
	if (mb_strlen($excerpt)>$len) $excerpt = mb_substr($excerpt, 0, $len-3) . "...";
	return $excerpt;
}
#get custom length titles
function it_title($len = 110) {
	$title = get_the_title();		
	if (!empty($len) && mb_strlen($title)>$len) $title = mb_substr($title, 0, $len-3) . "...";
	return $title;
}
#html display of signup form
function it_signup_form() {
?>

	<div class="sortbar-right">
        <form id="feedburner_subscribe" class="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo it_get_setting('feedburner_name'); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
                                    
            <div class="email-label"><?php echo it_get_setting("loop_email_label"); ?></div>
        
            <div class="input-append info" title="<?php echo it_get_setting("loop_email_label"); ?>">
                <input class="span2" id="appendedInputButton" type="text" name="email" placeholder="<?php _e('Email address',IT_TEXTDOMAIN); ?>">
                <button class="btn icon-check" type="button"></button>
            </div>
            
            <input type="hidden" value="<?php echo it_get_setting('feedburner_name'); ?>" name="uri"/>
            <input type="hidden" name="loc" value="en_US"/>
        
        </form>
    </div>
    
<?php 	
}
#html display of pagination
function it_pagination($pages = '', $format, $range = 6) {	
	global $paged;
	$out = '';	
	$loop = $format['loop'];
	$cols = $format['columns'];
	$view = $format['view'];
	$sort = $format['sort'];
	$numarticles = $format['numarticles'];	
	$location = $format['location'];
	$container = $format['container'];
	$thumbnail = $format['thumbnail'];
	$rating = $format['rating'];
	$icon = $format['icon'];
	$meta = $format['meta'];
	if(empty($paged)) $paged = $format['paged'];
	if(empty($paged)) $paged = 1;	
	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)	$pages = 1;
	} 
	if(empty($range)) $range = 6;
	$start = $paged - $range;
	$stop = $paged + $range;
	$leftshown = false;
	$firstshown = false;
	if(1 != $pages)	{
		$out .= '<div class="pagination" data-loop="'.$loop.'" data-location="'.$location.'" data-sorter="'.$sort.'" data-columns="'.$cols.'" data-view="'.$view.'" data-container="' . $container . '" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-icon="'.$icon.'" data-meta="'.$meta.'" data-numarticles="'.$numarticles.'">';			
		for ($i = $start; $i <= $stop; $i++) {	
			if($i>0 && $i<=$pages) {
				$class="inactive";
				if($paged == $i) $class="active";
				#first page
				if($start > 1 && !$firstshown && !it_get_setting('first_last_disable')) {
					$firstshown = true;
					$out .= '<a class="inactive arrow first" data-paginated="1"><span class="icon-first"></span></a>';	
				}
				#left arrow	
				if($start > 1 && !$leftshown && !it_get_setting('prev_next_disable')) {
					$leftshown = true;
					$leftnum = $i - 1;
					if($leftnum > 1) $out .= '<a class="inactive arrow previous" data-paginated="' . $leftnum . '"><span class="icon-previous"></span></a>';	
				}
				#page number
				$out .= '<a class="' . $class . '" data-paginated="' . $i . '">' . $i . '</a>';						
			}
		}
		#right and last arrows	
		if($stop < $pages) {
			$rightnum = $i + 1;
			if(!it_get_setting('prev_next_disable') && $rightnum<=$pages) $out .= '<a class="inactive arrow next" data-paginated="' . $rightnum . '"><span class="icon-next"></span></a>';	
			if(!it_get_setting('first_last_disable')) $out .= '<a class="inactive arrow last" data-paginated="' . $pages . '"><span class="icon-last"></span></a>';	
		}		
		$out .= '</div>';
		return $out;
	}
}
#html display of post nav
function it_get_postnav() {
	global $post;
	$out = '';
	$previous_hidden = '';
	$next_hidden = '';
	$previous_url = '';
	$previous_title = '';
	$next_url = '';
	$next_title = '';
	$cssrandom = '';
	$post_type = get_post_type();
	if($post_type=='post') $post_type = NULL; #let the function create the post type
    $random_url = it_get_random_article($post_type);
	$next_post = get_next_post();
	if (!empty( $next_post )) {
		$next_title = $next_post->post_title;
		$next_url = get_permalink( $next_post->ID );
	} else {
		$next_hidden = ' hidden';	
	}
	$previous_post = get_previous_post();
	if (!empty( $previous_post )) {
		$previous_title = $previous_post->post_title;
		$previous_url = get_permalink( $previous_post->ID );
	} else {
		$previous_hidden = ' hidden';	
	}	
	if(it_get_setting('post_postnav_random_disable')) $cssrandom = ' no-random';
	
	$out .= '<div id="postnav-wrapper" class="clearfix' . $cssrandom . '">';	
		$out .= '<div id="postnav">';		
			$out .= '<div class="previous-wrapper">';				
				$out .= '<a class="' . $previous_hidden . '" href="' . $previous_url . '">&nbsp;</a>';
				$out .= '<div class="previous-inner inner-content">';
					$out .= '<div class="nav-item ' . $previous_hidden . '"><span class="icon-previous"></span>' . __('previous',IT_TEXTDOMAIN) . '</div>';
					$out .= '<div class="article-title ' . $previous_hidden . '">' . $previous_title . '</div>&nbsp;';
				$out .= '</div>';				
			$out .= '</div>';
			if(!it_get_setting('post_postnav_random_disable')) {
				$out .= '<div class="random-wrapper">';
					$out .= '<a href="' . $random_url . '">&nbsp;</a>';
					$out .= '<div class="random-inner inner-content">';
						$out .= '<div class="nav-item">' . __('random',IT_TEXTDOMAIN) . '<br /><span class="icon-random"></span></div>';					
					$out .= '</div>';
				$out .= '</div>';
			}
			$out .= '<div class="next-wrapper">';	
				$out .= '<a class="' . $next_hidden . '" href="' . $next_url . '">&nbsp;</a>';
				$out .= '<div class="next-inner inner-content">';
					$out .= '<div class="nav-item ' . $next_hidden . '">' . __('next',IT_TEXTDOMAIN) . '<span class="icon-next"></span></div>';
					$out .= '<div class="article-title ' . $next_hidden . '">' . $next_title . '</div>&nbsp;';
				$out .= '</div>';
			$out .= '</div>';		
		$out .= '</div>';		
	$out .= '</div>';
            
	return $out;
}
#html display of section menu
function it_section_menu() {
	global $itMinisites, $post;
	$out = '<ul id="menu-section-menu" class="menu">';	
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'main-menu' ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ 'main-menu' ] );                                    
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$preload = it_get_setting('section_menu_preload');
		$numarticles = it_get_setting('section_menu_article_num');
		if(empty($numarticles)) $numarticles = 8;
		$thumbnail_disable = it_get_setting('section_menu_thumbnails_disable');
		$thumbnail = true;
		if($thumbnail_disable) $thumbnail = false;
		#loop through each menu item
		foreach ( (array) $menu_items as $key => $menu_item ) {
			#resets
			$selected = '';
			$icon = '';
			$arrow = '';
			$arrow_right = '';
			$method = '';
			$term_link = '';
			$current = '';
			$loading = '';
			$object_name = '';
			$term_slug = '';
			$menu_args = array();
			$args = array();
			$terms = array();
			$minisite = false;
			$loop = 'menu';
			$minisiteid = 0;
			$menu_content = '';
			$menu_item_type = 'mega';
			$unloaded = $preload ? ' loaded' : ' unloaded'; 
			
			#menu item variables
			$title = $menu_item->title;
			$url = $menu_item->url;
			$parentid = $menu_item->menu_item_parent;
			$objectid = $menu_item->object_id;
			$type = $menu_item->type;
			$object = $menu_item->object;
			$minisite = it_get_minisite_by_meta($objectid);
			$args = array('posts_per_page' => $numarticles);			
			
			#minisite variables
			if($minisite) {
				$method = 'minisite';
				$icon = it_get_category($minisite);
				$primary_taxonomy = $minisite->get_primary_taxonomy();	
				$object = $primary_taxonomy->slug;	
				$object_name = $object;								
				$minisiteid = $minisite->id;
				if(is_page() && $objectid == $post->ID) $current = 'current-menu-item';	
			} elseif($object=='category') {
				$method = $object;
				$object_name = 'category_name';
				$term = get_term_by('id', $objectid, $object);
				$term_slug = $term->slug;
				if(is_category() && in_category($objectid, $post->ID)) $current = 'current-menu-item';				
			} elseif($object=='post_tag') {
				$method = $object;
				$object_name = 'tag';
				$term = get_term_by('id', $objectid, $object);
				$term_slug = $term->slug;
				if(is_tag() && has_tag($objectid, $post->ID)) $current = 'current-menu-item';
			} elseif($type=='taxonomy') { #if type is still taxonomy but not category or post_tag, it must be a minisite taxonomy
				$method = 'taxonomy';
				$object_name = $object;				
				$term = get_term_by('id', $objectid, $object);
				$term_slug = $term->slug;
				if(is_tax() && is_object_in_term($post->ID, $object, $term->slug)) $current = 'current-menu-item';
				#add first object to args
				$args[$object_name] = $term->slug;
				#query posts to get single post to determine minisite for taxonomy items
				if($method=='taxonomy') {
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) { 
							$query->the_post();
							$postid = get_the_ID();
							$post_type = get_post_type($postid);
							$minisite = $itMinisites->get_type_by_id($post_type);
							$minisiteid = $minisite->id;
						}
					}
				}
			} else {
				$menu_item_type = 'standard';
				if(is_page() && $objectid == $post->ID) $current = 'current-menu-item';
				$unloaded = ' loaded';
			}
			
			$loading = '<ul class="loading-placeholder"><li><div class="loading"><div>&nbsp;</div></div></li></ul>';
			
			#this is a mega menu item
			if($menu_item_type=='mega') {
				if($preload) {
					$menu_args = array('object' => $object, 'objectid' => $objectid, 'object_name' => $object_name, 'loop' => $loop, 'location' => $loop, 'thumbnail' => $thumbnail, 'numarticles' => $numarticles, 'type' => $menu_item_type, 'minisite' => $minisite, 'method' => $method, 'sorter' => $term_slug);
					$menu_content = it_mega_menu_item($menu_args);
				}
				$arrow = '<span class="icon-down-bold"></span><span class="icon-right"></span>';
				$arrow_right = ' arrow-right';
			}
			
			#display the menu item
			$out .= '<li id="menu-item-' . $objectid . '" class="menu-item menu-item-' . $objectid . ' ' . $type . ' ' . $minisiteid . ' ' . $current . $unloaded . '" data-loop="' . $loop . '" data-method="' . $method . '" data-minisite="' . $minisiteid . '" data-numarticles="' . $numarticles . '" data-object_name="'.$object_name.'" data-object="'.$object.'" data-thumbnail="'.$thumbnail.'" data-type="'.$menu_item_type.'" data-sorter="'.$term_slug.'">';
				$out .= '<a class="parent-item' . $arrow_right . '" href="' . $url . '">' . $icon . $title . $arrow . '</a>';
				$out .= $loading;
				$out .= '<div class="dropdown-placeholder">' . $menu_content . '</div>';
			$out .= '</li>';
		}		
	}
	$out .= '</ul>';	
	return $out;
}
#html display of section menu
function it_mega_menu_item($args) {
	
	extract($args);
	
	#defaults
	$out = '';
	$error = '';
	$term_count = 0;
	$post_count = 0;
	$term_counter = 0;
	$mega_dropdown = false;

	#get term list based on method
	switch($method) {
		case 'minisite':
			$terms = get_terms($object, array('parent' => 0, 'hide_empty' => 0));
			if (is_wp_error($terms)) {
   				$error .= $terms->get_error_message() . '&nbsp;&nbsp;&nbsp;&nbsp;';	
				$terms = array();
			}
			if(!empty($terms)) $first_term = $terms[0]->slug;	
			$args['post_type'] = $minisite->id;
		break;	
		case 'category':
			$terms = get_terms($object, array('parent' => $objectid, 'hide_empty' => 0));
			#if(!empty($terms)) $first_term = $terms[0]->slug;
			$first_term = $sorter;
		break;
		case 'post_tag':
			$terms = get_terms($object, array('parent' => $objectid, 'hide_empty' => 0));
			#if(!empty($terms)) $first_term = $terms[0]->slug;
			$first_term = $sorter;
		break;
		case 'taxonomy':
			$terms = get_terms($object, array('parent' => $objectid, 'hide_empty' => 0));
			if(!empty($terms)) $first_term = $terms[0]->slug;
			$term = get_term_by('id', $objectid, $object);
		break;
	}

	#only get loop for mega menu items
	if($type == 'mega') {
		#no term list was found, don't display sub terms
		if(empty($terms)) {
			$term = get_term_by('id', $objectid, $object);
			$first_term = $term->slug;
		}
		#get count of returned terms
		if($method=='minisite') $term_count = count($terms);
		#add first object to args
		$args[$object_name] = $first_term;
		#get the link for the first object
		$term_link = get_term_link($first_term, $object);
		if(is_wp_error($term_link)) {
			$error .= $term_link->get_error_message();	
			$term_link = '';
		}
		#setup args
		$format = array('loop' => $loop, 'location' => $location, 'thumbnail' => $thumbnail, 'rating' => false, 'icon' => false);
		$args = array('posts_per_page' => $numarticles, $object_name => $first_term);
		#query posts
		$loop = it_loop($args, $format);
		$post_count = $loop['posts'];
		
	}
	
	if($term_count > 0 || $post_count > 0) $mega_dropdown = true;

	#begin mega drop down
	if($mega_dropdown) {
		$out .= '<ul class="term-list';
		if($term_count == 0) $out .= ' solo';
		$out .= '">';
			$out .= '<li class="post-list">';
				$out .= '<div class="loading"><div>&nbsp;</div></div>';
				$out .= $loop['content'];
				$out .= '<a class="view-all" href="' . $term_link . '">' . __('VIEW ALL',IT_TEXTDOMAIN) . '<span class="icon-right"></span></a>';
			$out .= '</li>';
			
			#begin sub term menu list
			if($term_count > 0) {
				foreach ( $terms as $term ) { 
					$term_counter++;
					$term_name = $term->name;
					$term_slug = $term->slug;
					$term_link = get_term_link($term_slug, $object);
					$out .= '<li';
					if($term_counter==1) {
						$out .= ' class="active"';
					} else {
						$out .= ' class="inactive"';
					}
					$out .= '>';
						$out .= '<a class="list-item" data-sorter="'.$term_slug.'" href="' . $term_link . '">' . $term_name . '</a>';
					$out .= '</li>';
				}
			}							
		$out .= '</ul>';				
	}	
	if(!empty($error)) echo '<div id="ajax-error">' . $error . '</div><style type="text/css">#ajax-error{display:block !important;}</style>';
	wp_reset_query();
	return $out;	
}
#html display of sidebar
function it_widget_panel($widgets, $class) {
	echo '<div class="widgets-wrapper">';
		echo '<div class="widgets ' . $class . '">';				
		if ( function_exists('dynamic_sidebar') && dynamic_sidebar($widgets) ) : else :			
			echo '<div class="widget">';			
				echo '<div class="header">';					
					echo '<h3>'.$widgets.'</h3>';						
				echo '</div>';
			echo '</div>';			
		endif;			
		echo '</div>';	
	echo '</div>';	
}
#get featured image
function it_featured_image($postid, $size, $width, $height, $wrapper = false, $itemprop = false, $link = true) {
	$out = '';
	$featured_image = '';
	$cssdarken = '';
	if(!it_get_setting('colorbox_disable')) $cssdarken = ' darken';
	if($wrapper) $out.='<div class="featured-image-wrapper"><div class="featured-image-inner">';
	if($itemprop) {
		$featured_image .= get_the_post_thumbnail($postid, $size, array( 'title' => get_the_title(), 'itemprop' => 'image' ));
	} else {
		$featured_image .= get_the_post_thumbnail($postid, $size, array( 'title' => get_the_title()));
	}
	if(empty($featured_image)) {
		$featured_image .= '<img';
		if($itemprop) $featured_image .= ' itemprop="image"';
		$featured_image .= ' src="'.THEME_IMAGES.'/placeholder-'.$width.'.png" alt="featured image" width="'.$width.'" height="'.$height.'" />';
	}
	$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
    if($link) $out .= '<a class="featured-image' . $cssdarken . '" href="' . $large_image_url[0] . '">';
	$out .= $featured_image;
	if($link) $out .= '</a>';
	if($wrapper) $out.='</div></div>';
	return $out;
}
#html display of featured video
function it_video( $args = array() ) {	
	extract( $args );
	if(empty($style)) $style = 'top';
	if(empty($noframe)) $noframe = '';
	# Vimeo video
	if( preg_match_all( '#https?://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches ) ) {
		if( !empty( $parse ) )
			return do_shortcode( '[vimeo url="' . $url . '" title="0" fs="0" portrait="0" height="' . $height . '" width="' . $width . '"]' );
		else
			return 'vimeo';
		
	} elseif( preg_match( '#https?://(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com/(.*?)#i', $url, $matches ) ) {
		if( !empty( $parse ) )			
			return do_shortcode( '[youtube url="' . $url . '" controls="' . ( empty( $video_controls ) ? 0 : 1 ) . '" autoplay="' . ( $style=='top' ? 0 : 1 ) . '" showinfo="0" fs="1" height="' . $height . '" width="' . $width . '" noframe="' . $noframe . '"]' );
		else			
			return 'youtube';
			
	} else {
		return false;
	}
}
#inject ad into loop
function it_get_ad($ads, $postcount, $adcount, $cols, $nonajax) {	
	$out = '';		
	if(it_get_setting('ad_num')!=0 && (($postcount==it_get_setting('ad_offset')+1) || (($postcount-it_get_setting('ad_offset')-1) % (it_get_setting('ad_increment'))==0) && $postcount>it_get_setting('ad_offset') && (it_get_setting('ad_num')>$adcount)) && ($nonajax || it_get_setting('ad_ajax'))) {				
		$out.='<div class="panel-wrapper it-ad">';				
			$out.='<div class="panel">';
				$out.='<div class="panel-inner">';			
					$out .= do_shortcode($ads[$adcount]);	
				$out .= '</div>';		
			$out.='</div>';				 
		$out.='</div>';				
		if($postcount % $cols==0) $out.='<br class="clearer" />';
		$adcount++; #increase adcount		
		$postcount++; #increase postcount				
	}	
	$counts=array('ad' => $out, 'postcount' => $postcount, 'adcount' => $adcount);	
	return $counts;	
}

#html display of list of comma separated categories
function it_get_categories($postid, $label = false) {
	$categories = get_the_category($postid);
	$separator = ', ';
	$out = '';
	if($categories) {
		$out .= '<div class="category-list">';
			if($label) $out .= '<span class="icon-category"></span>';
			
			foreach($categories as $category) {
				$out .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", IT_TEXTDOMAIN ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
			}
			$out = substr_replace($out,"",-2);
			
		$out .= '</div>';
	}	
	return $out;
}

#html display of category with icon
/*
the theme assumes the icon will always be dark unless it's in the featured widgets area
or the footer area, so those two areas are hard-coded into the CSS in this function. 
the $white variable is an override variable and is only used if you want to force a 
white version of the icon in any area other than the featured and footer areas.
for instance, the category icon featured image overlays in the post loop which 
need white icons even though they're displayed in the light-colored main content area.
*/
function it_get_category($minisite, $white = false, $wrapper = false, $label = false) {
	if(empty($minisite)) return false;
	$id = $minisite->id;
	$name = $minisite->name;
	$icon = $minisite->icon;
	$csswhite = '';
	if($white) $csswhite = ' white';
	$out='';
	if($wrapper) $out .= '<div class="minisite-wrapper">';
	if(!empty($icon)) $out .= '<span class="minisite-icon minisite-icon-' . $id . $csswhite . '"></span>';	
	if($label) $out .= $name;
	if($wrapper) $out .= '</div>';
	return $out;	
}

#get tags for the current post excluding template tags
function it_get_tags($postid, $separator = '') {	
	$tags = wp_get_post_tags($postid); #get all tag objects for this post
	$count=0;
	$tagcount=0;
	foreach($tags as $tag) {	#determine number of tags
		$tagcount++;
	}
	$out = '<div class="post-tags">';
	foreach($tags as $tag) {	#display tag list
		$count++;			
		$tag_link = get_tag_link($tag->term_id);
		$out .= '<a href="'.$tag_link.'" title="'.$tag->name.' Tag" class="'.$tag->slug.'">'.$tag->name.'</a>';
		if($count<$tagcount) {
			$out .= $separator; #add the separator if this is not the last tag
		}						
	}
	$out .= '<br class="clearer" /></div>';
	return $out;
}

#get authorship (date and author) into variable
function it_get_authorship() {
	$out = '';
	$out .= '<div class="authorship">';
		
		$out .= '<span class="author">';
			$out .= __('by ',IT_TEXTDOMAIN);
			$out .= '<a href="' . get_author_posts_url(get_the_author_meta('ID')) . '">';
				if(is_single()) {
					$out .= '<span itemprop="author">' . get_the_author() . ' </span>';
				} else {
					$out .= get_the_author();
				}
			$out .= '</a>';
		$out .= '</span>';
		$out .= '<span class="date">';
			$out .= __('on ',IT_TEXTDOMAIN);
			if(is_single()) $out .= '<meta itemprop="datePublished" content="' . get_the_date() . '">';
			$out .=  get_the_date();
		$out .= '</span>';
		
	$out .= '</div>';
	return $out;
}
#display authorship (date and author)
function it_show_authorship() {
	echo it_get_authorship();
}

#html display of sortbar
function it_get_sortbar($args) {
	extract($args);
	if(empty($disable_arrow)) $disable_arrow = false;
	if(empty($class)) $class = '';
	$out = '';	
	$active_shown = false;
	if(it_get_setting('loop_filtering_disable')) return false;
	if(empty($icon)) $icon = 'recent';
	if(empty($timeperiod)) $timeperiod = '';
	$out .= '<div class="sortbar-wrapper">';	
		$out .= '<div class="sortbar clearfix ' . $class . '">';	
			$out .= '<span class="icon-'.$icon.'"></span>';	
			if($prefix) $out .= '<div class="sortbar-prefix">' . $prefix . '</div>';	
			if($prefix && !$disable_title) $out .= '<div class="sortbar-separator"> - </div>';				
			if(!$disable_title) $out .= '<div class="sortbar-title">' . $title . '</div>';			
			if(!$disable_filters) {					
				if(!$disable_arrow) $out .= '<span class="sortbar-arrow icon-down-bold"></span>';		
				if(!it_get_setting("loop_tooltips_disable")) $infoclass="info-bottom";							
				$out .= '<div class="sort-buttons" data-loop="' . $loop . '" data-location="' . $location . '" data-container="' . $container . '" data-view="' . $view . '" data-numarticles="'.$numarticles.'" data-columns="' . $cols . '" data-paginated="1" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-meta="'.$meta.'" data-timeperiod="'.$timeperiod.'">';	
					if(!in_array('recent', $disabled)) {	
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						}
						$out .= '<a data-sorter="recent" class="icon-recent recent ' . $activeclass . ' ' . $infoclass . '" title="' . $title . '">&nbsp;</a>';
					}
					if(!in_array('viewed', $disabled)) {
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						}
						$out .= '<a data-sorter="viewed" class="icon-viewed viewed ' . $activeclass . ' ' . $infoclass . '" title="' . __('MOST VIEWED', IT_TEXTDOMAIN) . '">&nbsp;</a>';
					}	
					if(!in_array('liked', $disabled)) {
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						} 
						$out .= '<a data-sorter="liked" class="icon-liked liked ' . $activeclass . ' ' . $infoclass . '" title="' . __('MOST LIKED', IT_TEXTDOMAIN) . '">&nbsp;</a>';
					}			
					if(!in_array('reviewed', $disabled)) {
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						}
						$out .= '<a data-sorter="reviewed" class="icon-reviewed reviewed ' . $activeclass . ' ' . $infoclass . '" title="' . __('BEST REVIEWED', IT_TEXTDOMAIN) . '">&nbsp;</a>';
					}					 
					if(!in_array('rated', $disabled)) {
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						}
						$out .= '<a data-sorter="users" class="icon-users users ' . $activeclass . ' ' . $infoclass . '" title="' . __('HIGHEST RATED', IT_TEXTDOMAIN) . '">&nbsp;</a>';
					}					
					if(!in_array('commented', $disabled)) {
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						}
						$out .= '<a data-sorter="commented" class="icon-commented commented ' . $activeclass . ' ' . $infoclass . '" title="' . __('MOST COMMENTED', IT_TEXTDOMAIN) . '">&nbsp;</a>';
					}					
					if(!in_array('awarded', $disabled)) {
						if(!$active_shown) {
							$active_shown = true;
							$activeclass='active';	
						} else {
							$activeclass='';
						}
						$out .= '<a data-sorter="awarded" class="icon-awarded awarded ' . $activeclass . ' ' . $infoclass . '" title="' . __('RECENTLY AWARDED', IT_TEXTDOMAIN) . '">&nbsp;</a>';
					}				
				$out .= '</div>';				
			}			
		$out .= '</div>';	
	$out .= '</div>';	
	return $out;	
}

#html display of minisite filter buttons
function it_get_minisite_filters($args) {
	global $itMinisites;
	extract($args);
	$out = '';	
	$out .= '<div class="sort-buttons" data-loop="' . $loop . '" data-location="' . $location . '" data-thumbnail="'.$thumbnail.'" data-numarticles="'.$numarticles.'" data-rating="'.$rating.'" data-rating-small="'.$rating_small.'" data-meta="'.$meta.'" data-award="'.$award.'" data-article-format="'.$article_format.'" data-width="'.$width.'" data-height="'.$height.'" data-size="'.$size.'">';
		$i=0;                   
		foreach($itMinisites->minisites as $minisite){			
			if(array_key_exists($minisite->id, $enabled)) {
				if($minisite->enabled && $enabled[$minisite->id]) {
					$i++;
					$activecss = '';
					$white = false;
					if($i==1) {
						$activecss = ' active';	
						$white = true;
					}
					$out .= '<a data-sorter="' . $minisite->id . '" class="info' . $activecss . '" title="' . __('Latest from', IT_TEXTDOMAIN) . ' ' . $minisite->name . '">' . it_get_category($minisite, $white) . '<span class="selector-arrow"></span></a>';
					
				}	
			}
		}
		$out .= '</div>';	
	return $out;	
}

#html display of likes
function it_get_likes($args) {
	extract($args);
	$out = '';
	$tooltip = '';
	#determine if this post was already liked
	$ip=it_get_ip();
	$ips = get_post_meta($postid, IT_META_LIKE_IP_LIST, $single = true);
	$likeaction='like'; #default action is to like
	if(strpos($ips,$ip) !== false) $likeaction='unlike'; #already liked, need to unlike instead
	$likes = get_post_meta($postid, IT_META_TOTAL_LIKES, $single = true);	
	$label_text=__(' likes',IT_TEXTDOMAIN);
	if($likes==1) $label_text=__(' like',IT_TEXTDOMAIN);
	if(empty($likes) && $label) $likes=0; #display 0 if displaying the label
	if(empty($tooltip_hide)) $tooltip = ' info-bottom';
	if($clickable) {
		$out.='<a class="like-button do-like '.$postid.$tooltip.'" data-postid="'.$postid.'" data-likeaction="'.$likeaction.'" title="'.__('Likes',IT_TEXTDOMAIN).'">';
	} else {
		$out='<span class="metric' . $tooltip . '" title="'.__('Likes',IT_TEXTDOMAIN).'">';
	}
	if($icon) $out.='<span class="icon icon-liked '.$likeaction.'"></span>';
	$out.='<span class="numcount">'.$likes;
	if($label) $out.=$label_text;
	$out.='</span>';
	if($clickable) {
		$out.='</a>';
	} else {
		$out.='</span>';
	}
	return $out;
}

#html display of views
function it_get_views($args) {
	extract($args);
	if(it_get_setting('views_disable_global')) return false;
	$tooltip = '';
	$views = get_post_meta($postid, IT_META_TOTAL_VIEWS, $single = true);
	$label_text=__(' views',IT_TEXTDOMAIN);
	if($views==1) $label_text=__(' view',IT_TEXTDOMAIN);
	if(empty($tooltip_hide)) $tooltip = ' info-bottom';
	$out='<span class="metric' . $tooltip . '" title="'.__('Views',IT_TEXTDOMAIN).'">';
	if(!empty($views)) {
		if($icon) $out.='<span class="icon icon-viewed"></span>';
		$out.='<span class="numcount">'.$views;
		if($label) $out.=$label_text;
		$out.='</span>';
	}
	$out.='</span>';
	return $out;
}

#html display of comment count
function it_get_comments($args) {
	extract($args);
	$tooltip = '';
	$comments = get_comments_number($postid);
	$label_text=__(' comments',IT_TEXTDOMAIN);
	if($comments==1) $label_text=__(' comment',IT_TEXTDOMAIN);
	if(empty($tooltip_hide)) $tooltip = ' info-bottom';
	$out='<span class="metric' . $tooltip . '" title="'.__('Comments',IT_TEXTDOMAIN).'">';
	if($comments>0 || $showifempty) {
		if($anchor_link) '<a href="#comments">';
			if($icon) $out.='<span class="icon icon-commented"></span>';
			$out.='<span class="numcount">'.$comments;
			if($label) $out.=$label_text;
			$out.='</span>';
		if($anchor_link) '</a>';
	}
	$out.='</span>';
	return $out;
}

#html display of author's latest article
function it_author_latest_article($authorid) {
	$out = '';
	$authorargs = array( 'post_type' => 'any', 'author' => $authorid, 'showposts' => 1);
	$recentPost = new WP_Query($authorargs);
	if($recentPost->have_posts()) : while($recentPost->have_posts()) : $recentPost->the_post();	
		$out.=__( 'Latest Article: ', IT_TEXTDOMAIN );
		$out.='<a href="'.get_permalink().'">'.get_the_title().'</a>';
	endwhile;
	endif;
	return $out;	
}

#html display of author info
function it_get_author($postid) {
	$out = '<div class="author-info">';
		$out .= '<div class="author-image thumbnail">';
			$out .= '<a class="info" title="'.__('See all posts from this author',IT_TEXTDOMAIN).'" href="'.get_author_posts_url(get_the_author_meta('ID')).'">';
				$out .= get_avatar(get_the_author_meta('user_email'), 70);
			$out .= '</a>';
		$out .= '</div>';
		$out .= '<a class="info" title="'.__('See all posts from this author',IT_TEXTDOMAIN).'" href="'.get_author_posts_url(get_the_author_meta('ID')).'">';
			$out .= '<h3>'.get_the_author_meta('display_name').'</h3>';
		$out .= '</a>';
		$out .= get_the_author_meta('description');
		$out .= it_author_profile_fields(get_the_author_meta('ID'));
		$out .= '<br class="clearer" />';
	$out .= '</div>';
	return $out;
}

#html display of post info panel
function it_get_post_info($postid) {
	$out = '';
	$likesargs = array('postid' => $postid, 'label' => true, 'icon' => true, 'clickable' => true);
	if(it_component_disabled('postinfo', $postid)) return false;	
	$out .= '<div class="postinfo-box-wrapper">';
		$out .= '<div class="postinfo-box">';	
			if(!it_component_disabled('likes', $postid)) $out .= it_get_likes($likesargs);
			if(!it_component_disabled('categories', $postid)) $out .= it_get_categories($postid, true);
			if(!(it_component_disabled('likes', $postid) && it_component_disabled('categories', $postid))) $out .= '<br class="clearer" />';
			if(!it_component_disabled('tags', $postid) && get_the_tags($postid)) $out .= '<div class="post-tags-wrapper"><span class="icon-tag"></span>'.it_get_tags($postid).'</div>';	
			$out .= '<br class="clearer" />';
			if(!it_component_disabled('author', $postid)) $out .= it_get_author($postid);	
		$out .= '</div>';
	$out .= '</div>';
		
	return $out;
}

#html display of login form 
function it_login_form() {
	$out = '';
	$homeurl = force_ssl_login() ? str_replace('http://','https://',home_url()) : home_url();
	$out .= '<form method="post" action="' . $homeurl . '/wp-login.php" class="sticky-login-form">';
		$out .= '<div id="sticky-login-submit" class="sticky-submit login">';
			$out .= '<span class="icon-check"></span>';
			$out .= __('LOGIN',IT_TEXTDOMAIN);
		$out .= '</div>';  
		$out .= '<div class="input-prepend">';
			$out .= '<span class="add-on icon-username"></span>';
			$out .= '<input type="text" name="log" value="' . esc_attr(stripslashes($user_login)) . '" id="user_login" tabindex="11" placeholder="username" />';
		$out .= '</div>';
		$out .= '<br class="clearer" />';
		$out .= '<div class="input-prepend">';
			$out .= '<span class="add-on icon-password"></span>';
			$out .= '<input type="password" name="pwd" value="" id="user_pass" tabindex="12" placeholder="password" />';
		$out .= '</div>'; 		                           
		$out .= '<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '" />';
		$out .= '<input type="hidden" name="user-cookie" value="1" /> '; 		               
	$out .= '</form>';
	
	return $out;
}

#html display of register form 
function it_register_form() {
	$out = '';
	$homeurl = force_ssl_login() ? str_replace('http://','https://',site_url('wp-login.php?action=register', 'login_post')) : site_url('wp-login.php?action=register', 'login_post');
	$out .= '<form method="post" action="' . $homeurl . '" class="sticky-register-form">';
		$out .= '<div id="sticky-register-submit" class="sticky-submit register">';
			$out .= '<span class="icon-check"></span>';
			$out .= __('REGISTER',IT_TEXTDOMAIN);
		$out .= '</div>';  
		$out .= '<div class="input-prepend">';
			$out .= '<span class="add-on icon-username"></span>';
			$out .= '<input type="text" name="user_login" value="' . esc_attr(stripslashes($user_login)) . '" id="user_register" tabindex="11" placeholder="username" />';
		$out .= '</div>';
		$out .= '<br class="clearer" />';
		$out .= '<div class="input-prepend">';
			$out .= '<span class="add-on at-symbol">@</span>';
			$out .= '<input type="text" name="user_email" value="' . esc_attr(stripslashes($user_email)) . '" id="user_email" tabindex="12" placeholder="email" />';
		$out .= '</div>'; 		                           
		$out .= '<input type="hidden" name="redirect_to" value="' . $_SERVER['REQUEST_URI'] . '?register=true" />';
		$out .= '<input type="hidden" name="user-cookie" value="1" /> '; 		               
	$out .= '</form>';
	
	return $out;
}
#html display of email form 
function it_email_form() {
	$out = '';
	
	$email_label = it_get_setting("email_label");
	if(empty($email_label)) $email_label = __('ENTER YOUR E-MAIL',IT_TEXTDOMAIN); 
	
	$onsubmit = "window.open('http://feedburner.google.com/fb/a/mailverify?uri=" . it_get_setting("feedburner_name") . "', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true";
	
	$out .= '<div class="connect-email info" title="' . __('Hit enter when done',IT_TEXTDOMAIN) . '">';
	
		$out .= '<form id="feedburner_subscribe" class="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="' . $onsubmit . '">';
			
			$out .= '<input type="text" class="email-textbox" name="email" placeholder="' . $email_label . '">';
			
			$out .= '<span class="icon-email"></span>';
			
			$out .= '<input type="hidden" value="' . it_get_setting('feedburner_name') . '" name="uri"/>';
			$out .= '<input type="hidden" name="loc" value="en_US"/>';
		
		$out .= '</form>';
	
	$out .= '</div>';
	
	return $out;
}
#html display of social badges
function it_social_badges() {
	$out = '<div class="social-badges">';
	$social = it_get_setting( 'sociable' );
    if( $social['keys'] != '#' ) {
		$social_keys = explode( ',', $social['keys'] );

		foreach ( $social_keys as $key ) {
			if( $key != '#' ) {

				$social_link = ( !empty( $social[$key]['link'] ) ) ? $social[$key]['link'] : home_url();
				$social_icon = ( !empty( $social[$key]['icon'] ) ) ? $social[$key]['icon'] : 'none';
				$social_custom = ( !empty( $social[$key]['custom'] ) ) ? $social[$key]['custom'] : '#';
				$social_hover = ( !empty( $social[$key]['hover'] ) ) ? $social[$key]['hover'] : ucwords($social_icon);
				
				#if($social_link!='#top') $social_link = 'http://'.str_replace('http://','',$social_link);
				
				if( !empty( $social[$key]['custom'] ) )
					$out .= '<a href="'.esc_url( $social_link ).'" class="info" title="'.$social_hover.'" target="_blank"><img src="' . esc_url( $social_custom ) . '" alt="link" /></a>';

				elseif( empty( $social[$key]['custom'] ) )
					$out .= '<a href="'.esc_url( $social_link ).'" class="icon-'.$social_icon.' info" title="'.$social_hover.'" target="_blank"></a>';
				  
			}
		}
	}	
	$out .= '</div>';
	return $out;
}

#html display of related posts
function it_get_recommended($postid) {
	$out = '';
	if(it_component_disabled('recommended', $postid)) return false;	
	$minisite = it_get_minisite($postid);
	#theme options variables
	$label = it_get_setting('post_recommended_label');	
	$numarticles = it_get_setting('post_recommended_num');	
	$numfilters = it_get_setting('post_recommended_filters_num');
	$method = it_get_setting('post_recommended_method');
	$disable_filters = it_component_disabled('recommended_filters', $postid);
	$method = ( !empty($method) ) ? $method : 'tags';
	#override with minisite-specific settings
	if($minisite) {
		$label = $minisite->recommended_label;
		$numarticles = $minisite->recommended_num;
		$numfilters = $minisite->recommended_filters_num;
		$method = $minisite->recommended_method;		
		$method = ( !empty($method) ) ? $method : 'tags';
	}
	#defaults
	$label = ( !empty($label) ) ? $label : __('More Goodness',IT_TEXTDOMAIN);
	$numarticles = ( !empty($numarticles) ) ? $numarticles : 6;	
	$numfilters = ( !empty($numfilters) ) ? $numfilters : 3;	
	$loop = 'recommended';
	$location = 'widget';
	$thumbnail = true;
	$rating = true;
	$icon = true;
	$container = '#recommended';
	$cols = 1;
	#setup the query            
	$args=array('posts_per_page' => $numarticles, 'post__not_in' => array($postid));	
	#setup loop format
	$format = array('loop' => $loop, 'location' => $location, 'thumbnail' => $thumbnail, 'rating' => $rating, 'icon' => $icon, 'container' => $container, 'columns' => $cols, 'article_format' => '', 'award' => false, 'rating_small' => false);		
	#add minisite to args
	$targeted = '';	
	if($minisite && $minisite->recommended_targeted) {
		$args['post_type'] = $minisite->id;
		$targeted = $minisite->id;
	}	
	$filters = '';
	$count = 0;
	$testargs = $args;
	#recommended methods
	switch($method) {
		case 'tags':
			$terms = wp_get_post_terms($postid, 'post_tag');				
			foreach($terms as $term) {				
				$testargs['tag_id'] = $term->term_id;
				if($count==0) $args['tag_id'] = $term->term_id;
				query_posts ( $testargs );
				if(have_posts()) {
					$count++;
					
					$filters .= '<a data-sorter="'.$term->term_id.'" data-method="tags" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles tagged: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
					
					if($count == $numfilters) break;	
				}
			}
		break;
		case 'categories':
			$terms = wp_get_post_terms($postid, 'category');	
			foreach($terms as $term) {				
				$testargs['cat'] = $term->term_id;
				if($count==0) $args['cat'] = $term->term_id;
				query_posts ( $testargs );
				if(have_posts()) {
					$count++;
					
					$filters .= '<a data-sorter="'.$term->term_id.'" data-method="categories" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles filed under: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';				
					
					if($count == $numfilters) break;
				}
			}
		break;
		case 'tags_categories':
			#tag			
			$terms = wp_get_post_terms($postid, 'post_tag');			
			foreach($terms as $term) {				
				$testargs['tag_id'] = $term->term_id;
				if($count==0) $args['tag_id'] = $term->term_id;	
				query_posts ( $testargs );
				$half = round($numfilters/2, 0);
				if(have_posts()) {	
					$count++;
					
					$filters .= '<a data-sorter="'.$term->term_id.'" data-method="tags" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles tagged: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
						
					if($count == $half) break;
				}
			}
			
			#category
			$testargs = $args;
			$terms = wp_get_post_terms($postid, 'category');			
			foreach($terms as $term) {				
				$testargs['cat'] = $term->term_id;
				if($count==0) $args['cat'] = $term->term_id;				
				query_posts ( $testargs );
				if(have_posts()) {	
					$count++;
				
					$filters .= '<a data-sorter="'.$term->term_id.'" data-method="categories" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles filed under: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
						
					if($count == $numfilters) break;					
				}
			}
		break;	
		case 'primary_taxonomy':
			$primary_taxonomy = $minisite->get_primary_taxonomy();
			$terms = wp_get_post_terms($postid, $primary_taxonomy->slug);			
			foreach($terms as $term) {
				$tax_query = array(array('taxonomy' => $primary_taxonomy->slug, 'field' => 'id', 'terms' => $term->term_id));
				$testargs['tax_query'] = $tax_query;
				if($count==0) $args['tax_query'] = $tax_query;	
				query_posts ( $testargs );
				if(have_posts()) {
					$count++;
					
					$filters .= '<a data-sorter="'.$term->term_id.'" data-taxonomy="'.$primary_taxonomy->slug.'" data-method="taxonomies" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles from: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';				
					
					if($count == $numfilters) break;
				}
			}		
		break;	
		case 'taxonomies':
			$taxonomies = $minisite->taxonomies;			
			foreach($taxonomies as $taxonomy){
				$terms = wp_get_post_terms($postid, $taxonomy[0]->slug);
				foreach($terms as $term) {					
					$tax_query = array(array('taxonomy' => $taxonomy[0]->slug, 'field' => 'id', 'terms' => $term->term_id));
					$testargs['tax_query'] = $tax_query;					
					if($count==0) $args['tax_query'] = $tax_query;	
					query_posts ( $testargs );
					if(have_posts()) {					
						$count++;
					
						$filters .= '<a data-sorter="'.$term->term_id.'" data-taxonomy="'.$taxonomy[0]->slug.'" data-method="taxonomies" class="info';
						if($count==1) $filters .= ' active';
						$filters .= '" title="' . __('More articles from: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
										
						break;						
					}
				}
				if($count == $numfilters) break;
			}
		break;
		case 'mixed':
			#tag			
			$terms = wp_get_post_terms($postid, 'post_tag');			
			foreach($terms as $term) {				
				$testargs['tag_id'] = $term->term_id;
				if($count==0) $args['tag_id'] = $term->term_id;	
				query_posts ( $testargs );
				if(have_posts()) {	
					$count++;
					
					$filters .= '<a data-sorter="'.$term->term_id.'" data-method="tags" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles tagged: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
						
					break;
				}
			}
			if($count == $numfilters) break;
			#category
			$testargs = $args;
			$terms = wp_get_post_terms($postid, 'category');			
			foreach($terms as $term) {				
				$testargs['cat'] = $term->term_id;
				if($count==0) $args['cat'] = $term->term_id;				
				query_posts ( $testargs );
				if(have_posts()) {	
					$count++;
				
					$filters .= '<a data-sorter="'.$term->term_id.'" data-method="categories" class="info';
					if($count==1) $filters .= ' active';
					$filters .= '" title="' . __('More articles filed under: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';
						
					break;					
				}
			}
			if($count == $numfilters) break;
			#taxonomies
			$testargs = $args;
			$taxonomies = $minisite->taxonomies;			
			foreach($taxonomies as $taxonomy){
				if(is_array($taxonomy)) {
					if(array_key_exists(0, $taxonomy)) {
						$terms = wp_get_post_terms($postid, $taxonomy[0]->slug);
						foreach($terms as $term) {					
							$tax_query = array(array('taxonomy' => $taxonomy[0]->slug, 'field' => 'id', 'terms' => $term->term_id));
							$testargs['tax_query'] = $tax_query;					
							if($count==0) $args['tax_query'] = $tax_query;	
							query_posts ( $testargs );
							if(have_posts()) {	
								$count++;
												
								$filters .= '<a data-sorter="'.$term->term_id.'" data-taxonomy="'.$taxonomy[0]->slug.'" data-method="taxonomies" class="info';
								if($count==1) $filters .= ' active';
								$filters .= '" title="' . __('More articles from: ', IT_TEXTDOMAIN) . $term->name . '">'.$term->name.'<span class="bottom-arrow"></span></a>';				
								
								break;						
							}
						}
					}
				}
			}
			if($count == $numfilters) break;		
		break;
	}	
	if($count>0) {
		$out .= '<div id="recommended" class="clearfix">';
			$out .= '<div class="filterbar">';
				$out .= '<div class="sort-buttons" data-loop="'.$loop.'" data-location="'.$location.'" data-thumbnail="'.$thumbnail.'" data-rating="'.$rating.'" data-numarticles="'.$numarticles.'" data-icon="'.$icon.'" data-targeted="'.$targeted.'" data-container="'.$container.'" data-columns="'.$cols.'">';
					$out .= '<div class="ribbon-wrapper">';
						$out .= '<div class="ribbon">';
							$out .= '<span class="icon-thumbs-up"></span>';
							$out .= $label;
							$out .= '<div class="ribbon-separator">&nbsp;</div>';
						$out .= '</div>';
					$out .= '</div>';
					if(!$disable_filters) $out .= $filters;
				$out .= '</div>';
				$out .= '<br class="clearer" />';
			$out .= '</div>';
			
			$out .= '<div class="loading"><div>&nbsp;</div></div>';	
			
			$out .= '<div class="post-list-wrapper">';
				$out .= '<div class="post-list">';	
				
					#display the loop
					$loop = it_loop($args, $format); 
					$out .= $loop['content'];
				
				$out .= '</div>';
			$out .= '<br class="clearer" /></div>';
		$out .= '</div>';
	}
	wp_reset_query();
	return $out;
}

function it_comment($comment, $args, $depth) {
	global $post;	
	$GLOBALS['comment'] = $comment; ?>		
	
	<li id="li-comment-<?php comment_ID(); ?>">
		<div class="comment" id="comment-<?php comment_ID(); ?>">
			<div class="comment-avatar-wrapper">
            	<div class="comment-avatar">
					<?php echo get_avatar($comment, 50); ?>
				</div>
            </div>
			<div class="comment-content">
            
				<div class="comment-author"><?php printf(__('%s',IT_TEXTDOMAIN), get_comment_author_link()) ?></div>
                
				<a class="comment-meta" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s',IT_TEXTDOMAIN), get_comment_date(),  get_comment_time()) ?></a>
				<?php $editlink = get_edit_comment_link();
				if(!empty($editlink)) { ?>
                	<a href="<?php echo $editlink; ?>"><span class="icon-pencil"></span></a>
                <?php } ?>
                
				<br class="clearer" />
                
                <?php if ($comment->comment_approved == '0') : ?>
                
                    <div class="comment-moderation">
                        <?php _e('Your comment is awaiting moderation.',IT_TEXTDOMAIN) ?>                               
                    </div>
                    
                <?php endif; ?>  
                
                <?php echo it_get_comment_rating($post->ID, $comment->comment_ID); ?>
                
                <?php if(strpos(get_comment_text(),'it_hide_this_comment')===false) { ?>
                
                    <div class="comment-text">
                    
                        <?php comment_text() ?>
                        
                    </div>    
                    
                <?php } ?>            
                    
				<?php echo get_comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>                    
                
			</div>
			<br class="clearer" />
       	</div>
	
<?php } 

#add container to comment form fields
function it_before_comment_fields() {
	$out = '';
	$width = '';
	global $post;					
	$minisite = it_get_minisite($post->ID);
	$disable_review = get_post_meta( $post->ID, IT_META_DISABLE_REVIEW, $single = true );
	if(!$minisite || $minisite->user_rating_disable || $disable_review=='true') $width=' full';
	$out .= '<div class="comment-fields-container'.$width.'">';
	$out .= '<div class="comment-fields-inner">';
	echo $out;	
}
function it_after_comment_fields() {
	$out = '';
	$out .= '</div>';
	$out .= '</div>';	
	global $post;					
	$minisite = it_get_minisite($post->ID);
	$disable_review = get_post_meta( $post->ID, IT_META_DISABLE_REVIEW, $single = true );
	if($minisite && !$minisite->user_rating_disable && $disable_review!='true') {
		if(!$minisite->user_comment_rating_disable) {
			$out .= '<div class="comment-ratings-container">';
			$out .= '<div class="comment-ratings-inner ratings">';
				$out .= it_get_comment_criteria($post->ID);					
			$out .= '</div>';
			$out .= '</div><br class="clearer" />';
		}			
	}
	echo $out;	
}
#html display of author's profile fields
function it_author_profile_fields($authorid) {
	$out='<div class="author-profile-fields">';
	if(get_the_author_meta('twitter', $authorid))
		$out.='<a class="icon-twitter info" title="'. __( 'Find me on Twitter', IT_TEXTDOMAIN ) .'" href="http://twitter.com/'. get_the_author_meta('twitter', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('facebook', $authorid))
		$out.='<a class="icon-facebook info" title="'. __( 'Find me on Facebook', IT_TEXTDOMAIN ) .'" href="http://www.facebook.com/'. get_the_author_meta('facebook', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('googleplus', $authorid))
		$out.='<a class="icon-googleplus info" title="'. __( 'Find me on Google+', IT_TEXTDOMAIN ) .'" href="http://plus.google.com/'. get_the_author_meta('googleplus', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('linkedin', $authorid))
		$out.='<a class="icon-linkedin info" title="'. __( 'Find me on LinkedIn', IT_TEXTDOMAIN ) .'" href="http://www.linkedin.com/in/'. get_the_author_meta('linkedin', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('pinterest', $authorid))
		$out.='<a class="icon-pinterest info" title="'. __( 'Find me on Pinterest', IT_TEXTDOMAIN ) .'" href="http://www.pinterest.com/'. get_the_author_meta('pinterest', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('flickr', $authorid))
		$out.='<a class="icon-flickr info" title="'. __( 'Find me on Flickr', IT_TEXTDOMAIN ) .'" href="http://www.flickr.com/photos/'. get_the_author_meta('flickr', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('youtube', $authorid))
		$out.='<a class="icon-youtube info" title="'. __( 'Find me on YouTube', IT_TEXTDOMAIN ) .'" href="http://www.youtube.com/user/'. get_the_author_meta('youtube', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('instagram', $authorid))
		$out.='<a class="icon-instagram info" title="'. __( 'Find me on Instagram', IT_TEXTDOMAIN ) .'" href="http://instagram.com/'. get_the_author_meta('instagram', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('vimeo', $authorid))
		$out.='<a class="icon-vimeo info" title="'. __( 'Find me on Vimeo', IT_TEXTDOMAIN ) .'" href="http://www.vimeo.com/'. get_the_author_meta('vimeo', $authorid) .'" target="_blank"></a>';	
	if(get_the_author_meta('stumbleupon', $authorid))
		$out.='<a class="icon-stumbleupon info" title="'. __( 'Find me on StumbleUpon', IT_TEXTDOMAIN ) .'" href="http://www.stumbleupon.com/stumbler/'. get_the_author_meta('stumbleupon', $authorid) .'" target="_blank"></a>';
	if(get_the_author_meta('user_email', $authorid))
		$out.='<a class="icon-email info" title="'. __( 'E-mail Me', IT_TEXTDOMAIN ) .'" href="mailto:'. get_the_author_meta('user_email', $authorid) .'"></a>';
	if(get_the_author_meta('user_url', $authorid))
		$out.='<a class="icon-globe info" title="'. __( 'My Website', IT_TEXTDOMAIN ) .'" href="'. get_the_author_meta('user_url', $authorid) .'" target="_blank"></a>';	
	$out.='</div>';
    return $out;	
}
#get footer layout
function it_footer_layout($l){
	$col1 = '';
	$col2 = '';
	$col3 = '';
	$col4 = '';
	$col5 = '';
	$col6 = '';
	switch($l) {
		case 'a':
			$col1=12;
		break;
		case 'b':
			$col1=6;
			$col2=6;
		break;
		case 'c':
			$col1=4;
			$col2=4;
			$col3=4;
		break;	
		case 'd':
			$col1=3;
			$col2=3;
			$col3=3;
			$col4=3;
		break;
		case 'e':
			$col1=2;
			$col2=2;
			$col3=2;
			$col4=2;
			$col5=2;
			$col6=2;
		break;
		case 'f':
			$col1=10;
			$col2=2;
		break;
		case 'g':
			$col1=9;
			$col2=3;
		break;
		case 'h':
			$col1=8;
			$col2=4;
		break;
		case 'i':
			$col1=6;
			$col2=3;
			$col3=3;
		break;
		case 'j':
			$col1=2;
			$col2=10;
		break;
		case 'k':
			$col1=3;
			$col2=9;
		break;
		case 'l':
			$col1=4;
			$col2=8;
		break;
		case 'm':
			$col1=3;
			$col2=3;
			$col3=6;
		break;
		case 'n':
			$col1=4;
			$col2=2;
			$col3=2;
			$col4=2;
			$col5=2;
		break;
		case 'o':
			$col1=4;
			$col2=4;
			$col3=2;
			$col4=2;
		break;
		case 'p':
			$col1=3;
			$col2=3;
			$col3=2;
			$col4=2;
			$col5=2;
		break;
		case 'q':
			$col1=2;
			$col2=2;
			$col3=2;
			$col4=2;
			$col5=4;
		break;
		case 'r':
			$col1=2;
			$col2=2;
			$col3=4;
			$col4=4;
		break;
		case 's':
			$col1=2;
			$col2=2;
			$col3=2;
			$col4=3;
			$col5=3;
		break;
		case 't':
			$col1=4;
			$col2=3;
			$col3=3;
			$col4=2;
		break;
		case 'u':
			$col1=4;
			$col2=2;
			$col3=3;
			$col4=3;
		break;
		case 'v':
			$col1=4;
			$col2=3;
			$col3=2;
			$col4=3;
		break;
		case 'w':
			$col1=2;
			$col2=3;
			$col3=3;
			$col4=4;
		break;
		case 'x':
			$col1=3;
			$col2=3;
			$col3=2;
			$col4=4;
		break;
		case 'y':
			$col1=3;
			$col2=2;
			$col3=3;
			$col4=4;
		break;
		case 'z':
			$col1=4;
			$col2=2;
			$col3=4;
			$col4=2;
		break;
		case 'aa':
			$col1=4;
			$col2=2;
			$col3=2;
			$col4=4;
		break;
		case 'ab':
			$col1=2;
			$col2=4;
			$col3=2;
			$col4=4;
		break;
		case 'ac':
			$col1=3;
			$col2=2;
			$col3=3;
			$col4=2;
			$col5=2;
		break;
		case 'ad':
			$col1=3;
			$col2=2;
			$col3=2;
			$col4=2;
			$col5=3;
		break;
	}
	$layout = array('col1' => $col1, 'col2' => $col2, 'col3' => $col3, 'col4' => $col4, 'col5' => $col5, 'col6' => $col6);
	return $layout;
}
#woocommerce actions
function it_wrapper_start() { 	
	$layout = it_get_setting('woo_layout');
	$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
	if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);
	?>
    
    <div class="container">
    
        <div id="content-wrapper" class="loop-page">
        
            <div class="row">
        
                <div class="span12">
                        
                    <?php if($layout=='sidebar-left') { ?>
                    
                        <?php it_widget_panel($sidebar, $layout); ?>
                                    
                    <?php } ?>
                
                    <div id="content" class="main-content articles <?php echo $layout; ?>">
                    
                        <div class="main-sortbar">
                        
                            <div class="sortbar-wrapper">
                            
                                <div class="sortbar clearfix">
            
                                    <?php $args = array('delimiter' => ' &raquo; '); ?>
                                
                                    <div class="sortbar-title"><?php if(function_exists('woocommerce_breadcrumb') && !it_get_setting('woo_breadcrumb_disable')) woocommerce_breadcrumb($args); ?></div>
                                    
                                </div>
                                
                            </div> 
                            
                        </div>
                        
                        <div class="content-inner">
                        
                            <div class="single-page">
                                    
                                <div class="main-content">
                            
                                    <div class="intro-content">
                
                        
                    
<?php }

function it_wrapper_end() {	
	$layout = it_get_setting('woo_layout');
	$sidebar = __('Page Sidebar',IT_TEXTDOMAIN);
	if(it_get_setting('woo_sidebar_unique')) $sidebar = __('WooCommerce Sidebar',IT_TEXTDOMAIN);	
	
	?>
    
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div class="pagination-wrapper">
                            
                                <?php if(function_exists('woocommerce_pagination')) woocommerce_pagination(); ?>
                                
                            </div>
                        
                        </div>
        
                    </div>          
                 
                    <?php if($layout=='sidebar-right') { ?>
                    
                        <?php it_widget_panel($sidebar, $layout); ?>
                    
                    <?php } ?>
                
                </div>
            
            </div>
            
        </div>
        
    </div>
    
<?php }
?>