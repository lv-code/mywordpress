<?php
	global $ct_options;

	/**
	 * General Settings
	 *
	 */
	if ( isset( $ct_options['site_width'] ) ) $site_width = $ct_options['site_width'];

	/**
	 * Header Settings
	 *
	 */
	if ( isset( $ct_options['header_bg_color'] ) ) $header_bg_color = $ct_options['header_bg_color'];
	if ( isset( $ct_options['breaknews_color'] ) ) $breaknews_color = $ct_options['breaknews_color'];
	if ( isset( $ct_options['top_bg_color'] ) ) $top_bg_color = $ct_options['top_bg_color'];

	/**
	 * Banner
	 *
	 */
	if ( isset( $ct_options['banner_padding'] ) ) $banner_padding = $ct_options['banner_padding'];

	/**
	 * Page Title Settings
	 *
	 */
	if ( isset( $ct_options['ptitle_padding'] ) ) $ptitle_padding = $ct_options['ptitle_padding'];
	if ( isset( $ct_options['ptitle_bg_type'] ) ) $ptitle_bg_type = $ct_options['ptitle_bg_type'];
	if ( isset( $ct_options['ptitle_background'] ) ) $ptitle_background = $ct_options['ptitle_background'];
	if ( isset( $ct_options['ptitle_color_opacity'] ) ) $ptitle_color_opacity = $ct_options['ptitle_color_opacity'];
	if ( isset( $ct_options['ptitle_bg_attachment'] ) ) $ptitle_bg_attachment = $ct_options['ptitle_bg_attachment'];
	if ( isset( $ct_options['ptitle_bg_repeat'] ) ) $ptitle_bg_repeat = $ct_options['ptitle_bg_repeat'];
	if ( isset( $ct_options['ptitle_bg_position'] ) ) $ptitle_bg_position = $ct_options['ptitle_bg_position'];
	if ( isset( $ct_options['ptitle_bg_image'] ) ) $ptitle_bg_image = $ct_options['ptitle_bg_image'];
	if ( isset( $ct_options['ptitle_header_font'] ) ) $ptitle_header_font = $ct_options['ptitle_header_font'];
	if ( isset( $ct_options['ptitle_mask_background'] ) ) $ptitle_mask_background = $ct_options['ptitle_mask_background'];
	if ( isset( $ct_options['ptitle_mask_opacity'] ) ) $ptitle_mask_opacity = $ct_options['ptitle_mask_opacity'];

	/**
	 * Body
	 *
	 */
	if ( isset( $ct_options['body_background'] ) ) $body_background = stripslashes ( $ct_options['body_background'] );
	if ( isset( $ct_options['body_font'] ) ) $body_font = $ct_options['body_font'];
	if ( isset( $ct_options['ptitle_text_font'] ) ) $ptitle_text_font = $ct_options['ptitle_text_font'];

	/**
	 * Logo
	 *
	 */
	if ( isset( $ct_options['logo_padding'] ) ) $logo_padding = $ct_options['logo_padding'];


	/**
	 * Menu
	 *
	 */
	if ( isset( $ct_options['main_menu_top_level'] ) ) $main_menu_top_level = $ct_options['main_menu_top_level'];
	if ( isset( $ct_options['menu_top_level_active'] ) ) $menu_top_level_active = $ct_options['menu_top_level_active'];
	if ( isset( $ct_options['sublevel_link_color'] ) ) $sublevel_link_color = $ct_options['sublevel_link_color'];
	if ( isset( $ct_options['sublevel_link_hover'] ) ) $sublevel_link_hover = $ct_options['sublevel_link_hover'];
	if ( isset( $ct_options['sublevel_bg_color_default'] ) ) $sublevel_bg_color_default = $ct_options['sublevel_bg_color_default'];
	if ( isset( $ct_options['sublevel_bg_color'] ) ) $sublevel_bg_color = $ct_options['sublevel_bg_color'];


	/**
	 * Blog
	 *
	 */
	if ( isset( $ct_options['blog_layout'] ) ) $blog_layout = $ct_options['blog_layout'];
	if ( isset( $ct_options['blog_pagination'] ) ) $blog_pagination = $ct_options['blog_pagination'];


	/**
	 * Styling Options
	 *
	 */
	if ( isset( $ct_options['theme_color'] ) ) $theme_color = $ct_options['theme_color'];
	if ( isset( $ct_options['theme_bg_elements'] ) ) $theme_bg_elements = $ct_options['theme_bg_elements'];


	/**
	 * Footer
	 *
	 */

	if ( isset( $ct_options['footer_bg_color'] ) ) $footer_bg_color = $ct_options['footer_bg_color'];
	if ( isset( $ct_options['footer_bg_opacity'] ) ) $footer_bg_opacity = $ct_options['footer_bg_opacity'];
	if ( isset( $ct_options['footer_text_color'] ) ) $footer_text_color = $ct_options['footer_text_color'];
	if ( isset( $ct_options['footer_link_color'] ) ) $footer_link_color = $ct_options['footer_link_color'];
	if ( isset( $ct_options['copyright_padding'] ) ) $copyright_padding = $ct_options['copyright_padding'];
	if ( isset( $ct_options['copyright_bg_color'] ) ) $copyright_bg_color = $ct_options['copyright_bg_color'];


?>

/**
 * General Settings
 * -------------------------------------------------------------------------------------------------------------------
 */

@media (min-width: <?php echo ( $site_width + 30 ) . 'px'; ?>) {
  .container {
    width: <?php echo $site_width . 'px'; ?>;
  }
}

/**
 * Header Settings
 * -------------------------------------------------------------------------------------------------------------------
 */
	<?php
	$rgb = ct_hex2rgb( $header_bg_color );
	$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",1)";
?>
 #masthead {
	background: <?php echo $rgba; ?>;
}

.hot-title {
	color: <?php echo $breaknews_color; ?>
}

#ct-topbar {
	background: <?php echo $top_bg_color; ?>;
}

/**
 * Banner
 * -------------------------------------------------------------------------------------------------------------------
 */
#entry-ads {
	padding: <?php echo $banner_padding['padding-top']; ?> <?php echo $banner_padding['padding-right']; ?> <?php echo $banner_padding['padding-bottom']; ?> <?php echo $banner_padding['padding-left']; ?>;
}


/**
 * Body
 * -------------------------------------------------------------------------------------------------------------------
 */
<?php if ( $body_font['font-family'] == '' ) $body_font['font-family'] = 'Arial, Helvetica, sans-serif' ?>

body {
	color: <?php echo $body_font['color']; ?>;
	font-size: <?php echo $body_font['font-size']; ?>;
	font-family: '<?php echo $body_font['font-family']; ?>', Helvetica, Arial, sans-serif;
	line-height: <?php echo $body_font['line-height']; ?>;
}

body { background: <?php echo $body_background; ?>; }

/**
 * Logo
 * -------------------------------------------------------------------------------------------------------------------
 */
.entry-logo {
	padding: <?php echo $logo_padding['padding-top']; ?> <?php echo $logo_padding['padding-right']; ?> <?php echo $logo_padding['padding-bottom']; ?> <?php echo $logo_padding['padding-left']; ?>;
}

/**
 * Styling Options
 * -------------------------------------------------------------------------------------------------------------------
 */
<?php
	$rgb = ct_hex2rgb( $theme_color );
	$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",0.8)";
?>
.post-thumbnail a .post-format i {
	background: <?php echo $rgba; ?>;
}

.entry-content a.more-post-link,
.search-block,
.inner-search #s,
h3#reply-title,
.prev-slide:hover,
.next-slide:hover,
.prev-cat-slide:hover,
.next-cat-slide:hover,
.prev-related-slide:hover,
.next-related-slide:hover,
.prev-nav:hover, .next-nav:hover,
#post-formats-widget .carousel-header .prev-cat-slide:hover,
#post-formats-widget .carousel-header .next-cat-slide:hover,
.ct-page-description {
	background: <?php echo $theme_color; ?>;
}

.logged-in-as, .comment-notes { color: #FFF; }

.edit-link > i,
span.dropcap,
.nav-links .nav-left:hover a,
.nav-links .nav-right:hover a,
#author-description .single-author-name {
	color: <?php echo $theme_color; ?>;
}

<?php
	$rgb = ct_hex2rgb( $theme_color );
	$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",0.5)";
?>
#mainfooter .ct-footer-menu li::before,
.bottom-meta.clearfix li::before,
.header-meta.clearfix li::before,
#sidebar .bottom-meta.clearfix li::before,
.ct-sidebar .bottom-meta.clearfix li::before,
.comment-body > a time::before,
.ct-postformats-widget .ct-post-format:hover .content-box,
.ct-sidebar .widget.ct-comments-widget.clearfix .recent-comments-widget li .comment-time::before {
	background: <?php echo $rgba; ?>;
}

blockquote::before { color: <?php echo $rgba; ?> }

<?php
	$rgb = ct_hex2rgb( $theme_color );
	$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",0.2)";
?>
.entry-post .entry-content h3.entry-title > a:hover,
.widget ul li > a:hover,
.widget ul li .entry-title a:hover,
.first-big-post h3.entry-title a:hover {
	border-bottom: 1px solid <?php echo $rgba; ?>;
}

.entry-tags.clearfix > a {
	color: <?php echo $theme_color; ?> !important;
}

.widget.ct_recent_posts_bycategories_widget.clearfix ul li h4.entry-title .entry-comments i,
.widget.ct_recent_posts_bycategories_widget.clearfix ul li h4.entry-title .entry-views i,
.widget.ct_recent_posts_bycategories_widget.clearfix ul li h4.entry-title .like-count i {
	color: <?php echo $theme_color; ?>;
}

<?php
	$rgb = ct_hex2rgb( $theme_color );
	$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",0.25)";
?>
#ct-topbar {
	border-bottom: 1px solid <?php echo $rgba; ?>;
}

a, a:link, a:visited { color: <?php echo $theme_color; ?>; }
a:hover { color: #131618; }

.flex-direction-nav .flex-prev,
.flex-direction-nav .flex-next,
.pagination span.current,
#infscr-loading > div {
	background: <?php echo $theme_color; ?>;
}

#menu .search-block { background: <?php echo $theme_color; ?>; }

.entry-meta i,
.entry-tags.clearfix > a {
	color: <?php echo $theme_color; ?>;
}

div.wpcf7-mail-sent-ok,
input[type=submit].wpcf7-submit {
	background: <?php echo $theme_color; ?>;
}

#sidebar thead tr th,
#wp-calendar td#today,
#wp-calendar thead tr th { background: <?php echo $theme_color; ?>; }


/**
 * Blog
 * -------------------------------------------------------------------------------------------------------------------
 */
<?php
	if ( $blog_pagination == "infinite_scroll" ) {
		echo '.navigation.pagination {display:none;}';
	}
?>


<?php if( $blog_layout == 'two_columns' ) : ?>
	.post-thumbnail.blog-thumb { margin-bottom: 0; }
<?php endif; ?>


/**
 * Menu
 * -------------------------------------------------------------------------------------------------------------------
 */

#site-nav .sf-menu a { color: <?php echo $main_menu_top_level; ?>; }

#site-nav .sf-menu a:before { background: <?php echo $menu_top_level_active; ?>; }

<?php
	$rgb = ct_hex2rgb( $sublevel_bg_color_default );
	$rgba = "rgba(" . $rgb[0] . "," . $rgb[1] . "," . $rgb[2] . ",1)";
?>

#site-nav .sf-menu ul li {
	background: <?php echo $rgba; ?>;
}

#site-nav .sf-menu ul::before {
	border-color: transparent transparent <?php echo $sublevel_bg_color_default; ?> transparent;
}

#site-nav .sf-menu ul li a:hover, .sf-menu ul ul li a:hover,
#site-nav .sf-menu ul ul li a.sf-with-ul:hover {
	background: <?php echo $sublevel_bg_color; ?>;
}

#site-nav .sf-menu ul li a,
#site-nav .sf-menu ul ul li a,
#site-nav .sf-menu ul ul ul li a,
#site-nav .sf-menu ul ul ul ul li a,
#site-nav .sf-menu ul ul ul ul ul li a {
	color: <?php echo $sublevel_link_color; ?> !important;
}

#site-nav .sf-menu ul li a:hover,
#site-nav .sf-menu ul ul li a:hover,
#site-nav .sf-menu ul ul ul li a:hover,
#site-nav .sf-menu ul ul ul ul li a:hover,
#site-nav .sf-menu ul ul ul ul ul li a:hover {
	color: <?php echo $sublevel_link_hover; ?> !important;
}

#site-nav .sf-menu ul li a:hover, .sf-menu ul ul li a:hover,
#site-nav .sf-menu ul ul li a.sf-with-ul:hover {
	color: <?php echo $sublevel_link_hover; ?> !important;
}

#site-nav .current-menu-item,
#site-nav .current-page-item,
#site-nav .current-menu-item a,
#site-nav .current-page-item a,
#site-nav .current-menu-ancestor > a {
	color: <?php echo $menu_top_level_active; ?>;
}

/**
 * Footer
 * -------------------------------------------------------------------------------------------------------------------
 */
<?php
	$foot_rgb = ct_hex2rgb( $footer_bg_color );
	$foot_rgba = "rgba(" . $foot_rgb[0] . "," . $foot_rgb[1] . "," . $foot_rgb[2] . ",". $footer_bg_opacity . ")";

?>

#mainfooter {
	background: <?php echo $foot_rgba; ?>;
	color: <?php echo $footer_text_color; ?>;
}

#mainfooter,
#mainfooter #copyright,
#mainfooter a.ct-totop,
#mainfooter .ct-totop i {
	color: <?php echo $footer_text_color; ?>;
}

#mainfooter #copyright > a {
	color: <?php echo $footer_link_color; ?>;
}

#mainfooter #copyright {
	padding: <?php echo $copyright_padding['padding-top']; ?> <?php echo $copyright_padding['padding-right']; ?> <?php echo $copyright_padding['padding-bottom']; ?> <?php echo $copyright_padding['padding-left']; ?>;
}

#mainfooter #copyright {
	background: <?php echo $copyright_bg_color; ?>;
}
