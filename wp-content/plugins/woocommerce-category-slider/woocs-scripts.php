<?php
	
function woocs_load_scripts(){
		wp_enqueue_script('woocs-slider-js', plugins_url('js/jquery.bxslider.min.js', __FILE__), array('jquery'));
		wp_enqueue_script('jquery-effects-core');
		wp_enqueue_script('woocs-main-js', plugins_url('js/main.js', __FILE__));
		wp_enqueue_style('woocs-slider-css', plugins_url('styles/jquery.bxslider.css', __FILE__));
		wp_enqueue_style('woocs-main-css', plugins_url('styles/main.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'woocs_load_scripts');

function woocs_load_admin_scripts(){
	wp_enqueue_script('woocs-jscolor-js', plugins_url('js/jscolor/jscolor.js', __FILE__));
	wp_enqueue_script('woocs-backend-js', plugins_url('js/backend.js', __FILE__));
}

add_action('admin_enqueue_scripts', 'woocs_load_admin_scripts');

?>