<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta name="viewport" content="width=device-width, user-scalable=no,
initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">-->
    <title><?php bloginfo( 'name' ); ?></title>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style id="mediaq600"></style>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<!--<div class="header-text-container"><h2 class="header-text">Intestazione del sito</h2></div>-->

<header class="site-header">

	<div class="header-center">
		<div class="header-text-centered"><div class="header-text">Intestazione del sito</div></div>
    </div>
    <!--</div>-->
    
    <!--<div class="header-right">-->
		<!--<div class="header-text-centered"><h2 class="header-text">Studio dentistico "Nessun dolore!"</h2></div>
    </div>-->
	<div style="clear:both;"></div>

    <!--<img id="header-image-left" src="https://sannaidelavoro.altervista.org/wp-content/uploads/2023/01/header_002.jpg" alt="Header image" />-->
    <!--
    <div class="header-left"></div>
    <div class="header-right"></div>
    -->
    <!--<img id="header-image-right" src="https://sannaidelavoro.altervista.org/wp- 
    <!--<img id="header-image-center" src="https://sannaidelavoro.altervista.org/wp-content/uploads/2023/01/2105.i211.005.S.m012.c13.stomatology-dentist-composition-realistic-2-scaled.jpg" alt="Header image" />-->
    <!--
    <div class="header-center">
    	<div class="header-center-centered"><h2 class="header-text">Studio dentistico "Nessun dolore!"</h2></div>
    </div>-->
    <!--<div style="clear:both;"></div>-->
    
    <?php include(dirname(__FILE__) . '/components/mainmenu/header/mainmenu.php'); /*include('mainmenu.php');*/ ?>
    
</header>