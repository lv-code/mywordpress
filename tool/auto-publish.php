<?php
set_time_limit(0);
include(__DIR__.'/../wp-load.php');

$n = rand(6,12);
$args = array('post_status'=>'draft','numberposts'=>$n);
$postArr = get_posts($args);
//echo '<pre>';var_dump($postArr);die;
// select ID from wp_POSTS where post_status='draft' limit 6;
// update from wp_POSTS set post_status='public' where ID in ();

if( !is_array($postArr) ) die('please check the $arr, is not Array type');
foreach($postArr as $k=>$obj) {

	$my_post = array(
			'ID' => $obj->ID,
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			);
	if( $my_post['ID']>0 && $my_post['ID']!=1) {
		//var_export($my_post);die;
		// update the post into the database
		$res = wp_update_post( $my_post );
		//$res = wp_insert_post( $my_post );
		var_dump($res);
	}
}
