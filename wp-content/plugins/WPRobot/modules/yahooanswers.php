<?php
function ma_yahooanswersrequest($keyword,$num,$yapcat) {	

	$appid = get_option('ma_yap_appkey');
	$region = get_option('ma_yap_lang');

	$keyword = urlencode($keyword);
	
    $request = "http://answers.yahooapis.com/AnswersService/V1/questionSearch?appid=".$appid."&query=".$keyword."&region=".$region."&type=resolved&start=".$num."&results=1";
    if($yapcat != "") {
		$request .= "&category_id=$yapcat";
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

function ma_getyahooanswers($keyword,$num,$yapcat) {
	
	$pxml = ma_yahooanswersrequest($keyword,$num,$yapcat);
	
	if ($pxml === False) {
		return false;
	} else {
		if (isset($pxml->Question)) {
			foreach($pxml->Question as $question) {
			
					$attrs = $question->attributes();
					$qid = $question['id']; 			

					$title = $question->Subject;
			
					$content = $question->Content;
					
					$url = $question->Link;
					
					$user = $question->UserNick;
					
					$answercount = $question->NumAnswers;
					
					$quest = array($qid,$title,$content,$url,$user,$answercount); 
					return $quest;
			}
		} else {
			return "nothing";
		}
	}	
}

function ma_yap_insertcomments($qid,$answercount,$postid) {

	$appid = get_option('ma_yap_appkey');
	$requesturl = 'http://answers.yahooapis.com/AnswersService/V1/getQuestion?appid='.$appid.'&question_id='.$qid;

	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $requesturl);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$response = curl_exec($ch);
		curl_close($ch);
	} else { 				
		$response = @file_get_contents($requesturl);
	}
    
    if ($response === False) {
    } else {
        $commentsFeed = simplexml_load_string($response);
    }	
	
	//$commentsFeed = simplexml_load_file($requesturl);    
						if($_POST['postdate']) {
							$comment_date= $_POST['postdate'];		
						} else {
							$comment_date = current_time('mysql');
						}	
		
    foreach ($commentsFeed->Question->Answers->Answer as $answer) {

				$comment_post_ID=$postid;

				list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $comment_date );	
				$comment_date = mktime($hour, $minute + rand(0, 59), $second + rand(0, 59), $today_month, $today_day, $today_year);
				$comment_date=date("Y-m-d H:i:s", $comment_date); 		
				$comment_date_gmt = $comment_date;					

				$comment_author_email="someone@domain.com";
				$comment_author=$answer->UserNick;
				$comment_author_url='';  
				$comment_content=$answer->Content;
				if (get_option('ma_ya_striplinks_a')=='yes') {$comment_content = ma_strip_selected_tags($comment_content, array('a','iframe','script'));}
				
				if (function_exists('ma_translate') && get_option('ma_trans_yapa') == 1) {$comment_content = ma_translate($comment_content);}

				$comment_type='';
				$user_ID='';
				$comment_approved = 1;
				$commentdata = compact('comment_post_ID', 'comment_date', 'comment_date_gmt', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'user_ID', 'comment_approved');
				$comment_id = wp_insert_comment( $commentdata );				
    }
}

function ma_yahooanswerspost($keyword,$cat,$num,$which,$yapcat) {
     
	// Debug
   	debug_log('- YT');
	
	$question = ma_getyahooanswers($keyword,$num,$yapcat);
	
	$title = $question[1];
	if (function_exists('ma_translate') && get_option('ma_trans_title') == 1) {$title = ma_translate($title);}					
	
	$post = get_option( 'ma_yap_template');
						// Youtube			
						$pos = strpos($post, "{video}");		
						if ($pos === false) {
						} else {
							$vid = ma_getvideo($keyword,1,0);
							if($vid[8] != "") {
								$post = str_replace("{video}", $vid[8], $post);							
							} else {	
								$post = str_replace("{video}", "", $post);								
							}							
						}	
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
						
	if (get_option('ma_ya_striplinks_q')=='yes') {$question[2] = ma_strip_selected_tags($question[2], array('a','iframe','script'));}
	$post = str_replace("{question}", $question[2], $post);							
	$post = str_replace("{keyword}", $keyword, $post);
	$post = str_replace("{url}", $question[3], $post);	
	
	$qid = $question[0];
	$answercount = $question[5];

	if($question === false) {
		return false;
	} elseif($question === "nothing") {
		return "nothing";
	} else {  
		$insert = ma_insertpost($post,$title,$cat);	  
		if ($insert == false) {return false;} else {
			if($answercount > 0) {ma_yap_insertcomments($qid,$answercount,$insert);}
			return true;
		}
	}	
}

function ma_yap_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td width="30%" scope="row">Yahoo Application ID:</td> 
				<td><input name="ma_yap_appkey" type="text" id="ma_yap_appkey" value="<?php echo get_option('ma_yap_appkey') ;?>"/>
			<a href="http://wprobot.net/documentation/#37"><b>?</b></a></td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Add "Powered by Yahoo! Answers" text to footer?</td> 
				<td><input name="ma_yap_yatos" type="checkbox" id="ma_yap_yatos" value="yes" <?php if (get_option('ma_yap_yatos')=='yes') {echo "checked";} ?>/> Yes
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Country:</td> 
				<td>
				<select name="ma_yap_lang" id="ma_yap_lang">
							<option value="us" <?php if(get_option('ma_yap_lang')=="us"){_e('selected');}?>>USA</option>
							<option value="uk" <?php if(get_option('ma_yap_lang')=="uk"){_e('selected');}?>>United Kingdom</option>								
							<option value="ca" <?php if(get_option('ma_yap_lang')=="ca"){_e('selected');}?>>Canada</option>	
							<option value="au" <?php if(get_option('ma_yap_lang')=="au"){_e('selected');}?>>Australia</option>			
							<option value="de" <?php if(get_option('ma_yap_lang')=="de"){_e('selected');}?>>Germany</option>
							<option value="fr" <?php if(get_option('ma_yap_lang')=="fr"){_e('selected');}?>>France</option>
							<option value="it" <?php if(get_option('ma_yap_lang')=="it"){_e('selected');}?>>Italy</option>	
							<option value="es" <?php if(get_option('ma_yap_lang')=="es"){_e('selected');}?>>Spain</option>		
							<option value="br" <?php if(get_option('ma_yap_lang')=="br"){_e('selected');}?>>Brazil</option>
							<option value="ar" <?php if(get_option('ma_yap_lang')=="ar"){_e('selected');}?>>Argentina</option>
							<option value="mx" <?php if(get_option('ma_yap_lang')=="mx"){_e('selected');}?>>Mexico</option>
							<option value="sg" <?php if(get_option('ma_yap_lang')=="sg"){_e('selected');}?>>Singapore</option>								
				</select>
			</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
			<textarea name="ma_yap_template" rows="2" cols="30"><?php echo get_option('ma_yap_template');?></textarea>	
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Strip All Links from...</td> 
				<td><input name="ma_ya_striplinks_q" type="checkbox" id="ma_ya_striplinks_q" value="yes" <?php if (get_option('ma_ya_striplinks_q')=='yes') {echo "checked";} ?>/> Questions<br/>
				<input name="ma_ya_striplinks_a" type="checkbox" id="ma_ya_striplinks_a" value="yes" <?php if (get_option('ma_ya_striplinks_a')=='yes') {echo "checked";} ?>/> Answers</td> 
			</tr>				
		</table>	
<?php
}

function ma_yap_showtos() {
	if (get_option( 'ma_yap_yatos') == 'yes') {
		echo '<p>Powered by Yahoo! Answers</p>';
	}
}

add_action('wp_footer', 'ma_yap_showtos'); 
?>