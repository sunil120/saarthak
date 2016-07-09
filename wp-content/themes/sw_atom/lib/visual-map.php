<?php 
add_action( 'vc_before_init', 'YA_shortcodeVC' );
function YA_shortcodeVC(){
$target_arr = array(
	__( 'Same window', 'yatheme' ) => '_self',
	__( 'New window', 'yatheme' ) => "_blank"
);
$link_category = array( __( 'All Links', 'yatheme' ) => '' );
$link_cats     = get_categories();
if ( is_array( $link_cats ) ) {
	foreach ( $link_cats as $link_cat ) {
		$link_category[ $link_cat->name ] = $link_cat->term_id;
	}
}
//category product
$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_emty' => false ) );
	if( count( $terms ) == 0 ){
		return ;
	}
	$term = array( __( 'All Category Product', 'yatheme' ) => '' );
	foreach( $terms as $cat ){
		$term[$cat->name] = $cat -> term_id;
	}
// hot category
$terms1 = get_terms( 'product_cat', array( 'parent' => 0, 'hide_emty' => false ) );
	if( count( $terms1 ) == 0 ){
		return ;
	}
	$term = array( __( '', 'yatheme' ) => '' );
	foreach( $terms1 as $cat ){
		$term1[$cat->name] = $cat -> term_id;
	}	
$args =
 array(
			'type' => 'post',
			'child_of' => 0,
			'parent' => 0,
			'orderby' => 'name',
			'order' => 'ASC',
			'hide_empty' => false,
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'number' => '',
			'taxonomy' => 'product_cat',
			'pad_counts' => false,

		);
		$product_categories_dropdown = array( __( 'All Category Product', 'yatheme' ) => '' );;
		$categories = get_categories( $args );
		foreach($categories as $category){
			$product_categories_dropdown[$category->name] = $category -> term_id;
		}
$menu_locations_array = array( __( 'All Links', 'yatheme' ) => '' );
$menu_locations = wp_get_nav_menus();	
foreach ($menu_locations as $menu_location){
	$menu_locations_array[$menu_location->name] = $menu_location -> term_id;
}

/* YTC VC */
// ytc tesminial

vc_map( array(
	'name' => 'YTC_ ' . __( 'Testimonial Slide', 'yatheme' ),
	'base' => 'testimonial_slide',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'The tesminial on your site', 'yatheme' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'yatheme' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'yatheme' ) => 'title1',
				__( 'Style title 2', 'yatheme' ) => 'title2',
				__( 'Style title 3', 'yatheme' ) => 'title3'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'yatheme' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Excerpt length (in words)', 'yatheme' ),
			'param_name' => 'length',
			'description' => __( 'Excerpt length (in words).', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'yatheme' ),
			'param_name' => 'type',
			'value' => array(
				__('Indicators Up','yatheme') => 'indicators_up',
				__( 'Slide Style 1', 'yatheme' ) => 'slide1',
				__('Slide Style 2','yatheme') => 'slide2',
				__( 'Style Our Service', 'yatheme' ) => 'ourservice'
				
			),
			'description' => sprintf( __( 'Chose template for testimonial', 'yatheme' ) )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'yatheme' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'yatheme' ) => 'DESC',
				__( 'Ascending', 'yatheme' ) => 'ASC'
			),
			'description' => __( 'Designates the ascending or descending order. More at %s.', 'yatheme' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'yatheme' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'yatheme' ) => 'date',
				__( 'ID', 'yatheme' ) => 'ID',
				__( 'Author', 'yatheme' ) => 'author',
				__( 'Title', 'yatheme' ) => 'title',
				__( 'Modified', 'yatheme' ) => 'modified',
				__( 'Random', 'yatheme' ) => 'rand',
				__( 'Comment count', 'yatheme' ) => 'comment_count',
				__( 'Menu order', 'yatheme' ) => 'menu_order'
			),
			'description' => __( 'Select how to sort retrieved posts. More at %s.', 'yatheme' )
		),
			
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		)
	)
) );
//ytc our brand
vc_map( array(
	'name' => 'YTC_ ' . __( 'Brand', 'yatheme' ),
	'base' => 'OurBrand',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'The best sale  product on your site', 'yatheme' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style title', 'yatheme' ),
			'param_name' => 'style_title',
			'value' => array(
				'Select type',
				__( 'Style title 1', 'yatheme' ) => 'title1',
				__( 'Style title 2', 'yatheme' ) => 'title2',
				__( 'Style title 3', 'yatheme' ) => 'title3',
				__( 'Style title 4', 'yatheme' ) => 'title4'
			),
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Type display', 'yatheme' ),
			'param_name' => 'type',
			'value' => array(
				'Select type',
				__( 'Type default', 'yatheme' ) => 'default',
				__( 'Type slide', 'yatheme' ) => 'slide',
			),
			'description' =>__( 'type you want display.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'yatheme' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'yatheme' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'yatheme' ) => 'DESC',
				__( 'Ascending', 'yatheme' ) => 'ASC'
			),
			'description' => __( 'Designates the ascending or descending order. More at %s.', 'yatheme' )
		),
				
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'yatheme' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'yatheme' ) => 'date',
				__( 'ID', 'yatheme' ) => 'ID',
				__( 'Author', 'yatheme' ) => 'author',
				__( 'Title', 'yatheme' ) => 'title',
				__( 'Modified', 'yatheme' ) => 'modified',
				__( 'Random', 'yatheme' ) => 'rand',
				__( 'Comment count', 'yatheme' ) => 'comment_count',
				__( 'Menu order', 'yatheme' ) => 'menu_order'
			),
			'description' => __( 'Select how to sort retrieved posts. More at %s.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Speed slide', 'yatheme' ),
			'param_name' => 'interval',
			'description' => __( 'Speed for slide', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
		    'heading' => __( 'Effect slide', 'yatheme' ),
			'param_name' => 'effect',
			'value' => array(
				__( 'Slide', 'yatheme' ) => 'slide',
				__( 'Fade', 'yatheme' ) => 'fade',
			),
				'description' => __( 'Effect for slide', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
		    'heading' => __( 'Hover slide', 'yatheme' ),
			'param_name' => 'hover',
			'value' => array(
				__( 'Yes', 'yatheme' ) => 'hover',
				__( 'No', 'yatheme' ) => '',
			),
				'description' => __( 'Hover for slide', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
		    'heading' => __( 'Swipe slide', 'yatheme' ),
			'param_name' => 'swipe',
			'value' => array(
				__( 'Yes', 'yatheme' ) => 'yes',
				__( 'No', 'yatheme' ) => 'no',
			),
				'description' => __( 'Swipe for slide', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns >1200px:', 'yatheme' ),
			'param_name' => 'columns',
			'description' => __( 'Number colums you want display  > 1200px.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 768px to 1199px:', 'yatheme' ),
			'param_name' => 'columns1',
			'description' => __( 'Number colums you want display  on 768px to 1199px.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 480px to 767px:', 'yatheme' ),
			'param_name' => 'columns2',
			'description' => __( 'Number colums you want display  on 480px to 767px.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns on 321px to 479px:', 'yatheme' ),
			'param_name' => 'columns3',
			'description' => __( 'Number colums you want display  on 321px to 479px.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of Columns in 320px or less than:', 'yatheme' ),
			'param_name' => 'columns4',
			'description' => __( 'Number colums you want display  in 320px or less than.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		)
	)
) );
//// vertical mega menu
vc_map( array(
	'name' => 'YTC ' . __( 'vertical mega menu', 'yatheme' ),
	'base' => 'ya_mega_menu',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display vertical mega menu', 'yatheme' ),
	'params' => array(
	    array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		array(
			'param_name'    => 'style',
			'type'          => 'dropdown',
			'value'         => array(
				'Style Default' => '',
				'Style 1'       => 'style1'
			), // here I'm stuck
			'heading'       => __('Style Vertical Menu', 'yatheme'),
			'description'   => '',
			'holder'        => 'div'
		),
	    array(
			'param_name'    => 'menu_locate',
			'type'          => 'dropdown',
			'value'         => $menu_locations_array, // here I'm stuck
			'heading'       => __('Category menu:', 'overmax'),
			'description'   => '',
			'holder'        => 'div',
			'class'         => ''
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Theme shortcode want display', 'yatheme' ),
			'param_name' => 'widget_template',
			'value' => array(
				__( 'default', 'yatheme' ) => 'default',
			),
			'description' => sprintf( __( 'Select different style menu.', 'yatheme' ) )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		),			
	)
));
///// Gallery 
vc_map( array(
	'name' => __( 'YTC_Gallery', 'yatheme' ),
	'base' => 'gallerys',
	'icon' => 'icon-wpb-images-carousel',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'description' => __( 'Animated carousel with images', 'yatheme' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'yatheme' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Images', 'yatheme' ),
			'param_name' => 'ids',
			'value' => '',
			'description' => __( 'Select images from media library.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'gallery size', 'yatheme' ),
			'param_name' => 'size',
			'description' => __( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size. If used slides per view, this will be used to define carousel wrapper size.', 'yatheme' )
		),
		
		array(
			'type' => 'dropdown',
			'heading' => __( 'Gallery caption', 'yatheme' ),
			'param_name' => 'caption',
			'value' => array(
				__( 'true', 'yatheme' ) => 'true',
				__( 'false', 'yatheme' ) => 'false'
			),
			'description' => __( 'Images display caption true or false', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Gallery type', 'yatheme' ),
			'param_name' => 'type',
			'value' => array(
				__( 'column', 'yatheme' ) => 'column',
				__( 'slide', 'yatheme' ) => 'slide',
				__( 'flex', 'yatheme' ) => 'flex'
			),
			'description' => __( 'Images display type', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'gallery columns', 'yatheme' ),
			'param_name' => 'columns',
			'description' => __( 'Enter gallery columns. Example: 1,2,3,4 ... Only use gallery type="column".', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Slider speed', 'yatheme' ),
			'param_name' => 'interval',
			'value' => '5000',
			'description' => __( 'Duration of animation between slides (in ms)', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Gallery event', 'yatheme' ),
			'param_name' => 'event',
			'value' => array(
				__( 'slide', 'yatheme' ) => 'slide',
				__( 'fade', 'yatheme' ) => 'fade'
			),
			'description' => __( 'event slide images', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		)
		)
) );
/////////////////// best sale /////////////////////
vc_map( array(
	'name' => 'YTC_' . __( 'Best Sale', 'yatheme' ),
	'base' => 'BestSale',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display bestseller', 'yatheme' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Widget title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Style title', 'yatheme' ),
			'param_name' => 'style_title',
			'description' =>__( 'What text use as a style title. Leave blank to use default style title.', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Template', 'yatheme' ),
			'param_name' => 'template',
			'value' => array(
				'Select type',
				__( 'Default', 'yatheme' ) => 'default',
				__( 'Slide', 'yatheme' ) => 'slide',
			),
			'description' => sprintf( __( 'Select different style best sale.', 'yatheme' ) )
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of posts to show', 'yatheme' ),
			'param_name' => 'number',
			'admin_label' => true
		),
		
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		),	
	)
) );
/////////////////// YA Recommend/////////////////////
vc_map( array(
	'name' =>  __( 'YA Recommend Products', 'yatheme' ),
	'base' => 'ya_recommend',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Recommend Products', 'yatheme' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'holder' => 'div',
			'class' => '',
			'heading' => __( "Category", "smartaddons" ),
			'param_name' => "category",
			'value' => $term,
			'description' => __( "Select Categories", "smartaddons" )
		 ),
		array(
			'type' => 'textfield',
			'heading' => __( 'Number of product to show', 'yatheme' ),
			'param_name' => 'numberposts',
			'admin_label' => true
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order way', 'yatheme' ),
			'param_name' => 'order',
			'value' => array(
				__( 'Descending', 'yatheme' ) => 'DESC',
				__( 'Ascending', 'yatheme' ) => 'ASC'
			),
			'description' => __( 'Designates the ascending or descending order. More at %s.', 'yatheme' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Order by', 'yatheme' ),
			'param_name' => 'orderby',
			'value' => array(
				'Select orderby',
				__( 'Date', 'yatheme' ) => 'date',
				__( 'ID', 'yatheme' ) => 'ID',
				__( 'Author', 'yatheme' ) => 'author',
				__( 'Title', 'yatheme' ) => 'title',
				__( 'Modified', 'yatheme' ) => 'modified',
				__( 'Random', 'yatheme' ) => 'rand',
				__( 'Comment count', 'yatheme' ) => 'comment_count',
				__( 'Menu order', 'yatheme' ) => 'menu_order'
			),
			'description' => __( 'Select how to sort retrieved posts. More at %s.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		),	
	)
) );

/////////////////// ya Choose us/////////////////////
vc_map( array(
	'name' => 'YTC_' . __( 'Why Choose Us', 'yatheme' ),
	'base' => 'block_chooseus',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Content Blog Why Choose Us', 'yatheme' ),
	'params' => array(
			array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		array(
			'type' => 'attach_images',
			'heading' => __( 'Image', 'yatheme' ),
			'param_name' => 'image',
			'description' => __( '', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Description', 'yatheme' ),
			'param_name' => 'description',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		),
	)
));

/////////////////// ya Hot Category/////////////////////
vc_map( array(
	'name' => 'YTC_' . __( 'Hot Category', 'yatheme' ),
	'base' => 'hot_category',
	'icon' => 'icon-wpb-ytc',
	'category' => __( 'My shortcodes', 'yatheme' ),
	'class' => 'wpb_vc_wp_widget',
	'weight' => - 50,
	'description' => __( 'Display Hot Product Category', 'yatheme' ),
	'params' => array(
			array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'yatheme' ),
			'param_name' => 'title',
			'description' => __( 'What text use as a widget title. Leave blank to use default widget title.', 'yatheme' )
		),
		 array(
			'type' => 'checkbox',
			'holder' => 'div',
			'class' => '',
			'heading' => __( "Category", "smartaddons" ),
			'param_name' => "categories",
			'value' => $term1,
			'description' => __( "Select Categories", "smartaddons" )
		 ),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'yatheme' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'yatheme' )
		),
	)
));

}
?>