<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function ya_scripts() {	
	$scheme = ya_options()->getCpanelValue('scheme');
	if ($scheme){
		$app_css = get_template_directory_uri() . '/css/app-'.$scheme.'.css';
	} else {
		$app_css = get_template_directory_uri() . '/css/app-default.css';
	}
	wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null);
	wp_register_style('ya_photobox_css', get_template_directory_uri() . '/css/photobox.css', array(), null);	
	wp_register_style('rtl_css', get_template_directory_uri() . '/css/rtl.css', array(), null);
	wp_register_style('yatheme_css', $app_css, array(), null);
    wp_register_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css', array(), null);
	 wp_register_style('respslider_css', get_template_directory_uri() . '/css/slick.css', array(), null);
	wp_register_style('lightbox_css', get_template_directory_uri() . '/css/jquery.fancybox.css', array(), null);
	wp_register_style('animate_css', get_template_directory_uri() . '/css/animate.css', array(), null);
	wp_register_style('yatheme_responsive_css', get_template_directory_uri() . '/css/app-responsive.css', array('yatheme_css'), null);
	/* register script */

	wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', false, null, false);
	wp_register_script('bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
	wp_register_script('bootstrap_responsive_js', get_template_directory_uri() . '/js/responsive-tabs.js', array('jquery'), null, true);
	wp_register_script('gallery_load_js', get_template_directory_uri() . '/js/load-image.min.js', array('bootstrap_js'), null, true);
	wp_register_script('bootstrap_gallery_js', get_template_directory_uri() . '/js/bootstrap-image-gallery.min.js', array('gallery_load_js'), null, true);
    wp_register_script('flexslider_js', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'), null, true);
	wp_register_script('photobox_js', get_template_directory_uri() . '/js/photobox.js', array('jquery'), null, true);
	wp_register_script('plugins_js', get_template_directory_uri() . '/js/plugins.js', array('jquery'), null, true);	
	wp_register_script('lightbox_js', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'), null, true);
    wp_register_script( 'ya_circle_skill', get_template_directory_uri() .'/js/jquery.circliful.min.js',array(), null, true );
    wp_register_script('ya_accordion',get_template_directory_uri().'/js/jquery.accordion.js',array(),null,true);
	wp_register_script('ya_countup',get_template_directory_uri().'/js/jquery.counterup.js',array(),null,true);
	wp_register_script('slick_slider_js',get_template_directory_uri().'/js/slick.min.js',array(),null,true);
	wp_register_script( 'woo_countdown_js', get_template_directory_uri(). '/js/jquery.countdown.min.js',array(), null, true );	
	wp_register_script( 'cloud-zoom', get_template_directory_uri(). '/js/cloud-zoom.1.0.2.min.js',array(), null, true );
	wp_register_script('masonry_js', get_template_directory_uri() . '/js/isotope.js', array(), null, true);
   wp_register_script('number_js', get_template_directory_uri() . '/js/number-polyfill.min.js', array('jquery'), null, true);
   wp_register_script('animate_js', get_template_directory_uri() . '/js/wow.min.js', array(), null, true);
    wp_register_script('quantity_js', get_template_directory_uri() . '/js/wc-quantity-increment.min.js', array('jquery'), null, true);
	wp_register_script('hoverdir',get_template_directory_uri().'/js/jquery.hoverdir.js',array(),null,true);
	wp_register_script('megamenu_js', get_template_directory_uri() . '/js/megamenu.js', array(), null, true);
	wp_register_script('yatheme_js', get_template_directory_uri() . '/js/main.js', array('bootstrap_js', 'plugins_js'), null, true);

	
	
	/* enqueue script & style */
	if ( !is_admin() ){			
		wp_dequeue_style('tabcontent_styles');
		wp_enqueue_style('bootstrap');	
		if( is_rtl() || $ya_direction = 'rtl' ){
			wp_enqueue_style('rtl_css');
		}
		wp_enqueue_script('lightbox_js');
		wp_enqueue_script('lightbox_js');
		wp_enqueue_script('ya_circle_skill');
		wp_enqueue_script('ya_countup');
		wp_enqueue_style('flexslider_css');
		wp_enqueue_style('slick_css');
		wp_enqueue_style('lightbox_css');
		wp_enqueue_style('yatheme_css');
		wp_enqueue_style('animate_css');		
		wp_enqueue_script('flexslider_js');
		wp_enqueue_script('slick');
		wp_enqueue_script('masonry_js');
		wp_enqueue_script('cloud-zoom');
		wp_enqueue_script('number_js');
		wp_enqueue_script('animate_js');
		wp_enqueue_script('quantity_js');
		wp_enqueue_script('hoverdir');
		wp_enqueue_script('bootstrap_responsive_js');
		
		if (ya_options()->getCpanelValue('responsive_support')){
		/*	wp_enqueue_style('bootstrap_responsive_css'); */
			wp_enqueue_style('yatheme_responsive_css');
		}		
		/* is_rtl() && wp_enqueue_style('bootstrap_rtl_css'); */
		/* Load style.css from child theme */
		if (is_child_theme()) {
			wp_enqueue_style('yatheme_child_css', get_stylesheet_uri(), false, null);
		}
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}		
	
	$is_category = is_category() && !is_category('blog');
	if ( !is_admin() ){
		wp_enqueue_script('modernizr');
		wp_enqueue_script('yatheme_js');
	}
	if( ya_options()-> getCpanelValue( 'effect_active' ) == 1 ){ 
		if( is_home() || is_front_page() ){
			wp_enqueue_script('scroll_js');
		}
	}
	if( ya_options()-> getCpanelValue( 'menu_type' ) == 'mega' ){
		wp_enqueue_script('megamenu_js');	
	}
}
add_action('wp_enqueue_scripts', 'ya_scripts', 100);
