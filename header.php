<!DOCTYPE html>
<!--[if lt IE 7]>		<html class="no-js lt-ie9 lt-ie8 lt-ie7">	<![endif]-->
<!--[if IE 7]>			<html class="no-js lt-ie9 lt-ie8">			<![endif]-->
<!--[if IE 8]>			<html class="no-js lt-ie9">					<![endif]-->
<!--[if gt IE 8]><!-->	<html class="no-js">						<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php bloginfo( 'name' ); ?> &mdash; <?php bloginfo( 'description' ); ?></title>
	<meta name="description" content="Projekt Website der alternativen Lösung Durchgangsbahnhof Luzern">
	<meta name="google-site-verification" content="mynUOc8bmMLzsoDW92EBPFrcUP1a_H3YlXJGdW82ySM" />
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/style.css">
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/fancybox/jquery.fancybox.css">
	<?php wp_head(); ?>
</head>
<body id="top">
	<div id="container">
		<header>
			<div id="titlebar">
				<hgroup>
					<h1><?php bloginfo( 'title' ); ?></h1>
					<h2><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
			</div>
			<div class="page clearfix">
				<nav>
					<?php wp_nav_menu( $navigation ); ?>
				</nav>
			</div>
		</header>
		<section>
			<div class="page clearfix">