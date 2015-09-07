<?php
function ma_youtuberequest($keyword,$num) {	
	$num++;
	$sort = get_option('ma_yt_sort');
	$safesearch = get_option('ma_yt_safe');
	$lang = get_option("ma_yt_lang");
    if($lang == "zh-cn") {$lang = "zh-Hans";}
    if($lang == "zh-tw") {$lang = "zh-Hant";}	
	$keyword = '"'.$keyword.'"';
	$keyword = urlencode($keyword);
    $request = "http://gdata.youtube.com/feeds/api/videos?q=$keyword&orderby=$sort&start-index=$num&max-results=1&format=5&safeSearch=$safesearch&v=2";
	if($lang != "") {
	$request .= "&lr=$lang";
	}
	
	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $request);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$response = curl_exec($ch);
		curl_close($ch);
	} else { 				
		$response = @file_get_contents($request);
	}
    
    if ($response === False) {
        return False;
    } else {
        $pxml = simplexml_load_string($response);
        if ($pxml === False) {
            return False;
        } else {
            return $pxml;
        }
    }
}

function ma_getvideo($keyword,$h,$num) {
	
	if($h == 1) {$num = rand(0,50);}
	$pxml = ma_youtuberequest($keyword,$num);
	
	if ($pxml === False) {
		return false;
	} else {
		if (isset($pxml->entry)) {
			foreach($pxml->entry as $entry) {
				
				    $media = $entry->children('http://search.yahoo.com/mrss/');		
					$title = $media->group->title;
					$description = $media->group->description;	
				
					$attrs = $media->group->thumbnail[0]->attributes();
					$thumbnail = "<img src=".$attrs['url']." />"; 
					$thumbnailurl = $attrs['url'];
					
					$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
					$attrs = $yt->statistics->attributes();
					$viewCount = $attrs['viewCount']; 
					
					$yt = $media->children('http://gdata.youtube.com/schemas/2007');
					$videoid = $yt->videoid;
							
					$gd = $entry->children('http://schemas.google.com/g/2005'); 
					if ($gd->rating) {
						$attrs = $gd->rating->attributes();
						$rating = round($attrs['average'], 2); 
					} else {
						$rating = 0; 
					} 
					
					$attrs = $media->group->player->attributes();
					$playerUrl = $attrs['url'];

					$gd = $entry->children('http://schemas.google.com/g/2005');
					if ($gd->comments->feedLink) { 
						$attrs = $gd->comments->feedLink->attributes();
						$commentsUrl = $attrs['href']; 
						$commentsCount = $attrs['countHint']; 
					}
					 // 425 // 355
					$video ='
					<object width="'.get_option('ma_yt_width').'" height="'.get_option('ma_yt_height').'">
					<param name="movie" value="http://www.youtube.com/v/'.$videoid.'?fs=1"></param>
					<param name="allowFullScreen" value="true"></param>
					<embed src="http://www.youtube.com/v/'.$videoid.'?fs=1" type="application/x-shockwave-flash" width="'.get_option('ma_yt_width').'" height="'.get_option('ma_yt_height').'" allowfullscreen="true"></embed>
					</object>';
					
					$vid = array($title,$description,$thumbnail,$viewCount,$rating,$playerUrl,$commentsUrl,$commentsCount,$video,$thumbnailurl); 
					return $vid;

			}
		} else {
			return "nothing";
		}
	}	
}

function ma_yt_insertcomments($commenturl,$commentcount,$id) {

	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $commenturl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$response = curl_exec($ch);
		curl_close($ch);
	} else { 				
		$response = @file_get_contents($commenturl);
	}
    
    if ($response === False) {
    } else {
        $commentsFeed = simplexml_load_string($response);
    }

	//$commentsFeed = simplexml_load_file($commenturl);    
						if($_POST['postdate']) {
							$comment_date= $_POST['postdate'];		
						} else {
							$comment_date = current_time('mysql');
						}	
		
    foreach ($commentsFeed->entry as $comment) {

				$comment_post_ID=$id;

				list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $comment_date );	
				$comment_date = mktime($hour, $minute + rand(0, 59), $second + rand(0, 59), $today_month, $today_day, $today_year);
				$comment_date=date("Y-m-d H:i:s", $comment_date); 		
				$comment_date_gmt = $comment_date;					

				$comment_author_email="someone@domain.com";
				$comment_author=$comment->author->name;
				$comment_author_url='';  
				$comment_content=$comment->content;
				if (get_option('ma_yt_striplinks_comm')=='yes') {$comment_content = ma_strip_selected_tags($comment_content, array('a','iframe','script'));}
				if (function_exists('ma_translate') && get_option('ma_trans_ytcom') == 1) {$comment_content = ma_translate($comment_content);}

				$comment_type='';
				$user_ID='';
				$comment_approved = 1;
				$commentdata = compact('comment_post_ID', 'comment_date', 'comment_date_gmt', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'user_ID', 'comment_approved');
				$comment_id = wp_insert_comment( $commentdata );				
    }
}

function ma_youtubepost($keyword,$cat,$num,$which) {
   global $wpdb, $ma_dbtable;
   
	// Debug
   	debug_log('- YT');
	
	$video = ma_getvideo($keyword,0,$num);
	
	$title = $video[0];
	if (get_option('ma_yt_striplinks_desc')=='yes') {$video[1] = ma_strip_selected_tags($video[1], array('a','iframe','script'));}
	
	$post = get_option( 'ma_yt_template');
	
						// Flickr
						preg_match('#\{image(.*)\}#iU', $post, $matches);
						if ($matches[0] == false) {
						} else {
							if($matches[1] != false ) {$imgkeyword = substr($matches[1], 1);} else {$imgkeyword = $keyword;}
					
							$img = ma_getimage($imgkeyword,1,0);
							if($img[4] != "" && $img[4] != "i") {
								$image = '<img style="float:left;margin: 0 20px 10px 0;" src="'.$img[4].'" width="'.get_option("ma_fl_twidth").'" />';
								$post = str_replace("{date}", $img[1], $post);
								$post = str_replace("{owner}", $img[2] , $post);
								$post = str_replace("{largeimage}", $img[6], $post);
								$post = str_replace($matches[0], $image, $post);
								$fllink = 'http://www.flickr.com/photos/'.$img[7].'/'.$img[8];
								$post = str_replace("{imageurl}", $fllink, $post);
							} else {
								$post = str_replace("{date}", "", $post);
								$post = str_replace("{owner}", "", $post);
								$post = str_replace("{largeimage}","", $post);								
								$post = str_replace($matches[0], "", $post);
								$post = str_replace("{imageurl}", "", $post);								
							}
						}
						
						// eBay
						preg_match('#\{auction(.*)\}#iU', $post, $matches);
						if ($matches[0] == false) {
						} else {
							if($matches[1] != false ) {$aucnum = substr($matches[1], 1);} else {$aucnum = 1;}
							$post = str_replace($matches[0], '[eba kw="'.$keyword.'" num="'.$aucnum.'" ebcat=""]', $post);						
						}
			
 	$post = str_replace("{description}", $video[1], $post);
 	$post = str_replace("{thumbnail}", $video[2], $post);
	$post = str_replace("{viewcount}", $video[3], $post);
	$post = str_replace("{rating}", $video[4], $post);	
	$post = str_replace("{keyword}", $keyword, $post);
	$post = str_replace("{video}", $video[8], $post);
	$commenturl = $video[6];
	$commentcount = $video[7];
	
	if($video === false) {
		return false;
	} elseif($video === "nothing") {
		return "nothing";
	} else {  
		$insert = ma_insertpost($post,$title,$cat);	  
		if ($insert == false) {return false;} else {
		
			// Custom Field
			// add_post_meta($insert, 'custom_field_name', $video[9]);
	
			if($commentcount > 0 && get_option('ma_yt_comments')=="yes") {ma_yt_insertcomments($commenturl,$commentcount,$insert);}
			return true;
		}
	}	
}

function ma_yt_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td width="30%" scope="row">Language:</td> 
				<td>
				<select name="ma_yt_lang" id="ma_yt_lang">
							<option value="" <?php if(get_option('ma_yt_lang')==""){_e('selected');}?>>Any Language</option>
							<option value="ar" <?php if(get_option('ma_yt_lang')=="ar"){_e('selected');}?>>Arabic</option>
							<option value="bg" <?php if(get_option('ma_yt_lang')=="bg"){_e('selected');}?>>Bulgarian</option>
							<option value="ca" <?php if(get_option('ma_yt_lang')=="ca"){_e('selected');}?>>Catalan</option>
							<option value="zh-cn" <?php if(get_option('ma_yt_lang')=="zh-cn"){_e('selected');}?>>Chinese (Simplified)</option>
							<option value="zh-tw" <?php if(get_option('ma_yt_lang')=="zh-tw"){_e('selected');}?>>Chinese (Traditional)</option>
							<option value="hr" <?php if(get_option('ma_yt_lang')=="hr"){_e('selected');}?>>Croatian</option>
							<option value="cs" <?php if(get_option('ma_yt_lang')=="cs"){_e('selected');}?>>Czech</option>
							<option value="da" <?php if(get_option('ma_yt_lang')=="da"){_e('selected');}?>>Danish</option>
							<option value="nl" <?php if(get_option('ma_yt_lang')=="nl"){_e('selected');}?>>Dutch</option>
							<option value="en" <?php if(get_option('ma_yt_lang')=="en"){_e('selected');}?>>English</option>
							<option value="et" <?php if(get_option('ma_yt_lang')=="et"){_e('selected');}?>>Estonian</option>
							<option value="fi" <?php if(get_option('ma_yt_lang')=="fi"){_e('selected');}?>>Finnish</option>
							<option value="fr" <?php if(get_option('ma_yt_lang')=="fr"){_e('selected');}?>>French</option>
							<option value="de" <?php if(get_option('ma_yt_lang')=="de"){_e('selected');}?>>German</option>
							<option value="er" <?php if(get_option('ma_yt_lang')=="er"){_e('selected');}?>>Greek</option>
							<option value="iw" <?php if(get_option('ma_yt_lang')=="iw"){_e('selected');}?>>Hebrew</option>
							<option value="hu" <?php if(get_option('ma_yt_lang')=="hu"){_e('selected');}?>>Hungarian</option>
							<option value="is" <?php if(get_option('ma_yt_lang')=="is"){_e('selected');}?>>Icelandic</option>
							<option value="it" <?php if(get_option('ma_yt_lang')=="it"){_e('selected');}?>>Italian</option>
							<option value="ja" <?php if(get_option('ma_yt_lang')=="ja"){_e('selected');}?>>Japanese</option>
							<option value="ko" <?php if(get_option('ma_yt_lang')=="ko"){_e('selected');}?>>Korean</option>
							<option value="lv" <?php if(get_option('ma_yt_lang')=="lv"){_e('selected');}?>>Latvian</option>
							<option value="lt" <?php if(get_option('ma_yt_lang')=="lt"){_e('selected');}?>>Lithuanian</option>
							<option value="no" <?php if(get_option('ma_yt_lang')=="no"){_e('selected');}?>>Norwegian</option>
							<option value="pl" <?php if(get_option('ma_yt_lang')=="pl"){_e('selected');}?>>Polish</option>
							<option value="pt" <?php if(get_option('ma_yt_lang')=="pt"){_e('selected');}?>>Portuguese</option>
							<option value="ro" <?php if(get_option('ma_yt_lang')=="ro"){_e('selected');}?>>Romanian</option>
							<option value="ru" <?php if(get_option('ma_yt_lang')=="ru"){_e('selected');}?>>Russian</option>
							<option value="sr" <?php if(get_option('ma_yt_lang')=="sr"){_e('selected');}?>>Serbian</option>
							<option value="sk" <?php if(get_option('ma_yt_lang')=="sk"){_e('selected');}?>>Slovak</option>
							<option value="sl" <?php if(get_option('ma_yt_lang')=="sl"){_e('selected');}?>>Slovenian</option>
							<option value="es" <?php if(get_option('ma_yt_lang')=="es"){_e('selected');}?>>Spanish</option>
							<option value="sv" <?php if(get_option('ma_yt_lang')=="sv"){_e('selected');}?>>Swedish</option>
							<option value="tr" <?php if(get_option('ma_yt_lang')=="tr"){_e('selected');}?>>Turkish</option>									
				</select>
			</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Safe Search:</td> 
				<td>
				<select name="ma_yt_safe" id="ma_yt_safe">
							<option value="none" <?php if(get_option('ma_yt_safe')=="none"){_e('selected');}?>>None</option>
							<option value="moderate" <?php if(get_option('ma_yt_safe')=="moderate"){_e('selected');}?>>Moderate</option>
							<option value="strict" <?php if(get_option('ma_yt_safe')=="strict"){_e('selected');}?>>Strict</option>
				</select>
			</td> 
			</tr>	
			
			<tr valign="top"> 
				<td width="30%" scope="row">Sort Videos by:</td> 
				<td>
				<select name="ma_yt_sort" id="ma_yt_sort">
							<option value="relevance" <?php if(get_option('ma_yt_sort')=="relevance"){_e('selected');}?>>Relevance</option>
							<option value="viewCount" <?php if(get_option('ma_yt_sort')=="viewCount"){_e('selected');}?>>View Count</option>
							<option value="rating" <?php if(get_option('ma_yt_sort')=="rating"){_e('selected');}?>>Rating</option>
							<option value="published" <?php if(get_option('ma_yt_sort')=="published"){_e('selected');}?>>Date Published</option>
				</select>
			</td> 
			</tr>				
			
			<tr valign="top"> 
				<td width="30%" scope="row">Video Size:</td> 
				<td>
				<input id="ma_yt_width" size="7" value="<?php echo get_option('ma_yt_width'); ?>" name="ma_yt_width"/> x <input id="ma_yt_height" size="7" value="<?php echo get_option('ma_yt_height'); ?>" name="ma_yt_height"/>
				</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
			<textarea name="ma_yt_template" rows="2" cols="30"><?php echo get_option('ma_yt_template');?></textarea>	
			</td> 
			</tr>
			<tr valign="top"> 
				<td width="30%" scope="row">Post Comments?</td> 
				<td><input name="ma_yt_comments" type="checkbox" id="ma_yt_comments" value="yes" <?php if (get_option('ma_yt_comments')=='yes') {echo "checked";} ?>/> Yes
				</td> 
			</tr>
			<tr valign="top"> 
				<td width="30%" scope="row">Strip All Links from...</td> 
				<td><input name="ma_yt_striplinks_desc" type="checkbox" id="ma_yt_striplinks_desc" value="yes" <?php if (get_option('ma_yt_striplinks_desc')=='yes') {echo "checked";} ?>/> Video Description<br/>
				<input name="ma_yt_striplinks_comm" type="checkbox" id="ma_yt_striplinks_comm" value="yes" <?php if (get_option('ma_yt_striplinks_comm')=='yes') {echo "checked";} ?>/> Comments</td> 
			</tr>				
		</table>
<?php
}
?>