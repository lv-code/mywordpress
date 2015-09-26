<?php get_header(); # show header ?>

<?php 
$content = false;
#loop through content panels
for($i = 1; $i <= 11; $i++ ) {
	$var = 'page_' . $i;
	$setting = it_get_setting($var);
	if(!empty($setting)) {
		if($setting=='post-loop') $setting = 'page-content';
		$content = true;
		it_get_template_part($setting);
	}
}
#display default if nothing has been shown
if(!$content) {
	it_get_template_part('page-content');
}
?>

<?php get_footer(); # show footer ?>