<?php

/**
 * Articoli
 */
add_shortcode('shortcode_postlist',function () {
	ob_flush();
	ob_start();
    //$result = eval('postlist();');
    //postlist();
    
    include(get_template_directory() . '/components/postlist/postlist.php');
	postlist();
	
    $result = ob_get_contents();
	ob_end_clean();
	return $result;
});

/**
 * #Example CSS snippet
 *
 * This is an example snippet for demonstrating how to add custom CSS code to your website.
 * 
 * You can remove it, or edit it to add your own content.
 */
add_action( 'wp_head', function () { ?>
<style>

	/* write your CSS code here */
	
	/* per capire se sono in portrait o landscape */
	/* con il resize() funziona ma viene falsato se ad es. */
	/* appare la tastiera a video... */
	/* setto width and height con il media screen */
	
	@media screen and (orientation: portrait) {
    	div.device-orientation {
        	width: 100px;
			height: 400px;
		}
	}

	@media screen and (orientation: landscape) {
		div.device-orientation {
        	width: 400px;
			height: 100px;
		}
	}

</style>
<?php } );

/**
 * #Example JavaScript snippet
 *
 * This is an example snippet for demonstrating how to add custom JavaScript code to your website.
 * 
 * You can remove it, or edit it to add your own content.
 */
add_action( 'wp_head', function () { ?>
<script>

	/* write your JavaScript code here */

</script>
<?php } );

/**
 * Init
 */
add_action('init', 'init_utils', 1);
function init_utils() {
	function mylog($log_content) {
		$logpath = WP_CONTENT_DIR . '/mylog.log';
		$pf = fopen($logpath,'a');
		if($pf !== false) {
			fwrite($pf,"\r\n" . $log_content);
			fclose($pf);
		}
	}

	function mylog_clean() {
		$logpath = WP_CONTENT_DIR . '/mylog.log';
		$pf = fopen($logpath,'w');
		if($pf !== false) {
			fclose($pf);
		}
	}

	function mylog_vardump($log_content) {
		$logpath = WP_CONTENT_DIR . '/mylog.log';
		ob_flush();
		ob_start();
		var_dump($log_content);
		$pf = fopen($logpath,'a');
		if($pf !== false) {
			fwrite($pf,"\r\n" . ob_get_flush());
			fclose($pf);
		}
	}
	
	function current_location() {
		if(isset($_SERVER['HTTPS']) &&
			($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
			$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$protocol = 'https://';
		}else {
			$protocol = 'http://';
		}
		return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	// funzione che stampa la lista degli articoli del sito
	/*include(get_template_directory() . '/components/postlist/postlist.php');*/
	
	//function postlist() {
  /*$big = 989889989;
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  $args = array('post_type' => 'post','posts_per_page' => 2,'paged' => $paged);
  $post_query = new WP_Query($args);
  if($post_query->have_posts() ) { ?>
<nav class="pagination">
     <span>Pagine</span>
     <?php
     echo paginate_links( array(
          'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $post_query->max_num_pages,
          'prev_text' => '«',
          'next_text' => '»'
     ) );
?>
</nav>
<?php
    while($post_query->have_posts() ) {
      $post_query->the_post(); ?>
      <div style="margin-top:20px; margin-bottom:20px;">
        <div style="float:left; margin-right:20px;"><a href="<?php echo get_permalink(); ?>"><img style="width:150px; height:150px;" src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ); ?>" /></a></div>
        <div style="float-left;" class="postlist-item-items">
           <div style="height:150px; display: flex; flex-direction: column; justify-content: center; ">
             <h2 style="margin:0px; padding:0px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;" class="postlist-text"><?php the_title(); ?></h2>
             <h2 style="margin:0px; padding:0px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;" class="postlist-text">By&nbsp;<?php the_author(); ?></h2>
             <h2 style="margin:0px; padding:0px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis;" class="postlist-text"><?php echo get_the_date(); ?></h2>
           </div>
        </div>
        <div style="clear:both;"></div>
      </div>
<?php
    }		
	}
		wp_reset_postdata();*/
	//}
}

/**
 * #JavaScript in html head
 */
add_action( 'wp_head', function () {
	
	$current_url = '\'var current_url = ' . '"' . current_location() . '";\'';
	$is_mobile = '\'var is_mobile = ' . '"' . wp_is_mobile() . '";\'';
	$current_username = '';
	$current_user = wp_get_current_user();
	$user_info = get_userdata($current_user->ID);
	if($current_user->ID != 0)
		$current_username = $user_info->user_login;
	$current_username = '\'var current_username = ' . '"' . $current_username . '";\'';
	
?>
	<script type="text/javascript" >
		
		eval(<?php echo $current_url; ?>);
		eval(<?php echo $is_mobile; ?>);
		eval(<?php echo $current_username; ?>);
		
		// array parametri chiamate in sequenza set_php_session_search_results_current_page()
		// per evitare il problema delle chiamate ajax in sequenza troppo ravvicinate
		// vedi set_php_session_search_results_current_page.js
		//var set_php_session_search_results_current_page_array = [];
		// per lo slider con i video, se è fullscreen non ricarico la pagina anche dopo un cambio di orientation
		var video_fullscreen = false;
		
		jQuery.noConflict();
		jQuery(document).ready(function($) {
			
			//alert($('span.av-svg-icon-search').css('url'));
			
			// per il check dell'orientation del dispositivo, purtroppo con la tastiera a video
			// lancia il resize() e falsa il calcolo per capire se siamo in portrait o landscape
			// uso un <div> alla cui classe setto width ed height (vedi action wp_head css) con dei valori
			// coerenti all'orientation
			//$('body').append('<div id="check_device_orientation" class="device-orientation" style="display:none;"></div>');
			/* // interessant uso dei data-xxxxxx
			$('body').attr('data-height',winW);
                $('body').attr('data-width',winH);
                MobileOrientation = 'landscape';    
                $('body').attr('data-orientation','landscape'); 
			*/
			
			// se l'utente è "Default" non visualizza/permette di commentare
			/*if(current_username == 'Default') {
				$('section.show-comments-area').remove();
			}*/
			
			// modifiche al layout: non posso/dovrei modificare il @media screen
			// di questo layout, allora vedo se st asettando a 50% del div contenitore
			// che è poco vorrei l'immagine un pò più grande, tipo al 60%
			var width_calculated = $('.header-logo').width(); // purtroppo NON restituisce la precentuale, lo calcolo
			// this will return parent element's width which also can be replaced with document to get viewport width
			var parentWidth = $('.header-logo').offsetParent().width();
			// percentuale con un certo margine di approssimazione
			var percent = Math.ceil(100 * width_calculated / parentWidth);
			// si avvicina con un certo margine a 50%, tento di cambiarlo
			if(Math.abs(50 - percent) <= 5)
				$('.header-logo').css('width','60%').css('max-width','60%');
			
			// modifiche al layout (master slider)
			//$(document).on('click',function(e) {
				if($('div.master-slider').length > 0) {
					
					$('div.master-slider').on('click',function() {
						if($('div.ms-vcbtn-txt').html() == 'Close video')
							$('div.ms-vcbtn-txt').html('Chiudi video');
					});
					
					//if($('div.ms-vcbtn-txt').html() == 'Close video')
						//$('div.ms-vcbtn-txt').html('Chiudi video');
					
					// non ricarica il sito se sono a fullscreen con il player video
					//document.addEventListener("fullscreenchange", function() {
					$(document).on("fullscreenchange", function() {
					  video_fullscreen = !video_fullscreen;
					  if(!video_fullscreen) location.reload();
					  //console.log('fullscreenchange -> fullscreen -> ' + video_fullscreen);
					  //setTimeout(function() { alert(video_fullscreen); },1500);
					});

					//document.addEventListener("mozfullscreenchange", function() {
					$(document).on("mozfullscreenchange", function() {
					  video_fullscreen = !video_fullscreen;
					  if(!video_fullscreen) location.reload();
					  //setTimeout(function() { alert(video_fullscreen); },1500);
					});

					//document.addEventListener("webkitfullscreenchange", function() {
					$(document).on("webkitfullscreenchange", function() {
					  video_fullscreen = !video_fullscreen;
					  if(!video_fullscreen) location.reload();
					  //setTimeout(function() { alert(video_fullscreen); },1500);
					});

					//document.addEventListener("msfullscreenchange", function() {
					$(document).on("msfullscreenchange", function() {
					  video_fullscreen = !video_fullscreen;
					  if(!video_fullscreen) location.reload();
					  //setTimeout(function() { alert(video_fullscreen); },1500);
					});					
				}
			//});
			
			//$(document).on('click',function(e) {
			
			//alert($('.ms-slide-video').length);
				
			/*setTimeout(function() {
					var div_left = Math.floor($('.master-slider').position().left);
					var div_top = Math.floor($('.master-slider').position().top);
					var div_width = Math.floor($('.master-slider').width());
					var div_height = Math.floor($('.master-slider').height());
					//alert(div_left + 'x' + div_top + ' ' + div_width + 'x' + div_height);
				
					$('.master-slider-parent').wrap('<div class="playercover" style="position:relative; left: ' + div_left + 'px; top: ' + div_top + 'px; width: ' + div_width + 'px; height: ' + div_height + 'px;"></div>');
					
					$('div.playercover').on('click',function() {
						alert();
						var _this = this;
						alert($(this).position().left + ',' + $(this).position().top + ' ' + $(this).width() + 'x' + $(this).height());
						$('iframe.ms-slide-video').wrap('<div class="playercover"></div>');
						//setTimeout(function() {
							//$('iframe.ms-slide-video').playVideo();
							//alert($(_this).position().left + ',' + $(_this).position().top + ' ' + $(_this).width() + 'x' + $(_this).height());
						//},2000);
					});
				},1000);*/
			//});
			
			// modifiche al layout: pulsanti uploader
			/*if($('div#wordpress_file_upload_block_1').length > 0) {
				$('form#uploadform_1').css('width','100%');
				$('div#wordpress_file_upload_form_1,div#wordpress_file_upload_submit_1').wrapAll('<div style="text-align:center;"></div>');
				$('div#wordpress_file_upload_form_1').css('width','50%');
				$('input#input_1').css('margin-right','0%').css('width','99%');
				$('div#wordpress_file_upload_submit_1').css('width','50%');
				$('input#upload_1').css('width','99%');
				
				//$('div#wordpress_file_upload_progressbar_1').css('display','');
				//$('div#wfu_messageblock_header_1_safecontainer').css('display','');
				
				// tolgo il padding destro sinistro dalla larghezza
				var progress_bar_padding_delta = (parseInt($('div#progressbar_1_outer').css('padding-left')) * 2);
				
				$('div#wordpress_file_upload_progressbar_1').width($('div#wordpress_file_upload_textbox_1').width());
				$('div#progressbar_1').width($('div#wordpress_file_upload_progressbar_1').width());
				$('div#progressbar_1_outer').width($('div#wordpress_file_upload_progressbar_1').width() - progress_bar_padding_delta);
				$('div#progressbar_1_inner').width($('div#wordpress_file_upload_progressbar_1').width() - progress_bar_padding_delta);
				$('div#wordpress_file_upload_message_1').width($('div#wordpress_file_upload_textbox_1').width() + ((progress_bar_padding_delta / 2) - 2));
			}*/
			
			// modifiche al layout: pulsante "crea" o "aggiorna" articolo
			/*if($('form.wpuf-form-add').length != 0) {
				setTimeout(function() {
					if($('input.wpuf-submit-button').length != 0) {
						$('input.wpuf-submit-button').css('float','right').width(
							$('input.textfield').width() - (parseInt($('input.textfield').css('padding-left')) * 2));
						$('li.wpuf-submit').append('<div style="clear:both;"></div>');
					}
					else {
						$('li.wpuf-submit > button').css('float','right').width(
							$('input.textfield').width() - (parseInt($('input.textfield').css('padding-left')) * 2));
						$('li.wpuf-submit').append('<div style="clear:both;"></div>');
					}
				},1000);
			}*/
			
			/*if($('input.wpuf-submit-button').length != 0) {
					$('input.wpuf-submit-button').css('float','right').width(
						$('input.textfield').width() - (parseInt($('input.textfield').css('padding-left')) * 2));
				}
				/*else*/
					/*$('button').width(
						$('input.textfield').width() - (parseInt($('input.textfield').css('padding-left')) * 2))*/		
			//}
			
			// sul resize()...
			//if(!is_mobile) {
				var id_timeout;
				var portrait_mode = 0, landscape_mode = 1;
				var old_mode = (($(window).width() < $(window).height()) ? (portrait_mode) : (landscape_mode));
				// se varia solo l'altezza ma la larghezza è uguale, molto probabilmente sta innescando un resize() la tastiera
				var old_width = $(window).width();
				/*var old_mode =
					((parseInt($('div#check_device_orientation').css('width')) < parseInt($('div#check_device_orientation').css('height')))
					? (portrait_mode) : (landscape_mode));*/
			
				//alert(old_mode);
				
				// purtroppo il check dell'orientation su mobile fallisce se c'è la tastiera
				//alert($('div#check_device_orientation').css('width') + ',' + $('div#check_device_orientation').css('height'));
			
			
				// STICKY
				/*$('div.header-container').prepend('<div id="menu_top" class="main-navigation" style="display:none;" aria-label="Menù header"></div>');
				var consider_scroll = true; // se metto/tolgo elementi riesegue lo scroll()
				$(window).scroll(function() {
					if(!consider_scroll) return; // non continua se appare il menu blu
					if($(window).scrollTop() > 100) {
						if($('p.site-title > a').length <= 0) {
							if($('div.header-logo').is(':visible') && $('nav#site-navigation').is(':visible')) {
								consider_scroll = false;
								$('div.header-logo').hide();
								$('nav#site-navigation').hide();
								$('div#menu_top').append($('ul#menu-mymenu').detach()).show();
								consider_scroll = true;
							}
						}else if($('div#img_custom_logo_padding > a').is(':visible')) {
							consider_scroll = false;
							$('div#img_custom_logo_padding > a').hide();
							consider_scroll = true;
						}
					}else if($('p.site-title > a').length <= 0) {
						if(!$('div.header-logo').is(':visible') && !$('nav#site-navigation').is(':visible')) {
							consider_scroll = false;
							$('div#menu_top').hide();
							$('a#blog_title').after($('ul#menu-mymenu').detach());
							$('div.header-logo').show();
							$('nav#site-navigation').show();
							consider_scroll = true;
						}
					}else if(!$('div#img_custom_logo_padding > a').is(':visible')) {
						consider_scroll = false;
						$('div#img_custom_logo_padding > a').show();
						consider_scroll = true;
					}
				});*/
			
				$(window).resize(function() {
					
					// su mobile non prosegue (aggiorna), prosegue se lancia un resize() da cambiamento
					// portrait/landscape e viceversa ma se ricarico su mobile (che sia portrait o landscape)
					// senza cambiamento orientamento non proseguo. se non è mobile ricarico sempre (desktop)
					if(is_mobile) {
						var cur_mode = (($(window).width() < $(window).height()) ? (portrait_mode) : (landscape_mode));
							//((parseInt($('div#check_device_orientation').css('width')) < parseInt($('div#check_device_orientation').css('height')))
							//? (portrait_mode) : (landscape_mode));
						if(cur_mode == old_mode) return;
						// ok è variato, ma veramente o solo l'altezza? (è apparsa/scomparsa la tastiera)
						// oppure non devo essere in fullscreen con il player video, purtroppo su desktop
						// landscape/portrait è un pò un concetto che dipende da come fa il resize l'utente
						// uso questa logica solo su mobile
						else if($(window).width() != old_width/* && !video_fullscreen*/) {
							old_mode = (($(window).width() < $(window).height()) ? (portrait_mode) : (landscape_mode));
							old_width = $(window).width();
								//((parseInt($('div#check_device_orientation').css('width')) < parseInt($('div#check_device_orientation').css('height')))
								//? (portrait_mode) : (landscape_mode));
						}else return;
						//var cur_mode = (($(window).width() < $(window).height()) ? (portrait_mode) : (landscape_mode));
						//if(cur_mode == old_mode) return;
						//else {
							//old_mode = (($(window).width() < $(window).height()) ? (portrait_mode) : (landscape_mode));
							//alert($(window).width() + ',' + $(window).height());
							//alert(window.innerWidth + ',' + window.innerHeight);
						//}
					}
					
					if($('p.site-title > a').length == 0 && $('img.custom-logo').is(':visible')) {
						$('#blog_title').show();
					}else {
						$('.header-container').before('<div id="img_custom_logo_padding" style="padding:10px 0px 0px 0px;"></div>');
						$('#img_custom_logo_padding').append($('img.custom-logo'));
						if($('p.site-title > a').length == 0) {
							$('div.header-logo.av-hide-mobile').prepend('<p class="site-title"><a href="https://sannaidelavoro.altervista.org/" rel="home">Gommista X</a></p>').show();
						}
						$('#blog_title').hide();
					}
					clearTimeout(id_timeout);
					id_timeout = setTimeout(function() {
						if(!video_fullscreen) {
							location.reload();
						}
					}, 100);
				});
			//}
			// segue...
			//if($('p.site-title > a').length == 0 && $('img.custom-logo').is(':visible')) {
			if(!$('button.menu-toggle').is(':visible')) {
				var search_toogle_html = $('#search-toggle').html();
				$('#search-toggle').remove();
				$('ul#menu-mymenu').append('<li style="cursor:pointer;">' + search_toogle_html + '</li>');
				
				var nav_html_old = $('nav#site-navigation').html();
				var nav_html_new = '<div style="flex-direction:column; width:100%;"><a id="blog_title" href="https://sannaidelavoro.altervista.org/"><h1 style="text-align:center; color:back;">Gommista X<br /></h1></a>' + nav_html_old + '</div>';
				$('nav#site-navigation').html(nav_html_new);
			}else {
				$('.header-container').before('<div id="img_custom_logo_padding" style="padding:10px 0px 0px 0px;"></div>');
				$('#img_custom_logo_padding').append($('img.custom-logo'));
				$('img.custom-logo').wrap('<a href="https://sannaidelavoro.altervista.org/"></a>');
				if($('p.site-title > a').length == 0) {
					$('div.header-logo').prepend('<p class="site-title"><a href="https://sannaidelavoro.altervista.org/" rel="home">Gommista X</a></p>').show();
				}
			}
			
			// non permette di cliccare per ricerca per autore
			/*if($('span.post-author').length != 0) {
				var a_html = [];
				$('a.url.fn.n').each(function() {
					a_html.push($(this).html());
					$(this).remove();
				});
				var a_html_idx = 0;
				$('span.post-author').each(function() {
					$(this).prepend('<span>' + a_html[a_html_idx++] + '</span>');
				});
			}
			// non permette di cliccare per ricerca per data
			if($('span.post-date').length != 0) {
				var a_html = [];
				$('span.post-date > a').each(function() {
					a_html.push($(this).html());
					$(this).remove();
				});
				var a_html_idx = 0;
				$('span.post-date > span.screen-reader-text').each(function() {
					$(this).after('<span>' + a_html[a_html_idx++] + '</span>');
				});
			}
			
			// se sono nella pagina dei risultati della ricerca
			if(current_url.indexOf('/?s') != -1) {
				// pagina corrente 0 per default
				set_php_session_search_results_current_page(0,false);
			}
			
			// cambio i link dei risultati della ricerca per passarmi il numero di pagina in cui si trovano (SOSPESO)
			// provo ad usare la sessione per impratichirmi con l'ajax da wordpress
			if($('span.page-numbers.current').length != 0) {
				var current_page = $($('span.page-numbers.current').get(0)).html();
				set_php_session_search_results_current_page(current_page,false);
			}*/
			
			// qui entro in edit la prima volta, MA ci entro anche se riclicco su "update"
			// le successive volte. ne devo tener conto, altrimenti mette l'hidden sempre a false
			/*if($("input[name='action_is_edit']").val() !== undefined) {
				if((current_url.search('pid=') != -1 && current_url.search('action=edit') != -1) ||
				  (current_url.search('pid=') != -1 && current_url.search('msg=post_updated') != -1)) {
					
					$("input[type=submit]").replaceWith('<button>Aggiorna</button>');
					$("form.wpuf-form-add.wpuf-form-layout1.wpuf-theme-style").on('submit',function(e) { e.preventDefault(); });
					
					$('button').on('click',function(e) {
						e.preventDefault();
						$("input[name='action_is_edit']").val('true');
						$("form.wpuf-form-add.wpuf-form-layout1.wpuf-theme-style").submit();
					});
					
				}else {
					$("input[name='action_is_edit']").val('false');
				}
			}*/
			
			// il parametro -1 è farlocco, è solo per dargli un parametro e
			// poi true per eseguire la sequenza (secondo parametro)
			/*if(set_php_session_search_results_current_page_array.length > 0)
				set_php_session_search_results_current_page(-1,true);
			else
				// rimette i pointer-events che avrebbe rimesso set_php_session_search_results_current_page()
				// alla fine delle chiamate, ma se non parte la sequenza delle chiamate (array vuoto ovviamente
				// se mi trovo al di fuori di (url) -> /?s, risultati della ricerca)
				$('div.av-page').css('pointer-events','all');*/
			
		});
	</script>

<?php });

/**
 * #Order snippets by name
 *
 * Order snippets by name by default in the snippets table.
 */
add_filter( 'code_snippets/list_table/default_orderby', function () {
	return 'name';
} );

/**
 * Wp head
 */
add_action( 'wp_head', function () {
?>
	<script type="text/javascript" >
		
		var navbar = null;
		//var menulastitem = null;
		//var mediaq = null;
		//var menutoggle_left = -1;
		var sticky = -1;
		var navbar_height = -1;
		var id_timeout = 0;
		
		// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
		function stickyMenu($) {
			// SE COMMENTI ONRESIZE COMMENTA QUESTO
			/*if(navbar.classList.contains("responsive"))
				navbar.classList.remove("responsive");
			else if(navbar.classList.contains("responsive-sticky"))
				navbar.classList.remove("responsive-sticky");*/
			
			if(window.pageYOffset >= sticky) {
				if(!navbar.classList.contains("sticky")) {
					navbar.classList.add("sticky");
					// SE COMMENTI ONRESIZE DECOMMENTA QUESTO
					/*if(navbar.classList.contains("responsive")) {
						navbar.classList.remove("responsive");
						navbar.classList.add("responsive-sticky");
					}*/
				}
			}else {
				if(navbar.classList.contains("sticky")) {
					navbar.classList.remove("sticky");
					// SE COMMENTI ONRESIZE DECOMMENTA QUESTO
					/*if(navbar.classList.contains("responsive-sticky")) {
						navbar.classList.remove("responsive-sticky");
						navbar.classList.add("responsive");
					}*/
				}
			}
		}
		
		/*function checkMenuitemOverflow($) {
			//if(!$('a.icon').is(':visible')) {
			if(mediaq.innerHTML == '') {
				if(menulastitem.offsetTop > navbar.offsetTop) {
					//menulastitem.innerHTML = 'O ' + menulastitem.offsetTop + ' ' + navbar.offsetTop;
					//mediaq.innerHTML = 'a#menulastitem { background-color: blue; }';
					mediaq.innerHTML = '.topnav a:not(:first-child) { display: none; } .topnav a.icon { float: right; display: block; } .topnav.responsive { position: relative; }  .topnav.responsive a.icon { position: absolute; right: 0; top: 0; } .topnav.responsive a { float: none; display: block; text-align: left; } .topnav.responsive-sticky { position: fixed; width: 100%; } .topnav.responsive-sticky a.icon { position: absolute; right: 0; top: 0; } .topnav.responsive-sticky a { float: none; display: block; text-align: left; }';
					menutoggle_left = $('a.icon').position().left;
					//console.log('memorizzo menutoggle_left: ' + menutoggle_left);
				}//else {
					//var boundingCRect = menulastitem.getBoundingClientRect();
					//menulastitem.innerHTML = 'P ' + menulastitem.offsetTop + ' ' + navbar.offsetTop;
					//mediaq.innerHTML = 'a#menulastitem { background-color: #333; }';
					//mediaq.innerHTML = '';
				//}
			}else if($('a.icon').position().left > menutoggle_left) {
				//console.log('$(\'a.icon\').position().left ' + $('a.icon').position().left + ' menutoggle_left: ' + menutoggle_left);
				mediaq.innerHTML = '';
				// potrebbe, togliendo le classi topnav, rimettere a capo l'ultimo menu item, rifaccio il controllo
				if(menulastitem.offsetTop > navbar.offsetTop) {
					//menulastitem.innerHTML = 'O ' + menulastitem.offsetTop + ' ' + navbar.offsetTop;
					//mediaq.innerHTML = 'a#menulastitem { background-color: blue; }';
					mediaq.innerHTML = '.topnav a:not(:first-child) { display: none; } .topnav a.icon { float: right; display: block; } .topnav.responsive { position: relative; }  .topnav.responsive a.icon { position: absolute; right: 0; top: 0; } .topnav.responsive a { float: none; display: block; text-align: left; } .topnav.responsive-sticky { position: fixed; width: 100%; } .topnav.responsive-sticky a.icon { position: absolute; right: 0; top: 0; } .topnav.responsive-sticky a { float: none; display: block; text-align: left; }';
					menutoggle_left = $('a.icon').position().left;
					console.log('memorizzo menutoggle_left: ' + menutoggle_left);
				}
			}
			//}else if(window.matchMedia('(min-width: 601px)').matches && menulastitem.offsetTop <= navbar.offsetTop) {
			//	mediaq.innerHTML = '';
			//}
		}*/
		
		// OK...
		/*function checkMenuitemOverflow($) {
			
			// a max-width: 600px devo rispettare la media query, se proseguo la "sovrascrivo"
			if(window.matchMedia('(max-width: 600px)').matches) {
				// inoltre metto visibile l'hamburger perchè metto tutto
				// invisibile (ad es. nel ready()) tranne "home", e nel resize()
				if(!$('.topnav > a.icon').is(':visible'))
					$('.topnav > a.icon').show();
				return;
			}
			
			var a_hidden_ids = [];
			var found_overflow = false;
			$('.topnav > a:not(:first-child)').hide();
			$('.topnav > a:not(:first-child):not(:last-child)').each(function() {
				if(!a_hidden_ids.includes($(this).attr('id'))) {
					$(this).show();
				}
				if($('.topnav').height() > navbar_height) {
					found_overflow = true;
					// deve nascondere solo quelli che fanno andare a "capo" il menu
					$($('.topnav > a:not(:first-child):not(:last-child)').get().reverse()).each(function() {
						$(this).hide();
						a_hidden_ids.push($(this).attr('id'));
						if($('.topnav').height() <= navbar_height)
							return false;
					});
				}
			});
			
			// dopo aver messo a posto il menu, se c'è un overflow metto l'hamburger.
			// Ovviamente potrebbe andare a capo, provo a togliere voci di menu in caso,
			// sino a quando non risulta sulla stessa riga
			if(found_overflow) {
				$('.topnav > a.icon').show();
				if($('.topnav').height() > navbar_height) {
					$($('.topnav > a:not(:first-child):not(:last-child)').get().reverse()).each(function() {
						$(this).hide();
						if($('.topnav').height() <= navbar_height)
							return false;
					});
				}
			}
			
		}*/

		// usa il div clone del menu che non è però overflow:hidden
		// e contiene i menu item, ma in questo caso vano "a capo"
		// se vanno a capo mostro l'hamburger, altrimenti lo nascondo
		function checkMenuitemOverflow($) {
			// non controllo se sono in media query 600px,
			// in tal caso li nasconde tutti e mostra l'hamburger
			if(!window.matchMedia('(max-width: 600px)').matches) {
				// controlla se sono andato a capo
				if($('.topnav-clone').height() <= navbar_height)
					$('.topnav a.icon').hide();
				else
					$('.topnav a.icon').show();
			}else
				$('.topnav a.icon').show();
		}
		
		jQuery.noConflict();
		jQuery(document).ready(function($) {
			
			// Get the navbar
			navbar = document.getElementById("myTopnav");
			
			// Get menu last item
			//menulastitem = document.getElementById("menulastitem");
			
			// Get dynamic <style>
			//mediaq = document.getElementById("mediaq600");
			
			// Get the offset position of the navbar
			sticky = navbar.offsetTop;

			// Nasconde tutte le voci di menu tranne la prima per
			// calcolare l'altezza del menu, la uso quando faccio
			// il check dell'overflow e nascondo le opportune voci
			// di menu
			$('.topnav a:not(:first-child)').hide();
			navbar_height = $('.topnav').height();
			$('.topnav').height(navbar_height); // il div genitore
			$('#menuitems').height(navbar_height); // il div sotto, contenitore float left
			// se sta eseguendo la media query 600px non devo mostrare le voci di menu
			if(!window.matchMedia('(max-width: 600px)').matches)
				$('.topnav a:not(:first-child)').show();
			
			// Nasconde le voci di menu in overflow e mette il toggle
			// menu se l'ultima voce di menu va a capo. ATTENZIONE
			// alcune volte nel reload e quindi in ready() potrebbe
			// mettere temporaneamente la scrollbar verticale che,
			// prima è presente e riduce la larghezza del menu facendo
			// sparire l'ultima voce, che NON riappare una volta che si
			// è assestato il tutto ed è sparita la scrollbar.
			// Aspetto un minimo in modo che eventualmente sparisca
			// e solo in quell'attimo faccio partire la funzione che
			// regola il menu
			setTimeout(function() {
				$('div#menuitems, div#menuitems2').width($(window).width() - $('.topnav a.icon').width() - $('#menuitem1').width());
				checkMenuitemOverflow($);
				//checkMenuitemOverflow($);
				//$('div#topnav_wrapper').css('visibility','visible');
			},100);
			
			// mette il content (che è absolute) sotto l'header
			$('.content').css('top',($('header').height() + navbar_height) + 'px');
			
			// When the user scrolls the page, execute function
			window.onscroll = function() {
				//stickyMenu($);
			}
			
			window.onresize = function() {
				// TOGLIE IL MENU APERTO NELL'ONRESIZE PER EVITARE ARTEFATTI
				/*if(navbar.classList.contains("responsive"))
					navbar.classList.remove("responsive");
				else if(navbar.classList.contains("responsive-sticky"))
					navbar.classList.remove("responsive-sticky");*/
				
				id_timeout = setTimeout(function() {
					clearTimeout(id_timeout);
					
					$('div#menuitems, div#menuitems2').width($(window).width() - $('.topnav a.icon').width() - $('#menuitem1').width());
					
					// da 601 in poi li mostro tutti, a parte quelli in overflow
					if(!window.matchMedia('(max-width: 600px)').matches) {
						$('.topnav a:not(:first-child)').show();
						$('.topnav-clone a:not(:first-child)').show();
					}
					
					// a volte va a capo l'hamburger, controllo
					if($('.topnav a.icon').position().top > navbar.offsetTop) {
						var attempts = 1000;
						while($('.topnav a.icon').position().top > navbar.offsetTop && attempts-- > 0) {
							$('div#menuitems').width($(window).width() - $('.topnav a.icon').width() - $('#menuitem1').width() - 1);
						}
					}
					// a volte va a capo l'hamburger (idem per la copia), controllo
					/*if($('.topnav-clone a.icon').position().top > navbar2.offsetTop) {
						while($('.topnav-clone a.icon').position().top > navbar2.offsetTop) {
							$('div#menuitems2').width($(window).width() - $('.topnav a.icon').width() - $('#menuitem1').width() - 1);
						}
					}*/
					
					// Mette il toggle menu se vanno voci a capo nel menu clone
					checkMenuitemOverflow($);
					
				},100);
			}
			
		});
	</script>

<?php });

/**
 * Includi stili
 */
function custom_theme_assets_css() {
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
	wp_enqueue_style('style_sidebar', get_template_directory_uri() . '/components/sidebar/css/style.css', array(), filemtime(get_stylesheet_directory() . '/components/sidebar/css/style.css'));
	wp_enqueue_style('style_mainmenu_header', get_template_directory_uri() . '/components/mainmenu/header/css/style.css', array(), filemtime(get_stylesheet_directory() . '/components/mainmenu/header/css/style.css'));
}
add_action( 'wp_enqueue_scripts', 'custom_theme_assets_css' );

/**
 * Admin css
 */
add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css() {
  echo '<style>
  	.editor-styles-wrapper {
		background-color: #E0C647;
	}
	.editor-post-title {
		color: #04AA6D;
	}
  </style>';
}

/**
 * Defines
 */
define('181b_HOME_PAGE','https://sannaidelavoro.altervista.org/');
	define('181b_POST_PAGE','https://sannaidelavoro.altervista.org/articoli/');

/**
 * Includi javascript
 */
function custom_theme_assets_js() {
	wp_enqueue_script('sidebar', get_stylesheet_directory_uri() . '/components/sidebar/js/sidebar.js', array(), filemtime( get_stylesheet_directory() . '/components/sidebar/js/sidebar.js'));
	wp_enqueue_script('mainmenu-header', get_stylesheet_directory_uri() . '/components/mainmenu/header/js/mainmenu.js', array(), filemtime( get_stylesheet_directory() . '/components/mainmenu/header/js/mainmenu.js'));
}
add_action('wp_enqueue_scripts','custom_theme_assets_js');
