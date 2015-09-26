<?php global $itMinisites, $post; 
$minisite = it_get_minisite($post->ID); ?>
<style type="text/css">
	
	<?php #MAIN ACCENT COLOR 
	$accent = !empty($minisite->color_accent) ? $minisite->color_accent : it_get_setting('color_accent');
	if(empty($accent)) $accent = '#BD2A33';
	?>
			
	/*top menu*/
	#top-menu ul li ul li a:hover, 
	#top-menu ul li ul li.current_page_item a, 
	#top-menu ul li ul li.current_page_ancestor a, 
	#top-menu ul li ul li.current_page_parent a,
	#top-menu ul li ul li.current-menu-item a,
	#top-menu ul li ul li.current-cat a {color:<?php echo $accent; ?>;}
	#top-menu ul li ul li.over a {color:#333;}
	#top-menu ul li ul li a:hover,
	#top-menu ul li ul li ul li a:hover {color:<?php echo $accent; ?>;}
	/*section menu*/
	#section-menu a:hover,
	#section-menu ul li:hover a,
	#section-menu ul li.over a,
	#section-menu ul li a:hover, 
	#section-menu ul li.current_page_item a, 
	#section-menu ul li.current_page_ancestor a, 
	#section-menu ul li.current_page_parent a,
	#section-menu ul li.current-menu-item a,
	#section-menu ul li.current-cat a {color:<?php echo $accent; ?>;}
	#section-menu ul li ul li a,
	#section-menu ul li:hover ul li a,
	#section-menu ul li.over ul li a {color:#333;}
	#section-menu ul li ul li a:hover, 
	#section-menu ul li ul li.current_page_item a, 
	#section-menu ul li ul li.current_page_ancestor a, 
	#section-menu ul li ul li.current_page_parent a,
	#section-menu ul li ul li.current-menu-item a,
	#section-menu ul li ul li.current-cat a,
	#section-menu ul li ul li.active a,
	#section-menu .standard-menu ul li ul li.over a,
	#section-menu .standard-menu ul li ul li:hover a {color:<?php echo $accent; ?>;}
	#section-menu .standard-menu ul li ul li ul li a,
	#section-menu .standard-menu ul li ul li:hover ul li a,
	#section-menu .standard-menu ul li ul li.over ul li a {color:#333;}
	#section-menu .standard-menu ul li ul li ul li:hover a,
	#section-menu .standard-menu ul li ul li ul li.current_page_item a, 
	#section-menu .standard-menu ul li ul li ul li.current_page_ancestor a, 
	#section-menu .standard-menu ul li ul li ul li.current_page_parent a,
	#section-menu .standard-menu ul li ul li ul li.current-menu-item a,
	#section-menu .standard-menu ul li ul li ul li.current-cat a,
	#section-menu .standard-menu ul li ul li ul li.active a {color:<?php echo $accent; ?>;}
	#section-menu .standard-menu ul li ul li ul li ul li a,
	#section-menu .standard-menu ul li ul li ul li:hover ul li a,
	#section-menu .standard-menu ul li ul li ul li.over ul li a {color:#333;}
	#section-menu .standard-menu ul li ul li ul li ul li a:hover,
	#section-menu .standard-menu ul li ul li ul li ul li.current_page_item a, 
	#section-menu .standard-menu ul li ul li ul li ul li.current_page_ancestor a, 
	#section-menu .standard-menu ul li ul li ul li ul li.current_page_parent a,
	#section-menu .standard-menu ul li ul li ul li ul li.current-menu-item a,
	#section-menu .standard-menu ul li ul li ul li ul li.current-cat a,
	#section-menu .standard-menu ul li ul li ul li ul li.active a {color:<?php echo $accent; ?>;}
	/*sub menu*/
	#sub-menu ul li a:hover, 
	#sub-menu ul li:hover a,
	#sub-menu ul li.over a,
	#sub-menu ul li.current_page_item a, 
	#sub-menu ul li.current_page_ancestor a, 
	#sub-menu ul li.current_page_parent a,
	#sub-menu ul li.current-menu-item a,
	#sub-menu ul li.current-cat a {color:<?php echo $accent; ?>;}
	#sub-menu ul li ul li a,
	#sub-menu ul li:hover ul li a,
	#sub-menu ul li.over ul li a {color:#333;}
	#sub-menu ul li ul li:hover a,
	#sub-menu ul li ul li.over a,
	#sub-menu ul li ul li a:hover, 
	#sub-menu ul li ul li.current_page_item a, 
	#sub-menu ul li ul li.current_page_ancestor a, 
	#sub-menu ul li ul li.current_page_parent a,
	#sub-menu ul li ul li.current-menu-item a,
	#sub-menu ul li ul li.current-cat a,
	#sub-menu ul li ul li.active a {color:<?php echo $accent; ?>;}
	#sub-menu ul li ul li ul li a,
	#sub-menu ul li ul li:hover ul li a,
	#sub-menu ul li ul li.over ul li a {color:#333;}
	#sub-menu ul li ul li ul li:hover a,
	#sub-menu ul li ul li ul li.over a,
	#sub-menu ul li ul li ul li a:hover, 
	#sub-menu ul li ul li ul li.current_page_item a, 
	#sub-menu ul li ul li ul li.current_page_ancestor a, 
	#sub-menu ul li ul li ul li.current_page_parent a,
	#sub-menu ul li ul li ul li.current-menu-item a,
	#sub-menu ul li ul li ul li.current-cat a,
	#sub-menu ul li ul li ul li.active a {color:<?php echo $accent; ?>;}
	#sub-menu ul li ul li ul li ul li a,
	#sub-menu ul li ul li ul li:hover ul li a,
	#sub-menu ul li ul li ul li.over ul li a {color:#333;}
	#sub-menu ul li ul li ul li ul li a:hover, 
	#sub-menu ul li ul li ul li ul li.current_page_item a, 
	#sub-menu ul li ul li ul li ul li.current_page_ancestor a, 
	#sub-menu ul li ul li ul li ul li.current_page_parent a,
	#sub-menu ul li ul li ul li ul li.current-menu-item a,
	#sub-menu ul li ul li ul li ul li.current-cat a,
	#sub-menu ul li ul li ul li ul li.active a {color:<?php echo $accent; ?>;}
	
	/*all other styles*/
	a:hover, 
	#top-menu-selector:hover, 
	#new-articles .selector a:hover,
	#sticky-controls a:hover, 
	#sticky-controls a.active,
	#menu-search-button.active span,
	#menu-search input#s,
	#random-article:hover,
	#sub-menu .home-button a:hover,
	.bar-selected .selector-icon,
	.loop h2 a:hover,
	#exclusive ul li a:hover,
	.exclusive-more,
	.connect-counts .social-counts .panel span,
	.connect-counts .social-counts a:hover,
	.widgets #wp-calendar a:hover,
	.social-counts .panel span,
	.social-counts a:hover,
	.single-page .main-content a:hover,
	.single-page.template-authors .main-content a:hover,
	#footer a:hover,
	#footer.widgets #wp-calendar a:hover,
	.ratings .rating-value .stars span,
	.sticky-post .icon-pin,
	.single-page .sortbar .minisite-wrapper,
	.single-page .main-content a, 
	.single-page .main-content a:link, 
	.single-page .main-content a:visited,
	.single-page .main-content a span,
	.single-page .main-content a:link span,
	.single-page .main-content a:visited span {color:<?php echo $accent; ?>;}
	.single-page .main-content a:hover,
	.single-page .main-content a:hover span {color:#000;}
	
	.sticky-form .sticky-submit,
	#new-articles .selector.active a,
	#new-articles .post-container a:hover,
	.revolution-slider .slider-label,
	.bar-selector ul li ul li a:hover,
	.details-box .taxonomies-wrapper .detail-content a:hover,
	.postinfo-box .post-tags a:hover,
	#recommended .filterbar .sort-buttons a:hover,
	#recommended .filterbar .sort-buttons .active,
	#recommended .filterbar .sort-buttons a:active,
	#comments .filterbar .sort-buttons a:hover, 
	#comments .filterbar .sort-buttons a.reply-link:hover,
	#comments .comment-rating,
	#comments .filterbar .sort-buttons span.current,
	#respond .ratings .ui-slider-range,
	#postnav .active {background:<?php echo $accent; ?>;}
	
	.bar-label .label-text,
	.exclusive-label,
	#recommended .filterbar .sort-buttons .bottom-arrow,
	.trending-color {background-color:<?php echo $accent; ?>;}
	
	.hover-text.active, 
	.hover-text.active a,
	.woocommerce .woocommerce-breadcrumb a:hover {color:<?php echo $accent; ?> !important;}
	
	<?php #BOX GRADIENTS
	$color1 = !empty($minisite->color_boxes_1) ? $minisite->color_boxes_1 : it_get_setting('color_boxes_1');
	$color2 = !empty($minisite->color_boxes_2) ? $minisite->color_boxes_2 : it_get_setting('color_boxes_2');
	$color3 = !empty($minisite->color_boxes_3) ? $minisite->color_boxes_3 : it_get_setting('color_boxes_3');
	$color4 = !empty($minisite->color_boxes_4) ? $minisite->color_boxes_4 : it_get_setting('color_boxes_4');
	#color defaults
	$color1 = !empty($color1) ? $color1 : '#30374F';
	$color2 = !empty($color2) ? $color2 : '#408156';
	$color3 = !empty($color3) ? $color3 : '#D6AA26';
	$color4 = !empty($color4) ? $color4 : '#93A31C';
	?>
	.box-0 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color1 ?>),to(<?php echo $color2 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color1 ?>,<?php echo $color2 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color1 ?>, endColorstr=<?php echo $color2 ?>)";}
	.box-1 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color1 ?>),to(<?php echo $color1 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color1 ?>,<?php echo $color1 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color1 ?>, endColorstr=<?php echo $color1 ?>)";}
	.box-2 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color2 ?>),to(<?php echo $color2 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color2 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color2 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color2 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color2 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color2 ?>,<?php echo $color2 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color2 ?>, endColorstr=<?php echo $color2 ?>)";}
	.box-3 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color2 ?>),to(<?php echo $color3 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color3 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color3 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color3 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color3 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color2 ?>,<?php echo $color3 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color2 ?>, endColorstr=<?php echo $color3 ?>)";}
	.box-4 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color2 ?>),to(<?php echo $color4 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color4 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color4 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color4 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color4 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color2 ?>,<?php echo $color4 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color2 ?>, endColorstr=<?php echo $color4 ?>)";}
	.box-5 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color4 ?>),to(<?php echo $color2 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color4 ?>,<?php echo $color2 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color4 ?>,<?php echo $color2 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color4 ?>,<?php echo $color2 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color4 ?>,<?php echo $color2 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color4 ?>,<?php echo $color2 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color4 ?>, endColorstr=<?php echo $color2 ?>)";}
	.box-6 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color2 ?>),to(<?php echo $color1 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color1 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color1 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color1 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color2 ?>,<?php echo $color1 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color2 ?>,<?php echo $color1 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color2 ?>, endColorstr=<?php echo $color1 ?>)";}
	.box-7 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color1 ?>),to(<?php echo $color2 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color2 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color1 ?>,<?php echo $color2 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color1 ?>, endColorstr=<?php echo $color2 ?>)";}
	.box-8 .box-layer {
	background-image: -webkit-gradient(linear,left top,right bottom,from(<?php echo $color1 ?>),to(<?php echo $color1 ?>));
	background-image: -webkit-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: -moz-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: -ms-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: -o-linear-gradient(left top,<?php echo $color1 ?>,<?php echo $color1 ?>);
	background-image: linear-gradient(to bottom right,<?php echo $color1 ?>,<?php echo $color1 ?>);
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=<?php echo $color1 ?>, endColorstr=<?php echo $color1 ?>)";}
	
	<?php #google fonts
	$font_menus = it_get_setting('font_menus');	    
	if(!empty($font_menus) && $font_menus!='spacer') {		
		echo '#section-menu a, #highlight-menu a, #top-menu a, #sub-menu a {font-family:'.$font_menus.';} ';			
	}
	$font_section_headers = it_get_setting('font_section_headers');	    
	if(!empty($font_section_headers) && $font_section_headers!='spacer') {		
		echo '.widgets .header, .bar-label .label-text, a.selector-button, .steam-label, .exclusive-label .label-top, .connect-label .label-top, .sortbar .sortbar-title, .sortbar .sortbar-prefix, .trending-bar .title, .revolution-slider .slider-label, .revolution-slider .category {font-family:'.$font_section_headers.';} ';			
	}
	$font_content_headers = it_get_setting('font_content_headers');	    
	if(!empty($font_content_headers) && $font_content_headers!='spacer') {		
		echo '.single-page .main-content h1, .main-content h1, .main-content h2, .main-content h3, .main-content h4, .main-content h5, .main-content h6, #exclusive ul li a, .articles h2 a, .box-info {font-family:'.$font_content_headers.';} ';			
	}
	$font_body = it_get_setting('font_body');
	$font_body_size = it_get_setting('font_body_size');	    
	if(!empty($font_body) && $font_body!='spacer') echo '.the-content {font-family:'.$font_body.';} body {font-family:'.$font_body.';}';				
	if(!empty($font_body_size)) echo '.the-content {font-size:'.$font_body_size.'px;line-height:'.$font_body_size.'px;}';			
	$font_widgets = it_get_setting('font_widgets');
	$font_widgets_size = it_get_setting('font_widgets_size');	    
	if(!empty($font_widgets) && $font_widgets!='spacer') echo '.widget, .widget a, .post-list .list-item a.title, .topten-articles .panel a.title {font-family:'.$font_widgets.';}';
	if(!empty($font_widgets_size)) echo '.post-list .list-item a.title, .topten-articles .panel a.title, .widgets .textwidget, .widgets .post-list.overlays .box-inner, .widgets ul li a {font-size:'.$font_widgets_size.'px !important;line-height:'.$font_widgets_size.'px !important;}';
	?>	
	
	<?php #MINISITE BACKGROUNDS ?>	
	<?php if($minisite) { ?>
		<?php if($minisite->bg_color) { ?>
			body.it-background {background-color:<?php echo $minisite->bg_color; ?> !important;}
		<?php } ?>
		<?php if($minisite->bg_color_override) { ?>
			body.it-background {background-image:none !important;}
		<?php } ?>
		<?php if($minisite->bg_image) { ?>
			body.it-background {background-image:url(<?php echo $minisite->bg_image; ?>) !important;}
		<?php } ?>
		<?php if($minisite->bg_position) { ?>
			body.it-background {background-position:top <?php echo $minisite->bg_position; ?> !important;}
		<?php } ?>
		<?php if($minisite->bg_repeat) { ?>
			body.it-background {background-repeat:<?php echo $minisite->bg_repeat; ?> !important;}
		<?php } ?>
		<?php if($minisite->bg_attachment) { ?>
			body.it-background {background-attachment:<?php echo $minisite->bg_attachment; ?> !important;}
		<?php } ?>		
	<?php } ?>
	
	<?php #PAGE SPECIFIC STYLES ?>	
	<?php if(is_single() || is_page()) { 
		$bg_color = get_post_meta($post->ID, "_bg_color", $single = true);
		$bg_color_override = get_post_meta($post->ID, "_bg_color_override", $single = true);
		$bg_image = get_post_meta($post->ID, "_bg_image", $single = true);
		$bg_position = get_post_meta($post->ID, "_bg_position", $single = true);
		$bg_repeat = get_post_meta($post->ID, "_bg_repeat", $single = true);
		$bg_attachment = get_post_meta($post->ID, "_bg_attachment", $single = true);
		$bg_overlay = get_post_meta($post->ID, "_bg_overlay", $single = true);	
		?>	
		<?php if($bg_color) { ?>
			body.it-background {background-color:<?php echo $bg_color; ?> !important;}
		<?php } ?>
		<?php if($bg_color_override) { ?>
			body.it-background {background-image:none !important;}
		<?php } ?>
		<?php if($bg_image) { ?>
			body.it-background {background-image:url(<?php echo $bg_image; ?>) !important;}
		<?php } ?>
		<?php if($bg_position) { ?>
			body.it-background {background-position:top <?php echo $bg_position; ?> !important;}
		<?php } ?>
		<?php if($bg_repeat) { ?>
			body.it-background {background-repeat:<?php echo $bg_repeat; ?> !important;}
		<?php } ?>
		<?php if($bg_attachment) { ?>
			body.it-background {background-attachment:<?php echo $bg_attachment; ?> !important;}
		<?php } 
	} ?>
	
	<?php #APPLY CUSTOM CSS ?>	
	<?php if( it_get_setting( 'custom_css' ) )  { ?>
		<?php echo stripslashes( it_get_setting( 'custom_css' ) ) . "\n"; ?>	
	<?php } ?>	
	
	<?php #MINISITE-SPECIFIC STYLES ?>	
	<?php foreach($itMinisites->minisites as $minisite) { 
		$id = $minisite->id;
		$icon = $minisite->icon;
		$iconhd = $minisite->iconhd;
		$iconwhite = $minisite->iconwhite;
		$iconhdwhite = $minisite->iconhdwhite;
		if(empty($iconwhite)) $iconwhite = $icon;
		if(empty($iconhdwhite)) $iconhdwhite = $iconhd;	
		$awards = $minisite->awards;
		$color = $minisite->color_accent;
		/*menu hover colors*/
		if($color) { ?>
			#section-menu ul li.<?php echo $id; ?> a:hover,
			#section-menu ul li.<?php echo $id; ?>:hover a,
			#section-menu ul li.<?php echo $id; ?>.over a,
			#section-menu ul li.<?php echo $id; ?> a:hover, 
			#section-menu ul li.<?php echo $id; ?>.current_page_item a, 
			#section-menu ul li.<?php echo $id; ?>.current_page_ancestor a, 
			#section-menu ul li.<?php echo $id; ?>.current_page_parent a,
			#section-menu ul li.<?php echo $id; ?>.current-menu-item a,
			#section-menu ul li.<?php echo $id; ?>.current-cat a {color:<?php echo $color; ?>}
			
			#section-menu ul li.<?php echo $id; ?> ul li a,
			#section-menu ul li.<?php echo $id; ?>:hover ul li a,
			#section-menu ul li.<?php echo $id; ?>.over ul li a {color:#333;}
			
			#section-menu ul li.<?php echo $id; ?> ul li a:hover, 
			#section-menu ul li.<?php echo $id; ?> ul li.current_page_item a, 
			#section-menu ul li.<?php echo $id; ?> ul li.current_page_ancestor a, 
			#section-menu ul li.<?php echo $id; ?> ul li.current_page_parent a,
			#section-menu ul li.<?php echo $id; ?> ul li.current-menu-item a,
			#section-menu ul li.<?php echo $id; ?> ul li.current-cat a,
			#section-menu ul li.<?php echo $id; ?> ul li.active a,
			#section-menu ul li.<?php echo $id; ?> ul li.active a {color:<?php echo $color; ?>}
			
			.directory-panel .listing.<?php echo $id; ?> .stars span {color:<?php echo $color; ?>}
			.directory-panel .listing.<?php echo $id; ?>.active a {background:<?php echo $color; ?>}
			
			@media (max-width: 767px) { 
				#section-menu ul li.<?php echo $id; ?> ul li.active a {color:#333;}
				#section-menu ul li.<?php echo $id; ?> ul li a:hover {color:<?php echo $color; ?>;}
			}
		<?php } ?>	
		
		<?php /*minisite icons*/ ?>
		@media screen {
		.minisite-icon-<?php echo $id; ?>, #footer .ui-tabs-active .minisite-icon-<?php echo $id; ?>, #footer .ui-tabs-active .minisite-icon-<?php echo $id; ?>.white, #footer .active .minisite-icon-<?php echo $id; ?>.white {background:url(<?php echo $icon; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
		.minisite-icon-<?php echo $id; ?>.white, #footer .minisite-icon-<?php echo $id; ?>, #featured-bar-wrapper .minisite-icon-<?php echo $id; ?> {background:url(<?php echo $iconwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
		<?php foreach($awards as $award){ 
			if(is_array($award)) {
				if(array_key_exists(0, $award)) {
					$awardname = stripslashes($award[0]->name);
					$awardid = preg_replace('/[^a-z0-9]/i', '', strtolower($awardname));
					$awardicon = $award[0]->icon;
					$awardiconwhite = $award[0]->iconwhite;
					if(empty($awardiconwhite)) $awardiconwhite = $awardicon;
					?>
					.award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardicon; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
					.award-wrapper.white .award-icon-<?php echo $awardid; ?>, #footer .award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardiconwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
				<?php } 
			}
		}?>
		}
		@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
		.minisite-icon-<?php echo $id; ?>, #footer .ui-tabs-active .minisite-icon-<?php echo $id; ?>, #footer .ui-tabs-active .minisite-icon-<?php echo $id; ?>.white, #footer .active .minisite-icon-<?php echo $id; ?>.white {background:url(<?php echo $iconhd; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
		.minisite-icon-<?php echo $id; ?>.white, #footer .minisite-icon-<?php echo $id; ?>, #featured-bar-wrapper .minisite-icon-<?php echo $id; ?> {background:url(<?php echo $iconhdwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
		<?php foreach($awards as $award){ 
			if(is_array($award)) {
				if(array_key_exists(0, $award)) {
					$awardname = stripslashes($award[0]->name);
					$awardid = preg_replace('/[^a-z0-9]/i', '', strtolower($awardname));
					$awardiconhd = $award[0]->iconhd;
					$awardiconhdwhite = $award[0]->iconhdwhite;
					if(empty($awardiconhdwhite)) $awardiconhdwhite = $awardiconhd;
					?>
					.award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardiconhd; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
					.award-wrapper.white .award-icon-<?php echo $awardid; ?>, #footer .award-icon-<?php echo $awardid; ?> {background:url(<?php echo $awardiconhdwhite; ?>) no-repeat 0px 0px;background-size:16px 16px !important;width:16px;height:16px;float:left;}
				<?php } 
			}
		}?>
		}
		
	<?php } ?>
</style>