<?php
error_reporting(E_ALL);
set_time_limit(0);
include('../wp-load.php');
/* ---------------------------------------------
?data=chengyu.t086.com-gushi&cate=6
?data=07938.com-mingrendushu&cate=296
http://121.42.195.181:8080/tool/my-wp-json-import.php?data=07938.com-kexuejiagushi&cate=301
 --------------------------------------------- */
//ToDo
$data = $_GET['data'];
$cate = $_GET['cate'];
$isOne = $_GET['isone'];
if( empty($data) || empty($cate) ) die('params error');
$info = array('data'=>'./data/'.$data.'.json','cate'=>$cate,'isOne'=>$isOne);
//$info = array('data'=>'./data/07938-yisuoyuyan.json','cate'=>9,'isOne'=>1);
//$info = array('data'=>'./data/gsdaquan-lafengdanyuyan.json','cate'=>10,'isOne'=>1);
//$info = array('data'=>'./data/gsdaquan-zhongguoyuyan.json','cate'=>286,'isOne'=>1);
//$info = './data/gsdaquan-lafengdanyuyan.json';
//$info = './data/lz13-1.json';
//$info = './data/jingdianxiaohua-1-output.json';
//$info = './data/1.json';
//$info = './data/jingdianxiaohua-1-output.json';
$jsonStr = file_get_contents($info['data']);
//echo print_r($jsonStr, true);
$arrArt = json_decode($jsonStr, true);
//var_dump($arrArt);die;
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
			'post_status'   => 'publish',
			//'post_status'   => 'draft',
			//'post_author'   => 2 ,//健身达人
			'post_author'   => 1 ,//小志 励志
			'post_category' => array($info['cate']),
			//'post_category' => array(13,14), //健康
			//'post_category' => array(5),
			'tags_input' => $arr['art_keyw'][0],
			'post_excerpt' => $arr['art_desc'][0],
			);
	if(mb_strlen($my_post['tags_input'])>8) unset($my_post['tags_input']);
	if(empty($my_post['post_title']) || empty($my_post['post_content'])) continue;
	//去重
	$one = ifHaveOne($my_post['post_title']);
	if( empty($one) ){
		//var_dump($one, $my_post);die;
		// Insert the post into the database
		$res = wp_insert_post( $my_post, true );
		if(0<(int)$res){
			update_post_meta($res, 'keywords', $arr['art_keyw'][0] );
		}
		if(!isset($info['isOne']) || $info['isOne']=1){
			var_dump($res);die;
		}
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
