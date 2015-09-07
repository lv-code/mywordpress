<?php

function ma_getebay($keyword,$aucnum,$ebcat) {
   global $wpdb, $ma_dbtable; 
	
	$ebaycat = $ebcat;
	$country = get_option("ma_eb_country");
	$sortby = get_option("ma_eb_sortby");
	$lang = get_option("ma_eb_lang");
	$affkey = get_option( 'ma_eb_affkey' );
	if (empty($ebaycat)){$ebaycat="-1";}
	
	require_once ( ABSPATH . WPINC .  '/rss.php' );
		$keyword = str_replace(" ","+",$keyword);
		$keyword = str_replace("-","+",$keyword);
		$keyword = strtolower($keyword);
		$rssurl="http://rss.api.ebay.com/ws/rssapi?FeedName=SearchResults&siteId=$country&language=$lang&output=RSS20&sacat=$ebaycat&fcl=3&satitle=" . $keyword."&sacur=0&frpp=100&afepn=" . urlencode($affkey) . "&dfsp=32&sabfmts=0&salic=$country&ftrt=1&ftrv=1&customid=" .$keyword."&fss=0&saobfmts=exsif&catref=C5&saaff=afepn&from=R6&saslop=1";

		if($sortby !="bestmatch"){
			$rssurl.=$sortby;
		}	

	$therss = fetch_rss($rssurl);
	$cit=0;
	if($therss->items != "" || $therss->items != null)  {	
		foreach ($therss->items as $item) {	
			$cit++;
		}
	}
	if($cit < 60) {$limit = $cit;} else {$limit = 60;}
	
	$i=0;
		if ($therss){
			$startat = rand(0,$limit);
			$totalresults = $startat + $aucnum;
			
			if($therss->items == "" || $therss->items == null) {$ebayitems = "No auctions available.";} else {
				foreach ($therss->items as $item) {
					if($item['link'] == null || $item['title'] == "") {}	 
				
					$thelink=$item['link'];
					$theurl=$thelink;
					$thetitle = preg_replace ('#\$#', '&#36;',$item['title']);
					$descr = preg_replace ('#\$#', '&#36;',$item['description']);
					
					if ($i >= $startat) {
						$ebayitems.="<div style=\"padding-top:10px;\">";
						$ebayitems.="<a rel=\"nofollow\" href=\"$theurl\"><b>$thetitle</b></a><br />$descr\n";
						$ebayitems.="</div>";
					}
					if (($totalresults-1)==$i){break;}
					$i++;
				}

			}		
		}
		
			return $ebayitems;		
}

function ma_ebaypost($keyword,$cat,$num,$which,$ebcat) {
   global $wpdb, $ma_dbtable;

	// Debug
   	debug_log('- EB module entered');	
	
	$kw = ucwords($keyword);	
	$ebaycat = $ebcat;
	$country = get_option("ma_eb_country");
	$sortby = get_option("ma_eb_sortby");
	$lang = get_option("ma_eb_lang");
	$affkey = get_option( 'ma_eb_affkey' );
	if (empty($ebaycat)){$ebaycat="-1";}
	
	if(get_option( 'ma_eb_postrss' ) != "true") {
	require_once ( ABSPATH . WPINC .  '/rss.php' );

		$keyword = str_replace(" ","+",$keyword);
		$keyword = str_replace("-","+",$keyword);
		$keyword = strtolower($keyword);
		$rssurl="http://rss.api.ebay.com/ws/rssapi?FeedName=SearchResults&siteId=$country&language=$lang&output=RSS20&sacat=$ebaycat&fcl=3&satitle=" . $keyword."&sacur=0&frpp=100&afepn=" . urlencode($affkey) . "&dfsp=32&sabfmts=0&salic=$country&ftrt=1&ftrv=1&customid=" .$keyword."&fss=0&saobfmts=exsif&catref=C5&saaff=afepn&from=R6&saslop=1";

		if($sortby !="bestmatch"){
			$rssurl.=$sortby;
		}	

	$therss = fetch_rss($rssurl);
	$i=0;
	$posted = 0;
		if ($therss){
			if ($num < 60) {$startat = $num;} else {$startat = 0;}
			$totalresults = $startat + get_option( 'ma_eb_auctionnum');
			
			if($therss->items == "" || $therss->items == null) {$nf = "nothing";} else {
				foreach ($therss->items as $item) {
					if($item['link'] == null || $item['title'] == "") {$nf = "nothing";}	 
				
					$thelink=$item['link'];
					$theurl=$thelink;
					$thetitle = preg_replace ('#\$#', '&#36;',$item['title']);
					$descr = preg_replace ('#\$#', '&#36;',$item['description']);
					
					if ($i >= $startat) {
						$ebayitems.="<div style=\"padding-top:10px;\">";
						$ebayitems.="<a rel=\"nofollow\" href=\"$theurl\"><b>$thetitle</b></a><br />$descr\n";
						$ebayitems.="</div>";
					}
					if (($totalresults-1)==$i){break;}
					$i++;$posted++;
				}
			$itemtitle = $thetitle;
			$itemtitle = strtolower ($itemtitle);
			$itemtitle = ucwords($itemtitle);	
			$auctions = $ebayitems;					
			}		
		}	
	} else {
		$auctions = '[eba kw="'.$keyword.'" num="'.get_option( 'ma_eb_auctionnum').'" ebcat="'.$ebaycat.'"]';
	}
	if($nf != "nothing") {
			$title = get_option( 'ma_eb_titlet');
			$title = str_replace("{item}", $itemtitle, $title);			
			$title = str_replace("{keyword}", $kw, $title);					

			$content = get_option( 'ma_eb_template');
						// Youtube			
						$pos = strpos($content, "{video}");		
						if ($pos === false) {
						} else {
							$vid = ma_getvideo($keyword2,1,0);
							if($vid[8] != "") {
								$content = str_replace("{video}", $vid[8], $content);							
							} else {	
								$content = str_replace("{video}", "", $content);								
							}							
						}	
						// Flickr
						preg_match('#\{image(.*)\}#iU', $content, $matches);
						if ($matches[0] == false) {
						} else {
							if($matches[1] != false ) {$imgkeyword = substr($matches[1], 1);} else {$imgkeyword = $keyword;}
					
							$img = ma_getimage($imgkeyword,1,0);
							if($img[4] != "" && $img[4] != "i") {
								$image = '<img style="float:left;margin: 0 20px 10px 0;" src="'.$img[4].'" width="'.get_option("ma_fl_twidth").'" />';
								$content = str_replace("{date}", $img[1], $content);
								$content = str_replace("{owner}", $img[2] , $content);
								$content = str_replace("{largeimage}", $img[6], $content);
								$content = str_replace($matches[0], $image, $content);
								$fllink = 'http://www.flickr.com/photos/'.$img[7].'/'.$img[8];
								$content = str_replace("{imageurl}", $fllink, $content);
							} else {
								$content = str_replace("{date}", "", $content);
								$content = str_replace("{owner}", "", $content);
								$content = str_replace("{largeimage}","", $content);								
								$content = str_replace($matches[0], "", $content);
								$content = str_replace("{imageurl}", "", $content);								
							}
						}		
			$content = str_replace("{auctions}", $auctions, $content);			
			$content = str_replace("{link}", $link, $content);			
			$content = str_replace("{keyword}", $kw, $content);	
			$content = str_replace("{url}", $thelink, $content);	
	
			$insert = ma_insertpost($content,$title,$cat,1);	
		}	
		if($nf == "nothing") {echo '<div class="updated"><p>No eBay auctions found!</p></div>';return "nothing";} elseif ($insert == false) {return false;} else {return true;}
}

function ma_rss_shortcode( $atts ) {
	extract(shortcode_atts(array(  
	    "kw" 		=> '',  
		"num" 		=> '1',  
		"ebcat" 	=> ''
	), $atts));
	
	$auc = ma_getebay($kw,$num,$ebcat);
	$content .= $auc;
	
	/*if(get_option('ma_cloak') == 'Yes') {
		$ebcloak = new ma_linkcloaker();
		$content = $ebcloak->contentcloaker($content);
	}		*/

	return $content;
}

function ma_eb_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td width="30%" scope="row">eBay Affiliate ID (CampID):</td> 
				<td><input name="ma_eb_affkey" type="text" id="ma_eb_affkey" value="<?php echo get_option('ma_eb_affkey') ;?>"/>
			</td> 
			</tr>
			<tr valign="top"> 
				<td width="30%" scope="row">Country:</td> 
				<td>
				<select name="ma_eb_country" id="ma_eb_country">
					<option value="0" <?php if(get_option('ma_eb_country')=="0"){_e('selected');}?>>United States</option>
					<option value="2" <?php if(get_option('ma_eb_country')=="2"){_e('selected');}?>>Canada</option>
					<option value="3" <?php if(get_option('ma_eb_country')=="3"){_e('selected');}?>>United kingdom</option>
					<option value="15" <?php if(get_option('ma_eb_country')=="15"){_e('selected');}?>>Australia</option>
					<option value="16" <?php if(get_option('ma_eb_country')=="16"){_e('selected');}?>>Austria</option>
					<option value="23" <?php if(get_option('ma_eb_country')=="23"){_e('selected');}?>>Belgium (French)</option>
					<option value="71" <?php if(get_option('ma_eb_country')=="71"){_e('selected');}?>>France</option>
					<option value="77" <?php if(get_option('ma_eb_country')=="77"){_e('selected');}?>>Germany</option>
					<option value="100" <?php if(get_option('ma_eb_country')=="100"){_e('selected');}?>>eBay Motors</option>
					<option value="101" <?php if(get_option('ma_eb_country')=="101"){_e('selected');}?>>Italy</option>
					<option value="123" <?php if(get_option('ma_eb_country')=="123"){_e('selected');}?>>Belgium (Dutch)</option>
					<option value="146" <?php if(get_option('ma_eb_country')=="146"){_e('selected');}?>>Netherlands</option>
					<option value="186" <?php if(get_option('ma_eb_country')=="186"){_e('selected');}?>>Spain</option>
					<option value="193" <?php if(get_option('ma_eb_country')=="193"){_e('selected');}?>>Switzerland</option>
					<option value="196" <?php if(get_option('ma_eb_country')=="196"){_e('selected');}?>>Taiwan</option>
					<option value="223" <?php if(get_option('ma_eb_country')=="223"){_e('selected');}?>>China</option>
				</select>
			</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Language:</td> 
				<td>
				<select name="ma_eb_lang" id="ma_eb_lang">
					<option value="en-US" <?php if(get_option('ma_eb_lang')=="en-US"){_e('selected');}?>>English</option>
					<option value="de" <?php if(get_option('ma_eb_lang')=="de"){_e('selected');}?>>German</option>
					<option value="fr" <?php if(get_option('ma_eb_lang')=="fr"){_e('selected');}?>>French</option>
					<option value="it" <?php if(get_option('ma_eb_lang')=="it"){_e('selected');}?>>Italian</option>
					<option value="es" <?php if(get_option('ma_eb_lang')=="es"){_e('selected');}?>>Spanish</option>
					<option value="nl" <?php if(get_option('ma_eb_lang')=="nl"){_e('selected');}?>>Dutch</option>
					<option value="cn" <?php if(get_option('ma_eb_lang')=="cn"){_e('selected');}?>>Chinese</option>
					<option value="tw" <?php if(get_option('ma_eb_lang')=="tw"){_e('selected');}?>>Taiwanese</option>
				</select>
			</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Sort results by:</td> 
				<td>
				<select name="ma_eb_sortby" id="ma_eb_sortby">
					<option value="bestmatch" <?php if(get_option('ma_eb_sortby')=="bestmatch"){_e('selected');}?>>Best Match</option>
					<option value="&fsop=1&fsoo=1" <?php if(get_option('ma_eb_sortby')=="&fsop=1&fsoo=1"){_e('selected');}?>>Time: ending soonest</option>
					<option value="&fsop=2&fsoo=2" <?php if(get_option('ma_eb_sortby')=="&fsop=2&fsoo=2"){_e('selected');}?>>Time: newly listed</option>
					<option value="&fsop=34&fsoo=1" <?php if(get_option('ma_eb_sortby')=="&fsop=34&fsoo=1"){_e('selected');}?>>Price + Shipping: lowest first</option>
					<option value="&fsop=34&fsoo=2" <?php if(get_option('ma_eb_sortby')=="&fsop=34&fsoo=2"){_e('selected');}?>>Price + Shipping: highest first</option>
					<option value="&fsop=3&fsoo=2" <?php if(get_option('ma_eb_sortby')=="&fsop=3&fsoo=2"){_e('selected');}?>>Price: highest first</option>
				</select>				
			</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Number of Auctions per Post:</td> 
				<td>
				<select name="ma_eb_auctionnum" id="ma_eb_auctionnum">
					<option <?php if (get_option('ma_eb_auctionnum')==1){echo "selected";}?>>1</option>
					<option <?php if (get_option('ma_eb_auctionnum')==2){echo "selected";}?>>2</option>
					<option <?php if (get_option('ma_eb_auctionnum')==3){echo "selected";}?>>3</option>
					<option <?php if (get_option('ma_eb_auctionnum')==4){echo "selected";}?>>4</option>
					<option <?php if (get_option('ma_eb_auctionnum')==5){echo "selected";}?>>5</option>	
					<option <?php if (get_option('ma_eb_auctionnum')==6){echo "selected";}?>>6</option>
					<option <?php if (get_option('ma_eb_auctionnum')==8){echo "selected";}?>>8</option>	
					<option <?php if (get_option('ma_eb_auctionnum')==10){echo "selected";}?>>10</option>	
				</select>					
			</td> 
			</tr>		
			<tr valign="top"> 
				<td width="30%" scope="row">Auto Renew Auctions:</td> 
				<td>
				<select name="ma_eb_postrss" id="ma_eb_postrss">
					<option value="true" <?php if (get_option('ma_eb_postrss')=="true"){echo "selected";}?>>Yes, embed RSS feed</option>
					<option value="false" <?php if (get_option('ma_eb_postrss')=="false"){echo "selected";}?>>No, hardcode auctions</option>
				</select>					
			</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Title Template:</td> 
				<td><input size="38" name="ma_eb_titlet" type="text" id="ma_eb_titlet" value="<?php echo get_option('ma_eb_titlet') ;?>"/>
			</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
			<textarea name="ma_eb_template" rows="4" cols="30"><?php echo get_option('ma_eb_template');?></textarea>	
				</td> 
			</tr>				
		</table>
<?php
}

add_shortcode( 'eba', 'ma_rss_shortcode' );
	
?>