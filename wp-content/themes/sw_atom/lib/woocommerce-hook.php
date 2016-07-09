<?php
add_theme_support( 'woocommerce' );

add_filter( 'wp_list_categories', 'ya_list_categories' );
function ya_list_categories( $output ){
	$output = preg_replace('~\((\d+)\)(?=\s*+<)~', '<span class="number-count">$1</span>', $output);
	return $output;
}

/*minicart via Ajax*/
$ya_header  = ya_options()->getCpanelValue( 'header_style' );
if( $ya_header == 'style2' ){
	add_filter('add_to_cart_fragments', 'ya_add_to_cart_fragment', 100);
	function ya_add_to_cart_fragment( $fragments ) {
		ob_start();
		?>
		<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
		<?php
		$fragments['.ya-minicart'] = ob_get_clean();
		return $fragments;
		
	}
}else{
	add_filter('add_to_cart_fragments', 'ya_add_to_cart_fragment_style1', 101);
	function ya_add_to_cart_fragment_style1( $fragments ) {
		ob_start();
		?>
		<?php get_template_part( 'woocommerce/minicart-ajax-style1' ); ?>
		<?php
		$fragments['.ya-minicart-style1'] = ob_get_clean();
		return $fragments;
		
	}
}
/*remove woo breadcrumb*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/*add second thumbnail loop product*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'ya_woocommerce_template_loop_product_thumbnail', 10 );
	function ya_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post;
		$html = '';
		$id = get_the_ID();
		$gallery = get_post_meta($id, '_product_image_gallery', true);
		$attachment_image = '';
		if(!empty($gallery)) {
			$gallery = explode(',', $gallery);
			$first_image_id = $gallery[0];
			$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image back'));
		}
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
		if ( has_post_thumbnail() ){
			if( $attachment_image ){
				$html .= '<div class="product-thumb-hover">';
				$html .= (get_the_post_thumbnail( $post->ID, $size )) ? get_the_post_thumbnail( $post->ID, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';
				$html .= $attachment_image;
				$html .= '</div>';
				/* quickview */
				$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
				$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$post->ID.'&amp;nonce='.$nonce);
				$html .= '<a href="'. $link .'" data-fancybox-type="ajax" class="group fancybox fancybox.ajax">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View ', 'yatheme' ) ).'</a>';	
			}else{
				$html .= (get_the_post_thumbnail( $post->ID, $size )) ? get_the_post_thumbnail( $post->ID, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';
			}			
			return $html;
		}else{
			$html .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="No thumb">';
			return $html;
		}
	}
	function ya_woocommerce_template_loop_product_thumbnail(){
		echo ya_product_thumbnail();
	}

/*filter order*/
function ya_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;
     $url_data['query'] = http_build_query($params);
     return ya_build_url($url_data);
}


function ya_build_url($url_data) {
 $url="";
 if(isset($url_data['host']))
 {
	 $url .= $url_data['scheme'] . '://';
	 if (isset($url_data['user'])) {
		 $url .= $url_data['user'];
			 if (isset($url_data['pass'])) {
				 $url .= ':' . $url_data['pass'];
			 }
		 $url .= '@';
	 }
	 $url .= $url_data['host'];
	 if (isset($url_data['port'])) {
		 $url .= ':' . $url_data['port'];
	 }
 }
 if (isset($url_data['path'])) {
	$url .= $url_data['path'];
 }
 if (isset($url_data['query'])) {
	 $url .= '?' . $url_data['query'];
 }
 if (isset($url_data['fragment'])) {
	 $url .= '#' . $url_data['fragment'];
 }
 return $url;
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_before_shop_loop', 'ya_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_before_shop_loop', 'ya_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_before_shop_loop', 'ya_woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'ya_woocommerce_pagination', 35 );
add_action( 'woocommerce_before_shop_loop','ya_woommerce_view_mode_wrap',15 );
add_action( 'woocommerce_after_shop_loop', 'ya_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_after_shop_loop', 'ya_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_after_shop_loop', 'ya_woommerce_view_mode_wrap', 6 );
add_action( 'woocommerce_after_shop_loop', 'ya_woocommerce_catalog_ordering', 7 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action('woocommerce_message','wc_print_notices', 10);
function ya_viewmode_wrapper_start(){
	echo '<div class="products-nav">';
}
function ya_viewmode_wrapper_end(){
	echo '</div>';
}
function ya_woommerce_view_mode_wrap () {
	$html='<div class="view-mode-wrap">
				<p class="view-mode">
						<a href="javascript:void(0)" class="grid-view active" title="'. __('Grid view', 'yatheme').'"><span>'. __('Grid view', 'yatheme').'</span></a>
						<a href="javascript:void(0)" class="list-view" title="'. __('List view', 'yatheme') .'"><span>'.__('List view', 'yatheme').'</span></a>
				</p>	
			</div>';
	echo $html;
}

function ya_woocommerce_pagination() {
	global $wp_query;
	$term 		= get_queried_object();
	$parent_id 	= empty( $term->term_id ) ? 0 : $term->term_id;
	$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
		'parent'       => $parent_id,
		'menu_order'   => 'ASC',
		'hide_empty'   => 0,
		'hierarchical' => 1,
		'taxonomy'     => 'product_cat',
		'pad_counts'   => 1
	) ) );
	if ( $product_categories ) {
		if ( is_product_category() ) {
			$display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

			switch ( $display_type ) {
				case 'subcategories' :
					$wp_query->post_count    = 0;
					$wp_query->max_num_pages = 0;
				break;
				case '' :
					if ( get_option( 'woocommerce_category_archive_display' ) == 'subcategories' ) {
						$wp_query->post_count    = 0;
						$wp_query->max_num_pages = 0;
					}
				break;
			}
		}

		if ( is_shop() && get_option( 'woocommerce_shop_page_display' ) == 'subcategories' ) {
			$wp_query->post_count    = 0;
			$wp_query->max_num_pages = 0;
		}
	}
	wc_get_template( 'loop/pagination.php' );
}

function ya_woocommerce_catalog_ordering() {
	global $data;
	parse_str($_SERVER['QUERY_STRING'], $params);

	$query_string = '?'.$_SERVER['QUERY_STRING'];

	// replace it with theme option
	if($data['woo_items']) {
		$per_page = $data['woo_items'];
	} else {
		$per_page = 12;
	}

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po  = !empty($params['product_order'])  ? $params['product_order'] : 'asc';
	$pc  = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering clearfix">';

	$html .= '<div class="orderby-order-container">';
	$html .= '<span class="sort">Sort by</span>';
	$html .= '<ul class="orderby order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.__('Sort by', 'yatheme').'</a></span></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pob == 'default') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_orderby', 'default').'">'.__('', 'yatheme').__('Default', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'name') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_orderby', 'name').'">'.__('', 'yatheme').__('Name', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'price') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_orderby', 'price').'">'.__('', 'yatheme').__('Price', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'date') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_orderby', 'date').'">'.__('', 'yatheme').__('Date', 'yatheme').'</a></li>';
	$html .= '<li class="'.(($pob == 'rating') ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_orderby', 'rating').'">'.__('', 'yatheme').__('Rating', 'yatheme').'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '<span class="show-product"> Show </span>';
	$html .= '<ul class="sort-count order-dropdown">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'.__('12', 'yatheme').'</a></span>';
	$html .= '<ul>';
	$html .= '<li class="'.(($pc == $per_page) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page).'">'.$per_page.'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*2) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*2).'">'.($per_page*2).'</a></li>';
	$html .= '<li class="'.(($pc == $per_page*3) ? 'current': '').'"><a href="'.ya_addURLParameter($query_string, 'product_count', $per_page*3).'">'.($per_page*3).'</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	$html .= '<span class="per-page"> per/page </span>';
	$html .= '</div>';
	$html .= '</div>';
	
	echo $html;
}


add_action('woocommerce_get_catalog_ordering_args', 'ya_woocommerce_get_catalog_ordering_args', 20);
function ya_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;

	parse_str($_SERVER['QUERY_STRING'], $params);

	$pob = !empty($params['product_orderby']) ? $params['product_orderby'] : 'default';
	$po = !empty($params['product_order'])  ? $params['product_order'] : 'asc';

	switch($pob) {
		case 'date':
			$orderby = 'date';
			$order = 'desc';
			$meta_key = '';
		break;
		case 'price':
			$orderby = 'meta_value_num';
			$order = 'asc';
			$meta_key = '_price';
		break;
		case 'popularity':
			$orderby = 'meta_value_num';
			$order = 'desc';
			$meta_key = 'total_sales';
		break;
		case 'title':
			$orderby = 'title';
			$order = 'asc';
			$meta_key = '';
		break;
		case 'default':
		default:
			$orderby = 'menu_order title';
			$order = 'asc';
			$meta_key = '';
		break;
	}

	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'asc';
		break;
	}

	$args['orderby'] = $orderby;
	$args['order'] = $order;
	$args['meta_key'] = $meta_key;

	if( $pob == 'rating' ) {
		$args['orderby']  = 'menu_order title';
		$args['order']    = $po == 'desc' ? 'desc' : 'asc';
		$args['order']	  = strtoupper( $args['order'] );
		$args['meta_key'] = '';

		add_filter( 'posts_clauses', 'ya_order_by_rating_post_clauses' );
	}

	return $args;
}
function ya_order_by_rating_post_clauses( $args ) {
	global $wpdb;

	$args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

	$args['join'] .= "
		LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
		LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
	";

	$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

	$args['groupby'] = "$wpdb->posts.ID";

	return $args;
}
add_filter('loop_shop_per_page', 'ya_loop_shop_per_page');
function ya_loop_shop_per_page()
{
	global $data;

	parse_str($_SERVER['QUERY_STRING'], $params);

	if($data['woo_items']) {
		$per_page = $data['woo_items'];
	} else {
		$per_page = 12;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	return $pc;
}
/*********QUICK VIEW PRODUCT**********/

add_action("wp_ajax_ya_quickviewproduct", "ya_quickviewproduct");
add_action("wp_ajax_nopriv_ya_quickviewproduct", "ya_quickviewproduct");
function ya_quickviewproduct(){
	
	$productid = (isset($_REQUEST["post_id"]) && $_REQUEST["post_id"]>0) ? $_REQUEST["post_id"] : 0;
	
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 

		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			global $product;
			ob_start();
			woocommerce_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	echo $output;exit();
}
/* Product loop content */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'ya_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'ya_product_description', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'ya_product_addcart_start', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'ya_product_addcart_mid', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'ya_product_addcart_end', 99 );
function ya_loop_product_title(){
	?>
		<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title() ?></a></h4>
	<?php
}
function ya_product_description(){
	global $post;
	if ( ! $post->post_excerpt ) return;
	
	echo '<div class="item-description">'.wp_trim_words( $post->post_excerpt, 20 ).'</div>';
}
function ya_product_addcart_start(){
	echo '<div class="item-bottom">';
}
function ya_product_addcart_end(){
	echo '</div>';
}
function ya_product_addcart_mid(){
	global $product, $post;
	$html ='';
	$html .= '<div class="item-cart clearfix">';
	/* compare & wishlist */
	if( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ){
		$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
	if( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ){
		$yith_compare = new YITH_Woocompare_Frontend();
		add_shortcode( 'yith_compare_button', array( $yith_compare , 'compare_button_sc' ) );
		$html .= do_shortcode( "[yith_compare_button]" );	
	}	
	$html .= '</div>';
	echo $html;
}
add_filter( 'product_cat_class', 'ya_product_category_class', 2 );
function ya_product_category_class( $classes, $category = null ){
	$ya_product_sidebar = ya_options()->getCpanelValue('sidebar_product');
	if( $ya_product_sidebar == 'left' || $ya_product_sidebar == 'right' ){
		$classes[] = 'col-lg-4 col-md-4 col-sm-6 col-xs-6 col-mb-12';
	}else if( $ya_product_sidebar == 'lr' ){
		$classes[] = 'col-lg-6 col-md-6 col-sm-6 col-xs-6 col-mb-12';
	}else if( $ya_product_sidebar == 'full' ){
		$classes[] = 'col-lg-3 col-md-4 col-sm-6 col-xs-6 col-mb-12';
	}
	return $classes;
}
/* ==========================================================================================
	** Single Product
   ========================================================================================== */
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'ya_product_excerpt', 20 );
function ya_product_excerpt(){
	global $post;
	
	if ( ! $post->post_excerpt ) {
		return;
	}
	$html = '';
	$html .= '<div class="product-description" itemprop="description">';
	$html .= '<h2 class="quick-overview">'. __( 'Quick Overview', 'yatheme' ) .'</h2>';
	$html .= apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	$html .= '</div>';
	echo $html;
}
add_action( 'woocommerce_single_product_summary', 'ya_single_addcart_wrapper_start', 25 );
add_action( 'woocommerce_after_add_to_cart_button', 'ya_single_addcart', 10 );
add_action( 'woocommerce_single_product_summary', 'ya_single_addcart_wrapper_end', 32 );
add_action( 'woocommerce_single_product_summary', 'ya_woocommerce_sharing', 31 );
function ya_woocommerce_sharing(){
	echo get_social();
}
function ya_single_addcart_wrapper_start(){
	echo '<div class="product-summary-bottom clearfix">';
}
function ya_single_addcart_wrapper_end(){
	echo "</div>";
}
function ya_single_addcart(){
	/* compare & wishlist */
	global $product;
	$html = '<div class="clear"></div>';
	$html .= '<div class="single-product-addcart">';
	if( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ){
		$yith_compare = new YITH_Woocompare_Frontend();
		add_shortcode( 'yith_compare_button', array( $yith_compare , 'compare_button_sc' ) );
		$html .= do_shortcode( "[yith_compare_button]" );	
	}
	if( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ){
		$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
	$html .= '<div class="share">'. esc_html__( 'Share', 'yatheme' ) .'</div>';
	$html .= '</div>';
	echo $html;
}
/* Add Product Tag To Tabs */
add_filter( 'woocommerce_product_tabs', 'ya_tab_tag' );
function ya_tab_tag($tabs){
	global $post, $product;
	$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
	if ( count( $tag_count ) > 1 ) {
		$tabs['product_tag'] = array(
			'title'    => __( 'Tags', 'yatheme' ),
			'priority' => 11,
			'callback' => 'ya_single_product_tab_tag'
		);
	}
	return $tabs;
}
function ya_single_product_tab_tag(){
	global $post, $product;
	echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $tag_count, 'woocommerce' ) . ' ', '</span>' );
}
function ya_cpwl_init(){
	if( is_plugin_active( 'yith-woocommerce-compare/init.php' ) ){
		update_option( 'yith_woocompare_compare_button_in_product_page', 'no' );
		update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
	}
	if( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ){
		update_option( 'yith_wcwl_button_position', 'shortcode' );
	}
}
add_action('admin_init','ya_cpwl_init');
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

?>