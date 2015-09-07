<?php
/**
 Plugin Name: WP Robot
 Plugin URI: http://www.wprobot.net/
 Version: 2.01
 Description: Automatically post content related to any topic of your choice to your weblog.
 Author: Lunatic Studios
 Author URI: http://www.lunaticstudios.com/
 License: Commercial. For personal use only. Not to give away or resell
*/
/*  Copyright 2009 Lunatic Studios
*/

require_once("mainstall.php");
require_once("general.php");
		
function ma_add_pages() {
    add_menu_page('WP Robot', 'WP Robot', 8, __FILE__, 'ma_toplevel');
    add_submenu_page(__FILE__, 'Options', 'Options', 8, 'ma-options', 'ma_sub_options');
    add_submenu_page(__FILE__, 'Probabilities', 'Probabilities', 8, 'ma-propabilities', 'ma_sub_propabilities');
    add_submenu_page(__FILE__, 'Bulk Add', 'Bulk Add', 8, 'ma-bulkkws', 'ma_sub_bulk');	
    add_submenu_page(__FILE__, '', '', 8, 'ma-editkw', 'ma_editkw');	
}

function ma_resetred() {
	global $wpdb,$ma_dbtable;
	$sql = "UPDATE " . $ma_dbtable . " SET `num_amazon` = '0' WHERE `num_amazon` < '-1'";
	$update = $wpdb->query($sql);	
	$sql = "UPDATE " . $ma_dbtable . " SET `num_article` = '0' WHERE `num_article` < '-1'";
	$update = $wpdb->query($sql);		
	$sql = "UPDATE " . $ma_dbtable . " SET `num_ebay` = '0' WHERE `num_ebay` < '-1'";
	$update = $wpdb->query($sql);	
	$sql = "UPDATE " . $ma_dbtable . " SET `num_clickbank` = '0' WHERE `num_clickbank` < '-1'";
	$update = $wpdb->query($sql);	
	$sql = "UPDATE " . $ma_dbtable . " SET `num_flickr` = '0' WHERE `num_flickr` < '-1'";
	$update = $wpdb->query($sql);	
	$sql = "UPDATE " . $ma_dbtable . " SET `num_yahoo` = '0' WHERE `num_yahoo` < '-1'";
	$update = $wpdb->query($sql);	
	$sql = "UPDATE " . $ma_dbtable . " SET `num_youtube` = '0' WHERE `num_youtube` < '-1'";
	$update = $wpdb->query($sql);	
	$sql = "UPDATE " . $ma_dbtable . " SET `num_yn` = '0' WHERE `num_yn` < '-1'";
	$update = $wpdb->query($sql);		
}

function ma_editkw() {
   global $wpdb, $ma_dbtable, $modules;
   
	$which =$_GET['kw'];
		 
	$sql = "SELECT * FROM " . $ma_dbtable . " WHERE id = '$which'";
	$result = $wpdb->get_row($sql);	

	$aa = $result->num_amazon;
	$eza = $result->num_article;
	$cb = $result->num_clickbank;	
	$eb = $result->num_ebay;
	$yap = $result->num_yahoo;
	$yt = $result->num_youtube;	
	$fl = $result->num_flickr;	
	$yn = $result->num_yn;	
	
	$keyword = $result->keyword;
	$cat = $result->category;
	$aad = $result->amazoncat;
	$aanode = $result->amazonnode;	
	$ebcat = $result->ebaycat;
	$yapcat = $result->yapcat;	
	$postspanorig = $result->postspan;	
	$rss = $result->rssfeed;	
	$time = ma_get_string_between($postspanorig, "MA_", "_");
	
					$findMich   = 'days';
					$pos = strpos($postspanorig, $findMich);
					if ($pos === false) {
						$span = "hours";
					} else {
					    $span = "days";
					}	   
   
   	if($_POST['ma_update']){
	
	$id = $_POST['ma_id'];
	$postevery = $_POST['ma_postevery'];
	$cr_period = $_POST['ma_period'];
	
	$aa_department= $_POST['ma_aa_department'];
	$ebay_cat= $_POST['ma_eb_ebaycat'];	
	$yap_cat= $_POST['ma_yap_yacat'];
	$rssfeed= $_POST['ma_rssfeed'];;
	
	$postspan = "MA_" . $postevery . "_" . $cr_period;	

	if($postspan != $postspanorig) {		
		ma_set_schedule($postevery, $cr_period);	
		wp_reschedule_event( time(), $postspan, "maposthook", array($id) );
		// wp_schedule_event( time(), $postspan, "maposthook" , array($id) );
	}
	
	$keyword = $_POST['ma_keyword'];
	$amazonnode = $_POST['ma_aa_node'];	
	$category = $_POST['ma_category'];
    $update = "UPDATE " . $ma_dbtable . " SET postspan = '$postspan', keyword = '$keyword', ebaycat = '$ebay_cat', yapcat = '$yap_cat', amazoncat = '$aa_department', category = '$category', amazonnode = '$amazonnode', rssfeed = '$rssfeed'";
 
	if ($_POST['ma_post_aa'] != 'yes') {$update .= ", num_amazon = '-1'";} elseif($aa < 0 && $_POST['ma_post_aa'] == 'yes') {$update .= ", num_amazon = '0'";}
	if ($_POST['ma_post_cb'] != 'yes') {$update .= ", num_clickbank = '-1'";} elseif($cb < 0 && $_POST['ma_post_cb'] == 'yes') {$update .= ", num_clickbank = '0'";}
	if ($_POST['ma_post_eb'] != 'yes') {$update .= ", num_ebay = '-1'";} elseif($eb < 0 && $_POST['ma_post_eb'] == 'yes') {$update .= ", num_ebay = '0'";}
	if ($_POST['ma_post_yap'] != 'yes') {$update .= ", num_yahoo = '-1'";} elseif($yap < 0 && $_POST['ma_post_yap'] == 'yes') {$update .= ", num_yahoo = '0'";}
	if ($_POST['ma_post_yt'] != 'yes') {$update .= ", num_youtube = '-1'";} elseif($yt < 0 && $_POST['ma_post_yt'] == 'yes') {$update .= ", num_youtube = '0'";}
	if ($_POST['ma_post_eza'] != 'yes') {$update .= ", num_article = '-1'";}  elseif($eza < 0 && $_POST['ma_post_eza'] == 'yes') {$update .= ", num_article = '0'";}
	if ($_POST['ma_post_fl'] != 'yes') {$update .= ", num_flickr = '-1'";}  elseif($fl < 0 && $_POST['ma_post_fl'] == 'yes') {$update .= ", num_flickr = '0'";}
	if ($_POST['ma_post_yn'] != 'yes') {$update .= ", num_yn = '-1'";}  elseif($yn < 0 && $_POST['ma_post_yn'] == 'yes') {$update .= ", num_yn = '0'";}	
	$update .= " WHERE id = $id";
	
	$results = $wpdb->query($update);

	if ($results) {
		echo '<div class="updated"><p>Keyword '.$keyword.' updated! <a href="admin.php?page=WPRobot/wprobot.php">Go back</a></p></div>';		
			if($postspan != $postspanorig) {ma_delete_schedule($time, $span);}
	} else {
		echo '<div class="updated"><p>Keyword could not be updated! <a href="admin.php?page=WPRobot/wprobot.php">Go back</a></p></div>';			
	}	
	
	} elseif($_GET['kw'] != "") {
		if($rss == "") {
?>
	<div class="wrap">
	<h2>Edit Keyword</h2>
	<form method="post" id="ma_editkw">
	
		<div style="padding:8px;margin-top: 4px;border:1px solid #e3e3e3;-moz-border-radius:5px;width:700px;background-color:#ececec;">	
		<table>
		
		  <tr>
		    <td width="220px"><input style="display:none;" name="ma_id" type="text" id="ma_id" value="<?php echo $which;?>"/><b>Main Settings</b></td>
		    <td width="200px"><b>What to Post?</b></td>
		    <td><b>Optional Settings</b></td>
		  </tr>		
		
		  <tr>
		    <td rowspan="2">
			Keyword:<br/><input name="ma_keyword" type="text" id="ma_keyword" value="<?php echo $keyword;?>"/>
			</td>
		    <td><input name="ma_post_aa" type="checkbox" id="ma_post_aa" value="yes" <?php if(function_exists('ma_amazonpost') && $aa != -1) {echo "checked";} elseif($aa == -1) {} else {echo "disabled";} ?> /> Amazon Products</td>
			<!-- AMAZON DEPARTMENT -->
		    <td rowspan="2">
				Amazon Department and BrowseNode:<br/>
			<?php $ll = get_option('ma_aa_site'); if($ll == "us") {$ll = "com";} ?>
				<select name="ma_aa_department" id="ma_aa_department">
					<option>All</option>
					<?php if($ll!="fr" || $ll!="ca") {?><option <?php if($aad == "Apparel") {echo "selected";} ?>>Apparel</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option <?php if($aad == "Automotive") {echo "selected";} ?>>Automotive</option><?php } ?>
					<?php if($ll!="ca") {?><option <?php if($aad == "Baby") {echo "selected";} ?>>Baby</option><?php } ?>
					<?php if($ll!="uk" || $ll!="de") {?><option <?php if($aad == "Beauty") {echo "selected";} ?>>Beauty</option><?php } ?>
					<option <?php if($aad == "Books") {echo "selected";} ?>>Books</option>
					<option <?php if($aad == "Classical") {echo "selected";} ?>>Classical</option>
					<?php if($ll=="com") {?><option value="DigitalMusic" <?php if($aad == "DigitalMusic") {echo "selected";} ?>>Digital Music</option><?php } ?>
					<?php if($ll!="jp" || $ll!="ca") {?><option value="MP3Downloads" <?php if($aad == "MP3Downloads") {echo "selected";} ?>>MP3 Downloads</option><?php } ?>
					<option <?php if($aad == "DVD") {echo "selected";} ?>>DVD</option>
					<option <?php if($aad == "Electronics") {echo "selected";} ?>>Electronics</option>
					<?php if($ll!="com" || $ll!="uk") {?><option value="ForeignBooks" <?php if($aad == "ForeignBooks") {echo "selected";} ?>>Foreign Books</option><?php } ?>
					<?php if($ll=="com") {?><option value="GourmetFood" <?php if($aad == "GourmetFood") {echo "selected";} ?>>Gourmet Food</option><?php } ?>
					<?php if($ll=="com") {?><option value="Grocery" <?php if($aad == "Grocery") {echo "selected";} ?>>Grocery</option><?php } ?>
					<?php if($ll!="ca") {?><option value="HealthPersonalCare" <?php if($aad == "HealthPersonalCare") {echo "selected";} ?>>Health &amp; Personal Care</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="HomeGarden" <?php if($aad == "HomeGarden") {echo "selected";} ?>>Home &amp; Garden</option><?php } ?>
					<?php if($ll=="com") {?><option <?php if($aad == "Industrial") {echo "selected";} ?>>Industrial</option><?php } ?>
					<?php if($ll!="ca") {?><option <?php if($aad == "Jewelry") {echo "selected";} ?>>Jewelry</option><?php } ?>
					<?php if($ll=="com") {?><option value="KindleStore" <?php if($aad == "KindleStore") {echo "selected";} ?>>Kindle Store</option><?php } ?>
					<?php if($ll!="ca") {?><option <?php if($aad == "Kitchen") {echo "selected";} ?>>Kitchen</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option <?php if($aad == "Magazines") {echo "selected";} ?>>Magazines</option><?php } ?>
					<?php if($ll=="com") {?><option <?php if($aad == "Merchants") {echo "selected";} ?>>Merchants</option><?php } ?>
					<?php if($ll=="com") {?><option <?php if($aad == "Miscellaneous") {echo "selected";} ?>>Miscellaneous</option><?php } ?>
					<option <?php if($aad == "Music") {echo "selected";} ?>>Music</option>
					<?php if($ll=="com") {?><option value="MusicalInstruments" <?php if($aad == "MusicalInstruments") {echo "selected";} ?>>Musical Instruments</option><?php } ?>
					<?php if($ll!="ca") {?><option value="MusicTracks" <?php if($aad == "MusicTracks") {echo "selected";} ?>>Music Tracks</option><?php } ?>
					<?php if($ll!="jp" || $ll!="ca") {?><option value="OfficeProducts" <?php if($aad == "OfficeProducts") {echo "selected";} ?>>Office Products</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="OutdoorLiving" <?php if($aad == "OutdoorLiving") {echo "selected";} ?>>Outdoor &amp; Living</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option value="PCHardware" <?php if($aad == "PCHardware") {echo "selected";} ?>>PC Hardware</option><?php } ?>
					<?php if($ll=="com") {?><option value="PetSupplies" <?php if($aad == "PetSupplies") {echo "selected";} ?>>Pet Supplies</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option <?php if($aad == "Photo") {echo "selected";} ?>>Photo</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option <?php if($aad == "Shoes") {echo "selected";} ?>>Shoes</option><?php } ?>
					<option <?php if($aad == "Software") {echo "selected";} ?>>Software</option>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="SportingGoods" <?php if($aad == "SportingGoods") {echo "selected";} ?>>Sporting Goods</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option <?php if($aad == "Tools") {echo "selected";} ?>>Tools</option><?php } ?>
					<?php if($ll!="ca") {?><option <?php if($aad == "Toys") {echo "selected";} ?>>Toys</option><?php } ?>
					<option value="UnboxVideo" <?php if($aad == "UnboxVideo") {echo "selected";} ?>>Unbox Video</option>
					<option <?php if($aad == "VHS") {echo "selected";} ?>>VHS</option>
					<option <?php if($aad == "Video") {echo "selected";} ?>>Video</option>
					<option value="VideoGames" <?php if($aad == "VideoGames") {echo "selected";} ?>>Video Games</option>
					<?php if($ll!="jp" || $ll!="ca") {?><option <?php if($aad == "Watches") {echo "selected";} ?>>Watches</option><?php } ?>
					<?php if($ll=="com") {?><option <?php if($aad == "Wireless") {echo "selected";} ?>>Wireless</option><?php } ?>
					<?php if($ll=="com") {?><option value="WirelessAccessories" <?php if($aad == "WirelessAccessories") {echo "selected";} ?>>Wireless Accessories</option><?php } ?>         			
				</select><input name="ma_aa_node" size="10" type="text" id="ma_aa_node" value="<?php echo $aanode;?>"/>	
				</td>
		  </tr>
		  <tr>
		    <td><input name="ma_post_eza" type="checkbox" id="ma_post_eza" value="yes" <?php if(function_exists('ma_articlepost') && $eza != -1) {echo "checked";} elseif($eza == -1) {} else {echo "disabled";} ?> /> Articles</td>
		  </tr>	  
		  <tr>
		    <td rowspan="2">
			Category:<br/>
				<select name="ma_category" id="ma_category">				
				<?php
				   				   $categories = get_categories('type=post&hide_empty=0');
				   				   foreach($categories as $category) {
										if($cat == $category->cat_ID) {
											echo '<option value="'.$category->cat_ID.'" selected>'.$category->cat_name.'</option>';
										} else {
											echo '<option value="'.$category->cat_ID.'">'.$category->cat_name.'</option>';
										}
									}				
				?>				
				</select>				
			</td>
		    <td><input name="ma_post_cb" type="checkbox" id="ma_post_cb" value="yes" <?php if(function_exists('ma_clickbankpost') && $cb != -1) {echo "checked";} elseif($cb == -1) {} else {echo "disabled";} ?> /> Clickbank Ads</td>
			<!-- AMAZON DEPARTMENT -->
		    <td rowspan="2">
				eBay Category:<br/>
				<select name="ma_eb_ebaycat" id="ma_eb_ebaycat">
					<option value="all" <?php if($ebcat == "all") {echo "selected";} ?>>All Categories</option>
					<option value="20081" <?php if($ebcat == "20081") {echo "selected";} ?>>Antiques</option>
					<option value="550" <?php if($ebcat == "550") {echo "selected";} ?>>Art</option>
					<option value="2984" <?php if($ebcat == "2984") {echo "selected";} ?>>Baby</option>
					<option value="267" <?php if($ebcat == "267") {echo "selected";} ?>>Books</option>
					<option value="12576" <?php if($ebcat == "12576") {echo "selected";} ?>>Business &amp; Industrial</option>
					<option value="625" <?php if($ebcat == "625") {echo "selected";} ?>>Cameras &amp; Photo</option>
					<option value="15032" <?php if($ebcat == "15032") {echo "selected";} ?>>Cell Phones &amp; PDAs</option>
					<option value="11450" <?php if($ebcat == "11450") {echo "selected";} ?>>Clothing, Shoes &amp; Accessories</option>
					<option value="11116" <?php if($ebcat == "11116") {echo "selected";} ?>>Coins &amp; Paper Money</option>
					<option value="1" <?php if($ebcat == "1") {echo "selected";} ?>>Collectibles</option>
					<option value="58058" <?php if($ebcat == "58058") {echo "selected";} ?>>Computers &amp; Networking</option>
					<option value="14339" <?php if($ebcat == "14339") {echo "selected";} ?>>Crafts</option>
					<option value="237" <?php if($ebcat == "237") {echo "selected";} ?>>Dolls &amp; Bears</option>
					<option value="11232" <?php if($ebcat == "11232") {echo "selected";} ?>>DVDs &amp; Movies</option>
					<option value="6000" <?php if($ebcat == "6000") {echo "selected";} ?>>eBay Motors</option>
					<option value="293" <?php if($ebcat == "293") {echo "selected";} ?>>Electronics</option>
					<option value="45100" <?php if($ebcat == "45100") {echo "selected";} ?>>Entertainment Memorabilia</option>
					<option value="31411" <?php if($ebcat == "31411") {echo "selected";} ?>>Gift Certificates</option>
					<option value="26395" <?php if($ebcat == "26395") {echo "selected";} ?>>Health &amp; Beauty</option>
					<option value="11700" <?php if($ebcat == "11700") {echo "selected";} ?>>Home &amp; Garden</option>
					<option value="281" <?php if($ebcat == "281") {echo "selected";} ?>>Jewelry &amp; Watches</option>
					<option value="11233" <?php if($ebcat == "11233") {echo "selected";} ?>>Music</option>
					<option value="619" <?php if($ebcat == "619") {echo "selected";} ?>>Musical Instruments</option>
					<option value="870" <?php if($ebcat == "870") {echo "selected";} ?>>Pottery &amp; Glass</option>
					<option value="10542" <?php if($ebcat == "10542") {echo "selected";} ?>>Real Estate</option>
					<option value="316" <?php if($ebcat == "316") {echo "selected";} ?>>Specialty Services</option>
					<option value="382" <?php if($ebcat == "382") {echo "selected";} ?>>Sporting Goods</option>
					<option value="64482" <?php if($ebcat == "64482") {echo "selected";} ?>>Sports Mem, Cards &amp; Fan Shop</option>
					<option value="260" <?php if($ebcat == "260") {echo "selected";} ?>>Stamps</option>
					<option value="1305" <?php if($ebcat == "1305") {echo "selected";} ?>>Tickets</option>
					<option value="220" <?php if($ebcat == "220") {echo "selected";} ?>>Toys &amp; Hobbies</option>
					<option value="3252" <?php if($ebcat == "3252") {echo "selected";} ?>>Travel</option>
					<option value="1249" <?php if($ebcat == "1249") {echo "selected";} ?>>Video Games</option>
					<option value="99" <?php if($ebcat == "99") {echo "selected";} ?>>Everything Else</option>
				</select>		
				</td>
		  </tr>
		  <tr>
		    <td><input name="ma_post_eb" type="checkbox" id="ma_post_eb" value="yes" <?php if(function_exists('ma_ebaypost') && $eb != -1) {echo "checked";} elseif($eb == -1) {} else {echo "disabled";} ?> /> eBay Auctions</td>
		  </tr>		
		  <tr>
		    <td rowspan="2">
			Post every:<br/>
				<input size="5" name="ma_postevery" type="text" id="ma_postevery" value="<?php echo $time;?>"/>
				<select name="ma_period" id="ma_period">
					<option value="hours" <?php if($span == "hours") {echo "selected";} ?>>Hours</option>
					<option value="days" <?php if($span == "days") {echo "selected";} ?>>Days</option>
				</select>					
			</td>
		    <td><input name="ma_post_yap" type="checkbox" id="ma_post_yap" value="yes" <?php if(function_exists('ma_yahooanswerspost') && $yap != -1) {echo "checked";} elseif($yap == -1) {} else {echo "disabled";} ?> /> Yahoo Answers</td>
			<!-- AMAZON DEPARTMENT -->
		    <td rowspan="2">
				Yahoo Answers Category:<br/>
				<select name="ma_yap_yacat" id="ma_yap_yacat">				
					<option value="" <?php if($yapcat == "") {echo "selected";} ?>> All </option>
					<option value="396545012" <?php if($yapcat == "396545012") {echo "selected";} ?>>Arts &amp; Humanities</option>
					<option value="396545144" <?php if($yapcat == "396545144") {echo "selected";} ?>>Beauty &amp; Style</option>
					<option value="396545013" <?php if($yapcat == "396545013") {echo "selected";} ?>>Business &amp; Finance</option>
					<option value="396545311" <?php if($yapcat == "396545311") {echo "selected";} ?>>Cars &amp; Transportation</option>
					<option value="396545660" <?php if($yapcat == "396545660") {echo "selected";} ?>>Computers &amp; Internet</option>
					<option value="396545014" <?php if($yapcat == "396545014") {echo "selected";} ?>>Consumer Electronics</option>
					<option value="396545327" <?php if($yapcat == "396545327") {echo "selected";} ?>>Dining Out</option>
					<option value="396545015" <?php if($yapcat == "396545015") {echo "selected";} ?>>Education &amp; Reference</option>
					<option value="396545016" <?php if($yapcat == "396545016") {echo "selected";} ?>>Entertainment &amp; Music</option>
					<option value="396545451" <?php if($yapcat == "396545451") {echo "selected";} ?>>Environment</option>
					<option value="396545433" <?php if($yapcat == "396545433") {echo "selected";} ?>>Family &amp; Relationships</option>
					<option value="396545367" <?php if($yapcat == "396545367") {echo "selected";} ?>>Food &amp; Drink</option>
					<option value="396545019" <?php if($yapcat == "396545019") {echo "selected";} ?>>Games &amp; Recreation</option>
					<option value="396545018" <?php if($yapcat == "396545018") {echo "selected";} ?>>Health</option>
					<option value="396545394" <?php if($yapcat == "396545394") {echo "selected";} ?>>Home &amp; Garden</option>
					<option value="396545401" <?php if($yapcat == "396545401") {echo "selected";} ?>>Local Businesses</option>
					<option value="396545439" <?php if($yapcat == "396545439") {echo "selected";} ?>>News &amp; Events</option>
					<option value="396545443" <?php if($yapcat == "396545443") {echo "selected";} ?>>Pets</option>
					<option value="396545444" <?php if($yapcat == "396545444") {echo "selected";} ?>>Politics &amp; Government</option>
					<option value="396546046" <?php if($yapcat == "396546046") {echo "selected";} ?>>Pregnancy &amp; Parenting</option>
					<option value="396545122" <?php if($yapcat == "396545122") {echo "selected";} ?>>Science &amp; Mathematics</option>
					<option value="396545301" <?php if($yapcat == "396545301") {echo "selected";} ?>>Social Science</option>
					<option value="396545454" <?php if($yapcat == "396545454") {echo "selected";} ?>>Society &amp; Culture</option>
					<option value="396545213" <?php if($yapcat == "396545213") {echo "selected";} ?>>Sports</option>
					<option value="396545469" <?php if($yapcat == "396545469") {echo "selected";} ?>>Travel</option>
					<option value="396546089" <?php if($yapcat == "396546089") {echo "selected";} ?>>Yahoo! Products</option>				
				</select>	
				</td>
		  </tr>
		  <tr>
		    <td><input name="ma_post_yt" type="checkbox" id="ma_post_yt" value="yes" <?php if(function_exists('ma_youtubepost') && $yt != -1) {echo "checked";} elseif($yt == -1) {} else {echo "disabled";} ?> /> Youtube Videos</td>
		  </tr>	
		  
		  <tr>
		    <td rowspan="2">
		<p class="submit" style="margin:0;"><input class="button-primary" type="submit" name="ma_update" value="Save Changes" /></p>			
			</td>
				<td><input name="ma_post_fl" type="checkbox" id="ma_post_fl" value="yes" <?php if(function_exists('ma_flickrpost') && $fl != -1) {echo "checked";} elseif($fl == -1) {} else {echo "disabled";} ?> /> Flickr Images</td>
		    <td rowspan="2"></td>
			</tr>	
			
		  <tr>
		    <td><input name="ma_post_yn" type="checkbox" id="ma_post_yn" value="yes" <?php if(function_exists('ma_yahoonewspost') && $yn != -1) {echo "checked";} elseif($yn == -1) {} else {echo "disabled";} ?> /> Yahoo News</td>
		  </tr>	
		  
		</table>	
		
		</div>
	<?php } else { ?>
	
	<div class="wrap">
	<h2>Edit RSS Feed</h2>
	<form method="post" id="ma_editkw">	
	
		<div style="padding:8px;margin-top: 4px;border:1px solid #e3e3e3;-moz-border-radius:5px;width:700px;background-color:#ececec;">	
		<table>			
		  <tr>
		    <td width="180px">
			Feed:<br/><input name="ma_rssfeed" type="text" id="ma_rssfeed" value="<?php echo $rss; ?>"/>
			<input style="display:none;" name="ma_id" type="text" id="ma_id" value="<?php echo $which;?>"/></td>
		    <td width="180px">	
				Category:<br/>
				<select name="ma_category" id="ma_category">				
				<?php
				   				   $categories = get_categories('type=post&hide_empty=0');
				   				   foreach($categories as $category) {
										if($cat == $category->cat_ID) {
											echo '<option value="'.$category->cat_ID.'" selected>'.$category->cat_name.'</option>';
										} else {
											echo '<option value="'.$category->cat_ID.'">'.$category->cat_name.'</option>';
										}
									}				
				?>				
				</select>			
			</td>

		    <td>
			Post every:<br/>
				<input size="5" name="ma_postevery" type="text" id="ma_postevery" value="<?php echo $time;?>"/>
				<select name="ma_period" id="ma_period">
					<option value="hours" <?php if($span == "hours") {echo "selected";} ?>>Hours</option>
					<option value="days" <?php if($span == "days") {echo "selected";} ?>>Days</option>
				</select>				
			</td>
		  </tr>
	  
		</table>		
		<p class="submit" style="margin:0;padding: 10px 0;"><input class="button-primary" type="submit" name="ma_update" value="Save Changes" /></p>			
		

		</div>
	<?php } ?>
		
</form>		
</div>
<?php	
	} else {
	?>
	<div class="wrap">
	<h2>Edit Keyword</h2>
		<p>No keyword specified. Go back and select one!</p>
	</div>	
	<?php
	}	 
}


function ma_sub_options() {

	if($_POST['ma_reset']){
		ma_reset_options();
		echo '<div class="updated"><p>Options reset successfully!</p></div>';
	}
	if($_POST['ma_pop']){
		ma_default();
		echo '<div class="updated"><p>New options populated!</p></div>';
	}
	if($_POST['ma_save']){
			$_POST['ma_aa_template'] = str_replace('\"', '"', $_POST['ma_aa_template']);	
			$_POST['ma_eza_template'] = str_replace('\"', '"', $_POST['ma_eza_template']);
			$_POST['ma_cb_template'] = str_replace('\"', '"', $_POST['ma_cb_template']);
			$_POST['ma_eb_template'] = str_replace('\"', '"', $_POST['ma_eb_template']);
			$_POST['ma_yap_template'] = str_replace('\"', '"', $_POST['ma_yap_template']);
			$_POST['ma_yt_template'] = str_replace('\"', '"', $_POST['ma_yt_template']);
			$_POST['ma_fl_template'] = str_replace('\"', '"', $_POST['ma_fl_template']);
			$_POST['ma_yn_template'] = str_replace('\"', '"', $_POST['ma_yn_template']);
			$_POST['ma_rss_template'] = str_replace('\"', '"', $_POST['ma_rss_template']);
			
			update_option('ma_resetcount',$_POST['ma_resetcount']);
			update_option('ma_autotag',$_POST['ma_autotag']);
			update_option('ma_badwords',$_POST['ma_badwords']);
			update_option('ma_randomstart1',$_POST['ma_randomstart1']);
			update_option('ma_randomstart2',$_POST['ma_randomstart2']);
			update_option('ma_randomize',$_POST['ma_randomize']);
			update_option('ma_poststatus',$_POST['ma_poststatus']);
			update_option('ma_cb_template',$_POST['ma_cb_template']);
			update_option('ma_cb_affkey',$_POST['ma_cb_affkey']);		
			update_option('ma_cb_filter',$_POST['ma_cb_filter']);	
			update_option('ma_cloak',$_POST['ma_cloak']);			
			if(function_exists('ma_articlepost')) {
			update_option('ma_eza_grabmethod',$_POST['ma_eza_grabmethod']);
			update_option('ma_eza_template',$_POST['ma_eza_template']);
			update_option('ma_eza_source',$_POST['ma_eza_source']);
			update_option('ma_eza_lang',$_POST['ma_eza_lang']);
			} if(function_exists('ma_amazonpost')) {
			update_option('ma_aa_affkey',$_POST['ma_aa_affkey']);
			update_option('ma_aa_apikey',$_POST['ma_aa_apikey']);
			update_option('ma_aa_secretkey',$_POST['ma_aa_secretkey']);
			update_option('ma_aa_skip',$_POST['ma_aa_skip']);
			update_option('ma_aa_revtemplate',$_POST['ma_aa_revtemplate']);
			update_option('ma_aa_postreviews',$_POST['ma_aa_postreviews']);
			update_option('ma_aa_excerptlength',$_POST['ma_aa_excerptlength']);
			update_option('ma_aa_site',$_POST['ma_aa_site']);	
			update_option('ma_aa_template',$_POST['ma_aa_template']);	
			update_option('ma_aa_striptitle',$_POST['ma_aa_striptitle']);
			update_option('ma_aa_searchmode',$_POST['ma_aa_searchmode']);
			} if(function_exists('ma_ebaypost')) {
			update_option('ma_eb_affkey',$_POST['ma_eb_affkey']);
			update_option('ma_eb_lang',$_POST['ma_eb_lang']);
			update_option('ma_eb_auctionnum',$_POST['ma_eb_auctionnum']);
			update_option('ma_eb_country',$_POST['ma_eb_country']);
			update_option('ma_eb_sortby',$_POST['ma_eb_sortby']);	
			update_option('ma_eb_template',$_POST['ma_eb_template']);	
			update_option('ma_eb_postrss',$_POST['ma_eb_postrss']);	
			update_option('ma_eb_titlet',$_POST['ma_eb_titlet']);	
			} if(function_exists('ma_yahooanswerspost')) {
			update_option("ma_yap_appkey",$_POST['ma_yap_appkey']);
			update_option("ma_yap_lang",$_POST['ma_yap_lang']);
			update_option('ma_yap_yatos',$_POST['ma_yap_yatos']);	
			update_option('ma_yap_template',$_POST['ma_yap_template']);	
			update_option('ma_ya_striplinks_q',$_POST['ma_ya_striplinks_q']);	
			update_option('ma_ya_striplinks_a',$_POST['ma_ya_striplinks_a']);	
			} if(function_exists('ma_youtubepost')) {
			update_option('ma_yt_template',$_POST['ma_yt_template']);	
			update_option('ma_yt_comments',$_POST['ma_yt_comments']);
			update_option('ma_yt_width',$_POST['ma_yt_width']);	
			update_option('ma_yt_height',$_POST['ma_yt_height']);	
			update_option('ma_yt_lang',$_POST['ma_yt_lang']);	
			update_option('ma_yt_safe',$_POST['ma_yt_safe']);				
			update_option('ma_yt_sort',$_POST['ma_yt_sort']);
			update_option('ma_yt_striplinks_desc',$_POST['ma_yt_striplinks_desc']);		
			update_option('ma_yt_striplinks_comm',$_POST['ma_yt_striplinks_comm']);		
			} if(function_exists('ma_flickrpost')) {
			update_option('ma_fl_template',$_POST['ma_fl_template']);	
			update_option('ma_fl_apikey',$_POST['ma_fl_apikey']);		
			update_option('ma_fl_content',$_POST['ma_fl_content']);
			update_option('ma_fl_sort',$_POST['ma_fl_sort']);
			update_option('ma_fl_license',$_POST['ma_fl_license']);
			update_option('ma_fl_size',$_POST['ma_fl_size']);
			update_option('ma_fl_width',$_POST['ma_fl_width']);
			update_option('ma_fl_twidth',$_POST['ma_fl_twidth']);
			} if(function_exists('ma_translate')) {	
			update_option('ma_translate0',$_POST['ma_translate0']);			
			update_option('ma_translate1',$_POST['ma_translate1']);
			update_option('ma_translate2',$_POST['ma_translate2']);
			update_option('ma_translate3',$_POST['ma_translate3']);		
			update_option('ma_transsite', $_POST['ma_transsite']);
			update_option('ma_trans_article',$_POST['ma_trans_article']);
			update_option('ma_trans_articlebox',$_POST['ma_trans_articlebox']);
			update_option('ma_trans_cbads',$_POST['ma_trans_cbads']);
			update_option('ma_trans_aadesc',$_POST['ma_trans_aadesc']);
			update_option('ma_trans_aarfull',$_POST['ma_trans_aarfull']);
			update_option('ma_trans_yapa',$_POST['ma_trans_yapa']);
			update_option('ma_trans_yapq',$_POST['ma_trans_yapq']);
			update_option('ma_trans_ytdesc',$_POST['ma_trans_ytdesc']);
			update_option('ma_trans_ytcom',$_POST['ma_trans_ytcom']);
			update_option('ma_trans_rss',$_POST['ma_trans_rss']);
			update_option('ma_trans_title',$_POST['ma_trans_title']);
			} if(function_exists('ma_yahoonewspost')) {
			update_option("ma_yan_appkey",$_POST['ma_yan_appkey']);
			update_option("ma_yan_lang",$_POST['ma_yan_lang']);
			update_option('ma_yan_newsnum',$_POST['ma_yan_newsnum']);	
			update_option('ma_yan_titlet',$_POST['ma_yan_titlet']);	
			update_option('ma_yan_template',$_POST['ma_yan_template']);				
			} if(function_exists('ma_rsspost')) {	
			update_option('ma_rss_content',$_POST['ma_rss_content']);
			update_option('ma_rss_template',$_POST['ma_rss_template']);		
			update_option('ma_rss_comments',$_POST['ma_rss_comments']);	
			update_option('ma_rss_striplinks',$_POST['ma_rss_striplinks']);			
			}			
			echo '<div class="updated"><p>Options updated successfully!</p></div>';
			
			if($_POST['ma_cloak'] == "Yes") {
				echo '<div class="updated"><p>Link cloaking has been enabled but <b>additional steps are required</b> to set it up!<br/>Please follow the instructions in <a href="http://wprobot.net/blog/how-to-set-up-wp-robot-link-cloaking">this post</a>. Otherwise your affiliate links will not work!</p></div>';			
			}			
		}
		
?>
	<div class="wrap">
	<h2>WP Robot</h2>
	<form method="post" id="ma_options">	
	
	<h3>General Options</h3>	
		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 			
			<tr valign="top"> 
				<td width="30%" scope="row">New Post Status:</td>
				<td>
				<select name="ma_poststatus" id="ma_poststatus">
					<option <?php if (get_option('ma_poststatus')=='published') {echo 'selected';} ?>>published</option>
					<option <?php if (get_option('ma_poststatus')=='draft') {echo 'selected';} ?>>draft</option>
				</select>
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Reset Post Count:</td>
				<td>
				<select name="ma_resetcount" id="ma_resetcount">
					<option <?php if (get_option('ma_resetcount')=='no') {echo 'selected';} ?>>no</option>
					<option <?php if (get_option('ma_resetcount')=='25') {echo 'selected';} ?>>25</option>
					<option <?php if (get_option('ma_resetcount')=='50') {echo 'selected';} ?>>50</option>					
					<option <?php if (get_option('ma_resetcount')=='75') {echo 'selected';} ?>>75</option>					
					<option <?php if (get_option('ma_resetcount')=='100') {echo 'selected';} ?>>100</option>
					<option <?php if (get_option('ma_resetcount')=='150') {echo 'selected';} ?>>150</option>
					<option <?php if (get_option('ma_resetcount')=='200') {echo 'selected';} ?>>200</option>					
				</select><a href="http://wprobot.net/documentation/#32"><b>?</b></a>
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Randomize time of first post:</td> 
				<td>
				between <input id="ma_randomstart1" size="7" value="<?php echo get_option('ma_randomstart1'); ?>" name="ma_randomstart1"/> and <input id="ma_randomstart2" size="7" value="<?php echo get_option('ma_randomstart2'); ?>" name="ma_randomstart2"/> hours from now
				(<a href="http://wprobot.net/documentation/#32"><b>?</b></a>)</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Randomize Post Times</td> 
				<td>
				<input name="ma_randomize" type="checkbox" id="ma_randomize" value="Yes" <?php if (get_option('ma_randomize')=='Yes') {echo "checked";} ?>/> Yes		
				</td> 
			</tr>	
			<tr valign="top"> 
				<td width="30%" scope="row">Cloak Affiliate Links</td> 
				<td>
				<input name="ma_cloak" type="checkbox" id="ma_cloak" value="Yes" <?php if (get_option('ma_cloak')=='Yes') {echo "checked";} ?>/> Yes				
				</td> 
			</tr>				
			<tr valign="top"> 
				<td width="30%" scope="row">Automatically create Tags:</td>
				<td>
				<input name="ma_autotag" type="checkbox" id="ma_autotag" value="Yes" <?php if (get_option('ma_autotag')=='Yes') {echo "checked";} ?>/> Yes
				</td> 
			</tr>
			<tr valign="top"> 
				<td width="30%" scope="row">Exclude from Tags:<br/><small>Words with 3 characters and less are automatically excluded</small></td> 
				<td>			
			<textarea name="ma_badwords" rows="2" cols="30"><?php echo get_option('ma_badwords');?></textarea>	
				</td> 
			</tr>							
		</table>

	<h3>Amazon Options</h3>
	<?php 	if(function_exists('ma_amazonpost')) {
				ma_aa_options();
			} else {echo '<p>Amazon module is not installed. Get it <a href="http://wprobot.net/modules/amazon.php">here</a>!';} ?>
	
	<h3>Article Options</h3>
	<?php 	if(function_exists('ma_articlepost')) { 
				ma_eza_options();
			} else {echo '<p>Article module is not installed. Get it <a href="http://wprobot.net/modules/article.php">here</a>!';} ?>
		
	<h3>Clickbank Options</h3>
	<?php 	if(function_exists('ma_clickbankpost')) { 
				ma_cb_options();
			} else {echo '<p>Clickbank module is not installed.';} ?>
				
	<h3>eBay Options</h3>
	<?php 	if(function_exists('ma_ebaypost')) {
				ma_eb_options();
			} else {echo '<p>eBay module is not installed. Get it <a href="http://wprobot.net/modules/ebay.php">here</a>!';} ?>

	<h3>Yahoo Answers Options</h3>	
	<?php 	if(function_exists('ma_yahooanswerspost')) {
				ma_yap_options();
			} else {echo '<p>Yahoo Answers module is not installed. Get it <a href="http://wprobot.net/modules/yahoo.php">here</a>!';} ?>
		
	<h3>Youtube Options</h3>
	<?php 	if(function_exists('ma_youtubepost')) {		
				ma_yt_options();
			} else {echo '<p>Youtube module is not installed. Get it <a href="http://wprobot.net/modules/youtube.php">here</a>!';} ?>

	<h3>Flickr Options</h3>			
	<?php 	if(function_exists('ma_flickrpost')) {	
				ma_fl_options();
			} else {echo '<p>Flickr module is not installed. Get it <a href="http://wprobot.net/modules/flickr.php">here</a>!';} ?>

	<h3>Yahoo News Options</h3>			
	<?php 	if(function_exists('ma_yahoonewspost')) {	
				ma_yn_options();
			} else {echo '<p>Yahoo News module is not installed. Get it <a href="http://wprobot.net/modules/yahoonews.php">here</a>!';} ?>
		
	<h3>RSS Options</h3>			
	<?php 	if(function_exists('ma_rsspost')) {	
				ma_rss_options();
			} else {echo '<p>RSS module is not installed. Get it <a href="http://wprobot.net/modules/rss.php">here</a>!';} ?>
				
	<h3>Translation Options</h3>
	<?php   if(function_exists('ma_translate')) {	
				ma_tr_options();
			} else {echo '<p>Translation module is not installed. Get it <a href="http://wprobot.net/modules/translation.php">here</a>!';} ?>
			
		<p class="submit"><input class="button-primary" type="submit" name="ma_save" value="Save Options" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="submit" name="ma_reset" value="Reset to Default" /> <input type="submit" name="ma_pop" value="Populate new Options" /></p>
	</form>	

<h3>Quick Links</h3>
<p><a href="http://wprobot.net/">WP Robot</a> - <a href="http://wprobot.net/documentation/">Documentation</a> - <a href="http://wprobot.net/forum/">Support Forum</a> - <a href="http://wprobot.net/affiliate-program.php">Affiliate Program</a></p>
	
	</div>
<?php		
}

function ma_sub_propabilities() {

	if($_POST['ma_savep']){
		if($_POST['ma_aa_chance']+$_POST['ma_yn_chance']+$_POST['ma_eza_chance']+$_POST['ma_cb_chance']+$_POST['ma_eb_chance']+$_POST['ma_yap_chance']+$_POST['ma_yt_chance']+$_POST['ma_fl_chance'] != 100) {
			echo '<div class="updated"><p>Error: The total of all percentages has to be 100!</p></div>';		
		} else {
			update_option('aa_chance',$_POST['ma_aa_chance']);
			update_option('eza_chance',$_POST['ma_eza_chance']);
			update_option('cb_chance',$_POST['ma_cb_chance']);
			update_option('eb_chance',$_POST['ma_eb_chance']);
			update_option('yap_chance',$_POST['ma_yap_chance']);
			update_option('yt_chance',$_POST['ma_yt_chance']);	
			update_option('fl_chance',$_POST['ma_fl_chance']);	
			update_option('yn_chance',$_POST['ma_yn_chance']);				
			echo '<div class="updated"><p>Probabilities updated successfully!</p></div>';
			}
		}

?>
	<div class="wrap">
	<h2>WP Robot</h2>
	<h3>Posting Probabilities</h3>
	<form method="post" id="ma_options">	

		<table width="100%" cellspacing="2" cellpadding="5" class="editform"> 
	<?php if(function_exists('ma_amazonpost')) { ?>			
			<tr valign="top"> 
				<td width="20%" scope="row">Amazon:</td> 			
				<td><input size="3" name="ma_aa_chance" type="text" id="ma_aa_chance" value="<?php echo get_option('aa_chance') ;?>"/> %
				</td>
			</tr>
	<?php } if(function_exists('ma_articlepost')) { ?>				
			<tr valign="top"> 
				<td width="20%" scope="row">Articles:</td> 			
				<td><input size="3" name="ma_eza_chance" type="text" id="ma_eza_chance" value="<?php echo get_option('eza_chance') ;?>"/> %
				</td>
			</tr>	
	<?php } if(function_exists('ma_clickbankpost')) { ?>					
			<tr valign="top"> 
				<td width="20%" scope="row">Clickbank:</td> 			
				<td><input size="3" name="ma_cb_chance" type="text" id="ma_cb_chance" value="<?php echo get_option('cb_chance') ;?>"/> %
				</td>
			</tr>
	<?php } if(function_exists('ma_ebaypost')) { ?>					
			<tr valign="top"> 
				<td width="20%" scope="row">eBay:</td> 			
				<td><input size="3" name="ma_eb_chance" type="text" id="ma_eb_chance" value="<?php echo get_option('eb_chance') ;?>"/> %
				</td>
			</tr>	
	<?php } if(function_exists('ma_yahooanswerspost')) { ?>					
			<tr valign="top"> 
				<td width="20%" scope="row">Yahoo Answers:</td> 			
				<td><input size="3" name="ma_yap_chance" type="text" id="ma_yap_chance" value="<?php echo get_option('yap_chance') ;?>"/> %
				</td>
			</tr>	
	<?php } if(function_exists('ma_youtubepost')) { ?>					
			<tr valign="top"> 
				<td width="20%" scope="row">Youtube:</td> 			
				<td><input size="3" name="ma_yt_chance" type="text" id="ma_yt_chance" value="<?php echo get_option('yt_chance') ;?>"/> %
				</td>
			</tr>	
	<?php } if(function_exists('ma_flickrpost')) { ?>					
			<tr valign="top"> 
				<td width="20%" scope="row">Flickr:</td> 			
				<td><input size="3" name="ma_fl_chance" type="text" id="ma_fl_chance" value="<?php echo get_option('fl_chance') ;?>"/> %
				</td>
			</tr>	
	<?php } if(function_exists('ma_yahoonewspost')) { ?>					
			<tr valign="top"> 
				<td width="20%" scope="row">Yahoo News:</td> 			
				<td><input size="3" name="ma_yn_chance" type="text" id="ma_yn_chance" value="<?php echo get_option('yn_chance') ;?>"/> %
				</td>
			</tr>	
	<?php } ?>				
		</table>	
	
		<p class="submit"><input type="submit" name="ma_savep" value="Save Options" /></p>
	</form>		

<h3>Quick Links</h3>
<p><a href="http://wprobot.net/">WP Robot</a> - <a href="http://wprobot.net/documentation/">Documentation</a> - <a href="http://wprobot.net/forum/">Support Forum</a> - <a href="http://wprobot.net/affiliate-program.php">Affiliate Program</a></p>
	
	</div>	
<?php	
}

function ma_toplevel() {
   global $wpdb, $ma_dbtable;

if($_POST['ma_post']){
	ma_add_keyword();
}

if($_POST['ma_deleteit'] || $_GET['ma_deleteit']){
	if($_GET['ma_deleteit']) {
		$_POST["delete"] = array($_GET["ma_deleteit"]);
		ma_delete_keyword();
	} else {
		if($_POST["delete"] == "" || $_POST["delete"] == 0 || $_POST["delete"] == null) {
			echo '<div class="updated"><p>Please select at least one keyword!</p></div>';				
		} else {
			ma_delete_keyword();
		}
	}	
}

if($_POST['ma_runnow'] || $_GET['ma_runnow']) {
	if($_POST['ma_runnow']) {
		$_GET['ma_runnow'] = false;
		if($_POST["delete"] == "" || $_POST["delete"] == 0 || $_POST["delete"] == null) {
			echo '<div class="updated"><p>Please select at least one keyword!</p></div>';				
		} else {
			$bulk = $_POST["ma_bulk"];
			$delete = $_POST["delete"];
			$array = implode(",", $delete);
			
			if($bulk == "" || $bulk == 0 || $bulk == null) {$bulk = 1;}
			
			if($_POST['time'] && $_POST['backdate'] == "yes") {
				$sp = $_POST['timespace'];
				$time = explode("-", $_POST['time']);					
			}			
			
			for($i=0; $i < $bulk; $i++) { 
				foreach ($_POST['delete']  as $key => $value) {
				
				if($_POST['time'] && $_POST['backdate'] == "yes") {				
					$comment_date = mktime(rand(0,23), rand(0, 59), rand(0, 59), $time[1], $time[2] + $i* $sp, $time[0]);
					$_POST['postdate']=date("Y-m-d H:i:s", $comment_date);									
				}			
					ma_post($value);	
				}	
			}
		}
	} elseif($_GET['ma_runnow'] && !$_POST['ma_post'] && !$_POST['ma_deleteit'] && !$_POST['ma_resetred']) {
		ma_post($_GET['ma_runnow']);		
	}
}
if($_POST['ma_resetred']) {
	ma_resetred();	
}

?>
<div class="wrap">
<?php 	ma_get_versions(); ?>
<h2>WP Robot</h2>
	<h3>Active Keywords</h3>	
	
	<?php $records = $wpdb->get_results("SELECT * FROM " . $ma_dbtable . " ORDER BY id ASC"); 
	if ($records) {
	?>
	<form id="ma_delete" method="post">	
<table class="widefat post fixed" cellspacing="0">	
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" style="" scope="col">
				<input type="checkbox"/>
			</th>
			<th id="title" class="manage-column column-title" style="" scope="col">Keyword</th>
			<th id="author" class="manage-column column-author" style="width:320px;" scope="col">Posts Created</th>
			<th id="categories" class="manage-column column-categories" style="" scope="col">Category</th>
			<th id="date" class="manage-column column-date" style="width:160px;" scope="col">Next Post</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" style="" scope="col"><input type="checkbox"/>
			</th>
			<th class="manage-column column-title" style="" scope="col">Keyword</th>
			<th class="manage-column column-author" style="width:320px;" scope="col">Posts Created</th>
			<th class="manage-column column-categories" style="" scope="col">Category</th>
			<th class="manage-column column-date" style="width:160px;" scope="col">Next Post</th>
		</tr>
	</tfoot>	
	<tbody>	
      <?php
		$red = 0;
         
         foreach ($records as $record) { 
		 	$time = ma_get_string_between($record->postspan, "MA_", "_");
					$pos = strpos($record->postspan, 'days');
					if ($pos === false) {
						$span = "hours";
					} else {
					    $span = "days";
					}
		 
		 ?>	
	
		<tr id="post-1575" class="alternate author-self status-publish iedit" valign="top">
			<th class="check-column" scope="row">
				<input type="checkbox" value="<?php echo $record->id; ?>" name="delete[]"/>
			</th>
			<td class="post-title column-title">
				<strong><?php if($record->keyword != "") {echo $record->keyword;} elseif ($record->amazonnode != "0") {echo '<span style="color:#2357c3;">Node: ';if($record->amazonnodename != "") {echo $record->amazonnodename;} else {echo $record->amazonnode;} echo '</span>';} else {echo '<span style="color:#84520a;">Feed: <a title="'.$record->rssfeed.'" href="'.$record->rssfeed.'">'.substr($record->rssfeed, 7, 20).'...</a></span>';} ?></strong>
				
				<div class="row-actions">
					<span class="edit">
					<a title="Edit Keyword" href="admin.php?page=ma-editkw&kw=<?php echo $record->id; ?>">Edit</a>
					|
					</span>
					<span class="delete">
					<a class="submitdelete" href="admin.php?page=WPRobot/wprobot.php&ma_deleteit=<?php echo $record->id; ?>" title="Delete this keyword">Delete</a>
					|
					</span>
					<span class="view">
					<a rel="permalink" title="Create Post" href="admin.php?page=WPRobot/wprobot.php&ma_runnow=<?php echo $record->id; ?>">Post Now</a>
					</span>
				</div>				
				
			</td>
			<td class="author column-author">
				<?php echo '<strong>' . $record->num_total . '</strong> (';
				if($record->num_amazon > -1) {echo ' Amazon:' . $record->num_amazon;} elseif($record->num_amazon < -1) {$red = 1;$nnum = $record->num_amazon * -1 -2;echo ' Amazon:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_article > -1) {echo ' Articles:' . $record->num_article;} elseif($record->num_article < -1) {$red = 1;$nnum = $record->num_article * -1 -2;echo ' Articles:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_youtube > -1) {echo ' Youtube:' . $record->num_youtube;} elseif($record->num_youtube < -1) {$red = 1;$nnum = $record->num_youtube * -1 -2;echo ' Youtube:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_yahoo > -1) {echo ' Yahoo:' . $record->num_yahoo;} elseif($record->num_yahoo < -1) {$red = 1;$nnum = $record->num_yahoo * -1 -2;echo ' Yahoo:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_clickbank > -1) {echo ' Clickbank:' . $record->num_clickbank;} elseif($record->num_clickbank < -1) {$red = 1;$nnum = $record->num_clickbank * -1 -2;echo ' Clickbank:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_ebay > -1) {echo ' eBay:' . $record->num_ebay;} elseif($record->num_ebay < -1) {$red = 1;$nnum = $record->num_ebay * -1 -2;echo ' eBay:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_flickr > -1) {echo ' Flickr:' . $record->num_flickr;} elseif($record->num_flickr < -1) {$red = 1;$nnum = $record->num_flickr * -1 -2;echo ' Flickr:' . $nnum .'<b style="color:#cc0000;">!</b>';}
				if($record->num_rss > -1) {echo ' RSS:' . $record->num_rss;} elseif($record->num_rss < -1) {$red = 1;$nnum = $record->num_rss * -1 -2;echo ' RSS:' . $nnum .'<b style="color:#cc0000;">!</b>';}	
				if($record->num_yn > -1) {echo ' News:' . $record->num_yn;} elseif($record->num_yn < -1) {$red = 1;$nnum = $record->num_yn * -1 -2;echo ' News:' . $nnum .'<b style="color:#cc0000;">!</b>';}					
				echo ' )'; ?>			
			</td>
			<td class="categories column-categories"><?php echo get_cat_name($record->category); ?></td>
			<td class="date column-date"><?php echo date('m/j/Y H:i:s',wp_next_scheduled("maposthook",array($record->id)));?><br/><span style="color:#666;">(every <?php echo $time." ".$span; ?>)</span></td>
		</tr>	
		<?php } ?>
	</tbody>
</table>	

	<div style="height:75px;padding:8px 12px;margin: 20px 20px 0 0;border:1px solid #e3e3e3;-moz-border-radius:5px;float:left;">
		<div style="float:left;margin-right: 70px;">
		<b>Bulk Post</b><br/>
		Number of Posts: <input size="3" style="background:#fff;" name="ma_bulk" type="text" id="ma_bulk" value="1"/><br/>	
		<input style="margin: 2px;" class="button-secondary" type="submit" name="ma_runnow" value="Post Now"/>	
		</div>		
		<div style="float:left;margin-right: 20px;">			
		<input name="backdate" type="checkbox" id="backdate" value="yes" /> <b>Backdate?</b><br/>
		Start Date: <input size="11" style="background:#fff;" name="time" type="text" id="time" value="<?php echo date('Y-m-d'); ?>"/><br/>
		Between Posts: <input size="3" style="background:#fff;" name="timespace" type="text" id="time" value="1"/> day(s)
		</div>	
	</div>	
	
	<div style="height:75px;padding:8px 12px;margin: 20px 20px 0 0;border:1px solid #e3e3e3;-moz-border-radius:5px;float:left;">
	<input class="button-secondary" type="submit" name="ma_deleteit" value="Delete Selected Keywords"/><br/>
	<?php if($red==1){ ?><input class="button-secondary" type="submit" name="ma_resetred" value="Reset All '!'"/> <a href="http://wprobot.net/documentation/#2x"><b>?</b></a><?php } ?>
	</div>	
	
	<div style="clear:both;"></div>	
</form>	
		 <?php } else {echo 'None yet, go add some below!';} ?>

	
	<h3>Add New Keyword</h3>
	<form method="post" id="ma_post_options">
	
		<div style="padding:8px;margin-top: 4px;border:1px solid #e3e3e3;-moz-border-radius:5px;width:700px;background-color:#ececec;">	
		<table>
		
		  <tr>
		    <td width="220px"><b>Main Settings</b></td>
		    <td width="200px"><b>What to Post?</b></td>
		    <td><b>Optional Settings</b></td>
		  </tr>		
		
		  <tr>
		    <td rowspan="2">
			Keyword:<br/><input name="ma_keyword" type="text" id="ma_keyword" value=""/>
			</td>
		    <td><input name="ma_post_aa" type="checkbox" id="ma_post_aa" value="yes" <?php if(function_exists('ma_amazonpost')) {echo "checked";} else {echo "disabled";} ?> /> Amazon Products</td>
			<!-- AMAZON DEPARTMENT -->
		    <td rowspan="2">
			<?php if(function_exists('ma_amazonpost')) { $ll = get_option('ma_aa_site'); if($ll == "us") {$ll = "com";} ?>
				Amazon Department and BrowseNode:<br/>
				<select name="ma_aa_department" id="ma_aa_department">
					<option>All</option>
					<?php if($ll!="fr" || $ll!="ca") {?><option>Apparel</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Automotive</option><?php } ?>
					<?php if($ll!="ca") {?><option>Baby</option><?php } ?>
					<?php if($ll!="uk" || $ll!="de") {?><option>Beauty</option><?php } ?>
					<option>Books</option>
					<option>Classical</option>
					<?php if($ll=="com") {?><option value="DigitalMusic">Digital Music</option><?php } ?>
					<?php if($ll!="jp" || $ll!="ca") {?><option value="MP3Downloads">MP3 Downloads</option><?php } ?>
					<option>DVD</option>
					<option>Electronics</option>
					<?php if($ll!="com" || $ll!="uk") {?><option value="ForeignBooks">Foreign Books</option><?php } ?>
					<?php if($ll=="com") {?><option value="GourmetFood">Gourmet Food</option><?php } ?>
					<?php if($ll=="com") {?><option value="Grocery">Grocery</option><?php } ?>
					<?php if($ll!="ca") {?><option value="HealthPersonalCare">Health &amp; Personal Care</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="HomeGarden">Home &amp; Garden</option><?php } ?>
					<?php if($ll=="com") {?><option>Industrial</option><?php } ?>
					<?php if($ll!="ca") {?><option>Jewelry</option><?php } ?>
					<?php if($ll=="com") {?><option value="KindleStore">Kindle Store</option><?php } ?>
					<?php if($ll!="ca") {?><option>Kitchen</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Magazines</option><?php } ?>
					<?php if($ll=="com") {?><option>Merchants</option><?php } ?>
					<?php if($ll=="com") {?><option>Miscellaneous</option><?php } ?>
					<option>Music</option>
					<?php if($ll=="com") {?><option value="MusicalInstruments">Musical Instruments</option><?php } ?>
					<?php if($ll!="ca") {?><option value="MusicTracks">Music Tracks</option><?php } ?>
					<?php if($ll!="jp" || $ll!="ca") {?><option value="OfficeProducts">Office Products</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="OutdoorLiving">Outdoor &amp; Living</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option value="PCHardware">PC Hardware</option><?php } ?>
					<?php if($ll=="com") {?><option value="PetSupplies">Pet Supplies</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Photo</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Shoes</option><?php } ?>
					<option>Software</option>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="SportingGoods">Sporting Goods</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option>Tools</option><?php } ?>
					<?php if($ll!="ca") {?><option>Toys</option><?php } ?>
					<option value="UnboxVideo">Unbox Video</option>
					<option>VHS</option>
					<option>Video</option>
					<option value="VideoGames">Video Games</option>
					<?php if($ll!="jp" || $ll!="ca") {?><option>Watches</option><?php } ?>
					<?php if($ll=="com") {?><option>Wireless</option><?php } ?>
					<?php if($ll=="com") {?><option value="WirelessAccessories">Wireless Accessories</option><?php } ?>         			
				</select><input name="ma_aa_node" size="10" type="text" id="ma_aa_node" value=""/>	
			<?php } ?>
				</td>
		  </tr>
		  <tr>
		    <td><input name="ma_post_eza" type="checkbox" id="ma_post_eza" value="yes" <?php if(function_exists('ma_articlepost')) {echo "checked";} else {echo "disabled";} ?> /> Articles</td>
		  </tr>	  
		  <tr>
		    <td rowspan="2">
			Category:<br/>
				<select name="ma_category" id="ma_category">				
				<?php
				   				   $categories = get_categories('type=post&hide_empty=0');
				   				   foreach($categories as $category)
				   				   {
				   				   echo '<option value="'.$category->cat_ID.'">'.$category->cat_name.'</option>';
				   				   }				
				?>				
				</select>				
			</td>
		    <td><input name="ma_post_cb" type="checkbox" id="ma_post_cb" value="yes" <?php if(function_exists('ma_clickbankpost')) {echo "checked";} else {echo "disabled";} ?> /> Clickbank Ads</td>
			<!-- AMAZON DEPARTMENT -->
		    <td rowspan="2">
			<?php if(function_exists('ma_ebaypost')) { ?>
				eBay Category:<br/>
				<select name="ma_eb_ebaycat" id="ma_eb_ebaycat">
					<option value="all">All Categories</option>
					<option value="20081">Antiques</option>
					<option value="550" >Art</option>
					<option value="2984">Baby</option>
					<option value="267" >Books</option>
					<option value="12576">Business &amp; Industrial</option>
					<option value="625" >Cameras &amp; Photo</option>
					<option value="15032">Cell Phones &amp; PDAs</option>
					<option value="11450">Clothing, Shoes &amp; Accessories</option>
					<option value="11116" >Coins &amp; Paper Money</option>
					<option value="1" >Collectibles</option>
					<option value="58058">Computers &amp; Networking</option>
					<option value="14339">Crafts</option>
					<option value="237" >Dolls &amp; Bears</option>
					<option value="11232" >DVDs &amp; Movies</option>
					<option value="6000" >eBay Motors</option>
					<option value="293" >Electronics</option>
					<option value="45100" >Entertainment Memorabilia</option>
					<option value="31411" >Gift Certificates</option>
					<option value="26395" >Health &amp; Beauty</option>
					<option value="11700">Home &amp; Garden</option>
					<option value="281" >Jewelry &amp; Watches</option>
					<option value="11233">Music</option>
					<option value="619" >Musical Instruments</option>
					<option value="870" >Pottery &amp; Glass</option>
					<option value="10542">Real Estate</option>
					<option value="316" >Specialty Services</option>
					<option value="382" >Sporting Goods</option>
					<option value="64482">Sports Mem, Cards &amp; Fan Shop</option>
					<option value="260" >Stamps</option>
					<option value="1305">Tickets</option>
					<option value="220">Toys &amp; Hobbies</option>
					<option value="3252" >Travel</option>
					<option value="1249" >Video Games</option>
					<option value="99">Everything Else</option>
				</select>
			<?php } ?>	
			<?php if(!function_exists('ma_yahoopost') && !function_exists('ma_ebaypost') && !function_exists('ma_amazonpost')) { ?>
				<p>None available for your modules.</p>
			<?php } ?>				
				</td>
		  </tr>
		  <tr>
		    <td><input name="ma_post_eb" type="checkbox" id="ma_post_eb" value="yes" <?php if(function_exists('ma_ebaypost')) {echo "checked";} else {echo "disabled";} ?> /> eBay Auctions</td>
		  </tr>		
		  <tr>
		    <td rowspan="2">
			Post every:<br/>
				<input size="5" name="ma_postevery" type="text" id="ma_postevery" value=""/>
				<select name="ma_period" id="ma_period">
					<option value="hours">Hours</option>
					<option value="days">Days</option>
				</select>					
			</td>
		    <td><input name="ma_post_yap" type="checkbox" id="ma_post_yap" value="yes" <?php if(function_exists('ma_yahooanswerspost')) {echo "checked";} else {echo "disabled";} ?> /> Yahoo Answers</td>
			<!-- AMAZON DEPARTMENT -->
		    <td rowspan="2">
			<?php if(function_exists('ma_yahooanswerspost')) { ?>
				Yahoo Answers Category:<br/>
				<select name="ma_yap_yacat" id="ma_yap_yacat">				
					<option value=""> All </option>
					<option value="396545012">Arts &amp; Humanities</option>
					<option value="396545144">Beauty &amp; Style</option>
					<option value="396545013">Business &amp; Finance</option>
					<option value="396545311">Cars &amp; Transportation</option>
					<option value="396545660">Computers &amp; Internet</option>
					<option value="396545014">Consumer Electronics</option>
					<option value="396545327">Dining Out</option>
					<option value="396545015">Education &amp; Reference</option>
					<option value="396545016">Entertainment &amp; Music</option>
					<option value="396545451">Environment</option>
					<option value="396545433">Family &amp; Relationships</option>
					<option value="396545367">Food &amp; Drink</option>
					<option value="396545019">Games &amp; Recreation</option>
					<option value="396545018">Health</option>
					<option value="396545394">Home &amp; Garden</option>
					<option value="396545401">Local Businesses</option>
					<option value="396545439">News &amp; Events</option>
					<option value="396545443">Pets</option>
					<option value="396545444">Politics &amp; Government</option>
					<option value="396546046">Pregnancy &amp; Parenting</option>
					<option value="396545122">Science &amp; Mathematics</option>
					<option value="396545301">Social Science</option>
					<option value="396545454">Society &amp; Culture</option>
					<option value="396545213">Sports</option>
					<option value="396545469">Travel</option>
					<option value="396546089">Yahoo! Products</option>				
				</select>
				<?php }?>
				</td>
		  </tr>
		  <tr>
		    <td><input name="ma_post_yt" type="checkbox" id="ma_post_yt" value="yes" <?php if(function_exists('ma_youtubepost')) {echo "checked";} else {echo "disabled";} ?> /> Youtube Videos</td>
		  </tr>	
	  
		  <tr>
		    <td rowspan="2">
		<p class="submit" style="margin:0;padding: 10px 0;"><input class="button-primary" type="submit" name="ma_post" value="Add Keyword" /></p>			
			</td>
		    <td><input name="ma_post_fl" type="checkbox" id="ma_post_fl" value="yes" <?php if(function_exists('ma_flickrpost')) {echo "checked";} else {echo "disabled";} ?> /> Flickr Images</td>
		    <td rowspan="2"></td>
		  </tr>	
		  <tr>
		    <td><input name="ma_post_yn" type="checkbox" id="ma_post_yn" value="yes" <?php if(function_exists('ma_yahoonewspost')) {echo "checked";} else {echo "disabled";} ?> /> Yahoo News</td>
		  </tr>				  
		</table>

		
		</div>
</form>		
<?php if(function_exists('ma_amazonpost')) { ?>
<h3>Add New Amazon BrowseNode</h3>
	<form method="post" id="ma_post_options">
	
	<input name="ma_post_aa" type="hidden" id="ma_post_aa" value="yes" checked />
		<div style="padding:8px;margin-top: 4px;border:1px solid #e3e3e3;-moz-border-radius:5px;width:700px;background-color:#ececec;">	

		<table>			
		  <tr>
		    <td width="160px">
			BrowseNode ID:<br/><input name="ma_aa_node" type="text" id="ma_aa_node" value=""/>
			</td>
		    <td width="180px">
			<?php $ll = get_option('ma_aa_site'); if($ll == "us") {$ll = "com";} ?>
				Amazon Department:<br/>
				<select name="ma_aa_department" id="ma_aa_department">
					<?php if($ll!="fr" || $ll!="ca") {?><option>Apparel</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Automotive</option><?php } ?>
					<?php if($ll!="ca") {?><option>Baby</option><?php } ?>
					<?php if($ll!="uk" || $ll!="de") {?><option>Beauty</option><?php } ?>
					<option>Books</option>
					<option>Classical</option>
					<?php if($ll=="com") {?><option value="DigitalMusic">Digital Music</option><?php } ?>
					<?php if($ll!="jp" || $ll!="ca") {?><option value="MP3Downloads">MP3 Downloads</option><?php } ?>
					<option>DVD</option>
					<option>Electronics</option>
					<?php if($ll!="com" || $ll!="uk") {?><option value="ForeignBooks">Foreign Books</option><?php } ?>
					<?php if($ll=="com") {?><option value="GourmetFood">Gourmet Food</option><?php } ?>
					<?php if($ll=="com") {?><option value="Grocery">Grocery</option><?php } ?>
					<?php if($ll!="ca") {?><option value="HealthPersonalCare">Health &amp; Personal Care</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="HomeGarden">Home &amp; Garden</option><?php } ?>
					<?php if($ll=="com") {?><option>Industrial</option><?php } ?>
					<?php if($ll!="ca") {?><option>Jewelry</option><?php } ?>
					<?php if($ll=="com") {?><option value="KindleStore">Kindle Store</option><?php } ?>
					<?php if($ll!="ca") {?><option>Kitchen</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Magazines</option><?php } ?>
					<?php if($ll=="com") {?><option>Merchants</option><?php } ?>
					<?php if($ll=="com") {?><option>Miscellaneous</option><?php } ?>
					<option>Music</option>
					<?php if($ll=="com") {?><option value="MusicalInstruments">Musical Instruments</option><?php } ?>
					<?php if($ll!="ca") {?><option value="MusicTracks">Music Tracks</option><?php } ?>
					<?php if($ll!="jp" || $ll!="ca") {?><option value="OfficeProducts">Office Products</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="OutdoorLiving">Outdoor &amp; Living</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option value="PCHardware">PC Hardware</option><?php } ?>
					<?php if($ll=="com") {?><option value="PetSupplies">Pet Supplies</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Photo</option><?php } ?>
					<?php if($ll=="com" || $ll=="de") {?><option>Shoes</option><?php } ?>
					<option>Software</option>
					<?php if($ll!="fr" || $ll!="ca") {?><option value="SportingGoods">Sporting Goods</option><?php } ?>
					<?php if($ll!="fr" || $ll!="ca") {?><option>Tools</option><?php } ?>
					<?php if($ll!="ca") {?><option>Toys</option><?php } ?>
					<option value="UnboxVideo">Unbox Video</option>
					<option>VHS</option>
					<option>Video</option>
					<option value="VideoGames">Video Games</option>
					<?php if($ll!="jp" || $ll!="ca") {?><option>Watches</option><?php } ?>
					<?php if($ll=="com") {?><option>Wireless</option><?php } ?>
					<?php if($ll=="com") {?><option value="WirelessAccessories">Wireless Accessories</option><?php } ?>         			
				</select>				
			</td>

		    <td rowspan="2">
			Amazon BrowseNodes are a good tool if you want to add all products from a specific Amazon category to your weblog.<br/>		
			To find the BrowseNode ID you need have a look <a href="http://www.browsenodes.com/">here</a>. Important: You have to select the correct Amazon Department related to your BrowseNode!
			</td>
		  </tr>

		  <tr>
		    <td>
			Category:<br/>
				<select name="ma_category" id="ma_category">				
				<?php
				   				   $categories = get_categories('type=post&hide_empty=0');
				   				   foreach($categories as $category)
				   				   {
				   				   echo '<option value="'.$category->cat_ID.'">'.$category->cat_name.'</option>';
				   				   }				
				?>				
				</select>				
			</td>
		    <td>
			Post every:<br/>
				<input size="5" name="ma_postevery" type="text" id="ma_postevery" value=""/>
				<select name="ma_period" id="ma_period">
					<option value="hours">Hours</option>
					<option value="days">Days</option>
				</select>				
			</td>
		    <td></td>
		  </tr>
	  
		</table>		
		<p class="submit" style="margin:0;padding: 10px 0;"><input class="button-primary" type="submit" name="ma_post" value="Add BrowseNode" /></p>			
		

		</div>
</form>		
<?php } ?>

<?php if(function_exists('ma_rsspost')) { ?>
<h3>Add New RSS Feed</h3>
	<form method="post" id="ma_post_options">
	
	<input name="ma_post_rss" type="hidden" id="ma_post_rss" value="yes" checked />
		<div style="padding:8px;margin-top: 4px;border:1px solid #e3e3e3;-moz-border-radius:5px;width:700px;background-color:#ececec;">	

		<table>			
		  <tr>
		    <td width="180px">
			Feed:<br/><input name="ma_rssfeed" type="text" id="ma_rssfeed" value=""/>
			</td>
		    <td width="180px">	
				Category:<br/>
				<select name="ma_category" id="ma_category">				
				<?php
				   				   $categories = get_categories('type=post&hide_empty=0');
				   				   foreach($categories as $category)
				   				   {
				   				   echo '<option value="'.$category->cat_ID.'">'.$category->cat_name.'</option>';
				   				   }				
				?>				
				</select>			
			</td>

		    <td>
			Post every:<br/>
				<input size="5" name="ma_postevery" type="text" id="ma_postevery" value=""/>
				<select name="ma_period" id="ma_period">
					<option value="hours">Hours</option>
					<option value="days">Days</option>
				</select>				
			</td>
		  </tr>
	  
		</table>		
		<p class="submit" style="margin:0;padding: 10px 0;"><input class="button-primary" type="submit" name="ma_post" value="Add RSS Feed" /></p>			
		

		</div>
</form>		
<?php } ?>

<h3>Quick Links</h3>
<p><a href="http://wprobot.net/">WP Robot</a> - <a href="http://wprobot.net/documentation/">Documentation</a> - <a href="http://wprobot.net/forum/">Support Forum</a> - <a href="http://wprobot.net/affiliate-program.php">Affiliate Program</a></p>

</div>
	
	<?php
}

function ma_get_versions() {
   global $ma_core_ver, $ma_aa_ver, $ma_eza_ver, $ma_eb_ver, $ma_yap_ver, $ma_yt_ver, $ma_trans_ver, $ma_fl_ver;
   
	$versions = @file_get_contents( 'http://wprobot.net/versions.php' );
	$versions = explode(";", $versions);
	//$versions[0],$versions[1]...	
	?>
	<div style="float:right;margin-top: 25px;">Version <?php echo $ma_core_ver; ?><?php if($ma_core_ver != $versions[0]) {?> - <a href="http://wprobot.net/robotpal/sendnew.php"><b>Update available!</b></a><?php } ?>
	</div>
	<?php
}

function ma_sub_bulk() {
   global $wpdb, $ma_dbtable;
   
	if($_POST['ma_bulkadd']) {
	
		$keywords = $_POST['ma_keywords'];
		$keywords = explode("\n", $keywords);
		reset($keywords);
		foreach($keywords as $keyword) { 
			$keywordb = explode(";", $keyword);
			
			$kw = $keywordb[0];
			$cat = $keywordb[1];
			
			$category_ID = $wpdb->get_var( "SELECT term_id FROM $wpdb->terms WHERE name = '" . $cat . "'" );						
			
			if($_POST['ma_howt'] == "random") {
				$timespan = rand($_POST['ma_rd1'],$_POST['ma_rd2']);
				$_POST['ma_period'] = $_POST['ma_period'];
			} else {
				$timespan = $keywordb[2];
				$_POST['ma_period'] = $keywordb[3];
			}
			
			$_POST['ma_postevery'] = $timespan;
			

			$_POST['ma_aa_department'] = "All";
			$_POST['ma_eb_ebaycat'] = "all";
			$_POST['ma_yap_yacat'] = "";
			

			$_POST['ma_keyword'] = $kw;
			$_POST['ma_category'] = $category_ID;			
		
			ma_add_keyword();

		} 

	}
	
?>

<div class="wrap">
<h2>Bulk Add Keywords</h2>

	<form method="post" id="ma_bulk_add">
	
		<table>

		  <tr>
		    <td><br/>
			<b>Posting Frequency:</b><br/>
			<input name="ma_howt" type="radio" id="ma_post_aa" value="random" checked /> 1. Randomly choose post interval between <input size="3" name="ma_rd1" type="text" id="ma_rd1" value="1"/> and <input size="3" name="ma_rd2" type="text" id="ma_rd2" value="24"/>
							<select name="ma_period" id="ma_period">
					<option value="hours">Hours</option>
					<option value="days">Days</option>
				</select>	<br/>
			<input name="ma_howt" type="radio" id="ma_post_aa" value="custom" /> 2. Specify custom post intervals in keyword list.	
			</td>
		  </tr>


		  <tr>
		    <td><br/>
			<b>Keywords:</b><br/>
			Formatting: Keyword;Category;Post Every;hours/days<br/>i.e. <i>Bananas;Uncategorized;7;hours</i><br/>
			- Separate keywords with linebreaks<br/>
			- Post Every and hours/days can be left empty if option 1 is chosen for "Posting Frequency".<br/>
			<textarea name="ma_keywords" rows="6" cols="60"></textarea>
			</td>
		  </tr>
		  
		  <tr>		  
		    <td><br/>
			<b>Modules:</b><br/>	
			These settings apply to all added keywords.<br/>
			<input name="ma_post_aa" type="checkbox" id="ma_post_aa" value="yes" <?php if(function_exists('ma_amazonpost')) {echo "checked";} else {echo "disabled";} ?> /> Amazon Products<br/>	   
		    <input name="ma_post_eza" type="checkbox" id="ma_post_eza" value="yes" <?php if(function_exists('ma_articlepost')) {echo "checked";} else {echo "disabled";} ?> /> Articles<br/>
		    <input name="ma_post_cb" type="checkbox" id="ma_post_cb" value="yes" <?php if(function_exists('ma_clickbankpost')) {echo "checked";} else {echo "disabled";} ?> /> Clickbank Ads<br/>		  
		    <input name="ma_post_eb" type="checkbox" id="ma_post_eb" value="yes" <?php if(function_exists('ma_ebaypost')) {echo "checked";} else {echo "disabled";} ?> /> eBay Auctions<br/>	  
		    <input name="ma_post_yap" type="checkbox" id="ma_post_yap" value="yes" <?php if(function_exists('ma_yahooanswerspost')) {echo "checked";} else {echo "disabled";} ?> /> Yahoo Answers<br/>	  
		    <input name="ma_post_yt" type="checkbox" id="ma_post_yt" value="yes" <?php if(function_exists('ma_youtubepost')) {echo "checked";} else {echo "disabled";} ?> /> Youtube Videos<br/>	  
		    <input name="ma_post_fl" type="checkbox" id="ma_post_fl" value="yes" <?php if(function_exists('ma_flickrpost')) {echo "checked";} else {echo "disabled";} ?> /> Flickr Images</td>		  
		    <input name="ma_post_yn" type="checkbox" id="ma_post_yn" value="yes" <?php if(function_exists('ma_yahoonewspost')) {echo "checked";} else {echo "disabled";} ?> /> Yahoo News</td>	
			</tr>		  
		  
		  <tr>
		    <td>
		<p class="submit" style="margin:0;padding: 10px 0;"><input type="submit" name="ma_bulkadd" value="Add Keywords" /></p>			
			</td>
		  </tr>	
			  
		</table>

</form>	
</div>	
<?php	
}

function ma_deactivate() {
	wp_clear_scheduled_hook("macheckhook");	
}		

add_action( "macheckhook", 'ma_check_schedules' );
add_action( "maposthook", 'ma_post' );
register_deactivation_hook(__FILE__, 'ma_deactivate');
register_activation_hook(__FILE__, 'ma_activate');
add_action('admin_menu', 'ma_add_pages');

?>