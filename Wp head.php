add_action( 'wp_head', function () {
?>
	<script type="text/javascript" >
		
		var navbar = null;
		var sticky = -1;
		
		/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
/*function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}*/		
		function toggleMenu() {
			if(!navbar.classList.contains("sticky")) {
				if(!navbar.classList.contains("responsive")) {
					navbar.classList.add("responsive");
				}else {
					navbar.classList.remove("responsive");
				}
			}else {
				if(!navbar.classList.contains("responsive-sticky")) {
					navbar.classList.add("responsive-sticky");
				}else {
					navbar.classList.remove("responsive-sticky");
				}
			}
		}
		
		// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
		function stickyMenu() {
			if(window.pageYOffset >= sticky) {
				if(!navbar.classList.contains("sticky")) {
					navbar.classList.add("sticky");
					if(navbar.classList.contains("responsive")) {
						navbar.classList.remove("responsive");
						navbar.classList.add("responsive-sticky");
					}
					//console.log("add sticky");
					//console.log(navbar.className);
				}
			}else {
				if(navbar.classList.contains("sticky")) {
					navbar.classList.remove("sticky");
					if(navbar.classList.contains("responsive-sticky")) {
						navbar.classList.remove("responsive-sticky");
						navbar.classList.add("responsive");
					}
					//console.log("remove sticky");
				}
			}
		}
		
		jQuery.noConflict();
		jQuery(document).ready(function($) {
			
			// When the user scrolls the page, execute function
			window.onscroll = function() { stickyMenu() };

			// Get the navbar
			navbar = document.getElementById("myTopnav");

			// Get the offset position of the navbar
			sticky = navbar.offsetTop;
			
		});
	</script>