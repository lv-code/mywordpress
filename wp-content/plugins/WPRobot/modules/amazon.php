<?php

function ma_aws_request($region, $params, $public_key, $private_key) {
    $method = "GET";
    $host = "ecs.amazonaws.".$region;
    $uri = "/onca/xml";

    $params["Service"] = "AWSECommerceService";
    $params["AWSAccessKeyId"] = $public_key;
	
	$t = time() + 10000;
	$params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z",$t);	
    //$params["Timestamp"] = gmdate("Y-m-d\TH:i:s\Z");
    $params["Version"] = "2009-03-31";
    
    ksort($params);
    
    $canonicalized_query = array();
    foreach ($params as $param=>$value) {
        $param = str_replace("%7E", "~", rawurlencode($param));
        $value = str_replace("%7E", "~", rawurlencode($value));
        $canonicalized_query[] = $param."=".$value;
    }
    $canonicalized_query = implode("&", $canonicalized_query);
    $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;   
    $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $private_key, True));  
    $signature = str_replace("%7E", "~", rawurlencode($signature));  
    $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature; 
		
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

function ma_aws_getnodename($nodeid) {

	$public_key = get_option('ma_aa_apikey');
	$private_key = get_option('ma_aa_secretkey');
	$locale = get_option('ma_aa_site');
	if($locale == "us") {$locale = "com";}
	if($locale == "uk") {$locale = "co.uk";}	
	$pxml = ma_aws_request($locale, array(
	"Operation"=>"BrowseNodeLookup",
	"BrowseNodeId"=>$nodeid,
	"ResponseGroup"=>"BrowseNodeInfo"
	), $public_key, $private_key);

	if ($pxml === False) {
		return false;
	} else {
		if($pxml->BrowseNodes->BrowseNode->Name) {
			return $pxml->BrowseNodes->BrowseNode->Name;
		} else {
			return false;		
		}
	}
}

function ma_amazonpost($keyword,$cat,$num,$which,$aadept,$aanode) {
   global $wpdb, $ma_dbtable;
   
	// Debug
   	debug_log('- AA');	     
   
	$startat = $num;
	$affid = get_option('ma_aa_affkey');
	$public_key = get_option('ma_aa_apikey');
	$private_key = get_option('ma_aa_secretkey');
	$locale = get_option('ma_aa_site');
	if($locale == "us") {$locale = "com";}
	if($locale == "uk") {$locale = "co.uk";}
	
	if($aadept == "search-alias=apparel") {$aadept = "Apparel";}
	if($aadept == "search-alias=automotive") {$aadept ="Automotive"; }
	if($aadept == "search-alias=baby-products") {$aadept = "Baby";}
	if($aadept == "search-alias=beauty") {$aadept = "Beauty";}
	if($aadept == "search-alias=stripbooks") {$aadept = "Books";}
	if($aadept == "search-alias=electronics") {$aadept = "Electronics";}
	if($aadept == "search-alias=misc") {$aadept = "Miscellaneous";}
	if($aadept == "search-alias=gourmet") {$aadept = "GourmetFood";}
	if($aadept == "search-alias=grocery") {$aadept = "All";}
	if($aadept == "search-alias=hpc") {$aadept = "All";}
	if($aadept == "search-alias=garden") {$aadept = "HomeGarden";}
	if($aadept == "search-alias=tools") {$aadept = "Tools";}
	if($aadept == "search-alias=jewelry") {$aadept = "Jewelry";}
	if($aadept == "search-alias=digital-text") {$aadept = "KindleStore";}
	if($aadept == "search-alias=magazines") {$aadept = "Magazines";}
	if($aadept == "search-alias=dvd") {$aadept = "DVD";}
	if($aadept == "search-alias=popular") {$aadept = "All";}
	if($aadept == "search-alias=mi") {$aadept = "MusicalInstruments";}
	if($aadept == "search-alias=office-products") {$aadept = "OfficeProducts";}
	if($aadept == "search-alias=shoes") {$aadept = "Shoes";}
	if($aadept == "search-alias=software") {$aadept = "Software";}
	if($aadept == "search-alias=sporting") {$aadept = "SportingGoods";}
	if($aadept == "search-alias=toys-and-games") {$aadept = "Toys";}
	if($aadept == "search-alias=vhs") {$aadept = "VHS";}
	if($aadept == "search-alias=videogames") {$aadept = "VideoGames";}
	if($aadept == "search-alias=amazontv") {$aadept = "Video";}
	if($aadept == "search-alias=watches") {$aadept = "Watches";}	
	
	$numb = $num;
	$num = $num / 10;
	$num = (string) $num; 
	$num = explode(".", $num);
	$page=(int)$num[0];	
	$page++;				
	$cnum=(int)$num[1]; 
	$l = $page;
	$sk = $cnum;
	
	$keyword2 = urlencode($keyword);   
	
	if(get_option('ma_aa_searchmode') == "exact") {
		$keyword2 = '"' .$keyword2. '"';
	}
	// Request
	if($aanode != 0 && $aanode != "") {
		$pxml = ma_aws_request($locale, array(
		"Operation"=>"ItemSearch",
		"AssociateTag"=>$affid,
		"BrowseNode"=>$aanode,
		"SearchIndex"=>$aadept,
		"ItemPage"=>$l,
		"ReviewSort"=>"HelpfulVotes",
		"ResponseGroup"=>"Large"
		), $public_key, $private_key);
	} else {
		if($aanode == 0) {$aanode = "";}
		$pxml = ma_aws_request($locale, array(
		"Operation"=>"ItemSearch",
		"AssociateTag"=>$affid,
		"Keywords"=>$keyword2,
		"SearchIndex"=>$aadept,
		"BrowseNode"=>$aanode,
		"ItemPage"=>$l,
		"ReviewSort"=>"HelpfulVotes",
		"ResponseGroup"=>"Large"
		), $public_key, $private_key);	
	}
	//echo "<pre>".print_r($pxml)."</pre>";
	if ($pxml === False) {
		echo '<div class="updated"><p>Error: Request did not work.</p></div>';
	} else {
		if (isset($pxml->Items->Item)) {
			$i = 0;
			foreach($pxml->Items->Item as $item) {
				if($i == $sk) {
					$title = $item->ItemAttributes->Title;
					$url = $item->DetailPageURL ;
					
					$img = $item->MediumImage->URL;
					if($img == "") {$img = $item->SmallImage->URL;}
					$thumbnail = '<a href="'.$url.'" rel="nofollow"><img style="float:left;margin: 0 20px 10px 0;" src="'.$img.'" /></a>';	
					$thumbnailurl = $img;
					$largeimage = $item->LargeImage->URL;
					$price = $item->OfferSummary->LowestNewPrice->FormattedPrice;
					// strip brackets
					if(get_option('ma_aa_striptitle') == 'yes') {
						$title = preg_replace('`\[[^\]]*\]`','',$title);
						$title = preg_replace('`\([^\]]*\)`','',$title);		
					}					
					
					if (function_exists('ma_translate') && get_option('ma_trans_title') == 1 && get_option('ma_trans_aadesc') == 1) {$title = ma_translate($title);}					

					if (isset($item->ItemAttributes->Feature)) {	
						$features = "<ul>";
						foreach($item->ItemAttributes->Feature as $feature) {
							$posx = strpos($feature, "href=");
							if ($posx === false) {
								$features .= "<li>".$feature."</li>";		
							}
						}	
						$features .= "</ul>";				
					}			
					
					if (isset($item->EditorialReviews->EditorialReview)) {	
						$desc = "";
						foreach($item->EditorialReviews->EditorialReview as $descs) {
							$content .= "<b>".$descs->Source."</b><br>";
							$content .= $descs->Content;
							$desc .= $descs->Content;
						}
						
						$elength = get_option('ma_aa_excerptlength');
						if ($elength != 'full') {
							$content = strip_tags($content,'<strong><b><a><br>');
							$content = substr($content, 0, $elength);
							$content .= '... <a href="' . $url . '" rel="nofollow">More >></a>';
						}
						
						if (function_exists('ma_translate') && get_option('ma_trans_aadesc') == 1) {$content = ma_translate($content);}							
					}
					
					if (isset($item->CustomerReviews->Review)) {						
						$avgrating = $item->CustomerReviews->AverageRating;			
						$noreviews = $item->CustomerReviews->TotalReviews;		
					}					
					
					$affl = '<a href="' . $url . '" title="'.$title.'" rel="nofollow"><b>'.$title.'</b></a>';

					$post = get_option( 'ma_aa_template'); //'{thumbnail}{description}{link}');		
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
					$post = str_replace("{thumbnail}", $thumbnail, $post);	
					$post = str_replace("{largethumb}", $largeimage, $post);			
					$post = str_replace("{description}", $content, $post);			
					$post = str_replace("{link}", $affl, $post);				
					$post = str_replace("{keyword}", $keyword, $post);	
					$post = str_replace("{url}", $url, $post);	
					$post = str_replace("{title}", $title, $post);						
					$post = str_replace("{price}", $price, $post);	
					$post = str_replace("{noreviews}", $noreviews, $post);	
					$post = str_replace("{avgrating}", $avgrating, $post);						
					$post = str_replace("{features}", $features, $post);	

					
					$skip = get_option( 'ma_aa_skip');
					if($skip == "noimg" || $skip == "nox") {if($img == "") {return false;} }
					
					if($skip == "nodesc" || $skip == "nox") {if($desc == "") {return false;}}
					
					$insert = ma_insertpost($post,$title,$cat);	
					
					if ($insert == false) {return false;} elseif (get_option('ma_aa_postreviews') == "all") {

						// Custom Field
						// add_post_meta($insert, 'custom_field_name', $thumbnailurl);
					
						if (isset($item->CustomerReviews->Review)) {
						
						if($_POST['postdate']) {
							$comment_date= $_POST['postdate'];		
						} else {
							$comment_date = current_time('mysql');
						}						
						
							foreach($item->CustomerReviews->Review as $reviews) {
							
								$author = $reviews->Reviewer->Name;			
								$rating = $reviews->Rating;
								$review = $reviews->Content;
								$cont = get_option( 'ma_aa_revtemplate');
								$cont = str_replace("{review}", $review, $cont);	
								$cont = str_replace("{rating}", $rating, $cont);								
								$cont = str_replace("{link}", $affl, $cont);
								$cont = str_replace("{keyword}", $keyword, $cont);
								$cont = str_replace("{url}", $url, $cont);
								
								$comment_post_ID=$insert;

								list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $comment_date );	
								$comment_date = mktime($hour + rand(0, 2), $minute + rand(0, 59), $second + rand(0, 59), $today_month, $today_day, $today_year);
								$comment_date=date("Y-m-d H:i:s", $comment_date); 		
								$comment_date_gmt = $comment_date;					

								$comment_author_email="someone@domain.com";
								$comment_author=$author;
								$comment_author_url=$url;  
								$comment_content=$cont;
								if (function_exists('ma_translate') && get_option('ma_trans_aarfull') == 1) {$comment_content = ma_translate($comment_content);}

								$comment_type='';
								$user_ID='';
								$comment_approved = 1;
								$commentdata = compact('comment_post_ID', 'comment_date', 'comment_date_gmt', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'user_ID', 'comment_approved');
								$comment_id = wp_insert_comment( $commentdata );								
								
							}	
						}
						
						return true;	

					}
			
				}
				$i++;			
			}
	 
		} else {
		//	echo '<div class="updated"><p>No Amazon Products found!</p></div>';
		return "nothing";
		}
	}
}

function ma_aa_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td width="30%" scope="row">Amazon Affiliate ID:</td> 
				<td><input name="ma_aa_affkey" type="text" id="ma_aa_affkey" value="<?php echo get_option('ma_aa_affkey') ;?>"/>
			</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">API Key (Access Key ID):</td> 
				<td><input name="ma_aa_apikey" type="text" id="ma_aa_apikey" value="<?php echo get_option('ma_aa_apikey') ;?>"/>
			(<a href="http://wprobot.net/documentation/#33"><b>?</b></a>) - <i>required!</i></td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Secret Access Key:</td> 
				<td><input name="ma_aa_secretkey" type="text" id="ma_aa_secretkey" value="<?php echo get_option('ma_aa_secretkey') ;?>"/>
			(<a href="http://wprobot.net/documentation/#33"><b>?</b></a>) - <i>required!</i></td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Search Method:</td> 
				<td>
				<select name="ma_aa_searchmode" id="ma_aa_searchmode">
					<option value="exact" <?php if (get_option('ma_aa_searchmode')=="exact"){echo "selected";}?>>Exact Match</option>
					<option value="broad" <?php if (get_option('ma_aa_searchmode')=="broad"){echo "selected";}?>>Broad Match</option>
				</select>
				</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Skip Products If:</td> 
				<td>
				<select name="ma_aa_skip" id="ma_aa_skip">
					<option value="" <?php if (get_option('ma_aa_skip')==""){echo "selected";}?>>Don't skip</option>
					<option value="nodesc" <?php if (get_option('ma_aa_skip')=="nodesc"){echo "selected";}?>>No description found</option>
					<option value="noimg" <?php if (get_option('ma_aa_skip')=="noimg"){echo "selected";}?>>No thumbnail image found</option>
					<option value="nox" <?php if (get_option('ma_aa_skip')=="nox"){echo "selected";}?>>No description OR no thumbnail</option>
				</select>
				</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Amazon Description Length:</td> 
				<td>
				<select name="ma_aa_excerptlength" id="ma_aa_excerptlength">
					<option value="250" <?php if (get_option('ma_aa_excerptlength')==250){echo "selected";}?>>250 Characters</option>
					<option value="500" <?php if (get_option('ma_aa_excerptlength')==500){echo "selected";}?>>500 Characters</option>
					<option value="750" <?php if (get_option('ma_aa_excerptlength')==750){echo "selected";}?>>750 Characters</option>
					<option value="1000" <?php if (get_option('ma_aa_excerptlength')==1000){echo "selected";}?>>1000 Characters</option>
					<option value="full" <?php if (get_option('ma_aa_excerptlength')=='full'){echo "selected";}?>>Full Description</option>
				</select>				
				</td> 
			</tr>
			<tr valign="top"> 
				<td width="30%" scope="row">Amazon Website:</td> 
				<td>
				<select name="ma_aa_site" id="ma_aa_site">
					<option value="com" <?php if (get_option('ma_aa_site')=='com'){echo "selected";}?>>Amazon.com</option>
					<option value="uk" <?php if (get_option('ma_aa_site')=='uk'){echo "selected";}?>>Amazon.co.uk</option>
					<option value="de" <?php if (get_option('ma_aa_site')=='de'){echo "selected";}?>>Amazon.de</option>
					<option value="ca" <?php if (get_option('ma_aa_site')=='ca'){echo "selected";}?>>Amazon.ca</option>
					<option value="jp" <?php if (get_option('ma_aa_site')=='jp'){echo "selected";}?>>Amazon.jp</option>
					<option value="fr" <?php if (get_option('ma_aa_site')=='fr'){echo "selected";}?>>Amazon.fr</option>					
				</select>				
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Strip brackets from titles:</td> 
				<td>
				<input name="ma_aa_striptitle" type="checkbox" id="ma_aa_striptitle" value="yes" <?php if (get_option('ma_aa_striptitle')=='yes') {echo "checked";} ?>/> Yes
				<!--<select name="ma_aa_striptitle" id="ma_aa_striptitle">
					<option value="yes" <?php if (get_option('ma_aa_striptitle')=='yes'){echo "selected";}?>>Yes</option>
					<option value="no" <?php if (get_option('ma_aa_striptitle')=='no'){echo "selected";}?>>No</option>
				</select>-->				
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Post Reviews as Comments?</td> 
				<td>
				<input name="ma_aa_postreviews" type="checkbox" id="ma_aa_postreviews" value="all" <?php if (get_option('ma_aa_postreviews')=='all') {echo "checked";} ?>/> Yes
				<!--<select name="ma_aa_postreviews" id="ma_aa_postreviews">
					<option value="all" <?php if (get_option('ma_aa_postreviews')=="all"){echo "selected";}?>>Yes</option>
					<option value="none" <?php if (get_option('ma_aa_postreviews')=="none"){echo "selected";}?>>No</option>
				</select>-->
				</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
				<textarea name="ma_aa_template" rows="3" cols="30"><?php echo get_option('ma_aa_template');?></textarea>	
				</td> 
			</tr>		
			<tr valign="top"> 
				<td width="30%" scope="row">Review Template:</td> 
				<td>			
				<textarea name="ma_aa_revtemplate" rows="2" cols="30"><?php echo get_option('ma_aa_revtemplate');?></textarea>	
				</td> 
			</tr>				
		</table>	
		<?php
}
?>