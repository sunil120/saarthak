<?php
	include(get_template_directory().'/lib/shortcodes/gallery.php');
	include(get_template_directory().'/lib/shortcodes/skills.php');
	function ya_shortcode_css() {
		wp_enqueue_style('yashortcode_css', get_template_directory_uri().'/css/shortcode_admin.css');
	}
	add_action('admin_enqueue_scripts', 'ya_shortcode_css');
class YA_Shortcodes{
	protected $supports = array();

	protected $tags = array( 'icon','youtube video', 'button', 'alert', 'bloginfo', 'colorset', 'slideshow', 'googlemaps', 'tabs', 'collapses', 'columns', 'row', 'col', 'code', 'breadcrumb', 'pricing','tooltip','modal','gallery_image');

	public function __construct(){
		add_action('admin_head', array($this, 'mce_inject') );
		$this->add_shortcodes();
	}

	public function mce_inject(){
		global $typenow;
		// check user permissions
		if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
		return;
		}
			// verify the post type
		if( ! in_array( $typenow, array( 'post', 'page' ) ) )
			return;
		// check if WYSIWYG is enabled
		if ( get_user_option('rich_editing') == 'true') {
			add_filter( 'mce_external_plugins', array($this, 'mce_external_plugins') );
			add_filter( 'mce_buttons', array($this,'mce_buttons') );
		}
	}
	
	public function mce_external_plugins($plugin_array) {
		$wp_version = get_bloginfo( 'version' );
		if ( version_compare( $wp_version, '3.9', '>=' ) ) {
			$plugin_array['ya_shortcodes'] = get_template_directory_uri().'/js/ya_shortcodes_tinymce.js';
		}else{
			$plugin_array['ya_shortcodes'] = get_template_directory_uri().'/js/ya_shortcodes_tinymce_old.js';
		}
		return $plugin_array;
	}
	
	public function mce_buttons($buttons) {
		array_push($buttons, "ya_shortcodes");
		return $buttons;
	}
	
	public function add_shortcodes(){
		if ( is_array($this->tags) && count($this->tags) ){
			foreach ( $this->tags as $tag ){
				add_shortcode($tag, array($this, $tag));
			}
		}
	}
	
	function code($attr, $content) {
		$html = '';
		$html .= '<pre>';
		$html .= $content;
		$html .= '</pre>';
		
		return $html;
	}
	
	function icon( $atts ) {
		
		// Attributes
		extract( shortcode_atts(
			array(
				'tag' => 'span',
				'name' => '*',
				'class' => '',
				'border'=>'',
				'bg'    =>'',
				'color' => ''
			), $atts )
		);
		$attributes = array();
	
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		
		if ( !preg_match('/fa-/', $name) ){
			$name = 'fa-'.$name;
		}
		array_unshift($classes, $name);
		
		$classes = array_unique($classes);
		
		$attributes[] = 'class="fa '.implode(' ', $classes).'"';
		if(!empty($color)&&!empty($bg)&&!empty($border)){
			$attributes[] = 'style="color: '.$color.';background:'.$bg.';border:1px solid '.$border.'"';
		}
		if ( !empty($color) ){
			$attributes[] = 'style="color: '.$color.'"';
		}
		
		// Code
		return "<$tag ".implode(' ', $attributes)."></$tag>";
	}
	
	public function button( $atts, $content = null ){
		// Attributes
		extract( shortcode_atts(
			array(
				'id' => '',
				'tag' => 'span',
				'class' => 'btn',
				'target' => '',
				'type' => 'default',
				'border' =>'',
				'color' =>'',
				'size'	=> '',
				'icon' => '',
				'href' => '#'
			), $atts )
		);
		$attributes = array();
		
		$classes = $class;
		if ( $type != '' ){
			$type = ' btn-'.$type;
		}
		if( $size != '' ){
			$size = 'btn-'.$size;
		}
		$classes .= $type.' '.$size;
		$attributes[] = 'class="'.$classes.'"';
		if ( !empty($id) ){
			$attributes[] = 'id="'.esc_attr($id).'"';
		}
		if ( !empty($target) ){
			if ( 'a' == $tag ){
				$attributes[] = 'target="'.esc_attr($target).'"';
			} else {
				// html5
				$attributes[] = 'data-target="'.esc_attr($target).'"';
			}
		}
		
		if ( 'a' == $tag ){
			$attributes[] = 'href="'.esc_attr($href).'"';
		}
		if( $icon != '' ){
			$icon = '<i class="'.$icon.'"></i>';
		}
		return "<$tag ".implode(' ', $attributes).">".$icon."".do_shortcode($content)."</$tag>";
	}
	
	/**
	 * Alert
	 * */
	public function alert($atts, $content = null ){

		extract(shortcode_atts(array(
				'tag' => 'div',
				'class' => 'block',
				'dismiss' => 'true',
				'icon'  => '',
				'color'	=> '',
				'border' => '',
				'type' => ''
			), $atts)
		);
		
		$attributes = array();
		$attributes[] = $tag;
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		
		if ( !preg_match('/alert-/', $type) ){
			$type = 'alert-'.$type;
		}
		if( $color != '' || $border != '' ){
			$attributes[] .= 'style="color: '.$color.'; border-color:'.$border.'"';
		}
		array_unshift($classes, 'alert', $type);
		$classes = array_unique($classes);
		$attributes[] = 'class="'.implode(' ', $classes).'"';
		
		$html = '';
		$html .= '<'.implode(' ', $attributes).'>';
		if( $icon != '' ){
			$html .= '<i class="'.$icon.'"></i>';
		}
		if ($dismiss == 'true') {
			$html .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		}
		$html .= do_shortcode($content);
		$html .= '</'.$tag.'>';
		return $html;
	}


	/**
	 * Bloginfo
	 * */
	function bloginfo( $atts){
		extract( shortcode_atts(array(
				'show' => 'wpurl',
				'filter' => 'raw'
			), $atts)
		);
		$html = '';
		$html .= get_bloginfo($show, $filter);

		return $html;
	}
	
	function colorset($atts){
		$value = ya_options()->getCpanelValue('scheme'); 
		return $value;
	}
	
	/**
	 * Google Maps
	 */
	function googlemaps($atts, $content = null) {
		extract(shortcode_atts(array(
		"title" => '',
		"location" => '',
		"width" => '', //leave width blank for responsive designs
		"height" => '300',
		"zoom" => 10,
		"align" => '',
		), $atts));

		// load scripts
		wp_enqueue_script('ya_googlemap',  get_template_directory_uri() . '/js/ya_googlemap.js', array('jquery'), '', true);
		wp_enqueue_script('ya_googlemap_api', 'https://maps.googleapis.com/maps/api/js?sensor=false', array('jquery'), null, true);

		$output = '<div id="map_canvas_'.rand(1, 100).'" class="googlemap" style="height:'.$height.'px;width:'.$width.'">';
		$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.esc_attr( $title ).'" />' : '';
		$output .= '<input class="location" type="hidden" value="'.esc_attr( $location ).'" />';
		$output .= '<input class="zoom" type="hidden" value="'.esc_attr( $zoom ).'" />';
		$output .= '<div class="map_canvas"></div>';
		$output .= '</div>';

		return $output;
	}


	/**
	 * Tabs
	 * */
	public function tabs( $atts , $content = null ) {
		static $key = 0;
		
		if (is_array($atts) ) {
				
			foreach ($atts as $k => $att){
				$att = trim($att);
				if (empty($att)) unset( $atts[$k] );
			}
		}
		$yaTab_id = 'yaTab-'.$key;
		extract(shortcode_atts(array(
				'tag' => 'div',
				'class' => 'tabbable',
				'position' => 'top'
			), $atts));
		$atts['id'] = $yaTab_id;
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		array_unshift($classes, 'tabbable');
		
		if ( $position == 'left' ) array_unshift($classes, 'tabs-left');
		elseif ( $position == 'right' ) array_unshift($classes, 'tabs-right');
		elseif ($position == 'bottom') array_unshift($classes, 'tabs-below');
		
		$classes = array_unique($classes);
		$classes = ' class="'.implode(' ', $classes).'"';
		
		$html = '';
		$html .= '<'.$tag.$classes.' id="'.esc_attr( $yaTab_id ).'">';
		$html .= self::get_tab($atts, $content);
		$html .= '</'.$tag.'>';
		$key++;
		
		return $html;
	}
	
	
	protected function get_tab($atts, $content){
		
		if (preg_match_all('/\[(\[?)(tab)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', $content, $m)) {
			$titles = array();
			$contents = array();
			$icons = array();
			for ($i=0; $i<count($m[0]); $i++) {			
				preg_match_all("/title=&#8221;(.*)&[#8243;,#8221;]/iU", $m[3][$i], $output_title);
				preg_match_all("/icon=&#8221;(.*)&#8221;/iU", $m[3][$i], $output_icon);				
				extract(shortcode_atts( array(
									'title' => (count($output_title[1]) > 0 ) ?$output_title[1][0] : '',
									'icon'	=> (count($output_icon[1]) > 0 ) ? $output_icon[1][0] : ''
								), $atts
							)
						);
				$titles[] = $title;				
				$contents[] = $m[5][$i];
				$icons[] = '<i class="'.$icon.'"></i>';
			}
		
			$header = '<ul class="nav nav-tabs responsive">';
			foreach ($titles as $i => $title){
				$class = '';
				if ($i == 0) $class .= ' class="active"';
				$header .= '<li '.$class.'><a data-toggle="tab" href="#'.$atts['id'].$i.'">'.$icons[$i].esc_html( $title ).'</a></li>';
			}
			$header .= '</ul>';
			
			$body = '<div class="tab-content responsive">';
			foreach ($contents as $i => $content){
				$class = 'tab-pane';
				if ($i == 0) $class .= ' active';
				$class = 'class="'.$class.'"';
				$body .= '<div '.$class.' id="'.$atts['id'].$i.'">'.do_shortcode($content).'</div>';
			}
			$body .= '</div>';
			
			$html = '';
			if ($atts['position'] == 'bottom') {
				$html .= $body.$header;
			} else $html .= $header.$body;
		}
		
		return $html;
	}
	
	
	/**
	 * Collapse
	 * */

	public function collapses( $atts, $content = NULL ){
		static $key = 0;

		if (is_array($atts) ) {
				
			foreach ($atts as $k => $att){
				$att = trim($att);
				if (empty($att)) unset( $atts[$k] );
			}
		}

		$collapse_id = 'yaCollapse-'.$key ;
		extract(shortcode_atts(array(
				'class' => '',
				'type' => 'collapse',
				'tag'   => 'div'
			), $atts));
		$atts['id'] = $collapse_id;
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		array_unshift($classes, 'panel-group');
		$classes = array_unique($classes);
		$html = '';
		$html .= '<'.$tag.' id="'.esc_attr( $collapse_id ).'" class="'.implode(' ', $classes).'">';
		$html .= self::get_collapse($atts, $content);
		$html .= '</'.$tag.'>';
		$key++;
		
		return $html;
	}

	function get_collapse( $atts, $content = NULL ) {
		$html = '';
		if (preg_match_all('/\[(\[?)(collapse)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/', $content, $m)) {
			$titles = array();
			$contents = array();
			for ($i=0; $i<count($m[0]); $i++) {			
				preg_match_all("/title=&#8221;(.*)&[#8243;,#8221;]/iU", $m[3][$i], $output_title);
				preg_match_all("/active=&#8221;(.*)&#8221;/iU", $m[3][$i], $output_class);
				extract(shortcode_atts( array(
				                
								'title' => (count($output_title[1]) > 0 ) ?$output_title[1][0] : '',
								'active' => (count($output_class[1]) > 0 ) ?$output_class[1][0] : ''
								
							), $atts
						)
					);
				$content = $m[5][$i];
				$attributes = ($active == 'true') ? 'class="panel-collapse collapse in" data-toggle="collapse" id="'.$atts['id'].$i.'"': 'class="panel-collapse collapse" id="'.$atts['id'].$i.'"';
				$types = ($active == 'true') ? 'class="accordion-toggle ya-accordion" data-toggle="collapse"' : 'class="accordion-toggle ya-accordion collapsed" data-toggle="collapse"';
				$types .= ( $atts['type'] == 'collapse' ) ? ' data-parent="#'.$atts['id'].'"' : '';
				$types .= ' href="#'.$atts['id'].$i.'"';
				$html .= '<div class="panel panel-default">';
				$html .= '<a '.$types.'><span></span><div class="panel-heading">'.esc_html( $title ).'</div></a>';
				$html .= '<div '.$attributes.'>
							<div class="panel-body">
								'.do_shortcode($content).'
							</div>
						</div>';
				$html .= '</div>';
			}
		}
		
		return $html;
	}

	
	/**
	 * Column
	 * */
	public function row( $atts, $content = null ){
		extract( shortcode_atts( array(
			'class' => '',
			'tag'   => 'div',
			'type'  => ''
		), $atts) );
		$row_class = 'row';
		
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		
		array_unshift($classes, $row_class);
		$classes = array_unique($classes);
		$classes = ' class="'. implode(' ', $classes).'"';
		return "<$tag ". $classes . ">" . do_shortcode($content) . "</$tag>";
	}
	
	public function col( $atts, $content = null ){
		extract( shortcode_atts( array(
			'class' 	=> '',
			'tag'   	=> 'div',
			'large'  	=> '12',
			'medium'	=> '12',
			'small'		=> '12',
			'xsmall'	=> '12'
		), $atts) );
		$col_class  = !empty($large)  ? "col-lg-$large"   : 'col-lg-12';
		$col_class .= !empty($medium) ? " col-md-$medium" : ' col-md-12';
		$col_class .= !empty($small)  ? " col-sm-$small"  : ' col-sm-12';
		$col_class .= !empty($xsmall) ? " col-xs-$xsmall" : ' col-xs-12';
		$classes = array();
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		array_unshift($classes, $col_class);
		$classes = array_unique($classes);
		$classes = ' class="'. implode(' ', $classes).'"';
		return "<$tag ". $classes . ">" . do_shortcode($content) . "</$tag>";
	}
	
	public function breadcrumb ($atts){
		
		extract(shortcode_atts(array(
				'class' => 'breadcumbs',
				'tag'  => 'div'
			), $atts));
			
		$classes = preg_split('/[\s,]+/', $class, -1, PREG_SPLIT_NO_EMPTY);
		$classes = ' class="' . implode(' ', $classes) . '" ';
		
		$before = '<' . $tag . $classes . '>';
		$after  = '</' . $tag . '>';
		
		$ya_breadcrumb = new YA_Breadcrumbs;
		return $ya_breadcrumb->breadcrumb( $before, $after, false );
	}
}
new YA_Shortcodes();


/**
 * This class handles the Breadcrumbs generation and display
 */
class YA_Breadcrumbs {

	/**
	 * Wrapper function for the breadcrumb so it can be output for the supported themes.
	 */
	function breadcrumb_output() {
		$this->breadcrumb( '<div class="breadcumbs">', '</div>' );
	}

	/**
	 * Get a term's parents.
	 *
	 * @param object $term Term to get the parents for
	 * @return array
	 */
	function get_term_parents( $term ) {
		$tax     = $term->taxonomy;
		$parents = array();
		while ( $term->parent != 0 ) {
			$term      = get_term( $term->parent, $tax );
			$parents[] = $term;
		}
		return array_reverse( $parents );
	}

	/**
	 * Display or return the full breadcrumb path.
	 *
	 * @param string $before  The prefix for the breadcrumb, usually something like "You're here".
	 * @param string $after   The suffix for the breadcrumb.
	 * @param bool   $display When true, echo the breadcrumb, if not, return it as a string.
	 * @return string
	 */
	function breadcrumb( $before = '', $after = '', $display = true ) {
		$options = array('breadcrumbs-home' => 'Home', 'breadcrumbs-blog-remove' => false, 'post_types-post-maintax' => '0');
		
		global $wp_query, $post;

		$on_front  = get_option( 'show_on_front' );
		$blog_page = get_option( 'page_for_posts' );

		$links = array(
			array(
				'url'  => get_home_url(),
				'text' => ( isset( $options['breadcrumbs-home'] ) && $options['breadcrumbs-home'] != '' ) ? $options['breadcrumbs-home'] : __( 'Home', 'yatheme' )
			)
		);

		if ( ( $on_front == "page" && is_front_page() ) || ( $on_front == "posts" && is_home() ) ) {

		} else if ( $on_front == "page" && is_home() ) {
			$links[] = array( 'id' => $blog_page );
		} else if ( is_singular() ) {
			if ( get_post_type_archive_link( $post->post_type ) ) {
				$links[] = array( 'ptarchive' => $post->post_type );
			}
			
			if ( 0 == $post->post_parent ) {
				if ( isset( $options['post_types-post-maintax'] ) && $options['post_types-post-maintax'] != '0' ) {
					$main_tax = $options['post_types-post-maintax'];
					$terms    = wp_get_object_terms( $post->ID, $main_tax );
					
					if ( count( $terms ) > 0 ) {
						// Let's find the deepest term in this array, by looping through and then unsetting every term that is used as a parent by another one in the array.
						$terms_by_id = array();
						foreach ( $terms as $term ) {
							$terms_by_id[$term->term_id] = $term;
						}
						foreach ( $terms as $term ) {
							unset( $terms_by_id[$term->parent] );
						}

						// As we could still have two subcategories, from different parent categories, let's pick the first.
						reset( $terms_by_id );
						$deepest_term = current( $terms_by_id );

						if ( is_taxonomy_hierarchical( $main_tax ) && $deepest_term->parent != 0 ) {
							foreach ( $this->get_term_parents( $deepest_term ) as $parent_term ) {
								$links[] = array( 'term' => $parent_term );
							}
						}
						$links[] = array( 'term' => $deepest_term );
					}

				}
			} else {
				if ( isset( $post->ancestors ) ) {
					if ( is_array( $post->ancestors ) )
						$ancestors = array_values( $post->ancestors );
					else
						$ancestors = array( $post->ancestors );
				} else {
					$ancestors = array( $post->post_parent );
				}

				// Reverse the order so it's oldest to newest
				$ancestors = array_reverse( $ancestors );

				foreach ( $ancestors as $ancestor ) {
					$links[] = array( 'id' => $ancestor );
				}
			}
			$links[] = array( 'id' => $post->ID );
		} else {
			if ( is_post_type_archive() ) {
				$links[] = array( 'ptarchive' => get_post_type() );
			} else if ( is_tax() || is_tag() || is_category() ) {
				$term = $wp_query->get_queried_object();

				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent != 0 ) {
					foreach ( $this->get_term_parents( $term ) as $parent_term ) {
						$links[] = array( 'term' => $parent_term );
					}
				}

				$links[] = array( 'term' => $term );
			} else if ( is_date() ) {
				$bc = __( 'Archives for', 'yatheme' );
				
				if ( is_day() ) {
					global $wp_locale;
					$links[] = array(
						'url'  => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
						'text' => $wp_locale->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' )
					);
					$links[] = array( 'text' => $bc . " " . get_the_date() );
				} else if ( is_month() ) {
					$links[] = array( 'text' => $bc . " " . single_month_title( ' ', false ) );
				} else if ( is_year() ) {
					$links[] = array( 'text' => $bc . " " . get_query_var( 'year' ) );
				}
			} elseif ( is_author() ) {
				$bc = __( 'Archives for', 'yatheme' );
				$user    = $wp_query->get_queried_object();
				$links[] = array( 'text' => $bc . " " . esc_html( $user->display_name ) );
			} elseif ( is_search() ) {
				$bc = __( 'You searched for', 'yatheme' );
				$links[] = array( 'text' => $bc . ' "' . esc_html( get_search_query() ) . '"' );
			} elseif ( is_404() ) {
				$crumb404 = __( 'Error 404: Page not found', 'yatheme' );
				$links[] = array( 'text' => $crumb404 );
			}
		}
		
		$output = $this->create_breadcrumbs_string( $links );

		if ( $display ) {
			echo $before . $output . $after;
			return true;
		} else {
			return $before . $output . $after;
		}
	}

	/**
	 * Take the links array and return a full breadcrumb string.
	 *
	 * Each element of the links array can either have one of these keys:
	 *       "id"            for post types;
	 *    "ptarchive"  for a post type archive;
	 *    "term"         for a taxonomy term.
	 * If either of these 3 are set, the url and text are retrieved. If not, url and text have to be set.
	 *
	 * @link http://support.google.com/webmasters/bin/answer.py?hl=en&answer=185417 Google documentation on RDFA
	 *
	 * @param array  $links   The links that should be contained in the breadcrumb.
	 * @param string $wrapper The wrapping element for the entire breadcrumb path.
	 * @param string $element The wrapping element for each individual link.
	 * @return string
	 */
	function create_breadcrumbs_string( $links, $wrapper = 'ul', $element = 'li' ) {
		global $paged;
		
		$output = '';

		foreach ( $links as $i => $link ) {

			if ( isset( $link['id'] ) ) {
				$link['url']  = get_permalink( $link['id'] );
				$link['text'] = strip_tags( get_the_title( $link['id'] ) );
			}

			if ( isset( $link['term'] ) ) {
				$link['url']  = get_term_link( $link['term'] );
				$link['text'] = $link['term']->name;
			}

			if ( isset( $link['ptarchive'] ) ) {
				$post_type_obj = get_post_type_object( $link['ptarchive'] );
				$archive_title = $post_type_obj->labels->menu_name;
				$link['url']  = get_post_type_archive_link( $link['ptarchive'] );
				$link['text'] = $archive_title;
			}
			
			$link_class = '';
			if ( isset( $link['url'] ) && ( $i < ( count( $links ) - 1 ) || $paged ) ) {
				$link_output = '<a href="' . esc_url( $link['url'] ) . '" >' . esc_html( $link['text'] ) . '</a><span class="divider"></span>';
			} else {
				$link_class = ' class="active" ';
				$link_output = '<span>' . esc_html( $link['text'] ) . '</span>';
			}
			
			$element = esc_attr(  $element );
			$element_output = '<' . $element . $link_class . '>' . $link_output . '</' . $element . '>';
			
			$output .=  $element_output;
			
			$class = ' class="breadcrumb" ';
		}

		return '<' . $wrapper . $class . '>' . $output . '</' . $wrapper . '>';
	}

}

global $yabreadcrumb;
$yabreadcrumb = new YA_Breadcrumbs();

if ( !function_exists( 'ya_breadcrumb' ) ) {
	/**
	 * Template tag for breadcrumbs.
	 *
	 * @param string $before  What to show before the breadcrumb.
	 * @param string $after   What to show after the breadcrumb.
	 * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
	 * @return string
	 */
	function ya_breadcrumb( $before = '', $after = '', $display = true ) {
		global $yabreadcrumb;
		return $yabreadcrumb->breadcrumb( $before, $after, $display );
	}
}

/*
 * Pricing Table
 * @since v1.0
 *
 */
 
/*main*/
if( !function_exists('ya_pricing_table_shortcode') ) {
	function ya_pricing_table_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'style' => 'style1',
		), $atts ) );
		
	   return '<div class="pricing-table clearfix '.$style.'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode( 'pricing_table', 'ya_pricing_table_shortcode' );
}

/*section*/
if( !function_exists('ya_pricing_shortcode') ) {
	function ya_pricing_shortcode( $atts, $content = null, $style_table) {
		
		extract( shortcode_atts( array(
			'style' =>'style1',
			'size' => 'one-five',
			'featured' => 'no',
			'description'=>'',
			'plan' => '',
			'cost' => '$20',
			'currency'=>'',
			'per' => 'month',
			'button_url' => '',
			'button_text' => 'Purchase',
			'button_target' => 'self',
			'button_rel' => 'nofollow'
		), $atts ) );
		
		//set variables
		$featured_pricing = ( $featured == 'yes' ) ? 'most-popular' : NULL;
		
		//start content1  
		$pricing_content1 ='';
		$pricing_content1 .= '<div class="pricing pricing-'. $size .' '. $featured_pricing . '">';
				$pricing_content1 .= '<div class="header">'. esc_html( $plan ). '</div>';
				$pricing_content1 .= '<div class="price">'. esc_html( $cost ) .'/'. esc_html( $per ) .'</div>';
			$pricing_content1 .= '<div class="pricing-content">';
				$pricing_content1 .= ''. $content. '';
			$pricing_content1 .= '</div>';
			if( $button_url ) {
				$pricing_content1 .= '<a href="'. esc_url( $button_url ) .'" class="signup" target="_'. esc_attr( $button_target ).'" rel="'. esc_attr( $button_rel ) .'" '.'>'. esc_html( $button_text ) .'</a>';
			}
		$pricing_content1 .= '</div>';
		//start content2  
		$pricing_content2 ='';
		$pricing_content2 .= '<div class="pricing pricing-'. $size .' '. $featured_pricing . '">';
			$pricing_content2 .= '<div class="header"><h3>'. esc_html( $plan ). '</h3><span>'.esc_html( $description ).'</span></div>';
				
			$pricing_content2 .= '<div class="pricing-content">';
				$pricing_content2 .= ''. $content. '';
			$pricing_content2 .= '</div>';
			$pricing_content2 .= '<div class="price"><span class="span-1"><p>'.$currency.'</p>'. esc_html( $cost ) .'</span><span class="span-2">'. esc_html( $per ) .'</span></div>';
			if( $button_url ) {
				$pricing_content2 .= '<div class="plan"><a href="'. esc_url( $button_url ) .'" class="signup" target="_'. esc_attr( $button_target ) .'" rel="'. esc_attr( $button_rel ) .'" '.'>'. esc_html( $button_text ) .'</a></div>';
			}
		$pricing_content2 .= '</div>';
		//start basic
		$pricing_content4 ='';
		$pricing_content4 .= '<div class="pricing pricing-'. $size .' '. $featured_pricing . '">';
			$pricing_content4 .= '<div class="price"><span class="span-1">'. esc_html( $cost ) .'<p>'.$currency.'</p></span><span class="span-2">'. esc_html( $per ) .'</span></div>';
			if( $button_url ) {
				$pricing_content4 .= '<div class="plan"><a href="'. esc_url( $button_url ) .'" class="signup" target="_'. esc_attr( $button_target ) .'" rel="'. esc_attr( $button_rel ) .'" '.'>'. esc_html( $button_text ) .'</a></div>';
			}
		$pricing_content4 .= '</div>';
		if($style == 'style1'||$style == 'style3'){
			return $pricing_content1;
		}
		if($style == 'style2') {
			return $pricing_content2;
		}
		if($style == 'basic'){
			return $pricing_content4;
		}
	}
	
	add_shortcode( 'pricing', 'ya_pricing_shortcode' );
}
/*
 * Tooltip
 * @since v1.0
 *
 */
 function ya_tooltip($atts, $content = null) {
            extract(shortcode_atts(array(
	 'info' =>'',
	 'title'=>'',
	 'style'=>'',
	 'position'=>''
	 ),$atts));
	 if($title !=''){
		$title = '<strong>'.$title.'</strong>';
	 }
		  $html ='<a class="tooltips " href="#">';
		  $html .='<span class="'.$position.' tooltip-'.$style.'">'.$title.$info.'<b></b></span>';
		  $html .=do_shortcode($content);
		  $html .='</a>';
		 return $html;
	
}
add_shortcode('ya_tooltip', 'ya_tooltip');


/*
 * Modal
 * @since v1.0
 *
 */
 
function ya_modal($attr, $content = null) {
            ob_start();
			$tag_id = 'myModal_'.rand().time();
			?>
			<a href="#<?php echo esc_attr( $tag_id ); ?>" role="button" class="btn btn-default" data-toggle="modal"><?php echo trim($attr['label']) ?></a>
 
			<!-- Modal -->
			<div id="<?php echo esc_attr( $tag_id ); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h3 id="myModalLabel"><?php echo esc_html( trim($attr['header']) ) ?></h3>
						</div>
						<div class="modal-body">
							<?php echo $content; ?>
						</div>
						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo esc_html( trim($attr['close']) ) ?></button>
							<button class="btn btn-primary"><?php echo esc_html( trim($attr['save']) ) ?></button>
						</div>
					</div>
				</div>
			</div>
            
            <?php
            $output_string = ob_get_contents();
            ob_end_clean();
            return $output_string;
        }
add_shortcode('ya_modal', 'ya_modal');

/*
 * Videos shortcode
 *
 */
 
// register the shortcode to wrap html around the content
function ya_vid_sc($atts, $content=null) {
    extract(
        shortcode_atts(array(
            'site' => '',
            'id' => '',
            'w' => '',
            'h' => ''
        ), $atts)
    );
    if ( $site == "youtube" ) { $src = 'http://www.youtube-nocookie.com/embed/'.esc_attr( $id ); }
    else if ( $site == "vimeo" ) { $src = 'http://player.vimeo.com/video/'.esc_attr( $id ); }
    else if ( $site == "dailymotion" ) { $src = 'http://www.dailymotion.com/embed/video/'.esc_attr( $id ); }
    else if ( $site == "yahoo" ) { $src = 'http://d.yimg.com/nl/vyc/site/player.html#vid='.esc_attr( $id ); }
    else if ( $site == "bliptv" ) { $src = 'http://a.blip.tv/scripts/shoggplayer.html#file=http://blip.tv/rss/flash/'.esc_attr( $id ); }
    else if ( $site == "veoh" ) { $src = 'http://www.veoh.com/static/swf/veoh/SPL.swf?videoAutoPlay=0&permalinkId='.esc_attr( $id ); }
    else if ( $site == "viddler" ) { $src = 'http://www.viddler.com/simple/'.esc_attr( $id )
	; }
    if ( $id != '' ) {
        return '<iframe width="'.esc_attr( $w ).'" height="'.esc_attr( $h ).'" src="'.esc_attr( $src ).'" class="vid iframe-'.esc_attr( $site ).'"></iframe>';
    }
}
add_shortcode('videos','ya_vid_sc');
/*
 * Audios shortcode
 *
 */
// register the shortcode to wrap html around the content
function ya_audio_shortcode( $atts ) {
    extract( shortcode_atts( array (
        'identifier' => ''
    ), $atts ) );
    return '<div class="yt-audio-container"><iframe width="100%" height="166" frameborder="no" scrolling="no" src="https://w.soundcloud.com/player/?url=' . esc_attr( $identifier ) . '"></iframe></div>';
}
add_shortcode ('soundcloud-audio', 'ya_audio_shortcode' );
/*
 * Post slide 
 *
 */
function ya_post_slide( $atts ) {
	extract( shortcode_atts( array( 'title'=>'','style_title'=>'title1','limit' => 6,'categories'=>'','length'=> 40,'type'=>'','interval'=>'5000','el_class'=>''), $atts ) );
    $list = get_posts( array('cat' =>$categories,'posts_per_page' =>  $limit) );
	$html = '<div id="yt_post_slide" class="carousel  yt_post_slide_'.esc_attr( $type ).' slide content '.esc_attr( $el_class ).'" data-ride="carousel" data-interval="'.esc_attr( $interval ).'">';
	if($title != ''){
	$html.='<div class="block-title '.esc_attr( $style_title ).'">';
if($style_title == 'title3'){
	$wordChunks = explode(" ", $title);
	$firstchunk = $wordChunks[0];
	$secondchunk = $wordChunks[1];
$html.='<h2> <span>'.$firstchunk.'</span> <span class="text-color"> '.esc_html( $secondchunk ).' </span></h2>';
}else{
$html.='<h2>
				<span>'.esc_html( $title ).'</span>
	</h2>' ;
}	
}
	$html.=	'<div class="customNavigation nav-left-product">
				<a title="Previous" class="btn-bs prev-bs fa fa-angle-left"  href=".yt_post_slide_'.esc_attr( $type ).'" role="button" data-slide="prev"></a>
				<a title="Next" class="btn-bs next-bs fa fa-angle-right" href=".yt_post_slide_'.esc_attr( $type ).'" role="button" data-slide="next"></a>
			</div>
		</div>';
    $html .= '<div class="carousel-inner">';
	foreach( $list as $i => $item ){
	  $html .= '<div class="item ';
				if($i == 0)
				{$html .='active ';} 
				$html .='">';
	  $html .='<a href="'.post_permalink($item->ID).'" title="'.esc_attr( $item->post_title ).'">'.get_the_post_thumbnail($item->ID).'</a>';
	  $html .='  <div class="carousel-caption-'.esc_attr( $type ).' carousel-caption">
      	         <div class="carousel-caption-inner">
				 <a href="'.post_permalink($item->ID).'">'.esc_html( $item->post_title ).'</a>';	
	  $html .='<div class="item-description">'.wp_trim_words($item->post_content,$length).'</div>';
	  $html .='</div></div></div>';  
	}
	  $html .='</div>';
	  $html .='<div class="carousel-cl-'.esc_attr( $type ).' carousel-cl" >';
	  $html .=	'<a class="left carousel-control" href=".yt_post_slide_'.esc_attr( $type ).'" role="button" data-slide="prev"></a>';
	  $html .='<a class="right carousel-control" href=".yt_post_slide_'.esc_attr( $type ).'" role="button" data-slide="next"></a>';
	  $html .='</div>';
	  $html .='</div>';
	return $html;
}
add_shortcode ('postslide', 'ya_post_slide' );
/*
 * Lightbox image
 *
 */
 function ya_lightbox_shortcode($atts){
	  extract( shortcode_atts( array (
        'id' => '',
		'style'=>'',
		'size'=>'thumbnail',
		'class'=>'',
		'title'=>''
    ), $atts ) );
	add_action('wp_footer', 'add_script_lightbox', 50);
	return '<div class="lightbox '.esc_attr( $class ).' lightbox-'.esc_attr( $style ).'" ><a id="single_image" href="' . wp_get_attachment_url($id) . '">'.wp_get_attachment_image($id,$size).'</a><div class="caption"><h4>'.$title.'</h4></div></div>';
 }
 add_shortcode ('lightbox', 'ya_lightbox_shortcode' );
 function add_script_lightbox(){
	$script = '';
	$script .= '<script type="text/javascript">
	 jQuery(document).ready(function($) {
		  "use strict";
		 $("a#single_image").fancybox();
		 });
	</script>';
	echo $script;
 }
 /*
 * Heading tag
 *
 */
 function ya_heading_shortcode($atts,$content = null){
	 extract( shortcode_atts( array (
        'heading' => '',
		'type'=>'',
		'color'=>'',
		'icon'=>'',
        'class'=>'', 		
		'bg'=>''
    ), $atts ) );
	if( $icon != ''||$color !=''||$bg !=''||$class !=''){
			return '<span class="'.$class.'" style="background:'.$bg.';color:'.$color.'"><i class="fa '.esc_attr( $icon ).'"></i>'.do_shortcode($content);
		}
	if($heading !=''){
	  return '<'.$heading.' style="font-weight:'.esc_attr( $type ).'">'.do_shortcode($content).'</'.$heading.'>';
	}
 }
 add_shortcode('headings','ya_heading_shortcode');
  /*
 * Testimonial
 *
 */
 function ya_testimonial($atts,$content = null) {
	 extract(shortcode_atts(array(
	 'iconleft' =>'',
	 'iconright' =>'',
	 'imgsrc'=>'',
	 'auname'=>'',
	 'auinfo'=>'',
	 'title'=>'',
	 'content'=>'',
	 'class'=>'',
	 'style'=>''
	 ),$atts));
	 if($style == 'style1' || $style == 'style2'){
	 if($iconleft !='' ||$iconright !=''){
		 $iconleft = '<i class="'.esc_attr( $iconleft ).'"></i>';
		 $iconright ='<i class="'.esc_attr( $iconright ).'"></i>';
	 }
	 $html ='<div class="testimonial_'.$style.' '.esc_attr( $class ).'">';
	 $html .='<div class="testimonial_content">';
	 $html .= $iconleft.$content.$iconright;
	 $html .='</div>';
	 $html .='<div class="testimonial_meta">';
	 	 if($imgsrc !=''){
	 $html .= '<img src ="'.esc_attr( $imgsrc ).'">';
		   }
	 $html .='<div class="testimonial_info"><ul><li>'.esc_html( $auname ).'</li>';
	 if($auinfo !=''){
	 $html .='<li>'.esc_html( $auinfo ).'</li>';
	 }
	 $html .='</ul></div>';
	 $html .='</div></div>';
	 return $html;
	 }
	 /*** testimonial width background ***/
	 if($style == 'bg'){
		 if($iconleft !='' ||$iconright !=''){
		 $iconleft = '<i class="'.esc_attr( $iconleft ).'"></i>';
		 $iconright ='<i class="'.esc_attr( $iconright ).'"></i>';
	 }
	 $html ='<div class="testimonial_'.$style.' '.esc_attr( $class ).'">';
	 if($imgsrc !=''){
	 $html .= '<img src ="'.esc_attr( $imgsrc ).'">';
		   }
	 $html .='<div class="testimonial_content">';
	 $html .= $iconleft.$content.$iconright;
	 $html .='</div>';
	 $html .='<div class="testimonial_meta">';
	 $html .='<div class="testimonial_info"><ul><li>'.esc_html( $auname ).'</li>';
	 if($auinfo !=''){
	 $html .='<li>'.esc_html( $auinfo ).'</li>';
	 }
	 $html .='</ul></div>';
	 $html .='</div></div>';
	 return $html; 
	 }
	 /*** Testimonial width border ***/
	 if($style == 'border'){
		 if($iconleft !='' ||$iconright !=''){
		 $iconleft = '<i class="'.esc_attr( $iconleft ).'"></i>';
		 $iconright ='<i class="'.esc_attr( $iconright ).'"></i>';
	 }
	 $html ='<div class="testimonial_'.$style.' '.esc_attr( $class ).'">';
	 $html .='<div class="testimonial_content">';
	 $html .= $iconleft.$content.$iconright;
	 $html .='</div>';
	 $html .='<div class="testimonial_meta">';
	 	 if($imgsrc !=''){
	 $html .= '<img src ="'.esc_attr( $imgsrc ).'">';
		   }
	 $html .='<div class="testimonial_info"><ul><li>'.esc_html( $auname ).'</li>';
	 if($auinfo !=''){
	 $html .='<li>'.esc_html( $auinfo ).'</li>';
	 }
	 $html .='</ul></div>';
	 $html .='</div></div>';
	 return $html;
		 
	 }
 }
 add_shortcode('testimonial','ya_testimonial');
 /*
 * Testimonial Slide
 *
 */
 function ya_testimonial_slide($atts){
	 extract(shortcode_atts(array(
	 'post_type' => 'testimonial',
	 'type' =>'',
	 'el_class'=>'',
	 'title'=>'Testimonial',
	 'style_title'=>'title1',
		'orderby' => '',
		'length'=>'',
		'order' => '',
		'post_status' => 'publish',
		'numberposts' => 5
	 ),$atts));
$pf_id = 'testimonial-'.rand().time();
$i='';
$j='';
$k='';
$query_args =array( 'posts_per_page'=> $numberposts,'post_type' => 'testimonial','orderby' => $orderby,'order' => $order); 
$list = new WP_Query($query_args);
//var_dump($list);
//////////////////////    testimonial indicators /////////////////
if($type=='indicators_up'){
	$output='<div id="'.$pf_id.'" class="testimonial-slider '.$type.' carousel slide '.$el_class.'" data-interval="0">';
if($title !=''){
$output.='<div class="block-title '.$style_title.'">
			<h2>
				<span>'.$title.'</span>
			</h2>
			</div>';
}
$output.='<ul class="carousel-indicators">';
			 while ( $list->have_posts() ) : $list->the_post();
				 if( $j % 1 == 0 ) {  $k++;
				 $active = ($j== 0)? 'active' :'';
$output.='<li class="'.$active.'" data-slide-to="'.($k-1).'" data-target="#'.$pf_id.'"> ';
				}  if( ( $j+1 ) % 1 == 0 || ( $j+1 ) == $numberposts ){
$output.='</li>';
			
				}
					
				$j++; 
			 endwhile; 
		wp_reset_postdata(); 
$output.='</ul>';
$output.='<div class="carousel-inner">';
				while($list->have_posts()): $list->the_post();
			
				global $post;
				$au_name = get_post_meta( $post->ID, 'au_name', true );
				$au_url  = get_post_meta( $post->ID, 'au_url', true );
				$au_info = get_post_meta( $post->ID, 'au_info', true );
				if( $i % 1 == 0 ){ 
				$active = ($i== 0)? 'active' :'';
	$output.='<div class="item '.$active.'">';
	$output.='<div class="row">';
			   } 
	$output.='<div class="item-inner col-lg-12">';
						
	$output.='<div class="client-comment">';
					$text = get_the_content($post->ID);
										$content = wp_trim_words($text, $length);
								$output.= esc_html($content);
	$output.='</div>';
	$output.='<div class="client-say-info">';
	$output.='<div class="name-client">';
	$output.='<h2><a href="#" title="'.esc_attr( $post->post_title ).'">'.esc_html($au_name).'</span></a></h2>
			</div>';
	if($au_info !=''){
	$output.='<div class="info-client">--- '.esc_html($au_info).' ---</div>';
	}
	$output.='</div>';
	$output.='</div>';
			if( ( $i+1 )%1==0 || ( $i+1 ) == $numberposts ){

$output.='	</div></div>';
} 
			 $i++; endwhile; wp_reset_postdata(); 
		$output.='</div>';

$output.='</div>';
	return $output;
} 
///////////////////////////   testimonial   slide //////////////////////
if($type=='slide1'){
	$output ='<div class="widget-testimonial">
	<div class="widget-inner">
		<div class="title-testimonial '.$style_title.'">
			<h2>'.$title.'</h2>
		</div>
		<div id="'.$pf_id.'" class="testimonial-slider carousel slide" data-interval="0">
			<div class="carousel-inner">';				
					while($list->have_posts()): $list->the_post();
					global $post;
					$au_name = get_post_meta( $post->ID, 'au_name', true );
					$au_url  = get_post_meta( $post->ID, 'au_url', true );
					$au_info = get_post_meta( $post->ID, 'au_info', true );
					if( $i % 2 == 0 ){ 
					$active = ($i== 0)? 'active' :'';
	$output.='<div class="item '.$active.'">';
				     } 
    $output.='<div class="item-inner">';
							 if( has_post_thumbnail() ){
	$output.='<div class="item-content">
				<div class="item-desc">';
						$text = get_the_content($post->ID);
						$content = wp_trim_words($text, $length);
						$output.= esc_html($content);
	$output.='</div></div>';
	$output.='<div class="item-info">';
	$output.='<div class="item-image">';
	$output.='<a href="#" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail($post->ID,'thumbnail').'</a>';
	$output.='</div>';							
	$output.='<div class="item-bottom">
					<h4><span class="client-name">'.esc_html($au_name).'</span></h4>';
	$output.='<div class="client-job">'.esc_html($au_info).'</div></div>';
	$output.='</div>';
							  }
	$output.='</div>';
				if( ( $i+1 )%2==0 || ( $i+1 ) == $numberposts ){ 
	$output.='</div>';  
				} 
				$i++; endwhile; wp_reset_postdata(); 
	$output.='</div>
			<!-- Controls -->
				<div class="carousel-cl">
					<a class="left carousel-control" href="#'.$pf_id.'" role="button" data-slide="prev"></a>
					<a class="right carousel-control" href="#'.$pf_id.'" role="button" data-slide="next"></a>
				</div>
		</div>
		</div>
	</div>
</div>';
return $output;
} 
if($type=='slide2'){
	$output ='<div class="widget-testimonial slide2">
	<div class="widget-inner">
		<div class="title-testimonial '.$style_title.'">
			<h2>'.$title.'</h2>
		</div>
		<div id="'.$pf_id.'" class="testimonial-slider carousel slide">
			<div class="carousel-inner">';				
					while($list->have_posts()): $list->the_post();
					global $post;
					$au_name = get_post_meta( $post->ID, 'au_name', true );
					$au_url  = get_post_meta( $post->ID, 'au_url', true );
					$au_info = get_post_meta( $post->ID, 'au_info', true );
					if( $i % 1 == 0 ){ 
					$active = ($i== 0)? 'active' :'';
	$output.='<div class="item '.$active.'">';
				     } 
    $output.='<div class="item-inner">';
							 if( has_post_thumbnail() ){
	$output.='<div class="item-content">
				<div class="item-desc">';
						$text = get_the_content($post->ID);
						$content = wp_trim_words($text, $length);
						$output.= esc_html($content);
	$output.='</div></div>';
	$output.='<div class="item-info">';
	$output.='<div class="item-image">';
	$output.='<a href="#" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail($post->ID,'thumbnail').'</a>';
	$output.='</div>';							
	$output.='<div class="item-bottom">
					<h4><span class="client-name">'.esc_html($au_name).'</span></h4>';
	$output.='<div class="client-job">'.esc_html($au_info).'</div></div>';
	$output.='</div>';
							  }
	$output.='</div>';
				if( ( $i+1 )%1==0 || ( $i+1 ) == $numberposts ){ 
	$output.='</div>';  
				} 
				$i++; endwhile; wp_reset_postdata(); 
	$output.='</div>
			<!-- Controls -->
				<div class="carousel-cl">
					<a class="left carousel-control" href="#'.$pf_id.'" role="button" data-slide="prev"></a>
					<a class="right carousel-control" href="#'.$pf_id.'" role="button" data-slide="next"></a>
				</div>
		</div>
		</div>
	</div>
</div>';
return $output;
}
if($type=='ourservice'){
	$output ='<div class="widget-testimonial style2">
	<div class="widget-inner">
		<div class="title-testimonial '.$style_title.'">
			<h2>'.$title.'</h2>
		</div>
		<div id="'.$pf_id.'" class="testimonial">
			<div class="testimonial-inner">';				
					while($list->have_posts()): $list->the_post();
					global $post;
					$au_name = get_post_meta( $post->ID, 'au_name', true );
					$au_url  = get_post_meta( $post->ID, 'au_url', true );
					$au_info = get_post_meta( $post->ID, 'au_info', true );
	$output.='<div class="item">';
    $output.='<div class="item-inner col-lg-6 col-md-6">';
							 if( has_post_thumbnail() ){
	$output.='<div class="item-content">
				<div class="item-desc">';
						$text = get_the_content($post->ID);
						$content = wp_trim_words($text, $length);
						$output.= esc_html($content);
	$output.='</div></div>';
	$output.='<div class="item-info">';
	$output.='<div class="item-image">';
	$output.='<a href="#" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail($post->ID,'thumbnail').'</a>';
	$output.='</div>';							
	$output.='<div class="item-bottom">
					<h4><span class="client-name">'.esc_html($au_name).'</span></h4>';
	$output.='<div class="client-job">'.esc_html($au_info).'</div></div>';
	$output.='</div>';
							  }
	$output.='</div>';
				if( ( $i+1 )%1==0 || ( $i+1 ) == $numberposts ){ 
	$output.='</div>';  
				} 
				$i++; endwhile; wp_reset_postdata(); 
	$output.='</div>
		</div>
		</div>
	</div>
</div>';
return $output;
} 
}
add_shortcode('testimonial_slide','ya_testimonial_slide');

  /*
 * Divider
 *
 */
 function ya_divider_shortcode ($atts){
	 extract(shortcode_atts(array(
	 'position' =>'top',
	 'title'=>'',
	 'style'=>'',
	 'type'=>'',
	 'width' =>'auto',
	 'widthbd'=>'1px',
	 'color' =>'#d1d1d1'
	 ),$atts));
	 if($position !=''&&$type !='LR'){
		 return '<h4 style="text-align: center;">'.$title.'</h4><hr style ="border-'.$position.':'.$widthbd.' '.$style.' '.$color.';width:'.$width.';margin-top:10px">';
	 }
	 if($type == 'LR'){
		 return'<div class="rpl-title-wrapper"><h4>'.$title.'</h4></div><hr style ="border-'.$position.':'.$widthbd.' '.$style.' '.$color.';width:'.$width.';margin-top:-20px">';
	 }
	
 }
 add_shortcode('divider','ya_divider_shortcode');
 /*
 * Tables
 *
 */
 function ya_simple_table( $atts ) {
    extract( shortcode_atts( array(
        'cols' => 'none',
        'data' => 'none',
		'class'=>'',
		'style'=>''
    ), $atts ) );
    $cols = explode(',',$cols);
    $data = explode(',',$data);
    $total = count($cols);
    $output = '<table class="table-'.$style.' '.$class.'"><tr class="th">';
    foreach($cols as $col):
        $output .= '<td>'.$col.'</td>';
    endforeach;
    $output .= '</tr><tr>';
    $counter = 1;
    foreach($data as $datum):
        $output .= '<td>'.$datum.'</td>';
        if($counter%$total==0):
            $output .= '</tr>';
        endif;
        $counter++;
    endforeach;
        $output .= '</table>';
    return $output;
}
add_shortcode( 'tables', 'ya_simple_table' );
/*
 * Block quotes
 *
 */
 function ya_quote_shortcode( $atts,$content = null ) {
    extract( shortcode_atts( array(
		'style'=>''
    ), $atts ) );
	return '<div class="quote-'.$style.'">'.do_shortcode($content).'</div>';
 }
 add_shortcode ('quotes','ya_quote_shortcode');
 /*
 * Counter box
 *
 */
 function yt_counter_box($atts){
extract( shortcode_atts( array(
		'style'=>'',
		'icon'=>'',
	    'number'=>'',
		'type'=>''
      ), $atts ) );
	  add_action('wp_footer', 'add_script_counterbox', 50);
	  wp_enqueue_script('ya_waypoints_api', 'http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js', array('jquery'), null, true);
	if($icon !=''){
		$icon= '<i class="'.$icon.'"></i>';
	}
	return'<div class="counter-'.$style.'"><ul><li class="counterbox-number">'.$icon.''.$number.'</li><li class="type">'.$type.'</li></ul></div>';
}
add_shortcode('counters','yt_counter_box');
 function add_script_counterbox(){
	$script = '';
	$script .='<script type="text/javascript">';
	$script .= 'jQuery(document).ready(function( $ ) {
        $(".counterbox-number").counterUp({
            delay: 10,
            time: 1000
        });
    });';
	$script .='</script>';
	echo $script;
 }
 /*
 * Social
 *
 */
 function ya_social_shortcode($atts){
	 extract(shortcode_atts(array(
	 'style'=>'',
	 'background'=>'',
	 'icon'=>'',
	 'link'=>'',
	 'title'=>''
	 ),$atts));
	 $bg='';
	 if($background !=''){
		 $bg = 'style="background:'.$background.'"';
	 }
	 return '<div id="socials" class="socials-'.$style.'" '.$bg.'><a href="'.esc_url( $link ).'" title="'.esc_attr( $title ).'"><i class="fa '.$icon.'"></i></a></div>';
 }
 add_shortcode('socials','ya_social_shortcode');
 /*
 * Best Sale product
 *
 */
 function ya_bestsale_shortcode($atts){
	 extract(shortcode_atts(array(
	 'number' => 5,
	 'title'=>'Best Sale',
	 'style_title'=>'title1',
	 'el_class'=>'',
	 'template'=>'',
    		'post_status' 	 => 'publish',
    		'post_type' 	 => 'product',
    		'meta_key' 		 => 'total_sales',
    		'orderby' 		 => 'meta_value_num',
    		'no_found_rows'  => 1
	 ),$atts));
	 global $woocommerce;
	 $i='';
	 $pf_id = 'bestsale-'.rand().time();
	 $query_args =array( 'posts_per_page'=> $number,'post_type' => 'product','meta_key' => 'total_sales','orderby' => 'meta_value_num','no_found_rows' => 1); 
	 $query_args['meta_query'] = $woocommerce->query->get_meta_query();

    		$query_args['meta_query'][] = array(
			    'key'     => '_price',
			    'value'   => 0,
			    'compare' => '>',
			    'type'    => 'DECIMAL',
			);
    

		$r = new WP_Query($query_args);
		if ( $r->have_posts() ) {
if($template== 'default'){
	$output ='<div class="block-title-bottom">
			<h2>'.$title.'</h2>
		</div>';
	$output .='<div id="'.$pf_id.'" class="sw-best-seller-product vc_element">';
		while ( $r -> have_posts() ) : $r -> the_post();
		global $product, $post, $wpdb, $average;
		$count = $wpdb->get_var($wpdb->prepare("
			SELECT COUNT(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
			AND meta_value > 0
		",$post->ID));
		$rating = $wpdb->get_var($wpdb->prepare("
			SELECT SUM(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
		",$post->ID));
	$output.='<div class="bs-item cf">
			<div class="bs-item-inner">';
	$output.='<div class="item-img">';
	$output.='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">';
					 if( has_post_thumbnail() ){  
	$output.= (get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' )) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
					}else{ 
	$output.= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
					} 
	$output.='</a>';
	$output.='</div>';
	$output.='<div class="item-content">';
	
					if( $count > 0 ){
						$average = number_format($rating / $count, 1);
				
	$output.='<div class="star"><span style="width:'.($average*14).'px'.'"></span></div>';
					
			 } else { 
				
	$output.='<div class="star"></div>';
					
				}
	$output.='<h4><a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h4>';
    $output.= '<p>'.$product->get_price_html().'</p>';			 
    $output.='</div></div></div>';
		endwhile;
	wp_reset_postdata();
	$output.='</div>';
	return $output;
}elseif($template == 'slide'){
	$output ='<div id="'.$pf_id.'" class="sw-best-seller-product vc_element carousel slide '.$el_class.'" data-interval="0">';
	if($title != ''){
	$output.='<div class="block-title '.$style_title.'">';

$output.='<h2>
				<span>'.$title.'</span>
			</h2>';
    
}
	$output.='<div class="customNavigation nav-left-product">
				<a title="Previous" class="btn-bs prev-bs fa fa-angle-left"  href="#'.$pf_id.'" role="button" data-slide="prev"></a>
				<a title="Next" class="btn-bs next-bs fa fa-angle-right" href="#'.$pf_id.'" role="button" data-slide="next"></a>
			</div>
		</div>';
    $output.='<div class="carousel-inner">';
		while ( $r -> have_posts() ) : $r -> the_post();
		global $product, $post, $wpdb, $average;
		$count = $wpdb->get_var($wpdb->prepare("
			SELECT COUNT(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
			AND meta_value > 0
		",$post->ID));
		$rating = $wpdb->get_var($wpdb->prepare("
			SELECT SUM(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
		",$post->ID));
	if( $i % 4 == 0 ){
    $active = ( $i == 0 ) ? 'active' : '';		
	$output.='<div class="item '.$active.'" >';
	}
	$output.='<div class="bs-item cf">';
	$output.='<div class="bs-item-inner">';
	$output.='<div class="item-img">';
	$output.='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">';
					 if( has_post_thumbnail() ){  
	$output.= (get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' )) ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
					}else{ 
	$output.= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
					} 
	$output.='</a>';
	$output.='</div>';
	$output.='<div class="item-content">';
	if( $count > 0 ){
						$average = number_format($rating / $count, 1);
				
	$output.='<div class="star"><span style="width:'.($average*14).'px'.'"></span></div>';
					
			 } else { 
				
	$output.='<div class="star"></div>';
					
				}
	$output.='<h4><a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h4>';
    $output.= '<p>'.$product->get_price_html().'</p>';
	$output.='</div></div></div>';
		if( ( $i+1 ) % 4 == 0 || ( $i+1 ) == $number ){
	$output.='</div>';
		}
		 $i++;endwhile;
	wp_reset_postdata();
	$output.='</div></div>';
		  return $output;
		  }
		}
		
 }
 add_shortcode('BestSale','ya_bestsale_shortcode');
  /*
 * Related product
 *
 */
 function ya_nav_title_shortcode($atts){
	 extract(shortcode_atts(array(
	 'number' => 5,
	 'title'=>'Related Product',
	 'el_class'=>'',
	 'template'=>''
	 ),$atts));
	 global $product, $woocommerce_loop,$wp_query;
	$related = $product->get_related( $number );
	if ( sizeof( $related ) == 0 ) return;
	$args = apply_filters( 'woocommerce_related_products_args', array(
		'post_type'            => 'product',
		'ignore_sticky_posts'  => 1,
		'no_found_rows'        => 1,
		'posts_per_page'       => $number,
		'post__in'             => $related,
		'post__not_in'         => array( $product->id )
	) );
	$num_post  = count($related);
	$relate = new WP_Query( $args );
	
	if ($relate->have_posts()) :
	$i = 0;
	$j = 0;
	$k = 0;
	 $pf_id = 'bestsale-'.rand().time();
	if($template == 'indicators'){
		$output='<div id="'.$pf_id.'" class="carousel slide sw-related-product" data-ride="carousel">';
		$output.='<ul class="list-unstyled carousel-indicators">';
		 while( $relate->have_posts() ) : $relate->the_post(); 
				if( $j % 3 == 0 ){
					  $active = ( $j == 0 ) ? 'active' : '';	
		$output.='<li data-target="#'.$pf_id.'" data-slide-to="'.$k.'" class="'.$active.'"></li>';
				
			 $k++; } $j++;  endwhile; wp_reset_postdata(); 
		$output.='</ul>';
	}
	if($template == 'slide'){
		$output ='<div id="'.$pf_id.'" class="carousel slide sw-related-product '.$el_class.'" data-ride="carousel" data-interval="0">';
	$output.='<div class="block-title title1">
			<h2>
				<span>'.$title.'</span>
			</h2>
			<div class="customNavigation nav-left-product">
				<a title="Previous" class="btn-bs prev-bs fa fa-angle-left"  href="#'.$pf_id.'" role="button" data-slide="prev"></a>
				<a title="Next" class="btn-bs next-bs fa fa-angle-right" href="#'.$pf_id.'" role="button" data-slide="next"></a>
			</div>
		</div>';
	}
		$output.='<div class="carousel-inner">';
			while ($relate->have_posts()) : $relate->the_post();
			global $product, $post, $wpdb, $average;
			$count = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0
			",$post->ID));

			$rating = $wpdb->get_var($wpdb->prepare("
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
			",$post->ID));
			if( $i % 4 == 0 ){
				$active = ( $i == 0 ) ? 'active' : '';		
				$output.='<div class="item '.$active.'" >';
				}
			$output.='<div class="bs-item cf">';
	        $output.='<div class="bs-item-inner">';
			$output.='<div class="item-img">';
	$output.='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">';
					 if( has_post_thumbnail() ){  
	$output.= (get_the_post_thumbnail( $relate->post->ID, 'shop_thumbnail' )) ? get_the_post_thumbnail( $relate->post->ID, 'shop_thumbnail' ):'<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
					}else{ 
	$output.= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
					} 
	$output.='</a>';
	$output.='</div>';
	$output.='<div class="item-content">';
	if( $count > 0 ){
						$average = number_format($rating / $count, 1);
				
	$output.='<div class="star"><span style="width:'.($average*14).'px'.'"></span></div>';
					
			 } else { 
				
	$output.='<div class="star"></div>';
					
				}
	$output.='<h4><a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.esc_html( $post->post_title ).'</a></h4>';
    $output.= '<p>'.$product->get_price_html().'</p>';
	$output.='</div></div></div>';
			 if( ( $i+1 )%4==0 || ( $i+1 ) == $num_post  ){ 
			 $output.='</div>';
			 } 
			 $i++; endwhile; 
		$output.='</div>
	</div>';
	endif;
	wp_reset_postdata();
	return $output;
	
 }
  add_shortcode('yt_related_product','yt_related_product_shortcode');
 /**  Nav Title Style **/
 function yt_nav_title_shortcode($atts,$content = null){
	 extract(shortcode_atts(array(
	 'style'=>'',
	 'color'=>'',
	 'tag'=>'h2',
	 'icon'=>'',
	 'font-color'=>''
	 ),$atts));
	if( $icon != '' ){
			$icon = '<i class="'.$icon.'"></i>';
		}
		return '<section class="block-title '.$style.'">
		<'.$tag.'><span>'.$icon.do_shortcode($content).'</span></'.$tag.'>
	</section>';
 }
 add_shortcode('Title','ya_nav_title_shortcode');
 /*
 * OUR BRAND
 *
 */
 function ya_our_brand_shortcode($atts){
	 extract( shortcode_atts( array(
	'title' => '',
	'type'=>'default',
	'style_title'=>'',
	'numberposts' => 5,
	'orderby'=>'',
	'order' => '',
	'post_status' => 'publish',
	'columns'=>'',
	'columns1'=>'',
	'columns2'=>'',
	'columns3'=>'',
	'columns4'=>'',
	'interval'=>'',
	'effect'=>'slide',
	'hover'=>'hover',
	'swipe'=>'yes',
	'el_class' => ''
), $atts ) );
$tag_id ='sw_partner_slider_'.rand().time();
		$default = array(
			'post_type' => 'partner',
			'orderby' => $orderby,
			'order' => $order,
			'post_status' => 'publish',
			'showposts' => $numberposts
		);
	$list = new WP_Query( $default );
if($type == 'default'){
$output='<div class="'.$el_class.' block-brand">';
if($title !=''){
$output.='<div class="block-title '.$style_title.'">';
if($style_title == 'title3'){
	$wordChunks = explode(" ", $title);
	$firstchunk = $wordChunks[0];
	$secondchunk = $wordChunks[1];
$output.='<h2> <span>'.$firstchunk.'</span> <span class="text-color"> '.$secondchunk.' </span></h2>';
}else {
	$output.='<h2>
				<span>'.$title.'</span>
			</h2>';
    }
}
$output.='<a class="view-all-brand" href="#" title="View All">View All</a>
		</div>';
$output.='<div class="block-content">
				<div class="brand-wrapper">
					<ul>';
				while($list->have_posts()): $list->the_post();
						global  $post;
						$output.='<li><a href="'.post_permalink($post->ID).'" title="'.$post->post_title.'">'.get_the_post_thumbnail($post->ID).'</a></li>';
                     endwhile; wp_reset_postdata();
$output.='</ul>
				</div>
			</div>
		</div>';
		return $output;
}
if($type == 'slide'){
$output='<div id="'.$tag_id.'" class="sw-partner-container-slider flex-slider '.$el_class.'">';
$output.='<div class="page-button top">
				<ul class="control-button preload">
					<li class="preview"></li>
					<li class="next"></li>
				</ul>		
			</div>';
	$count_items = 0;
		if($numberposts >= $list->found_posts){$count_items = $list->found_posts; }else{$count_items = $numberposts;}
		//var_dump($list);
		if($columns > $count_items){
			$columns = $count_items;
		}
		
		if($columns1 > $count_items){
			$columns1 = $count_items;
		}
		
		if($columns2 > $count_items){
			$columns2 = $count_items;
		}
		
		if($columns3 > $count_items){
			$columns3 = $count_items;
		}
		
		if($columns4 > $count_items){
			$columns4 = $count_items;
		}
		
		$deviceclass_sfx = 'preset01-'.$columns.' '.'preset02-'.$columns1.' '.'preset03-'.$columns2.' '.'preset04-'.$columns3.' '.'preset05-'.$columns4;
$output.='<div class="slider not-js cols-6 '.$deviceclass_sfx.'" data-interval="'.$interval.'" data-effect="'.$effect.'" data-hover="'.$hover.'" data-swipe="'.$swipe.'">
			<div class="vpo-wrap">
				<div class="vp">
					<div class="vpi-wrap">';
						while($list->have_posts()): $list->the_post();
						global  $post;
						$link = get_post_meta( $post->ID, 'link', true );
						$target = get_post_meta( $post->ID, 'target', true );
						$description = get_post_meta( $post->ID, 'description', true );
$output.='<div class="item">
							<div class="item-wrap">';							
								if(has_post_thumbnail()){ 
								$output.='	<div class="item-img item-height">
										<div class="item-img-info">
											<a href="'.esc_url( $link ).'" title="'.esc_attr( $post->post_title ).'" target="'.$target.'">
												'.get_the_post_thumbnail($post->ID).'
											</a>
										</div>
									</div>';
								 }else{ 
$output.='      <div class="item-img item-height">
										<div class="item-img-info">
											<a href="'.esc_url( $link ).'" title="'.esc_attr( $post->post_title ).'" target="'.$target.'">
												<img src="'.get_template_directory_uri().'/assets/img/placeholder/thumbnail.png" alt="No thumb">;
											</a>
										</div>
									</div>';
								 }
								 if( $description != '' ){ 
							$output.='<div class="item-desc">';
								$output.= $description.'
									</div>';		
								 }
						$output.='	</div>
						</div>';
					 endwhile; wp_reset_postdata();
					$output.='</div>
				</div>
			</div>
		</div>
	</div>';
	return $output;
}

 }
 add_shortcode('OurBrand','ya_our_brand_shortcode');
 /*
 * Vertical mega menu
 *
 */
 function yt_vertical_megamenu_shortcode($atts){
	 extract( shortcode_atts( array(
	'menu_locate' =>'',
	'title'  =>'',
	'style' =>'',
	'el_class' => ''
), $atts ) );
$output = '<div class="vc_wp_custommenu wpb_content_element ' . $el_class . ' '.$style.'">';
if($title != ''){
$output.='<div class="mega-left-title">
				<strong>'.$title.'</strong>
			</div>';
}
$output.='<div class="wrapper_vertical_menu vertical_megamenu">';
ob_start();
$output .= wp_nav_menu( array( 'menu' => $menu_locate, 'menu_class' => 'nav vertical-megamenu' ) );
$output .= ob_get_clean();
$output .= '</div></div>';
return $output;
 }
 add_shortcode('ya_mega_menu','yt_vertical_megamenu_shortcode');
 /***********************
 * Ya Post 
 *
 ***************************/
 function ya_post_shortcode($atts){
	  $output = $title = $number = $el_class = '';
extract( shortcode_atts( array(
	'title' => '',
	'number' => '',
	'type' =>'the_blog',
	'category_id' =>'',
	'orderby'=>'',
	'order' => '',
	'post_status' => 'publish',
	'length' => 10,
	'el_class' => ''
), $atts ) );
$pf_id = 'posts-'.rand().time();
$list = get_posts(( array('cat' =>$category_id,'posts_per_page' =>  $number,'orderby' => $orderby,'order' => $order ) ));
//var_dump($list);
if (count($list)>0){
	$i = 0;
	$j = 0;
	$k = 0;
// The blog style
if($type == 'the_blog'){
	$output='<div class="widget-the-blog '.$type.' ">';
	$output .='<div class="title-home">';
	$output .='<h2>'.$title.'</h2></div>';
	$output .='<ul>';
		foreach ($list as $key => $post){
	    if (get_the_post_thumbnail( $post->ID ) ) {
	$output .='<li class="widget-post">';
	$output	.='<div class="widget-post-inner">';
	$output	.='<div class="widget-thumb">';
		if($i == 0){
			$output .='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail($post->ID, 'ya_first_thumb').'</a>';
		}else{
			$output .='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail($post->ID, 'thumbnail').'</a>';
		}
	$output	.='</div>';
	$output .='<div class="widget-caption">';
	$output .='<div class="item-title">';
	$output .='<h4><a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.$post->post_title.'</a></h4>';
	$output .='<div class="entry-meta">';
	$output .='<span class="entry-time">'.get_the_time('d/m/Y', $post->ID ).'</span>';
	$output.='<div class="item-content">';
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
								$content = wp_trim_words($post->post_content, $length, ' ');
							}
	$output.= esc_html( $content );
	$output.='</div></div></div></div></div>';
	$output.='</li>';
		}
	$i++;
 }
	$output.='</ul>';
    $output.='</div>';
	return $output;
}
// 2 Column Style
if($type == 'style2'){
	$output='<div class=" widget-the-blog '.$type.' ">';
	$output .='<div class="title-home">';
	$output .='<h2>'.$title.'</h2></div>';
	$output .='<ul>';
		foreach ($list as $key => $post){
	    if (get_the_post_thumbnail( $post->ID ) ) {
	$output .='<li class="widget-post">';
	$output	.='<div class="widget-post-inner">';
	$output	.='<div class="widget-thumb">';
	$output .='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.get_the_post_thumbnail($post->ID, 'thumbnail').'</a>';
	$output	.='</div>';
	$output .='<div class="widget-caption">';
	$output .='<div class="item-title">';
	$output .='<h4><a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'.$post->post_title.'</a></h4>';
	$output .='<div class="entry-meta">';
	$output .='<span class="entry-time">'.get_the_time('d M Y', $post->ID ).'</span>';
	$output.='<div class="item-content">';
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
								$content = wp_trim_words($post->post_content, $length, ' ');
							}
	$output.= esc_html( $content );
	$output.='</div></div></div>';
	$output.='</li>';
		} 
 }
	$output.='</ul>';
    $output.='</div>';
	return $output;
}
}
}
 add_shortcode('ya_post','ya_post_shortcode');
 function ya_get_url_shortcode($atts) {
	 if(is_front_page()){
		 $frontpage_ID = get_option('page_on_front');
		 $link =  get_site_url().'/?page_id='.$frontpage_ID ;
		 return $link;
	 }
	 elseif(is_page()){
		$pageid = get_the_ID();
		 $link = get_site_url().'/?page_id='.$pageid ;
		 return $link;
	 }
	 else{
		 $link = $_SERVER['REQUEST_URI'];
		 return $link;
	 }
	 
	 
 }
 add_shortcode('get_url','ya_get_url_shortcode');
 ////////   Ya Content Blog //////
 function ya_chooseus($atts){
	 extract( shortcode_atts( array(
	'title' =>'',
	'image'  =>'',
	'description'  =>'',
	'el_class' => ''
	), $atts ) );
	$output = '';
	$output .= '<div class="block-whychoose" '.$el_class.'>';
	$output .= '<div class="image-whychoose">'.wp_get_attachment_image($image,'full').'</div>';
	$output .= '<div class="content-whychoose">';
	$output .= '<h2>'.$title.'</h2>';
	$output	.= '<div class="description">'.$description.'</div>';
	$output .= '</div>';
	$output .='</div>';
	return $output;
 }
 add_shortcode('block_chooseus','ya_chooseus');
  ////////   Ya Hot Category //////
  function ya_hotcategory($atts){
	extract( shortcode_atts( array(
		'title' => '',
		'categories' => '',
		'el_class' => ''
	), $atts));
	if($categories != 0){
			if( !is_array( $categories ) ){
				$categories = explode( ',', $categories);
					}
		$output ='';
		$output .='<div class="hot-category '.$el_class.' clearfix">';
		$output .= '<div class="hot-title"><h2>'. esc_html($title) .'</h2></div>';
			foreach( $categories as $cat ){
			$term = get_term($cat, 'product_cat');			
			if( $term == NULL ){
				return ;
			}
			$thumbnail_id 	= absint( get_metadata( 'woocommerce_term', $cat, 'thumbnail_id', true ));
			//echo $thumbnail_id;
			$thumb = wp_get_attachment_image( $thumbnail_id, 'full' );
			//echo get_term_link( $cat, 'product_cat' );
		$output .='<div class="content-box">';
		$output .='<div class="image-cat"><a href="'. get_term_link( $term->slug, 'product_cat' ) .'" >'.$thumb.'</a></div>';
		$output .='<div class="name-cat"><h4><a href="'. get_term_link( $term->slug, 'product_cat' ) .'"> ' . esc_html( $term->name ) .'</a></h4></div>';
		$output .='<div class="child-cat">';
			$termchild = get_term_children( $term->term_id, 'product_cat' );
			//var_dump($termchild);
		$output .='<ul>';
				$i = 0;
				 foreach ( $termchild as $child ) {
					$i++;
					 $term = get_term_by( 'id', $child, 'product_cat' );
					 if($i <= 5){
					 $output .='<li><a href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name .'</a></li>';
					}
				 }
		 $output .='</ul>';
		 $output .='</div></div>';
		 }
		 $output .='</div>';
		return $output;
	}
  }
  add_shortcode('hot_category', 'ya_hotcategory');
  ////////   YA Recommend //////
  function YA_Recommend($atts){
	extract(shortcode_atts(array(
		'title' => '',
		'category' => '',
		'numberposts' => '',
		'orderby' => '',
		'order' => '',
		'post_status' => 'publish',
		'el_class' => ''
		), $atts));
	if($category != 0){
	$default = array(
		'post_type' => 'product',
		'tax_query'	=> array(
		array(
			'taxonomy'	=> 'product_cat',
			'field'		=> 'id',
			'terms'		=> $category)),
		'meta_key'		=> 'recommend_product',
		'meta_value'	=> 'yes',
		'orderby'		=> $orderby,
		'order'			=> $order,
		'post_status' 	=> 'publish',
		'showposts' 	=> $numberposts
	);
	}else{
		$default = array(
			'post_type' => 'product',
			'orderby' => $orderby,
			'order' => $order,
			'meta_key'		=> 'recommend_product',
			'meta_value'	=> 'yes',
			'post_status' => 'publish',
			'showposts' => $numberposts
		);
	}
	$list = new WP_Query( $default );
	//echo '<pre>';
	//var_dump($list);
	//echo '</pre>';
	$tag_id = 'sw_recommend_'.rand().time();
	$output = '';
	$output .='<div id='.$tag_id.' class="sw-recommend-product recommend-product">';
	$output .=' <div class="box-title">';
	$output .='<div class="order-title">';
	$output .='<h2>'.$title.'</h2>';
	$output .='</div></div>';
	$output .='<div class="recommend-content">';
		while($list->have_posts()): $list->the_post();global $product, $post, $wpdb, $average;
			$count = $wpdb->get_var($wpdb->prepare("
			SELECT COUNT(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
			AND meta_value > 0
		",$post->ID));
		$rating = $wpdb->get_var($wpdb->prepare("
			SELECT SUM(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
		",$post->ID));
		
	$output .='<div class="item"><div class="item-detail">';
	$output .='<div class="item-thumb">';
	$output .='<a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">';
			if( has_post_thumbnail() ){  
				$output .= get_the_post_thumbnail( $list->post->ID, 'ya_product_thumb') ? get_the_post_thumbnail( $list->post->ID, 'ya_product_thumb' ) : '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>';
			}else{ 
				$output .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/shop_thumbnail.png" alt="No thumb"/>' ;
			} 
	$output .='</a></div>';
	
	$output .='<div class="item-content">';
	$output .='<h4><a href="'.post_permalink($post->ID).'" title="'.esc_attr( $post->post_title ).'">'. esc_html( $post->post_title ) .'</a></h4>';
	$output .='<div class="reviews-content">';
			if( $count > 0 ){
					$average = number_format($rating / $count, 1);			
				$output.='<div class="star"><span style="width:'.($average*11).'px'.'"></span></div>';		
			 } else { 
				$output.='<div class="star"></div>';		
				}
	$output	.='<div class="item-number-rating">';
	$output .='</div></div>';
			if ( $price_html = $product->get_price_html() ){								
					$output	.='<div class="item-price"><span>';
					$output .= $price_html;
					$output	.='	</span></div>';
				 }
	$output .='</div>';
	$output .='</div></div>';
		endwhile; wp_reset_postdata();
	$output .='</div>';
	$output .='</div>';
	return $output;
  }
  add_shortcode('ya_recommend','YA_Recommend');
 
 /*
   * Shortcode change logo footer 
   *
  */
  function ya_change_logo( $atts ){
		extract(shortcode_atts(array(
		'title' => '',
		'colorset' => '',
		'post_status' => 'publish',
		'el_class' => ''
		), $atts));
		$ya_colorset = ya_options()->getCpanelValue('scheme');
		$site_logo = ya_options()->getCpanelValue('sitelogo');
		//var_dump($name);
		$output   ='';
		$output  .='<div class="ya-logo">';
		$output	 .='<a  href='.esc_url( home_url( '/' ) ).'>';
						 if($site_logo){
		$output	 .='<img src="'.esc_attr( $site_logo ).'"/>';
					 }else{
							if ($ya_colorset){$logo = get_template_directory_uri().'/assets/img/logo-footer-'.$ya_colorset.'.png';}
							else $logo = get_template_directory_uri().'/assets/img/logo-default.png';
		$output  .='<img src="'.esc_attr( $logo ).'" alt="logo-footer" />';
					}
		$output	 .='</a>';
		$output  .='</div>';
		return $output; 
  }
  add_shortcode('logo_footer','ya_change_logo');
function ya_popup_subscribe( $atts ){
	extract(shortcode_atts(array(
		'title' => '',
		'description' => '',
		'background' => '',
		'facebook_link' => '',
		'twitter_link' => '',
		'googleplus_link' => '',
		'pinterest_link' => '',
		'linkedin_link' => '',
	), $atts));
	ob_start();
	?>
	<div id="subscribe_popup" class="subscribe-popup" <?php echo ( $background != '' ) ? 'style="background: url('. esc_attr( $background ) .')"' : '' ?>>
		<div class="subscribe-popup-container">
			<h3><?php echo esc_html( $title ); ?></h3>
			<h2><?php echo esc_html( $description ); ?></h2>
			<div class="subscribe-form">
				<?php
					if( is_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ){
						echo do_shortcode( '[mc4wp_form]' );  
					}else{
				?>
					<div class="alert alert-warning alert-dismissible" role="alert">
						<a class="close" data-dismiss="alert">&times;</a>
						<p><?php esc_html_e('Please active mailchimp plugin first!', 'yatheme'); ?></p>
					</div>
				<?php
					}
				?>
			</div>
			<div class="subscribe-checkbox">
				<input id="popup_check" name="popup_check" type="checkbox" />
				<label><?php esc_html_e( "Don't show this popup again!", "yatheme" ); ?></label>
			</div>
			<div class="subscribe-social">
				<div class="subscribe-social-inner">
					<?php echo ( $facebook_link != '' ) ? '<a href="'. esc_url( $facebook_link ) .'" class="social-fb"><span class="fa fa-facebook"></span></a>' : ''; ?>
					<?php echo ( $twitter_link != '' ) ? '<a href="'. esc_url( $twitter_link ) .'" class="social-tw"><span class="fa fa-twitter"></span></a>' : ''; ?>
					<?php echo ( $googleplus_link != '' ) ? '<a href="'. esc_url( $googleplus_link ) .'" class="social-gplus"><span class="fa fa-google-plus"></span></a>' : ''; ?>
					<?php echo ( $pinterest_link != '' ) ? '<a href="'. esc_url( $pinterest_link ) .'" class="social-pin"><span class="fa fa-pinterest"></span></a>' : ''; ?>
					<?php echo ( $linkedin_link != '' ) ? '<a href="'. esc_url( $linkedin_link ) .'" class="social-linkedin"><span class="fa fa-linkedin"></span></a>' : ''; ?>
				</div>
			</div>
		</div>
	</div>
<?php	
	$output = ob_get_clean();
	return $output;
	
}
add_shortcode('ya_popup_subscribe','ya_popup_subscribe');