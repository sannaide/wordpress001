function custom_theme_assets() {
	//wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), filemtime(get_stylesheet_directory() . '/style.css'));
}

add_action( 'wp_enqueue_scripts', 'custom_theme_assets' );
