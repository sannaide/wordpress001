<?php /*session_start();*/ ?>

<?php get_header(); ?>

<?php
	// ok, funziona
    /*echo '<h1>Main page!</h1>';
    echo do_shortcode('[wpgmza id="1"]');*/
?>

    <?php include(dirname(__FILE__) . '/components/sidebar/sidebar.php'); ?>

	<?php /*include('mainmenu.php');*/ ?>
    <?php
    	/*switch(get_the_permalink()) {
        	case POST_PAGE: {
            	include(dirname(__FILE__) . '/components/postlist/postlist.php');
            	break;
            }
        }*/
    ?>

	<!--<div class="topnav" id="myTopnav">
		<a href="http://sannaidelavoro.altervista.org/" class="active">Home</a>
		<a href="https://sannaidelavoro.altervista.org/contatti/">Contatti</a>
		<a href="https://sannaidelavoro.altervista.org/come-raggiungerci/">Come raggiungerci</a>
		<a href="https://sannaidelavoro.altervista.org/dicono-di-noi/">Dicono di noi</a>
		<a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
			<i class="fa fa-bars"></i>
		</a>
	</div>-->
    
<div class="content">

<?php

	/* ok, sono gli stili inclusi di default
	global $wp_styles;
    if($wp_styles->queue) {
		// Print out a list of all the currently enqueued styles
		echo '<pre>', print_r($wp_styles->queue), '</pre>';
    }*/

	$post_id = url_to_postid(current_location());
	if(isset($post_id) && !empty($post_id)) {
		$post = get_post($post_id);
		$post_title = $post->post_title;
        echo '<div class="post-title">' . $post_title . '</div>';
        //ob_flush();
        //ob_start();
		$post_content = apply_filters('the_content',$post->post_content);
        
        //$shortcode_postlist_result = do_shortcode('[shortcode_postlist]');
        //$post_content = str_replace($shortcode_postlist_result,'',$post_content);
        
		//echo do_blocks($post_title);
		//echo '<h2 class="post-title">' . $post_title . '</h2>';
       	echo $post_content;
        //echo ob_get_flush();
	}
    
?>

<?php get_footer(); ?>