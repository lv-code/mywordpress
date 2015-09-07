<?php

function ma_articlepost($keyword,$cat,$num,$which) {
   global $wpdb, $ma_dbtable;
   
	// Debug
   	debug_log('- EZA');	 
	$keyword2 = $keyword;	
	$keyword = str_replace( " ","+",$keyword );	
	$keyword = urlencode($keyword);
	
	  $blist[] = "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)";
      $blist[] = "Mozilla/5.0 (compatible; Konqueror/3.92; Microsoft Windows) KHTML/3.92.0 (like Gecko)";
      $blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; Media Center PC 5.0; .NET CLR 1.1.4322; Windows-Media-Player/10.00.00.3990; InfoPath.2";
      $blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; Dealio Deskball 3.0)";
      $blist[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
      $ua = $blist[array_rand($blist)];	
	
	$source = get_option('ma_eza_source');
	
   // SOOPERARTICLES	
   if($source == "sooperarticles") {   
   
	$startat = $num;
	
	if ($startat == 0) {
		$startpage = 1;
		$sk = 1;
	} else {
		$xz = $startat / 15;
		$startpage = ceil($xz);
		$sk = $startat - ( $startpage -1 ) * 15;
	}
	$l = $startpage;
	$sk = $sk -1;
 
	$search_url = "http://www.sooperarticles.com/search/?t=titles&s=$keyword&p=$l";
	// make the cURL request to $search_url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
	curl_setopt($ch, CURLOPT_URL,$search_url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 45);
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
		$paras = $xpath->query("//div/h3/a");

		$para = $paras->item($sk);
		if($para == '' | $para == null) {
			echo '<div class="updated"><p>No articles found!</p></div>';
			return "nothing";
			break;
		} else {		
		$target_url = $para->getAttribute('href');

 	// make the cURL request to $search_url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	curl_setopt($ch, CURLOPT_URL,$target_url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 45);
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
		

	// Grab Article Title 

		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div/h1");
		
		$para = $paras->item(0);
		$title = $para->textContent;		
		$title2 = $title;
		
		if (function_exists('ma_translate') && get_option('ma_trans_title') == 1 && get_option('ma_trans_article') == 1) {$title = ma_translate($title2);}			

		
	// Check X
		
		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@id='KonaBody']/div[@class='arightside']"); 
		
		$para = $paras->item(0);

		if($para != "" && $para != null) {
			return false;
			break;	
		}
		
 	// Grab Article	
	
	if (get_option('ma_eza_grabmethod')=='old') {
		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@id='KonaBody']//p"); 

		for ($i = 0;  $i < $paras->length; $i++ ) {  //$paras->length

			$para = $paras->item($i);
			$paragraph = $para->textContent;
			
			if ($paragraph != '') {
					if (function_exists('ma_translate') && get_option('ma_trans_article') == 1) {$paragraph = ma_translate($paragraph);}
			
				$content .= $paragraph . ' ';
				$content .= "<br/><br/>";
			}
		}		
	} elseif (get_option('ma_eza_grabmethod')=='new') {
		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@id='KonaBody']"); 
		$para = $paras->item(0);		
		$string = $dom->saveXml($para);	
		$tags = array('div','iframe','script');
		$string = ma_strip_selected_tags($string, $tags);	
		$string = str_replace("]]>", "", $string);
		$string = str_replace("<![CDATA[", "", $string);
		
		if (function_exists('ma_translate') && get_option('ma_trans_article') == 1) {$string = ma_translate($string);}

		$content .= $string . ' ';
	}
	
	// Grab Ressource Box	

		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@class='author-signature']");
		$para = $paras->item(0);		
		$ressourcetext = $dom->saveXml($para);	
		if (function_exists('ma_translate') && get_option('ma_trans_articlebox') == 1) {$ressourcetext = ma_translate($ressourcetext);}
		
		if ($ressourcetext != '') {
		$authorbox = "<div style=\"margin:5px;padding:5px;border:1px solid #c1c1c1;font-size: 10px;\">" . $ressourcetext . "</div>";	
		}	
 
 	}
	}  
   
   // ARTICLESBASE
   if($source == "articlesbase") {
   
   /* Select Proxy
	$proxy ="";
	$burl = get_bloginfo('url');;
	$arr=@file("$burl/wp-content/plugins/WPRobot/modules/proxies.txt");
	if($arr) {
		$noprox = count($arr) - 1;
		$rprox = rand(0,$noprox);
		list($proxy,$proxytype,$proxyuser)=explode("|",$arr[$rprox]);
	}
	*/
	$lang = get_option('ma_eza_lang');
	if($lang == "en") {
		$search_url = "http://www.articlesbase.com/find-articles.php?q=$keyword&page=$num";
	} elseif($lang == "fr") {
		$search_url = "http://fr.articlesbase.com/find-articles.php?q=$keyword&page=$num";	
	} elseif($lang == "es") {
		$search_url = "http://www.articuloz.com/find-articles.php?q=$keyword&page=$num";
	} elseif($lang == "pg") {
		$search_url = "http://www.artigonal.com/find-articles.php?q=$keyword&page=$num";
	} elseif($lang == "ru") {
		$search_url = "http://www.rusarticles.com/find-articles.php?q=$keyword&page=$num";
	}
	
	// make the cURL request to $search_url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, 'Firefox (WindowsXP) - Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
	curl_setopt($ch, CURLOPT_URL,$search_url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	
	/* Proxy
	if($proxy != "") {
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	if($proxyuser) {curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuser);}
	if($proxytype == "socks") {curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);}
	}
	*/
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 45);
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
		$paras = $xpath->query("//div//h3/a");

		$para = $paras->item(0);
		if($para == '' | $para == null) {
			echo '<div class="updated"><p>No articles found!</p></div>';
			return "nothing";
			break;
		} else {		
		
	if($lang == "en") {
		$target_url = "http://www.articlesbase.com" . $para->getAttribute('href');
	} elseif($lang == "fr") {
		$target_url = "http://fr.articlesbase.com" . $para->getAttribute('href');	
	} elseif($lang == "es") {
		$target_url = "http://www.articuloz.com" . $para->getAttribute('href');	
	} elseif($lang == "pg") {
		$target_url = "http://www.artigonal.com" . $para->getAttribute('href');	
	} elseif($lang == "ru") {
		$target_url = "http://www.rusarticles.com" . $para->getAttribute('href');	
	}		

	// make the cURL request to $search_url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $ua);
	curl_setopt($ch, CURLOPT_URL,$target_url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	
	/* Proxy
	if($proxy != "") {
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1); 
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	if($proxyuser) {curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyuser);}
	if($proxytype == "socks") {curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);}
	}	
	*/
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 45);
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
		

	// Grab Article Title 

		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div/h1");
		
		$para = $paras->item(0);
		$title = $para->textContent;		
		$title2 = $title;
		
		if (function_exists('ma_translate') && get_option('ma_trans_title') == 1 && get_option('ma_trans_article') == 1) {$title = ma_translate($title2);}			

						
	// Grab Article	
	
	if (get_option('ma_eza_grabmethod')=='old') {
		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@class='KonaBody']//p"); 

		for ($i = 0;  $i < $paras->length; $i++ ) {  //$paras->length

			$para = $paras->item($i);
			$paragraph = $para->textContent;
			
			if ($paragraph != '') {
					if (function_exists('ma_translate') && get_option('ma_trans_article') == 1) {$paragraph = ma_translate($paragraph);}
			
				$content .= $paragraph . ' ';
				$content .= "<br/><br/>";
			}
		}		
	} elseif (get_option('ma_eza_grabmethod')=='new') {
		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@class='KonaBody']"); 
		$para = $paras->item(0);		
		$string = $dom->saveXml($para);	

		$string = strip_tags($string,'<p><strong><b><a><br>');
		$string = str_replace('<div class="KonaBody">', "", $string);	
		$string = str_replace("</div>", "", $string);			
		if (function_exists('ma_translate') && get_option('ma_trans_article') == 1) {$string = ma_translate($string);}

		$content .= $string . ' ';
	}
	
	// Grab Ressource Box	

		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@class='author-bio']//div[@class='text']");
		$para = $paras->item(0);		
		$ressourcetext = $dom->saveXml($para);	
		if (function_exists('ma_translate') && get_option('ma_trans_articlebox') == 1) {$ressourcetext = ma_translate($ressourcetext);}
		
		if ($ressourcetext != '') {
		$authorbox = "<div style=\"margin:5px;padding:5px;border:1px solid #c1c1c1;font-size: 10px;\">" . $ressourcetext . "</div>";	
		}	

}		

}
		$textc = $content;
		//$textc = htmlspecialchars($textc, ENT_QUOTES);
		if($lang == "es") {
			$textc = utf8_decode($textc);	
		}
		$authorbox = utf8_decode($authorbox);
		$title = utf8_decode($title);
		$content = get_option( 'ma_eza_template'); //'{thumbnail}{description}{link}');;	
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
		$content = str_replace("{article}", $textc, $content);			
		$content = str_replace("{authorbox}", $authorbox, $content);	
		$content = str_replace("{keyword}", $keyword2, $content);	
		$content = str_replace("{url}", $target_url, $content);	
		
		$insert = ma_insertpost($content,$title,$cat);			
		if ($insert == false) {return false;} else {return true;} //ma_post($which);		

}

function ma_eza_options() {
?>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td width="30%" scope="row">Article Source:</td> 
				<td>
				<select name="ma_eza_source" id="ma_eza_source">
					<option value="articlesbase" <?php if (get_option('ma_eza_source')=='articlesbase') {echo 'selected';} ?>>Articlesbase.com</option>
					<option value="sooperarticles" <?php if (get_option('ma_eza_source')=='sooperarticles') {echo 'selected';} ?>>Sooperarticles.com</option>
				</select>
				</td> 
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Article Formatting Method:</td> 
				<td>
				<select name="ma_eza_grabmethod" id="ma_eza_grabmethod">
					<option value="new" <?php if (get_option('ma_eza_grabmethod')=='new') {echo 'selected';} ?>>Leave Formatting Intact</option>
					<option value="old" <?php if (get_option('ma_eza_grabmethod')=='old') {echo 'selected';} ?>>Replace Formatting</option>
				</select> <a href="http://wprobot.net/documentation/#34"><b>?</b></a>
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Article Language:</td> 
				<td>
				<select name="ma_eza_lang" id="ma_eza_lang">
					<option value="en" <?php if(get_option('ma_eza_lang')=="en"){_e('selected');}?>>English</option>
					<option value="fr" <?php if(get_option('ma_eza_lang')=="fr"){_e('selected');}?>>French</option>
					<option value="es" <?php if(get_option('ma_eza_lang')=="es"){_e('selected');}?>>Spanish</option>
					<option value="pg" <?php if(get_option('ma_eza_lang')=="pg"){_e('selected');}?>>Portuguese</option>
					<option value="ru" <?php if(get_option('ma_eza_lang')=="ru"){_e('selected');}?>>Russian</option>
				</select>
			</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Post Template:</td> 
				<td>			
			<textarea name="ma_eza_template" rows="2" cols="30"><?php echo get_option('ma_eza_template');?></textarea>	
				</td> 
			</tr>					
		</table>
<?php
}
?>