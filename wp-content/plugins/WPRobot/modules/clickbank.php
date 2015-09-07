<?php

function ma_clickbankpost($keyword,$cat,$num,$which) {
   global $wpdb, $ma_dbtable;
   
	// Debug
   	debug_log('- CB');	     
	$keyword2 = $keyword;	
	$keyword = str_replace( " ","+",$keyword );
	$search_url = "http://www.clickbank.com/marketplace.htm?category=-1&subcategory=-1&keywords=$keyword&sortBy=popularity&billingType=ALL&language=ALL&maxResults=50";

	// make the cURL request to $search_url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
	curl_setopt($ch, CURLOPT_URL,$search_url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$html= curl_exec($ch);
	if (!$html) {
		echo "<br />cURL error number:" .curl_errno($ch);
		echo "<br />cURL error:" . curl_error($ch);
		exit;
	}
	curl_close($ch); 

	// parse the html into a DOMDocument  

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

	// Grab Product Links

		$xpath = new DOMXPath($dom);
		$links = $xpath->query("//a[@class='siteHeader']");
		
		
		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//td[@class='marketplace_indent']/div[@class='indent']");
			$para = $paras->item(0);
			$fullstring = $para->textContent;	
			
			$affid = get_option('ma_cb_affkey');
			if ($affid == '') { $affid = 'lun4tic' ;}

				$mlink = $links->item($num);
				if($mlink == '' | $mlink == null) {
				echo '<div class="updated"><p>No Clickbank products found!</p></div>';
				return "nothing";
				break;				
				} else {				
				$url = $mlink->getAttribute('href');
				$url = str_replace("zzzzz", $affid, $url);						
				$title = $mlink->textContent;	

				$link = '<a rel="nofollow" href="'. $url . '">'.$title . '</a><br/>';				
				$description = ma_get_string_between($fullstring, $title, "$/sale");

				$ff = get_option('ma_cb_filter');
				$stop = 0;
				if($ff == "yes") {
					$pos = strpos($description, "Commission");
					if ($pos !== false) {$stop = 1;}				
					$pos = strpos($description, "commission");
					if ($pos !== false) {$stop = 1;}
					$pos = strpos($description, "affiliate");
					if ($pos !== false) {$stop = 1;}	
					$pos = strpos($description, "Affiliate");
					if ($pos !== false) {$stop = 1;}						
					$pos = strpos($description, "affiliates");
					if ($pos !== false) {$stop = 1;}						
				}
				
				if (function_exists('ma_translate') && get_option('ma_trans_cbads') == 1) {$description = ma_translate($description);}
				if (function_exists('ma_translate') && get_option('ma_trans_title') == 1 && get_option('ma_trans_cbads') == 1) {$title = ma_translate($title);}

				
	// Insert Products in WP	

		$content = get_option( 'ma_cb_template');
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
						// eBay
						preg_match('#\{auction(.*)\}#iU', $content, $matches);
						if ($matches[0] == false) {
						} else {
							if($matches[1] != false ) {$aucnum = substr($matches[1], 1);} else {$aucnum = 1;}
							$content = str_replace($matches[0], '[eba kw="'.$keyword2.'" num="'.$aucnum.'" ebcat=""]', $content);						
						}
		$content = str_replace("{link}", $link, $content);			
		$content = str_replace("{description}", $description, $content);
		$content = str_replace("{keyword}", $keyword2, $content);	
		$content = str_replace("{url}", $search_url, $content);	
		
		if($stop != 1) {
		$insert = ma_insertpost($content,$title,$cat);	
		} else {return false;}
		if ($insert == false) {return false;} else {return true;} //ma_post($which);
		
}
}

function ma_cb_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 	
			<tr valign="top"> 
				<td width="30%" scope="row">Clickbank Affiliate ID:</td> 
				<td><input name="ma_cb_affkey" type="text" id="ma_cb_affkey" value="<?php echo get_option('ma_cb_affkey');?>"/>
			</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Filter Ads?</td> 
				<td><input name="ma_cb_filter" type="checkbox" id="ma_cb_filter" value="yes" <?php if (get_option('ma_cb_filter')=='yes') {echo "checked";} ?>/> Yes
				(<a href="http://wprobot.net/documentation/#35"><b>?</b></a>)</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
			<textarea name="ma_cb_template" rows="2" cols="30"><?php echo get_option('ma_cb_template');?></textarea>	
				</td> 
			</tr>		
		</table>
<?php
}
?>