<?php
error_reporting(E_ALL);
set_time_limit(0);
include('../wp-load.php');
/* ---------------------------------------------
?data=07938.com-mingrendushu&cate=296
 --------------------------------------------- */
//ToDo
$data = $_GET['data'];
$cate = $_GET['cate'];
$isOne = $_GET['isone'];
if( empty($data) || empty($cate) ) die('params error');
$info = array('data'=>'./data/'.$data.'.json','cate'=>$cate,'isOne'=>$isOne);
$jsonStr = file_get_contents($info['data']);
//echo print_r($jsonStr, true);
$arrArt = json_decode($jsonStr, true);
//var_dump($arrArt);die;
if( !is_array($arrArt) ) die('please check the $arr, is not Array type');
$imgUrl = 'http://img.upersmile.com/';
foreach($arrArt as $k=>$arr){
	$dateRandom = generateDateRandom();
	//var_dump($dateRandom);continue;
	//var_dump($arr);die;
	// Create post object
	$title = $arr['art_title'];
	$keyw = $arr['art_keyw'];
	if(strpos($keyw, '微语录')>0){
		$keyw = str_replace('微语录','幸福唯美文字,幸福唯美短语', $keyw);
	}else{
		$keyw .= ',幸福唯美文字,幸福唯美短语';
	}
	$desc = $arr['art_desc'];
	$content = strip_tags($arr['art_content'],'<p><br>');
	$img = $arr['images'][0]['path'];
	if(!empty($img)){
		$img_tag = '<br/><img src="'.$imgUrl.'cate-'.$info['cate'].'/'.$img.'" title="'.$title.'" alt="'.$title.','.$keyw.'"/>';
		$content = $content.$img_tag;
	}
	//var_dump($img, $img_tag);die;
	$my_post = array(
			'post_title'    => $title,
			'post_content'  => $content,
			'post_date'     => $dateRandom,
			//'post_date_gmt'     => $dateRandom,
			'post_status'   => 'publish',
			//'post_status'   => 'draft',
			'post_author'   => 1 ,//小志 励志
			'post_category' => array($info['cate']),
			'tags_input' => $keyw,
			'post_excerpt' => $desc,
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
			update_post_meta($res, 'keywords', $keyw );
		}
		if(!isset($info['isOne']) || $info['isOne']=1){
			var_dump($res);die;
		}
	}
}

function generateDateRandom(){
	$data1 = mktime(0,0,0,1,9,2015);
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
