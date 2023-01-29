var navbar = null;
var navbar_height = -1;
var id_timeout = 0;

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
    },100);
    
    // mette il content (che è absolute) sotto l'header
    $('.content').css('top',($('header').height() + navbar_height) + 'px');
    
    window.onresize = function() {
        
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
            
            // Mette il toggle menu se vanno voci a capo nel menu clone
            checkMenuitemOverflow($);
            
        },100);
    }
    
});
