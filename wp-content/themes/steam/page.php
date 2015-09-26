<?php get_header(); # show header

#determine if this page is connected to a minisite
$minisite = it_get_minisite_by_meta($post->ID);

$content = false;
#loop through content panels
for($i = 1; $i <= 11; $i++ ) {
	#if this is a minisite front page use minisite page builder
	if($minisite) {
		$var = 'front_' . $i;
		$setting = $minisite->$var;		
	#otherwise use page builder from normal theme options
	} else {
		$var = 'page_' . $i;
		$setting = it_get_setting($var);
	}
	#display the content panel
	if(!empty($setting)) {
		if($setting=='post-loop' && !$minisite) $setting = 'page-content';
		$content = true;
		it_get_template_part($setting);
	}
}
#display default if nothing has been shown
if(!$content) {
	it_get_template_part('page-content');
}

get_footer(); # show footer ?>