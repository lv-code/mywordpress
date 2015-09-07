<?php

if (version_compare(PHP_VERSION, '5.0.0.', '<'))
{
	die("WP Robot requires php 5 or a greater version to work.");
}

if (!defined('WP_CONTENT_URL')) {
   define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
}

	// Modules
	@include_once("modules/flickr.php");	
	@include_once("modules/translate.php");
	@include_once("modules/articles.php");
	@include_once("modules/ebay.php");
	@include_once("modules/yahooanswers.php");
	@include_once("modules/amazon.php");
	@include_once("modules/clickbank.php");
	@include_once("modules/youtube.php");
	@include_once("modules/rss.php");
	@include_once("modules/yahoonews.php");
	
	// Global Variables
	$ma_core_ver = "2.01";
	$ma_dbtable = $wpdb->prefix . "wprobot";	
	
function ma_activate() {
   global $wpdb;

   $ma_dbtable = $wpdb->prefix . "wprobot";

   if ($wpdb->get_var("SHOW TABLES LIKE '" . $ma_dbtable . "'") != $ma_dbtable) {
// UNSIGNED
      $sql = "CREATE TABLE ".$ma_dbtable." (
        id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		postspan VARCHAR(255) NOT NULL DEFAULT '1days',
		keyword VARCHAR(255) NOT NULL,
		ebaycat VARCHAR(255) NOT NULL DEFAULT 'all',
		yapcat VARCHAR(255) NOT NULL DEFAULT '',
		amazoncat VARCHAR(255) NOT NULL DEFAULT 'all',
		amazonnode BIGINT(20) NOT NULL DEFAULT 0,
		amazonnodename VARCHAR(255) NOT NULL,
		category BIGINT(20) NOT NULL DEFAULT -1,
		num_total BIGINT(20) NOT NULL DEFAULT 0,
		num_yahoo BIGINT(20) NOT NULL DEFAULT 0,
		num_ebay BIGINT(20) NOT NULL DEFAULT 0,
		num_amazon BIGINT(20) NOT NULL DEFAULT 0,
		num_clickbank BIGINT(20) NOT NULL DEFAULT 0,
		num_youtube BIGINT(20) NOT NULL DEFAULT 0,
		num_article BIGINT(20) NOT NULL DEFAULT 0,
		num_flickr BIGINT(20) NOT NULL DEFAULT 0,
		num_yn BIGINT(20) NOT NULL DEFAULT 0,
		num_rss BIGINT(20) NOT NULL DEFAULT 0,
		rssfeed VARCHAR(255) NOT NULL,
		UNIQUE KEY id (id)
		);";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
	  
   }
   
	ma_default();
			
	$aac = 20;
	$ezac = 15;
	$cbc = 5;
	$ebc = 15;
	$yapc = 20;
	$ytc = 15;
	$flc = 0;
	$ync = 10;
	
	if (!function_exists('ma_amazonpost')) {$ezac=$ezac+$aac;$aac=0;} else {$installed .= "-Aa";}
	if (!function_exists('ma_articlepost')) {$ebc=$ebc+$ezac;$ezac=0;} else {$installed .= "-Eza";}
	if (!function_exists('ma_ebaypost')) {$yapc=$yapc+$ebc;$ebc=0;} else {$installed .= "-Ebay";}
	if (!function_exists('ma_yahooanswerspost')) {$ytc=$ytc+$yapc;$yapc=0;} else {$installed .= "-Yap";}
	if (!function_exists('ma_youtubepost')) {$cbc=$cbc+$ytc;$ytc=0;} else {$installed .= "-Yt";}
	if (!function_exists('ma_yahoonewspost')) {$cbc=$cbc+$ync;$ync=0;} else {$installed .= "-Yn";}
	
	update_option('aa_chance',$aac);
	update_option('eza_chance',$ezac);
	update_option('cb_chance',$cbc);
	update_option('eb_chance',$ebc);
	update_option('yap_chance',$yapc);
	update_option('yt_chance',$ytc);
	update_option('fl_chance',$flc);
	update_option('yn_chance',$ync);
	
	update_option('ma_db_ver',"201");
	
	wp_schedule_event( time(), 'hourly', "macheckhook");
}

function ma_dbupdate() {
    global $wpdb;
	if(get_option('ma_db_ver') != "201") {

	   $ma_dbtable = $wpdb->prefix . "wprobot";
	   
		  $sql = "CREATE TABLE ".$ma_dbtable." (
			id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			postspan VARCHAR(255) NOT NULL DEFAULT '1days',
			keyword VARCHAR(255) NOT NULL,
			ebaycat VARCHAR(255) NOT NULL DEFAULT 'all',
			yapcat VARCHAR(255) NOT NULL DEFAULT '',
			amazoncat VARCHAR(255) NOT NULL DEFAULT 'all',
			amazonnode BIGINT(20) NOT NULL DEFAULT 0,
			amazonnodename VARCHAR(255) NOT NULL,
			category BIGINT(20) NOT NULL DEFAULT -1,
			num_total BIGINT(20) NOT NULL DEFAULT 0,
			num_yahoo BIGINT(20) NOT NULL DEFAULT 0,
			num_ebay BIGINT(20) NOT NULL DEFAULT 0,
			num_amazon BIGINT(20) NOT NULL DEFAULT 0,
			num_clickbank BIGINT(20) NOT NULL DEFAULT 0,
			num_youtube BIGINT(20) NOT NULL DEFAULT 0,
			num_article BIGINT(20) NOT NULL DEFAULT 0,
			num_flickr BIGINT(20) NOT NULL DEFAULT 0,
			num_yn BIGINT(20) NOT NULL DEFAULT 0,
			num_rss BIGINT(20) NOT NULL DEFAULT 0,
			rssfeed VARCHAR(255) NOT NULL,
			UNIQUE KEY id (id)
			);";

		  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		  dbDelta($sql);
		  
		  $wpdb->query("UPDATE ".$ma_dbtable." SET num_rss = -1 WHERE num_rss = 0");
		  $wpdb->query("UPDATE ".$ma_dbtable." SET num_yn = -1 WHERE num_yn = 0");
		  
		  update_option('ma_db_ver',"201");
	}
}
ma_dbupdate();
/*
if(get_option('ma_fl_dbup') != 1) {
    $ma_dbtable = $wpdb->prefix . "wprobot";
    $sql = "ALTER TABLE " . $ma_dbtable . " ADD num_flickr BIGINT NOT NULL DEFAULT 0";
	$wpdb->query($sql);

	update_option('ma_fl_dbup',1);
}

if(get_option('ma_20_dbup') != 1) {

    $ma_dbtable = $wpdb->prefix . "wprobot";
	$sql = "ALTER TABLE " . $ma_dbtable . " ADD (amazonnode BIGINT NOT NULL DEFAULT 0,amazonnodename VARCHAR(255) NOT NULL,num_yn BIGINT NOT NULL DEFAULT 0,num_rss BIGINT NOT NULL DEFAULT 0,rssfeed VARCHAR(255) NOT NULL);";
	$wpdb->query($sql);

	update_option('ma_20_dbup',1);
}
*/
function ma_default() {
	// DEFAULT OPTIONS
	//general
	add_option('ma_poststatus','published');
	add_option('ma_autotag','Yes');
	add_option('ma_resetcount','no');
	add_option('ma_randomstart1','0');
	add_option('ma_badwords','what;which;where;when;does;that;with;while;then;your;other;have;make;will');
	add_option('ma_randomstart2','0');
	add_option('ma_randomize','yes');	
	add_option('ma_cloak','no');
	// articles
	add_option('ma_eza_source',"articlesbase");	
	add_option('ma_eza_grabmethod','new');
	add_option('ma_eza_template','{article}&#13;{authorbox}');
	add_option('ma_eza_lang','en');
	// ebay
	add_option( 'ma_eb_affkey', '' );
	add_option( 'ma_eb_auctionnum', 2 );
	add_option( 'ma_eb_country',"0");
	add_option('ma_eb_lang','en-US');
	add_option( 'ma_eb_sortby',"bestmatch");
	add_option( 'ma_eb_template','Hey, check out these auctions:&#13;{auctions}&#13;Cool, arent they?');
	add_option('ma_eb_postrss',"true");
	add_option('ma_eb_titlet',"Latest {keyword} Auctions");	
	// yahoo
	add_option("ma_yap_appkey","");
	add_option("ma_yap_lang","us");
	add_option('ma_yap_yatos','yes');
	add_option('ma_yap_template','{question}');
	add_option('ma_ya_striplinks_q',"no");	
	add_option('ma_ya_striplinks_a',"no");	
	// amazon
	add_option('ma_aa_apikey',"");
	add_option('ma_aa_secretkey',"");
	add_option('ma_aa_skip',"");
	add_option('ma_aa_revtemplate','{review}&#13;Rating: {rating} / 5');	
	add_option( 'ma_aa_postreviews', 'all' );
	add_option( 'ma_aa_excerptlength', '500' );
	add_option( 'ma_aa_affkey', '' );
	add_option( 'ma_aa_site','us');
	add_option( 'ma_aa_template','{thumbnail}&#13;{features}&#13;{description}&#13;&#13;{link}');
	add_option ('ma_aa_striptitle', 'yes');
	add_option('ma_aa_searchmode',"exact");
	// clickbank
	add_option('ma_cb_affkey','');
	add_option('ma_cb_filter','');
	add_option( 'ma_cb_template','{description}&#13;{link}');
	// youtube
	add_option("ma_yt_lang","");
	add_option( 'ma_yt_template','{video}&#13;{description}');
	add_option('ma_yt_comments','yes');
	add_option('ma_yt_width','425');	
	add_option('ma_yt_height','355');
	add_option('ma_yt_safe',"moderate");				
	add_option('ma_yt_sort',"relevance");
	add_option('ma_yt_striplinks_desc',"no");		
	add_option('ma_yt_striplinks_comm',"yes");		
	// translate
	add_option('ma_transsite', 'google');
	add_option('ma_translate0','en');	
	add_option('ma_translate1','no');
	add_option('ma_translate2','no');
	add_option('ma_translate3','no');
	add_option('ma_trans_article',1);
	add_option('ma_trans_articlebox',1);
	add_option('ma_trans_cbads',0);
	add_option('ma_trans_aadesc',1);
	add_option('ma_trans_aarfull',1);
	add_option('ma_trans_yapa',0);
	add_option('ma_trans_yapq',1);
	add_option('ma_trans_ytdesc',1);
	add_option('ma_trans_ytcom',0);
	add_option('ma_trans_rss',0);
	add_option('ma_trans_title',0);
	// flickr
	add_option('ma_fl_template',"{image}&#13;Image taken on {date} by {owner}.");	
	add_option('ma_fl_apikey',"");	
	add_option('ma_fl_content',"7");
	add_option('ma_fl_sort',"relevance");
	add_option('ma_fl_license',"1,2,3,4,5,6,7");	
	add_option('ma_fl_size',"med");	
	add_option('ma_fl_width',"400");
	add_option('ma_fl_twidth',"160");	
	// rss	
	add_option('ma_rss_content',"full");			
	add_option('ma_rss_template',"{content}&#13;&#13;View full post on {source}");
	add_option('ma_rss_comments',"yes");
	add_option('ma_rss_striplinks',"no");		
	// yahoo news	
	if(get_option('ma_yap_appkey') != "") {add_option("ma_yan_appkey",get_option('ma_yap_appkey'));} else {add_option("ma_yan_appkey","");}
	add_option("ma_yan_lang","en");
	add_option('ma_yan_newsnum',"1");	
	add_option('ma_yan_titlet',"{newstitle}");	
	add_option('ma_yan_template',"{thumbnail}&#13;{title}&#13;{summary}&#13;&#13;{source}&#13;");	
}

function ma_reset_options() {
	update_option('ma_poststatus','published');
	update_option('ma_autotag','Yes');
	update_option('ma_resetcount','no');
	update_option('ma_randomstart1','0');
	update_option('ma_badwords','what;which;where;when;does;that;with;while;then;your;other;have;make;will');
	update_option('ma_randomstart2','0');	
	update_option('ma_randomize','yes');	
	// articles
	update_option('ma_eza_grabmethod','new');
	update_option('ma_eza_template','{article}&#13;{authorbox}');
	update_option('ma_eza_lang','en');
	// ebay
	//update_option( 'ma_eb_affkey', '' );
	update_option( 'ma_eb_auctionnum', 2 );
	update_option( 'ma_eb_country',"0");
	update_option('ma_eb_lang','en-US');
	update_option( 'ma_eb_sortby',"bestmatch");
	update_option( 'ma_eb_template','Hey, check out these auctions:&#13;{auctions}&#13;Cool, arent they?');
	update_option('ma_eb_postrss',"true");
	update_option('ma_eb_titlet',"Latest {keyword} Auctions");	
	// yahoo
	update_option("ma_yap_lang","us");
	update_option('ma_yap_yatos','yes');
	update_option('ma_yap_template','{question}');
	update_option('ma_ya_striplinks_q',"no");	
	update_option('ma_ya_striplinks_a',"no");		
	// amazon
	//update_option('ma_aa_apikey',"");
	//update_option('ma_aa_secretkey',"");
	update_option('ma_aa_skip',"");
	update_option('ma_aa_revtemplate','{review}&#13;Rating: {rating} / 5');	
	update_option( 'ma_aa_postreviews', 'all' );
	update_option( 'ma_aa_excerptlength', '500' );
	//update_option( 'ma_aa_affkey', '' );
	update_option( 'ma_aa_site','us');
	update_option( 'ma_aa_template','{thumbnail}&#13;{features}&#13;{description}&#13;&#13;{link}');
	update_option ('ma_aa_striptitle', 'yes');
	update_option('ma_aa_searchmode',"exact");
	// clickbank
	//update_option('ma_cb_affkey','');
	update_option('ma_cb_filter','');
	update_option( 'ma_cb_template','{description}&#13;{link}');
	// youtube
	update_option("ma_yt_lang","");
	update_option( 'ma_yt_template','{video}&#13;{description}');
	update_option('ma_yt_comments','yes');
	update_option('ma_yt_width','425');	
	update_option('ma_yt_height','355');
	update_option('ma_yt_safe',"moderate");				
	update_option('ma_yt_sort',"relevance");
	update_option('ma_yt_striplinks_desc',"no");		
	update_option('ma_yt_striplinks_comm',"yes");			
	// translate
	update_option('ma_transsite', 'google');
	update_option('ma_translate1','no');
	update_option('ma_translate2','no');
	update_option('ma_translate3','no');
	update_option('ma_trans_article',1);
	update_option('ma_trans_articlebox',1);
	update_option('ma_trans_cbads',0);
	update_option('ma_trans_aadesc',1);
	update_option('ma_trans_aarfull',1);
	update_option('ma_trans_yapa',0);
	update_option('ma_trans_yapq',1);
	update_option('ma_trans_ytdesc',1);
	update_option('ma_trans_ytcom',0);
	update_option('ma_trans_title',0);
	// flickr
	update_option('ma_fl_template',"{image}&#13;Image taken on {date} by {owner}.");	
	//update_option('ma_fl_apikey',"");	
	update_option('ma_fl_content',"7");
	update_option('ma_fl_sort',"relevance");
	update_option('ma_fl_license',"1,2,3,4,5,6");	
	update_option('ma_fl_size',"med");	
	update_option('ma_fl_width',"400");
	update_option('ma_fl_twidth',"160");
	// rss	
	update_option('ma_rss_content',"full");			
	update_option('ma_rss_template',"{content}&#13;&#13;View full post on {source}");
	update_option('ma_rss_comments',"yes");
	update_option('ma_rss_striplinks',"no");			
	// yahoo news	
	//update_option("ma_yan_appkey","");
	update_option("ma_yan_lang","en");
	update_option('ma_yan_newsnum',"1");	
	update_option('ma_yan_titlet',"{newstitle}");	
	update_option('ma_yan_template',"{thumbnail}&#13;{title}&#13;{summary}&#13;&#13;{source}&#13;");
}
?>