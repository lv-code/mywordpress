<?php
/**
 *
 */
function it_options_init() {
	register_setting( IT_SETTINGS, IT_SETTINGS );
	
	# Add default options if they don't exist
	add_option( IT_SETTINGS, it_options( 'settings', 'default' ) );
	add_option( IT_INTERNAL_SETTINGS, it_options( 'internal', 'default' ) );
	# delete_option(IT_SETTINGS);
	# delete_option(IT_INTERNAL_SETTINGS);
	
	if( it_ajax_request() ) {
		# Ajax option save
		if( isset( $_POST['it_option_save'] ) ) {
			it_ajax_option_save();
			
		# Sidebar option save
		} elseif( isset( $_POST['it_sidebar_save'] ) ) {
			it_sidebar_option_save();
			
		} elseif( isset( $_POST['it_sidebar_delete'] ) ) {
			it_sidebar_option_delete();
						
		} elseif( isset( $_POST['action'] ) && $_POST['action'] == 'add-menu-item' ) {
			add_filter( 'nav_menu_description', create_function('','return "";') );
		}
	}
	
	# Option import
	if( ( !it_ajax_request() ) && ( isset( $_POST['it_import_options'] ) ) ) {
		it_import_options( $_POST[IT_SETTINGS]['import_options'] );

	# Reset options
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST[IT_SETTINGS]['reset'] ) ) ) {
		it_load_defaults();
		wp_redirect( admin_url( 'admin.php?page=it-options&reset=true' ) );
		exit;
		
	# load demo settings
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST[IT_SETTINGS]['load_demo'] ) ) ) {
		it_load_demo();
		wp_redirect( admin_url( 'admin.php?page=it-options&demo=true' ) );
		exit;
		
	# Confirm minisites
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST[IT_SETTINGS]['confirm_minisites'] ) ) ) {		
		it_confirm_minisites();
		
	# Confirm taxonomies
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST[IT_SETTINGS]['confirm_taxonomies'] ) ) ) {			
		it_confirm_taxonomies();
		
	# $_POST option save
	} elseif( ( !it_ajax_request() ) && ( isset( $_POST['it_admin_wpnonce'] ) ) ) {
		unset(  $_POST[IT_SETTINGS]['export_options'] );
	}
	
}

/**
 *
 */
function it_sidebar_option_delete() {
	check_ajax_referer( IT_SETTINGS . '_wpnonce', 'it_admin_wpnonce' );
	
	$data = $_POST;
	
	$saved_sidebars = get_option( IT_SIDEBARS );
	
	$msg = array( 'success' => false, 'sidebar_id' => $data['sidebar_id'], 'message' => sprintf( __( 'Error: Sidebar &quot;%1$s&quot; not deleted, please try again.', IT_TEXTDOMAIN ), $data['it_sidebar_delete'] ) );
	
	unset( $saved_sidebars[$data['sidebar_id']] );
	
	if( update_option( IT_SIDEBARS, $saved_sidebars ) ) {
		$msg = array( 'success' => 'deleted_sidebar', 'sidebar_id' => $data['sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Deleted.', IT_TEXTDOMAIN ), $data['it_sidebar_delete'] ) );
	}
	
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 *
 */
function it_sidebar_option_save() {
	check_ajax_referer( IT_SETTINGS . '_wpnonce', 'it_admin_wpnonce' );
	
	$data = $_POST;
	
	$saved_sidebars = get_option( IT_SIDEBARS );
	
	$msg = array( 'success' => false, 'sidebar' => $data['custom_sidebars'], 'message' => sprintf( __( 'Error: Sidebar &quot;%1$s&quot; not saved, please try again.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
	
	if( empty( $saved_sidebars ) ) {
		$update_sidebar[$data['it_sidebar_id']] = $data['custom_sidebars'];
		
		if( update_option( IT_SIDEBARS, $update_sidebar ) )
			$msg = array( 'success' => 'saved_sidebar', 'sidebar' => $data['custom_sidebars'], 'sidebar_id' => $data['it_sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Added.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
		
	} elseif( is_array( $saved_sidebars ) ) {
		
		if( in_array( $data['custom_sidebars'], $saved_sidebars ) ) {
			$msg = array( 'success' => false, 'sidebar' => $data['custom_sidebars'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Already Exists.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
			
		} elseif( !in_array( $data['custom_sidebars'], $saved_sidebars ) ) {
			$sidebar[$data['it_sidebar_id']] = $data['custom_sidebars'];
			$update_sidebar = $saved_sidebars + $sidebar;
			
			if( update_option( IT_SIDEBARS, $update_sidebar ) )
				$msg = array( 'success' => 'saved_sidebar', 'sidebar' => $data['custom_sidebars'], 'sidebar_id' => $data['it_sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Added.', IT_TEXTDOMAIN ), $data['custom_sidebars'] ) );
			
		}
	}
		
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 *
 */
function it_ajax_option_save() {
	check_ajax_referer( IT_SETTINGS . '_wpnonce', 'it_admin_wpnonce' );
	
	$data = it_prep_data($_POST);
	
	$count = count($_POST, COUNT_RECURSIVE);
	
	unset( $data['_wp_http_referer'], $data['_wpnonce'], $data['action'], $data['it_full_submit'], $data[IT_SETTINGS]['export_options'] );
	unset( $data['it_admin_wpnonce'], $data['it_option_save'], $data['option_page'] );
	
	$msg = array( 'success' => false, 'message' => __( 'Error: Options not saved, please try again.', IT_TEXTDOMAIN ) );
	
	if( get_option( IT_SETTINGS ) != $data[IT_SETTINGS] ) {
		
		if( update_option( IT_SETTINGS, $data[IT_SETTINGS] ) )
			$msg = array( 'success' => 'options_saved', 'message' => $count . __( ' Total Options Saved.', IT_TEXTDOMAIN ) );
			
	} else {
		$msg = array( 'success' => true, 'message' => $count . __( ' Total Options Saved.', IT_TEXTDOMAIN ) );
	}
	
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

function it_confirm_minisites() {
	$data = it_prep_data($_POST);
	
	#die(var_export($data));
	
	flush_rewrite_rules();
	
	unset( $data['_wp_http_referer'], $data['_wpnonce'], $data['action'], $data['it_full_submit'], $data[IT_SETTINGS]['export_options'] );
	unset( $data['it_admin_wpnonce'], $data['it_option_save'], $data['option_page'] );
	
	$msg = array( 'success' => false, 'message' => __( 'Error: Options not saved, please try again.', IT_TEXTDOMAIN ) );
	
	if( get_option( IT_SETTINGS ) != $data[IT_SETTINGS] ) {
		
		if( update_option( IT_SETTINGS, $data[IT_SETTINGS] ) )
			$msg = array( 'success' => 'options_saved', 'message' => __( 'Options Saved.', IT_TEXTDOMAIN ) );
			
	} else {
		$msg = array( 'success' => true, 'message' => __( 'Options Saved.', IT_TEXTDOMAIN ) );
	}
	wp_redirect( admin_url( 'admin.php?page=it-options&confirm_minisites=true' ) );
	exit;	
}

function it_confirm_taxonomies() {
	$data = it_prep_data($_POST);
	
	#die(var_export($data));
	
	flush_rewrite_rules();
	
	unset( $data['_wp_http_referer'], $data['_wpnonce'], $data['action'], $data['it_full_submit'], $data[IT_SETTINGS]['export_options'] );
	unset( $data['it_admin_wpnonce'], $data['it_option_save'], $data['option_page'] );
	
	$msg = array( 'success' => false, 'message' => __( 'Error: Options not saved, please try again.', IT_TEXTDOMAIN ) );
	
	if( get_option( IT_SETTINGS ) != $data[IT_SETTINGS] ) {
		
		if( update_option( IT_SETTINGS, $data[IT_SETTINGS] ) )
			$msg = array( 'success' => 'options_saved', 'message' => __( 'Options Saved.', IT_TEXTDOMAIN ) );
			
	} else {
		$msg = array( 'success' => true, 'message' => __( 'Options Saved.', IT_TEXTDOMAIN ) );
	}
	wp_redirect( admin_url( 'admin.php?page=it-options&confirm_taxonomies=true' ) );
	exit;	
}

/**
 * 
 */
function it_shortcode_generator() {

	$shortcodes = it_shortcodes();
	
	$options = array();
	
	foreach( $shortcodes as $shortcode ) {
		$shortcode = str_replace( '.php', '',$shortcode );
		$shortcode = preg_replace( '/[0-9-]/', '', $shortcode );
		
		if( $shortcode[0] != '_' ) {
			$class = 'it' . ucwords( $shortcode );
			$options[] = call_user_func( array( &$class, '_options'), $class );
		}
	}
	
	return $options;
}

/**
 *
 */
function it_check_wp_version(){
	global $wp_version;
	
	$check_WP = '3.0';
	$is_ok = version_compare($wp_version, $check_WP, '>=');
	
	if ( ($is_ok == FALSE) ) {
		return false;
	}
	
	return true;
}

/**
 * 
 */
function it_sociable_option() {
	$sociables = array(
		'twitter' => 'Twitter',
		'facebook' => 'Facebook',
		'googleplus' => 'Google+',
		'pinterest' => 'Pinterest',
		'vimeo' => 'Vimeo',
		'tumblr' => 'Tumblr',
		'instagram' => 'Instagram',
		'flickr' => 'Flickr',
		'youtube' => 'Youtube',
		'linkedin' => 'LinkedIn',
		'stumbleupon' => 'StumbleUpon',
		'skype' => 'Skype'
		);
	
	return array( 'sociables' => $sociables );
}

/**
 *
 */
function it_signoffs() {
	$signoff = it_get_setting('signoff');
	if ( isset($signoff['keys']) && $signoff['keys'] != '#' ) {
		$signoff_keys = explode(',',$signoff['keys']);
		foreach ($signoff_keys as $skey) {
			if ( $skey != '#') {
				$signoff_name = ( !empty( $signoff[$skey]['name'] ) ) ? $signoff[$skey]['name'] : '#';	
				$options[$signoff_name] = $signoff_name;	
			}
		}
	}
	return $options;
}

/**
 * 
 */
function it_tinymce_init_size() {
	if( isset( $_GET['page'] ) ) {
		if( $_GET['page'] == 'it-options' ) {
			$tinymce = 'TinyMCE_' . IT_SETTINGS . '_content_size';
			if( !isset( $_COOKIE[$tinymce] ) )
				setcookie($tinymce, 'cw=577&ch=251');
		}
	}
}

/**
 *
 */
function it_import_options( $import ) {
	
	$imported_options = it_decode( $import, $serialize = true );
	
	if( is_array( $imported_options ) ) {
		
		if( array_key_exists( 'it_options_export', $imported_options ) ) {
			if( get_option( IT_SETTINGS ) != $imported_options ) {

				if( update_option( IT_SETTINGS, $imported_options ) )
					wp_redirect( admin_url( 'admin.php?page=it-options&import=true' ) );
				else
					wp_redirect( admin_url( 'admin.php?page=it-options&import=false' ) );

			} else {
				wp_redirect( admin_url( 'admin.php?page=it-options&import=true' ) );
			}
			
		} else {
			wp_redirect( admin_url( 'admin.php?page=it-options&import=false' ) );
		}
		
	} else {
		wp_redirect( admin_url( 'admin.php?page=it-options&import=false' ) );
	}
	
	exit;
}

/**
 *
 */
function it_load_defaults() {
	update_option( IT_SETTINGS, it_options( 'settings', 'default' ) );
	update_option( IT_WIDGETS, it_options( 'widgets', 'default' ) );
	update_option( IT_MODS, it_options( 'mods', 'default' ) );
	delete_option( IT_SIDEBARS );	
}

/**
 *
 */
function it_load_demo() {
	#load the theme options
	update_option( IT_SETTINGS, it_options( 'settings', 'demo' ) );
	#load the sidebar_widgets array
	update_option( IT_WIDGETS, it_options( 'widgets', 'demo' ) );
	#load the theme_mods array
	update_option( IT_MODS, it_options( 'mods', 'demo' ) );
	
	#load each individual widget
	$options = it_decode( it_options( 'widget', 'demo' ), $serialize = true );
	foreach ($options as $option_name => $option_value) {
		update_option($option_name, $option_value);
	}
}

/**
 *
 */
function it_options( $type, $state ) {	

	$options = '';
	
	switch($type) {
		case "settings":
		
			if($state=='demo') {
				
				#demo settings code
				$options = '7V37k9s2kv79qu5_4JarNk7daIZPkbJra9dxHG_uEseXmd3U1uVOBZGQRJsitSQ1YyXl__1ASgRBvAjqudnFPaqcERpodH9oPNkfeOFawYtfixeW9-L3f99k5cskW2QzkE-juACzBO7--BK8sF78Gr8wXxYv3H3BMt80v35G8vb-z0hunYDttKpn_zNXBolMGhFYhHm8LuMsHdpsQGg93eQJrjxw9r8sy3L94u7u6enpNk6jTVHmMUjKJVzB4jbMVndFCcHq7mk9CrO0hGl5t1knGYiKO9u0nDtzcldVPSog-jkC-fZ2nS7aHphk809xVC7xb037tuu35S2y_BLGi2XJCFiWLRBA_Zsuo7aL4_N08U_2p24v3VaJOJ0ypvZPaupu003_5-AxRlKddhvjt6UbDBdlHH7cXlbTgN826TD_pA5j3ORzNOBj0nI9ueIUNJuxPTZZ6KfwabrO4Tz-JHFMQBROwAwm0-wR5nkcQbbMuzc_Ga9-fPj29Xdv7o2HH75-9TcWiVU9ZbyCa5jHWcT0DyStzxubo5iUbdouWU3ZAimB4t0o7_QYx6Y5BOUmh9E0XoEFnBbxL5BpziHt0qgIUpBskUmLaZgR3WRt0_wlRDjIVtOwKMSFJ92yHyRFWzjAsI6sK5hupuV2DZmovIIL0Pra5cmBHHUlgdN0s1Jwc0e09rdECLe3makJNGgMsyTLpyAM0QiRFHc6xWfZJ1hMrYHl7YHlnYHlXQV8zFEsqA0kcbrdKdy4YQlBBHNlsX3Q6RebkFKzLNoqeBmX7Q4lsZdrARTGFrBUQTtZvKcJLJJXMi0kmlmkdo2gtM0ZROlGUNhh_l5m6xGysaB8i4ZmQO2Hn0gbjxFowpZAYMx0dhV_Epb2GY_DT2GyKeJHKJAImPrrKU1QesL8HUEwReBlu7VzlSl2KlXSUohWuyFYTUjVurUTIT1yrLLY3EnSM0vjM8Zqu-IhKPuH1K5oCRYS_Rln7KdWBC7JULcFUrOsRFMK20c0Hd8br3949_Dm3QNru7YW1C24yPKtQuRrhcgO4sVJ4LPDeg8IpR6aXBmqf6x2jd_gCsRJ3yQ0wQMzXFYdseTxgC5u90YEWsJhfllnRTlKMsIUtIyrMG5pGa9n5NLlx71jl5bw1a0aqBedKMyg2FnmkMKSENKsLdfV0rAHAp2ydq_VOsVVnN8RYGeQModpFBPbhU75Pq93Co8VYNUR8BUtGCiWm_TP6TuPmKoFLYW4UJcctovAa-ladvBWAmN8Uy6rlW60QttvmA45H8HBcF8HXK3L7eCzHZeqpHK3dE9jdQXyLIHSTRqebfYCWY5WngyG0xgt9cEKsu1EcY4GD5p9iFEoBidHzO4ZABwRlUHJEXN7Qz9HyOtZnHJE-gMzR8jvWRdyRIL-UMORmiis_AmnmsOKWwpnRHg0UkN6jIN3FBOb3XaD0cgpLHhsWoZc7zQ_Oo5EObTfnhEjoTGkI9ErRru3_BEkjNBYcrpR5iAt4mq3yBgC_RKRC0OXNaB0qdRuLhuBRxQss2lRbjlRgVzaWWMiuoYgVzG5RYn0Wdxu20VjkOpL0_7DD-8NAoOW3xVSPImyXGqA9J50-LRAsZl1ZRpHPvz523vjpzdv_ov1MRZWVdOjBQUgHHPOcKqgqeCmSae8fJtjd8pSuojXb1UcRl0uCYzhnn336uHN_QM-ZeQdtyPh3n1dt60a1cpTqkmuDNAQW0AFHLSFp6tsFidQ4cBl15V4FZfynSdPQO6YMSmwXxP0tMEVkbaCjxQREJPeRTZVun-bRQmozOmUiMomixLpW21TxcfKxyN7AV_ZnIFyyYnCYN67yFQvqrTuRh44eN1dyQ5dd9sOKY0WFdkKgSxCFawgWp1GnEgJFkUT9WJiWYYPW5iaulEcx-q_ZRtjVXXFAEmRGUn8sVXVDkSVzeMETflF53C-sZ7LzsOMPE9uzAABbT5itERodw3jKsRZ6B9udYGMr2bIBXoz3r_PHkm74Oki2bAb0lW3bIP53b4nYhS1GEX3cYUt2rj4c_zClqqNsffXKqYbb9FvPcrjeF7PAouOwHl64Eh70LT5FnQPzrnKN4UXVOHzKO7KTd8Y8l2Wjn6ECApPcuWboZNmad4tfg712z89w-NA3BkmqHF7IDybECluHqR40_ZHuC0Y61k39o1z4948a8vj-8N4kWbzOe6u0wx7W9hvHGrqcW_s3GjcdyrqzGYleYXn4PB9DyPjMa5uioFRZEkSh3G5QUtSI8vD2IClsc5hiXZpt8b9plhXq9WigAaqr7r5gijo3xh_34CVgSQeYYrMWcaFsV4CJJWDG6MA6ximRgLCTWGsQAKLDYgAirqLTYJ-RohqGjBKmKA53YhiVBtEgwTVl8QlahdpiPac6P-MNJ4tb4w1-g9QiyabsEQiKGQayDbljTEHmzCeoT8hcYC6fGt8n-WzGFW1jEPUolHFVwOUTYWrqsdFV_m9ygVcoZX8rfEtqmYBcwPVXEvgPpR5XJTx3zfwVoZcWx25ImdRBUU4w4f7JMLw-Va0v2skFopNe79P0O_GMofzP_zceTxRP5eYZzksytsUlnd_rIp8i19TPNSvKfYiv1_sKopXC6PIQ6om4TOMeQIes1z8DsO7K8BqncARiKqXGPta0dRdNi2AqPnjXaPDHaj_xZxjo2k8y0rp1sZpy85A-HGRZ5s0UjnKjqbFcjOfq5_4jVtJ-aKiPbirDh7CHNkuZbdMHq-7KBQUkC07YcrWmwUkYBHxxfxtwWPkmGYvROq3Os2fkUDz991jnOYH2zNVMdUYztaGO8xwjjbcYYZzteEOM5zXv3duio7Vi_rqRQP1ohPVU7gqdpsK89puAhSdu0XsUVWYrbf1zn9awk-lypOxHEZxWfQVb4_hYTTb5ClSqru-bXSiwXb33798YF_15EXR83C1mW_Lp7isTLApYM7dSMP0EZQZa7p1feqPRlCnIXxksB8fuFQ9KHZ13bFmXWTZIoFrtODt1maxz1d3dVTVsYceRDXrPJvHCVS0QuX-zQyyVmgQ-B7kj-8RTArOVQsI4SzLPnaackjNi73qTUnCFmxXcXW713pFWLmZOb5LBG9HG-FimT1Nq_8qlM-HPaaOMm_PCNXvfbs6dJbZ_ZUwVpjVF7PT7nMo8cukBs6793jdh7Cu150YwgQURRM594Kj6soiiVOI4ys1e1S-3Jet3UjNGo1YBEow2ikxiiMct33fslzb8sa2Ezje2A2ISebhCcKyMGZb409UpW0U__d_q_69-3ah-u_fzTdp_eLyeXRT3MTRl78-gtz4UNzMPxR_iG5R62-SeoFcfLV9AIt3CNrPiy__x_zfm_Uf7v5vN6puSzQ8n0e3SRaCqqov__jzF9UvP3_xYveP4ucvXsbz578j6_tq-230HLX35a91QyjKgRLuf0MtvPxQ3KJux1H1j2rWXP_HvqdVTEhAiSbf1S1px_0DytsPzbz7EnXhdo02zmn5DnkRzbJobJZf1dP2810Pv3z5-fPzKAs3Vas3e7mdcfb_cUN59wlX_-VubmxNiUzLvDJF2_-P-TSO2EHv2WPLtzzvT-_MgDOt7AQFt1gT9sQ7C-Pu8wiXe9JZfZDAXjDs-sYE7t2L7f6TIYT2j23cCtiIK4E7E5eW1aNG4Vadcwra6dIET3JFCRY55znQQZ2y_W6ncPW8QKzaE0fak4CKYyfyztBZRbUzrrQzeG3Vzq-n6Y9H96eq-nbXSt0dy_TtwLMn7mTiWu7Ysse26d5V1wnF4D560j56-DR9BbPT9I4pparpWGmQ4KXViQbJoJWbalf8y4ewg80eSHUdd2L7aVR1OV-H7eqvjb5eZmVW3D2hTWIOR4e6YKLkgv0K-MousEylqFo1hrZV6fnmvKaF2g_o_9cg3R4aXC35PN4-ICrReiGBm3WWXtsNtlKsLD6SXy5cQ9Xey7F_2HAjuLXAUbi5HvNuxjf-TXAzubHMG8u6sWzyPqN9J1u_1GU-PxW_uYlX1b3RNKu_gS5UvnCtdnMRXGVTNBbwSwL1bWGONhfVA7T6mc_Q58BB-2ose4LRtH5QUH03w14do41_tCHfnGKvg09Zmq1iWEw7F_4AeezXNrZY9K_iy9bGNG9hmkP5jWtTdNEp2uocrwDxeo2-L65s80O7DIvLh11f9hKonl-JxXPxvqc6YqfSPLGYEtq-Ix4uEnsffhcGGAY_xQFzOD3UkHgHtvPStKtN48TqM-juJX9XbESKfSa-6rdp7ztC7zciX-9fAcv1Dqg3w6fw7KweMof4UqDN0J6KPTrMODjI7J3KqCX2a1dyREmSrnXUXYun5O_fv3pl_FhHLsXXOGilAHJS4EoeFit0SJ_Fju6ITZVM5XedzVFQ7O6u7IiRJR3-jHa4fdpnM6I53O9M4bzZOoIliJOB85Dd--btO5gucO6FHe4CDLuv6zb3oHOG1SUDAH5gyxdYoWan3Idi046ENAiLu46HxvskK437bZqti7g4zgTSOqVjAd-NIMFpIRJkTYKBMeVJSoOYxDSNzPvdigit84z76jFTdqx9eiuWGinoLtSqdAGFQJpjqQm2lEhcGgIs1RAweHDTC12kex6HU-ptafsKH-ZVFgmw4MxlYY5ifB4DWvmxND70j-lXYcn7HvOpm3qFMgQzf73ea7fHiXueZlVCDgi5k5Qk5HQkDlz3uUR0uJgtj2hUZkmXCFgKdvTIMHXcEqtxyeusOvaAFzPkce3KbNm-V-zWLDZnY7ZpV4S0qKtu0UlnyX3JgX5syzKrTjo7FbXhjvswpaVOtTxU69cBT6DbF5dPII-YFaIlXyKOxXN2s0X4Chalkc2N6hUSEwa6h632i1M9dao7MyrzbL3sprMbEw2Teea8szRN5y-bEK0_LdsPTZACwVkUGNWt8PPN7UzQVWNinVGNrjV2o9_Hg_9VVX4_8jWsNKwOhFU7LcbFV9XHPsTBhnT9pYC5b2rtDAKpF8PcrtxVMLcrd0XM7cpdHXOkGicNZRpWGlbHhDJnQChz8FdraPq8Lzdpyjs-7YLu1J6vn5JW7SrhLjhX6-rQO7nPsQ6D0eeeV5OTxDWNMY0xZYypBjl3QJBzSQC-iqIY7cgfYQ8CT93rFViksIxDJQD6Z2p8AP7MM6kwGH7OWRU5SYTTANMAUwOYanjzBoS3xsdvorjM8p-_KIzXyywO4YX3DmEOftlaSuhzz9H0gK2Df472B-POPJ8WJ4lqGlcaV1JcqQazMR3MfCHonGbh_yZ9jPMsrT6sAkmyNeZ5DNMI_aO9du_B4anNkEAwV0Khc4aGB4BwfIbmh2IwmJxNCdoSODssAUDRA9ahIVCjUaNxGBr5AZHFIxkeffXwiN8u3defRhuPMTDewXKeEFRE_C8PTn7x86iEvpNf9DwOwJ578sYHI88_kwqXjIIadBp0Jwt2wYBg19TzAEE--gDzjzDvmWVP7fknUH13fo2tR93yFbcedftX33oQWlw04mnkaeQJkXdI2JsMCHuNo99WOU2qRC7QqIUvvMN4ilN4lR1G1fAVdxhV81ffYbRKXDTuaehp6ImhNyTw4SfGpnrkw8m3qhy_eVongwKJkUO03y4ufey8SLIZSK7yFGrX9BWfQu0UuPpTKFKNS4ZBjUONQ1UcHhQTrQExsZlbvwGrONkaYL3Os0cYGfM4WV36oTssShhd56F73fQ1H7rXClz_oTuhxkVDooahhqEaDA-KiPaAiNj89SEOP1YJS189gjipsvkYP6RV5tQeOJ56z1Du1FDC4_g8bQ8A5OQ8GgxGpH1OPS4aGTUcNRyHwfGgCOkMiJCNX-8_xmvjKcs_GmVmFBAawFhVySEgvPDz-0qHdQJCeJXn97j1Kz6_xzpc_fk9pclFY6UGpgbmocA85NrlGTfD1bAMXB0AChMxUFARJphgPSqmAeVZXZV8zOpP42l10we5NDVZkySTk8JIicehSQZKpyBSvi6oKWLFuJncVS2MdrV3ceuTKtTMNbQSmAXVMdmHLrXYjthGJGeZtkCu6vEyYjrtnKHT9BCxW-JotP7YTkUeYAnLXY4g126sqMcR5dtOTZZvP_koYaztnsraTcZDLsyczkBllPDPpATtdmtMBxdalYl5JlV4k0bAhi9GH-es-jAGwouaxZ7VRsC4-8y0Tcd0uYI7KmVacHyajnh3s8Uo3Ybu7Yc1x5So-XWGuhmzUMe5o2FadugkW9EcriFgRmNT9-7X0ZY960OioCxBuKzePdPimK0n_kSSsE5wEqrKzCAMOaLY2mHo-wR9CW54JzzLPsFiagmlPdeaW65c2hZKj230v2O5tCPRfALHllzaFUpPnMDybfb7wXmOwMH2mMv7TgkJO0rTv1NyjggWDYW4SNAVCYIcBfOETDnYFfSYYCAkkackxyIMdrnkKSlfpGiZV_S5ZJjoCgai5lZdyHelJiJH0Az2Ld_Vzutm_5RHSVj9E6yDc4_nC1jCaFokcVQRp9NrOrNZ1LUcyL_8kmCGg4oLqF38pJhyuiLUIfaMFe7xL44YTRXhSxu6EERbhFY8KUIfVdQkQqRVZB98TFTUGmKcVQwVfOd-JpZUTQ_2XH2iMLyCUUzSx05I0whkm5UMYFcWcoGQk9S0SkwvkMKrQwSBGchHCZyX7I6hrgH3djfrITBA0UrYn5jsAnQ3Wz3WXZ5BhQWojaG1AIMEHWzgssxW1YGrqiTevmQlSKZFmOXKopOOaEXaN0zepPIwK4p5eMpGSwo0G0TIQStYLjNm7Ymn_31m_2nZSfpNdp-sjKsHxvCPbUljnuUGAlmLBpNT3TxOyirYpJuVOgLICpQEfZKbYTpLQFpxF65q1rmBe1ciXu7MNS02s2raHVqPyeOt7u-KxVJFPKLBmi3Aij7EwKPZ4hVxe1kD3u9J8NRYA9Z06d8Uc4SwF8Ms1M82oGZUPKBax00Z1cQp6FnpESVdHYFhfNg8fChkcYWPMMnWsIc5AadHpYpfiXVApM7gzvYnhFU0EA4FhLNZ7YTe5oiPaPGOu51h7j6SQuZKbv4HoYIZs65VpYNhRRlKGOzSZzyXXp1LIqDWMBwdx_0TlQKzwlv0VxTgtsZDvIInYlbg1anErLDYC07LWCnFdsuswJPsD9R270R-Gs4JQW0qk94AnglMnsBhmJBHMFvhYy1kV-M9zOMsOhIl4hqVmGgqB0_XfDEOQpp-T1m5jl3cgXbBl62oRljcfZODNFzGxbFDqKdaqYUa2WInOxfKcsyEORQEwv0h82juDUne9HY71WHfYLRoTwpocuYJTb5xWEDtH-JN7LtYev4jG1aJQQu6aoUYRMkcs2jGPczBehmHxeVNe1jDSqalq1YxbVfmmAUqnnnv0bBKUDhGHuNQZ57LwCdpXmllUdQNVBvBLWcfIltZ8CT7Zw4V9rlNUsbrCxv8-MaVJukVp3qVSZqVO-la_XzEHn6X2IM3PyocLCl8PFq5Go39n7-4Tr44Tcfwz8fyoaGloXUs04d8bad5GTQvg6b70LD67dB9yDdUEuA1a8n_zJJSCXaajEETfgyJbBpgGmCnYfuQn2AMZGToJZ3RjAya8uMYyg8NMA2wI2Kcd2CM-zNECi2z8ipbCM3O8E_G-qFRpVF1BOcHjmZjXjRTyHr6w6aMsiw3mMtizaugWT7Om_VUQ09D77i8Azj6-QdGv9d5VhRG84y8L-u4JljQrB4nuFPVkNOQOyraBQOjXWPqv6QRzOtM-6pzrqZZ0AQfpwh-GoEagScl-sCxcDIsFuJveiv4Ga-RqiBOC-NVEmbLLDH-UmjuBc29cO60fBqDGoMn5v-w2kRpAwOizb7_Nl6DNZjFSVxuL3wQrdkX_nVZQDQQNRDPQQPShkZr4L65aeUnaHxVEXQ9LOOi3rdoBgbNwHChnbPGoMbgiVlA2oBoDwuIOGfZ-00eLkGdrbj-QrP6kt54G89LNGHnUaEpGDQFw-VCpEalRuX5iUHaoOkMXEV6dA4cNIHff_OTZl7QzAtXWE9qNGo0no0HRJ6WQZOBiMhA8P0oZmTgJDI6HclCTWnRttDltLBYLg-OMs1saDucbMQkJ4VE1hLK7jkpeEbwz2QEhttjLODK4CjFJpYNhPweSuITMcfHwfJim4oTn9dcHzwvBCfnkxDAEZ9_7Dk_OMooh-ZDlGFgYTLcHzyV3DOqxJkw8OghOUB4evln14vhApnQXCAcvTBTw7z-H67wLjO6EvxtDo2HJDMcReVB8nHsqTx4pmzmsWy0K8Rm-u7yeUgUKMI8SxI2x3qH1ENmthC4JkmP4XKJPY6twZbW4E6ciQflNTjSGhwnmPihvAZXWsMkmE0CyGbpb4g-OLJ8so-AIvuQNMoQfgQU4QdHVkCkEVCMH7zIK2T9CCjWD4kwyzUSUMQfEsBXfAWjJMvWImlfJs0hHQkoFhCJvUjCC0ZyIusySz4yoelAJO2u-KQ7mBdEAg-ahgSnz2coQngZwjRNiIAmZCygCZE4MakMziOyIJhCOOIcthC_yxaiJERSdZSy5hyKNSTvJKZzvD7aEMmCu0MdMhZQhyjNsGMBfYiSsC-iEBm0tGZpRFTEHUdOJaKkgsulExm0MudQivDAYDIEFawhWEIRGay-R3013mZZlMKCQIjbQycyCBU0pYiSYywZrQg_u7CUEsQXUYscUJfLpRdR2koFLMXIojpHKalzEZxKkvlZnLsTU6Fv1z2p83G_yJK_KU4Rbg_UrSLOUKpuRHy6tffQtKOLmHuAEhsRYiTluM143unPZvY9SDdzEFazQK6o_YoVuRKthEylgzouyUM73GB4H9i4m6tlP5NI43aOOOl-Z4j78ZVnHofQ-BGkiz7smu1gD2FOCFzL90KFDumzQgLiWmyqYqqA8jtHQ_Fgp4RHjDDp82eMz69OM-JRaxtawbF8srJ7mW9qPxzHicCrSoVjZs0tz2afbtYxU1JAHqrt_gwf92sYxvM4BNV51JH0IfJKpeMBw0YuycnJ7eEE6DxReSyzewmwmi9ij7SMqDoViqm1UIZjDRODhJIiDeEOAUozKP8GQW4Q89Sx9Cp99Urh0ghvkTA5AypRrTS6TkXS8mB4VgIRi0sg0lWBPLcAOYfuEZOH0Kr78jDZT23xzW5rf3lqiwMbVqG2mNNVK1BbUDIHL5gbdb_e5PQXBWenWDi6bekIxeSmbO2SodnAf8qIHbwobVaBr7PVGg2qS1v5FM0rMYeE3AZUmEN4kvLpon8R9FeQbODFrHxMqypLtMdOvQpLNFKANKV3QMz9M8ijJ5DDi8fcAxtWiblLumqFmEvJnGzHchzZisU-qyE3Lm6Xb4VZS7jyGVkhc_xXsCiNbG5Ud-CaCUMzYZyIkEDDSsPqkNSP4mWwZsHQLBiaXEXD6rdDriLebyqA7n6zhtWXX_kCauYLzXyxOENc0xDTEDuWXEV8yKPCe7FnPFCaWjXvhSZWGUysogGmAXYUsYr45FUBfq8rAgSEPVhkK_g7TX-h6S9OEdQ0qjSqjohkY_61vvz68W0OYWqs8yzaEJ99aEoLzaZynoQOGncadyegUplgJpUDYt6rwigq9GWp8fBXTWihOVTOHOs03jTejohxwYAYh7_b_KlmrchhERclSEsjQv9apJq9QrNXXDA3tgahBuGpKFQmmEFlwIqvqei7zadNvjWQCitNVqHJKs687tOo06g7Pjmh2VKkDFj_NcB-9QjipM4tHFfpotL64zeQJJqZQjNTXJo4SmNRY_HULClmy5IyYD3YuPWh5iZAcBwts02hySk0OcWlE1prBGoEnoYexWwz_Q9YJ47xU9G4rKfmeZYbqBsGzq-tc6zrHOtXWDRqYGpgXiL5v_gT4X-VxP84JaMw8X8319KYznlPZx8JrJNmu99X34VbwOb7p9VozrQcc8ImwSWT04sELdMWCO6z0jMdd8_RcSaZuyPIk0-rw6a69IQJ_vtlx-Ls_ocJC4zIYpxME8_a3Dt5cngu4NxuRn9GjeBcajCp6X0mlz-tzBm4BZrEcJzIP-Fk8Wc0cs-rEWOkMZ2_vx9mYzprf7_IhJOyn5YS5OvHbmzz9TNGEyfrt7jJ-kVN05n6TV6mflq4TZHvgQgEbNvdNP1CcW_izt25XNyWiLv-JDDl4s5xyrti8UkETRCx2_YmNT8tyM_L71F5-UXpuqiE7R6Vkl-kJZPL36My8ovTg3US-XtULn4RHjnZ8D0qE7-oRSoVvkel4GeiqjAPvkel3xdJsowDHpV-XyTJ0g2M6dz7IofQ2fNpSUthxnRFCfeZFDE6274g274jyLYvHA4rwIuSnVT7tCwnz77bzbMvkuAwM5BJ9hmxngz7dl-GfdEqt5Ne3xGk1-_HqyPIra-OdCaxvvp6ls2q3yvrmPKU-v2NW9x8-uprYU4yfcbpskz6njCTfn_nrZ7E-SLQjlmH02nzFUQDWdJ8TjpNpSz3TMb8oRVZ3HT5_f5kfTRNszSHjzGOtfvDhDYXGKeEON9aE9dfb9DKN-3JA43nIKrwbyptvqgTg8wjzjI3yKB4oY5dNqXVEufVZmRHXdn65N7CKZFYVAxNJ83tAi-T9JUSqPOTWp80X7aCQfAisPVpVyGxRxnJEZ1uG_vTGeTPpsnvsl2GankP2vOvTukreVWgzdCe9ueFVDMOPh1s3cto1p8Lv_UwJdxx8jOOk6-eDt-nliaC2UY6H9n9mYFflausWC9hfmRmfHGFSimEgVhKlkKYEesNxvbQNNQH2kOY1Ppiyaql8D46wblHAPcZZ8PWTW5OKyBMbx7Q6c0FHjzV2D0yMWyjRFsOL8thFJdZPt3bIYqL6gaU7wnpkrZxcb27ObY2fIqxz1V7iHX_Ve7UOM7tXlnV0w4DbOV32GoXSLgBPhkwcf3DqoJvzzxTwLK9v_wRi1qWJxDdX_1wDDA-jwGYOzRPcCHFqiRmAmRv0VSkA_E92qHiQnOy2CZHFc_-p6da5oPQ6g5cjirKHyAdoIqQ7rm9U-Mo5JxPIR47NicM8bQan1srxlgBfbfGaiWkxg7oSzYVzFucazZWTnTRNmEu2jhWFF-1OdyrNnHz9GWbzbtsk1ks8kPTFdFqN9dtkgoc23RNX16BLatgFtiwrwLn2C64sgoC07RNkz1Gaa7dWFH-xZtPXbxxAp7whsmnbt_Esuwdk09dwIm7ylwV-dQlnGz127m986krODHIOfd3PnURJ26VusHzqXs4cU-ZW0qfuogTt0ndiwb0PdwQ1wT0VZxKABqLLuPYFW5whds44a2aJ7xVG0tv1XzJrZonuFWTALV7r2bz7tVYac7N2rh7s6Yig-cO8m6NI9hzu-b23a6JV8Hk_Rq-pSuyvETNTPdbqcN3eJ7gwk4F1Z7gym7IiGAu7YYsoNlrOwVpbEPBxZ2KAg736o6VxBvo3cFNYYAZwo9RLuOiSmdQgk0O0lJObr2_2lONbtg47LWeinGcnou9Ibigb_aGWLZ7idYr-fn_AQ';	
				
			} else {
				
				#default settings code
				$options = 'rVrbjuQmEP2VkVZKniLZ7nvv02q1DyONkigzL1lFsrBNu0lj4wCemd7V_nvwBXzBxuUor-5zgCqKqjrQ6OwfvfN3cfaD80__lEx-TIgoKLqHlKWs-fJRnL32R_Ph2H6oUGHJ6TzS90fQ8Jo40F4f_UYSeYUOfcUkvUoHetuhSR6uWPkFvZKY5Qto_SXHb2HB8YW8O8DHHpiiCNOQvWLOSYIBBlQkSTJcYE6Yw5l7bTC6s7LzjL9pvws1XYT4L3zgOP-kzcZIlhwnIclQikNBvnWL00Ns9p69PpQjepckFmHMnAbpL3EpJMvCWIh58GmI_VsAHCVZEWY4LxsXOwgH7REcS6J2uibJe9EtXg-Z4RSZj8F2ioe4sp3iMC8zQAQMqEvr3GlSGdV4FZUS53JilXlpu0OxYNPoXBAzyniI4rg_hw3fDOARe8ci9Ffig5X4zUr8FhCGF-XN2kGO2AoGYL15V4wSzMG0dtuWaac-K2LJHRD0Bjs8sfO7XBNUqk2xFIAz0ocvTGEovOL4UGAABW6gwC0UuIMC91DgAQo8QoGn5bLcOtwD5J_meFTVp6r6g5y3658jO24a5ri46BpgxXADj5FcDvcGKlHqWL_G4veYloK84raOqpzvOIbBDCtiUlUVgLs6orIEp4zfAYmoI7ltOhiH57nKLCCLvEnOoj16n3CGCF0qCNrXiMfXygofDg3g0A0cuoVDd3DoHg49wKFHOPQEKFJmD7zlxq-o-jYfiAuAuA0QtwXidkDcHog7AHFHIO60nJcbP3uA41Yj1_XjpsmsuaubchNjpbxWzVySKfGDcxRRTUQqaX8nZ6_XP0pe6l9_9HJMOwbOCnkPlVBcM0inDtpBqpzoVAf-kMAZxfaPVSvFSVTKqQrVMhlXXZZVI3Oi2lqUTYyZEK4yqUrtzi7WRger0JtV6O0q9G4Ver8KfViFPq5CnwDtam93PEDtVSfkG1UhL4nsxY8-Fc-PX78-Pf76188dcT8iAuq8P57LWeW3I7TSiVEvPvVgm_klESUf-CuiFuc4Pwu-XJTbLKV4Qb0zaPSlyTKjVGX0Z4YonZAGmgbwWTDmuJ1mrWzZa9aqIG6zLj8kR7kglcqzyoP6Jek1WZ0C67znbKs6UagJr6oCsFDIO7Wzer8N7EVEgmPE1wVpQ3H7O-hmVVJ1ZIme_eW33x96h9B4vCVN3FFpYwbh0xUMnCckT8HXNYYgymiJcxpzIDdoJuwMaybsJg4efi8oiYkEW2MIK06P4cBOj4GPzLBD0x8z1ijE7hKXFaPEa5by9Only_PLw6c_Xh4_P315nrrUVeRFdTmcqz4_4I7E6zdW6jCnGLBLHTjMWEQoBt04V6aQrNnbdQT3xu77hLalWphjkuKcxVxVqgNAnYJihAzAyA0YuQUjd2DkHow8gJFHMPK0LBC150ESgwn5nyVGxV0rMYJNn62aM5ZlKluqATKs-u9kIpuiVOgsR7Cwr2eskYY51CTzP1n5kFWmPCAq2AMlt26pwXFusAuhqhEQgwt67b2tXZ0t_hRvb-2u0llENQ6dQArqd7b21w_m87b6bJ52-oLE2mPT09EyXValjchLrKV61lLbLDAP_dHNfcN3YeE-dDjzlELSnF0uS9YHcOt7t2PS8SCxYq1GGyftVTzgqkaFD2PSBTWHTWEjFN9Szsoc8EyHpiPLm9C1VS8bc5w532V6S1YbIbB0DH3qFwVFANzwaWgAh27g0C0cuoND93DoAQ49wqEn0NN3uwcQedsE41yflNitRcyKe539Q4nfJeQRUJUCIsUSvBNoOIlKnqtFwY4zF2LhZV0fEPlGZGVsKTB3j23cU9SaD6sE7p5CeydlTBXagpYLazKVqkcoOFOVBQONqfarjDDEGCOVUYwjxm4LS_PH8Ki-AAuHTbpDIbVubt74Ft7wjV5WKuHGQ5JAYrbBLmkQ0yaxmAxuGiGFtPrDhhVqrWVW5m3-U7BcdynJb_MofQKulVT6H6pTd2Na39kC_rBijM8KxpVkK6prCwF41VJynL2pzqZudSqFN0v68S8';
				
			}
			
			# Decode options and unserialize			
			$options = it_decode( $options, $serialize = true );
			if(is_array($options))
				foreach( $options as $key => $value )
					if( is_array( $value ) )
						foreach( $value as $key2 => $value2 )
							$options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		break;
		case "widgets":
		
			if($state=='demo') {
				
				#demo widgets code
				$options = 'pVftjqQgEHyb-2eioPgxD2MYZSckCnuKM7vZ7Luf3ijS2ujs3V8piu6q7kZ4QbPiqy-itPj1e9Dm8ia4GTpRB5VuhlYF0fPzhRdR8SWL8NIXJJyx0pQNN6I3Je-MrBrRB2SGfx9Qkj2lxY6URr-XnbhL8Ri3uHzxjBkBgREq6HUleYOQZSvZE1NWelAGREcWtlaPR_XBf-adOHHmK6waeqPbspe1uPKudEjDhZUtWYkPE6QzQBbRlEjkMDV6qNdzZEEOM11xdIo8OnAstNB4oiTQiUno2CKSCUEdRCdULdXNCZxt4uJNsx4WEYtLL46lU_yiMlIrgMk2AT3Lws0unxBsp4LhV1iLiyeP91IqPp50F-VD1jdheuvJaMkIXSqxH66tUMNm1UbT6LEKZ18tJrElSJHEGDQXkzGG9qYeGXPgLmZZCkwFNUYdWZad7_wmfphNBrI56o0MJHVUi1EIE_OWUeRPL3Z6fFlopZK9NCKoZTfGr7vPXbKzvXYqyA9sFlA7C46yiKA0R1DyujYUGYUgzJO5ChQ8JaP7nLFOpOc1DVNEayl3oknm9UorNa4H2y59YczHCN2b1kZ0e0eJpUNnUfi6lcnpqZhB-xF_Hj1FeJAZkJ8SxQgRZiE7ZUq2jYTDmLffnrcw3pVWdtiVwXPTPgcwDxxbcB7i5fF2T3bGSb2chyWUITfWfZRElzfe-uVhuDzOTqTc6b5gNtUOZGToWAUyYueh3Qr-8Ny-wZnpvzJjnXTjf8eJT0qCSznv-uE9wF4fHql3SNomdHUiuAPbMM8rmZ2R0h0pORd-cysg94ZrzUKjtJrXfe4kuDvrRiRzdKxHTtoJruUR6aGV-Rk3PQ7Y-9MTvvTGCC1l-kq4BP6s4HJRWJ37O4t5f0gXwxl8ZWDTJ4LPDG91MfjWwHrFHaTLOu86_lneRdePSTnxfv8B';
				
			} else {
				
				#default widgets code
				$options = 'hdJtbsMgDAbg2-wfUkI-upE77AoRJV5mqcEZkHZVlbuPaBSRKhK_3wfbGKQoW_GwovwQbz8Lue4296ilcniF_obDCM7-B50UhXisVpyCtMt5Ar3E1NdBUXRWvD8BSKO-GQ8CRenDsg6pAQXasZmss4nhmzntjaLJd9qxamNFYFsbP2-a11vOQ66kg5EM7kTjRRvABE7GaE1OXohmZnGAszQva4hmliO8mE9fm8fiqNGiAzagv48jcz_QcS0T_sLgb3xZJs3KrOBZUaWieW6EtPazsP0L78gXkQNzOMkx4XlS5UmdJ02etCmp4jcx8t5fwVgknfyk9Q8';
				
			}
			
			# Decode options and unserialize
			$options = it_decode( $options, $serialize = true );
			foreach( $options as $key => $value )
				if( is_array( $value ) )
					foreach( $value as $key2 => $value2 )
						$options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		break;
		case 'widget':
		
			if($state=='demo') {
				
				#demo individual widget code
				$options = '7V1bb9u4En5fYP8Dz8s-pfH9WiwOst1su0BzQZrdYp8CWqIlnlKiSlL2ySn6389QEnX1RXbsxKkNFEgiDoec-WaG5PBSPG73xt_kuNUb__I15OrtnNoOUQ9YWC6dERl_fIvHrYiqnVA9eCFTNKZNSOi49fZ7lZGFGfFtLDZnNCgzUsThgm7Rp3a7yIqCfIyBjIpaLMdvOP5Gxx3NuK85G0kUVYwkRNBeK_l8dfPpHt1dvru8vs8Ku0mhTSWeMPIgiEV8053JuKlpOiUaRr8Qu0hSZjOjZF6m6VeaWkRVbkyAGkskgxKJxT0POl0m65XI8BwLex3RlDJFhFzap4Dhx4e8gicAWU7JfuiVYILCpKybfhkZpNzQm_iYsgIzoygQnfpOocjomVrcLxQYOSIhF1bxiMK5gu903F9nOcYM32NthhL9xrhzMp2XMJ3OgZnOcJ3pGEV_4Arx6RQpl6BAEClP9vMS9tM6MPsZrbGfdAS8xQ71NQ7olksIQZ_zw-XJiA4uCDWXG1FzmRE1lxpRc6URtZrropAR_I-7myt0_-ES_fbx5v3JeE4RCIyndQpBpxD05BDUPq2-TlPoLQJQvZRCv5IHsBgP7SwD0NUZgC78MtAmaAQDOo_PssxDoqVOVjyjNuEO9sokzYzEiRd9xfJ2Vu5zP7ahAsUwQ4Iq4mUwmJq9ZvrJ6EZhZ0k3KjmUxO16Rydx_8gkrpcn61X8gwE3qaqpMgg14Ck6Wtddtd7AqvUeVq23hVWrkd2jPpUgfVbXyHM5I-JRuVnsePH4lDjMqrmO6fzHSH3oSlsWuougryH7MpusKXlvn5JHmYpujQH6mszZI7qws0Fqn2j39jgaDYue9Vidb1wwht6V_U6OO5mzVlSgq9xnTpzzz7hrD9LDjNWYUK0YFXMFXJCFephy4eFs8m2amFIhVaXPHMCBGUN-PpEuGzsrTKJb9Ib3hShZxyoqofXZQHmmSLMa_Nbzgp9vfAX4uWXfKvCHRfD_1qMomIBH6hjAquH3oGygv28bOOQA0D7yAHDU4HfWgd9ZMBd60iTohPxhIN87crfvPj15ti34S7Nozf2P-zH4_XXgt7N1AKz5uB1ap4i_C-hfcsoXQz-oG_EvfJ-HvkV0PnNf2BsttgaHO8M_OLgZFg6pC_dwHdzm812UbUcXZS2-7iF-eMxRflQX-2SIr4_9qrToqxvlW8-M_3P5fru5P_xXZPwOCP3eEU_w261jR394tOjX2y_qVPaLDNIPCk9K26rtmltu3VLO72GLPbdnPj5cwuF7fIr8kITt7FPY7oEJO9yTsHX9onx1AWQRhb0_PO6Zqwb9A9mErpfCKW9hbmR7iaUcuMSm3hUg_2R5e0eHcP84JDYJoJoBYVgJCJJYinK_dPmon-6u7z-ULtaO6emnYv92OF1uvsCEaVdr4nqGu8YwC6coTjj_yDhn-ZODDYdPM4RDzY7tMgnW_NFB7B4BiK2TJ75MrmKXILZPnniQIG55YOQE4uv0xG2Tg5JbFLMHi4fZfnAuORjZhEmdqDlVioiFB3Gn2CITzr8sRNIJWCir-anuXphnLB95qMIJqR4Tf4GG6-HTWoZPIXXbNuiM8vsAXNipFMukWy31KHMkNSf5rX7j0xVTXKggwyegPjRBpFps8oxaX5Z2IHC54lU_HlW3JOK7WctTkiWC6oKpJjbdCjaK_Fc9hP5c4CBIT9Q_6QkUxYPyrbUodRPD3atxpPeeB6B2B0X7MS7Ew02O9OpKV0np1qdvBnl7nOROhZhWQEoFJi0tLggMARD4GP1f7kZCOoIo6pGACMrtyn5SFhbT4atd49QbaAf9JYlAt2B7Tzz-siu1DItqCaF7u9LNoZ1-3-WUpbsOc1P_A3VcnVOMcL_LXfbc_pD7hvmYE_R7OOTarnHVy0B_aVPFDw38_YTDHxn3_jqXH-XCfAQ2unepRJ8J-fI8o-AzwZ7KqaX7h2Dxo4O_7Ravnk8p4henUutGjspkN207vrtfep6gsC5OKErvDrTyB3MSksrjBK0FLRXfJmjlHzlIKKpPE7S2iBmv8gUGCAkDc8phzWVnHRDuib8gHLzWtyc2nSOPVmuqavM_nl6WRU2znzCo8VCOMSTqJ2_koD8gth2dNUWp-5M5LTanbY8fKEF8OxuXIwWvfc8hXfffXV7__uf1y7z8VVOZdWZQg-LBpPY2km_YTm-f7XSLx3BWtDMqtYO2PP0Sj4rPobjhPtsZbpadGyx1p-pDKek7KeDe36qTt5KjtHY2A9zV5K5bpCo_O3UAj_Ump22PXL_Dfeq3e9LvXu23d9LvHvVbb45U2g7L5Re2f_zexzNg5IebMypt1wTY2cG797ExvSltUm3Qq9FCfoF-xnNzZs0SM7kFj9IesyT6_y3YnE3pXUCFnfhhwM05laxI79oVE0Ids9FdczGTPviWcdJApHQMVkvIFWT6a_zBVSoYNxrKJR6Zcr0heu4T1fi3pvjTt0OpBMXsXhcn-v7FidlQz0FSWEU-8_n8nKbVIq7yHAyoMWV4xkVjHoA5QVTwVSMMGMe2bLSbrU6j2WtI7AWMvMH2m06zeR4YZ0XAJmkDJwpGoC3lJh875rU75BLquIa2nX5umA43cPSbUUoxXhVzN92T1tdovbkHrfdWaz0NT58JA-EIUjx61z5-IeZfq8Ho9_s5MNyO7tRnguaCKoJc7uutmOTSzXnU7Zjk559-_ukjAOQhGsjQQzZnXCBJFcIQ8c8QqFWfzCcqFAjbNKDS0jvchFF1jv6mM-yFEs2AOZ2EDOpPoURGxWcIQ4FLrZBhkEToTaAptiiUA4UMgVGgmVzhUMCHrGhGZ0QIqBMKaO4c3QpMpL5IL7FDlQKK_4AhcIQVClwsiALaCZ3AgiP0zrU8F4x-DbEHyPm2IKAA5FH0NYSKHnZ8jGwcQG_lGaI2cgSeURsjRnhGD53iYkKRTywUhCLUFXUnoS8uloQxLTNVGBCK_4DaoI1MC6Y7CZVPvoZEp60oBm1oPr9zzduoOa9AInihHWxZoSexb5AhthE_lvIMEZ0Jy-M00-oHJIQe1UAnSWvx50gFZ0hyxqhFVWjTKKHGoDK0piFnGOwBWEYNwE8tnFbrboFa5zDpq6QrHMY4wjVXZE2oaqbZaJcIgqA3iPvsEQ2RmYFpLSidTjKbU2eIg_eJOZVEuyHUmPOQ2YCICjGDuhOCWk0UjfZxZe2xgf42Lz7hvSomDGrGhHdalR668ckb_XLoJ2qTSW7vabHUvUE-Twb_MLJiPjKuD_YEcAXEolNqRUJFMQco9QzrHP3DQ2RFxgcWgyCSI-w_RmXAy7cT4edU31hGjzyMQgdoTpfBn8jFM1C2j0KfUf2YK2jP06fdokLNOJSkjinUmGx8_z8';
				
			} else {
				
				#default individual widget code
				$options = 'xZLNDoIwEITfxpsJFH9weRhTy0aaUIrtoibEdxe0oEUOmGA8tZmZZL_ZlkMMtYVwDYtTpSm5yPSItOdGZPKM9ikmHBjUElhzidp4lyZJObqMhcCpvdDFhK4KcqqEoHFi56RGl6m-FG_mraFhzt6rKif5ZOoj4SOy9YEFJzxqI8eQV7Mg91CZRPPYj-D5zKVCv5RC4p91wsl1pk1lzJ9qUGBBS6GVas6RfbIv9rlxQlGpA5p-8HrqRnajbKW2_wYLBmD2xRNA3SYiP2Gx_TS_f87hJyK8kod2uwM';
				
			}
		
		break;
		case 'mods':
		
			if($state=='demo') {
				
				#demo theme_mods code
				$options = 'VY7BCoAgEET_pltQIVHjx8QWUQulhdpF_PeU7OBhLvMes0vo4BmNnGMM2gHV7bSVip7pXJWbDr2QZa3M10uCgDf4PauvOnmZMrq4MmZ4EquSinRDZLzzth8xtnTSH_-8cXMJexnCCw';
				
			} else {
				
				#default theme_mods code
				$options = 'VY7BCoAgEET_pltQIVHjx8QWUQulhdpF_PeU7OBhLvMes0vo4BmNnGMM2gHV7bSVip7pXJWbDr2QZa3M10uCgDf4PauvOnmZMrq4MmZ4EquSinRDZLzzth8xtnTSH_-8cXMJexnCCw';
				
			}
			
			# Decode options and unserialize
			$options = it_decode( $options, $serialize = true );
			foreach( $options as $key => $value )
				if( is_array( $value ) )
					foreach( $value as $key2 => $value2 )
						$options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		break;
		case "internal":
		
			$options = array();
			
			if( defined( 'FRAMEWORK_VERSION' ) )
				$options['framework_version'] = FRAMEWORK_VERSION;
				
			if( defined( 'DOCUMENTATION_URL' ) )
				$options['documentation_url'] = DOCUMENTATION_URL;
				
			if( defined( 'SUPPORT_URL' ) )
				$options['support_url'] = SUPPORT_URL;
		
		break;	
	}
	
	return $options;
}

# turn variables into proper class types
function it_prep_data( $data ) {
	#loop through minisites
	$minisite = it_get_setting('minisite');
	if ( isset($minisite['keys']) && $minisite['keys'] != '#' ) {
		$minisite_keys = explode(',',$minisite['keys']);
		foreach ($minisite_keys as $mkey) {
			if ( $mkey != '#') {
				$minisite_name = ( !empty( $minisite[$mkey]['name'] ) ) ? $minisite[$mkey]['name'] : '#';
				$minisite_slug = it_get_slug($minisite[$mkey]['slug'], $minisite_name);								
				#create itCriteria objects based on entered details	
				$criteria = $data[IT_SETTINGS]['criteria_'.$minisite_slug];		
				if ( isset($criteria['keys']) && $criteria['keys'] != '#' ) {
					$criteria_keys = explode(',',$criteria['keys']);
					foreach ($criteria_keys as $tkey) {
						$id = $tkey . '_' . $minisite_slug;
						$val = ( ( $id != '#_' . $minisite_slug ) && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
						if ( $id != '#_'.$minisite_slug) {
							$criteria_name = ( !empty( $criteria[$id]['name'] ) ) ? $criteria[$id]['name'] : '';
							$criteria_weight = ( !empty( $criteria[$id]['weight'] ) ) ? $criteria[$id]['weight'] : '';
							if(is_array($data)) array_push($data[IT_SETTINGS]['criteria_'.$minisite_slug][$id],new itCriteria($criteria_name, $criteria_weight));						
						}
					}
				}
				#create itDetail objects based on entered details	
				$details = $data[IT_SETTINGS]['details_'.$minisite_slug];		
				if ( isset($details['keys']) && $details['keys'] != '#' ) {
					$details_keys = explode(',',$details['keys']);
					foreach ($details_keys as $tkey) {
						$id = $tkey . '_' . $minisite_slug;
						$val = ( ( $id != '#_' . $minisite_slug ) && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
						if ( $id != '#_'.$minisite_slug) {
							$details_name = ( !empty( $details[$id]['name'] ) ) ? $details[$id]['name'] : '';
							if(is_array($data)) array_push($data[IT_SETTINGS]['details_'.$minisite_slug][$id],new itDetail($details_name));						
						}
					}
				}
				#create itTaxonomy objects based on entered taxonomies	
				$taxonomies = $data[IT_SETTINGS]['taxonomies_'.$minisite_slug];			
				if ( isset($taxonomies['keys']) && $taxonomies['keys'] != '#' ) {
					$taxonomies_keys = explode(',',$taxonomies['keys']);
					foreach ($taxonomies_keys as $tkey) {
						$id = $tkey . '_' . $minisite_slug;
						$val = ( ( $id != '#_' . $minisite_slug ) && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
						if ( $id != '#_'.$minisite_slug) {
							$taxonomy_name = ( !empty( $taxonomies[$id]['name'] ) ) ? $taxonomies[$id]['name'] : '';							
							$taxonomy_slug = it_get_slug($taxonomies[$id]['slug'], $taxonomy_name);
							$taxonomy_primary = ( !empty( $taxonomies[$id]['primary'] ) ) ? $taxonomies[$id]['primary'] : false;
							if(is_array($data)) array_push($data[IT_SETTINGS]['taxonomies_'.$minisite_slug][$id],new itTaxonomy($minisite_slug, $taxonomy_name, $taxonomy_slug, $taxonomy_primary));						
						}
					}
				}
				#create itAward objects based on entered awards
				$awards = $data[IT_SETTINGS]['awards_'.$minisite_slug];			
				if ( isset($awards['keys']) && $awards['keys'] != '#' ) {
					$awards_keys = explode(',',$awards['keys']);
					foreach ($awards_keys as $akey) {
						$id = $akey . '_' . $minisite_slug;
						$val = ( ( $id != '#_' . $minisite_slug ) && ( isset( $data[$id] ) ) ) ? $data[$id] : '';
						if ( $id != '#_'.$minisite_slug) {
							$award_name = ( !empty( $awards[$id]['name'] ) ) ? $awards[$id]['name'] : '';
							$award_icon = ( !empty( $awards[$id]['icon'] ) ) ? $awards[$id]['icon'] : '';
							$award_iconhd = ( !empty( $awards[$id]['iconhd'] ) ) ? $awards[$id]['iconhd'] : '';
							$award_iconwhite = ( !empty( $awards[$id]['iconwhite'] ) ) ? $awards[$id]['iconwhite'] : '';
							$award_iconhdwhite = ( !empty( $awards[$id]['iconhdwhite'] ) ) ? $awards[$id]['iconhdwhite'] : '';
							$award_badge = ( !empty( $awards[$id]['badge'] ) ) ? $awards[$id]['badge'] : false;
							if(is_array($data)) array_push($data[IT_SETTINGS]['awards_'.$minisite_slug][$id],new itAward($award_name, $award_icon, $award_iconhd, $award_iconwhite, $award_iconhdwhite, $award_badge));						
						}
					}
				}
			}
		}
	}
	#die (var_export($data));
	return $data;
}

/**
 * 
 */
function it_icons() {
	$icons = array(		
		'icon-flag' => __( 'Flag', IT_TEXTDOMAIN ),
		'icon-cog' => __( 'Gear', IT_TEXTDOMAIN ),
		'icon-cog-alt' => __( 'Gears', IT_TEXTDOMAIN ),
		'icon-wrench' => __( 'Wrench', IT_TEXTDOMAIN ),
		'icon-gauge' => __( 'Gauge', IT_TEXTDOMAIN ),
		'icon-tools' => __( 'Tools', IT_TEXTDOMAIN ),
		'icon-window' => __( 'Window', IT_TEXTDOMAIN ),
		'icon-folder-open' => __( 'Folder', IT_TEXTDOMAIN ),
		'icon-search' => __( 'Search', IT_TEXTDOMAIN ),
		'icon-username' => __( 'User', IT_TEXTDOMAIN ),
		'icon-users' => __( 'Users', IT_TEXTDOMAIN ),
		'icon-email' => __( 'Envelope', IT_TEXTDOMAIN ),
		'icon-bookmark' => __( 'Bookmark', IT_TEXTDOMAIN ),
		'icon-book' => __( 'Book', IT_TEXTDOMAIN ),
		'icon-commented' => __( 'Comment', IT_TEXTDOMAIN ),
		'icon-globe' => __( 'Globe', IT_TEXTDOMAIN ),
		'icon-suitcase' => __( 'Suitcase', IT_TEXTDOMAIN ),
		'icon-target' => __( 'Target', IT_TEXTDOMAIN ),
		'icon-pin' => __( 'Pin', IT_TEXTDOMAIN ),
		'icon-attach' => __( 'Paperclip', IT_TEXTDOMAIN ),
		'icon-home' => __( 'Home', IT_TEXTDOMAIN ),
		'icon-key' => __( 'Key', IT_TEXTDOMAIN ),
		'icon-zoom-in' => __( 'Zoom In', IT_TEXTDOMAIN ),
		'icon-zoom-out' => __( 'Zoom Out', IT_TEXTDOMAIN ),
		'icon-doc' => __( 'Document', IT_TEXTDOMAIN ),
		'icon-floppy' => __( 'Floppy Disk', IT_TEXTDOMAIN ),
		'icon-picture' => __( 'Picture', IT_TEXTDOMAIN ),
		'icon-link' => __( 'Link', IT_TEXTDOMAIN ),
		'icon-video' => __( 'Video', IT_TEXTDOMAIN ),
		'icon-battery' => __( 'Battery', IT_TEXTDOMAIN ),
		'icon-monitor' => __( 'Monitor', IT_TEXTDOMAIN ),
		'icon-mobile' => __( 'Mobile Phone', IT_TEXTDOMAIN ),
		'icon-tablet' => __( 'Tablet', IT_TEXTDOMAIN ),
		'icon-laptop' => __( 'Laptop', IT_TEXTDOMAIN ),
		'icon-signal' => __( 'Signal', IT_TEXTDOMAIN ),
		'icon-wifi' => __( 'Wifi', IT_TEXTDOMAIN ),
		'icon-camera' => __( 'Camera', IT_TEXTDOMAIN ),
		'icon-list' => __( 'List', IT_TEXTDOMAIN ),
		'icon-tag' => __( 'Tag', IT_TEXTDOMAIN ),
		'icon-pencil' => __( 'Pencil', IT_TEXTDOMAIN ),
		'icon-category' => __( 'Folder', IT_TEXTDOMAIN ),							
		'icon-random' => __( 'Shuffle', IT_TEXTDOMAIN ),
		'icon-loop' => __( 'Loop', IT_TEXTDOMAIN ),
		'icon-play' => __( 'Play', IT_TEXTDOMAIN ),
		'icon-stop' => __( 'Stop', IT_TEXTDOMAIN ),
		'icon-pause' => __( 'Pause', IT_TEXTDOMAIN ),
		'icon-grid' => __( 'Grid', IT_TEXTDOMAIN ),
		'icon-x' => __( 'Circled X', IT_TEXTDOMAIN ),
		'icon-help-circled' => __( 'Circled Help', IT_TEXTDOMAIN ),
		'icon-quote-circled' => __( 'Circled Quote', IT_TEXTDOMAIN ),
		'icon-info-circled' => __( 'Circled Info', IT_TEXTDOMAIN ),							
		'icon-attention' => __( 'Circled Attention', IT_TEXTDOMAIN ),
		'icon-plus' => __( 'Plus', IT_TEXTDOMAIN ),
		'icon-minus' => __( 'Minus', IT_TEXTDOMAIN ),
		'icon-plus-squared' => __( 'Plus Squared', IT_TEXTDOMAIN ),
		'icon-minus-squared' => __( 'Minus Squared', IT_TEXTDOMAIN ),
		'icon-alert' => __( 'Alert', IT_TEXTDOMAIN ),
		'icon-viewed' => __( 'Eye', IT_TEXTDOMAIN ),
		'icon-star' => __( 'Star', IT_TEXTDOMAIN ),
		'icon-liked' => __( 'Heart', IT_TEXTDOMAIN ),
		'icon-check' => __( 'Check', IT_TEXTDOMAIN ),
		'icon-lock' => __( 'Locked', IT_TEXTDOMAIN ),
		'icon-lock-open' => __( 'Unlocked', IT_TEXTDOMAIN ),
		'icon-password' => __( 'Password', IT_TEXTDOMAIN ),
		'icon-right' => __( 'Right Arrow', IT_TEXTDOMAIN ),
		'icon-left' => __( 'Left Arrow', IT_TEXTDOMAIN ),
		'icon-up' => __( 'Up Arrow', IT_TEXTDOMAIN ),
		'icon-down' => __( 'Down Arrow', IT_TEXTDOMAIN ),
		'icon-right-open' => __( 'Right Arrow Open', IT_TEXTDOMAIN ),
		'icon-left-open' => __( 'Left Arrow Open', IT_TEXTDOMAIN ),
		'icon-up-open' => __( 'Up Arrow Open', IT_TEXTDOMAIN ),
		'icon-arrow-down' => __( 'Down Arrow Open', IT_TEXTDOMAIN ),
		'icon-up-bold' => __( 'Up Arrow Bold', IT_TEXTDOMAIN ),
		'icon-down-bold' => __( 'Down Arrow Bold', IT_TEXTDOMAIN ),							
		'icon-right-thin' => __( 'Right Arrow Thin', IT_TEXTDOMAIN ),
		'icon-forward' => __( 'Right Arrow Curved', IT_TEXTDOMAIN ),
		'icon-left-hand' => __( 'Left Hand', IT_TEXTDOMAIN ),
		'icon-right-hand' => __( 'Right Hand', IT_TEXTDOMAIN ),
		'icon-awarded' => __( 'Trophy', IT_TEXTDOMAIN ),
		'icon-beaker' => __( 'Beaker', IT_TEXTDOMAIN ),
		'icon-scissors' => __( 'Scissors', IT_TEXTDOMAIN ),
		'icon-thumbs-up' => __( 'Thumbs Up', IT_TEXTDOMAIN ),
		'icon-thumbs-down' => __( 'Thumbs Down', IT_TEXTDOMAIN ),
		'icon-comments' => __( 'Comments', IT_TEXTDOMAIN ),
		'icon-recent' => __( 'Clock', IT_TEXTDOMAIN ),							
		'icon-trending' => __( 'Trending Graph', IT_TEXTDOMAIN ),
		'icon-reviewed' => __( 'Line Graph', IT_TEXTDOMAIN ),
		'icon-chart-pie' => __( 'Pie Chart', IT_TEXTDOMAIN ),
		'icon-coffee' => __( 'Coffee', IT_TEXTDOMAIN ),
		'icon-food' => __( 'Food', IT_TEXTDOMAIN ),
		'icon-truck' => __( 'Truck', IT_TEXTDOMAIN ),
		'icon-water' => __( 'Water', IT_TEXTDOMAIN ),
		'icon-magnet' => __( 'Magnet', IT_TEXTDOMAIN ),
		'icon-brush' => __( 'Paint Brush', IT_TEXTDOMAIN ),
		'icon-leaf' => __( 'Leaf', IT_TEXTDOMAIN ),
		'icon-fire' => __( 'Fire', IT_TEXTDOMAIN ),
		'icon-moon' => __( 'Moon', IT_TEXTDOMAIN ),
		'icon-cloud' => __( 'Cloud', IT_TEXTDOMAIN ),
		'icon-cc' => __( 'CC License', IT_TEXTDOMAIN ),
		'icon-basket' => __( 'Shopping Cart', IT_TEXTDOMAIN ),
		'icon-credit-card' => __( 'Credit Card', IT_TEXTDOMAIN ),
		'icon-facebook' => __( 'Facebook', IT_TEXTDOMAIN ),
		'icon-pinterest' => __( 'Pinterest', IT_TEXTDOMAIN ),
		'icon-instagram' => __( 'Instagram', IT_TEXTDOMAIN ),
		'icon-flickr' => __( 'Flickr', IT_TEXTDOMAIN ),							
		'icon-stumbleupon' => __( 'StumbleUpon', IT_TEXTDOMAIN ),							
		'icon-twitter' => __( 'Twitter', IT_TEXTDOMAIN ),							
		'icon-googleplus' => __( 'Google+', IT_TEXTDOMAIN ),
		'icon-vimeo' => __( 'Vimeo', IT_TEXTDOMAIN ),
		'icon-tumblr' => __( 'Tumblr', IT_TEXTDOMAIN ),
		'icon-youtube' => __( 'Youtube', IT_TEXTDOMAIN ),
		'icon-linkedin' => __( 'LinkedIn', IT_TEXTDOMAIN ),
		'icon-skype' => __( 'Skype', IT_TEXTDOMAIN ),
		'icon-paypal' => __( 'Paypal', IT_TEXTDOMAIN ),
		'icon-picasa' => __( 'Picasa', IT_TEXTDOMAIN ),
		'icon-spotify' => __( 'Spotify', IT_TEXTDOMAIN ),
		'icon-lastfm' => __( 'Last.fm', IT_TEXTDOMAIN ),
		'icon-dropbox' => __( 'Dropbox', IT_TEXTDOMAIN ),
		'icon-appstore' => __( 'Apple', IT_TEXTDOMAIN ),
		'icon-windows' => __( 'Windows', IT_TEXTDOMAIN ),
		'icon-yahoo' => __( 'Yahoo!', IT_TEXTDOMAIN ),
		'icon-wikipedia' => __( 'Wikipedia', IT_TEXTDOMAIN ),
		'icon-html5' => __( 'HTML5', IT_TEXTDOMAIN ),
		'icon-wordpress' => __( 'WordPress', IT_TEXTDOMAIN ),
		'icon-gmail' => __( 'Gmail', IT_TEXTDOMAIN ),
		'icon-reddit' => __( 'Reddit', IT_TEXTDOMAIN ),
		'icon-acrobat' => __( 'Acrobat', IT_TEXTDOMAIN ),
		'icon-firefox' => __( 'Firefox', IT_TEXTDOMAIN ),
		'icon-chrome' => __( 'Chrome', IT_TEXTDOMAIN ),
		'icon-opera' => __( 'Opera', IT_TEXTDOMAIN ),
		'icon-ie' => __( 'Internet Explorer', IT_TEXTDOMAIN ),
		'icon-rss' => __( 'RSS', IT_TEXTDOMAIN ),		
		);
	return $icons;
}

/**
 * 
 */
function it_fonts() {
	$fonts = array(
		'Arial, Helvetica, sans-serif' => 'Arial',
		'Verdana, Geneva, Tahoma, sans-serif' => 'Verdana',
		'"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif' => 'Lucida',
		'Georgia, Times, "Times New Roman", serif' => 'Georgia',
		'"Times New Roman", Times, Georgia, serif' => 'Times New Roman',
		'"Trebuchet MS", Tahoma, Arial, sans-serif' => 'Trebuchet',
		'"Courier New", Courier, monospace' => 'Courier New',
		'Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif' => 'Impact',
		'Tahoma, Geneva, Verdana, sans-serif' => 'Tahoma',	
		'spacer' => '                ',
		'ABeeZee, sans-serif' => 'ABeeZee',
		'Abel, sans-serif' => 'Abel',
		'Abril Fatface, sans-serif' => 'Abril Fatface',
		'Aclonica, sans-serif' => 'Aclonica',
		'Acme, sans-serif' => 'Acme',
		'Actor, sans-serif' => 'Actor',
		'Adamina, sans-serif' => 'Adamina',
		'Advent Pro, sans-serif' => 'Advent Pro',
		'Aguafina Script, sans-serif' => 'Aguafina Script',
		'Akronim, sans-serif' => 'Akronim',
		'Aladin, sans-serif' => 'Aladin',
		'Aldrich, sans-serif' => 'Aldrich',
		'Alegreya, sans-serif' => 'Alegreya',
		'Alegreya SC, sans-serif' => 'Alegreya SC',
		'Alex Brush, sans-serif' => 'Alex Brush',
		'Alfa Slab One, sans-serif' => 'Alfa Slab One',
		'Alice, sans-serif' => 'Alice',
		'Alike, sans-serif' => 'Alike',
		'Alike Angular, sans-serif' => 'Alike Angular',
		'Allan, sans-serif' => 'Allan',
		'Allerta, sans-serif' => 'Allerta',
		'Allerta Stencil, sans-serif' => 'Allerta Stencil',
		'Allura, sans-serif' => 'Allura',
		'Almendra, sans-serif' => 'Almendra',
		'Almendra Display, sans-serif' => 'Almendra Display',
		'Almendra SC, sans-serif' => 'Almendra SC',
		'Amarante, sans-serif' => 'Amarante',
		'Amaranth, sans-serif' => 'Amaranth',
		'Amatic SC, sans-serif' => 'Amatic SC',
		'Amethysta, sans-serif' => 'Amethysta',
		'Anaheim, sans-serif' => 'Anaheim',
		'Andada, sans-serif' => 'Andada',
		'Andika, sans-serif' => 'Andika',
		'Angkor, sans-serif' => 'Angkor',
		'Annie Use Your Telescope, sans-serif' => 'Annie Use Your Telescope',
		'Anonymous Pro, sans-serif' => 'Anonymous Pro',
		'Antic, sans-serif' => 'Antic',
		'Antic Didone, sans-serif' => 'Antic Didone',
		'Antic Slab, sans-serif' => 'Antic Slab',
		'Anton, sans-serif' => 'Anton',
		'Arapey, sans-serif' => 'Arapey',
		'Arbutus, sans-serif' => 'Arbutus',
		'Arbutus Slab, sans-serif' => 'Arbutus Slab',
		'Architects Daughter, sans-serif' => 'Architects Daughter',
		'Archivo Black, sans-serif' => 'Archivo Black',
		'Archivo Narrow, sans-serif' => 'Archivo Narrow',
		'Arimo, sans-serif' => 'Arimo',
		'Arizonia, sans-serif' => 'Arizonia',
		'Armata, sans-serif' => 'Armata',
		'Artifika, sans-serif' => 'Artifika',
		'Arvo, sans-serif' => 'Arvo',
		'Asap, sans-serif' => 'Asap',
		'Asset, sans-serif' => 'Asset',
		'Astloch, sans-serif' => 'Astloch',
		'Asul, sans-serif' => 'Asul',
		'Atomic Age, sans-serif' => 'Atomic Age',
		'Aubrey, sans-serif' => 'Aubrey',
		'Audiowide, sans-serif' => 'Audiowide',
		'Autour One, sans-serif' => 'Autour One',
		'Average, sans-serif' => 'Average',
		'Average Sans, sans-serif' => 'Average Sans',
		'Averia Gruesa Libre, sans-serif' => 'Averia Gruesa Libre',
		'Averia Libre, sans-serif' => 'Averia Libre',
		'Averia Sans Libre, sans-serif' => 'Averia Sans Libre',
		'Averia Serif Libre, sans-serif' => 'Averia Serif Libre',
		'Bad Script, sans-serif' => 'Bad Script',
		'Balthazar, sans-serif' => 'Balthazar',
		'Bangers, sans-serif' => 'Bangers',
		'Basic, sans-serif' => 'Basic',
		'Battambang, sans-serif' => 'Battambang',
		'Baumans, sans-serif' => 'Baumans',
		'Bayon, sans-serif' => 'Bayon',
		'Belgrano, sans-serif' => 'Belgrano',
		'Belleza, sans-serif' => 'Belleza',
		'BenchNine, sans-serif' => 'BenchNine',
		'Bentham, sans-serif' => 'Bentham',
		'Berkshire Swash, sans-serif' => 'Berkshire Swash',
		'Bevan, sans-serif' => 'Bevan',
		'Bigelow Rules, sans-serif' => 'Bigelow Rules',
		'Bigshot One, sans-serif' => 'Bigshot One',
		'Bilbo, sans-serif' => 'Bilbo',
		'Bilbo Swash Caps, sans-serif' => 'Bilbo Swash Caps',
		'Bitter, sans-serif' => 'Bitter',
		'Black Ops One, sans-serif' => 'Black Ops One',
		'Bokor, sans-serif' => 'Bokor',
		'Bonbon, sans-serif' => 'Bonbon',
		'Boogaloo, sans-serif' => 'Boogaloo',
		'Bowlby One, sans-serif' => 'Bowlby One',
		'Bowlby One SC, sans-serif' => 'Bowlby One SC',
		'Brawler, sans-serif' => 'Brawler',
		'Bree Serif, sans-serif' => 'Bree Serif',
		'Bubblegum Sans, sans-serif' => 'Bubblegum Sans',
		'Bubbler One, sans-serif' => 'Bubbler One',
		'Buda, sans-serif' => 'Buda',
		'Buenard, sans-serif' => 'Buenard',
		'Butcherman, sans-serif' => 'Butcherman',
		'Butterfly Kids, sans-serif' => 'Butterfly Kids',
		'Cabin, sans-serif' => 'Cabin',
		'Cabin Condensed, sans-serif' => 'Cabin Condensed',
		'Cabin Sketch, sans-serif' => 'Cabin Sketch',
		'Caesar Dressing, sans-serif' => 'Caesar Dressing',
		'Cagliostro, sans-serif' => 'Cagliostro',
		'Calligraffitti, sans-serif' => 'Calligraffitti',
		'Cambo, sans-serif' => 'Cambo',
		'Candal, sans-serif' => 'Candal',
		'Cantarell, sans-serif' => 'Cantarell',
		'Cantata One, sans-serif' => 'Cantata One',
		'Cantora One, sans-serif' => 'Cantora One',
		'Capriola, sans-serif' => 'Capriola',
		'Cardo, sans-serif' => 'Cardo',
		'Carme, sans-serif' => 'Carme',
		'Carrois Gothic, sans-serif' => 'Carrois Gothic',
		'Carrois Gothic SC, sans-serif' => 'Carrois Gothic SC',
		'Carter One, sans-serif' => 'Carter One',
		'Caudex, sans-serif' => 'Caudex',
		'Cedarville Cursive, sans-serif' => 'Cedarville Cursive',
		'Ceviche One, sans-serif' => 'Ceviche One',
		'Changa One, sans-serif' => 'Changa One',
		'Chango, sans-serif' => 'Chango',
		'Chau Philomene One, sans-serif' => 'Chau Philomene One',
		'Chela One, sans-serif' => 'Chela One',
		'Chelsea Market, sans-serif' => 'Chelsea Market',
		'Chenla, sans-serif' => 'Chenla',
		'Cherry Cream Soda, sans-serif' => 'Cherry Cream Soda',
		'Cherry Swash, sans-serif' => 'Cherry Swash',
		'Chewy, sans-serif' => 'Chewy',
		'Chicle, sans-serif' => 'Chicle',
		'Chivo, sans-serif' => 'Chivo',
		'Cinzel, sans-serif' => 'Cinzel',
		'Cinzel Decorative, sans-serif' => 'Cinzel Decorative',
		'Clicker Script, sans-serif' => 'Clicker Script',
		'Coda, sans-serif' => 'Coda',
		'Coda Caption, sans-serif' => 'Coda Caption',
		'Codystar, sans-serif' => 'Codystar',
		'Combo, sans-serif' => 'Combo',
		'Comfortaa, sans-serif' => 'Comfortaa',
		'Coming Soon, sans-serif' => 'Coming Soon',
		'Concert One, sans-serif' => 'Concert One',
		'Condiment, sans-serif' => 'Condiment',
		'Content, sans-serif' => 'Content',
		'Contrail One, sans-serif' => 'Contrail One',
		'Convergence, sans-serif' => 'Convergence',
		'Cookie, sans-serif' => 'Cookie',
		'Copse, sans-serif' => 'Copse',
		'Corben, sans-serif' => 'Corben',
		'Courgette, sans-serif' => 'Courgette',
		'Cousine, sans-serif' => 'Cousine',
		'Coustard, sans-serif' => 'Coustard',
		'Covered By Your Grace, sans-serif' => 'Covered By Your Grace',
		'Crafty Girls, sans-serif' => 'Crafty Girls',
		'Creepster, sans-serif' => 'Creepster',
		'Crete Round, sans-serif' => 'Crete Round',
		'Crimson Text, sans-serif' => 'Crimson Text',
		'Croissant One, sans-serif' => 'Croissant One',
		'Crushed, sans-serif' => 'Crushed',
		'Cuprum, sans-serif' => 'Cuprum',
		'Cutive, sans-serif' => 'Cutive',
		'Cutive Mono, sans-serif' => 'Cutive Mono',
		'Damion, sans-serif' => 'Damion',
		'Dancing Script, sans-serif' => 'Dancing Script',
		'Dangrek, sans-serif' => 'Dangrek',
		'Dawning of a New Day, sans-serif' => 'Dawning of a New Day',
		'Days One, sans-serif' => 'Days One',
		'Delius, sans-serif' => 'Delius',
		'Delius Swash Caps, sans-serif' => 'Delius Swash Caps',
		'Delius Unicase, sans-serif' => 'Delius Unicase',
		'Della Respira, sans-serif' => 'Della Respira',
		'Denk One, sans-serif' => 'Denk One',
		'Devonshire, sans-serif' => 'Devonshire',
		'Didact Gothic, sans-serif' => 'Didact Gothic',
		'Diplomata, sans-serif' => 'Diplomata',
		'Diplomata SC, sans-serif' => 'Diplomata SC',
		'Domine, sans-serif' => 'Domine',
		'Donegal One, sans-serif' => 'Donegal One',
		'Doppio One, sans-serif' => 'Doppio One',
		'Dorsa, sans-serif' => 'Dorsa',
		'Dosis, sans-serif' => 'Dosis',
		'Dr Sugiyama, sans-serif' => 'Dr Sugiyama',
		'Droid Sans, sans-serif' => 'Droid Sans',
		'Droid Sans Mono, sans-serif' => 'Droid Sans Mono',
		'Droid Serif, sans-serif' => 'Droid Serif',
		'Duru Sans, sans-serif' => 'Duru Sans',
		'Dynalight, sans-serif' => 'Dynalight',
		'EB Garamond, sans-serif' => 'EB Garamond',
		'Eagle Lake, sans-serif' => 'Eagle Lake',
		'Eater, sans-serif' => 'Eater',
		'Economica, sans-serif' => 'Economica',
		'Electrolize, sans-serif' => 'Electrolize',
		'Elsie, sans-serif' => 'Elsie',
		'Elsie Swash Caps, sans-serif' => 'Elsie Swash Caps',
		'Emblema One, sans-serif' => 'Emblema One',
		'Emilys Candy, sans-serif' => 'Emilys Candy',
		'Engagement, sans-serif' => 'Engagement',
		'Englebert, sans-serif' => 'Englebert',
		'Enriqueta, sans-serif' => 'Enriqueta',
		'Erica One, sans-serif' => 'Erica One',
		'Esteban, sans-serif' => 'Esteban',
		'Euphoria Script, sans-serif' => 'Euphoria Script',
		'Ewert, sans-serif' => 'Ewert',
		'Exo, sans-serif' => 'Exo',
		'Expletus Sans, sans-serif' => 'Expletus Sans',
		'Fanwood Text, sans-serif' => 'Fanwood Text',
		'Fascinate, sans-serif' => 'Fascinate',
		'Fascinate Inline, sans-serif' => 'Fascinate Inline',
		'Faster One, sans-serif' => 'Faster One',
		'Fasthand, sans-serif' => 'Fasthand',
		'Federant, sans-serif' => 'Federant',
		'Federo, sans-serif' => 'Federo',
		'Felipa, sans-serif' => 'Felipa',
		'Fenix, sans-serif' => 'Fenix',
		'Finger Paint, sans-serif' => 'Finger Paint',
		'Fjalla One, sans-serif' => 'Fjalla One',
		'Fjord One, sans-serif' => 'Fjord One',
		'Flamenco, sans-serif' => 'Flamenco',
		'Flavors, sans-serif' => 'Flavors',
		'Fondamento, sans-serif' => 'Fondamento',
		'Fontdiner Swanky, sans-serif' => 'Fontdiner Swanky',
		'Forum, sans-serif' => 'Forum',
		'Francois One, sans-serif' => 'Francois One',
		'Freckle Face, sans-serif' => 'Freckle Face',
		'Fredericka the Great, sans-serif' => 'Fredericka the Great',
		'Fredoka One, sans-serif' => 'Fredoka One',
		'Freehand, sans-serif' => 'Freehand',
		'Fresca, sans-serif' => 'Fresca',
		'Frijole, sans-serif' => 'Frijole',
		'Fruktur, sans-serif' => 'Fruktur',
		'Fugaz One, sans-serif' => 'Fugaz One',
		'GFS Didot, sans-serif' => 'GFS Didot',
		'GFS Neohellenic, sans-serif' => 'GFS Neohellenic',
		'Gabriela, sans-serif' => 'Gabriela',
		'Gafata, sans-serif' => 'Gafata',
		'Galdeano, sans-serif' => 'Galdeano',
		'Galindo, sans-serif' => 'Galindo',
		'Gentium Basic, sans-serif' => 'Gentium Basic',
		'Gentium Book Basic, sans-serif' => 'Gentium Book Basic',
		'Geo, sans-serif' => 'Geo',
		'Geostar, sans-serif' => 'Geostar',
		'Geostar Fill, sans-serif' => 'Geostar Fill',
		'Germania One, sans-serif' => 'Germania One',
		'Gilda Display, sans-serif' => 'Gilda Display',
		'Give You Glory, sans-serif' => 'Give You Glory',
		'Glass Antiqua, sans-serif' => 'Glass Antiqua',
		'Glegoo, sans-serif' => 'Glegoo',
		'Gloria Hallelujah, sans-serif' => 'Gloria Hallelujah',
		'Goblin One, sans-serif' => 'Goblin One',
		'Gochi Hand, sans-serif' => 'Gochi Hand',
		'Gorditas, sans-serif' => 'Gorditas',
		'Goudy Bookletter 1911, sans-serif' => 'Goudy Bookletter 1911',
		'Graduate, sans-serif' => 'Graduate',
		'Grand Hotel, sans-serif' => 'Grand Hotel',
		'Gravitas One, sans-serif' => 'Gravitas One',
		'Great Vibes, sans-serif' => 'Great Vibes',
		'Griffy, sans-serif' => 'Griffy',
		'Gruppo, sans-serif' => 'Gruppo',
		'Gudea, sans-serif' => 'Gudea',
		'Habibi, sans-serif' => 'Habibi',
		'Hammersmith One, sans-serif' => 'Hammersmith One',
		'Hanalei, sans-serif' => 'Hanalei',
		'Hanalei Fill, sans-serif' => 'Hanalei Fill',
		'Handlee, sans-serif' => 'Handlee',
		'Hanuman, sans-serif' => 'Hanuman',
		'Happy Monkey, sans-serif' => 'Happy Monkey',
		'Headland One, sans-serif' => 'Headland One',
		'Henny Penny, sans-serif' => 'Henny Penny',
		'Herr Von Muellerhoff, sans-serif' => 'Herr Von Muellerhoff',
		'Holtwood One SC, sans-serif' => 'Holtwood One SC',
		'Homemade Apple, sans-serif' => 'Homemade Apple',
		'Homenaje, sans-serif' => 'Homenaje',
		'IM Fell DW Pica, sans-serif' => 'IM Fell DW Pica',
		'IM Fell DW Pica SC, sans-serif' => 'IM Fell DW Pica SC',
		'IM Fell Double Pica, sans-serif' => 'IM Fell Double Pica',
		'IM Fell Double Pica SC, sans-serif' => 'IM Fell Double Pica SC',
		'IM Fell English, sans-serif' => 'IM Fell English',
		'IM Fell English SC, sans-serif' => 'IM Fell English SC',
		'IM Fell French Canon, sans-serif' => 'IM Fell French Canon',
		'IM Fell French Canon SC, sans-serif' => 'IM Fell French Canon SC',
		'IM Fell Great Primer, sans-serif' => 'IM Fell Great Primer',
		'IM Fell Great Primer SC, sans-serif' => 'IM Fell Great Primer SC',
		'Iceberg, sans-serif' => 'Iceberg',
		'Iceland, sans-serif' => 'Iceland',
		'Imprima, sans-serif' => 'Imprima',
		'Inconsolata, sans-serif' => 'Inconsolata',
		'Inder, sans-serif' => 'Inder',
		'Indie Flower, sans-serif' => 'Indie Flower',
		'Inika, sans-serif' => 'Inika',
		'Irish Grover, sans-serif' => 'Irish Grover',
		'Istok Web, sans-serif' => 'Istok Web',
		'Italiana, sans-serif' => 'Italiana',
		'Italianno, sans-serif' => 'Italianno',
		'Jacques Francois, sans-serif' => 'Jacques Francois',
		'Jacques Francois Shadow, sans-serif' => 'Jacques Francois Shadow',
		'Jim Nightshade, sans-serif' => 'Jim Nightshade',
		'Jockey One, sans-serif' => 'Jockey One',
		'Jolly Lodger, sans-serif' => 'Jolly Lodger',
		'Josefin Sans, sans-serif' => 'Josefin Sans',
		'Josefin Slab, sans-serif' => 'Josefin Slab',
		'Joti One, sans-serif' => 'Joti One',
		'Judson, sans-serif' => 'Judson',
		'Julee, sans-serif' => 'Julee',
		'Julius Sans One, sans-serif' => 'Julius Sans One',
		'Junge, sans-serif' => 'Junge',
		'Jura, sans-serif' => 'Jura',
		'Just Another Hand, sans-serif' => 'Just Another Hand',
		'Just Me Again Down Here, sans-serif' => 'Just Me Again Down Here',
		'Kameron, sans-serif' => 'Kameron',
		'Karla, sans-serif' => 'Karla',
		'Kaushan Script, sans-serif' => 'Kaushan Script',
		'Kavoon, sans-serif' => 'Kavoon',
		'Keania One, sans-serif' => 'Keania One',
		'Kelly Slab, sans-serif' => 'Kelly Slab',
		'Kenia, sans-serif' => 'Kenia',
		'Khmer, sans-serif' => 'Khmer',
		'Kite One, sans-serif' => 'Kite One',
		'Knewave, sans-serif' => 'Knewave',
		'Kotta One, sans-serif' => 'Kotta One',
		'Koulen, sans-serif' => 'Koulen',
		'Kranky, sans-serif' => 'Kranky',
		'Kreon, sans-serif' => 'Kreon',
		'Kristi, sans-serif' => 'Kristi',
		'Krona One, sans-serif' => 'Krona One',
		'La Belle Aurore, sans-serif' => 'La Belle Aurore',
		'Lancelot, sans-serif' => 'Lancelot',
		'Lato, sans-serif' => 'Lato',
		'League Script, sans-serif' => 'League Script',
		'Leckerli One, sans-serif' => 'Leckerli One',
		'Ledger, sans-serif' => 'Ledger',
		'Lekton, sans-serif' => 'Lekton',
		'Lemon, sans-serif' => 'Lemon',
		'Libre Baskerville, sans-serif' => 'Libre Baskerville',
		'Life Savers, sans-serif' => 'Life Savers',
		'Lilita One, sans-serif' => 'Lilita One',
		'Limelight, sans-serif' => 'Limelight',
		'Linden Hill, sans-serif' => 'Linden Hill',
		'Lobster, sans-serif' => 'Lobster',
		'Lobster Two, sans-serif' => 'Lobster Two',
		'Londrina Outline, sans-serif' => 'Londrina Outline',
		'Londrina Shadow, sans-serif' => 'Londrina Shadow',
		'Londrina Sketch, sans-serif' => 'Londrina Sketch',
		'Londrina Solid, sans-serif' => 'Londrina Solid',
		'Lora, sans-serif' => 'Lora',
		'Love Ya Like A Sister, sans-serif' => 'Love Ya Like A Sister',
		'Loved by the King, sans-serif' => 'Loved by the King',
		'Lovers Quarrel, sans-serif' => 'Lovers Quarrel',
		'Luckiest Guy, sans-serif' => 'Luckiest Guy',
		'Lusitana, sans-serif' => 'Lusitana',
		'Lustria, sans-serif' => 'Lustria',
		'Macondo, sans-serif' => 'Macondo',
		'Macondo Swash Caps, sans-serif' => 'Macondo Swash Caps',
		'Magra, sans-serif' => 'Magra',
		'Maiden Orange, sans-serif' => 'Maiden Orange',
		'Mako, sans-serif' => 'Mako',
		'Marcellus, sans-serif' => 'Marcellus',
		'Marcellus SC, sans-serif' => 'Marcellus SC',
		'Marck Script, sans-serif' => 'Marck Script',
		'Margarine, sans-serif' => 'Margarine',
		'Marko One, sans-serif' => 'Marko One',
		'Marmelad, sans-serif' => 'Marmelad',
		'Marvel, sans-serif' => 'Marvel',
		'Mate, sans-serif' => 'Mate',
		'Mate SC, sans-serif' => 'Mate SC',
		'Maven Pro, sans-serif' => 'Maven Pro',
		'McLaren, sans-serif' => 'McLaren',
		'Meddon, sans-serif' => 'Meddon',
		'MedievalSharp, sans-serif' => 'MedievalSharp',
		'Medula One, sans-serif' => 'Medula One',
		'Megrim, sans-serif' => 'Megrim',
		'Meie Script, sans-serif' => 'Meie Script',
		'Merienda, sans-serif' => 'Merienda',
		'Merienda One, sans-serif' => 'Merienda One',
		'Merriweather, sans-serif' => 'Merriweather',
		'Merriweather Sans, sans-serif' => 'Merriweather Sans',
		'Metal, sans-serif' => 'Metal',
		'Metal Mania, sans-serif' => 'Metal Mania',
		'Metamorphous, sans-serif' => 'Metamorphous',
		'Metrophobic, sans-serif' => 'Metrophobic',
		'Michroma, sans-serif' => 'Michroma',
		'Milonga, sans-serif' => 'Milonga',
		'Miltonian, sans-serif' => 'Miltonian',
		'Miltonian Tattoo, sans-serif' => 'Miltonian Tattoo',
		'Miniver, sans-serif' => 'Miniver',
		'Miss Fajardose, sans-serif' => 'Miss Fajardose',
		'Modern Antiqua, sans-serif' => 'Modern Antiqua',
		'Molengo, sans-serif' => 'Molengo',
		'Molle, sans-serif' => 'Molle',
		'Monda, sans-serif' => 'Monda',
		'Monofett, sans-serif' => 'Monofett',
		'Monoton, sans-serif' => 'Monoton',
		'Monsieur La Doulaise, sans-serif' => 'Monsieur La Doulaise',
		'Montaga, sans-serif' => 'Montaga',
		'Montez, sans-serif' => 'Montez',
		'Montserrat, sans-serif' => 'Montserrat',
		'Montserrat Alternates, sans-serif' => 'Montserrat Alternates',
		'Montserrat Subrayada, sans-serif' => 'Montserrat Subrayada',
		'Moul, sans-serif' => 'Moul',
		'Moulpali, sans-serif' => 'Moulpali',
		'Mountains of Christmas, sans-serif' => 'Mountains of Christmas',
		'Mouse Memoirs, sans-serif' => 'Mouse Memoirs',
		'Mr Bedfort, sans-serif' => 'Mr Bedfort',
		'Mr Dafoe, sans-serif' => 'Mr Dafoe',
		'Mr De Haviland, sans-serif' => 'Mr De Haviland',
		'Mrs Saint Delafield, sans-serif' => 'Mrs Saint Delafield',
		'Mrs Sheppards, sans-serif' => 'Mrs Sheppards',
		'Muli, sans-serif' => 'Muli',
		'Mystery Quest, sans-serif' => 'Mystery Quest',
		'Neucha, sans-serif' => 'Neucha',
		'Neuton, sans-serif' => 'Neuton',
		'New Rocker, sans-serif' => 'New Rocker',
		'News Cycle, sans-serif' => 'News Cycle',
		'Niconne, sans-serif' => 'Niconne',
		'Nixie One, sans-serif' => 'Nixie One',
		'Nobile, sans-serif' => 'Nobile',
		'Nokora, sans-serif' => 'Nokora',
		'Norican, sans-serif' => 'Norican',
		'Nosifer, sans-serif' => 'Nosifer',
		'Nothing You Could Do, sans-serif' => 'Nothing You Could Do',
		'Noticia Text, sans-serif' => 'Noticia Text',
		'Nova Cut, sans-serif' => 'Nova Cut',
		'Nova Flat, sans-serif' => 'Nova Flat',
		'Nova Mono, sans-serif' => 'Nova Mono',
		'Nova Oval, sans-serif' => 'Nova Oval',
		'Nova Round, sans-serif' => 'Nova Round',
		'Nova Script, sans-serif' => 'Nova Script',
		'Nova Slim, sans-serif' => 'Nova Slim',
		'Nova Square, sans-serif' => 'Nova Square',
		'Numans, sans-serif' => 'Numans',
		'Nunito, sans-serif' => 'Nunito',
		'Odor Mean Chey, sans-serif' => 'Odor Mean Chey',
		'Offside, sans-serif' => 'Offside',
		'Old Standard TT, sans-serif' => 'Old Standard TT',
		'Oldenburg, sans-serif' => 'Oldenburg',
		'Oleo Script, sans-serif' => 'Oleo Script',
		'Oleo Script Swash Caps, sans-serif' => 'Oleo Script Swash Caps',
		'Open Sans, sans-serif' => 'Open Sans',
		'Open Sans Condensed, sans-serif' => 'Open Sans Condensed',
		'Oranienbaum, sans-serif' => 'Oranienbaum',
		'Orbitron, sans-serif' => 'Orbitron',
		'Oregano, sans-serif' => 'Oregano',
		'Orienta, sans-serif' => 'Orienta',
		'Original Surfer, sans-serif' => 'Original Surfer',
		'Oswald, sans-serif' => 'Oswald',
		'Over the Rainbow, sans-serif' => 'Over the Rainbow',
		'Overlock, sans-serif' => 'Overlock',
		'Overlock SC, sans-serif' => 'Overlock SC',
		'Ovo, sans-serif' => 'Ovo',
		'Oxygen, sans-serif' => 'Oxygen',
		'Oxygen Mono, sans-serif' => 'Oxygen Mono',
		'PT Mono, sans-serif' => 'PT Mono',
		'PT Sans, sans-serif' => 'PT Sans',
		'PT Sans Caption, sans-serif' => 'PT Sans Caption',
		'PT Sans Narrow, sans-serif' => 'PT Sans Narrow',
		'PT Serif, sans-serif' => 'PT Serif',
		'PT Serif Caption, sans-serif' => 'PT Serif Caption',
		'Pacifico, sans-serif' => 'Pacifico',
		'Paprika, sans-serif' => 'Paprika',
		'Parisienne, sans-serif' => 'Parisienne',
		'Passero One, sans-serif' => 'Passero One',
		'Passion One, sans-serif' => 'Passion One',
		'Patrick Hand, sans-serif' => 'Patrick Hand',
		'Patrick Hand SC, sans-serif' => 'Patrick Hand SC',
		'Patua One, sans-serif' => 'Patua One',
		'Paytone One, sans-serif' => 'Paytone One',
		'Peralta, sans-serif' => 'Peralta',
		'Permanent Marker, sans-serif' => 'Permanent Marker',
		'Petit Formal Script, sans-serif' => 'Petit Formal Script',
		'Petrona, sans-serif' => 'Petrona',
		'Philosopher, sans-serif' => 'Philosopher',
		'Piedra, sans-serif' => 'Piedra',
		'Pinyon Script, sans-serif' => 'Pinyon Script',
		'Pirata One, sans-serif' => 'Pirata One',
		'Plaster, sans-serif' => 'Plaster',
		'Play, sans-serif' => 'Play',
		'Playball, sans-serif' => 'Playball',
		'Playfair Display, sans-serif' => 'Playfair Display',
		'Playfair Display SC, sans-serif' => 'Playfair Display SC',
		'Podkova, sans-serif' => 'Podkova',
		'Poiret One, sans-serif' => 'Poiret One',
		'Poller One, sans-serif' => 'Poller One',
		'Poly, sans-serif' => 'Poly',
		'Pompiere, sans-serif' => 'Pompiere',
		'Pontano Sans, sans-serif' => 'Pontano Sans',
		'Port Lligat Sans, sans-serif' => 'Port Lligat Sans',
		'Port Lligat Slab, sans-serif' => 'Port Lligat Slab',
		'Prata, sans-serif' => 'Prata',
		'Preahvihear, sans-serif' => 'Preahvihear',
		'Press Start 2P, sans-serif' => 'Press Start 2P',
		'Princess Sofia, sans-serif' => 'Princess Sofia',
		'Prociono, sans-serif' => 'Prociono',
		'Prosto One, sans-serif' => 'Prosto One',
		'Puritan, sans-serif' => 'Puritan',
		'Purple Purse, sans-serif' => 'Purple Purse',
		'Quando, sans-serif' => 'Quando',
		'Quantico, sans-serif' => 'Quantico',
		'Quattrocento, sans-serif' => 'Quattrocento',
		'Quattrocento Sans, sans-serif' => 'Quattrocento Sans',
		'Questrial, sans-serif' => 'Questrial',
		'Quicksand, sans-serif' => 'Quicksand',
		'Quintessential, sans-serif' => 'Quintessential',
		'Qwigley, sans-serif' => 'Qwigley',
		'Racing Sans One, sans-serif' => 'Racing Sans One',
		'Radley, sans-serif' => 'Radley',
		'Raleway, sans-serif' => 'Raleway',
		'Raleway Dots, sans-serif' => 'Raleway Dots',
		'Rambla, sans-serif' => 'Rambla',
		'Rammetto One, sans-serif' => 'Rammetto One',
		'Ranchers, sans-serif' => 'Ranchers',
		'Rancho, sans-serif' => 'Rancho',
		'Rationale, sans-serif' => 'Rationale',
		'Redressed, sans-serif' => 'Redressed',
		'Reenie Beanie, sans-serif' => 'Reenie Beanie',
		'Revalia, sans-serif' => 'Revalia',
		'Ribeye, sans-serif' => 'Ribeye',
		'Ribeye Marrow, sans-serif' => 'Ribeye Marrow',
		'Righteous, sans-serif' => 'Righteous',
		'Risque, sans-serif' => 'Risque',
		'Roboto, sans-serif' => 'Roboto',
		'Roboto Condensed, sans-serif' => 'Roboto Condensed',
		'Rochester, sans-serif' => 'Rochester',
		'Rock Salt, sans-serif' => 'Rock Salt',
		'Rokkitt, sans-serif' => 'Rokkitt',
		'Romanesco, sans-serif' => 'Romanesco',
		'Ropa Sans, sans-serif' => 'Ropa Sans',
		'Rosario, sans-serif' => 'Rosario',
		'Rosarivo, sans-serif' => 'Rosarivo',
		'Rouge Script, sans-serif' => 'Rouge Script',
		'Ruda, sans-serif' => 'Ruda',
		'Rufina, sans-serif' => 'Rufina',
		'Ruge Boogie, sans-serif' => 'Ruge Boogie',
		'Ruluko, sans-serif' => 'Ruluko',
		'Rum Raisin, sans-serif' => 'Rum Raisin',
		'Ruslan Display, sans-serif' => 'Ruslan Display',
		'Russo One, sans-serif' => 'Russo One',
		'Ruthie, sans-serif' => 'Ruthie',
		'Rye, sans-serif' => 'Rye',
		'Sacramento, sans-serif' => 'Sacramento',
		'Sail, sans-serif' => 'Sail',
		'Salsa, sans-serif' => 'Salsa',
		'Sanchez, sans-serif' => 'Sanchez',
		'Sancreek, sans-serif' => 'Sancreek',
		'Sansita One, sans-serif' => 'Sansita One',
		'Sarina, sans-serif' => 'Sarina',
		'Satisfy, sans-serif' => 'Satisfy',
		'Scada, sans-serif' => 'Scada',
		'Schoolbell, sans-serif' => 'Schoolbell',
		'Seaweed Script, sans-serif' => 'Seaweed Script',
		'Sevillana, sans-serif' => 'Sevillana',
		'Seymour One, sans-serif' => 'Seymour One',
		'Shadows Into Light, sans-serif' => 'Shadows Into Light',
		'Shadows Into Light Two, sans-serif' => 'Shadows Into Light Two',
		'Shanti, sans-serif' => 'Shanti',
		'Share, sans-serif' => 'Share',
		'Share Tech, sans-serif' => 'Share Tech',
		'Share Tech Mono, sans-serif' => 'Share Tech Mono',
		'Shojumaru, sans-serif' => 'Shojumaru',
		'Short Stack, sans-serif' => 'Short Stack',
		'Siemreap, sans-serif' => 'Siemreap',
		'Sigmar One, sans-serif' => 'Sigmar One',
		'Signika, sans-serif' => 'Signika',
		'Signika Negative, sans-serif' => 'Signika Negative',
		'Simonetta, sans-serif' => 'Simonetta',
		'Sintony, sans-serif' => 'Sintony',
		'Sirin Stencil, sans-serif' => 'Sirin Stencil',
		'Six Caps, sans-serif' => 'Six Caps',
		'Skranji, sans-serif' => 'Skranji',
		'Slackey, sans-serif' => 'Slackey',
		'Smokum, sans-serif' => 'Smokum',
		'Smythe, sans-serif' => 'Smythe',
		'Sniglet, sans-serif' => 'Sniglet',
		'Snippet, sans-serif' => 'Snippet',
		'Snowburst One, sans-serif' => 'Snowburst One',
		'Sofadi One, sans-serif' => 'Sofadi One',
		'Sofia, sans-serif' => 'Sofia',
		'Sonsie One, sans-serif' => 'Sonsie One',
		'Sorts Mill Goudy, sans-serif' => 'Sorts Mill Goudy',
		'Source Code Pro, sans-serif' => 'Source Code Pro',
		'Source Sans Pro, sans-serif' => 'Source Sans Pro',
		'Special Elite, sans-serif' => 'Special Elite',
		'Spicy Rice, sans-serif' => 'Spicy Rice',
		'Spinnaker, sans-serif' => 'Spinnaker',
		'Spirax, sans-serif' => 'Spirax',
		'Squada One, sans-serif' => 'Squada One',
		'Stalemate, sans-serif' => 'Stalemate',
		'Stalinist One, sans-serif' => 'Stalinist One',
		'Stardos Stencil, sans-serif' => 'Stardos Stencil',
		'Stint Ultra Condensed, sans-serif' => 'Stint Ultra Condensed',
		'Stint Ultra Expanded, sans-serif' => 'Stint Ultra Expanded',
		'Stoke, sans-serif' => 'Stoke',
		'Strait, sans-serif' => 'Strait',
		'Sue Ellen Francisco, sans-serif' => 'Sue Ellen Francisco',
		'Sunshiney, sans-serif' => 'Sunshiney',
		'Supermercado One, sans-serif' => 'Supermercado One',
		'Suwannaphum, sans-serif' => 'Suwannaphum',
		'Swanky and Moo Moo, sans-serif' => 'Swanky and Moo Moo',
		'Syncopate, sans-serif' => 'Syncopate',
		'Tangerine, sans-serif' => 'Tangerine',
		'Taprom, sans-serif' => 'Taprom',
		'Tauri, sans-serif' => 'Tauri',
		'Telex, sans-serif' => 'Telex',
		'Tenor Sans, sans-serif' => 'Tenor Sans',
		'Text Me One, sans-serif' => 'Text Me One',
		'The Girl Next Door, sans-serif' => 'The Girl Next Door',
		'Tienne, sans-serif' => 'Tienne',
		'Tinos, sans-serif' => 'Tinos',
		'Titan One, sans-serif' => 'Titan One',
		'Titillium Web, sans-serif' => 'Titillium Web',
		'Trade Winds, sans-serif' => 'Trade Winds',
		'Trocchi, sans-serif' => 'Trocchi',
		'Trochut, sans-serif' => 'Trochut',
		'Trykker, sans-serif' => 'Trykker',
		'Tulpen One, sans-serif' => 'Tulpen One',
		'Ubuntu, sans-serif' => 'Ubuntu',
		'Ubuntu Condensed, sans-serif' => 'Ubuntu Condensed',
		'Ubuntu Mono, sans-serif' => 'Ubuntu Mono',
		'Ultra, sans-serif' => 'Ultra',
		'Uncial Antiqua, sans-serif' => 'Uncial Antiqua',
		'Underdog, sans-serif' => 'Underdog',
		'Unica One, sans-serif' => 'Unica One',
		'UnifrakturCook, sans-serif' => 'UnifrakturCook',
		'UnifrakturMaguntia, sans-serif' => 'UnifrakturMaguntia',
		'Unkempt, sans-serif' => 'Unkempt',
		'Unlock, sans-serif' => 'Unlock',
		'Unna, sans-serif' => 'Unna',
		'VT323, sans-serif' => 'VT323',
		'Vampiro One, sans-serif' => 'Vampiro One',
		'Varela, sans-serif' => 'Varela',
		'Varela Round, sans-serif' => 'Varela Round',
		'Vast Shadow, sans-serif' => 'Vast Shadow',
		'Vibur, sans-serif' => 'Vibur',
		'Vidaloka, sans-serif' => 'Vidaloka',
		'Viga, sans-serif' => 'Viga',
		'Voces, sans-serif' => 'Voces',
		'Volkhov, sans-serif' => 'Volkhov',
		'Vollkorn, sans-serif' => 'Vollkorn',
		'Voltaire, sans-serif' => 'Voltaire',
		'Waiting for the Sunrise, sans-serif' => 'Waiting for the Sunrise',
		'Wallpoet, sans-serif' => 'Wallpoet',
		'Walter Turncoat, sans-serif' => 'Walter Turncoat',
		'Warnes, sans-serif' => 'Warnes',
		'Wellfleet, sans-serif' => 'Wellfleet',
		'Wendy One, sans-serif' => 'Wendy One',
		'Wire One, sans-serif' => 'Wire One',
		'Yanone Kaffeesatz, sans-serif' => 'Yanone Kaffeesatz',
		'Yellowtail, sans-serif' => 'Yellowtail',
		'Yeseva One, sans-serif' => 'Yeseva One',
		'Yesteryear, sans-serif' => 'Yesteryear',
		'Zeyada, sans-serif' => 'Zeyada'
		);		
	return $fonts;
}


?>
