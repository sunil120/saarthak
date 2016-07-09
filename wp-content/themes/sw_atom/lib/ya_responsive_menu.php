<?php
class Ya_Resmenu{
	function __construct(){
		add_filter( 'wp_nav_menu_args' , array( $this , 'Ya_MenuRes_AdFilter' ), 100 ); 
		add_filter( 'wp_nav_menu_args' , array( $this , 'Ya_MenuRes_Filter' ), 110 );	
		add_action( 'wp_footer', array( $this  , 'Ya_MenuRes_AdScript' ), 110 );	
	}
	function Ya_MenuRes_AdScript(){
		
	}
	function Ya_MenuRes_AdFilter( $args ){
		$args['container'] = false;
		$ya_theme_locate = ya_options()->getCpanelValue( 'menu_location' );
		if ( ( strcmp( $ya_theme_locate, $args['theme_location'] ) == 0 ) ) {	
			if( isset( $args['ya_resmenu'] ) && $args['ya_resmenu'] == true ) {
				return $args;
			}		
			$ResNavMenu = $this->ResNavMenu( $args );
			$args['container'] = '';
			$args['container_class'].= '';	
			$args['menu_class'].= ($args['menu_class'] == '' ? '' : ' ') . 'ya-menures';			
			$args['items_wrap']	= '<ul id="%1$s" class="%2$s">%3$s</ul>'.$ResNavMenu;
		}
		return $args;
	}
	function ResNavMenu( $args ){
		$args['ya_resmenu'] = true;		
		$select = wp_nav_menu( $args );
		return $select;
	}
	function Ya_MenuRes_Filter( $args ){
		//var_dump($args);
		$args['container'] = false;
		$ya_theme_locate = ya_options()->getCpanelValue( 'menu_location' );
		$ya_menu_class = ya_options() -> getCpanelValue( 'menu_visible' );
		if ( ( strcmp( $ya_theme_locate, $args['theme_location'] ) == 0 ) ) {	
			$args['container'] = 'div';
			$args['container_class'].= 'resmenu-container '.$ya_menu_class;
			$args['items_wrap']	= '<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#ResMenu">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button><div id="ResMenu" class="collapse menu-responsive-wrapper"><ul id="%1$s" class="%2$s">%3$s</ul></div>';	
			$args['menu_class'] = 'ya_resmenu';
			$args['walker'] = new YA_ResMenu_Walker();
		}
		return $args;
	}
}
class YA_ResMenu_Walker extends Walker_Nav_Menu {
	function check_current($classes) {
		return preg_match('/(current[-_])|active|dropdown/', $classes);
	}

	function start_lvl(&$output, $depth = 0, $args = array()) {
		$output .= "\n<ul class=\"dropdown-resmenu\">\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		$item_html = '';
		parent::start_el($item_html, $item, $depth, $args);
		if( !$item->is_dropdown && ($depth === 0) ){
			$item_html = str_replace('<a', '<a class="item-link"', $item_html);			
			$item_html = str_replace('</a>', '</a>', $item_html);			
		}
		if ( $item->is_dropdown ) {
			$item_html = str_replace('<a', '<a class="item-link dropdown-toggle"', $item_html);
			$item_html = str_replace('</a>', '</a>', $item_html);
			$item_html .= '<span class="show-dropdown"></span>';
		}
		$output .= $item_html;
	}

	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
		$element->is_dropdown = !empty($children_elements[$element->ID]);
		if ($element->is_dropdown) {			
			$element->classes[] = 'res-dropdown';
		}

		parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
new Ya_Resmenu();