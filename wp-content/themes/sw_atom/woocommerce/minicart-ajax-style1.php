<?php 
if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) { 
	return false;
}
global $woocommerce; ?>
<div class="top-form top-form-minicart ya-minicart-style1 pull-right">
	<div class="top-minicart-icon pull-right">
		<i class="fa fa-shopping-cart"></i><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'yatheme'); ?>"><?php echo '<span class="minicart-number">'.$woocommerce->cart->cart_contents_count.'</span>';  esc_html_e('item(s)', 'yatheme');?> :  <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	</div>
	<div class="wrapp-minicart">
		<div class="minicart-padding">
			<h2><?php echo esc_html_e('Recent Add Item(s)', 'yatheme');?></h2>
			<ul class="minicart-content">
			<?php foreach($woocommerce->cart->cart_contents as $cart_item_key => $cart_item): ?>
				<li>
					<a href="<?php echo get_permalink($cart_item['product_id']); ?>" class="product-image">
						<?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>
						<?php echo get_the_post_thumbnail($thumbnail_id, array(70,60)); ?>
					</a>
					<?php 	global $product, $post, $wpdb, $average;
			$count = $wpdb->get_var($wpdb->prepare("
				SELECT COUNT(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value > 0
			",$cart_item['product_id']));

			$rating = $wpdb->get_var($wpdb->prepare("
				SELECT SUM(meta_value) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
			",$cart_item['product_id']));?>		
						 
	<div class="detail-item">
		<div class="product-details"> 
				<a href="<?php echo get_permalink($cart_item['product_id']); ?>"><?php echo esc_html( $cart_item['data']->post->post_title ); ?></a>
			<div class="rating-container">
					<div class="ratings">
						 <?php
							if( $count > 0 ){
								$average = number_format($rating / $count, 1);
						?>
							<div class="star"><span style="width: <?php echo ($average*11).'px'; ?>"></span></div>
							
						<?php } else { ?>
						
							<div class="star"></div>
							
						<?php } ?>			      
					
					</div>
			</div>	  		
			<div class="product-price">
				 <span class="price"><?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>		        		        		    		
			</div>
			<div class="qty">
				<span class="qty-label"><?php echo esc_html_e('Qty:', 'yatheme');?></span>
				<?php echo '<span class="qty-number">'.esc_html( $cart_item['quantity'] ).'</span>'; ?>
			</div>
			<div class="product-action">
				<?php echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="btn-remove" title="%s"><span></span></a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key ); ?>           
				<a class="btn-edit" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php esc_html_e('View your shopping cart', 'yatheme'); ?>"><span></span></a>    
			</div>
		</div>	
	</div>
							
	</li>
<?php
endforeach;
?>
</ul>
			<div class="cart-checkout">
			    <div class="price-total">
				   <span class="label-price-total"><?php esc_html_e('Total:', 'yatheme'); ?></span>
				   <span class="price-total-w"><span class="price"><?php echo $woocommerce->cart->get_cart_total(); ?></span></span>
				   
				</div>
				<div class="cart-links">
					<div class="cart-link"><a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" title="Cart"><?php esc_html_e('View Cart', 'yatheme'); ?></a></div>
					<div class="checkout-link"><a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" title="Check Out"><?php esc_html_e('Check Out', 'yatheme'); ?></a></div>
				</div>
			</div>
		</div>
	</div>
</div>