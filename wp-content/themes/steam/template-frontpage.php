<?php
#Template Name: Front Page

get_header(); #show header

#loop through content panels
$content = false;
for($i = 1; $i <= 11; $i++ ) {
	$var = 'front_' . $i;
	$setting = it_get_setting($var);
	if(!empty($setting)) {
		$content = true;
		it_get_template_part($setting);
	}
}
#display default if nothing has been shown
if(!$content) {
	it_get_template_part('boxes');
}
?>

<?php get_footer(); #show footer ?>