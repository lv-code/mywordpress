<?php

function ma_flickrrequest($keyword) {
	$apikey = get_option('ma_fl_apikey');		
	$cont = get_option('ma_fl_content');
	$sort = get_option('ma_fl_sort');
	$license = get_option('ma_fl_license');
	
	$keyword = urlencode($keyword);
	$keyword = '"'.$keyword.'"';
    $request = "http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=$apikey&text=$keyword&sort=$sort&content_type=$cont&license=$license&extras=date_taken%2C+owner_name%2C+icon_server%2C+geo%2C+tags%2C+machine_tags%2C+media%2C+path_alias%2C+url_sq%2C+url_t%2C+url_s%2C+url_m%2C+url_o";
	$request .= "&per_page=100&page=1";
	
	//http://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=7903156d4751dd9bc6b85583276ab893&text=sun&license=4&extras=url_o&auth_token=72157622331352790-ae382e28b5b223b9&api_sig=0bb05bc97bc7b555b53dace958dfb30f
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
        } else {//echo "<pre>"; print_r($pxml);echo "</pre>";
            return $pxml;
        }
    }
}

function ma_getimage($keyword,$h,$num) {
	$pxml = ma_flickrrequest($keyword);

	if($h == 1) {
		$cit = 0;
		if ($pxml === False) {	
		} else {
			if (isset($pxml->photos->photo)) {
				foreach($pxml->photos->photo as $photo) {
				$cit++;
				}
			}
		}
		if($cit == 0) {$cit = 10;}
		$sk = rand(0,$cit);
	} elseif($h == 0) {$sk = (int)$num;}
	
	if ($pxml === False) {
		return false;
	} else {
		if (isset($pxml->photos->photo)) {
			$i = 0;	
			foreach($pxml->photos->photo as $photo) {
				if($i == $sk) {
					$title = $photo['title'];
					$date = $photo['datetaken'];	
					$owner = $photo['ownername'];
					$urlt = $photo['url_t'];
					$urls = $photo['url_s'];
					$urlm = $photo['url_m'];
					$urlo = $photo['url_o'];
					
					$ownerid = $photo['owner'];
					$photoid = $photo['id'];
					$img = array($title,$date,$owner,$urlt,$urls,$urlm,$urlo,$ownerid,$photoid); 
					return $img;
				}
				$i++;
			}
		} else {
			return "nothing";
		}
	}	
}

function ma_flickrpost($keyword,$cat,$num,$which) {
	global $wpdb, $ma_dbtable;
   
	$image = ma_getimage($keyword,0,$num);
	
	$width = get_option("ma_fl_width");
	
	if(get_option("ma_fl_size") == "small") {
		$img = '<img alt="'.$keyword.'" src="'.$image[4].'" width="'.$width.'" /><br/>';
	} elseif(get_option("ma_fl_size") == "med") {
		$img = '<img alt="'.$keyword.'" src="'.$image[5].'" width="'.$width.'" /><br/>';
	} else {
		$img = '<img alt="'.$keyword.'" src="'.$image[6].'" width="'.$width.'" /><br/>';
	}
	
	$link = 'http://www.flickr.com/photos/'.$image[7].'/'.$image[8];
	
	$title = $image[0];
	$post = get_option( 'ma_fl_template');
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
						// eBay
						preg_match('#\{auction(.*)\}#iU', $post, $matches);
						if ($matches[0] == false) {
						} else {
							if($matches[1] != false ) {$aucnum = substr($matches[1], 1);} else {$aucnum = 1;}
							$post = str_replace($matches[0], '[eba kw="'.$keyword.'" num="'.$aucnum.'" ebcat=""]', $post);						
						}	
 	$post = str_replace("{image}", $img, $post);	
 	$post = str_replace("{date}", $image[1], $post);
 	$post = str_replace("{owner}", $image[2], $post);
	$post = str_replace("{url}", $link, $post);
	$post = str_replace("{keyword}", $keyword, $post);
	
	if($image === false) {
		return false;
	} elseif($image === "nothing") {
		return "nothing";
	} else {  
		$insert = ma_insertpost($post,$title,$cat);	  
		if ($insert == false) {return false;} else {return true;}
	}
}

function ma_fl_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td width="30%" scope="row">Flickr API Key:</td> 
				<td><input name="ma_fl_apikey" type="text" id="ma_fl_apikey" value="<?php echo get_option('ma_fl_apikey') ;?>"/>
				<a href="http://wprobot.net/documentation/#310"><b>?</b></a></td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">License:</td> 
				<td>
				<select name="ma_fl_license" id="ma_fl_license">
					<option value="1,2,3,4,5,6,7" <?php if (get_option('ma_fl_license')=="1,2,3,4,5,6,7"){echo "selected";}?>>All licenses</option>
					<option value="1,2,3,4,5,6" <?php if (get_option('ma_fl_license')=="1,2,3,4,5,6"){echo "selected";}?>>Only licenses requiring attribution</option>
					<option value="7" <?php if (get_option('ma_fl_license')=="7"){echo "selected";}?>>Only licenses not requiring attribution</option>
				</select>						
				<!--<input name="ma_fl_license" type="text" id="ma_fl_license" value="<?php echo get_option('ma_fl_license') ;?>"/><a href="http://wprobot.net/documentation/#310"><b>?</b></a>-->
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Image Size:</td> 
				<td>
				<select name="ma_fl_size" id="ma_fl_size">
					<option value="small" <?php if (get_option('ma_fl_size')=="small"){echo "selected";}?>>Small</option>
					<option value="med" <?php if (get_option('ma_fl_size')=="med"){echo "selected";}?>>Medium</option>
					<option value="orig" <?php if (get_option('ma_fl_size')=="orig"){echo "selected";}?>>Original</option>
				</select>				
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Image Width:</td> 
				<td>Posts: <input name="ma_fl_width" type="text" id="ma_fl_width" size="4" value="<?php echo get_option('ma_fl_width') ;?>"/>px Thumbnails: <input name="ma_fl_twidth" type="text" id="ma_fl_twidth" size="4" value="<?php echo get_option('ma_fl_twidth') ;?>"/>px <a href="http://wprobot.net/documentation/#310"><b>?</b></a>
				</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Content Type:</td> 
				<td>
				<select name="ma_fl_content" id="ma_fl_content">
					<option value="1" <?php if (get_option('ma_fl_content')==1){echo "selected";}?>>photos only</option>
					<option value="2" <?php if (get_option('ma_fl_content')==2){echo "selected";}?>>screenshots only</option>
					<option value="3" <?php if (get_option('ma_fl_content')==3){echo "selected";}?>>'other' only</option>
					<option value="4" <?php if (get_option('ma_fl_content')==4){echo "selected";}?>>photos and screenshots</option>
					<option value="5" <?php if (get_option('ma_fl_content')==5){echo "selected";}?>>screenshots and 'other'</option>
					<option value="6" <?php if (get_option('ma_fl_content')==6){echo "selected";}?>>photos and 'other'</option>
					<option value="7" <?php if (get_option('ma_fl_content')==7){echo "selected";}?>>photos, screenshots, and 'other' (all)</option>			
				</select>				
				</td> 
			</tr>
			<tr valign="top"> 
				<td width="30%" scope="row">Sort by:</td> 
				<td>
				<select name="ma_fl_sort" id="ma_fl_sort">
					<option value="relevance" <?php if (get_option('ma_fl_sort')=="relevance"){echo "selected";}?>>Relevance</option>
					<option value="date-posted-asc" <?php if (get_option('ma_fl_sort')=="date-posted-asc"){echo "selected";}?>>Date posted, ascending</option>
					<option value="date-posted-desc" <?php if (get_option('ma_fl_sort')=="date-posted-desc"){echo "selected";}?>>Date posted, descending</option>
					<option value="date-taken-asc" <?php if (get_option('ma_fl_sort')=="date-taken-asc"){echo "selected";}?>>Date taken, ascending</option>
					<option value="date-taken-desc" <?php if (get_option('ma_fl_sort')=="date-taken-desc"){echo "selected";}?>>Date taken, descending</option>
					<option value="interestingness-desc" <?php if (get_option('ma_fl_sort')=="interestingness-desc"){echo "selected";}?>>Interestingness, descending</option>
					<option value="interestingness-asc" <?php if (get_option('ma_fl_sort')=="interestingness-asc"){echo "selected";}?>>Interestingness, ascending</option>			
				</select>				
				</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
				<textarea name="ma_fl_template" rows="2" cols="30"><?php echo get_option('ma_fl_template');?></textarea>	
				</td> 
			</tr>					
		</table>	
<?php
}
?>