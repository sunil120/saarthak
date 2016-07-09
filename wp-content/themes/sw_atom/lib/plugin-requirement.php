<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'ya_register_required_plugins' );
function ya_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => 'Woocommerce', 
            'slug'               => 'woocommerce', 
            'required'           => true, 
			'version'			 => '2.4.8'
        ),
		
		array(
            'name'               => 'SW Testimonial Slider', 
            'slug'               => 'sw-testimonial-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-testimonial-slider.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'SW Partner Slider', 
            'slug'               => 'sw-partner-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-partner-slider.zip', 
            'required'           => true, 
        ),
         array(
            'name'               => 'Revslider', 
            'slug'               => 'revslider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/revslider.zip', 
            'required'           => true, 
        ),
         array(
            'name'               => 'SW Portfolio', 
            'slug'               => 'sw_portfolio', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw_portfolio.zip', 
            'required'           => true, 
        ),
        array(
            'name'               => 'SW Our Team', 
            'slug'               => 'sw_ourteam', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw_ourteam.zip', 
            'required'           => true, 
        ),
		 array(
            'name'               => 'SW Responsive Post Slider', 
            'slug'               => 'sw-responsive-post-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-responsive-post-slider.zip', 
            'required'           => true, 
        ),
		 array(
            'name'               => 'SW Woo Slider', 
            'slug'               => 'sw-woo-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-woo-slider.zip', 
            'required'           => true, 
        ),
		 array(
            'name'               => 'SW Woo Tab Category Slider', 
            'slug'               => 'sw-woo-tab-category-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-woo-tab-category-slider.zip', 
            'required'           => true, 
        ),
		 array(
            'name'               => 'SW Woo Tab Slider', 
            'slug'               => 'sw-woo-tab-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-woo-tab-slider.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'SW Woo Totalsales Slider', 
            'slug'               => 'sw-woo-totalsales-slider', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/sw-woo-totalsales-slider.zip', 
            'required'           => true, 
        ),
		array(
            'name'               => 'Visual Composer', 
            'slug'               => 'js_composer', 
            'source'             => get_stylesheet_directory() . '/lib/plugins/js_composer.zip', 
			'version'			 => '4.8.0.1',
            'required'           => true, 
        ), 		
		array(
            'name'      		 => 'MailChimp for WordPress Lite',
            'slug'     			 => 'mailchimp-for-wp',
            'required' 			 => false,
        ),
		array(
            'name'      		 => 'Contact Form 7',
            'slug'     			 => 'contact-form-7',
            'required' 			 => false,
        ),		
		 array(
            'name'      		 => 'YITH Woocommerce Compare',
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false,
			'version'			 => '2.0.4'
        ),
		 array(
            'name'     			 => 'YITH Woocommerce Wishlist',
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false,
			'version'			 => '2.0.12'
        ), 
		array(
            'name'     			 => 'Wordpress Seo',
            'slug'      		 => 'wordpress-seo',
            'required'  		 => false,
        ),

    );
    $config = array();

    tgmpa( $plugins, $config );

}
add_action( 'vc_before_init', 'Ya_vcSetAsTheme' );
function Ya_vcSetAsTheme() {
    vc_set_as_theme();
}