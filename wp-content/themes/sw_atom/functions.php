<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( !defined('__THEME__') ){
	// Define helper constants
	$get_theme_name = explode( '/wp-content/themes/', get_template_directory() );
	define( '__THEME__', next($get_theme_name) );
}

/**
 * Variables
 */
require_once (get_template_directory().'/lib/defines.php');
/**
 * Roots includes
 */
require_once (get_template_directory().'/lib/one-click-install/init.php');
require_once (get_template_directory().'/lib/classes.php');		// Utility functions
require_once (get_template_directory().'/lib/utils.php');			// Utility functions
require_once (get_template_directory().'/lib/init.php');			// Initial theme setup and constants
require_once (get_template_directory().'/lib/config.php');		// Configuration
require_once (get_template_directory().'/lib/activation.php');	// Theme activation
require_once (get_template_directory().'/lib/cleanup.php');		// Cleanup
require_once (get_template_directory().'/lib/nav.php');			// Custom nav modifications
require_once (get_template_directory().'/lib/rewrites.php');		// URL rewriting for assets
require_once (get_template_directory().'/lib/htaccess.php');		// HTML5 Boilerplate .htaccess
require_once (get_template_directory().'/lib/widgets.php');		// Sidebars and widgets
require_once (get_template_directory().'/lib/scripts.php');		// Scripts and stylesheets
require_once (get_template_directory().'/lib/customizer.php');	// Custom functions
require_once (get_template_directory().'/lib/shortcodes.php');	// Utility functions
require_once (get_template_directory().'/lib/plugin-requirement.php');			// Custom functions
if( is_plugin_active( 'woocommerce/woocommerce.php' ) ){
	require_once (get_template_directory().'/lib/plugins/currency-converter/currency-converter.php'); // currency converter
	require_once (get_template_directory().'/lib/woocommerce-hook.php');	// Utility functions
}
if( is_plugin_active( 'woocommerce/woocommerce.php' ) && is_plugin_active( 'js_composer/js_composer.php' ) ){
	require_once (get_template_directory().'/lib/visual-map.php');
}
// add image thumbnail latest blog
add_image_size( 'ya-latest-blog', 270, 200, true);
// add image thumbnail latest blog2
add_image_size( 'ya-latest-blog2', 220, 165, true);
// add image thumbnail grid blog
add_image_size( 'ya_grid_blog', 420,250, true);
// add image thumbnail related post
add_image_size( 'ya_related_post', 270,175, true);
// add image thumbnail r
add_image_size( 'ya_popular_post', 100,72, true);
// add image thumbnail r
add_image_size( 'ya_product_thumb', 100,72, true);
// add image blog detail
add_image_size( 'ya_detail_thumb', 870,370, true);
// add image blog detail
add_image_size( 'ya_first_thumb',170,140, true);

function Ya_SearchFilter( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', array( 'post', 'product' ) );
	}
	return $query;
}
add_filter('pre_get_posts','Ya_SearchFilter');
