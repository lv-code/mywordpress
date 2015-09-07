<?php 
define('THEMENAME','WQ-Base-Mobile');
define('VERSION','1.3.2');
define('THEMEPATH',str_replace('\\','/',dirname(__FILE__)));
define('BASEPATH',str_replace('/wp-content/themes/'.THEMENAME,'',THEMEPATH));
define('SITEURL',get_bloginfo('url'));
define('SAVEPATH','/wp-content/thumbs/');
include('Mobile_Detect.php');
$detect=new Mobile_Detect;
$isMobile=($detect->isMobile()||$detect->isTablet())?true:false;
define('ISMOBILE',$isMobile);
load_theme_textdomain('pbotheme', get_template_directory() . '/languages');
// sidebar
if (function_exists('register_sidebar')) {
	register_sidebar(array('name' => 'sidebar', 'before_widget' => '<div class="cbx">', 'after_widget' => '</div></div>', 'before_title' => '<h3>', 'after_title' => '</h3><div class="ctx">',));
} 
// 自定义title
function theme_title() {
	if (is_home()) {
		bloginfo('name');
		echo " - ";
		bloginfo('description');
	} elseif (is_category()) {
		single_cat_title();
		echo " - ";
		bloginfo('name');
        echo " - ";
        bloginfo('description');
	} elseif (is_single() || is_page()) {
		single_post_title();
		echo " - ";
		bloginfo('name');
        echo " - ";
        bloginfo('description');
	} elseif (is_search()) {
		echo "搜索结果";
		echo " - ";
		bloginfo('name');
        echo " - ";
        bloginfo('description');
	} elseif (is_404()) {
		echo '页面未找到!';
	} else {
		wp_title('', true);
        echo " - ";
        bloginfo('description');
	} 
} 

// 截取字符串
function strcut($content,$length,$charset='utf-8',$add='Y'){
	if ($length && strlen($content)>$length) {		
		if ($charset!='utf-8') {
			$retstr = '';
			for ($i=0;$i<$length-2;$i++) {
				$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
			}
			return $retstr.($add=='Y' ? ' ..' : '');
		}
		return utf8_trim(substr($content,0,$length)).($add=='Y' ? ' ..' : '');
	}
	return $content;
}

function utf8_trim($str) {
	$hex = '';
	$len = strlen($str)-1;
	for ($i=$len;$i>=0;$i-=1) {
		$ch = ord($str[$i]);
		$hex .= "$ch";
		if (($ch & 128)==0 || ($ch & 192)==192) {
			return substr($str,0,$i);
		}
	}
	return $str.$hex;
}

//主题选项功能
class pbOptions{
	function getOptions() {
		$options = get_option('pb_options');
		if (!is_array($options)) {
			$options['pbo_description'] ='明子中国，专注PHP的WEB应用开发，承接网站开发，提供免费网站建设咨询。承接WORDPRESS博客主题制作，ProBlog主题发布更新官方主页。';
			$options['pbo_keywords'] = '明子中国,cnmzi.com,problog主题,wp主题,wordpress,博客,php开发,web应用,网站开发,免费建站,韶关建站';
			$options['pbo_trackcode'] = '<script type="text/javascript">
				var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
				document.write(unescape("%3Cscript src=\'" + _bdhmProtocol + "hm.baidu.com/h.js%3F2307f6b8f0e0987e4f0e3de42ff9d388\' type=\'text/javascript\'%3E%3C/script%3E"));
				</script>';
            $options['pbo_isshowtop']=1;
            $options['pbo_showtopid']=1;
            $options['pbo_maxshow']=10;
            $options['pbo_rssaddress']='http://feed.feedsky.com/mingzi';
            $options['pbo_topnavi']=1;
            $options['pbo_footnavi']=1;
            $options['pbo_toinner']=1;
            
            $options['pbo_a1show']=0;
            $options['pbo_a1num']=0;
            $options['pbo_a1code']='';
            
            $options['pbo_a2show']=0;
            $options['pbo_a2num']=0;
            $options['pbo_a2code']='';
            
            $options['pbo_a3show']=0;            
            $options['pbo_a3code']='';
            
            $options['pbo_a4show']=0;            
            $options['pbo_a4code']='';
            
            $options['pbo_a5show']=0;            
            $options['pbo_a5code']='';
            
			update_option('pb_options', $options);
		}
		return $options;
	}
	function theme_options_init(){
		if(isset($_POST['pbo_save'])) {
			$options = pbOptions::getOptions();
			$options['pbo_description']=stripslashes($_POST['pbo_description']);
			$options['pbo_keywords']=stripslashes($_POST['pbo_keywords']);
			$options['pbo_trackcode']=stripslashes($_POST['pbo_trackcode']);
            $options['pbo_isshowtop']=stripslashes($_POST['pbo_isshowtop']);
            $options['pbo_showtopid']=stripslashes($_POST['pbo_showtopid']);
            $options['pbo_maxshow']=stripslashes($_POST['pbo_maxshow']);
            $options['pbo_rssaddress']=stripslashes($_POST['pbo_rssaddress']);
            $options['pbo_topnavi']=stripslashes($_POST['pbo_topnavi']);
            $options['pbo_footnavi']=stripslashes($_POST['pbo_footnavi']);
            $options['pbo_toinner']=stripslashes($_POST['pbo_toinner']);
            
            $options['pbo_a1show']=stripslashes($_POST['pbo_a1show']);
            $options['pbo_a1num']=stripslashes($_POST['pbo_a1num']);
            $options['pbo_a1code']=stripslashes($_POST['pbo_a1code']);
            
            $options['pbo_a2show']=stripslashes($_POST['pbo_a2show']);
            $options['pbo_a2num']=stripslashes($_POST['pbo_a2num']);
            $options['pbo_a2code']=stripslashes($_POST['pbo_a2code']);
            
            $options['pbo_a3show']=stripslashes($_POST['pbo_a3show']);           
            $options['pbo_a3code']=stripslashes($_POST['pbo_a3code']);
            
            $options['pbo_a4show']=stripslashes($_POST['pbo_a4show']);            
            $options['pbo_a4code']=stripslashes($_POST['pbo_a4code']);
            
            $options['pbo_a5show']=stripslashes($_POST['pbo_a5show']);            
            $options['pbo_a5code']=stripslashes($_POST['pbo_a5code']);
            
			update_option('pb_options', $options);
            header("Location: themes.php?page=functions.php&saved=true");
		}else{
			pbOptions::getOptions();
		}
		add_theme_page("problog设置", "主题选项", 'edit_themes', basename(__FILE__), array('pbOptions', 'theme_option_page'));
	}
	function theme_option_page() {
    	$options = pbOptions::getOptions();
        include('views/setting.php');
	} 	
}

add_action('admin_menu', array('pbOptions', 'theme_options_init'));

// 分页代码
function par_pagenavi($query_string){
	global $posts_per_page, $paged;
	$my_query = new WP_Query($query_string ."&posts_per_page=-1");
	$total_posts = $my_query->post_count;
	if(empty($paged))$paged = 1;
	$prev = $paged - 1;
	$next = $paged + 1;
	$range = 3; // only edit this if you want to show more page-links
	$showitems = ($range * 2)+1;
	
	$pages = ceil($total_posts/$posts_per_page);
	if(1 != $pages){
	echo "<div class='pagination'>";
		echo '<span class="pages">第 ' . $paged . '页 , 共 ' . $pages . ' 页</span>';
		echo ($paged > 2 && $paged+$range+1 > $pages && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>最前</a>":"";
		echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>上一页</a>":"";	
		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
			}
		}	
		echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>下一页</a>" :"";
		echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>最后</a>":"";
		echo "</div>\n";
	}
} 
// 分页代码
function mobile_par_pagenavi($query_string){
	global $posts_per_page, $paged;
	$my_query = new WP_Query($query_string ."&posts_per_page=-1");
	$total_posts = $my_query->post_count;
	if(empty($paged))$paged = 1;
	$prev = $paged - 1;
	$next = $paged + 1;
	$range = 3; // only edit this if you want to show more page-links
	$showitems = ($range * 2)+1;	
	$pages = ceil($total_posts/$posts_per_page);
	
	echo '<a href="javascript:;" data-role="button" data-icon="info">第'.$paged.'页</a>';
	if(1 != $pages){	
		echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."' data-transition=\"slidedown\" data-icon=\"arrow-l\" data-role=\"button\">上一页</a>":"";			
		echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."' data-transition=\"flow\" data-icon=\"arrow-r\" data-role=\"button\">下一页</a>" :"";		
	}
	
} 

//评论代码
function theme_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if (!$commentcount) {
		$page = get_query_var('cpage')-1;
		$cpp = get_option('comments_per_page');
		$commentcount = $cpp * $page;
	} 
    include('views/comments.php');
} 

/**------------------------------------view count begin------------------------------------------------**/
//function to get view count
function getPostViews($postID,$mode='show',$isRelated=false){
	$count_key = 'views';
	$count = get_post_meta($postID, $count_key, true);
	if(''==$count){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');		
	}
	if($isRelated){
		$result = $count;
	}else{
		if(0==$count){
			$result= "此文无人问津，去看看";
		}else{
			$result= '此文被围观<b>'.$count.'</b>次';
		}	
	}
	if($mode='show'){
		echo $result;
	}else{
		return $result;
	}	
}

// function to count views.
function setPostViews($postID) {
	$count_key = 'views';
	$count = get_post_meta($postID, $count_key, true);
	if(''==$count){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
} 

add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);

//function to add admin page view column
function posts_column_views($defaults){
	$defaults['post_views'] = __('Views');
	return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
		echo getPostViews(get_the_ID(),true);
	}
} 
/**------------------------------------view count end------------------------------------------------**/
//热门文章排行
function the_most_views($days=0,$n){
	global $wpdb, $post;
	if(0!=$days){
		$limit_date = current_time('timestamp') - ($days*86400);    
		$limit_date = date("Y-m-d H:i:s",$limit_date); 
		$most_viewed = $wpdb->get_results("SELECT ID,post_title,post_date,post_status,post_id,meta_key,meta_value FROM $wpdb->posts,$wpdb->postmeta where $wpdb->posts.ID=$wpdb->postmeta.post_id AND post_date < '".current_time('mysql')."' AND post_date > '".$limit_date."' AND post_status = 'publish' AND $wpdb->postmeta.meta_key='views' ORDER BY CAST($wpdb->postmeta.meta_value as SIGNED) DESC LIMIT $n");  	
	}else{		
		$most_viewed = $wpdb->get_results("SELECT ID,post_title,post_date,post_status,post_id,meta_key,meta_value FROM $wpdb->posts,$wpdb->postmeta where $wpdb->postmeta.meta_key='views' AND $wpdb->posts.ID=$wpdb->postmeta.post_id AND $wpdb->posts.post_status = 'publish' ORDER BY CAST($wpdb->postmeta.meta_value as SIGNED) DESC LIMIT $n"); 
	}
	if($most_viewed){
		foreach ($most_viewed as $views) {
			echo '<li>';			
			echo '<a title="'.strcut(strip_tags(apply_filters('the_content',$views->post_content)),20).'" href="'. get_permalink($views->ID).'" rel="bookmark">'.$views->post_title.'</a>';
			echo '</li>';
		}
	}else{
		echo '<li>当前设置没有文章可以显示。</li>';
	}  
	
}

/*remove_post_revision_and_autosave_wp3*/
remove_action('pre_post_update', 'wp_save_post_revision' );
function disable_autosave() {
	wp_deregister_script('autosave');
}

/**-------------------------------------------------------------------------------**/
function get_thumb($dir,$post_content,$post_id){
	//print_r($post_content);
	//http://www.waaqi.com/wp-content/uploads/2012/08/20120806170346-320×230.png
	//http://www.ithmz.com/wp-content/uploads/2012/10/2719_201107291130541MXMb.new_.jpg	
	$postimage=catch_first_image($post_content);	
	$id=($post_id+8) % 9;
	$image=SITEURL.'/wp-content/themes/'.THEMENAME.'/thumbs/'.$dir.'/'.$id.'.png';
	if($postimage){	
		$imagename=$sourname=end(explode('/',$postimage));
		$exname=end(explode('.',$imagename));
		if($exname=='jpg' || $exname=='jpeg' || $exname=='gif' || $exname=='png'){
			//$filename=explode('-',$sourname);
			$filename=str_replace('-'.end(explode('-',$sourname)), '', $sourname);
			if(count($filename)>1){			
				$imagename=$filename.'.'.$exname;
			}
				
			if(file_exists(BASEPATH.SAVEPATH.$dir.'/'.$imagename)){
				$image=SITEURL.SAVEPATH.$dir.'/'.$imagename;
			}else{
				list($w,$h)=explode('_',$dir);
				if(makethumb($postimage,$imagename,$w,$h)){
					$image=SITEURL.SAVEPATH.$dir.'/'.$imagename;
				}
			}
		}
	}
	return $image;
}

function catch_first_image($post_content) {
	
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
	
	return empty($matches [1] [0])?false:$matches [1] [0];
}

function makethumb($srcImage,$imagename,$dst_w,$dst_h){
	$fileImage=str_replace(SITEURL,BASEPATH,$srcImage);
	//list($name,$ex)=explode('.',$imagename);
	$ex=end(explode('.',$imagename));
	$name=str_replace('.'.$ex, '', $imagename);
		
	list($src_w,$src_h)=getimagesize($fileImage);  // 获取原图尺寸
	
	$dst_scale = $dst_h/$dst_w; //目标图像长宽比
	$src_scale = $src_h/$src_w; // 原图长宽比

	if($src_scale>=$dst_scale){  // 过高
		$w = intval($src_w);
		$h = intval($dst_scale*$w);

		$x = 0;
		$y = ($src_h - $h)/3;
	}
	else{ // 过宽
		$h = intval($src_h);
		$w = intval($h/$dst_scale);

		$x = ($src_w - $w)/2;
		$y = 0;
	}
	
	$funcex=($ex=='jpg')?'jpeg':$ex;	
	$createfunc='imagecreatefrom'.$funcex;
	$savefunc='image'.$funcex;

	// 剪裁
	$source=$createfunc($srcImage);
	$croped=imagecreatetruecolor($w, $h);
	imagecopy($croped,$source,0,0,$x,$y,$src_w,$src_h);

	// 缩放
	$scale = $dst_w/$w;
	$target = imagecreatetruecolor($dst_w, $dst_h);
	$final_w = intval($w*$scale);
	$final_h = intval($h*$scale);
	imagecopyresampled($target,$croped,0,0,0,0,$final_w,$final_h,$w,$h);
	$result=false;
	if(!is_dir(SAVEPATH.$dst_w.'_'.$dst_h.'/')){
		if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			//win主机创建目录从磁盘根目录算起
			makeDirectory(BASEPATH.SAVEPATH.$dst_w.'_'.$dst_h.'/');
		}else{
			//linux创建从网站根目录算起
			makeDirectory(SAVEPATH.$dst_w.'_'.$dst_h.'/');
		}		
	}
	if(is_dir(BASEPATH.SAVEPATH.$dst_w.'_'.$dst_h.'/')){
		if(@$savefunc($target, BASEPATH.SAVEPATH.$dst_w.'_'.$dst_h.'/'.$imagename)){
			$result=true;
		}
	}
	imagedestroy($target);
	return $result;
}
//建立目录
function makeDirectory($directoryName) {		
	$directoryName = str_replace ( "\\", "/", $directoryName );		
	$dirNames = explode ( '/', $directoryName );		
	$total = count ( $dirNames );		
	$temp = '';
	$err=false;		
	for($i = 0; $i < $total; $i ++) {
		if(!empty($dirNames [$i])){
			$temp .= $dirNames [$i] . '/';			
			if (! is_dir ( $temp )) {				
				$oldmask = umask ( 0 );				
				if (! mkdir ( $temp, 0755 )) {
					echo 'Can not create '.$temp;
					$err=true;														
				}				
				umask ( $oldmask );			
			}
		}
	}	
	return $err?false:true;	
}
/*----------------------------------------------------------------------------*/
?>
