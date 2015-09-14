<?php
error_reporting(E_ALL);
set_time_limit(0);
include('../wp-load.php');

$jsonFile = '/tmp/foodwang-foodsafe.json';
//$jsonFile = './data/jingdianxiaohua-1-output.json';
//$jsonFile = './data/1.json';
//$jsonFile = './data/jingdianxiaohua-1-output.json';
$jsonStr = file_get_contents($jsonFile);
//echo print_r($jsonStr, true);
$arrArt = json_decode($jsonStr, true);
//var_dump($arr);
if( !is_array($arrArt) ) die('please check the $arr, is not Array type');
foreach($arrArt as $k=>$arr){
	$dateRandom = generateDateRandom();
	//var_dump($dateRandom);continue;
	// Create post object
	$my_post = array(
			'post_title'    => $arr['art_title'][0],
			'post_content'  => $arr['art_content'][0],
			'post_date'     => $dateRandom,
			//'post_date_gmt'     => $dateRandom,
			'post_status'   => 'draft',
			'post_author'   => 2 ,//健身达人
			'post_category' => array(13,14),
			//'post_category' => array(5),
			'tags_input' => $arr['art_keyw'][0],
			'post_excerpt' => $arr['art_desc'][0],
			);
	if(empty($my_post['post_title']) || empty($my_post['post_content'])) continue;
	//去重
	$one = ifHaveOne($my_post['post_title']);
	if( empty($one) ){
		//var_dump($one, $my_post);die;
		// Insert the post into the database
		$res = wp_insert_post( $my_post, true );
		var_dump($res);die;
	}
}

function generateDateRandom(){
	$data1 = mktime(0,0,0,1,1,2014);
	//$data2 = mktime(0,0,0,1,8,2015);
	$data2 = time();
	$rand_time = rand($data1,$data2);
	return date("Y-m-d H:i:s",$rand_time);
}

function ifHaveOne($title){
	$args = array('post_title'=>$title);
	//return get_posts($args);
	//$title=  '让你看的吐血的搞笑QQ聊天记录';
	global $wpdb;
	$rw = $wpdb->get_row( $wpdb->prepare("select * from wp_posts where post_title='%s'", $title));
	//echo $rw->ID;die;
	return $rw->ID;
	//return get_page_by_title($title);
}
