<?php
function ma_gettr( $url, $post, $referer = "") {
	$blist[] = "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)";
	$blist[] = "Mozilla/5.0 (compatible; Konqueror/3.92; Microsoft Windows) KHTML/3.92.0 (like Gecko)";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; Media Center PC 5.0; .NET CLR 1.1.4322; Windows-Media-Player/10.00.00.3990; InfoPath.2";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; Dealio Deskball 3.0)";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
	$br = $blist[array_rand($blist)];
	if ( function_exists('curl_init') ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $br);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$buffer = curl_exec ($ch);
		curl_close ($ch);
		return $buffer;
	} 
}
function ma_gtrns($text, $from, $to) {
	$url = "http://translate.google.com/translate_t";
	$ref = "http://translate.google.com/translate_t";
	$text=urlencode($text);
	if($to=="tw"||$to=="cn") {
		$to="zh-".strtoupper($to);
	}
	$postdata="hl=en&ie=UTF8&text=".$text."&langpair=".$from."%7C".$to;
	$page = ma_gettr($url, $postdata, $ref);
	preg_match('#<div\ id=result_box\ dir=\".+?\">(.*?)</div>#s', $page, $ref);
	if ($ref[1]!="") {
		return stripslashes(strip_tags($ref[1]));
	}
	else {
		return "";
	}
}

function ma_tr($text, $from, $to) {
	$text=urlencode($text);
	$url = "http://translate.google.com/translate_t#$from|$to|$text";

	$blist[] = "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)";
	$blist[] = "Mozilla/5.0 (compatible; Konqueror/3.92; Microsoft Windows) KHTML/3.92.0 (like Gecko)";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; WOW64; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; Media Center PC 5.0; .NET CLR 1.1.4322; Windows-Media-Player/10.00.00.3990; InfoPath.2";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; InfoPath.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; Dealio Deskball 3.0)";
	$blist[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; NeosBrowser; .NET CLR 1.1.4322; .NET CLR 2.0.50727)";
	$br = $blist[array_rand($blist)];	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $br);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		$html = curl_exec ($ch);
		curl_close ($ch);	
	
	// parse the html into a DOMDocument  

		$dom = new DOMDocument();
		@$dom->loadHTML($html);

	// Grab Product Title

		$xpath = new DOMXPath($dom);
		$paras = $xpath->query("//div[@id='result_box']");	//[@id='btAsinTitle']
		
		$para = $paras->item(0);
		$translation = $para->textContent;	
		
		return $translation;
}

function ma_btrns($text, $from, $to) {
	$url = "http://babelfish.yahoo.com/translate_txt";
	$ref = "http://babelfish.yahoo.com/translate_txt";
	$text=urlencode($text);
	if($to=="tw") {
		$to = "zt";
	}
	if($to=="cn") {
		$to="zh";
	}
	$postdata="doit=done&intl=1&tt=urltext&trtext=".$text."&lp=".$from."_".$to."&btnTrTxt=Translate";
	$page = ma_gettr($url, $postdata, $ref);
	preg_match('#<div id="result"><div style="padding:0.6em;">(.*?)</div></div>#s', $page, $ref);
	if ($ref[1]!="") {
		return stripslashes($ref[1]);
	}
	else {
		return "";
	}
}
function ma_translate($text) {
	
	$where = get_option('ma_transsite');
	
				if (get_option('ma_translate1')!='no') {
							
					$text = strip_tags($text);
					//$text = preg_replace('/[a-zA-Z]\.[a-zA-Z]/', '. ', $text);
					$text  = str_replace(".", ". ", $text);				
				
					$tto = get_option('ma_translate1');
					$tfrom = get_option('ma_translate0');
					if ($where == "google") {
					$ttext = ma_gtrns($text, $tfrom, $tto);
					} elseif ($where == "yahoo") {
					$ttext = ma_btrns($text, $tfrom, $tto);
					} else {
					$rand = rand(0,1);
					if ($rand == 0) {$ttext = ma_gtrns($text, 'en', $tto);} else {$ttext = ma_btrns($text, 'en', $tto);}
					}
				} 
				if (get_option('ma_translate1')!='no' && get_option('ma_translate2')!='no') {
					$tto = get_option('ma_translate2');
					$tfrom = get_option('ma_translate1');
					if ($where == "google") {					
					$ttext = ma_gtrns($ttext, $tfrom, $tto);
					} elseif ($where == "yahoo") {
					$ttext = ma_btrns($ttext, $tfrom, $tto);
					} else {					
					$rand = rand(0,1);
					if ($rand == 0) {$ttext = ma_gtrns($ttext, $tfrom, $tto);} else {$ttext = ma_btrns($ttext, $tfrom, $tto);}
					}					
				} 
				if (get_option('ma_translate1')!='no' && get_option('ma_translate2')!='no' && get_option('ma_translate3')!='no') {
					$tto = get_option('ma_translate3');
					$tfrom = get_option('ma_translate2');
					if ($where == "google") {					
					$ttext = ma_gtrns($ttext, $tfrom, $tto);
					} elseif ($where == "yahoo") {
					$ttext = ma_btrns($ttext, $tfrom, $tto);
					} else {					
					$rand = rand(0,1);
					if ($rand == 0) {$ttext = ma_gtrns($ttext, $tfrom, $tto);} else {$ttext = ma_btrns($ttext, $tfrom, $tto);}
					}
				} 	
				if ($ttext != '') {
					return $ttext;
				} else {
					return $text;
				}
}

function ma_tr_options() {
?>
		<table cellspacing="2" cellpadding="5" class="editform"> 
			<tr valign="top"> 
				<td scope="row">Translate posts from </td> 
				<td>
				<select name="ma_translate0" id="ma_translate0">
					<option value="en" <?php if (get_option('ma_translate0')=='en') {echo 'selected';} ?>>English</option>
					<option value="de" <?php if (get_option('ma_translate0')=='de') {echo 'selected';} ?>>German</option>
					<option value="it" <?php if (get_option('ma_translate0')=='it') {echo 'selected';} ?>>Italian</option>
					<option value="fr" <?php if (get_option('ma_translate0')=='fr') {echo 'selected';} ?>>French</option>
					<option value="es" <?php if (get_option('ma_translate0')=='es') {echo 'selected';} ?>>Spanish</option>
					<option value="sv" <?php if (get_option('ma_translate0')=='sv') {echo 'selected';} ?>>Swedish</option>
					<option value="el" <?php if (get_option('ma_translate0')=='el') {echo 'selected';} ?>>Greek</option>
					<option value="fi" <?php if (get_option('ma_translate0')=='fi') {echo 'selected';} ?>>Finnish</option>
					<option value="zh-CN" <?php if (get_option('ma_translate0')=='zh-CN') {echo 'selected';} ?>>Chinese</option>
					<option value="ja" <?php if (get_option('ma_translate0')=='ja') {echo 'selected';} ?>>Japanese</option>	
					<option value="nl" <?php if (get_option('ma_translate0')=='nl') {echo 'selected';} ?>>Dutch</option>		
				</select> to					
				</td> 
				<td>
				<select name="ma_translate1" id="ma_translate1">
					<option value="no" <?php if (get_option('ma_translate1')=='no') {echo 'selected';} ?>>---</option>
					<option value="en" <?php if (get_option('ma_translate1')=='en') {echo 'selected';} ?>>English</option>					
					<option value="de" <?php if (get_option('ma_translate1')=='de') {echo 'selected';} ?>>German</option>
					<option value="it" <?php if (get_option('ma_translate1')=='it') {echo 'selected';} ?>>Italian</option>
					<option value="fr" <?php if (get_option('ma_translate1')=='fr') {echo 'selected';} ?>>French</option>
					<option value="es" <?php if (get_option('ma_translate1')=='es') {echo 'selected';} ?>>Spanish</option>
					<option value="sv" <?php if (get_option('ma_translate1')=='sv') {echo 'selected';} ?>>Swedish</option>
					<option value="el" <?php if (get_option('ma_translate1')=='el') {echo 'selected';} ?>>Greek</option>
					<option value="fi" <?php if (get_option('ma_translate1')=='fi') {echo 'selected';} ?>>Finnish</option>
					<option value="zh-CN" <?php if (get_option('ma_translate1')=='zh-CN') {echo 'selected';} ?>>Chinese</option>
					<option value="ja" <?php if (get_option('ma_translate1')=='ja') {echo 'selected';} ?>>Japanese</option>	
					<option value="nl" <?php if (get_option('ma_translate1')=='nl') {echo 'selected';} ?>>Dutch</option>		
				</select> to					
				</td> 
				<td>
				<select name="ma_translate2" id="ma_translate2">
					<option value="no" <?php if (get_option('ma_translate2')=='no') {echo 'selected';} ?>>---</option>
					<option value="en" <?php if (get_option('ma_translate2')=='en') {echo 'selected';} ?>>English</option>
					<option value="de" <?php if (get_option('ma_translate2')=='de') {echo 'selected';} ?>>German</option>
					<option value="it" <?php if (get_option('ma_translate2')=='it') {echo 'selected';} ?>>Italian</option>
					<option value="fr" <?php if (get_option('ma_translate2')=='fr') {echo 'selected';} ?>>French</option>
					<option value="es" <?php if (get_option('ma_translate2')=='es') {echo 'selected';} ?>>Spanish</option>
					<option value="sv" <?php if (get_option('ma_translate2')=='sv') {echo 'selected';} ?>>Swedish</option>
					<option value="el" <?php if (get_option('ma_translate2')=='el') {echo 'selected';} ?>>Greek</option>
					<option value="fi" <?php if (get_option('ma_translate2')=='fi') {echo 'selected';} ?>>Finnish</option>
					<option value="zh-CN" <?php if (get_option('ma_translate2')=='zh-CN') {echo 'selected';} ?>>Chinese</option>
					<option value="ja" <?php if (get_option('ma_translate2')=='ja') {echo 'selected';} ?>>Japanese</option>
					<option value="nl" <?php if (get_option('ma_translate2')=='nl') {echo 'selected';} ?>>Dutch</option>					
				</select> to						
				</td> 
				<td>
				<select name="ma_translate3" id="ma_translate3">
					<option value="no" <?php if (get_option('ma_translate3')=='no') {echo 'selected';} ?>>---</option>
					<option value="en" <?php if (get_option('ma_translate3')=='en') {echo 'selected';} ?>>English</option>
					<option value="de" <?php if (get_option('ma_translate3')=='de') {echo 'selected';} ?>>German</option>
					<option value="it" <?php if (get_option('ma_translate3')=='it') {echo 'selected';} ?>>Italian</option>
					<option value="fr" <?php if (get_option('ma_translate3')=='fr') {echo 'selected';} ?>>French</option>
					<option value="es" <?php if (get_option('ma_translate3')=='es') {echo 'selected';} ?>>Spanish</option>
					<option value="sv" <?php if (get_option('ma_translate3')=='sv') {echo 'selected';} ?>>Swedish</option>
					<option value="el" <?php if (get_option('ma_translate3')=='el') {echo 'selected';} ?>>Greek</option>
					<option value="fi" <?php if (get_option('ma_translate3')=='fi') {echo 'selected';} ?>>Finnish</option>
					<option value="zh-CN" <?php if (get_option('ma_translate3')=='zh-CN') {echo 'selected';} ?>>Chinese</option>
					<option value="ja" <?php if (get_option('ma_translate3')=='ja') {echo 'selected';} ?>>Japanese</option>
					<option value="nl" <?php if (get_option('ma_translate3')=='nl') {echo 'selected';} ?>>Dutch</option>
				</select>						
				</td> 				
			</tr>	
		</table>
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 		
			<tr valign="top"> 
				<td width="30%" scope="row">Translation Service to use:</td> 
				<td>
				<select name="ma_transsite" id="ma_transsite">
					<option value="google" <?php if (get_option('ma_transsite')=="google"){echo "selected";}?>>Google Translate</option>
					<option value="yahoo" <?php if (get_option('ma_transsite')=="yahoo"){echo "selected";}?>>Yahoo Babelfish</option>
					<option value="both" <?php if (get_option('ma_transsite')=="both"){echo "selected";}?>>both</option>			
				</select> <a href="http://wprobot.net/documentation/#39"><b>?</b></a>					
			</td> 
			</tr>		
			
			<tr valign="top"> 
				<td width="30%" scope="row"><b>Translate...</b> <a href="http://wprobot.net/documentation/#39"><b>?</b></a></td> 
				<td></td>
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Articles</td> 
				<td><input name="ma_trans_article" type="checkbox" value="1" <?php if(get_option('ma_trans_article')==1) {echo "checked";}?> /> Yes</td>
			</tr>		
			<tr valign="top"> 
				<td width="30%" scope="row">Article Author Boxes</td> 
				<td><input name="ma_trans_articlebox" type="checkbox" value="1" <?php if(get_option('ma_trans_articlebox')==1) {echo "checked";}?> /> Yes</td>
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Clickbank Ads</td> 
				<td><input name="ma_trans_cbads" type="checkbox" value="1" <?php if(get_option('ma_trans_cbads')==1) {echo "checked";}?> /> Yes</td>
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Amazon Descriptions</td> 
				<td><input name="ma_trans_aadesc" type="checkbox" value="1" <?php if(get_option('ma_trans_aadesc')==1) {echo "checked";}?> /> Yes</td>
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Amazon Reviews</td> 
				<td><input name="ma_trans_aarfull" type="checkbox" value="1" <?php if(get_option('ma_trans_aarfull')==1) {echo "checked";}?> /> Yes</td>
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Yahoo Answers Questions</td> 
				<td><input name="ma_trans_yapq" type="checkbox" value="1" <?php if(get_option('ma_trans_yapq')==1) {echo "checked";}?> /> Yes</td>
			</tr>			
			<tr valign="top"> 
				<td width="30%" scope="row">Yahoo Answers Answers</td> 
				<td><input name="ma_trans_yapa" type="checkbox" value="1" <?php if(get_option('ma_trans_yapa')==1) {echo "checked";}?> /> Yes</td>
			</tr>		
			<tr valign="top"> 
				<td width="30%" scope="row">Youtube Descriptions</td> 
				<td><input name="ma_trans_ytdesc" type="checkbox" value="1" <?php if(get_option('ma_trans_ytdesc')==1) {echo "checked";}?> /> Yes</td>
			</tr>		
			<tr valign="top"> 
				<td width="30%" scope="row">Youtube Comments</td> 
				<td><input name="ma_trans_ytcom" type="checkbox" value="1" <?php if(get_option('ma_trans_ytcom')==1) {echo "checked";}?> /> Yes</td>
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">RSS Feeds</td> 
				<td><input name="ma_trans_rss" type="checkbox" value="1" <?php if(get_option('ma_trans_rss')==1) {echo "checked";}?> /> Yes</td>
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Post Titles</td> 
				<td><input name="ma_trans_title" type="checkbox" value="1" <?php if(get_option('ma_trans_title')==1) {echo "checked";}?> /> Yes</td>
			</tr>					
		</table>
<?php
}
?>