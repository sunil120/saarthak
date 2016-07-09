<?php

function woocs_subcats_from_parentcat($parentcatid = null){
	
	global $wp_query;
	$woocs_cat = $wp_query->get_queried_object();
	$parentcatid = isset($parentcatid) ? $parentcatid : $woocs_cat->term_id;
	$args = array(
		'hierarchical' => 1,
		'show_option_none' => '',
		'hide_empty' => 0,
		'parent' => $parentcatid,
		'taxonomy' => 'product_cat'
	);
	$woocs_subcats = get_categories($args);
	return $woocs_subcats;
}

function woocs_bestseller_of_category($name){
	
	$args = array('post_type' => 'product', 'product_cat' => $name, 'order' => 'DESC', 'meta_key' => 'total_sales', 'orderby' => 'meta_value_num', 'posts_per_page' => 3);
	$woocs_cat_products = new WP_Query($args);
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		$sales = get_post_meta($product->id, 'total_sales', true);
		if( $sales!= 0){
			$woocs_posts[] = $product->post;
		}
	endwhile;
	unset($woocs_cat_products);
	if(!empty($woocs_posts)){
		$rand = rand(0, count($woocs_posts)-1);
		return $woocs_posts[$rand];
	}
	else{
		return false;
	}
}

function woocs_bestsale_of_category($name){
		
	$args = array('post_type' => 'product', 'product_cat' => $name, 'posts_per_page' => -1, 'meta_query' => array( array( 'key' => '_sale_price', 'value'   => array(''), 'compare' => 'NOT IN' )));
	$woocs_cat_products = new WP_Query($args);
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		$woocs_regular = $product->get_regular_price();
		$woocs_sale_price = $product->get_sale_price();
		$woocs_sales[] = $woocs_regular - $woocs_sale_price;
	endwhile;
	if(is_array($woocs_sales)){
		$woocs_bestsale = max($woocs_sales);
	
		while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
			global $product;
			$woocs_regular = $product->get_regular_price();
			$woocs_sale_price = $product->get_sale_price();
			if($woocs_regular - $woocs_sale_price == $woocs_bestsale){
				$woocs_posts[] = $product->post;
			}
		endwhile;
	}
	unset($woocs_cat_products);
	if(!empty($woocs_posts)){
		$rand = rand(0, count($woocs_posts)-1);
		return $woocs_posts[$rand];
	}
	else{
		return false;
	}
}

function woocs_toprated_of_category($name){
	
	$args = array('post_type' => 'product', 'product_cat' => $name, 'posts_per_page' => -1);
	$woocs_cat_products = new WP_Query($args);
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		$woocs_avg = $product->get_average_rating();
		if(!empty($woocs_avg)){
			$woocs_rates[] = $woocs_avg;
		}
	endwhile;
	if(is_array($woocs_rates)){
		$woocs_toprate = max($woocs_rates);
	
		while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
			global $product;
			if($product->get_average_rating() == $woocs_toprate){
				$woocs_posts[] = $product->post;
			}
		endwhile;
	}
	unset($woocs_cat_products);
	if(!empty($woocs_posts)){
		$rand = rand(0, count($woocs_posts)-1);
		return $woocs_posts[$rand];
	}
	else{
		return false;
	}
}

function woocs_get_highest($name){
	$args = array('post_type' => 'product', 'product_cat' => $name, 'order' => 'DESC', 'meta_key' => '_regular_price', 'orderby' => 'meta_value_num', 'posts_per_page' => 20 );
	$woocs_cat_products = new WP_Query($args);
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		if($product->get_sale_price()){
			$woocs_price = $product->get_sale_price();
		}
		else{
			$woocs_price = $product->get_price();
		}
		if(!empty($woocs_price)){
			$woocs_prices[] = $woocs_price;
		}
	endwhile;
	if(is_array($woocs_prices)){
		$woocs_topprice = max($woocs_prices);
		
		while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
			global $product;
			if($product->get_regular_price() == $woocs_topprice || $product->get_price() == $woocs_topprice){
				$woocs_posts[] = $product->post;
			}
		endwhile;
	}
	unset($woocs_cat_products);
	if(!empty($woocs_posts)){
		$rand = rand(0, count($woocs_posts)-1);
		return $woocs_posts[$rand];
	}
	else{
		return false;
	}
}

function woocs_get_lowest($name){
	$args = array('post_type' => 'product', 'product_cat' => $name, 'order' => 'ASC', 'meta_key' => '_regular_price', 'orderby' => 'meta_value_num', 'posts_per_page' => 100 );
	$woocs_cat_products = new WP_Query($args);
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		if($product->get_sale_price()){
			$woocs_price = $product->get_sale_price();
		}
		else{
			$woocs_price = $product->get_price();
		}
		if(!empty($woocs_price)){
			$woocs_prices[] = $woocs_price;
		}
	endwhile;
	if(is_array($woocs_prices)){
		$woocs_lowprice = min($woocs_prices);
		
		while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
			global $product;
			if($product->get_sale_price() == $woocs_lowprice || $product->get_price() == $woocs_lowprice){
				$woocs_posts[] = $product->post;
			}
		endwhile;
	}
	unset($woocs_cat_products);
	if(!empty($woocs_posts)){
		$rand = rand(0, count($woocs_posts)-1);
		return $woocs_posts[$rand];
	}
	else{
		return false;
	}
}


function woocs_product( $ID, $attr, $currency = true ){
	if(class_exists('WC_Product')){
		$product = new WC_Product($ID);  
		if( $attr == 'price_tax_inc' ){
			$p = round($product->get_price_including_tax(),2);
		}
		elseif( $attr == 'get_price_excluding_tax' ){
			$p = round($product->get_price_excluding_tax(),2);
		}
		elseif( $attr == 'get_price' ){
			$p = round($product->get_price(),2);
		}
		elseif( $attr == 'get_sale_price' ){
			$p = round($product->get_sale_price(),2);
		}
		elseif( $attr == 'get_regular_price' ){
			$p = round($product->get_regular_price(),2);
		}
		elseif( $attr == 'get_price_html' ){
			$p = strip_tags($product->get_price_html());
		}
		elseif( $attr == 'is_in_stock' ){
			$p = $product->is_in_stock();
		}
		
	}
	return $p;
}

function woocs_get_thumbnail_by_id($id, $size = 'large'){
	$woocs_thumbnail_id = get_woocommerce_term_meta($id, 'thumbnail_id', true);
	$woocs_image = wp_get_attachment_image_src($woocs_thumbnail_id, $size, false);
	return $woocs_image[0];
}

function woocs_get_products_by_category($name){
	global $product;
	$args = array('post_type' => 'product', 'product_cat' => $name, 'posts_per_page' => -1);
	$woocs_cat_products = new WP_Query($args);
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		if($product->product_type == 'grouped'){
			$args2 = array('post_type' => 'product', 'post_parent' => $product->ID);
			$woocs_children = new WP_Query($args2);
			while ($woocs_children->have_posts()) : $woocs_children->the_post();
			global $product;
			$woocs_child_price = $product->get_price();
			if(!empty($woocs_child_price)){
				$woocs_prices[] = round($woocs_child_price,1);
			}
			endwhile;
		}
		else{
			$woocs_price = $product->get_price();
			if(!empty($woocs_price)){
				$woocs_prices[] = round($woocs_price,1);
			}
		}
	endwhile;
	
	return $woocs_prices;
}

function woocs_text($input, $length, $ellipses = true, $strip_html = true) {
    if ($strip_html) { $input = strip_tags($input); }
    if(function_exists('mb_substr')){
		if (mb_strlen($input) <= $length) { return $input; }
		$last_space = mb_strrpos(mb_substr($input, 0, $length), ' ');
		$trimmed_text = mb_substr($input, 0, $last_space);
  	}
	else{
		if (strlen($input) <= $length) { return $input; }
		$last_space = strrpos(substr($input, 0, $length), ' ');
		$trimmed_text = substr($input, 0, $last_space);
	}
	if ($ellipses) { $trimmed_text .= ' ...'; }
    return $trimmed_text;
}

function woocs_get_featured_by_category($name, $count = 5, $type = 'all'){
	
	if(!$count) $count = 5;
	if(!$type) $type = get_option('woocs_t4_list_type');
	
	if( $type == 'featured' ){
		$args = array('post_type' => 'product', 'product_cat' => $name, 'orderby' => 'rand', 'posts_per_page' => $count, 'meta_key' => '_featured', 'meta_value' => 'yes');
	}
	else{
		$args = array('post_type' => 'product', 'product_cat' => $name, 'orderby' => 'rand', 'posts_per_page' => $count );
	}
	
	$woocs_cat_products = new WP_Query($args);
	
	while ($woocs_cat_products->have_posts()) : $woocs_cat_products->the_post();
		global $product;
		$woocs_products[] = $product->post;
	endwhile;
	return $woocs_products;
}

function woocs_taxonomy_add_new_meta_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[custom_term_meta]"><?php _e( 'Slider layout for this category', 'default' ); ?></label>
        <select name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]">
            <option value="9999">Default</option>
			<option value="1">Layout 1</option>
			<option value="2">Layout 2</option>
            <option value="-1">Disable</option>
		</select>
    </div>
<?php
}
add_action( 'product_cat_add_form_fields', 'woocs_taxonomy_add_new_meta_field', 10, 2 );

function woocs_taxonomy_edit_meta_field($term) {
 
    // put the term ID into a variable
    $t_id = $term->term_id;
 
    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" );
	$cterm = intval($term_meta['custom_term_meta']);
	//var_dump($term_meta);
	 ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[custom_term_meta]"><?php _e( 'Slider layout for this category', 'default' ); ?></label></th>
        <td>
            <select name="term_meta[custom_term_meta]" id="term_meta[custom_term_meta]">
				<option value="9999">Default</option>
				<option value="1" <?php if($term_meta !== false && $cterm === 1){echo "selected";} ?>>Layout 1</option>
				<option value="2" <?php if($term_meta !== false && $cterm === 2){echo "selected";} ?>>Layout 2</option>
                <option value="-1" <?php if($term_meta !== false && $cterm === -1){echo "selected";} ?>>Disable</option>
			</select>
        </td>
    </tr>
<?php
}
add_action( 'product_cat_edit_form_fields', 'woocs_taxonomy_edit_meta_field', 10, 2 );

function woocs_save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}  
add_action( 'edited_product_cat', 'woocs_save_taxonomy_custom_meta', 10, 2 );  
add_action( 'create_product_cat', 'woocs_save_taxonomy_custom_meta', 10, 2 );



			
function woocs_type1($autoslide, $speed, $pager, $controls, $subcats, $subcat_count, $currency, $numberofrows = null, $title_length, $description_length = null){
	
	if(!empty($subcats)){
		echo "<div class='woocs1' autoslide='$autoslide' speed='$speed' pager='$pager' count='$subcat_count' control='$controls'>";
		foreach($subcats as $woocsub){
		
			if( $woocsub->count == 0 ) continue;
			
			$image = woocs_get_thumbnail_by_id($woocsub->term_id, 'thumbnail');
			if(!empty($image)){
				$thumb = $image;
			}
			else{
				$thumb = plugins_url()."/woocommerce/assets/images/placeholder.png";
			}
			
			$term_link = get_category_link($woocsub);
			$title = (strlen(strip_tags($woocsub->name)) > $title_length) ? woocs_text($woocsub->name, $title_length) : strip_tags($woocsub->name);
			
			echo "<li><div class='woocs_container'>";
			echo "<div class='woocs_thumb'><a href='$term_link'><img src='$thumb'/></a></div>";
			echo "<div class='woocs_title'><a href='$term_link'>$title</a></div>";
			echo "<div class='woocs_count'>$woocsub->count ".get_option('woocs_ph_products')."</div>";
			
			$prices = woocs_get_products_by_category($woocsub->slug);
			if(!empty($prices)/*count($prices) > 1*/){
				$max_price = max($prices);
				$min_price = min($prices);
				if($max_price == $min_price){
					echo "<div class='woocs_price_range'><span style='font-size:13px;'>".get_option('woocs_ph_all_for')."</span> ".$currency.$min_price."</div>";
				}
				else{
					echo "<div class='woocs_price_range'><span style='font-size:12px;'>".get_option('woocs_ph_from')."</span> ".$currency.$min_price." <span style='font-size:12px;'>".get_option('woocs_ph_to')."</span> ".$currency.$max_price."</div>";
				}
			}
			echo "</div></li>";
		}
		echo '</div>';
	}
	
}

function woocs_type2($autoslide, $speed, $pager, $controls, $subcats, $subcat_count, $currency, $numberofrows, $title_length, $description_length = null){
	
	if( !$numberofrows ) $numberofrows = get_option('woocs_t2_numberofrows');
	
	if(!empty($subcats)){
		echo "<div class='woocs2' autoslide='$autoslide' speed='$speed' pager='$pager' count='".ceil($subcat_count/$numberofrows)."' control='$controls'>";
		$i = 0;
		foreach($subcats as $woocsub){
		//	echo '<pre>';print_r($woocsub);echo '</pre>';
		
			if( $woocsub->count == 0 ) continue;
		
			$image = woocs_get_thumbnail_by_id($woocsub->term_id, 'thumbnail');
			if(!empty($image)){
				$thumb = $image;
			}
			else{
				$thumb = plugins_url()."/woocommerce/assets/images/placeholder.png";
			}
			$term_link = get_category_link($woocsub);
			$title = (strlen(strip_tags($woocsub->name)) > $title_length) ? woocs_text($woocsub->name, $title_length) : strip_tags($woocsub->name);
			if($i % $numberofrows == 0){
				echo "<li><div class='woocs_col'>";
			}
			echo "<div class='woocs_container'>";
			echo "<div class='woocs_thumb'><a href='$term_link'><img src='$thumb'/></a></div>";
			echo "<div class='woocs_title'><a href='$term_link'>$title</a></div>";
			echo "</div><br>";
			$i++;
			if($i % $numberofrows == 0 || $i == count($subcats)){
				echo "</div></li>";
			}

		}
		echo '</div>';
	}
}





