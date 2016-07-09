<?php

/**
 * WC_Brands class.
 */
class pw_woocommerc_brans_Wc_Brands {
	var $template_url;
	var $plugin_path;
	public function __construct() {
		$this->template_url = apply_filters( 'woocommerce_template_url', 'woocommerce/' );	 	
		add_filter( 'template_include', array( $this, 'template_loader' ) );

		//pw_brand_VC_all_view_product
		add_action('restrict_manage_posts',array( $this,'restrict_listings_by_properties'));
		add_filter('parse_query', array( $this,'convert_id_to_term_in_query'));

		add_action( 'woocommerce_archive_description', array( $this, 'brand_description' ) );
		
		add_action( 'woocommerce_product_meta_end', array( $this,'pw_woocommerc_show_brand' )) ;
		
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'brand_show_title' ) );

	}
	private function includes()
	{
		//woocommerce_product_meta_end
		//woocommerce_single_product_summary
		//woocommerce_after_single_product_summary
		//woocommerce_before_single_product_summary
		//add_action( 'woocommerce_product_meta_end', array( $this,'pw_woocommerc_show_brand' )) ;
	}

	
	public function brand_show_title(){
		if(get_option('pw_wooccommerce_display_brand_in_product_shop')=="yes")
		{		
			global $post;
			$brand="";
			$id=$post->ID;
			//echo '<div>a</div>';
			$tax=(get_option('pw_woocommerce_brands_text')=="" ? "Brand":get_option('pw_woocommerce_brands_text'));			$tax='';
			$brand= $this->pw_woocommerc_get_brands( $post->ID, ', ', '<div class="wb-posted_in text-center">' . $tax . ' ', '</div>');
			//$brands = wp_get_post_terms( $post->ID, "product_brand", array( "fields" => "ids" ) );	
			//echo get_the_term_list( $id, 'product_brand' );
			//print_r(wp_get_object_terms($id, 'product_brand'));
			//echo $post->ID;
			/*if(get_option('pw_woocommerce_brands_image_single')!="yes")
			{
				$terms=get_the_terms( $post->ID, "product_brand");
				if($terms)
				{
					$brand.='<div class="wb-single-img-cnt" >';
					foreach ( $terms as $term ) {
						$url="";
						$url	= esc_html(get_woocommerce_term_meta( $term->term_id, 'url', true ));
						$thumbnail=get_woocommerce_term_meta($term->term_id,'thumbnail_id', true);						
						if($thumbnail)
						{
								$image = wp_get_attachment_thumb_url( $thumbnail );							
								if($url!="")
								{
									$brand.= '<a href="'.$url.'"><img src="'.$image.'"  alt="'. $labels->name.'" /></a>';
								}
								else
								{
									$brand.= '<img src="'.$image.'"  alt="'. $labels->name.'" />';
								}
						}
					}
					$brand.= '</div>';
				}
			}
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." a.add_to_cart_button').before('".$brand."');
						});
					</script>";*/
			echo $brand;
		}
		if(get_option('pw_woocommerce_image_brand_shop_page')=="yes")
		{
			$product_cats = wp_get_post_terms( $post->ID, 'product_brand', array("fields" => "ids"));
			
			$ratio = get_option( 'pw_woocommerce_image_brand_shop_page_image_size', "150:150" );

			list( $width, $height ) = explode( ':', $ratio );				
			foreach($product_cats as $cat)
			{
				$thumbnail=get_woocommerce_term_meta($cat,'thumbnail_id', true);                
				if($thumbnail)
				{            
					$image = wp_get_attachment_thumb_url( $thumbnail );                            
						echo '<img src="'.$image.'" style="width:'.$width.'px;height:'.$height.'px" />';
				}
			}
		}		
/*			if(get_option('pw_position_brand_shop')=="above_title")
			{
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." h3').before('".$brand."');
						});
					</script>";
			}
			elseif(get_option('pw_position_brand_shop')=="below_title")
			{
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." h3').after('".$brand."');
						});
					</script>";
			}
			elseif(get_option('pw_position_brand_shop')=="below_price")
			{
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." span.price').before('".$brand."');
						});
					</script>";
			}
			elseif(get_option('pw_position_brand_shop')=="above_price")
			{
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." span.price').after('".$brand."');
							
						});
					</script>";
			}
			elseif(get_option('pw_position_brand_shop')=="above_add_to_cart")
			{
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." a.add_to_cart_button').before('".$brand."');
						});
					</script>";
				
			}
			elseif(get_option('pw_position_brand_shop')=="below_add_to_cart")
			{
				echo
					"<script type='text/javascript'>
						jQuery(document).ready(function(){
							jQuery('.post-".$id." a.add_to_cart_button').after('".$brand."');
						});
					</script>";
			}

				//if(get_option('pw_woocommerce_brands_text_single')=="yes")

				/*$brands = wp_get_post_terms( $post->ID, "product_brand", array( "fields" => "ids" ) );	
				if(get_option('pw_woocommerce_brands_image_single')=="yes")
				{
					$terms=get_the_terms( $post->ID, "product_brand");
					if($terms)
					{
						foreach ( $terms as $term ) {
							$url="";
							$url	= esc_html(get_woocommerce_term_meta( $term->term_id, 'url', true ));
							
							$thumbnail=get_woocommerce_term_meta($term->term_id,'thumbnail_id', true);						
							if($thumbnail)
							{
									$image = wp_get_attachment_thumb_url( $thumbnail );							
									if($url!="")
									{
										echo '<a href="'.$url.'"><img src="'.$image.'"  alt="'. $labels->name.'" /></a>';
									}
									else
									{
										echo '<img src="'.$image.'"  alt="'. $labels->name.'" />';
									}
							}
						}
					}
				}	

		//$target="jQuery('li.post-" . $post->ID . "').find('h3')";
		//	jQuery('" . $show . "').insertBefore('li.post-" . $post->ID . " h3');
		//	target=jQuery('li.post-" . $post->ID . "').find('h3');
		//jQuery('a').insertBefore(target);		
		//echo '1';
	//jQuery('" . $show . "').insertBefore('.post-" . $post->ID . "');			
//				jQuery(document).ready(function()
	//			{
					//jQuery('.post-" . $post->ID . "').before('<div class='newPrettybox'>Iron man</div>');
					//jQuery('asd').insertBefore('.post-" . $post->ID . "');
					//jQuery('sdsds').insertBefore('li.post-" . $post->ID . " span.price');
					//jQuery('.post-70').before('dsd');
		//		});			
		*/
	}
	
	//jQuery('adsds').insertBefore(target);
	public function brand_description() {

		if ( ! is_tax( 'product_brand' ) )
			return;

		if ( ! get_query_var( 'term' ) )
			return;

		$thumbnail = '';			
		$term = get_term_by( 'slug', get_query_var( 'term' ), 'product_brand' );
		if(get_option('pw_woocommerce_brands_image_list')=="yes")
		{
			
			$thumbnail = $this->get_brand_thumbnail_url( $term->term_id, 'full' );		
		}
		$url="";
		$url	= esc_html(get_woocommerce_term_meta( $term->term_id, 'url', true ));	
		woocommerce_get_template( 'brand-description.php', array(
			'thumbnail'	=> $thumbnail,
			'url'	=> $url
		), 'woocommerce-brands', $this->plugin_path() . '/templates/' );
		
	}

	public function get_brand_thumbnail_url( $brand_id, $size = 'full' ) {
		$thumbnail_id = get_woocommerce_term_meta( $brand_id, 'thumbnail_id', true );

		if ( $thumbnail_id )
			return current( wp_get_attachment_image_src( $thumbnail_id, $size ) );
	}	
	 
	 public function pw_woocommerc_show_brand() {
		global $post;

		if ( is_singular( 'product' ) ) {
			
			if(get_option('pw_woocommerce_brands_show_categories')=="yes")
				$get_terms="product_cat";
			else
				$get_terms="product_brand";
			
			if(get_option('pw_woocommerce_brands_show_categories')=="no" && ( get_option('pw_woocommerce_brands_text_single')=="yes" || get_option('pw_woocommerce_brands_image_single')=="yes") )
			{
				$taxonomy = get_taxonomy( $get_terms); 
				$labels   = $taxonomy->labels;
				$tax=(get_option('pw_woocommerce_brands_text')=="" ? "Brand":get_option('pw_woocommerce_brands_text'));
				if(get_option('pw_woocommerce_brands_text_single')=="yes")
				
					echo $this->pw_woocommerc_get_brands( $post->ID, ', ', ' <div class="wb-posted_in">' . $tax . ': ', '</div>');
				else
					echo $tax .':';
				$brands = wp_get_post_terms( $post->ID, $get_terms, array( "fields" => "ids" ) );	
				if(get_option('pw_woocommerce_brands_image_single')=="yes")
				{
					$terms=get_the_terms( $post->ID, $get_terms );
					if($terms)
					{
						echo '<div class="wb-single-img-cnt" >';
						foreach ( $terms as $term ) {
							$url="";
							$url	= esc_html(get_woocommerce_term_meta( $term->term_id, 'url', true ));

							/*for crup
							$thumbnail=get_woocommerce_term_meta($term->term_id,'thumbnail_id', true);						
							if($thumbnail){
								$thumbnail = current( wp_get_attachment_image_src( $thumbnail, 'full' ));
									if($url!="")
									{
										echo '<a href="'.$url.'"><img src="'.$thumbnail.'"  alt="'. $term->name.'" /></a>';
									}else{
										echo '<a href="'.home_url() .'/?'.$get_terms.'=' . esc_html( $term->slug).'"><img src="'.$thumbnail.'"  alt="'. $labels->name.'" /></a>';
									}
							}
							*/
							$thumbnail=get_woocommerce_term_meta($term->term_id,'thumbnail_id', true);						
							if($thumbnail)
							{
								$ratio = get_option( 'pw_woocommerce_brands_image_single_image_size', "150:150" );
								list( $width, $height ) = explode( ':', $ratio );
								
								$image = wp_get_attachment_thumb_url( $thumbnail );							
								if($url!="")
								{
									echo '<a href="'.$url.'"><img src="'.$image.'"  alt="'. $term->name.'" style="width:'.  $width.'px;height:'. $height.'px" /></a>';
								}
								else
								{
									echo '<a href="'.home_url() .'/?'.$get_terms.'=' . esc_html( $term->slug).'"><img src="'.$image.'"  alt="'. $labels->name.'" style="width:'.$width.'px;height:'.$height.'px" /></a>';
								}
							}
						}
						echo '</div>';
					}
				}	
				//print_r($labels);
				if(get_option('pw_woocommerce_brands_desc_single')=="yes"){
					if($brands)
					{
						$prod_term=get_term($brands[0],'product_brand');
						$description=$prod_term->description;
						echo '<div class="shop_cat_desc">'.$description.'</div>';
					}
				}
			}
		}	
	}
	/**
	 * get_brands function.
	 *
	 * @access public
	 * @param int $post_id (default: 0)
	 * @param string $sep (default: ')
	 * @param mixed '
	 * @param string $before (default: '')
	 * @param string $after (default: '')
	 * @return void
	 */
	 public function pw_woocommerc_get_brands( $post_id = 0, $sep = ', ', $before = '', $after = '' ) {
		global $post;

		if ( $post_id )
			$post_id = $post->ID;
			
		return get_the_term_list( $post_id, 'product_brand', $before, $sep, $after );
	}
	
	/**
	 * Get the plugin path
	 */
	public function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;

		return $this->plugin_path = untrailingslashit( plugin_dir_path( dirname( __FILE__ ) ) );
	}	

	/**
	 * template_loader
	 *
	 * Handles template usage so that we can use our own templates instead of the themes.
	 *
	 * Templates are in the 'templates' folder. woocommerce looks for theme
	 * overides in /theme/woocommerce/ by default
	 *
	 * For beginners, it also looks for a woocommerce.php template first. If the user adds
	 * this to the theme (containing a woocommerce() inside) this will be used for all
	 * woocommerce templates.
	 */
	 
	public function woocommerce_catalog(){
		global $post, $product;
	//	print_r($product);
		$tax=(get_option('pw_woocommerce_brands_text')=="" ? "Brand":get_option('pw_woocommerce_brands_text'));
		echo $this->pw_woocommerc_get_brands( $post->ID, ', ', ' <div class="wb-posted_in">' . $tax . ': ', '</div>' );		
	}
	
	public function template_loader( $template ) {

		$find = array( 'woocommerce.php' );
		$file = '';
		//if(get_option('display_brand_in_product_listing')=="yes"){
		//	if ( is_tax( 'product_cat' ) )
		//	{
			//	add_action('woocommerce_after_shop_loop_item_title',array( $this, 'woocommerce_catalog'));
		//	}
		//}
		if ( is_tax( 'product_brand' ) ) {
			$term = get_queried_object();
			$file 		= 'taxonomy-' . $term->taxonomy . '.php';
			$find[] 	= 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $this->template_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] 	= $file;
			$find[] 	= $this->template_url . $file;
		}

		if ( $file ) {
			$template = locate_template( $find );
			if ( ! $template ) $template = $this->plugin_path() . '/templates/' . $file;
		}
		return $template;
	}

	///////////////ADD FILTER TO ADMIN LIST////////////////////
	public function restrict_listings_by_properties() {
	  global $typenow;
	  global $wp_query;
	  if ($typenow=='product') {
	   $taxonomy = 'product_brand';
	   $business_taxonomy = get_taxonomy($taxonomy);
		wp_dropdown_categories(array(
		'show_option_all' =>  __("Show All a {$business_taxonomy->label}"),
		'taxonomy'        =>  $taxonomy,
		'name'            =>  'product_brand',
		'orderby'         =>  'name',
		'selected'        =>  (isset( $wp_query->query['product_brand']) ? $wp_query->query['product_brand'] : ''),
		'hierarchical'    =>  true,
		'depth'           =>  3,
		'show_count'      =>  true, // Show # listings in parens
		'hide_empty'      =>  true, // Don't show businesses w/o listings
	   ));
	  }
	 }
		 
	public function convert_id_to_term_in_query($query) {
		global $pagenow;
		$post_type = 'product'; // change HERE
		$taxonomy = 'product_brand'; // change HERE
		$q_vars = &$query->query_vars;
		if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
			$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
			$q_vars[$taxonomy] = $term->slug;
		}
	}


}
new pw_woocommerc_brans_Wc_Brands();
?>