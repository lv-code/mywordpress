# WordPress MySQL 数据库备份
#
# 创建于：Friday 28. November 2014 14:19 UTC
# 主机名：wp.loc
# 数据库：`wordpress`
# --------------------------------------------------------
# --------------------------------------------------------
# 数据表：`wp_commentmeta`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_commentmeta` 数据表
#

DROP TABLE IF EXISTS `wp_commentmeta`;


#
#  `wp_commentmeta` 数据表的结构
#

CREATE TABLE `wp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

#
#  `wp_commentmeta` 数据表的内容
#

#
#  `wp_commentmeta` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_comments`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_comments` 数据表
#

DROP TABLE IF EXISTS `wp_comments`;


#
#  `wp_comments` 数据表的结构
#

CREATE TABLE `wp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ;

#
#  `wp_comments` 数据表的内容
#

#
#  `wp_comments` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_links`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_links` 数据表
#

DROP TABLE IF EXISTS `wp_links`;


#
#  `wp_links` 数据表的结构
#

CREATE TABLE `wp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

#
#  `wp_links` 数据表的内容
#

#
#  `wp_links` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_options`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_options` 数据表
#

DROP TABLE IF EXISTS `wp_options`;


#
#  `wp_options` 数据表的结构
#

CREATE TABLE `wp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM AUTO_INCREMENT=327 DEFAULT CHARSET=utf8 ;

#
#  `wp_options` 数据表的内容
#
 
INSERT INTO `wp_options` VALUES (1, 'siteurl', 'http://localhost:8080', 'yes'); 
INSERT INTO `wp_options` VALUES (2, 'home', 'http://localhost:8080', 'yes'); 
INSERT INTO `wp_options` VALUES (3, 'blogname', '幸福.正能量', 'yes'); 
INSERT INTO `wp_options` VALUES (4, 'blogdescription', '聚积身边的幸福，给你正能量！', 'yes'); 
INSERT INTO `wp_options` VALUES (5, 'users_can_register', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (6, 'admin_email', '824811854@qq.com', 'yes'); 
INSERT INTO `wp_options` VALUES (7, 'start_of_week', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (8, 'use_balanceTags', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (9, 'use_smilies', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (10, 'require_name_email', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (11, 'comments_notify', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (12, 'posts_per_rss', '10', 'yes'); 
INSERT INTO `wp_options` VALUES (13, 'rss_use_excerpt', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (14, 'mailserver_url', 'mail.example.com', 'yes'); 
INSERT INTO `wp_options` VALUES (15, 'mailserver_login', 'login@example.com', 'yes'); 
INSERT INTO `wp_options` VALUES (16, 'mailserver_pass', 'password', 'yes'); 
INSERT INTO `wp_options` VALUES (17, 'mailserver_port', '110', 'yes'); 
INSERT INTO `wp_options` VALUES (18, 'default_category', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (19, 'default_comment_status', 'open', 'yes'); 
INSERT INTO `wp_options` VALUES (20, 'default_ping_status', 'open', 'yes'); 
INSERT INTO `wp_options` VALUES (21, 'default_pingback_flag', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (22, 'posts_per_page', '10', 'yes'); 
INSERT INTO `wp_options` VALUES (23, 'date_format', 'Y年n月j日', 'yes'); 
INSERT INTO `wp_options` VALUES (24, 'time_format', 'ag:i', 'yes'); 
INSERT INTO `wp_options` VALUES (25, 'links_updated_date_format', 'Y年n月j日ag:i', 'yes'); 
INSERT INTO `wp_options` VALUES (26, 'comment_moderation', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (27, 'moderation_notify', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (28, 'permalink_structure', '/%year%/%monthnum%/%postname%/', 'yes'); 
INSERT INTO `wp_options` VALUES (29, 'gzipcompression', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (30, 'hack_file', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (31, 'blog_charset', 'UTF-8', 'yes'); 
INSERT INTO `wp_options` VALUES (32, 'moderation_keys', '', 'no'); 
INSERT INTO `wp_options` VALUES (33, 'active_plugins', 'a:8:{i:0;s:19:"WPRobot/wprobot.php";i:1;s:47:"disable-user-gravatar/disable-user-gravatar.php";i:2;s:52:"rejected-wp-keyword-link-rejected/wp_keywordlink.php";i:3;s:56:"remove-open-sans-font-from-wp-core/no-open-sans-font.php";i:4;s:33:"seo-image/seo-friendly-images.php";i:5;s:29:"wp-db-backup/wp-db-backup.php";i:6;s:23:"wp-o-matic/wpomatic.php";i:7;s:27:"wp-super-cache/wp-cache.php";}', 'yes'); 
INSERT INTO `wp_options` VALUES (34, 'category_base', '', 'yes'); 
INSERT INTO `wp_options` VALUES (35, 'ping_sites', 'http://rpc.pingomatic.com/', 'yes'); 
INSERT INTO `wp_options` VALUES (36, 'advanced_edit', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (37, 'comment_max_links', '2', 'yes'); 
INSERT INTO `wp_options` VALUES (38, 'gmt_offset', '', 'yes'); 
INSERT INTO `wp_options` VALUES (39, 'default_email_category', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (40, 'recently_edited', 'a:3:{i:0;s:65:"/vagrant/wordpress/wp-content/plugins/wp-super-cache/wp-cache.php";i:1;s:57:"/vagrant/wordpress/wp-content/plugins/akismet/akismet.php";i:2;s:0:"";}', 'no'); 
INSERT INTO `wp_options` VALUES (41, 'template', 'Wembley', 'yes'); 
INSERT INTO `wp_options` VALUES (42, 'stylesheet', 'Wembley', 'yes'); 
INSERT INTO `wp_options` VALUES (43, 'comment_whitelist', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (44, 'blacklist_keys', '', 'no'); 
INSERT INTO `wp_options` VALUES (45, 'comment_registration', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (46, 'html_type', 'text/html', 'yes'); 
INSERT INTO `wp_options` VALUES (47, 'use_trackback', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (48, 'default_role', 'subscriber', 'yes'); 
INSERT INTO `wp_options` VALUES (49, 'db_version', '29630', 'yes'); 
INSERT INTO `wp_options` VALUES (50, 'uploads_use_yearmonth_folders', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (51, 'upload_path', '', 'yes'); 
INSERT INTO `wp_options` VALUES (52, 'blog_public', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (53, 'default_link_category', '2', 'yes'); 
INSERT INTO `wp_options` VALUES (54, 'show_on_front', 'posts', 'yes'); 
INSERT INTO `wp_options` VALUES (55, 'tag_base', '', 'yes'); 
INSERT INTO `wp_options` VALUES (56, 'show_avatars', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (57, 'avatar_rating', 'G', 'yes'); 
INSERT INTO `wp_options` VALUES (58, 'upload_url_path', '', 'yes'); 
INSERT INTO `wp_options` VALUES (59, 'thumbnail_size_w', '150', 'yes'); 
INSERT INTO `wp_options` VALUES (60, 'thumbnail_size_h', '150', 'yes'); 
INSERT INTO `wp_options` VALUES (61, 'thumbnail_crop', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (62, 'medium_size_w', '300', 'yes'); 
INSERT INTO `wp_options` VALUES (63, 'medium_size_h', '300', 'yes'); 
INSERT INTO `wp_options` VALUES (64, 'avatar_default', 'mystery', 'yes'); 
INSERT INTO `wp_options` VALUES (65, 'large_size_w', '1024', 'yes'); 
INSERT INTO `wp_options` VALUES (66, 'large_size_h', '1024', 'yes'); 
INSERT INTO `wp_options` VALUES (67, 'image_default_link_type', 'file', 'yes'); 
INSERT INTO `wp_options` VALUES (68, 'image_default_size', '', 'yes'); 
INSERT INTO `wp_options` VALUES (69, 'image_default_align', '', 'yes'); 
INSERT INTO `wp_options` VALUES (70, 'close_comments_for_old_posts', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (71, 'close_comments_days_old', '14', 'yes'); 
INSERT INTO `wp_options` VALUES (72, 'thread_comments', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (73, 'thread_comments_depth', '5', 'yes'); 
INSERT INTO `wp_options` VALUES (74, 'page_comments', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (75, 'comments_per_page', '50', 'yes'); 
INSERT INTO `wp_options` VALUES (76, 'default_comments_page', 'newest', 'yes'); 
INSERT INTO `wp_options` VALUES (77, 'comment_order', 'asc', 'yes'); 
INSERT INTO `wp_options` VALUES (78, 'sticky_posts', 'a:0:{}', 'yes'); 
INSERT INTO `wp_options` VALUES (79, 'widget_categories', 'a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'); 
INSERT INTO `wp_options` VALUES (80, 'widget_text', 'a:0:{}', 'yes'); 
INSERT INTO `wp_options` VALUES (81, 'widget_rss', 'a:0:{}', 'yes'); 
INSERT INTO `wp_options` VALUES (82, 'uninstall_plugins', 'a:1:{s:27:"wp-super-cache/wp-cache.php";s:23:"wpsupercache_deactivate";}', 'no'); 
INSERT INTO `wp_options` VALUES (83, 'timezone_string', 'UTC', 'yes'); 
INSERT INTO `wp_options` VALUES (84, 'page_for_posts', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (85, 'page_on_front', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (86, 'default_post_format', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (87, 'link_manager_enabled', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (88, 'initial_db_version', '29630', 'yes'); 
INSERT INTO `wp_options` VALUES (89, 'wp_user_roles', 'a:5:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:62:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:9:"add_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}}', 'yes'); 
INSERT INTO `wp_options` VALUES (90, 'WPLANG', 'zh_CN', 'yes'); 
INSERT INTO `wp_options` VALUES (91, 'widget_search', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'); 
INSERT INTO `wp_options` VALUES (92, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'); 
INSERT INTO `wp_options` VALUES (93, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'); 
INSERT INTO `wp_options` VALUES (94, 'widget_archives', 'a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'); 
INSERT INTO `wp_options` VALUES (95, 'widget_meta', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'); 
INSERT INTO `wp_options` VALUES (96, 'sidebars_widgets', 'a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:13:"array_version";i:3;}', 'yes'); 
INSERT INTO `wp_options` VALUES (97, 'cron', 'a:7:{i:1416913740;a:1:{s:20:"wp_maybe_auto_update";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1416924396;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1416924408;a:1:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1416928060;a:1:{s:11:"wp_cache_gc";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:2:{s:8:"schedule";b:0;s:4:"args";a:0:{}}}}i:1416934606;a:1:{s:11:"macheckhook";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1417014015;a:1:{s:8:"do_pings";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:2:{s:8:"schedule";b:0;s:4:"args";a:0:{}}}}s:7:"version";i:2;}', 'yes'); 
INSERT INTO `wp_options` VALUES (98, '_transient_doing_cron', '1417184307.4341399669647216796875', 'yes'); 
INSERT INTO `wp_options` VALUES (99, '_transient_random_seed', 'd8a27f23e321c4c9787bac8eee84004f', 'yes'); 
INSERT INTO `wp_options` VALUES (100, '_site_transient_update_core', 'O:8:"stdClass":4:{s:7:"updates";a:2:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:65:"https://downloads.wordpress.org/release/zh_CN/wordpress-4.0.1.zip";s:6:"locale";s:5:"zh_CN";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:65:"https://downloads.wordpress.org/release/zh_CN/wordpress-4.0.1.zip";s:10:"no_content";b:0;s:11:"new_bundled";b:0;s:7:"partial";b:0;s:8:"rollback";b:0;}s:7:"current";s:5:"4.0.1";s:7:"version";s:5:"4.0.1";s:11:"php_version";s:5:"5.2.4";s:13:"mysql_version";s:3:"5.0";s:11:"new_bundled";s:3:"3.8";s:15:"partial_version";s:0:"";}i:1;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:59:"https://downloads.wordpress.org/release/wordpress-4.0.1.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:59:"https://downloads.wordpress.org/release/wordpress-4.0.1.zip";s:10:"no_content";s:70:"https://downloads.wordpress.org/release/wordpress-4.0.1-no-content.zip";s:11:"new_bundled";s:71:"https://downloads.wordpress.org/release/wordpress-4.0.1-new-bundled.zip";s:7:"partial";b:0;s:8:"rollback";b:0;}s:7:"current";s:5:"4.0.1";s:7:"version";s:5:"4.0.1";s:11:"php_version";s:5:"5.2.4";s:13:"mysql_version";s:3:"5.0";s:11:"new_bundled";s:3:"3.8";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1417179917;s:15:"version_checked";s:5:"4.0.1";s:12:"translations";a:0:{}}', 'yes'); 
INSERT INTO `wp_options` VALUES (305, '_site_transient_timeout_theme_roots', '1417181899', 'yes'); 
INSERT INTO `wp_options` VALUES (306, '_site_transient_theme_roots', 'a:5:{s:7:"Wembley";s:7:"/themes";s:9:"appliance";s:7:"/themes";s:14:"twentyfourteen";s:7:"/themes";s:14:"twentythirteen";s:7:"/themes";s:12:"twentytwelve";s:7:"/themes";}', 'yes'); 
INSERT INTO `wp_options` VALUES (104, '_site_transient_update_themes', 'O:8:"stdClass":4:{s:12:"last_checked";i:1417180135;s:7:"checked";a:4:{s:9:"appliance";s:4:"1.25";s:14:"twentyfourteen";s:3:"1.2";s:14:"twentythirteen";s:3:"1.3";s:12:"twentytwelve";s:3:"1.5";}s:8:"response";a:0:{}s:12:"translations";a:0:{}}', 'yes'); 
INSERT INTO `wp_options` VALUES (105, 'can_compress_scripts', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (326, '_transient_is_multi_author', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (311, '_transient_timeout_plugin_slugs', '1417268703', 'no'); 
INSERT INTO `wp_options` VALUES (312, '_transient_plugin_slugs', 'a:12:{i:0;s:19:"akismet/akismet.php";i:1;s:47:"disable-user-gravatar/disable-user-gravatar.php";i:2;s:9:"hello.php";i:3;s:22:"really-static/main.php";i:4;s:56:"remove-open-sans-font-from-wp-core/no-open-sans-font.php";i:5;s:33:"seo-image/seo-friendly-images.php";i:6;s:29:"wp-db-backup/wp-db-backup.php";i:7;s:27:"wp-autopost/wp-autopost.php";i:8;s:23:"wp-o-matic/wpomatic.php";i:9;s:52:"rejected-wp-keyword-link-rejected/wp_keywordlink.php";i:10;s:19:"WPRobot/wprobot.php";i:11;s:27:"wp-super-cache/wp-cache.php";}', 'no'); 
INSERT INTO `wp_options` VALUES (313, '_transient_timeout_dash_4077549d03da2e451c8b5f002294ff51', '1417223200', 'no'); 
INSERT INTO `wp_options` VALUES (314, '_transient_dash_4077549d03da2e451c8b5f002294ff51', '<div class="rss-widget"><p><strong>RSS错误</strong>：WP HTTP Error: Operation timed out after 10000 milliseconds with 109440 bytes received</p></div><div class="rss-widget"><p><strong>RSS错误</strong>：WP HTTP Error: Operation timed out after 10000 milliseconds with 169920 out of 205408 bytes received</p></div><div class="rss-widget"><ul><li class=\'dashboard-news-plugin\'><span>热门插件:</span> <a href=\'http://wordpress.org/plugins/woocommerce/\' class=\'dashboard-news-plugin-link\'>WooCommerce - excelling eCommerce</a>&nbsp;<span>(<a href=\'plugin-install.php?tab=plugin-information&amp;plugin=woocommerce&amp;_wpnonce=72ffbc836a&amp;TB_iframe=true&amp;width=600&amp;height=800\' class=\'thickbox\' title=\'WooCommerce - excelling eCommerce\'>安装</a>)</span></li></ul></div>', 'no'); 
INSERT INTO `wp_options` VALUES (309, '_transient_timeout_feed_mod_b9388c83948825c1edaef0d856b7b109', '1417223198', 'no'); 
INSERT INTO `wp_options` VALUES (310, '_transient_feed_mod_b9388c83948825c1edaef0d856b7b109', '1417179998', 'no'); 
INSERT INTO `wp_options` VALUES (315, 'theme_mods_twentyfourteen', 'a:1:{s:16:"sidebars_widgets";a:2:{s:4:"time";i:1417180131;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";a:0:{}}}}', 'yes'); 
INSERT INTO `wp_options` VALUES (307, '_transient_timeout_feed_b9388c83948825c1edaef0d856b7b109', '1417223198', 'no'); 
INSERT INTO `wp_options` VALUES (308, '_transient_feed_b9388c83948825c1edaef0d856b7b109', 'a:4:{s:5:"child";a:1:{s:0:"";a:1:{s:3:"rss";a:1:{i:0;a:6:{s:4:"data";s:3:"\n	\n";s:7:"attribs";a:1:{s:0:"";a:1:{s:7:"version";s:3:"2.0";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:1:{s:0:"";a:1:{s:7:"channel";a:1:{i:0;a:6:{s:4:"data";s:72:"\n		\n		\n		\n		\n		\n		\n				\n\n		\n		\n		\n		\n		\n		\n		\n		\n		\n		\n		\n		\n		\n		\n		\n\n	";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:7:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:39:"WordPress Plugins » View: Most Popular";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:44:"http://wordpress.org/plugins/browse/popular/";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:39:"WordPress Plugins » View: Most Popular";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:8:"language";a:1:{i:0;a:5:{s:4:"data";s:5:"en-US";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 28 Nov 2014 13:03:27 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:9:"generator";a:1:{i:0;a:5:{s:4:"data";s:25:"http://bbpress.org/?v=1.1";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"item";a:15:{i:0;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:7:"Akismet";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:45:"http://wordpress.org/plugins/akismet/#post-15";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 09 Mar 2007 22:11:30 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:32:"15@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:98:"Akismet checks your comments against the Akismet Web service to see if they look like spam or not.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Matt Mullenweg";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:1;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:22:"WordPress SEO by Yoast";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:53:"http://wordpress.org/plugins/wordpress-seo/#post-8321";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 01 Jan 2009 20:34:44 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"8321@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:131:"Improve your WordPress SEO: Write better content and have a fully optimized WordPress site using Yoast&#039;s WordPress SEO plugin.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Joost de Valk";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:2;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:14:"Contact Form 7";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:54:"http://wordpress.org/plugins/contact-form-7/#post-2141";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 02 Aug 2007 12:45:03 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"2141@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:54:"Just another contact form plugin. Simple but flexible.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:16:"Takayuki Miyoshi";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:3;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:19:"Google XML Sitemaps";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:63:"http://wordpress.org/plugins/google-sitemap-generator/#post-132";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 09 Mar 2007 22:31:32 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:33:"132@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:105:"This plugin will generate a special XML sitemap which will help search engines to better index your blog.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:5:"arnee";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:4;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:24:"Jetpack by WordPress.com";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:48:"http://wordpress.org/plugins/jetpack/#post-23862";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 20 Jan 2011 02:21:38 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"23862@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:28:"Your WordPress, Streamlined.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:9:"Tim Moore";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:5;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:18:"Wordfence Security";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:50:"http://wordpress.org/plugins/wordfence/#post-29832";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Sun, 04 Sep 2011 03:13:51 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"29832@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:137:"Wordfence Security is a free enterprise class security and performance plugin that makes your site up to 50 times faster and more secure.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:9:"Wordfence";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:6;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:25:"Google Analytics by Yoast";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:70:"http://wordpress.org/plugins/google-analytics-for-wordpress/#post-2316";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 14 Sep 2007 12:15:27 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"2316@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:124:"Track your WordPress site easily with the latest tracking codes and lots added data for search result pages and error pages.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:13:"Joost de Valk";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:7;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:15:"NextGEN Gallery";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:55:"http://wordpress.org/plugins/nextgen-gallery/#post-1169";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 23 Apr 2007 20:08:06 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"1169@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:121:"The most popular WordPress gallery plugin and one of the most popular plugins of all time with over 10 million downloads.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:9:"Alex Rabe";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:8;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:33:"WooCommerce - excelling eCommerce";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:52:"http://wordpress.org/plugins/woocommerce/#post-29860";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 05 Sep 2011 08:13:36 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"29860@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:97:"WooCommerce is a powerful, extendable eCommerce plugin that helps you sell anything. Beautifully.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:9:"WooThemes";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:9;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:18:"WordPress Importer";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:59:"http://wordpress.org/plugins/wordpress-importer/#post-18101";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 20 May 2010 17:42:45 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"18101@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:101:"Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Brian Colinger";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:10;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:19:"All in One SEO Pack";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:58:"http://wordpress.org/plugins/all-in-one-seo-pack/#post-753";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Fri, 30 Mar 2007 20:08:18 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:33:"753@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:126:"All in One SEO Pack is a WordPress SEO plugin to automatically optimize your WordPress blog for Search Engines such as Google.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:8:"uberdose";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:11;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:39:"BackWPup Free - WordPress Backup Plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:49:"http://wordpress.org/plugins/backwpup/#post-11392";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Tue, 23 Jun 2009 11:31:17 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"11392@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:146:"Schedule complete automatic backups of your WordPress installation. Decide which content will be stored (Dropbox, S3…). This is the free version";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:14:"Daniel Hüsken";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:12;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:21:"WPtouch Mobile Plugin";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:47:"http://wordpress.org/plugins/wptouch/#post-5468";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Thu, 01 May 2008 04:58:09 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"5468@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:63:"Create a slick mobile WordPress website with just a few clicks.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:17:"BraveNewCode Inc.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:13;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:11:"Redirection";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:51:"http://wordpress.org/plugins/redirection/#post-2286";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Mon, 10 Sep 2007 04:45:08 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:34:"2286@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:144:"Redirection is a WordPress plugin to manage 301 redirections and keep track of 404 errors without requiring knowledge of Apache .htaccess files.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:11:"John Godley";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}i:14;a:6:{s:4:"data";s:30:"\n			\n			\n			\n			\n			\n			\n					";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";s:5:"child";a:2:{s:0:"";a:5:{s:5:"title";a:1:{i:0;a:5:{s:4:"data";s:7:"Captcha";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:48:"http://wordpress.org/plugins/captcha/#post-26129";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:7:"pubDate";a:1:{i:0;a:5:{s:4:"data";s:31:"Wed, 27 Apr 2011 05:53:50 +0000";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:4:"guid";a:1:{i:0;a:5:{s:4:"data";s:35:"26129@http://wordpress.org/plugins/";s:7:"attribs";a:1:{s:0:"";a:1:{s:11:"isPermaLink";s:5:"false";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}s:11:"description";a:1:{i:0;a:5:{s:4:"data";s:79:"This plugin allows you to implement super security captcha form into web forms.";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}s:32:"http://purl.org/dc/elements/1.1/";a:1:{s:7:"creator";a:1:{i:0;a:5:{s:4:"data";s:11:"bestwebsoft";s:7:"attribs";a:0:{}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}}s:27:"http://www.w3.org/2005/Atom";a:1:{s:4:"link";a:1:{i:0;a:5:{s:4:"data";s:0:"";s:7:"attribs";a:1:{s:0:"";a:3:{s:4:"href";s:45:"http://wordpress.org/plugins/rss/view/popular";s:3:"rel";s:4:"self";s:4:"type";s:19:"application/rss+xml";}}s:8:"xml_base";s:0:"";s:17:"xml_base_explicit";b:0;s:8:"xml_lang";s:0:"";}}}}}}}}}}}}s:4:"type";i:128;s:7:"headers";a:11:{s:6:"server";s:5:"nginx";s:4:"date";s:29:"Fri, 28 Nov 2014 13:06:29 GMT";s:12:"content-type";s:23:"text/xml; charset=UTF-8";s:10:"connection";s:5:"close";s:4:"vary";s:15:"Accept-Encoding";s:7:"expires";s:29:"Fri, 28 Nov 2014 13:38:27 GMT";s:13:"cache-control";s:0:"";s:6:"pragma";s:0:"";s:13:"last-modified";s:31:"Fri, 28 Nov 2014 13:03:27 +0000";s:15:"x-frame-options";s:10:"SAMEORIGIN";s:4:"x-nc";s:11:"HIT lax 250";}s:5:"build";s:14:"20130911040210";}', 'no'); 
INSERT INTO `wp_options` VALUES (122, 'recently_activated', 'a:2:{s:27:"wp-autopost/wp-autopost.php";i:1417011633;s:30:"wp-autopost-po/wp-autopost.php";i:1416933223;}', 'yes'); 
INSERT INTO `wp_options` VALUES (320, '_site_transient_timeout_poptags_40cd750bba9870f18aada2478b24840a', '1417191700', 'yes'); 
INSERT INTO `wp_options` VALUES (321, '_site_transient_poptags_40cd750bba9870f18aada2478b24840a', 'a:40:{s:6:"widget";a:3:{s:4:"name";s:6:"widget";s:4:"slug";s:6:"widget";s:5:"count";s:4:"4690";}s:4:"post";a:3:{s:4:"name";s:4:"Post";s:4:"slug";s:4:"post";s:5:"count";s:4:"2907";}s:6:"plugin";a:3:{s:4:"name";s:6:"plugin";s:4:"slug";s:6:"plugin";s:5:"count";s:4:"2823";}s:5:"admin";a:3:{s:4:"name";s:5:"admin";s:4:"slug";s:5:"admin";s:5:"count";s:4:"2344";}s:5:"posts";a:3:{s:4:"name";s:5:"posts";s:4:"slug";s:5:"posts";s:5:"count";s:4:"2238";}s:7:"sidebar";a:3:{s:4:"name";s:7:"sidebar";s:4:"slug";s:7:"sidebar";s:5:"count";s:4:"1804";}s:6:"google";a:3:{s:4:"name";s:6:"google";s:4:"slug";s:6:"google";s:5:"count";s:4:"1619";}s:7:"twitter";a:3:{s:4:"name";s:7:"twitter";s:4:"slug";s:7:"twitter";s:5:"count";s:4:"1591";}s:6:"images";a:3:{s:4:"name";s:6:"images";s:4:"slug";s:6:"images";s:5:"count";s:4:"1569";}s:8:"comments";a:3:{s:4:"name";s:8:"comments";s:4:"slug";s:8:"comments";s:5:"count";s:4:"1533";}s:4:"page";a:3:{s:4:"name";s:4:"page";s:4:"slug";s:4:"page";s:5:"count";s:4:"1496";}s:9:"shortcode";a:3:{s:4:"name";s:9:"shortcode";s:4:"slug";s:9:"shortcode";s:5:"count";s:4:"1485";}s:5:"image";a:3:{s:4:"name";s:5:"image";s:4:"slug";s:5:"image";s:5:"count";s:4:"1403";}s:8:"facebook";a:3:{s:4:"name";s:8:"Facebook";s:4:"slug";s:8:"facebook";s:5:"count";s:4:"1236";}s:3:"seo";a:3:{s:4:"name";s:3:"seo";s:4:"slug";s:3:"seo";s:5:"count";s:4:"1183";}s:5:"links";a:3:{s:4:"name";s:5:"links";s:4:"slug";s:5:"links";s:5:"count";s:4:"1133";}s:9:"wordpress";a:3:{s:4:"name";s:9:"wordpress";s:4:"slug";s:9:"wordpress";s:5:"count";s:4:"1081";}s:7:"gallery";a:3:{s:4:"name";s:7:"gallery";s:4:"slug";s:7:"gallery";s:5:"count";s:4:"1027";}s:6:"social";a:3:{s:4:"name";s:6:"social";s:4:"slug";s:6:"social";s:5:"count";s:4:"1018";}s:7:"widgets";a:3:{s:4:"name";s:7:"widgets";s:4:"slug";s:7:"widgets";s:5:"count";s:3:"849";}s:5:"email";a:3:{s:4:"name";s:5:"email";s:4:"slug";s:5:"email";s:5:"count";s:3:"844";}s:5:"pages";a:3:{s:4:"name";s:5:"pages";s:4:"slug";s:5:"pages";s:5:"count";s:3:"838";}s:3:"rss";a:3:{s:4:"name";s:3:"rss";s:4:"slug";s:3:"rss";s:5:"count";s:3:"806";}s:6:"jquery";a:3:{s:4:"name";s:6:"jquery";s:4:"slug";s:6:"jquery";s:5:"count";s:3:"798";}s:5:"media";a:3:{s:4:"name";s:5:"media";s:4:"slug";s:5:"media";s:5:"count";s:3:"747";}s:5:"video";a:3:{s:4:"name";s:5:"video";s:4:"slug";s:5:"video";s:5:"count";s:3:"710";}s:4:"ajax";a:3:{s:4:"name";s:4:"AJAX";s:4:"slug";s:4:"ajax";s:5:"count";s:3:"709";}s:10:"javascript";a:3:{s:4:"name";s:10:"javascript";s:4:"slug";s:10:"javascript";s:5:"count";s:3:"673";}s:7:"content";a:3:{s:4:"name";s:7:"content";s:4:"slug";s:7:"content";s:5:"count";s:3:"663";}s:5:"login";a:3:{s:4:"name";s:5:"login";s:4:"slug";s:5:"login";s:5:"count";s:3:"631";}s:5:"photo";a:3:{s:4:"name";s:5:"photo";s:4:"slug";s:5:"photo";s:5:"count";s:3:"626";}s:10:"buddypress";a:3:{s:4:"name";s:10:"buddypress";s:4:"slug";s:10:"buddypress";s:5:"count";s:3:"623";}s:4:"feed";a:3:{s:4:"name";s:4:"feed";s:4:"slug";s:4:"feed";s:5:"count";s:3:"619";}s:4:"link";a:3:{s:4:"name";s:4:"link";s:4:"slug";s:4:"link";s:5:"count";s:3:"613";}s:6:"photos";a:3:{s:4:"name";s:6:"photos";s:4:"slug";s:6:"photos";s:5:"count";s:3:"600";}s:11:"woocommerce";a:3:{s:4:"name";s:11:"woocommerce";s:4:"slug";s:11:"woocommerce";s:5:"count";s:3:"572";}s:7:"youtube";a:3:{s:4:"name";s:7:"youtube";s:4:"slug";s:7:"youtube";s:5:"count";s:3:"564";}s:8:"category";a:3:{s:4:"name";s:8:"category";s:4:"slug";s:8:"category";s:5:"count";s:3:"561";}s:4:"spam";a:3:{s:4:"name";s:4:"spam";s:4:"slug";s:4:"spam";s:5:"count";s:3:"554";}s:5:"share";a:3:{s:4:"name";s:5:"Share";s:4:"slug";s:5:"share";s:5:"count";s:3:"553";}}', 'yes'); 
INSERT INTO `wp_options` VALUES (127, 'ossdl_off_cdn_url', 'http://localhost:8080', 'yes'); 
INSERT INTO `wp_options` VALUES (128, 'ossdl_off_include_dirs', 'wp-content,wp-includes', 'yes'); 
INSERT INTO `wp_options` VALUES (129, 'ossdl_off_exclude', '.php', 'yes'); 
INSERT INTO `wp_options` VALUES (130, 'ossdl_cname', '', 'yes'); 
INSERT INTO `wp_options` VALUES (293, 'rewrite_rules', 'a:70:{s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:47:"[0-9]{4}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:57:"[0-9]{4}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:77:"[0-9]{4}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:72:"[0-9]{4}/[0-9]{1,2}/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:44:"([0-9]{4})/([0-9]{1,2})/([^/]+)/trackback/?$";s:69:"index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]&tb=1";s:64:"([0-9]{4})/([0-9]{1,2})/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]&feed=$matches[4]";s:59:"([0-9]{4})/([0-9]{1,2})/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]&feed=$matches[4]";s:52:"([0-9]{4})/([0-9]{1,2})/([^/]+)/page/?([0-9]{1,})/?$";s:82:"index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]&paged=$matches[4]";s:59:"([0-9]{4})/([0-9]{1,2})/([^/]+)/comment-page-([0-9]{1,})/?$";s:82:"index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]&cpage=$matches[4]";s:44:"([0-9]{4})/([0-9]{1,2})/([^/]+)(/[0-9]+)?/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]&page=$matches[4]";s:36:"[0-9]{4}/[0-9]{1,2}/[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:46:"[0-9]{4}/[0-9]{1,2}/[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:66:"[0-9]{4}/[0-9]{1,2}/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:61:"[0-9]{4}/[0-9]{1,2}/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:61:"[0-9]{4}/[0-9]{1,2}/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:51:"([0-9]{4})/([0-9]{1,2})/comment-page-([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&cpage=$matches[3]";s:38:"([0-9]{4})/comment-page-([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&cpage=$matches[2]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:20:"(.?.+?)(/[0-9]+)?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";}', 'yes'); 
INSERT INTO `wp_options` VALUES (133, 'wpsupercache_start', '1416927098', 'yes'); 
INSERT INTO `wp_options` VALUES (134, 'wpsupercache_count', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (135, 'wpsupercache_gc_time', '1416928054', 'yes'); 
INSERT INTO `wp_options` VALUES (304, '_transient_twentyfourteen_category_count', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (280, 'wpo_setup', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (296, 'category_children', 'a:0:{}', 'yes'); 
INSERT INTO `wp_options` VALUES (317, 'ft_op', 'a:1:{s:2:"id";s:10:"ft_wembley";}', 'yes'); 
INSERT INTO `wp_options` VALUES (139, 'current_theme', 'Wembley', 'yes'); 
INSERT INTO `wp_options` VALUES (140, 'theme_mods_appliance', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1417006934;s:4:"data";a:2:{s:19:"wp_inactive_widgets";a:0:{}s:19:"primary-widget-area";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}}', 'yes'); 
INSERT INTO `wp_options` VALUES (141, 'theme_switched', '', 'yes'); 
INSERT INTO `wp_options` VALUES (322, 'wp_db_backup_excs', 'a:2:{s:9:"revisions";a:1:{i:0;s:8:"wp_posts";}s:4:"spam";a:1:{i:0;s:11:"wp_comments";}}', 'yes'); 
INSERT INTO `wp_options` VALUES (142, '_transient_timeout_feed_804066a6a5042090a2a0b25c55f38e72', '1418227783', 'no'); 
INSERT INTO `wp_options` VALUES (143, '_transient_feed_804066a6a5042090a2a0b25c55f38e72', '\r\nWyI8ZW0+VGhpcyBhcnRpY2xlIGlzIGF1dG9tYXRpY2FsbHkgcG9zdGVkIGJ5IFdQLUF1dG9Qb3N0IDogPGEgaHJlZj1cImh0dHA6XC9cL3dwLWF1dG9wb3N0Lm9yZ1wvemhcIiBpZD1cIjE0MTY5MzE3NzNcIiB0YXJnZXQ9XCJfYmxhbmtcIj5Xb3JkcHJlc3NcdTgxZWFcdTUyYThcdTkxYzdcdTk2YzZcdTUzZDFcdTVlMDNcdTYzZDJcdTRlZjY8XC9hPjxcL2VtPjxiclwvPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9ob3ctdG8tc2V0LWNzcy1zZWxlY3RvclwvXCIgaWQ9XCIxNDE2OTMxNzczXCIgdGFyZ2V0PVwiX2JsYW5rXCI+XHU1OTgyXHU0ZjU1XHU4YmJlXHU3ZjZlQ1NTXHU5MDA5XHU2MmU5XHU1NjY4LFdQLUF1dG9Qb3N0PFwvYT48XC9lbT4iLCI8ZW0+PGEgaHJlZj1cImh0dHA6XC9cL3dwLWF1dG9wb3N0Lm9yZ1wvemhcL21hbnVhbFwvZXh0cmFjdC10aGUtcGFnaW5hdGVkLWNvbnRlbnRcL1wiIGlkPVwiMjgzMzg2MzU0NlwiIHRhcmdldD1cIl9ibGFua1wiPlx1NjI5M1x1NTNkNlx1NjU4N1x1N2FlMFx1NTIwNlx1OTg3NVx1NTE4NVx1NWJiOSxXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9tYW51YWxcL2NvbnRlbnQtZmlsdGVyaW5nXC9cIiBpZD1cIjQyNTA3OTUzMTlcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTUxODVcdTViYjlcdThmYzdcdTZlZTQsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvcHVyY2hhc2VcL1wiIGlkPVwiNTY2NzcyNzA5MlwiIHRhcmdldD1cIl9ibGFua1wiPlx1OGQyZFx1NGU3MCxXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9mZWF0dXJlc1wvbWluaW11bS1yZXF1aXJlbWVudHNcL1wiIGlkPVwiNzA4NDY1ODg2NVwiIHRhcmdldD1cIl9ibGFua1wiPlx1NjcwMFx1NGY0ZVx1ODk4MVx1NmM0MixXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9tYW51YWxcL2h0bWwtdGFncy1maWx0ZXJpbmdcL1wiIGlkPVwiODUwMTU5MDYzOFwiIHRhcmdldD1cIl9ibGFua1wiPkhUTUxcdTY4MDdcdTdiN2VcdThmYzdcdTZlZTQsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9cIiBpZD1cIjk5MTg1MjI0MTFcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTRmN2ZcdTc1MjhcdTY1ODdcdTY4NjMsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9pbnN0YWxsLXdwLWF1dG9wb3N0XC9cIiBpZD1cIjExMzM1NDU0MTg0XCIgdGFyZ2V0PVwiX2JsYW5rXCI+XHU1Yjg5XHU4OGM1V1AtQXV0b1Bvc3QsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9hcnRpY2xlLXNvdXJjZS1zZXR0aW5nc1wvXCIgaWQ9XCIxMjc1MjM4NTk1N1wiIHRhcmdldD1cIl9ibGFua1wiPlx1NjU4N1x1N2FlMFx1Njc2NVx1NmU5MFx1OGJiZVx1N2Y2ZSxXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9tYW51YWxcL2FydGljbGUtZXh0cmFjdGlvbi1zZXR0aW5nc1wvXCIgaWQ9XCIxNDE2OTMxNzczMFwiIHRhcmdldD1cIl9ibGFua1wiPlx1NjU4N1x1N2FlMFx1NjI5M1x1NTNkNlx1OGJiZVx1N2Y2ZSxXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9tYW51YWxcL2hvdy10by1hcHBseS1taWNyb3NvZnQtdHJhbnNsYXRvci1jbGllbnQtaWQtYW5kLWNsaWVudC1zZWNyZXRcL1wiIGlkPVwiMTU1ODYyNDk1MDNcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTU5ODJcdTRmNTVcdTc1MzNcdThiZjdcdTVmYWVcdThmNmZcdTdmZmJcdThiZDFcdTViYTJcdTYyMzdcdTdhZWZcdTViYzZcdTk0YTVcdWZmMWYsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9ob3ctdG8tYXBwbHktYmFpZHUtdHJhbnNsYXRvci1hcGkta2V5XC9cIiBpZD1cIjE3MDAzMTgxMjc2XCIgdGFyZ2V0PVwiX2JsYW5rXCI+XHU1OTgyXHU0ZjU1XHU3NTMzXHU4YmY3XHU3NjdlXHU1ZWE2XHU3ZmZiXHU4YmQxQVBJIEtleVx1ZmYxZixXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9mZWF0dXJlc1wvXCIgaWQ9XCIxODQyMDExMzA0OVwiIHRhcmdldD1cIl9ibGFua1wiPlx1NjNkMlx1NGVmNlx1NzI3OVx1ODI3MixXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9tYW51YWxcL2FkZC1jdXN0b20tbGlua3NcL1wiIGlkPVwiMTk4MzcwNDQ4MjJcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTZkZmJcdTUyYTBcdTgxZWFcdTViOWFcdTRlNDlcdTk0ZmVcdTYzYTUsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9zb2x2ZS10aGUtdW5yZWNvZ25pemVkLWNoYXJhY3RlcnMtcHJvYmxlbVwvXCIgaWQ9XCIyMTI1Mzk3NjU5NVwiIHRhcmdldD1cIl9ibGFua1wiPlx1ODllM1x1NTFiM1x1NGU3MVx1NzgwMVx1OTVlZVx1OTg5OCxXUC1BdXRvUG9zdDxcL2E+PFwvZW0+IiwiPGVtPjxhIGhyZWY9XCJodHRwOlwvXC93cC1hdXRvcG9zdC5vcmdcL3poXC9tYW51YWxcL2tleXdvcmRzLXJlcGxhY2VtZW50XC9cIiBpZD1cIjIyNjcwOTA4MzY4XCIgdGFyZ2V0PVwiX2JsYW5rXCI+XHU1MTczXHU5NTJlXHU4YmNkXHU2NmZmXHU2MzYyLFdQLUF1dG9Qb3N0PFwvYT48XC9lbT4iLCI8ZW0+PGEgaHJlZj1cImh0dHA6XC9cL3dwLWF1dG9wb3N0Lm9yZ1wvemhcL3B1cmNoYXNlXC9wdXJjaGFzZS1wcm9jZXNzXC9cIiBpZD1cIjI0MDg3ODQwMTQxXCIgdGFyZ2V0PVwiX2JsYW5rXCI+XHU4ZDJkXHU0ZTcwXHU2ZDQxXHU3YTBiLFdQLUF1dG9Qb3N0PFwvYT48XC9lbT4iLCI8ZW0+PGEgaHJlZj1cImh0dHA6XC9cL3dwLWF1dG9wb3N0Lm9yZ1wvemhcL21hbnVhbFwvaG93LXRvLWdldC1jb29raWVcL1wiIGlkPVwiMjU1MDQ3NzE5MTRcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTU5ODJcdTRmNTVcdTgzYjdcdTUzZDZcdTVlNzZcdThiYmVcdTdmNmVDb29raWVcdTkxYzdcdTk2YzZcdTk3MDBcdTg5ODFcdTc2N2JcdTVmNTVcdTYyNGRcdTgwZmRcdTZkNGZcdTg5YzhcdTc2ODRcdTUxODVcdTViYjk/LFdQLUF1dG9Qb3N0PFwvYT48XC9lbT4iLCI8ZW0+PGEgaHJlZj1cImh0dHA6XC9cL3dwLWF1dG9wb3N0Lm9yZ1wvemhcL2ZlYXR1cmVzXC91cGRhdGUtbG9nXC9cIiBpZD1cIjI2OTIxNzAzNjg3XCIgdGFyZ2V0PVwiX2JsYW5rXCI+XHU2NmY0XHU2NWIwXHU2NWU1XHU1ZmQ3LFdQLUF1dG9Qb3N0PFwvYT48XC9lbT4iLCI8ZW0+PGEgaHJlZj1cImh0dHA6XC9cL3dwLWF1dG9wb3N0Lm9yZ1wvemhcL3N1cHBvcnRcL1wiIGlkPVwiMjgzMzg2MzU0NjBcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTU3MjhcdTdlYmZcdTY1MmZcdTYzMDEsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiIsIjxlbT48YSBocmVmPVwiaHR0cDpcL1wvd3AtYXV0b3Bvc3Qub3JnXC96aFwvbWFudWFsXC9jcmVhdGUtdGFzay1hbmQtYmFzaWMtc2V0dGluZ3NcL1wiIGlkPVwiMjk3NTU1NjcyMzNcIiB0YXJnZXQ9XCJfYmxhbmtcIj5cdTUyMWJcdTVlZmFcdTRlZmJcdTUyYTFcdTUzY2FcdTU3ZmFcdTY3MmNcdThiYmVcdTdmNmUsV1AtQXV0b1Bvc3Q8XC9hPjxcL2VtPiJd', 'no'); 
INSERT INTO `wp_options` VALUES (144, 'wp_autopost_updateMethod', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (145, 'wp_autopost_timeLimit', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (146, 'wp_autopost_pauseTime', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (147, 'wp_autopost_downImgMinWidth', '100', 'yes'); 
INSERT INTO `wp_options` VALUES (148, 'wp_autopost_downImgTimeOut', '120', 'yes'); 
INSERT INTO `wp_options` VALUES (149, 'wp_autopost_downImgMaxWidth', '800', 'yes'); 
INSERT INTO `wp_options` VALUES (150, 'wp_autopost_downImgQuality', '90', 'yes'); 
INSERT INTO `wp_options` VALUES (151, 'wp_autopost_downImgRelativeURL', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (152, 'wp_autopost_downImgFailsNotPost', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (153, 'wp_autopost_downImgThumbnail', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (154, 'wp_autopost_downFileOrganize', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (155, 'wp_autopost_delComment', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (156, 'wp_autopost_delAttrId', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (157, 'wp_autopost_delAttrClass', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (158, 'wp_autopost_delAttrStyle', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (159, 'wp_autopost_free_db_version', '2.9.2', 'yes'); 
INSERT INTO `wp_options` VALUES (160, 'wp-autopost-flickr-options', 'a:7:{s:7:"api_key";s:32:"fc1ec013e1bfb8f17b952a89efbe355e";s:10:"api_secret";s:16:"bbba8595664cfd10";s:11:"oauth_token";s:0:"";s:18:"oauth_token_secret";s:0:"";s:7:"user_id";s:0:"";s:10:"flickr_set";s:0:"";s:9:"is_public";i:0;}', 'yes'); 
INSERT INTO `wp_options` VALUES (161, 'wp-autopost-qiniu-options', 'a:7:{s:7:"api_key";s:32:"fc1ec013e1bfb8f17b952a89efbe355e";s:10:"api_secret";s:16:"bbba8595664cfd10";s:11:"oauth_token";s:0:"";s:18:"oauth_token_secret";s:0:"";s:7:"user_id";s:0:"";s:10:"flickr_set";s:0:"";s:9:"is_public";i:0;}', 'yes'); 
INSERT INTO `wp_options` VALUES (277, 'zh_cn_l10n_icp_num', '', 'yes'); 
INSERT INTO `wp_options` VALUES (162, 'wp_similarity', 'a:18:{s:5:"limit";i:5;s:9:"none_text";s:29:"<ul><li>Unique Post</li></ul>";s:6:"prefix";s:26:"<h2>Related Posts</h2><ul>";s:6:"suffix";s:5:"</ul>";s:6:"format";s:5:"value";s:15:"output_template";s:28:"<li>{link} ({strength})</li>";s:11:"auto_prefix";s:26:"<h2>Related Posts</h2><ul>";s:11:"auto_suffix";s:5:"</ul>";s:11:"auto_format";s:5:"value";s:20:"auto_output_template";s:28:"<li>{link} ({strength})</li>";s:10:"tag_weight";i:1;s:10:"cat_weight";i:1;s:11:"text_strong";s:23:"<strong>Strong</strong>";s:9:"text_mild";s:4:"Mild";s:9:"text_weak";s:4:"Weak";s:12:"text_tenuous";s:16:"<em>Tenuous</em>";s:9:"one_extra";s:5:"false";s:7:"sim_rss";s:3:"yes";}', 'yes'); 
INSERT INTO `wp_options` VALUES (163, 'seo_friendly_images_alt', '%name %title', 'yes'); 
INSERT INTO `wp_options` VALUES (164, 'seo_friendly_images_title', '%title', 'yes'); 
INSERT INTO `wp_options` VALUES (165, 'seo_friendly_images_override', 'on', 'yes'); 
INSERT INTO `wp_options` VALUES (166, 'seo_friendly_images_override_title', 'off', 'yes'); 
INSERT INTO `wp_options` VALUES (167, 'wp_autopost_admin_id', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (168, 'wp_autopost_admin_expiration', '1416960737', 'yes'); 
INSERT INTO `wp_options` VALUES (169, 'wp-autopost-featued-images', 'a:0:{}', 'yes'); 
INSERT INTO `wp_options` VALUES (170, 'data_posts_on_widget', '\r\n[{"url":"http:\\/\\/wp-autopost.org\\/zh","title":"Wordpress\\u81ea\\u52a8\\u91c7\\u96c6\\u53d1\\u5e03\\u63d2\\u4ef6"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/support\\/","title":"\\u5728\\u7ebf\\u652f\\u6301,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/features\\/update-log\\/","title":"\\u66f4\\u65b0\\u65e5\\u5fd7,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/content-filtering\\/","title":"\\u5185\\u5bb9\\u8fc7\\u6ee4,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/html-tags-filtering\\/","title":"HTML\\u6807\\u7b7e\\u8fc7\\u6ee4,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/install-wp-autopost\\/","title":"\\u5b89\\u88c5WP-AutoPost,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/create-task-and-basic-settings\\/","title":"\\u521b\\u5efa\\u4efb\\u52a1\\u53ca\\u57fa\\u672c\\u8bbe\\u7f6e,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/how-to-set-css-selector\\/","title":"\\u5982\\u4f55\\u8bbe\\u7f6eCSS\\u9009\\u62e9\\u5668,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/keywords-replacement\\/","title":"\\u5173\\u952e\\u8bcd\\u66ff\\u6362,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/features\\/minimum-requirements\\/","title":"\\u6700\\u4f4e\\u8981\\u6c42,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/features\\/","title":"\\u63d2\\u4ef6\\u7279\\u8272,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/add-custom-links\\/","title":"\\u6dfb\\u52a0\\u81ea\\u5b9a\\u4e49\\u94fe\\u63a5,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/article-source-settings\\/","title":"\\u6587\\u7ae0\\u6765\\u6e90\\u8bbe\\u7f6e,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/solve-the-unrecognized-characters-problem\\/","title":"\\u89e3\\u51b3\\u4e71\\u7801\\u95ee\\u9898,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/purchase\\/","title":"\\u8d2d\\u4e70,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/purchase\\/purchase-process\\/","title":"\\u8d2d\\u4e70\\u6d41\\u7a0b,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/","title":"\\u4f7f\\u7528\\u6587\\u6863,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/article-extraction-settings\\/","title":"\\u6587\\u7ae0\\u6293\\u53d6\\u8bbe\\u7f6e,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/extract-the-paginated-content\\/","title":"\\u6293\\u53d6\\u6587\\u7ae0\\u5206\\u9875\\u5185\\u5bb9,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/how-to-apply-microsoft-translator-client-id-and-client-secret\\/","title":"\\u5982\\u4f55\\u7533\\u8bf7\\u5fae\\u8f6f\\u7ffb\\u8bd1\\u5ba2\\u6237\\u7aef\\u5bc6\\u94a5\\uff1f,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/how-to-get-cookie\\/","title":"\\u5982\\u4f55\\u83b7\\u53d6\\u5e76\\u8bbe\\u7f6eCookie\\u91c7\\u96c6\\u9700\\u8981\\u767b\\u5f55\\u624d\\u80fd\\u6d4f\\u89c8\\u7684\\u5185\\u5bb9?,WP-AutoPost"},{"url":"http:\\/\\/wp-autopost.org\\/zh\\/manual\\/how-to-apply-baidu-translator-api-key\\/","title":"\\u5982\\u4f55\\u7533\\u8bf7\\u767e\\u5ea6\\u7ffb\\u8bd1API Key\\uff1f,WP-AutoPost"}]', 'yes'); 
INSERT INTO `wp_options` VALUES (171, 'timestamps_data_posts', '1416961722', 'yes'); 
INSERT INTO `wp_options` VALUES (173, 'wpo_log', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (172, 'wp-watermark-options', 'a:14:{s:4:"type";i:0;s:8:"position";i:9;s:4:"font";s:0:"";s:4:"text";s:21:"http://localhost:8080";s:4:"size";i:16;s:5:"color";s:7:"#ffffff";s:12:"x-adjustment";i:0;s:12:"y-adjustment";i:0;s:12:"transparency";i:80;s:12:"upload_image";s:84:"/vagrant/wordpress/wp-content/plugins/wp-autopost-po/watermark/uploads/watermark.png";s:16:"upload_image_url";s:87:"http://localhost:8080/wp-content/plugins/wp-autopost-po/watermark/uploads/watermark.png";s:9:"min_width";i:300;s:10:"min_height";i:300;s:12:"jpeg_quality";i:90;}', 'yes'); 
INSERT INTO `wp_options` VALUES (180, 'ma_db_ver', '201', 'yes'); 
INSERT INTO `wp_options` VALUES (174, 'wpo_log_stdout', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (175, 'wpo_unixcron', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (176, 'wpo_croncode', '9e01529f', 'yes'); 
INSERT INTO `wp_options` VALUES (177, 'wpo_cacheimages', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (178, 'wpo_cachepath', 'cache', 'yes'); 
INSERT INTO `wp_options` VALUES (179, 'wpo_version', '1.0RC4-6', 'yes'); 
INSERT INTO `wp_options` VALUES (181, 'ma_poststatus', 'published', 'yes'); 
INSERT INTO `wp_options` VALUES (182, 'ma_autotag', 'Yes', 'yes'); 
INSERT INTO `wp_options` VALUES (183, 'ma_resetcount', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (184, 'ma_randomstart1', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (185, 'ma_badwords', 'what;which;where;when;does;that;with;while;then;your;other;have;make;will', 'yes'); 
INSERT INTO `wp_options` VALUES (186, 'ma_randomstart2', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (187, 'ma_randomize', 'yes', 'yes'); 
INSERT INTO `wp_options` VALUES (188, 'ma_cloak', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (189, 'ma_eza_source', 'articlesbase', 'yes'); 
INSERT INTO `wp_options` VALUES (190, 'ma_eza_grabmethod', 'new', 'yes'); 
INSERT INTO `wp_options` VALUES (191, 'ma_eza_template', '{article}&#13;{authorbox}', 'yes'); 
INSERT INTO `wp_options` VALUES (192, 'ma_eza_lang', 'en', 'yes'); 
INSERT INTO `wp_options` VALUES (193, 'ma_eb_affkey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (194, 'ma_eb_auctionnum', '2', 'yes'); 
INSERT INTO `wp_options` VALUES (195, 'ma_eb_country', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (196, 'ma_eb_lang', 'en-US', 'yes'); 
INSERT INTO `wp_options` VALUES (197, 'ma_eb_sortby', 'bestmatch', 'yes'); 
INSERT INTO `wp_options` VALUES (198, 'ma_eb_template', 'Hey, check out these auctions:&#13;{auctions}&#13;Cool, arent they?', 'yes'); 
INSERT INTO `wp_options` VALUES (199, 'ma_eb_postrss', 'true', 'yes'); 
INSERT INTO `wp_options` VALUES (200, 'ma_eb_titlet', 'Latest {keyword} Auctions', 'yes'); 
INSERT INTO `wp_options` VALUES (201, 'ma_yap_appkey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (202, 'ma_yap_lang', 'us', 'yes'); 
INSERT INTO `wp_options` VALUES (203, 'ma_yap_yatos', 'yes', 'yes'); 
INSERT INTO `wp_options` VALUES (204, 'ma_yap_template', '{question}', 'yes'); 
INSERT INTO `wp_options` VALUES (205, 'ma_ya_striplinks_q', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (206, 'ma_ya_striplinks_a', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (207, 'ma_aa_apikey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (208, 'ma_aa_secretkey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (209, 'ma_aa_skip', '', 'yes'); 
INSERT INTO `wp_options` VALUES (210, 'ma_aa_revtemplate', '{review}&#13;Rating: {rating} / 5', 'yes'); 
INSERT INTO `wp_options` VALUES (211, 'ma_aa_postreviews', 'all', 'yes'); 
INSERT INTO `wp_options` VALUES (212, 'ma_aa_excerptlength', '500', 'yes'); 
INSERT INTO `wp_options` VALUES (213, 'ma_aa_affkey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (214, 'ma_aa_site', 'us', 'yes'); 
INSERT INTO `wp_options` VALUES (215, 'ma_aa_template', '{thumbnail}&#13;{features}&#13;{description}&#13;&#13;{link}', 'yes'); 
INSERT INTO `wp_options` VALUES (216, 'ma_aa_striptitle', 'yes', 'yes'); 
INSERT INTO `wp_options` VALUES (217, 'ma_aa_searchmode', 'exact', 'yes'); 
INSERT INTO `wp_options` VALUES (218, 'ma_cb_affkey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (219, 'ma_cb_filter', '', 'yes'); 
INSERT INTO `wp_options` VALUES (220, 'ma_cb_template', '{description}&#13;{link}', 'yes'); 
INSERT INTO `wp_options` VALUES (221, 'ma_yt_lang', '', 'yes'); 
INSERT INTO `wp_options` VALUES (222, 'ma_yt_template', '{video}&#13;{description}', 'yes'); 
INSERT INTO `wp_options` VALUES (223, 'ma_yt_comments', 'yes', 'yes'); 
INSERT INTO `wp_options` VALUES (224, 'ma_yt_width', '425', 'yes'); 
INSERT INTO `wp_options` VALUES (225, 'ma_yt_height', '355', 'yes'); 
INSERT INTO `wp_options` VALUES (226, 'ma_yt_safe', 'moderate', 'yes'); 
INSERT INTO `wp_options` VALUES (227, 'ma_yt_sort', 'relevance', 'yes'); 
INSERT INTO `wp_options` VALUES (228, 'ma_yt_striplinks_desc', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (229, 'ma_yt_striplinks_comm', 'yes', 'yes'); 
INSERT INTO `wp_options` VALUES (230, 'ma_transsite', 'google', 'yes'); 
INSERT INTO `wp_options` VALUES (231, 'ma_translate0', 'en', 'yes'); 
INSERT INTO `wp_options` VALUES (232, 'ma_translate1', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (233, 'ma_translate2', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (234, 'ma_translate3', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (235, 'ma_trans_article', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (236, 'ma_trans_articlebox', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (237, 'ma_trans_cbads', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (238, 'ma_trans_aadesc', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (239, 'ma_trans_aarfull', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (240, 'ma_trans_yapa', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (241, 'ma_trans_yapq', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (242, 'ma_trans_ytdesc', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (243, 'ma_trans_ytcom', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (244, 'ma_trans_rss', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (245, 'ma_trans_title', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (246, 'ma_fl_template', '{image}&#13;Image taken on {date} by {owner}.', 'yes'); 
INSERT INTO `wp_options` VALUES (247, 'ma_fl_apikey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (248, 'ma_fl_content', '7', 'yes'); 
INSERT INTO `wp_options` VALUES (249, 'ma_fl_sort', 'relevance', 'yes'); 
INSERT INTO `wp_options` VALUES (250, 'ma_fl_license', '1,2,3,4,5,6,7', 'yes'); 
INSERT INTO `wp_options` VALUES (251, 'ma_fl_size', 'med', 'yes'); 
INSERT INTO `wp_options` VALUES (252, 'ma_fl_width', '400', 'yes'); 
INSERT INTO `wp_options` VALUES (253, 'ma_fl_twidth', '160', 'yes'); 
INSERT INTO `wp_options` VALUES (254, 'ma_rss_content', 'full', 'yes'); 
INSERT INTO `wp_options` VALUES (255, 'ma_rss_template', '{content}&#13;&#13;View full post on {source}', 'yes'); 
INSERT INTO `wp_options` VALUES (256, 'ma_rss_comments', 'yes', 'yes'); 
INSERT INTO `wp_options` VALUES (257, 'ma_rss_striplinks', 'no', 'yes'); 
INSERT INTO `wp_options` VALUES (258, 'ma_yan_appkey', '', 'yes'); 
INSERT INTO `wp_options` VALUES (259, 'ma_yan_lang', 'en', 'yes'); 
INSERT INTO `wp_options` VALUES (260, 'ma_yan_newsnum', '1', 'yes'); 
INSERT INTO `wp_options` VALUES (261, 'ma_yan_titlet', '{newstitle}', 'yes'); 
INSERT INTO `wp_options` VALUES (262, 'ma_yan_template', '{thumbnail}&#13;{title}&#13;{summary}&#13;&#13;{source}&#13;', 'yes'); 
INSERT INTO `wp_options` VALUES (263, 'aa_chance', '20', 'yes'); 
INSERT INTO `wp_options` VALUES (264, 'eza_chance', '15', 'yes'); 
INSERT INTO `wp_options` VALUES (265, 'cb_chance', '15', 'yes'); 
INSERT INTO `wp_options` VALUES (266, 'eb_chance', '15', 'yes'); 
INSERT INTO `wp_options` VALUES (267, 'yap_chance', '20', 'yes'); 
INSERT INTO `wp_options` VALUES (268, 'yt_chance', '15', 'yes'); 
INSERT INTO `wp_options` VALUES (269, 'fl_chance', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (270, 'yn_chance', '0', 'yes'); 
INSERT INTO `wp_options` VALUES (316, 'theme_mods_Wembley', 'a:1:{i:0;b:0;}', 'yes'); 
INSERT INTO `wp_options` VALUES (318, 'external_theme_updates-Wembley', 'O:8:"stdClass":3:{s:9:"lastCheck";i:1417180135;s:14:"checkedVersion";s:3:"1.2";s:6:"update";N;}', 'yes'); 
INSERT INTO `wp_options` VALUES (273, '_site_transient_update_plugins', 'O:8:"stdClass":1:{s:12:"last_checked";i:1417182295;}', 'yes');
#
#  `wp_options` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_postmeta`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_postmeta` 数据表
#

DROP TABLE IF EXISTS `wp_postmeta`;


#
#  `wp_postmeta` 数据表的结构
#

CREATE TABLE `wp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=406 DEFAULT CHARSET=utf8 ;

#
#  `wp_postmeta` 数据表的内容
#
 
INSERT INTO `wp_postmeta` VALUES (1, 2, '_wp_page_template', 'default'); 
INSERT INTO `wp_postmeta` VALUES (342, 95, '_menu_item_orphaned', '1417180255'); 
INSERT INTO `wp_postmeta` VALUES (341, 95, '_menu_item_url', 'http://localhost:8080/'); 
INSERT INTO `wp_postmeta` VALUES (340, 95, '_menu_item_xfn', ''); 
INSERT INTO `wp_postmeta` VALUES (337, 95, '_menu_item_object', 'custom'); 
INSERT INTO `wp_postmeta` VALUES (338, 95, '_menu_item_target', ''); 
INSERT INTO `wp_postmeta` VALUES (339, 95, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'); 
INSERT INTO `wp_postmeta` VALUES (349, 96, '_menu_item_xfn', ''); 
INSERT INTO `wp_postmeta` VALUES (350, 96, '_menu_item_url', ''); 
INSERT INTO `wp_postmeta` VALUES (351, 96, '_menu_item_orphaned', '1417180256'); 
INSERT INTO `wp_postmeta` VALUES (384, 108, '_wp_trash_meta_status', 'publish'); 
INSERT INTO `wp_postmeta` VALUES (385, 108, '_wp_trash_meta_time', '1417183740'); 
INSERT INTO `wp_postmeta` VALUES (386, 111, '_pingme', '1'); 
INSERT INTO `wp_postmeta` VALUES (387, 111, '_encloseme', '1'); 
INSERT INTO `wp_postmeta` VALUES (383, 107, '_wp_trash_meta_time', '1417183740'); 
INSERT INTO `wp_postmeta` VALUES (382, 107, '_wp_trash_meta_status', 'publish'); 
INSERT INTO `wp_postmeta` VALUES (372, 107, '_pingme', '1'); 
INSERT INTO `wp_postmeta` VALUES (373, 107, '_encloseme', '1'); 
INSERT INTO `wp_postmeta` VALUES (374, 107, 'wpo_campaignid', '1'); 
INSERT INTO `wp_postmeta` VALUES (375, 107, 'wpo_feedid', '6'); 
INSERT INTO `wp_postmeta` VALUES (376, 107, 'wpo_sourcepermalink', 'http://blog.wpjam.com/m/cnblogs2wp/'); 
INSERT INTO `wp_postmeta` VALUES (377, 108, '_pingme', '1'); 
INSERT INTO `wp_postmeta` VALUES (378, 108, '_encloseme', '1'); 
INSERT INTO `wp_postmeta` VALUES (379, 108, 'wpo_campaignid', '1'); 
INSERT INTO `wp_postmeta` VALUES (380, 108, 'wpo_feedid', '6'); 
INSERT INTO `wp_postmeta` VALUES (381, 108, 'wpo_sourcepermalink', 'http://blog.wpjam.com/article/coding-net/'); 
INSERT INTO `wp_postmeta` VALUES (348, 96, '_menu_item_classes', 'a:1:{i:0;s:0:"";}'); 
INSERT INTO `wp_postmeta` VALUES (347, 96, '_menu_item_target', ''); 
INSERT INTO `wp_postmeta` VALUES (346, 96, '_menu_item_object', 'page'); 
INSERT INTO `wp_postmeta` VALUES (343, 96, '_menu_item_type', 'post_type'); 
INSERT INTO `wp_postmeta` VALUES (344, 96, '_menu_item_menu_item_parent', '0'); 
INSERT INTO `wp_postmeta` VALUES (345, 96, '_menu_item_object_id', '2'); 
INSERT INTO `wp_postmeta` VALUES (388, 111, 'wpo_campaignid', '1'); 
INSERT INTO `wp_postmeta` VALUES (389, 111, 'wpo_feedid', '6'); 
INSERT INTO `wp_postmeta` VALUES (390, 111, 'wpo_sourcepermalink', 'http://blog.wpjam.com/m/wordpress-gravatar-server/'); 
INSERT INTO `wp_postmeta` VALUES (391, 112, '_pingme', '1'); 
INSERT INTO `wp_postmeta` VALUES (392, 112, '_encloseme', '1'); 
INSERT INTO `wp_postmeta` VALUES (393, 112, 'wpo_campaignid', '1'); 
INSERT INTO `wp_postmeta` VALUES (394, 112, 'wpo_feedid', '6'); 
INSERT INTO `wp_postmeta` VALUES (395, 112, 'wpo_sourcepermalink', 'http://blog.wpjam.com/m/jquery-json-province-city/'); 
INSERT INTO `wp_postmeta` VALUES (396, 113, '_pingme', '1'); 
INSERT INTO `wp_postmeta` VALUES (397, 113, '_encloseme', '1'); 
INSERT INTO `wp_postmeta` VALUES (398, 113, 'wpo_campaignid', '1'); 
INSERT INTO `wp_postmeta` VALUES (399, 113, 'wpo_feedid', '6'); 
INSERT INTO `wp_postmeta` VALUES (400, 113, 'wpo_sourcepermalink', 'http://blog.wpjam.com/m/cnblogs2wp/'); 
INSERT INTO `wp_postmeta` VALUES (401, 114, '_pingme', '1'); 
INSERT INTO `wp_postmeta` VALUES (402, 114, '_encloseme', '1'); 
INSERT INTO `wp_postmeta` VALUES (403, 114, 'wpo_campaignid', '1'); 
INSERT INTO `wp_postmeta` VALUES (404, 114, 'wpo_feedid', '6'); 
INSERT INTO `wp_postmeta` VALUES (405, 114, 'wpo_sourcepermalink', 'http://blog.wpjam.com/article/coding-net/'); 
INSERT INTO `wp_postmeta` VALUES (336, 95, '_menu_item_object_id', '95'); 
INSERT INTO `wp_postmeta` VALUES (334, 95, '_menu_item_type', 'custom'); 
INSERT INTO `wp_postmeta` VALUES (335, 95, '_menu_item_menu_item_parent', '0');
#
#  `wp_postmeta` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_posts`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_posts` 数据表
#

DROP TABLE IF EXISTS `wp_posts`;


#
#  `wp_posts` 数据表的结构
#

CREATE TABLE `wp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(20) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8 ;

#
#  `wp_posts` 数据表的内容
#
 
INSERT INTO `wp_posts` VALUES (95, 1, '2014-11-28 13:10:55', '0000-00-00 00:00:00', '', '首页', '', 'draft', 'open', 'open', '', '', '', '', '2014-11-28 13:10:55', '0000-00-00 00:00:00', '', 0, 'http://localhost:8080/?p=95', 1, 'nav_menu_item', '', 0); 
INSERT INTO `wp_posts` VALUES (96, 1, '2014-11-28 13:10:56', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'open', 'open', '', '', '', '', '2014-11-28 13:10:56', '0000-00-00 00:00:00', '', 0, 'http://localhost:8080/?p=96', 1, 'nav_menu_item', '', 0); 
INSERT INTO `wp_posts` VALUES (2, 1, '2014-11-25 14:06:24', '2014-11-25 14:06:24', '这是示范页面。页面和博客文章不同，它的位置是固定的，通常会在站点导航栏显示。很多用户都创建一个“关于”页面，向访客介绍自己。例如，个人博客通常有类似这样的介绍：\n\n<blockquote>欢迎！我白天是个邮递员，晚上就是个有抱负的演员。这是我的博客。我住在天朝的帝都，有条叫做杰克的狗。</blockquote>\n\n……公司博客可以这样写：\n\n<blockquote>XYZ Doohickey公司成立于1971年，自从建立以来，我们一直向社会贡献着优秀doohicky。我们的公司总部位于天朝魔都，有着超过两千名员工，对魔都政府税收有着巨大贡献。</blockquote>\n\n您可以访问<a href="http://localhost:8080/wp-admin/">仪表盘</a>，删除本页面，然后添加您自己的内容。祝您使用愉快！', '示例页面', '', 'publish', 'open', 'open', '', 'sample-page', '', '', '2014-11-25 14:06:24', '2014-11-25 14:06:24', '', 0, 'http://localhost:8080/?page_id=2', 0, 'page', '', 0); 
INSERT INTO `wp_posts` VALUES (3, 1, '2014-11-25 22:07:12', '0000-00-00 00:00:00', '', '自动草稿', '', 'auto-draft', 'open', 'open', '', '', '', '', '2014-11-25 22:07:12', '0000-00-00 00:00:00', '', 0, 'http://localhost:8080/?p=3', 0, 'post', '', 0); 
INSERT INTO `wp_posts` VALUES (111, 1, '2014-11-27 03:16:23', '2014-11-27 03:16:23', '<p>WordPress 默认头像是使用 Gravatar 头像，而 Gravatar 头像服务在国内访问又不是很稳定，经常出现无法打开的情况，这样的话用户头像就可能会无法载入，本文介绍使用 Gravatar 头像稳定服务器的方法。</p>\n<h2>解决思路</h2>\n<p>Gravatar 头像无法稳定访问的原因不是 Gravatar 网站服务器的原因，是国内防火墙的问题，所以解决思路是使用Gravatar 头像服务的（HTTPS）加密线路。</p>\n<h2>实现方法</h2>\n<p>把代码添加到主题目录下的functions.php文件最后即可</p>\n<pre><code>\nfunction dmeng_get_https_avatar($avatar) {\r\n	//~ 替换为 https 的域名\r\n	$avatar = str_replace(array(&quot;www.gravatar.com&quot;, &quot;0.gravatar.com&quot;, &quot;1.gravatar.com&quot;, &quot;2.gravatar.com&quot;), &quot;secure.gravatar.com&quot;, $avatar);\r\n	//~ 替换为 https 协议\r\n	$avatar = str_replace(&quot;http://&quot;, &quot;https://&quot;, $avatar);\r\n	return $avatar;\r\n}\r\nadd_filter(&#039;get_avatar&#039;, &#039;dmeng_get_https_avatar&#039;);\n</code></pre>\n<p>原文链接：<a href="http://www.dmeng.net/wordpress-replace-gravatar-host.html">http://www.dmeng.net/wordpress-replace-gravatar-host.html</a>\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/m/wordpress-gravatar-server/" title="WordPress 技巧：如何替换 Gravatar 头像的服务器地址">WordPress 技巧：如何替换 Gravatar 头像的服务器地址</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/b65357e1d0_-feed-post-id-4692." /><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/5fcd1b107a_ga-php-utmac-MO-328125-5-amp-utmn-35105304-amp-utmr-http-3A-2F-2Fblog-wpjam.com%2Ffeed%2F&amp;utmp=%2Frss%2Fm%2Fwordpress-gravatar-server%2F&amp;utmdt=WordPress+%E6%8A%80%E5%B7%A7%EF%BC%9A%E5%A6%82%E4%BD%95%E6%9B%BF%E6%8D%A2+Gravatar+%E5%A4%B4%E5%83%8F%E7%9A%84%E6%9C%8D%E5%8A%A1%E5%99%A8%E5%9C%B0%E5%9D%80&amp;guid=ON" /></p>', 'WordPress 技巧：如何替换 Gravatar 头像的服务器地址', '', 'publish', 'open', '1', '', 'wordpress-%e6%8a%80%e5%b7%a7%ef%bc%9a%e5%a6%82%e4%bd%95%e6%9b%bf%e6%8d%a2-gravatar-%e5%a4%b4%e5%83%8f%e7%9a%84%e6%9c%8d%e5%8a%a1%e5%99%a8%e5%9c%b0%e5%9d%80', '', '', '2014-11-27 03:16:23', '2014-11-27 03:16:23', '<p>WordPress 默认头像是使用 Gravatar 头像，而 Gravatar 头像服务在国内访问又不是很稳定，经常出现无法打开的情况，这样的话用户头像就可能会无法载入，本文介绍使用 Gravatar 头像稳定服务器的方法。</p>\n<h2>解决思路</h2>\n<p>Gravatar 头像无法稳定访问的原因不是 Gravatar 网站服务器的原因，是国内防火墙的问题，所以解决思路是使用Gravatar 头像服务的（HTTPS）加密线路。</p>\n<h2>实现方法</h2>\n<p>把代码添加到主题目录下的functions.php文件最后即可</p>\n<pre><code>\nfunction dmeng_get_https_avatar($avatar) {\r\n	//~ 替换为 https 的域名\r\n	$avatar = str_replace(array(&quot;www.gravatar.com&quot;, &quot;0.gravatar.com&quot;, &quot;1.gravatar.com&quot;, &quot;2.gravatar.com&quot;), &quot;secure.gravatar.com&quot;, $avatar);\r\n	//~ 替换为 https 协议\r\n	$avatar = str_replace(&quot;http://&quot;, &quot;https://&quot;, $avatar);\r\n	return $avatar;\r\n}\r\nadd_filter(&#039;get_avatar&#039;, &#039;dmeng_get_https_avatar&#039;);\n</code></pre>\n<p>原文链接：<a href="http://www.dmeng.net/wordpress-replace-gravatar-host.html">http://www.dmeng.net/wordpress-replace-gravatar-host.html</a>\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/m/wordpress-gravatar-server/" title="WordPress 技巧：如何替换 Gravatar 头像的服务器地址">WordPress 技巧：如何替换 Gravatar 头像的服务器地址</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/b65357e1d0_-feed-post-id-4692." /><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/5fcd1b107a_ga-php-utmac-MO-328125-5-amp-utmn-35105304-amp-utmr-http-3A-2F-2Fblog-wpjam.com%2Ffeed%2F&amp;utmp=%2Frss%2Fm%2Fwordpress-gravatar-server%2F&amp;utmdt=WordPress+%E6%8A%80%E5%B7%A7%EF%BC%9A%E5%A6%82%E4%BD%95%E6%9B%BF%E6%8D%A2+Gravatar+%E5%A4%B4%E5%83%8F%E7%9A%84%E6%9C%8D%E5%8A%A1%E5%99%A8%E5%9C%B0%E5%9D%80&amp;guid=ON" /></p>', 0, 'http://localhost:8080/2014/11/wordpress-%e6%8a%80%e5%b7%a7%ef%bc%9a%e5%a6%82%e4%bd%95%e6%9b%bf%e6%8d%a2-gravatar-%e5%a4%b4%e5%83%8f%e7%9a%84%e6%9c%8d%e5%8a%a1%e5%99%a8%e5%9c%b0%e5%9d%80/', 0, 'post', '', 0); 
INSERT INTO `wp_posts` VALUES (112, 1, '2014-11-28 06:21:18', '2014-11-28 06:21:18', '<p>在一些和会员相关的注册系统中，让用户输入省市信息是非常常见的行为，并且一般都是要求做到省市区联动下拉效果，今天就给大家推荐一个 jQuery 插件 CitySelect，通过 JSON 数据实现省市联动效果：</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/5f51f82c73_600." alt="基于 jQuery+JSON 的省市联动效果" /></p>\n<h2>CitySelect 演示：</h2>\n<p><select></select>  <select disabled="disabled"></select> <select disabled="disabled"></select> </p>\n<h2>CitySelect 使用</h2>\n<p>首先在head中载入jquery库和cityselect插件。</p>\n<pre><code>\n&lt;script type=&quot;text/javascript&quot; src=&quot;js/jquery.js&quot;&gt;&lt;/script&gt; \r\n&lt;script type=&quot;text/javascript&quot; src=&quot;js/jquery.cityselect.js&quot;&gt;&lt;/script&gt; \n</code></pre>\n<p>接下来，我们在#city中，放置三个select，并且三个select分别设置class属性为：prov、city、dist，分别表示省、市、区（县）三个下拉框。注意如果只想实现省市二级联动，则去掉第三个dist的select即可。</p>\n<pre><code>\n&lt;div id=&quot;city&quot;&gt; \r\n    &lt;select class=&quot;prov&quot;&gt;&lt;/select&gt;  \r\n    &lt;select class=&quot;city&quot; disabled=&quot;disabled&quot;&gt;&lt;/select&gt; \r\n    &lt;select class=&quot;dist&quot; disabled=&quot;disabled&quot;&gt;&lt;/select&gt; \r\n&lt;/div&gt;\n</code></pre>\n<p>调用 cityselect 插件非常简单，直接调用：</p>\n<pre><code>\n$(&quot;#city&quot;).citySelect(); \n</code></pre>\n<p>自定义参数调用，设置默认省市区。</p>\n<pre><code>\n$(&quot;#city&quot;).citySelect({  \r\n    url:&quot;js/city.min.js&quot;,  \r\n    prov:&quot;湖南&quot;, //省份 \r\n    city:&quot;长沙&quot;, //城市 \r\n    dist:&quot;岳麓区&quot;, //区县 \r\n    nodata:&quot;none&quot; //当子集无数据时，隐藏select \r\n}); \n</code></pre>\n<p>下载：<a href="http://www.helloweba.com/down-188.html">CitySelect</a>\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/m/jquery-json-province-city/" title="使用 jQuery 插件 CitySelect 实现省市联动效果">使用 jQuery 插件 CitySelect 实现省市联动效果</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/e7c9d2c919_-feed-post-id-4492." /><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/837532fdab_ga-php-utmac-MO-328125-5-amp-utmn-137143336-amp-utmr-http-3A-2F-2Fblog-wpjam.com%2Ffeed%2F&amp;utmp=%2Frss%2Fm%2Fjquery-json-province-city%2F&amp;utmdt=%E4%BD%BF%E7%94%A8+jQuery+%E6%8F%92%E4%BB%B6+CitySelect+%E5%AE%9E%E7%8E%B0%E7%9C%81%E5%B8%82%E8%81%94%E5%8A%A8%E6%95%88%E6%9E%9C&amp;guid=ON" /></p>', '使用 jQuery 插件 CitySelect 实现省市联动效果', '', 'publish', 'open', '1', '', '%e4%bd%bf%e7%94%a8-jquery-%e6%8f%92%e4%bb%b6-cityselect-%e5%ae%9e%e7%8e%b0%e7%9c%81%e5%b8%82%e8%81%94%e5%8a%a8%e6%95%88%e6%9e%9c', '', '', '2014-11-28 06:21:18', '2014-11-28 06:21:18', '<p>在一些和会员相关的注册系统中，让用户输入省市信息是非常常见的行为，并且一般都是要求做到省市区联动下拉效果，今天就给大家推荐一个 jQuery 插件 CitySelect，通过 JSON 数据实现省市联动效果：</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/5f51f82c73_600." alt="基于 jQuery+JSON 的省市联动效果" /></p>\n<h2>CitySelect 演示：</h2>\n<p><select></select>  <select disabled="disabled"></select> <select disabled="disabled"></select> </p>\n<h2>CitySelect 使用</h2>\n<p>首先在head中载入jquery库和cityselect插件。</p>\n<pre><code>\n&lt;script type=&quot;text/javascript&quot; src=&quot;js/jquery.js&quot;&gt;&lt;/script&gt; \r\n&lt;script type=&quot;text/javascript&quot; src=&quot;js/jquery.cityselect.js&quot;&gt;&lt;/script&gt; \n</code></pre>\n<p>接下来，我们在#city中，放置三个select，并且三个select分别设置class属性为：prov、city、dist，分别表示省、市、区（县）三个下拉框。注意如果只想实现省市二级联动，则去掉第三个dist的select即可。</p>\n<pre><code>\n&lt;div id=&quot;city&quot;&gt; \r\n    &lt;select class=&quot;prov&quot;&gt;&lt;/select&gt;  \r\n    &lt;select class=&quot;city&quot; disabled=&quot;disabled&quot;&gt;&lt;/select&gt; \r\n    &lt;select class=&quot;dist&quot; disabled=&quot;disabled&quot;&gt;&lt;/select&gt; \r\n&lt;/div&gt;\n</code></pre>\n<p>调用 cityselect 插件非常简单，直接调用：</p>\n<pre><code>\n$(&quot;#city&quot;).citySelect(); \n</code></pre>\n<p>自定义参数调用，设置默认省市区。</p>\n<pre><code>\n$(&quot;#city&quot;).citySelect({  \r\n    url:&quot;js/city.min.js&quot;,  \r\n    prov:&quot;湖南&quot;, //省份 \r\n    city:&quot;长沙&quot;, //城市 \r\n    dist:&quot;岳麓区&quot;, //区县 \r\n    nodata:&quot;none&quot; //当子集无数据时，隐藏select \r\n}); \n</code></pre>\n<p>下载：<a href="http://www.helloweba.com/down-188.html">CitySelect</a>\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/m/jquery-json-province-city/" title="使用 jQuery 插件 CitySelect 实现省市联动效果">使用 jQuery 插件 CitySelect 实现省市联动效果</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/e7c9d2c919_-feed-post-id-4492." /><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/837532fdab_ga-php-utmac-MO-328125-5-amp-utmn-137143336-amp-utmr-http-3A-2F-2Fblog-wpjam.com%2Ffeed%2F&amp;utmp=%2Frss%2Fm%2Fjquery-json-province-city%2F&amp;utmdt=%E4%BD%BF%E7%94%A8+jQuery+%E6%8F%92%E4%BB%B6+CitySelect+%E5%AE%9E%E7%8E%B0%E7%9C%81%E5%B8%82%E8%81%94%E5%8A%A8%E6%95%88%E6%9E%9C&amp;guid=ON" /></p>', 0, 'http://localhost:8080/2014/11/%e4%bd%bf%e7%94%a8-jquery-%e6%8f%92%e4%bb%b6-cityselect-%e5%ae%9e%e7%8e%b0%e7%9c%81%e5%b8%82%e8%81%94%e5%8a%a8%e6%95%88%e6%9e%9c/', 0, 'post', '', 0); 
INSERT INTO `wp_posts` VALUES (113, 1, '2014-11-28 09:38:17', '2014-11-28 09:38:17', '<h2>导入博客园、开源中国的博客文章到 WordPress</h2>\n<p>还在苦恼怎么 cnblogs、osc 功能太少吗，早有更换 WordPress 的冲动却无奈博客无法搬家？这款插件可以帮助大家自动转换博客园、开源中国的文章导入到 WordPress 中来哦。</p>\n<p>这款插件已在 WordPress 插件中心上线，大家可以直接在 WordPress 控制台进行在线安装，安装方法：</p>\n<ol>\n<li>在wordpress控制台，点击“安装插件”搜索“cnblogs”或搜索“osc”即可找到插件</li>\n<li>点击安装，稍作等待即可</li>\n<li>进入“已安装的插件”页面启动插件</li>\n</ol>\n<p>你也可以通过离线的方式安装，安装方法：</p>\n<ol>\n<li>下载离线插件包并解压，下载地址：<a href="https://wordpress.org/plugins/cnblogs2wp/">https://wordpress.org/plugins/cnblogs2wp/</a></li>\n<li>复制目录到/wp-content/plugins/目录下</li>\n<li>进入wordpress控制台</li>\n<li>插件管理中找到并启用“<strong>转换博客园、开源中国博客文章到wordpress</strong>”</li>\n</ol>\n<h2>数据导入方法</h2>\n<ol>\n<li>点击“工具-导入”，在列表中找到并选择“博客园或开源中国的数据导入”</li>\n<li>上传对应的数据，导入按照流程导入</li>\n</ol>\n<p><img alt="" src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/6b92f4ee21_600." /></p>\n<p><strong>注意事项：</strong></p>\n<ol>\n<li>cnblogs的数据文件是xml，osc的数据文件是htm，不能混淆导入</li>\n<li>导入文件大小根据wordpress设定来决定的，若你导入的数据文件超出了服务器、主机限制，请自行百度或google搜索：“wordpress 文件上传限制”</li>\n<li>浏览器需支持js正常执行</li>\n</ol>\n<p>若试用期间遇到什么问题，可以在下方文章地址告诉我，我会及时作出修正。</p>\n<p><a href="http://levi.cg.am/archives/3759?f=11.22">http://levi.cg.am/archives/3759?f=11.22</a>\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/m/cnblogs2wp/" title="将博客园、开源中国的博客文章导入到 WordPress 中">将博客园、开源中国的博客文章导入到 WordPress 中</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/9274831a18_-feed-post-id-4701." /><img src="http://blog.wpjam.com/wp-content/themes/Blix/modules/all-in-one/ga.php?utmac=MO-328125-5&amp;utmn=1732504801&amp;utmr=http%3A%2F%2Fblog.wpjam.com%2Ffeed%2F&amp;utmp=%2Frss%2Fm%2Fcnblogs2wp%2F&amp;utmdt=%E5%B0%86%E5%8D%9A%E5%AE%A2%E5%9B%AD%E3%80%81%E5%BC%80%E6%BA%90%E4%B8%AD%E5%9B%BD%E7%9A%84%E5%8D%9A%E5%AE%A2%E6%96%87%E7%AB%A0%E5%AF%BC%E5%85%A5%E5%88%B0+WordPress+%E4%B8%AD&amp;guid=ON" /></p>', '将博客园、开源中国的博客文章导入到 WordPress 中', '', 'publish', 'open', '1', '', '%e5%b0%86%e5%8d%9a%e5%ae%a2%e5%9b%ad%e3%80%81%e5%bc%80%e6%ba%90%e4%b8%ad%e5%9b%bd%e7%9a%84%e5%8d%9a%e5%ae%a2%e6%96%87%e7%ab%a0%e5%af%bc%e5%85%a5%e5%88%b0-wordpress-%e4%b8%ad', '', '', '2014-11-28 09:38:17', '2014-11-28 09:38:17', '<h2>导入博客园、开源中国的博客文章到 WordPress</h2>\n<p>还在苦恼怎么 cnblogs、osc 功能太少吗，早有更换 WordPress 的冲动却无奈博客无法搬家？这款插件可以帮助大家自动转换博客园、开源中国的文章导入到 WordPress 中来哦。</p>\n<p>这款插件已在 WordPress 插件中心上线，大家可以直接在 WordPress 控制台进行在线安装，安装方法：</p>\n<ol>\n<li>在wordpress控制台，点击“安装插件”搜索“cnblogs”或搜索“osc”即可找到插件</li>\n<li>点击安装，稍作等待即可</li>\n<li>进入“已安装的插件”页面启动插件</li>\n</ol>\n<p>你也可以通过离线的方式安装，安装方法：</p>\n<ol>\n<li>下载离线插件包并解压，下载地址：<a href="https://wordpress.org/plugins/cnblogs2wp/">https://wordpress.org/plugins/cnblogs2wp/</a></li>\n<li>复制目录到/wp-content/plugins/目录下</li>\n<li>进入wordpress控制台</li>\n<li>插件管理中找到并启用“<strong>转换博客园、开源中国博客文章到wordpress</strong>”</li>\n</ol>\n<h2>数据导入方法</h2>\n<ol>\n<li>点击“工具-导入”，在列表中找到并选择“博客园或开源中国的数据导入”</li>\n<li>上传对应的数据，导入按照流程导入</li>\n</ol>\n<p><img alt="" src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/6b92f4ee21_600." /></p>\n<p><strong>注意事项：</strong></p>\n<ol>\n<li>cnblogs的数据文件是xml，osc的数据文件是htm，不能混淆导入</li>\n<li>导入文件大小根据wordpress设定来决定的，若你导入的数据文件超出了服务器、主机限制，请自行百度或google搜索：“wordpress 文件上传限制”</li>\n<li>浏览器需支持js正常执行</li>\n</ol>\n<p>若试用期间遇到什么问题，可以在下方文章地址告诉我，我会及时作出修正。</p>\n<p><a href="http://levi.cg.am/archives/3759?f=11.22">http://levi.cg.am/archives/3759?f=11.22</a>\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/m/cnblogs2wp/" title="将博客园、开源中国的博客文章导入到 WordPress 中">将博客园、开源中国的博客文章导入到 WordPress 中</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/9274831a18_-feed-post-id-4701." /><img src="http://blog.wpjam.com/wp-content/themes/Blix/modules/all-in-one/ga.php?utmac=MO-328125-5&amp;utmn=1732504801&amp;utmr=http%3A%2F%2Fblog.wpjam.com%2Ffeed%2F&amp;utmp=%2Frss%2Fm%2Fcnblogs2wp%2F&amp;utmdt=%E5%B0%86%E5%8D%9A%E5%AE%A2%E5%9B%AD%E3%80%81%E5%BC%80%E6%BA%90%E4%B8%AD%E5%9B%BD%E7%9A%84%E5%8D%9A%E5%AE%A2%E6%96%87%E7%AB%A0%E5%AF%BC%E5%85%A5%E5%88%B0+WordPress+%E4%B8%AD&amp;guid=ON" /></p>', 0, 'http://localhost:8080/2014/11/%e5%b0%86%e5%8d%9a%e5%ae%a2%e5%9b%ad%e3%80%81%e5%bc%80%e6%ba%90%e4%b8%ad%e5%9b%bd%e7%9a%84%e5%8d%9a%e5%ae%a2%e6%96%87%e7%ab%a0%e5%af%bc%e5%85%a5%e5%88%b0-wordpress-%e4%b8%ad/', 0, 'post', '', 0); 
INSERT INTO `wp_posts` VALUES (114, 1, '2014-11-28 10:28:13', '2014-11-28 10:28:13', '<h2>Coding 介绍</h2>\n<p>Coding 是一个面向开发者的云端开发平台，目前提供代码托管，运行空间，质量控制，项目管理等功能。Coding 提供社会化协作功能，包含了社交元素，为开发者提供技术讨论和协作平台。</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/633e85bfd7_300." alt="Coding.net：面向开发者的云端开发平台" width="300" /></p>\n<ul>\n<li><strong>代码托管平台</strong>：通过代码版本控制系统 git 进行公开项目或者私有项目的源码托管。</li>\n<li><strong>在线运行环境</strong>：无需重复搭建配置环境，一键部署，在云端进行项目展示。</li>\n<li><strong>代码质量监控</strong>：通过自动化静态代码分析等管理工具，发现代码问题，获取代码度量信息，及时了解代码质量状况，保证项目管理质量。</li>\n<li><strong>项目管理平台</strong>：通过社会化项目协作管理平台，开发团队成员之间可自由进行信息交流、知识分享、任务管理和项目讨论，让远程协作和云端管理变得简单高效。</li>\n</ul>\n<h2>在Coding.net 上传 WordPress 源代码</h2>\n<p>在 <a href="https://coding.net/">Coding.net</a> 注册账号并且登陆后进入自己的主页就可以上传 WordPress 源代码：</p>\n<p><strong>方法一：直接将现有的项目 fork 一份。</strong></p>\n<p>进入已经建好的 wordpress 项目：<a href="直接将现有的项目 fork 一份。 进入已经建好的 wordpress 项目：https://coding.net/u/ylgaoyifan/p/wordpress/git">https://coding.net/u/ylgaoyifan/p/wordpress/git</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/f504d96713_600." alt="fork WordPress 源代码" /></p>\n<p>点击右上角 Fork 按钮，再点击确定，然后会跳转到自己的项目页面。这个操作其实是将这个项目做一个副本，作为自己新项目的文件。优点是操作起来比较简单，缺点是没办法自定义源程序。</p>\n<p><strong>方法二：通过 git 上传。</strong></p>\n<p>Windows 系统安装 git（for windows） ，安装过程中不用修改任何配置，全部使用安装向导默认选项即可；Mac 系统建议安装 Command Line Tools（工具集中含有git 1.8.5），Linux 系统一般自带 git。详细的 Git 上传过程这里就不说了。</p>\n<h2>Coding.net 上部署 WordPress </h2>\n<p>在个人首页中点击演示，我们要检测程序的运行的环境，Coding 提供了检测功能，只需要简单点击下“开始检测”即可。</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/293de53801_600." alt="检测程序的运行的环境" /></p>\n<p>WordPress 运行是需要 MySQL 数据支持的，Coding 也支持 MySQL 数据库服务，在演示平台的控制台页面，点击左侧导航栏“服务管理”选项，进入服务列表页面，点击右上角“添加服务”：</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/e931ea4761_600." alt="添加 MySQL" /></p>\n<p>选择 MySQL 服务并勾选绑定创建后的服务到此项目。在“可用服务”里可以看到刚才添加的服务，点击绑定之后，就可以在“已绑定服务”里看到该服务，点击“连接信息”。记下 MySQL 的数据库名( name ),服务器名（hostname）,用户名( username ),密码（password）。</p>\n<p>回到”控制台”页面，部署版本填写“ master ”，点击一键部署：</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/feb5c23e33_600." alt="一键部署" /></p>\n<p>一键部署成功后，点击启动，然后使用二级域名访问你的网站，点击创建配置文件，填写您的数据库名（name）、数据库主机( hostname )、用户名( username )、密码（password），点击进行安装。最后大功告成。\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/article/coding-net/" title="云端开发平台 Coding.net 介绍和 WordPress 部署">云端开发平台 Coding.net 介绍和 WordPress 部署</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/82160d1d0d_-feed-post-id-4544." /><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/7c30020ad0_ga-php-utmac-MO-328125-5-amp-utmn-146563720-amp-utmr-http-3A-2F-2Fblog-wpjam-com-2Ffeed-2F-amp-utmp--2Frss-2Farticle-2Fcoding-net-2F-amp-utmdt--E4-BA-91-E7-AB-AF-E5-BC-80-E5-8F-91-E5-B9-B3-E5-8F-B0-Coding.net+%E4%BB%8B%E7%BB%8D%E5%92%8C+WordPress+%E9%83%A8%E7%BD%B2&amp;guid=ON" /></p>', '云端开发平台 Coding.net 介绍和 WordPress 部署', '', 'publish', 'open', '1', '', '%e4%ba%91%e7%ab%af%e5%bc%80%e5%8f%91%e5%b9%b3%e5%8f%b0-coding-net-%e4%bb%8b%e7%bb%8d%e5%92%8c-wordpress-%e9%83%a8%e7%bd%b2', '', '', '2014-11-28 10:28:13', '2014-11-28 10:28:13', '<h2>Coding 介绍</h2>\n<p>Coding 是一个面向开发者的云端开发平台，目前提供代码托管，运行空间，质量控制，项目管理等功能。Coding 提供社会化协作功能，包含了社交元素，为开发者提供技术讨论和协作平台。</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/633e85bfd7_300." alt="Coding.net：面向开发者的云端开发平台" width="300" /></p>\n<ul>\n<li><strong>代码托管平台</strong>：通过代码版本控制系统 git 进行公开项目或者私有项目的源码托管。</li>\n<li><strong>在线运行环境</strong>：无需重复搭建配置环境，一键部署，在云端进行项目展示。</li>\n<li><strong>代码质量监控</strong>：通过自动化静态代码分析等管理工具，发现代码问题，获取代码度量信息，及时了解代码质量状况，保证项目管理质量。</li>\n<li><strong>项目管理平台</strong>：通过社会化项目协作管理平台，开发团队成员之间可自由进行信息交流、知识分享、任务管理和项目讨论，让远程协作和云端管理变得简单高效。</li>\n</ul>\n<h2>在Coding.net 上传 WordPress 源代码</h2>\n<p>在 <a href="https://coding.net/">Coding.net</a> 注册账号并且登陆后进入自己的主页就可以上传 WordPress 源代码：</p>\n<p><strong>方法一：直接将现有的项目 fork 一份。</strong></p>\n<p>进入已经建好的 wordpress 项目：<a href="直接将现有的项目 fork 一份。 进入已经建好的 wordpress 项目：https://coding.net/u/ylgaoyifan/p/wordpress/git">https://coding.net/u/ylgaoyifan/p/wordpress/git</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/f504d96713_600." alt="fork WordPress 源代码" /></p>\n<p>点击右上角 Fork 按钮，再点击确定，然后会跳转到自己的项目页面。这个操作其实是将这个项目做一个副本，作为自己新项目的文件。优点是操作起来比较简单，缺点是没办法自定义源程序。</p>\n<p><strong>方法二：通过 git 上传。</strong></p>\n<p>Windows 系统安装 git（for windows） ，安装过程中不用修改任何配置，全部使用安装向导默认选项即可；Mac 系统建议安装 Command Line Tools（工具集中含有git 1.8.5），Linux 系统一般自带 git。详细的 Git 上传过程这里就不说了。</p>\n<h2>Coding.net 上部署 WordPress </h2>\n<p>在个人首页中点击演示，我们要检测程序的运行的环境，Coding 提供了检测功能，只需要简单点击下“开始检测”即可。</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/293de53801_600." alt="检测程序的运行的环境" /></p>\n<p>WordPress 运行是需要 MySQL 数据支持的，Coding 也支持 MySQL 数据库服务，在演示平台的控制台页面，点击左侧导航栏“服务管理”选项，进入服务列表页面，点击右上角“添加服务”：</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/e931ea4761_600." alt="添加 MySQL" /></p>\n<p>选择 MySQL 服务并勾选绑定创建后的服务到此项目。在“可用服务”里可以看到刚才添加的服务，点击绑定之后，就可以在“已绑定服务”里看到该服务，点击“连接信息”。记下 MySQL 的数据库名( name ),服务器名（hostname）,用户名( username ),密码（password）。</p>\n<p>回到”控制台”页面，部署版本填写“ master ”，点击一键部署：</p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/feb5c23e33_600." alt="一键部署" /></p>\n<p>一键部署成功后，点击启动，然后使用二级域名访问你的网站，点击创建配置文件，填写您的数据库名（name）、数据库主机( hostname )、用户名( username )、密码（password），点击进行安装。最后大功告成。\n<p>&gt;&gt;&gt;继续阅读<a href="http://blog.wpjam.com/article/coding-net/" title="云端开发平台 Coding.net 介绍和 WordPress 部署">云端开发平台 Coding.net 介绍和 WordPress 部署</a>的全文 &#8230;</p>\n<p> &copy; <a href="http://blog.wpjam.com" title="我爱水煮鱼">我爱水煮鱼</a> / <a href="http://blog.wpjam.com/feed/" title="订阅我爱水煮鱼">RSS 订阅</a> / <a href="http://wpjam.com/" title="WordPress JAM">长期承接 WordPress 项目</a> / <a href="http://blog.wpjam.com/coupon/" title="主机域名优惠码">主机域名优惠码</a> / <a href="http://weibo.com/wpjam/" title="新浪微博">新浪微博</a></p>\n<p><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/82160d1d0d_-feed-post-id-4544." /><img src="http://localhost:8080/wp-content/plugins/wp-o-matic/cache/7c30020ad0_ga-php-utmac-MO-328125-5-amp-utmn-146563720-amp-utmr-http-3A-2F-2Fblog-wpjam-com-2Ffeed-2F-amp-utmp--2Frss-2Farticle-2Fcoding-net-2F-amp-utmdt--E4-BA-91-E7-AB-AF-E5-BC-80-E5-8F-91-E5-B9-B3-E5-8F-B0-Coding.net+%E4%BB%8B%E7%BB%8D%E5%92%8C+WordPress+%E9%83%A8%E7%BD%B2&amp;guid=ON" /></p>', 0, 'http://localhost:8080/2014/11/%e4%ba%91%e7%ab%af%e5%bc%80%e5%8f%91%e5%b9%b3%e5%8f%b0-coding-net-%e4%bb%8b%e7%bb%8d%e5%92%8c-wordpress-%e9%83%a8%e7%bd%b2/', 0, 'post', '', 0);
#
#  `wp_posts` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_term_relationships`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_term_relationships` 数据表
#

DROP TABLE IF EXISTS `wp_term_relationships`;


#
#  `wp_term_relationships` 数据表的结构
#

CREATE TABLE `wp_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

#
#  `wp_term_relationships` 数据表的内容
#
 
INSERT INTO `wp_term_relationships` VALUES (112, 2, 0); 
INSERT INTO `wp_term_relationships` VALUES (108, 2, 0); 
INSERT INTO `wp_term_relationships` VALUES (111, 2, 0); 
INSERT INTO `wp_term_relationships` VALUES (114, 2, 0); 
INSERT INTO `wp_term_relationships` VALUES (107, 2, 0); 
INSERT INTO `wp_term_relationships` VALUES (113, 2, 0);
#
#  `wp_term_relationships` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_term_taxonomy`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_term_taxonomy` 数据表
#

DROP TABLE IF EXISTS `wp_term_taxonomy`;


#
#  `wp_term_taxonomy` 数据表的结构
#

CREATE TABLE `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ;

#
#  `wp_term_taxonomy` 数据表的内容
#
 
INSERT INTO `wp_term_taxonomy` VALUES (1, 1, 'category', '', 0, 0); 
INSERT INTO `wp_term_taxonomy` VALUES (2, 2, 'category', '', 0, 4); 
INSERT INTO `wp_term_taxonomy` VALUES (3, 3, 'category', '', 0, 0);
#
#  `wp_term_taxonomy` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_terms`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_terms` 数据表
#

DROP TABLE IF EXISTS `wp_terms`;


#
#  `wp_terms` 数据表的结构
#

CREATE TABLE `wp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ;

#
#  `wp_terms` 数据表的内容
#
 
INSERT INTO `wp_terms` VALUES (1, '未分类', 'uncategorized', 0); 
INSERT INTO `wp_terms` VALUES (2, '个人站长博客', '%e4%b8%aa%e4%ba%ba%e7%ab%99%e9%95%bf%e5%8d%9a%e5%ae%a2', 0); 
INSERT INTO `wp_terms` VALUES (3, 'happyThings', 'happythings', 0);
#
#  `wp_terms` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_usermeta`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_usermeta` 数据表
#

DROP TABLE IF EXISTS `wp_usermeta`;


#
#  `wp_usermeta` 数据表的结构
#

CREATE TABLE `wp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 ;

#
#  `wp_usermeta` 数据表的内容
#
 
INSERT INTO `wp_usermeta` VALUES (1, 1, 'nickname', '幸福小白'); 
INSERT INTO `wp_usermeta` VALUES (2, 1, 'first_name', ''); 
INSERT INTO `wp_usermeta` VALUES (3, 1, 'last_name', ''); 
INSERT INTO `wp_usermeta` VALUES (4, 1, 'description', '幸福的小白，每天分享着快乐的事情！'); 
INSERT INTO `wp_usermeta` VALUES (5, 1, 'rich_editing', 'true'); 
INSERT INTO `wp_usermeta` VALUES (6, 1, 'comment_shortcuts', 'false'); 
INSERT INTO `wp_usermeta` VALUES (7, 1, 'admin_color', 'fresh'); 
INSERT INTO `wp_usermeta` VALUES (8, 1, 'use_ssl', '0'); 
INSERT INTO `wp_usermeta` VALUES (9, 1, 'show_admin_bar_front', 'false'); 
INSERT INTO `wp_usermeta` VALUES (10, 1, 'wp_capabilities', 'a:1:{s:13:"administrator";b:1;}'); 
INSERT INTO `wp_usermeta` VALUES (11, 1, 'wp_user_level', '10'); 
INSERT INTO `wp_usermeta` VALUES (12, 1, 'dismissed_wp_pointers', 'wp350_media,wp360_revisions,wp360_locks,wp390_widgets'); 
INSERT INTO `wp_usermeta` VALUES (13, 1, 'show_welcome_panel', '1'); 
INSERT INTO `wp_usermeta` VALUES (14, 1, 'session_tokens', 'a:1:{s:64:"ac0e148070b7b605ec97c19e1b320a50b0aae0691d57152a1005fcd6b2a2b641";i:1417352715;}'); 
INSERT INTO `wp_usermeta` VALUES (15, 1, 'wp_dashboard_quick_press_last_post_id', '3'); 
INSERT INTO `wp_usermeta` VALUES (16, 2, 'nickname', 'joyful'); 
INSERT INTO `wp_usermeta` VALUES (17, 2, 'first_name', ''); 
INSERT INTO `wp_usermeta` VALUES (18, 2, 'last_name', ''); 
INSERT INTO `wp_usermeta` VALUES (19, 2, 'description', ''); 
INSERT INTO `wp_usermeta` VALUES (20, 2, 'rich_editing', 'true'); 
INSERT INTO `wp_usermeta` VALUES (21, 2, 'comment_shortcuts', 'false'); 
INSERT INTO `wp_usermeta` VALUES (22, 2, 'admin_color', 'fresh'); 
INSERT INTO `wp_usermeta` VALUES (23, 2, 'use_ssl', '0'); 
INSERT INTO `wp_usermeta` VALUES (24, 2, 'show_admin_bar_front', 'true'); 
INSERT INTO `wp_usermeta` VALUES (25, 2, 'wp_capabilities', 'a:1:{s:11:"contributor";b:1;}'); 
INSERT INTO `wp_usermeta` VALUES (26, 2, 'wp_user_level', '1'); 
INSERT INTO `wp_usermeta` VALUES (27, 2, 'dismissed_wp_pointers', 'wp350_media,wp360_revisions,wp360_locks,wp390_widgets'); 
INSERT INTO `wp_usermeta` VALUES (28, 3, 'nickname', 'actboy'); 
INSERT INTO `wp_usermeta` VALUES (29, 3, 'first_name', ''); 
INSERT INTO `wp_usermeta` VALUES (30, 3, 'last_name', ''); 
INSERT INTO `wp_usermeta` VALUES (31, 3, 'description', ''); 
INSERT INTO `wp_usermeta` VALUES (32, 3, 'rich_editing', 'true'); 
INSERT INTO `wp_usermeta` VALUES (33, 3, 'comment_shortcuts', 'false'); 
INSERT INTO `wp_usermeta` VALUES (34, 3, 'admin_color', 'fresh'); 
INSERT INTO `wp_usermeta` VALUES (35, 3, 'use_ssl', '0'); 
INSERT INTO `wp_usermeta` VALUES (36, 3, 'show_admin_bar_front', 'true'); 
INSERT INTO `wp_usermeta` VALUES (37, 3, 'wp_capabilities', 'a:1:{s:11:"contributor";b:1;}'); 
INSERT INTO `wp_usermeta` VALUES (38, 3, 'wp_user_level', '1'); 
INSERT INTO `wp_usermeta` VALUES (39, 3, 'dismissed_wp_pointers', 'wp350_media,wp360_revisions,wp360_locks,wp390_widgets'); 
INSERT INTO `wp_usermeta` VALUES (40, 1, 'managenav-menuscolumnshidden', 'a:4:{i:0;s:11:"link-target";i:1;s:11:"css-classes";i:2;s:3:"xfn";i:3;s:11:"description";}'); 
INSERT INTO `wp_usermeta` VALUES (41, 1, 'metaboxhidden_nav-menus', 'a:2:{i:0;s:8:"add-post";i:1;s:12:"add-post_tag";}'); 
INSERT INTO `wp_usermeta` VALUES (42, 1, 'wp_user-settings', 'posts_list_mode=list'); 
INSERT INTO `wp_usermeta` VALUES (43, 1, 'wp_user-settings-time', '1417183731');
#
#  `wp_usermeta` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_users`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_users` 数据表
#

DROP TABLE IF EXISTS `wp_users`;


#
#  `wp_users` 数据表的结构
#

CREATE TABLE `wp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ;

#
#  `wp_users` 数据表的内容
#
 
INSERT INTO `wp_users` VALUES (1, 'admin', '$P$BkGhrBu3NFZwNoBSFons57g6dwYizu0', 'admin', '824811854@qq.com', '', '2014-11-25 14:06:24', '', 0, '幸福小白'); 
INSERT INTO `wp_users` VALUES (2, 'joyful', '$P$BiXFFn0VxQ0E22eitbpGXjZYn0mhIF0', 'joyful', '937948323@qq.com', '', '2014-11-26 15:15:10', '', 0, 'joyful'); 
INSERT INTO `wp_users` VALUES (3, 'actboy', '$P$BD9N30DnFSU3BxCTXa8niIxSNDFapS1', 'actboy', 'actboy@localhost.com', '', '2014-11-27 13:21:11', '', 0, 'actboy');
#
#  `wp_users` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_autolink`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_autolink` 数据表
#

DROP TABLE IF EXISTS `wp_autolink`;


#
#  `wp_autolink` 数据表的结构
#

CREATE TABLE `wp_autolink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
#  `wp_autolink` 数据表的内容
#

#
#  `wp_autolink` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_autopost_log`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_autopost_log` 数据表
#

DROP TABLE IF EXISTS `wp_autopost_log`;


#
#  `wp_autopost_log` 数据表的结构
#

CREATE TABLE `wp_autopost_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_id` int(10) unsigned DEFAULT NULL,
  `date_time` int(10) unsigned DEFAULT NULL,
  `info` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
#  `wp_autopost_log` 数据表的内容
#

#
#  `wp_autopost_log` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_autopost_record`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_autopost_record` 数据表
#

DROP TABLE IF EXISTS `wp_autopost_record`;


#
#  `wp_autopost_record` 数据表的结构
#

CREATE TABLE `wp_autopost_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_id` smallint(5) unsigned NOT NULL,
  `url` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_id` int(10) unsigned NOT NULL,
  `date_time` int(10) unsigned NOT NULL,
  `url_status` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `url` (`url`(333)),
  KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
#  `wp_autopost_record` 数据表的内容
#

#
#  `wp_autopost_record` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_autopost_task`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_autopost_task` 数据表
#

DROP TABLE IF EXISTS `wp_autopost_task`;


#
#  `wp_autopost_task` 数据表的结构
#

CREATE TABLE `wp_autopost_task` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `m_extract` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `activation` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` char(200) COLLATE utf8_unicode_ci NOT NULL,
  `page_charset` char(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UTF-8',
  `a_match_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `title_match_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `content_match_type` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `auto_set` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `a_selector` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title_selector` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_selector` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `start_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `end_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `updated_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` smallint(5) unsigned DEFAULT NULL,
  `update_interval` smallint(5) unsigned NOT NULL DEFAULT '60',
  `published_interval` smallint(5) unsigned NOT NULL DEFAULT '60',
  `post_scheduled` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_scheduled_last_time` int(10) unsigned NOT NULL DEFAULT '0',
  `last_update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `post_id` int(10) unsigned NOT NULL DEFAULT '0',
  `last_error` int(10) unsigned NOT NULL DEFAULT '0',
  `is_running` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `reverse_sort` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `auto_tags` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `proxy` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'post',
  `post_format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `check_duplicate` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `err_status` tinyint(3) NOT NULL DEFAULT '1',
  `publish_date` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
#  `wp_autopost_task` 数据表的内容
#
 
INSERT INTO `wp_autopost_task` VALUES (1, 0, 0, '示例任务-作为参考以快速掌握该插件的使用', 'UTF-8', 1, 0, '["0,0"]', '', '.contList  a', '#artibodyTitle', '["#artibody"]', 0, 0, 0, 0, '', 1, 60, 60, '["0",12,0]', 0, 0, 0, 0, 0, 0, '[0,0,0]', '[0,0]', 'post', '', 0, 1, '');
#
#  `wp_autopost_task` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_autopost_task_urllist`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_autopost_task_urllist` 数据表
#

DROP TABLE IF EXISTS `wp_autopost_task_urllist`;


#
#  `wp_autopost_task_urllist` 数据表的结构
#

CREATE TABLE `wp_autopost_task_urllist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `config_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `url` char(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
#  `wp_autopost_task_urllist` 数据表的内容
#
 
INSERT INTO `wp_autopost_task_urllist` VALUES (5, 1, 'http://roll.tech.sina.com.cn/internet_worldlist/index_1.shtml');
#
#  `wp_autopost_task_urllist` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_autopost_watermark`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_autopost_watermark` 数据表
#

DROP TABLE IF EXISTS `wp_autopost_watermark`;


#
#  `wp_autopost_watermark` 数据表的结构
#

CREATE TABLE `wp_autopost_watermark` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `wm_type` tinyint(3) NOT NULL DEFAULT '0',
  `wm_position` tinyint(3) NOT NULL DEFAULT '9',
  `wm_font` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wm_text` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wm_size` smallint(5) DEFAULT '16',
  `wm_color` varchar(100) COLLATE utf8_unicode_ci DEFAULT '#ffffff',
  `x_adjustment` smallint(5) DEFAULT '0',
  `y_adjustment` smallint(5) DEFAULT '0',
  `transparency` smallint(5) DEFAULT '80',
  `upload_image` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upload_image_url` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `min_width` smallint(5) DEFAULT '150',
  `min_height` smallint(5) DEFAULT '150',
  `jpeg_quality` smallint(5) DEFAULT '90',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

#
#  `wp_autopost_watermark` 数据表的内容
#
 
INSERT INTO `wp_autopost_watermark` VALUES (1, 'Default Watermark', 1, 9, '', 'http://localhost:8080', 16, '#ffffff', 0, 0, 80, '/vagrant/wordpress/wp-content/plugins/wp-autopost/watermark/uploads/watermark.png', 'http://localhost:8080/wp-content/plugins/wp-autopost/watermark/uploads/watermark.png', 150, 150, 90);
#
#  `wp_autopost_watermark` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wpo_campaign`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wpo_campaign` 数据表
#

DROP TABLE IF EXISTS `wp_wpo_campaign`;


#
#  `wp_wpo_campaign` 数据表的结构
#

CREATE TABLE `wp_wpo_campaign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `active` tinyint(1) DEFAULT '1',
  `slug` varchar(250) DEFAULT '',
  `template` mediumtext,
  `frequency` int(5) DEFAULT '180',
  `feeddate` tinyint(1) DEFAULT '0',
  `cacheimages` tinyint(1) DEFAULT '1',
  `posttype` enum('publish','draft','private') NOT NULL DEFAULT 'publish',
  `authorid` int(11) DEFAULT NULL,
  `comment_status` enum('open','closed','registered_only') NOT NULL DEFAULT 'open',
  `allowpings` tinyint(1) DEFAULT '1',
  `dopingbacks` tinyint(1) DEFAULT '1',
  `max` smallint(3) DEFAULT '10',
  `linktosource` tinyint(1) DEFAULT '0',
  `count` int(11) DEFAULT '0',
  `lastactive` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ;

#
#  `wp_wpo_campaign` 数据表的内容
#
 
INSERT INTO `wp_wpo_campaign` VALUES (1, '好的博客', 1, 'good blog', '', 104400, 0, 1, 'publish', 1, 'open', 1, 0, 4, 0, 4, '2014-11-28 14:18:16', '0000-00-00 00:00:00'); 
INSERT INTO `wp_wpo_campaign` VALUES (2, 'joyfulThings', 1, 'joyfulthings', '', 104400, 0, 1, 'publish', 3, 'open', 1, 0, 10, 0, 30, '2014-11-27 13:44:19', '0000-00-00 00:00:00');
#
#  `wp_wpo_campaign` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wpo_campaign_category`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wpo_campaign_category` 数据表
#

DROP TABLE IF EXISTS `wp_wpo_campaign_category`;


#
#  `wp_wpo_campaign_category` 数据表的结构
#

CREATE TABLE `wp_wpo_campaign_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ;

#
#  `wp_wpo_campaign_category` 数据表的内容
#
 
INSERT INTO `wp_wpo_campaign_category` VALUES (15, 2, 1); 
INSERT INTO `wp_wpo_campaign_category` VALUES (14, 3, 2);
#
#  `wp_wpo_campaign_category` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wpo_campaign_feed`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wpo_campaign_feed` 数据表
#

DROP TABLE IF EXISTS `wp_wpo_campaign_feed`;


#
#  `wp_wpo_campaign_feed` 数据表的结构
#

CREATE TABLE `wp_wpo_campaign_feed` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(255) DEFAULT '',
  `count` int(11) DEFAULT '0',
  `hash` varchar(255) DEFAULT '',
  `lastactive` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ;

#
#  `wp_wpo_campaign_feed` 数据表的内容
#
 
INSERT INTO `wp_wpo_campaign_feed` VALUES (5, 2, 'http://rickwarren.org/feeds/daily-hope', '', 'Daily Hope', '', '', 10, '0dc9f8b0165ed20baf8d3f84cabd4df4126e2ba9', '2014-11-27 13:23:00'); 
INSERT INTO `wp_wpo_campaign_feed` VALUES (6, 1, 'http://blog.wpjam.com/feed/', '', '我爱水煮鱼', '人人都爱 WordPress', '', 4, '2420b6dcd45d50da116b7f8748cf8006e0d8162b', '2014-11-28 14:18:16'); 
INSERT INTO `wp_wpo_campaign_feed` VALUES (4, 2, 'http://makemejoyful.com/feed/', '', 'Make Me Joyful', 'For a life that\'s more than so-so', '', 10, '5a66a2a2700d6d2d9cd3b211ecb45651cba73d91', '2014-11-27 13:44:19');
#
#  `wp_wpo_campaign_feed` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wpo_campaign_post`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wpo_campaign_post` 数据表
#

DROP TABLE IF EXISTS `wp_wpo_campaign_post`;


#
#  `wp_wpo_campaign_post` 数据表的结构
#

CREATE TABLE `wp_wpo_campaign_post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `feed_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `hash` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 ;

#
#  `wp_wpo_campaign_post` 数据表的内容
#
 
INSERT INTO `wp_wpo_campaign_post` VALUES (56, 1, 6, 114, '2420b6dcd45d50da116b7f8748cf8006e0d8162b'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (55, 1, 6, 113, '9470818117393ad28ba7836abd4c307f90743ba1'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (21, 2, 3, 24, '52f80b8fa6cac454f3c473c55589ea4d86534488'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (22, 2, 3, 25, '5cb6186965f5ddf6cfe75b2485d5e01ca4f4a903'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (23, 2, 3, 26, 'a11c28dc54f4b9099ca626d2fc13e2ebc506dedc'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (24, 2, 3, 27, 'bbced2c38f4ea5e12a35c32a0738d6712ab33fd9'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (25, 2, 3, 28, 'ff36170c5c9e6bb03e61c2b306042d5560abc974'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (26, 2, 3, 29, '9db250e5faab8f4ca0371c7d2e4b13aaa483b25d'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (27, 2, 3, 30, '244c9d8b7f0f3c32e1c25a62646d20bb3777ba7a'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (28, 2, 3, 31, 'd2b20e6fac75433bfab741f20fdcc7c490e01a46'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (29, 2, 3, 32, '3ec9a07051ba5c29258503d9f2329321c05f640b'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (30, 2, 3, 33, '16975d442fde591ac89e25588b9c942759448ed8'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (31, 2, 5, 34, '2ac9b61abcbd0c818c24d69964be19e245cc7ffa'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (32, 2, 5, 35, '5b1746c34bdfc82503496d7514a40af976095915'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (33, 2, 5, 36, '314ed3ea8d9219040618fac6998f04c8fa381759'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (34, 2, 5, 37, '1cbe754efd86240c0812c7f18367e195cdd4ba7b'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (35, 2, 5, 38, 'e03c8f09a38b31e0e72019bd8e9ea090ba0d8974'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (36, 2, 5, 39, 'eb89be313a56c29216092ff47cfeb69f15fea17c'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (37, 2, 5, 40, '88eb489344e408f45d6d85cbfec40b9fe02c0f3b'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (38, 2, 5, 41, 'e5736252939fce84cee350030239b503eb854614'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (39, 2, 5, 42, '81666304fca52002e6b9798404d0b4d3662034fb'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (40, 2, 5, 43, '0dc9f8b0165ed20baf8d3f84cabd4df4126e2ba9'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (41, 2, 4, 85, '0f7dd2d1cf1e8e431156efa40df404f767c1fbd3'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (42, 2, 4, 86, 'a30434fa73c4e9d552298f9a6cd640cac0d46b30'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (43, 2, 4, 87, 'c6adc004a248cdad5f3d8e659e510e02e8e12669'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (44, 2, 4, 88, '053a6383b3b491a5dd7f4ea56c59a4388ee87e7d'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (45, 2, 4, 89, '337e5084eb3d2bed7a1db4a6937ec20f17fc68d2'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (46, 2, 4, 90, 'ba6fdaf88c5994b124184a22a2cc689eddfd303f'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (47, 2, 4, 91, 'ecf91824bf28a1e559d9394731b0b58b6659bcb3'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (48, 2, 4, 92, '1dd6159447b02f3e79cf80f4fe946346b372cc03'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (49, 2, 4, 93, '6d84c927c7ce07f63748a5b661d55b93b92b7db6'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (50, 2, 4, 94, '5a66a2a2700d6d2d9cd3b211ecb45651cba73d91'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (54, 1, 6, 112, 'cc55ac5349d2ac477b3a7d0a1cd56288ac7a5cc4'); 
INSERT INTO `wp_wpo_campaign_post` VALUES (53, 1, 6, 111, '1d9b8c5b61e8954cd7d0f3aaf8620661f160271b');
#
#  `wp_wpo_campaign_post` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wpo_campaign_word`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wpo_campaign_word` 数据表
#

DROP TABLE IF EXISTS `wp_wpo_campaign_word`;


#
#  `wp_wpo_campaign_word` 数据表的结构
#

CREATE TABLE `wp_wpo_campaign_word` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL DEFAULT '',
  `regex` tinyint(1) DEFAULT '0',
  `rewrite` tinyint(1) DEFAULT '1',
  `rewrite_to` varchar(255) DEFAULT '',
  `relink` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

#
#  `wp_wpo_campaign_word` 数据表的内容
#

#
#  `wp_wpo_campaign_word` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wpo_log`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wpo_log` 数据表
#

DROP TABLE IF EXISTS `wp_wpo_log`;


#
#  `wp_wpo_log` 数据表的结构
#

CREATE TABLE `wp_wpo_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `message` mediumtext NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 ;

#
#  `wp_wpo_log` 数据表的内容
#
 
INSERT INTO `wp_wpo_log` VALUES (1, 'Processing campaign 测试title (ID: 1)', '2014-11-26 14:59:38'); 
INSERT INTO `wp_wpo_log` VALUES (2, 'Processing feed 幸福满家园有声博客 (ID: 1)', '2014-11-26 14:59:38'); 
INSERT INTO `wp_wpo_log` VALUES (3, 'Campaign fetch limit reached at 10', '2014-11-26 14:59:44'); 
INSERT INTO `wp_wpo_log` VALUES (4, 'Processing item', '2014-11-26 14:59:44'); 
INSERT INTO `wp_wpo_log` VALUES (5, 'Caching images', '2014-11-26 14:59:44'); 
INSERT INTO `wp_wpo_log` VALUES (6, 'Processing item', '2014-11-26 15:00:15'); 
INSERT INTO `wp_wpo_log` VALUES (7, 'Caching images', '2014-11-26 15:00:15'); 
INSERT INTO `wp_wpo_log` VALUES (8, 'Processing item', '2014-11-26 15:01:57'); 
INSERT INTO `wp_wpo_log` VALUES (9, 'Caching images', '2014-11-26 15:01:57'); 
INSERT INTO `wp_wpo_log` VALUES (10, 'Processing item', '2014-11-26 15:02:18'); 
INSERT INTO `wp_wpo_log` VALUES (11, 'Caching images', '2014-11-26 15:02:18'); 
INSERT INTO `wp_wpo_log` VALUES (12, 'Processing item', '2014-11-26 15:02:38'); 
INSERT INTO `wp_wpo_log` VALUES (13, 'Caching images', '2014-11-26 15:02:38'); 
INSERT INTO `wp_wpo_log` VALUES (14, 'Processing item', '2014-11-26 15:03:09'); 
INSERT INTO `wp_wpo_log` VALUES (15, 'Caching images', '2014-11-26 15:03:09'); 
INSERT INTO `wp_wpo_log` VALUES (16, 'Processing item', '2014-11-26 15:04:11'); 
INSERT INTO `wp_wpo_log` VALUES (17, 'Caching images', '2014-11-26 15:04:11'); 
INSERT INTO `wp_wpo_log` VALUES (18, 'Processing item', '2014-11-26 15:04:42'); 
INSERT INTO `wp_wpo_log` VALUES (19, 'Caching images', '2014-11-26 15:04:42'); 
INSERT INTO `wp_wpo_log` VALUES (20, 'Processing item', '2014-11-26 15:05:56'); 
INSERT INTO `wp_wpo_log` VALUES (21, 'Caching images', '2014-11-26 15:05:56'); 
INSERT INTO `wp_wpo_log` VALUES (22, 'Processing item', '2014-11-26 15:06:27'); 
INSERT INTO `wp_wpo_log` VALUES (23, 'Caching images', '2014-11-26 15:06:27'); 
INSERT INTO `wp_wpo_log` VALUES (24, '10 posts added', '2014-11-26 15:07:39'); 
INSERT INTO `wp_wpo_log` VALUES (25, 'Processing campaign 测试title (ID: 1)', '2014-11-26 15:16:01'); 
INSERT INTO `wp_wpo_log` VALUES (26, 'Processing feed 幸福满家园有声博客 (ID: 1)', '2014-11-26 15:16:01'); 
INSERT INTO `wp_wpo_log` VALUES (27, 'No new posts', '2014-11-26 15:16:06'); 
INSERT INTO `wp_wpo_log` VALUES (28, 'Processing feed 俗人理解不了的幸福 (ID: 2)', '2014-11-26 15:16:06'); 
INSERT INTO `wp_wpo_log` VALUES (29, 'Campaign fetch limit reached at 10', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (30, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (31, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (32, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (33, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (34, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (35, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (36, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (37, 'Processing item', '2014-11-26 15:16:12'); 
INSERT INTO `wp_wpo_log` VALUES (38, 'Processing item', '2014-11-26 15:16:13'); 
INSERT INTO `wp_wpo_log` VALUES (39, 'Processing item', '2014-11-26 15:16:13'); 
INSERT INTO `wp_wpo_log` VALUES (40, '10 posts added', '2014-11-26 15:16:13'); 
INSERT INTO `wp_wpo_log` VALUES (41, 'Processing campaign joyfulThings (ID: 2)', '2014-11-27 12:54:20'); 
INSERT INTO `wp_wpo_log` VALUES (42, 'Processing feed Mostpopular on Huffington Post (ID: 3)', '2014-11-27 12:54:20'); 
INSERT INTO `wp_wpo_log` VALUES (43, 'Campaign fetch limit reached at 10', '2014-11-27 12:54:26'); 
INSERT INTO `wp_wpo_log` VALUES (44, 'Processing item', '2014-11-27 12:54:26'); 
INSERT INTO `wp_wpo_log` VALUES (45, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (46, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (47, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (48, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (49, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (50, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (51, 'Processing item', '2014-11-27 12:54:27'); 
INSERT INTO `wp_wpo_log` VALUES (52, 'Processing item', '2014-11-27 12:54:28'); 
INSERT INTO `wp_wpo_log` VALUES (53, 'Processing item', '2014-11-27 12:54:28'); 
INSERT INTO `wp_wpo_log` VALUES (54, '10 posts added', '2014-11-27 12:54:28'); 
INSERT INTO `wp_wpo_log` VALUES (55, 'Processing campaign joyfulThings (ID: 2)', '2014-11-27 13:12:23'); 
INSERT INTO `wp_wpo_log` VALUES (56, 'Processing feed Make Me Joyful (ID: 4)', '2014-11-27 13:12:23'); 
INSERT INTO `wp_wpo_log` VALUES (57, 'Processing campaign joyfulThings (ID: 2)', '2014-11-27 13:22:46'); 
INSERT INTO `wp_wpo_log` VALUES (58, 'Processing feed Daily Hope (ID: 5)', '2014-11-27 13:22:46'); 
INSERT INTO `wp_wpo_log` VALUES (59, 'Campaign fetch limit reached at 10', '2014-11-27 13:22:58'); 
INSERT INTO `wp_wpo_log` VALUES (60, 'Processing item', '2014-11-27 13:22:58'); 
INSERT INTO `wp_wpo_log` VALUES (61, 'Processing item', '2014-11-27 13:22:59'); 
INSERT INTO `wp_wpo_log` VALUES (62, 'Processing item', '2014-11-27 13:22:59'); 
INSERT INTO `wp_wpo_log` VALUES (63, 'Processing item', '2014-11-27 13:22:59'); 
INSERT INTO `wp_wpo_log` VALUES (64, 'Processing item', '2014-11-27 13:22:59'); 
INSERT INTO `wp_wpo_log` VALUES (65, 'Processing item', '2014-11-27 13:22:59'); 
INSERT INTO `wp_wpo_log` VALUES (66, 'Processing item', '2014-11-27 13:22:59'); 
INSERT INTO `wp_wpo_log` VALUES (67, 'Processing item', '2014-11-27 13:23:00'); 
INSERT INTO `wp_wpo_log` VALUES (68, 'Processing item', '2014-11-27 13:23:00'); 
INSERT INTO `wp_wpo_log` VALUES (69, 'Processing item', '2014-11-27 13:23:00'); 
INSERT INTO `wp_wpo_log` VALUES (70, '10 posts added', '2014-11-27 13:23:00'); 
INSERT INTO `wp_wpo_log` VALUES (71, 'Processing feed Make Me Joyful (ID: 4)', '2014-11-27 13:23:00'); 
INSERT INTO `wp_wpo_log` VALUES (72, 'Processing campaign joyfulThings (ID: 2)', '2014-11-27 13:40:39'); 
INSERT INTO `wp_wpo_log` VALUES (73, 'Processing feed Daily Hope (ID: 5)', '2014-11-27 13:40:39'); 
INSERT INTO `wp_wpo_log` VALUES (74, 'No new posts', '2014-11-27 13:40:54'); 
INSERT INTO `wp_wpo_log` VALUES (75, 'Processing feed Make Me Joyful (ID: 4)', '2014-11-27 13:40:54'); 
INSERT INTO `wp_wpo_log` VALUES (76, 'Campaign fetch limit reached at 10', '2014-11-27 13:41:01'); 
INSERT INTO `wp_wpo_log` VALUES (77, 'Processing item', '2014-11-27 13:41:01'); 
INSERT INTO `wp_wpo_log` VALUES (78, 'Caching images', '2014-11-27 13:41:01'); 
INSERT INTO `wp_wpo_log` VALUES (79, 'Processing item', '2014-11-27 13:41:14'); 
INSERT INTO `wp_wpo_log` VALUES (80, 'Caching images', '2014-11-27 13:41:14'); 
INSERT INTO `wp_wpo_log` VALUES (81, 'Processing item', '2014-11-27 13:41:29'); 
INSERT INTO `wp_wpo_log` VALUES (82, 'Caching images', '2014-11-27 13:41:29'); 
INSERT INTO `wp_wpo_log` VALUES (83, 'Processing item', '2014-11-27 13:41:42'); 
INSERT INTO `wp_wpo_log` VALUES (84, 'Caching images', '2014-11-27 13:41:42'); 
INSERT INTO `wp_wpo_log` VALUES (85, 'Processing item', '2014-11-27 13:42:09'); 
INSERT INTO `wp_wpo_log` VALUES (86, 'Caching images', '2014-11-27 13:42:09'); 
INSERT INTO `wp_wpo_log` VALUES (87, 'Processing item', '2014-11-27 13:42:31'); 
INSERT INTO `wp_wpo_log` VALUES (88, 'Caching images', '2014-11-27 13:42:31'); 
INSERT INTO `wp_wpo_log` VALUES (89, 'Processing item', '2014-11-27 13:42:48'); 
INSERT INTO `wp_wpo_log` VALUES (90, 'Caching images', '2014-11-27 13:42:48'); 
INSERT INTO `wp_wpo_log` VALUES (91, 'Processing item', '2014-11-27 13:43:14'); 
INSERT INTO `wp_wpo_log` VALUES (92, 'Caching images', '2014-11-27 13:43:14'); 
INSERT INTO `wp_wpo_log` VALUES (93, 'Processing item', '2014-11-27 13:43:34'); 
INSERT INTO `wp_wpo_log` VALUES (94, 'Caching images', '2014-11-27 13:43:34'); 
INSERT INTO `wp_wpo_log` VALUES (95, 'Processing item', '2014-11-27 13:43:48'); 
INSERT INTO `wp_wpo_log` VALUES (96, 'Caching images', '2014-11-27 13:43:48'); 
INSERT INTO `wp_wpo_log` VALUES (97, '10 posts added', '2014-11-27 13:44:19'); 
INSERT INTO `wp_wpo_log` VALUES (98, 'Processing campaign 好的博客 (ID: 1)', '2014-11-28 14:00:08'); 
INSERT INTO `wp_wpo_log` VALUES (99, 'Processing feed 我爱水煮鱼 (ID: 6)', '2014-11-28 14:00:08'); 
INSERT INTO `wp_wpo_log` VALUES (100, 'Campaign fetch limit reached at 2', '2014-11-28 14:00:18'); 
INSERT INTO `wp_wpo_log` VALUES (101, 'Processing item', '2014-11-28 14:00:18'); 
INSERT INTO `wp_wpo_log` VALUES (102, 'Caching images', '2014-11-28 14:00:18'); 
INSERT INTO `wp_wpo_log` VALUES (103, 'Processing item', '2014-11-28 14:01:06'); 
INSERT INTO `wp_wpo_log` VALUES (104, 'Caching images', '2014-11-28 14:01:06'); 
INSERT INTO `wp_wpo_log` VALUES (105, '2 posts added', '2014-11-28 14:02:26'); 
INSERT INTO `wp_wpo_log` VALUES (106, 'Processing campaign 好的博客 (ID: 1)', '2014-11-28 14:10:17'); 
INSERT INTO `wp_wpo_log` VALUES (107, 'Processing feed 我爱水煮鱼 (ID: 6)', '2014-11-28 14:10:17'); 
INSERT INTO `wp_wpo_log` VALUES (108, 'Processing campaign 好的博客 (ID: 1)', '2014-11-28 14:11:13'); 
INSERT INTO `wp_wpo_log` VALUES (109, 'Processing feed 我爱水煮鱼 (ID: 6)', '2014-11-28 14:11:13'); 
INSERT INTO `wp_wpo_log` VALUES (110, 'No new posts', '2014-11-28 14:11:25'); 
INSERT INTO `wp_wpo_log` VALUES (111, 'Processing campaign 好的博客 (ID: 1)', '2014-11-28 14:12:40'); 
INSERT INTO `wp_wpo_log` VALUES (112, 'Processing feed 我爱水煮鱼 (ID: 6)', '2014-11-28 14:12:40'); 
INSERT INTO `wp_wpo_log` VALUES (113, 'Campaign fetch limit reached at 4', '2014-11-28 14:12:53'); 
INSERT INTO `wp_wpo_log` VALUES (114, 'Processing item', '2014-11-28 14:12:53'); 
INSERT INTO `wp_wpo_log` VALUES (115, 'Caching images', '2014-11-28 14:12:53'); 
INSERT INTO `wp_wpo_log` VALUES (116, 'Processing item', '2014-11-28 14:13:59'); 
INSERT INTO `wp_wpo_log` VALUES (117, 'Caching images', '2014-11-28 14:14:00'); 
INSERT INTO `wp_wpo_log` VALUES (118, 'Processing item', '2014-11-28 14:14:54'); 
INSERT INTO `wp_wpo_log` VALUES (119, 'Caching images', '2014-11-28 14:14:54'); 
INSERT INTO `wp_wpo_log` VALUES (120, 'Processing item', '2014-11-28 14:16:48'); 
INSERT INTO `wp_wpo_log` VALUES (121, 'Caching images', '2014-11-28 14:16:48'); 
INSERT INTO `wp_wpo_log` VALUES (122, '4 posts added', '2014-11-28 14:18:16');
#
#  `wp_wpo_log` 数据表的内容结束
# --------------------------------------------------------

# --------------------------------------------------------
# 数据表：`wp_wprobot`
# --------------------------------------------------------


#
# 删除任何存在的 `wp_wprobot` 数据表
#

DROP TABLE IF EXISTS `wp_wprobot`;


#
#  `wp_wprobot` 数据表的结构
#

CREATE TABLE `wp_wprobot` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `postspan` varchar(255) NOT NULL DEFAULT '1days',
  `keyword` varchar(255) NOT NULL,
  `ebaycat` varchar(255) NOT NULL DEFAULT 'all',
  `yapcat` varchar(255) NOT NULL DEFAULT '',
  `amazoncat` varchar(255) NOT NULL DEFAULT 'all',
  `amazonnode` bigint(20) NOT NULL DEFAULT '0',
  `amazonnodename` varchar(255) NOT NULL,
  `category` bigint(20) NOT NULL DEFAULT '-1',
  `num_total` bigint(20) NOT NULL DEFAULT '0',
  `num_yahoo` bigint(20) NOT NULL DEFAULT '0',
  `num_ebay` bigint(20) NOT NULL DEFAULT '0',
  `num_amazon` bigint(20) NOT NULL DEFAULT '0',
  `num_clickbank` bigint(20) NOT NULL DEFAULT '0',
  `num_youtube` bigint(20) NOT NULL DEFAULT '0',
  `num_article` bigint(20) NOT NULL DEFAULT '0',
  `num_flickr` bigint(20) NOT NULL DEFAULT '0',
  `num_yn` bigint(20) NOT NULL DEFAULT '0',
  `num_rss` bigint(20) NOT NULL DEFAULT '0',
  `rssfeed` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

#
#  `wp_wprobot` 数据表的内容
#

#
#  `wp_wprobot` 数据表的内容结束
# --------------------------------------------------------

