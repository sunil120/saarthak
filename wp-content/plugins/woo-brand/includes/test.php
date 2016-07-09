<?php 
function woo_brands_filter( $filtered_posts ) {
	global $woocommerce, $_chosen_attributes;

	if ( is_tax('product_cat') && ! is_admin() ) {

		if ( ! empty( $_GET[ 'filter_product_brand' ] ) ) {

			$terms 	= array_map( 'intval', explode( ',', $_GET[ 'filter_product_brand' ] ) );

			if ( sizeof( $terms ) > 0 ) {

				$_chosen_attributes['product_brand']['terms'] = $terms;
				$_chosen_attributes['product_brand']['query_type'] = 'and';

				$matched_products = get_posts(
					array(
						'post_type' 	=> 'product',
						'numberposts' 	=> -1,
						'post_status' 	=> 'publish',
						'fields' 		=> 'ids',
						'no_found_rows' => true,
						'tax_query' => array(
							'relation' => 'AND',
							array(
								'taxonomy' 	=> 'product_brand',
								'terms' 	=> $terms,
								'field' 	=> 'id'
							)
						)
					)
				);

				$woocommerce->query->layered_nav_post__in = array_merge( $woocommerce->query->layered_nav_post__in, $matched_products );
				$woocommerce->query->layered_nav_post__in[] = 0;

				if ( sizeof( $filtered_posts ) == 0 ) {
					$filtered_posts = $matched_products;
					$filtered_posts[] = 0;
				} else {
					$filtered_posts = array_intersect( $filtered_posts, $matched_products );
					$filtered_posts[] = 0;
				}

			}

		}


    }

    return (array) $filtered_posts;
}
add_action( 'loop_shop_post_in', 'woo_brands_filter', 11 );

		

add_shortcode( 'pw_brand_carousela', 'pw_brand_carousel_func_a' );
function pw_brand_carousel_func_a( $atts, $content = null ) {
	global $_chosen_attributes, $woocommerce, $_attributes_array;
	//Add BxSlider
	wp_enqueue_style('woob-bxslider-style');	
	wp_enqueue_script('woob-bxslider-script');
	$pw_brand=$pw_show_image=$pw_tooltip=$pw_except_brand=$pw_featured=$pw_show_title=$pw_show_count=$pw_style=$pw_round_corner=
	$pw_item_width=$pw_item_marrgin=$pw_slide_direction=$pw_show_pagination=$pw_show_control
	=$pw_item_per_view=$pw_item_per_slide=$pw_slide_speed=$pw_auto_play="";
	extract(shortcode_atts( array(
		'pw_brand' => '',
		'pw_except_brand' => '',
		'pw_style' => '',
		'pw_tooltip' => '',
		'pw_round_corner' => '',
		'pw_show_image' => '',
		'pw_featured' => '',
		'pw_show_title' => '',
		'pw_show_count' => '',
		'pw_item_width' => '300',
		'pw_item_marrgin' => '10',
		'pw_slide_direction' => '',
		'pw_show_pagination' => '',
		'pw_show_control' => '',
		'pw_item_per_view' => '3',
		'pw_item_per_slide' => '1',
		'pw_slide_speed' => '',
		'pw_auto_play' => '',
	),$atts));
	//print_r($atts);
	if(get_option('pw_woocommerce_brands_show_categories')=="yes")
		$get_terms="product_cat";
	else
		$get_terms="product_brand";
	
	$exclude = array_map( 'intval', explode( ',', $pw_except_brand ) );
	//$exclude=$pw_except_brand;
	if($pw_except_brand =="null" || $pw_except_brand=="all"|| $pw_except_brand=="")
		$exclude="";
	
	$include = array_map( 'intval', explode( ',', $pw_brand ) );
	//$include=$pw_brand;
	if($pw_brand =="null" || $pw_brand=="all" || $pw_brand=="")
		$include="";
	$args = array(
		'orderby'           => 'name', 
		'order'             => 'ASC',
		'hide_empty'        => false,
		'exclude'           => $exclude, 
		'exclude_tree'      => array(), 
		'include'           => $include,
		'number'            => '', 
		'fields'            => 'all', 
		'slug'              => '',
		'name'              => '',
		'parent'            => '',
		'hierarchical'      => true, 
		'child_of'          => 0, 
		'get'               => '', 
		'name__like'        => '',
		'description__like' => '',
		'pad_counts'        => false, 
		'offset'            => '', 
		'search'            => '', 
		'cache_domain'      => 'core'
	);	
	$categories = get_terms( $get_terms, $args);
	$ret="";
	$did=rand(0,1000);
	$count='';
	$pw_item_width = (trim($pw_item_width)=='')?300:$pw_item_width;
	$pw_item_marrgin = (trim($pw_item_marrgin)=='')?10:$pw_item_marrgin;
	$pw_item_per_view = (trim($pw_item_per_view)=='')?3:$pw_item_per_view;
	$pw_item_per_slide = (trim($pw_item_per_slide)=='')?1:$pw_item_per_slide;
	$pw_auto_play = ((trim($pw_auto_play)=='') || (!isset($pw_auto_play)))?'false':$pw_auto_play;
	
	$ret .= '<ul class="wb-bxslider wb-car-car  wb-carousel-layout wb-car-cnt '.$pw_style.' '.$pw_round_corner.'" id="slider_'.$did.'" >';
	foreach( (array) $categories as $term ) {
		$display_featured	= get_woocommerce_term_meta( $term->term_id, 'featured', true );
		
		$url= esc_html(get_woocommerce_term_meta( $term->term_id, 'url', true ));
		if($url=="")
			$url= get_term_link( $term->slug, $get_terms );

		$image= '';
		if($pw_show_count=="yes") $count=' ('.esc_html( $term->count).')';
		if($pw_show_image=="yes")
		{
			$thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
			if ( $thumbnail_id )
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			else
			{
				if(get_option('pw_woocommerce_brands_default_image'))
					$image=wp_get_attachment_thumb_url(get_option('pw_woocommerce_brands_default_image'));
				else
					$image = WP_PLUGIN_URL.'/woo-brands/img/default.png';
			}
		}
				
				$current_term 	= $_attributes_array && is_tax( $_attributes_array ) ? get_queried_object()->term_id : '';
		$current_tax 	= $_attributes_array && is_tax( $_attributes_array ) ? get_queried_object()->taxonomy : '';
		
		
					$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
					//print_r($link);
					$current_filter = ( isset( $_GET[ 'filter_product_brand' ] ) ) ? explode( ',', $_GET[ 'filter_product_brand' ] ) : array();

					if ( ! is_array( $current_filter ) )
						$current_filter = array();

					if ( ! in_array( $term->term_id, $current_filter ) )
						$current_filter[] = $term->term_id;		
					
					$link = add_query_arg( 'filter_product_brand', implode( ',', $current_filter ), $link );
				//	echo '<a href='.$link.'/>asd</a>';
			if($pw_featured=="yes" && $display_featured==1)
			{
				$ret .='<li>
					<div class="wb-car-item-cnt" rel="tipsy" title="'.$term->name.$count.'">';
				if ($image!='')	{  
					$ret .='<a href="'.$link.'">'.'<img src="'.$image.'" >'.'</a>';
				}
				if ($pw_show_title=='yes'){
					$ret.='<div class="wb-car-title"><a  href="'.$link.'" title="'.$term->name.'" >'.$term->name.'</a>'.$count.'</div>';
				}
				$ret .='</div>
				</li>';
			}
			elseif($pw_featured=="no")
			{

				$ret .='<li>
					<div class="wb-car-item-cnt" rel="tipsy" title="'.$term->name.$count.'">';
				if ($image!='')	{  
					$ret .='<a href="'.$link.'" >'.'<img src="'.$image.'" >'.'</a>';
				}
				if ($pw_show_title=='yes'){
					$ret.='<div class="wb-car-title"><a  href="'.$link.'" title="'.$term->name.'" >'.$term->name.'</a>'.$count.'</div>';
				}
				$ret .='</div>
				</li>';
			}
		
		
	}
	$ret .='</ul>';
	if ( $pw_tooltip=='yes' ){
		$ret .="
		<script type='text/javascript'>
			jQuery(function() {
			   jQuery('#slider_" . $did ." div[rel=tipsy]').tipsy({ gravity: 's',live: true,fade:true});
			});
		</script>";
	}
	$ret .="<script type='text/javascript'>
                jQuery(document).ready(function() {
                    slider" . $did ." =
					 jQuery('#slider_" . $did ."').bxSlider({ 
						  mode : '".($pw_slide_direction=='vertical' ? 'vertical' : 'horizontal' )."' ,
						  touchEnabled : true ,
						  adaptiveHeight : true ,
						  slideMargin : ".$pw_item_marrgin." , 
						  wrapperClass : 'wb-bx-wrapper wb-car-car ' ,
						  infiniteLoop:true,
						  pager:".($pw_show_pagination =='true'?'true':'false').",
						  controls:".($pw_show_control=='true'?'true':'false').",".
						  ($pw_slide_direction=='horizontal' ? 'slideWidth:'.$pw_item_width.',' : 'slideWidth:5000,' )."
						  minSlides: ". $pw_item_per_view.",
						  maxSlides: ". $pw_item_per_view.",
						  moveSlides: ".$pw_item_per_slide.",
						  auto: ". $pw_auto_play.",
						  pause : ". $pw_slide_speed .",
						  autoHover  : true , 
 						  autoStart: true,
						  responsive:false,
					 });";
					 if ($pw_auto_play=='true'){
					 $ret.="
						 jQuery('.wb-bx-wrapper .wb-bx-controls-direction a').click(function(){
							  slider" . $did .".startAuto();
						 });
						 jQuery('.wb-bx-pager a').click(function(){
							 var i = jQuery(this).data('slide-index');
							 slider" . $did .".goToSlide(i);
							 slider" . $did .".stopAuto();
							 restart=setTimeout(function(){
								slider" . $did .".startAuto();
								},1000);
							 return false;
						 });";
					 }
               $ret.=" });	
            </script>";
	return $ret;
}		
?>