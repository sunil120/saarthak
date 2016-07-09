<?php

/*
Plugin Name: WooCommerce Category Slider
Plugin URI: http://gvectors.com/product/woocommerce-category-slider-pro/
Description: This is the best solution to show all subCategory details on a parent Category page. It includes subCategory image, title, description, price chart, number of products, featured products and lots of more information ...
Author: gVectors Team
Author URI: http://gvectors.com
Version: 1.2.0
*/
 
 
 if (!defined('WP_CONTENT_URL'))
    define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if (!defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
if (!defined('WP_PLUGIN_URL'))
    define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
if (!defined('WP_PLUGIN_DIR'))
    define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');

define('WOOCS_FOLDER', dirname(__FILE__) . '/');
define('WOOCS_PATH', WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__)) . '/');

require_once('woocs-scripts.php');
require_once('woocs-options.php');
require_once('woocs-functions.php');

function woocs_activate() {
	
	update_option( 'woocs_version', '1.2.0' );
	
    add_option('woocs_enabled', '1', '', 'yes');
    add_option('woocs_type', '1', '', 'yes');
    add_option('woocs_bgcolor', 'fbfbfb', '', 'yes');

    add_option('woocs_ph_pcats_in_section', 'Product Categories in this Section', '', 'yes');
    add_option('woocs_ph_products', 'Products', '', 'yes');
    add_option('woocs_ph_from', 'From', '', 'yes');
    add_option('woocs_ph_to', 'to', '', 'yes');
	add_option('woocs_ph_all_for', 'to', 'All for', 'yes');
    add_option('woocs_ph_veiw_all_prod', 'View All Products', '', 'yes');

    add_option('woocs_t1_autoslide', '0', '', 'yes');
    add_option('woocs_t2_autoslide', '0', '', 'yes');

    add_option('woocs_t1_pager', '0', '', 'yes');
    add_option('woocs_t2_pager', '0', '', 'yes');

    add_option('woocs_t1_controls', '0', '', 'yes');
    add_option('woocs_t2_controls', '0', '', 'yes');

    add_option('woocs_t1_speed', '500', '', 'yes');
    add_option('woocs_t2_speed', '500', '', 'yes');

    add_option('woocs_t1_title_length', '30', '', 'yes');
    add_option('woocs_t2_title_length', '30', '', 'yes');

    add_option('woocs_t2_numberofrows', '2', '', 'yes');
}

register_activation_hook(__FILE__, 'woocs_activate');

function woocs_shortcode($woocs_atts) {
  
	$woocs_atts = shortcode_atts(array(
        'catid' => '0',
        'type' => '1',
        'bgcolor' => 'fbfbfb',
        'titlelength' => '30',
        'desclength' => '150',
        'pager' => '0',
        'controls' => '0',
        'autoslide' => '0',
        'speed' => '500',
        'numberofrows' => '2',
		'products' => 'all'
            ), $woocs_atts, 'wcslider');

	

    $woocs_catid = $woocs_atts['catid'];
    $woocs_title_length = $woocs_atts['titlelength'];
    $woocs_autoslide = $woocs_atts['autoslide'];
    $woocs_pager = $woocs_atts['pager'];
    $woocs_controls = $woocs_atts['controls'];
    $woocs_speed = $woocs_atts['speed'];
    $woocs_description_length = $woocs_atts['desclength'];
	$woocs_products = $woocs_atts['products'];

    $woocs_type = $woocs_atts['type'];
    
    $woocs_currency = get_woocommerce_currency_symbol();
    $woocs_rownum = $woocs_atts['numberofrows'];

    if ($woocs_controls == 0) {
        wp_enqueue_style('woocs-controls-css', plugins_url('styles/controls.css', __FILE__));
    }

    $woocs_subcats = woocs_subcats_from_parentcat($woocs_catid);
    $woocs_subcat_count = count($woocs_subcats);
	
	if( $woocs_type && $woocs_type < 3 ){
		$woocs_bgcolor = get_option('woocs_bgcolor');
		echo '<style type="text/css">.woocs-head .woocs-head-title{ background:#'.$woocs_bgcolor.'; } .wcs-wrapper{ background:#'.$woocs_bgcolor.'; }  </style>';
    	$woocs_function = 'woocs_type' . $woocs_type;
    	$woocs_function($woocs_autoslide, $woocs_speed, $woocs_pager, $woocs_controls, $woocs_subcats, $woocs_subcat_count, $woocs_currency, $woocs_rownum, $woocs_title_length, $woocs_description_length, $woocs_products);
	}
}

add_shortcode('wcslider', 'woocs_shortcode');

function woocs_show_current_category_children() {
    
	if( function_exists('is_product_category') ){
	
		if (is_product_category()) {
			$woocs_bgcolor = get_option('woocs_bgcolor');
	
			$woocs_t1_title_length = get_option('woocs_t1_title_length');
			$woocs_t2_title_length = get_option('woocs_t2_title_length');
	
			$woocs_t1_autoslide = get_option('woocs_t1_autoslide');
			$woocs_t2_autoslide = get_option('woocs_t2_autoslide');
	
			$woocs_t1_pager = get_option('woocs_t1_pager');
			$woocs_t2_pager = get_option('woocs_t2_pager');
	
			$woocs_t1_controls = get_option('woocs_t1_controls');
			$woocs_t2_controls = get_option('woocs_t2_controls');
	
			$woocs_t1_speed = get_option('woocs_t1_speed');
			$woocs_t2_speed = get_option('woocs_t2_speed');
	
			$woocs_enabled = get_option('woocs_enabled');
	
	
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$t_id = $cat_obj->term_id;
			$term_meta = get_option("taxonomy_$t_id");
			$cterm = intval($term_meta['custom_term_meta']);
			if ($term_meta !== false && $cterm != 9999) {
				$woocs_type = $cterm;
			} else {
				$woocs_type = get_option('woocs_type');
			}
	
			if ($woocs_type == -1) $woocs_enabled = 0;
			$woocs_currency = get_woocommerce_currency_symbol();
	
			if (($woocs_type == 1 && $woocs_t1_controls == 0) || 
				($woocs_type == 2 && $woocs_t2_controls == 0)) {
				wp_register_style('woocs-controls-css', plugins_url('styles/controls.css', __FILE__));
				wp_enqueue_style('woocs-controls-css');
			}
	
			$woocs_subcats = woocs_subcats_from_parentcat();
			$woocs_subcat_count = count($woocs_subcats);
			
			if ($woocs_enabled == 1) {
				if(!empty($woocs_subcats)){
					echo '<style type="text/css">.woocs-head .woocs-head-title{ background:#'.$woocs_bgcolor.'; } .wcs-wrapper{ background:#'.$woocs_bgcolor.'; }  </style>
						  <div class="woocs-head">
								<span class="woocs-head-title">'.get_option('woocs_ph_pcats_in_section').'</span>
						  </div>';
					if ($woocs_type == 1) {
						woocs_type1($woocs_t1_autoslide, $woocs_t1_speed, $woocs_t1_pager, $woocs_t1_controls, $woocs_subcats, $woocs_subcat_count, $woocs_currency, null, $woocs_t1_title_length);
					} elseif ($woocs_type == 2) {
						$woocs_numberofrows = get_option('woocs_t2_numberofrows');
						woocs_type2($woocs_t2_autoslide, $woocs_t2_speed, $woocs_t2_pager, $woocs_t2_controls, $woocs_subcats, $woocs_subcat_count, $woocs_currency, $woocs_numberofrows, $woocs_t2_title_length);
					}
				}
			}
		}
		if (!empty($woocs_subcats)) {
			echo '<div class="woocs-clear"></div><hr class="woocs-hr" />';
		}
	}
}

add_action('woocommerce_before_shop_loop', 'woocs_show_current_category_children');
?>