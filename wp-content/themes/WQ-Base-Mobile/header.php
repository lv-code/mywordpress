<?php if(ISMOBILE):?>
<!DOCTYPE html> 
<html> 
<head> 
	<meta charset="utf-8">
	<title><?php theme_title();?></title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="<?php bloginfo('template_url');?>/jquery.mobile-1.2.0/jquery.mobile-1.2.0.min.css" />
	<link rel="stylesheet" href="<?php bloginfo('template_url');?>/style/mobile.css" />
	<script src="<?php bloginfo('template_url');?>/jquery.mobile-1.2.0/jquery-1.8.2.min.js"></script>
	<script src="<?php bloginfo('template_url');?>/jquery.mobile-1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script>
		$(document).ready(function(){
			
		});		
	</script>
	<?php wp_head();?>	
</head> 
<body>
<div data-role="page">
	<div data-role="header">
		<a href="<?php bloginfo('home');?>" data-role="button" data-icon="home" data-iconpos="notext">首页</a>
		<h1><?php theme_title();?></h1>
		<a href="#popupNested" data-rel="popup" data-role="button"  data-position-to="window" data-transition="pop" data-inline="true" data-icon="grid" data-iconpos="notext">导航</a>		
	</div>
	<div data-role="popup" id="popupNested" data-theme="none" data-overlay-theme="a"  class="ui-corner-all">
		<div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:250px;">
			<ul data-role="listview" data-inset="true" style="min-width:210px;" data-theme="b">
				<li data-role="divider" data-theme="a" data-mini="true">导航 Menu</li>
				<?php wp_nav_menu(array( 'items_wrap' => '%3$s','container' => '','depth'=>1 )); ?>
				<li data-role="divider" data-theme="a"><button data-theme="a" onclick="javascript:history.go(-1)" data-rel="back" data-mini="true" data-icon="delete">关闭 Cancel</button></li>
			</ul>
		</div>
	</div>
<?php else:?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type');?>; charset=<?php bloginfo('charset');?>" />
<?php
// 自定义description,keywords
	$options = get_option('pb_options');
	$seo = array('keywords' => '', 'description' => '');
	if (is_home() || is_page()) {
		// 将以下引号中的内容改成你的主页description
		$seo['description'] = $options['pbo_description']; 
		// 将以下引号中的内容改成你的主页keywords
		$seo['keywords'] = $options['pbo_keywords'];
	} elseif (is_single()) {
		$description1 = get_post_meta($post -> ID, "description", true);
		$description2 = mb_strimwidth(strip_tags(apply_filters('the_content', $post -> post_content)), 0, 180, "…"); 
		// 填写自定义字段description时显示自定义字段的内容，否则使用文章内容前200字作为描述
		$seo['description'] = $description1 ? $description1 : $description2; 
		// 填写自定义字段keywords时显示自定义字段的内容，否则使用文章tags作为关键词
		$seo['keywords'] = get_post_meta($post -> ID, "keywords", true);
		if (empty($seo['keywords'])) {
			$tags = wp_get_post_tags($post -> ID);
			foreach ($tags as $tag) {
				$seo['keywords'] .= $tag -> name . ", ";
			} 
			$seo['keywords'] = rtrim($seo['keywords'], ', ');
		} 
	} elseif (is_category()) {
		$seo['description'] = category_description();
		$seo['keywords'] = single_cat_title('', false);
	} elseif (is_tag()) {
		$seo['description'] = tag_description();
		$seo['keywords'] = single_tag_title('', false);
	}
?>
<meta content="<?php echo $seo['description'];?>" name="description">
<meta content="<?php echo $seo['keywords'];?>" name="keywords">
<link href="<?php bloginfo('stylesheet_url');?>" media="screen" type="text/css" rel="stylesheet" />
<link href="<?php bloginfo('template_url');?>/style/highlight.css" media="screen" type="text/css" rel="stylesheet" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有文章" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 所有评论" href="<?php bloginfo('comments_rss2_url'); ?>" />
<title><?php theme_title();?></title>
<?php wp_head();?>
<script src="<?php bloginfo('template_url');?>/script/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/comments-ajax.js"></script>
</head>
<body>
<?php flush(); global $options; $options=get_option('pb_options');?>
<div id="header">
		<div class="mbox">
				<div id="tide">
						<h1><a href="<?php bloginfo('home');?>"><?php bloginfo('name');?></a><span><?php bloginfo('description');?></span></h1>
				</div>
				<div id="h_serch">
						<?php get_search_form();?>
				</div>
				<div id="navi">
						<ul>								
							 <?php wp_nav_menu(array( 'items_wrap' => '%3$s','container' => '','depth'=>1 )); ?> 							
							<div class="clear"></div>
						</ul>
				</div>
		</div>
</div>
<?php endif;?>
