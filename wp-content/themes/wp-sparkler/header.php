<!DOCTYPE html>
<!-- Sparkler theme. A ZERGE design (http://www.color-theme.com - http://themeforest.net/user/ZERGE) - Proudly powered by WordPress (http://wordpress.org) -->

<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->

<head>
	<?php global $ct_options ?>
	<?php if ( isset( $ct_options['responsive_layout'] ) ) { $responsive_layout = $ct_options['responsive_layout']; } else { $responsive_layout = 1; }; ?>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<?php if ( $responsive_layout ) { ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php } else { ?>
		<meta name="viewport" content="width=1170">
	<?php } ?>

	<?php
	if (isset($_SERVER['HTTP_USER_AGENT']) &&
		(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
		header('X-UA-Compatible: IE=edge,chrome=1');
	?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php ct_get_post_oginfo(); ?>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<?php ct_get_header(); ?>
