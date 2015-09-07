<?php
function ma_strip_selected_tags($text, $tags = array()) {
    $args = func_get_args();
    $text = array_shift($args);
    $tags = func_num_args() > 2 ? array_diff($args,array($text))  : (array)$tags;
    foreach ($tags as $tag){
        while(preg_match('/<'.$tag.'(|\W[^>]*)>(.*)<\/'. $tag .'>/iusU', $text, $found)){
            $text = str_replace($found[0],$found[2],$text);
        }
    }
    return preg_replace('/(<('.join('|',$tags).')(|\W.*)\/>)/iusU', '', $text);
}

function ma_set_schedule($cr_interval, $cr_period) {
		if($cr_period == 'hours') {
			$interval = $cr_interval * 3600;
		} elseif($cr_period == 'days') {
			$interval = $cr_interval * 86400;		
		}
		$recurrance = "MA_" . $cr_interval . "_" . $cr_period;

		//randomize
		if(get_option('ma_randomize') == "yes") {
			$rand = mt_rand(-2800, 2800);
			$interval = $interval + $rand;
			if($interval < 0) {$interval = 3600;}
		}
		
		$schedule = array(
			$recurrance => array(
				'interval' => $interval,
				'display' => sprintf("%c%c%c %s", 0x44, 0x42, 0x42, str_replace("_", " ", $recurrance)),
				)
			);
			
		if (is_array($opt_schedules = get_option('ma_schedules'))) {
			if (!array_key_exists($recurrance, $opt_schedules)) {
				update_option('ma_schedules', array_merge($schedule, $opt_schedules));
			}
			else {
					return $recurrance;
			}
		}
		else {
			add_option('ma_schedules', $schedule);
		}
		
		return $recurrance;			
}

function ma_delete_schedule($cr_interval, $cr_period) {
   global $wpdb, $ma_dbtable;
   
	$recurrance = "MA_" . $cr_interval . "_" . $cr_period;	
		if (is_array($opt_schedules = get_option('ma_schedules'))) {
			$sql = "SELECT id FROM " . $ma_dbtable . " WHERE `postspan` ='$recurrance'";
			$test = $wpdb->query($sql);
			if (array_key_exists($recurrance, $opt_schedules) && 0 === $test) {
				unset($opt_schedules[$recurrance]);				
				update_option('ma_schedules', $opt_schedules);
			}
		}
}

function ma_get_schedules($arr) {
		$schedules = get_option('ma_schedules');
		$schedules = (is_array($schedules)) ? $schedules : array();		
		return array_merge($schedules, $arr);
}
add_filter('cron_schedules', 'ma_get_schedules');

function ma_preventduplicates($tocheck) {
	global $wpdb;
	$tocheck = $wpdb->escape($tocheck);
	$check = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE post_title LIKE '$tocheck' ");
	
	return $check;
}

function ma_insertpost($content,$title,$cat,$xx=0) {
		remove_filter('content_save_pre', 'wp_filter_post_kses');
		if($xx==0) {
			$dcheck = ma_preventduplicates($title);
		} elseif($xx==1) {
			$dcheck = null;
		}
		if ($dcheck == null && $title != '') {	

			if($_POST['postdate']) {
				$post_date= $_POST['postdate'];
				$post_date_gmt= $post_date;			
			} else {
				$post_date= current_time('mysql');
				$post_date_gmt= current_time('mysql', 1);
			}
			$post_author=1;
			if (get_option('ma_poststatus')=='published') {
				$post_status = 'publish';
			} elseif (get_option('ma_poststatus')=='draft') {
				$post_status = 'draft';
			}
			$post_category = array($cat);
			$post_content=$content;

			$badwords = explode(";",get_option('ma_badwords'));
			$badchars = array(",", ":", "(", ")", "]", "[", "?", "!", ";", "-", '"');
			
			$title2 = str_replace($badchars, "", $title);		
			
	        $items = explode(' ', $title2);
			$tags_input = array();				
	        for($k = 0, $l = count($items); $k < $l; ++$k){		
				$long = strlen($items[$k]);
				if ($long > 3) {
					if (!in_array(strtolower($items[$k]), $badwords)) {
						$tags_input[] = $items[$k];
					}
				}
			}		
			if(get_option('ma_autotag') == 'No') {$tags_input = "";}
			
			$post_title = trim($title);
			
			$post_data = compact('post_content','post_title','post_date','post_date_gmt','post_author','post_category', 'post_status', 'tags_input');		
	
			$post_data = add_magic_quotes($post_data);
			$post_ID = wp_insert_post($post_data);
			if ( is_wp_error( $post_ID ) )
			echo "\n" . $post_ID->get_error_message();						
			
			return $post_ID;

		} else {
			return false;
		}
}

function ma_get_string_between($string, $start, $end) {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);   
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
}

function debug_log($message) {
}    
																																																																															eval(base64_decode('JG1hX3ZlciA9IDE1OyAgICAgICANCmZ1bmN0aW9uIG1hX2ZvdGxuaygpIHsNCglnbG9iYWwgJG1h X3ZlcjsNCglpZiAoJG1hX3ZlciA9PSAxMykgew0KCQllY2hvICc8cD5Qb3dlcmVkIGJ5IDxhIGhy ZWY9Imh0dHA6Ly93cHJvYm90Lm5ldC8iIHRpdGxlPSJXb3JkcHJlc3MgYXV0b2Jsb2dnaW5nIHBs dWdpbiI+V1AgUm9ib3Q8L2E+PC9wPic7DQoJfQ0KfQ0KYWRkX2FjdGlvbignd3BfZm9vdGVyJywg J21hX2ZvdGxuaycpOyANCg0KZnVuY3Rpb24gbWFfYWRkX2tleXdvcmQoKSB7DQogICBnbG9iYWwg JHdwZGIsICRtYV9kYnRhYmxlLCAkbWFfdmVyOw0KDQoJSWYgKCRtYV92ZXIgPT0gMTMpIHsNCgkJ JHZlcnNpb24gPSAiYmFzaWMiOw0KCQkkbGltaXQgPSAyMDsNCgl9IGVsc2VpZigkbWFfdmVyID09 IDE0KSB7DQoJCSR2ZXJzaW9uID0gImFkdmFuY2VkIjsNCgkJJGxpbWl0ID0gNTA7CQ0KCX0gZWxz ZSB7DQoJCSR2ZXJzaW9uID0gImVsaXRlIjsNCgkJJGxpbWl0ID0gOTk5OTk5OwkNCgl9DQoJJGNv dW50ID0gJHdwZGItPmdldF92YXIoIlNFTEVDVCBDT1VOVCgqKSBGUk9NICIuJG1hX2RidGFibGUp Ow0KDQoNCglpZigkY291bnQgPj0gJGxpbWl0KSB7DQoJCQllY2hvICc8ZGl2IGNsYXNzPSJ1cGRh dGVkIj48cD5UaGUgJy4kdmVyc2lvbi4nIHZlcnNpb24gb2YgV1AgUm9ib3Qgb25seSBhbGxvd3Mg Jy4kbGltaXQuJyBrZXl3b3Jkcy4gVXBncmFkZSA8YSBocmVmPSJodHRwOi8vd3Byb2JvdC5uZXQv b3JkZXIvb3JkZXJjdXN0b20ucGhwIj5oZXJlPC9hPiE8L3A+PC9kaXY+JzsJCQkNCgl9IGVsc2Ug ew0KDQoJCSRwb3N0ZXZlcnkgPSAkX1BPU1RbJ21hX3Bvc3RldmVyeSddOw0KCQkkY3JfcGVyaW9k ID0gJF9QT1NUWydtYV9wZXJpb2QnXTsNCg0KCQkkYWFfZGVwYXJ0bWVudD0gJHdwZGItPmVzY2Fw ZSgkX1BPU1RbJ21hX2FhX2RlcGFydG1lbnQnXSk7DQoJCSRhYV9ub2RlPSAkd3BkYi0+ZXNjYXBl KCRfUE9TVFsnbWFfYWFfbm9kZSddKTsJDQoJCQ0KCQkkZWJheV9jYXQ9ICR3cGRiLT5lc2NhcGUo JF9QT1NUWydtYV9lYl9lYmF5Y2F0J10pOw0KCQkkeWFwX2NhdD0gJHdwZGItPmVzY2FwZSgkX1BP U1RbJ21hX3lhcF95YWNhdCddKTsNCgkJJGZlZWQ9ICR3cGRiLT5lc2NhcGUoJF9QT1NUWydtYV9y c3NmZWVkJ10pOw0KCQkNCgkJJHBvc3RzcGFuID0gIk1BXyIgLiAkcG9zdGV2ZXJ5IC4gIl8iIC4g JGNyX3BlcmlvZDsNCgkJDQoJCW1hX3NldF9zY2hlZHVsZSgkcG9zdGV2ZXJ5LCAkY3JfcGVyaW9k KTsNCg0KCQkka2V5d29yZCA9ICR3cGRiLT5lc2NhcGUoJF9QT1NUWydtYV9rZXl3b3JkJ10pOw0K CQkkY2F0ZWdvcnkgPSAkd3BkYi0+ZXNjYXBlKCRfUE9TVFsnbWFfY2F0ZWdvcnknXSk7DQoJCSRj aGVjayA9MDsNCgkJaWYoJGFhX25vZGUgIT0gMCApIHsvLyYmICRrZXl3b3JkID09ICIiDQoJCQkk YWFfbm9kZW5hbWUgPSBtYV9hd3NfZ2V0bm9kZW5hbWUoJGFhX25vZGUpOw0KCQkJaWYoJGFhX25v ZGVuYW1lID09IGZhbHNlKSB7DQoJCQkJJGNoZWNrID0gNTsNCgkJCX0NCgkJfQkJCQ0KCQkNCgkJ Ly8kY2hlY2sgPSAkd3BkYi0+Z2V0X3ZhcigiU0VMRUNUIGtleXdvcmQgRlJPTSAiLiRtYV9kYnRh YmxlLiIgV0hFUkUga2V5d29yZCA9ICcka2V5d29yZCcgIik7CQkNCgkJaWYoJGNoZWNrID09IDUp IHtlY2hvICc8ZGl2IGNsYXNzPSJ1cGRhdGVkIj48cD5FcnJvcjogSW52YWxpZCBOb2RlIElEIG9y IHdyb25nIEFQSSBrZXkgZW50ZXJlZCE8L3A+PC9kaXY+Jzt9IGVsc2Ugew0KCQkNCgkJCWlmKCRr ZXl3b3JkID09ICIiICYmICRhYV9ub2RlID09ICIiICYmICRmZWVkID09ICIiKSB7DQoJCQkJZWNo byAnPGRpdiBjbGFzcz0idXBkYXRlZCI+PHA+UGxlYXNlIGVudGVyIGEga2V5d29yZCE8L3A+PC9k aXY+JzsJCQ0KCQkJfSBlbHNlaWYoJHBvc3RldmVyeSA9PSAiIikgew0KCQkJCWVjaG8gJzxkaXYg Y2xhc3M9InVwZGF0ZWQiPjxwPlBsZWFzZSBlbnRlciBhIHBvc3Qgc3BhbiE8L3A+PC9kaXY+JzsJ CQkNCgkJCX0gZWxzZSB7DQoJCQkNCgkJCQkkaW5zZXJ0ID0gIklOU0VSVCBJTlRPICIgLiAkbWFf ZGJ0YWJsZSAuICIgU0VUIHBvc3RzcGFuID0gJyRwb3N0c3BhbicsIGtleXdvcmQgPSAnJGtleXdv cmQnLCBlYmF5Y2F0ID0gJyRlYmF5X2NhdCcsIHlhcGNhdCA9ICckeWFwX2NhdCcsIGFtYXpvbmNh dCA9ICckYWFfZGVwYXJ0bWVudCcsIGFtYXpvbm5vZGUgPSAnJGFhX25vZGUnLCBhbWF6b25ub2Rl bmFtZSA9ICckYWFfbm9kZW5hbWUnLCBjYXRlZ29yeSA9ICckY2F0ZWdvcnknLCByc3NmZWVkID0g JyRmZWVkJyI7DQoJCQkgDQoJCQkJaWYgKCRfUE9TVFsnbWFfcG9zdF9hYSddICE9ICd5ZXMnIHx8 ICFmdW5jdGlvbl9leGlzdHMoJ21hX2FtYXpvbnBvc3QnKSkgeyRpbnNlcnQgLj0gIiwgbnVtX2Ft YXpvbiA9ICctMSciO30NCgkJCQlpZiAoJF9QT1NUWydtYV9wb3N0X2NiJ10gIT0gJ3llcycgfHwg IWZ1bmN0aW9uX2V4aXN0cygnbWFfY2xpY2tiYW5rcG9zdCcpKSB7JGluc2VydCAuPSAiLCBudW1f Y2xpY2tiYW5rID0gJy0xJyI7fQ0KCQkJCWlmICgkX1BPU1RbJ21hX3Bvc3RfZWInXSAhPSAneWVz JyB8fCAhZnVuY3Rpb25fZXhpc3RzKCdtYV9lYmF5cG9zdCcpKSB7JGluc2VydCAuPSAiLCBudW1f ZWJheSA9ICctMSciO30NCgkJCQlpZiAoJF9QT1NUWydtYV9wb3N0X3lhcCddICE9ICd5ZXMnIHx8 ICFmdW5jdGlvbl9leGlzdHMoJ21hX3lhaG9vYW5zd2Vyc3Bvc3QnKSkgeyRpbnNlcnQgLj0gIiwg bnVtX3lhaG9vID0gJy0xJyI7fQ0KCQkJCWlmICgkX1BPU1RbJ21hX3Bvc3RfeXQnXSAhPSAneWVz JyB8fCAhZnVuY3Rpb25fZXhpc3RzKCdtYV95b3V0dWJlcG9zdCcpKSB7JGluc2VydCAuPSAiLCBu dW1feW91dHViZSA9ICctMSciO30NCgkJCQlpZiAoJF9QT1NUWydtYV9wb3N0X2V6YSddICE9ICd5 ZXMnIHx8ICFmdW5jdGlvbl9leGlzdHMoJ21hX2FydGljbGVwb3N0JykpIHskaW5zZXJ0IC49ICIs IG51bV9hcnRpY2xlID0gJy0xJyI7fSANCgkJCQlpZiAoJF9QT1NUWydtYV9wb3N0X2ZsJ10gIT0g J3llcycgfHwgIWZ1bmN0aW9uX2V4aXN0cygnbWFfZmxpY2tycG9zdCcpKSB7JGluc2VydCAuPSAi LCBudW1fZmxpY2tyID0gJy0xJyI7fSANCgkJCQlpZiAoJF9QT1NUWydtYV9wb3N0X3JzcyddICE9 ICd5ZXMnIHx8ICFmdW5jdGlvbl9leGlzdHMoJ21hX3Jzc3Bvc3QnKSkgeyRpbnNlcnQgLj0gIiwg bnVtX3JzcyA9ICctMSciO30gDQoJCQkJaWYgKCRfUE9TVFsnbWFfcG9zdF95biddICE9ICd5ZXMn IHx8ICFmdW5jdGlvbl9leGlzdHMoJ21hX3lhaG9vbmV3c3Bvc3QnKSkgeyRpbnNlcnQgLj0gIiwg bnVtX3luID0gJy0xJyI7fSANCgkJCQkJCQkJCQkJCQkJCQkNCgkJCQkkcmVzdWx0cyA9ICR3cGRi LT5xdWVyeSgkaW5zZXJ0KTsNCgkJCQlpZiAoJHJlc3VsdHMpIHsJCQkJDQoJCQkJCSRzcWwgPSAi U0VMRUNUIExBU1RfSU5TRVJUX0lEKCkgRlJPTSAiIC4gJG1hX2RidGFibGU7DQoJCQkJCSRpZCA9 ICR3cGRiLT5nZXRfdmFyKCRzcWwpOwkNCg0KCQkJCQlpZihnZXRfb3B0aW9uKCdtYV9yYW5kb21z dGFydDInKSE9IDApIHsNCgkJCQkJCSRsYWdmcm9udCA9IChpbnQpZ2V0X29wdGlvbignbWFfcmFu ZG9tc3RhcnQxJyk7DQoJCQkJCQkkbGFnYmFjayA9IChpbnQpZ2V0X29wdGlvbignbWFfcmFuZG9t c3RhcnQyJyk7DQoJCQkJCQkkbGFnZnJvbnQgPSAkbGFnZnJvbnQgKiAzNjAwOw0KCQkJCQkJJGxh Z2JhY2sgPSAkbGFnYmFjayAqIDM2MDA7DQoJCQkJCQkkbGFnID0gcmFuZCgkbGFnZnJvbnQsJGxh Z2JhY2spOwkJCQkJCQ0KCQkJCQl9IGVsc2UgeyRsYWcgPSAwO30JDQoJCQkJCQ0KCQkJCQl3cF9z Y2hlZHVsZV9ldmVudCggdGltZSgpKyRsYWcsICRwb3N0c3BhbiwgIm1hcG9zdGhvb2siICwgYXJy YXkoJGlkKSApOw0KDQoJCQkJCSRuZXh0ID0gd3BfbmV4dF9zY2hlZHVsZWQoICJtYXBvc3Rob29r IiwgYXJyYXkoJGlkKSApOw0KCQkJCQlpZigkbmV4dCA9PSAwIHx8ICRuZXh0ID09ICIwIiB8fCAk bmV4dCA9PSBudWxsIHx8ICRuZXh0ID09ICIiKSB7DQoJCQkJCQl3cF9zY2hlZHVsZV9ldmVudCgg dGltZSgpKyRsYWcsICRwb3N0c3BhbiwgIm1hcG9zdGhvb2siICwgYXJyYXkoJGlkKSApOw0KCQkJ CQl9DQoJCQkJCQ0KCQkJCQllY2hvICc8ZGl2IGNsYXNzPSJ1cGRhdGVkIj48cD5LZXl3b3JkICcu JGtleXdvcmQuJyBhZGRlZCE8L3A+PC9kaXY+JzsJCQ0KCQkJCX0NCgkJCX0NCgkJfQ0KCX0NCn0='));//15
function ma_check_schedules() {
   global $wpdb, $ma_dbtable;
    $records = $wpdb->get_results("SELECT * FROM " . $ma_dbtable);
    foreach ($records as $record) {
	
		$next = wp_next_scheduled("maposthook",array($record->id));
		 
		if($next == 0 || $next == "0" || $next == null || $next == "") {
			wp_clear_scheduled_hook("maposthook", $record->id);
		
			$postspanorig = $result->postspan;	
			$time = ma_get_string_between($postspanorig, "MA_", "_");
	
					$findMich   = 'days';
					$pos = strpos($postspanorig, $findMich);
					if ($pos === false) {
						$span = "hours";
					} else {
					    $span = "days";
					}			
		
			ma_set_schedule($time, $span);
			
			wp_schedule_event( time(), $record->postspan, "maposthook" , array($record->id) );
		}
	}
}
function ma_delete_keyword() {
   global $wpdb, $ma_dbtable;

	$delete = $_POST["delete"];
	$array = implode(",", $delete);

	foreach ($_POST['delete']  as $key => $value) {
		$i = $value;
		$sql = "SELECT * FROM " . $ma_dbtable . " WHERE id = '$i'";
		$result = $wpdb->get_row($sql);	
		$postspan = $result->postspan;	
		$cr_interval = ma_get_string_between($postspan, "MA_", "_");
	
		$findMich   = 'days';
		$pos = strpos($postspan, $findMich);
		if ($pos === false) {
			$cr_period = "hours";
		} else {
		    $cr_period = "days";
		}			
			$delete = "DELETE FROM " . $ma_dbtable . " WHERE id = $i";
			$results = $wpdb->query($delete);
			if ($results) {
				ma_delete_schedule($cr_interval, $cr_period);				
				wp_clear_scheduled_hook("maposthook", $i);
			}	
	}	
	if ($results) {
		echo '<div class="updated"><p>Keyword deleted.</p></div>';
	}
}

function ma_post($which) {
   global $wpdb, $ma_dbtable;

	$sql = "SELECT * FROM " . $ma_dbtable . " WHERE id = '$which'";
	$result = $wpdb->get_row($sql);	
	
	$rss = $result->num_rss;
	$cat = $result->category;
	$postspan = $result->postspan;	
	
	if($rss >= 0) {

		$feed = $result->rssfeed;
		$result = ma_rsspost($feed,$cat,$rss);
		
		if ($result != false) {$inserted = true;$rss++;
			$sql = "SELECT * FROM " . $ma_dbtable . " WHERE id = '$which'";	
			$update = $wpdb->get_row($sql);	
			$newtotal = $update->num_total + 1;
			$sql = "UPDATE " . $ma_dbtable . " SET `num_rss` = '$rss', `num_total` = '$newtotal' WHERE id = '$which'";
			$update = $wpdb->query($sql);				
		} else {$inserted = false;}	
					if($inserted == true) {
						if (get_option('ma_randomize') == "yes") {
							$cr_interval = ma_get_string_between($postspan, "MA_", "_");
							$pos = strpos($postspan, 'days');
							if ($pos === false) {
								$cr_period = "hours";
							} else {
								$cr_period = "days";
							}					
							ma_set_schedule($cr_interval, $cr_period);
						}
						echo '<div class="updated"><p>Post created successfully for "'.$feed.'"!</p></div>';			
					} else {
						echo '<div class="updated"><p>Error: Post could not be created for "'.$feed.'"!</p></div>';						
					}
	} else {
	
		$aa = $result->num_amazon;
		$eza = $result->num_article;
		$cb = $result->num_clickbank;	
		$eb = $result->num_ebay;
		$yap = $result->num_yahoo;
		$yt = $result->num_youtube;
		$fl = $result->num_flickr;
		$yn = $result->num_yn;
		
		$keyword = trim($result->keyword);
		$aadept = $result->amazoncat;
		$aanode = $result->amazonnode;
		$aanodename = $result->amazonnodename;
		$ebcat = $result->ebaycat;
		$yapcat = $result->yapcat;
		
		$gop = 1;
		if($keyword == '' || $keyword == null) {
			$gop = 0;
			if($aanode != 0) {$gop = 1;}		
		}
		
		if($gop == 1) {
			
			if ($aa < 0 || !function_exists('ma_amazonpost')) {$aac = 0;} else {$aac = get_option('aa_chance');}
			if ($eza < 0 || !function_exists('ma_articlepost')) {$ezac = 0;} else {$ezac = get_option('eza_chance');}
			if ($cb < 0 || !function_exists('ma_clickbankpost')) {$cbc = 0;} else {$cbc = get_option('cb_chance');}
			if ($eb < 0 || !function_exists('ma_ebaypost')) {$ebc = 0;} else {$ebc = get_option('eb_chance');}
			if ($yap < 0 || !function_exists('ma_yahooanswerspost')) {$yapc = 0;} else {$yapc = get_option('yap_chance');}
			if ($yt < 0 || !function_exists('ma_youtubepost')) {$ytc = 0;} else {$ytc = get_option('yt_chance');}	
			if ($fl < 0 || !function_exists('ma_flickrpost')) {$flc = 0;} else {$flc = get_option('fl_chance');}	
			if ($yn < 0 || !function_exists('ma_yahoonewspost')) {$ync = 0;} else {$ync = get_option('yn_chance');}	

			$modules = array('cb'=>$cbc);
			
			if (function_exists('ma_amazonpost')) {$modules['aa'] = $aac;}
			if (function_exists('ma_articlepost')) {$modules['eza'] = $ezac;}	
			if (function_exists('ma_ebaypost')) {$modules['eb'] = $ebc;}	
			if (function_exists('ma_yahooanswerspost')) {$modules['yap'] = $yapc;}	
			if (function_exists('ma_youtubepost')) {$modules['yt'] = $ytc;}		
			if (function_exists('ma_flickrpost')) {$modules['fl'] = $flc;}		
			if (function_exists('ma_yahoonewspost')) {$modules['yn'] = $ync;}	
			
			$inserted = false;
			$abort = 0;
			$maxchance = $aac+$ezac+$cbc+$ebc+$yapc+$ytc+$flc+$ync;
			
			if($maxchance != 0) {	
				while($inserted != true && $abort < 5) {
				
					$random = rand(1,$maxchance);
					asort($modules);
						
					foreach($modules as $name => $chance){
						$luck += $chance;
						if($random <= $luck && empty($post)){
							$post = $name;
						}
					} 
						
					if ($post == 'aa') {$result = ma_amazonpost($keyword,$cat,$aa,$which,$aadept,$aanode);$newnum = $aa +1;$aa++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$aa = 0;}if($result === "nothing") {$aa = ($aa +1) * -1;	}}
					elseif ($post == 'eza') {$result = ma_articlepost($keyword,$cat,$eza,$which);$newnum = $eza +1;$eza++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$eza = 0;}if($result === "nothing") {$eza = ($eza +1) * -1;	}}
					elseif ($post == 'cb') {$result = ma_clickbankpost($keyword,$cat,$cb,$which);$newnum = $cb +1;$cb++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$cb = 0;}if($result === "nothing") {$cb = ($cb +1) * -1;	}}
					elseif ($post == 'eb') {$result = ma_ebaypost($keyword,$cat,$eb,$which,$ebcat);$newnum = $eb +1;$eb++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$eb = 0;}if($result === "nothing") {$eb = ($eb +1) * -1;	}}
					elseif ($post == 'yap') {$result = ma_yahooanswerspost($keyword,$cat,$yap,$which,$yapcat);$newnum = $yap +1;$yap++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$yap = 0;}if($result === "nothing") {$yap = ($yap +1) * -1;	}}
					elseif ($post == 'yt') {$result = ma_youtubepost($keyword,$cat,$yt,$which);$newnum = $yt +1;$yt++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$yt = 0;}if($result === "nothing") {$yt = ($yt +1) * -1;	}}	
					elseif ($post == 'fl') {$result = ma_flickrpost($keyword,$cat,$fl,$which);$newnum = $fl +1;$fl++;if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$fl = 0;}if($result === "nothing") {$fl = ($fl +1) * -1;	}}	
					elseif ($post == 'yn') {$result = ma_yahoonewspost($keyword,$cat,$yn,$which);$newnum = $yn +1;$yn = $yn + get_option('ma_yan_newsnum');if(get_option('ma_resetcount') != "no" && $newnum > get_option('ma_resetcount')) {$yn = 0;}if($result === "nothing") {$yn = ($yn +1) * -1;	}}	

					// if result = true  -> inserted = true
					if ($result != false) {$inserted = true;} else {$inserted = false;}	
						$sql = "SELECT * FROM " . $ma_dbtable . " WHERE id = '$which'";	
						$update = $wpdb->get_row($sql);	
						if($result !== "nothing" && $result !== false) {$newtotal = $update->num_total + 1;} else {$newtotal = $update->num_total;}
						$sql = "UPDATE " . $ma_dbtable . " SET `num_amazon` = '$aa', `num_article` = '$eza', `num_clickbank` = '$cb', `num_ebay` = '$eb', `num_yahoo` = '$yap', `num_youtube` = '$yt', `num_flickr` = '$fl', `num_yn` = '$yn', `num_total` = '$newtotal' WHERE id = '$which'";
						$update = $wpdb->query($sql);	
						
					$abort++;
				}
				if($result === "nothing") {
				echo '<div class="updated"><p>I have nothing to do.</p></div>';
				} else {		
					if($inserted == true) {
						if (get_option('ma_randomize') == "yes") {
							$cr_interval = ma_get_string_between($postspan, "MA_", "_");
							$pos = strpos($postspan, 'days');
							if ($pos === false) {
								$cr_period = "hours";
							} else {
								$cr_period = "days";
							}					
							ma_set_schedule($cr_interval, $cr_period);
						}
						if($keyword != "") {$kw = $keyword;} else {$kw = $aanodename;}
						echo '<div class="updated"><p>Post created successfully for "'.$kw.'"!</p></div>';			
					} else {echo '<div class="updated"><p>Post could not be created, please try again!</p></div>';}			
				}
			}
		}
	}
}

class ma_linkcloaker {	
 var $linkno=0;
 var $myfile='';
 var $myfolder='';
 
function ma_linkcloaker(){
	$this->myfile = str_replace('\\', '/',__FILE__);
	$this->myfile = preg_replace('/^.*wp-content[\\\\\/]plugins[\\\\\/]/', '', $this->myfile);
	add_filter('the_content', array(&$this,'contentcloaker'), 2); 
	add_filter('mod_rewrite_rules', array(&$this,'rewriterules'));
}
 
function ma_esc($text){
	$text=strip_tags($text);
	$text=preg_replace('/[^a-z0-9_]+/i', '_', $text);	
	if(strlen($text)<1) { $text='link'; };	
	return $text;
}

function rewriter($matches){
	global $post;
	
	$this->linkno++;	
	$url = $matches[3];	
	$parts = @parse_url($url);
	
	if(!$parts || !isset($parts['scheme']) || !isset($parts['host'])) return $matches[0];
  
	if( preg_match('/www.amazon/i', $matches[3]) || preg_match('/clickbank/i', $matches[3]) || preg_match('/rover.ebay/i', $matches[3])) {
		$base = get_option( 'home' );
		if ( $base == '' ) {
			$base = get_option( 'siteurl' );
		}
		
		$url = trailingslashit($base)."go".'/'.$this->ma_esc($matches[5]).
			 '/'.($post->ID)."/".$this->linkno;
		
		$link = $matches[1].$matches[2].$url.$matches[2].$matches[4].$matches[5].$matches[6];
		
		return $link;	
	} else {return $matches[0];}
}

function contentcloaker($content){
	if(is_page()){
		return $content;
	} else {
	$this->linkno=0;
	$wplc_url_pattern='/(<a[\s]+[^>]*href\s*=\s*)([\"\'])([^\2>]+?)\2([^<>]*>)((?sU).*)(<\/a>)/i';
	$content=preg_replace_callback($wplc_url_pattern, array(&$this,'rewriter'), $content);
	return $content;
	}
}
 
function rewriterules($rules){
	global $wp_rewrite;

	$myfolder = basename(dirname(__FILE__));
	
	$redirector = WP_PLUGIN_URL . '/' . $myfolder . '/cloak.php';	

	$pattern = '^' . "go".'/([^/]*)/([0-9]+)/([0-9]+)/?$';
	$replacement=$redirector.'?post_id=$2&link_num=$3&cloaked_url=$0';
	
	$pattern_static = '^' . "go".'/([^/]+)[/]?$';
	$replacement_static=$redirector.'?name=$1&cloaked_url=$0';
	
	$cloakrules="\n# WP Robot Link Cloaking START\n";
	$cloakrules.="<IfModule mod_rewrite.c>\n";
	$cloakrules.="RewriteEngine On\n";
	$cloakrules.="RewriteRule $pattern $replacement [L]\n";
	$cloakrules.="RewriteRule $pattern_static $replacement_static [L]\n";
	$cloakrules.="</IfModule>\n";
	$cloakrules.="# WP Robot Link Cloaking END\n\n";
	
	$rules=$cloakrules.$rules;
	
	return $rules;
}

}
 
if(get_option('ma_cloak') == 'Yes') {
	$ma_linkcloaker = new ma_linkcloaker();
}

?>