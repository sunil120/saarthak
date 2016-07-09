<?php $ya_direction = ya_options()->getCpanelValue( 'direction' ); ?>
<?php
	$default = array(
		'post_type' => 'product',		
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			),
			array(
				'key' => '_sale_price',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC'
			),
			array(
				'key' => '_sale_price_dates_to',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC'
			)
		),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
	if( $category != '' ){
		$default['tax_query'] = array(
			array(
				'taxonomy'	=> 'product_cat',
				'field'		=> 'id',
				'terms'		=> $category));
	}	
	$id = 'sw-count-down_'.rand().time();
	$list = new WP_Query( $default );
	do_action( 'before' ); 
	if ( $list -> have_posts() ){
 ?>

        <div id="<?php echo $id; ?>" class="sw-woo-container-slider responsive-slider countdown-slider loading <?php echo $style; ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">       
			<div class="resp-slider-container">
				<div class="box-slider-title <?php echo esc_html($header_style);?>" >
					<?php echo '<h2><span>'. esc_html( $title1 ) .'</span></h2>'; ?>
				</div>
				<div class="slider responsive">	
				<?php 
					$count_items = 0;
					$count_items = ($numberposts >= $list->found_posts) ? $list->found_posts : $numberposts;
					$i = 0;
					while($list->have_posts()): $list->the_post();					
					global $product, $post, $wpdb, $average;
					$start_time = get_post_meta( $post->ID, '_sale_price_dates_from', true );
					$countdown_time = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
					$orginal_price = get_post_meta( $post->ID, '_regular_price', true );	
					$sale_price = get_post_meta( $post->ID, '_sale_price', true );	
					$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
					if( $i % $item_row == 0 ){
				?>
					<div class="item item-countdown" id="<?php echo 'product_'.$id.$post->ID; ?>">
					<?php } ?>
						<div class="item-wrap">
							<div class="item-detail">
								<div class="item-image-countdown">
									<?php
										/* quickview */
										$nonce = wp_create_nonce("ya_quickviewproduct_nonce");
										$link = admin_url('admin-ajax.php?ajax=true&amp;action=ya_quickviewproduct&amp;post_id='.$post->ID.'&amp;nonce='.$nonce);
										$linkcontent ='<a href="'. $link .'" data-fancybox-type="ajax" class="group fancybox fancybox.ajax">'.apply_filters( 'out_of_stock_add_to_cart_text', __( 'Quick View ', 'yatheme' ) ).'</a>';	
									?>
									<div class="products-thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_post_thumbnail( 'shop_catalog' ); ?></a></div>
									<?php echo $linkcontent; ?>
								</div>
								<div class="item-content">
									<h4><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h4>
									<!-- rating  -->
									<?php 
										$rating_count = $product->get_rating_count();
										$review_count = $product->get_review_count();
										$average      = $product->get_average_rating();
									?>
									<div class="reviews-content">
										<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*11 ).'px"></span>' : ''; ?></div>
										<div class="item-number-rating">
											<?php //echo $review_count; _e(' Review(s)', 'yatheme');?>
										</div>
									</div>									
									<!-- end rating  -->
									<!-- Price -->
									<?php if ( $price_html = $product->get_price_html() ){?>								
									<div class="item-price">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
									<?php } ?>
									<div class="product-countdown"  data-price="<?php echo esc_attr( $symboy.$orginal_price ); ?>" data-starttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo 'product_'.$id.$post->ID; ?>"></div>
								</div>
								<div class="sale-off">
									<div class="sale"><?php echo esc_html('Save'); ?></div>
									<div class="percent"><?php $sale_off = 100 - (($sale_price/$orginal_price)*100); echo round($sale_off).'%';?></div>
								</div>
							</div>
						</div>
					<?php if( ( $i+1 ) % $item_row == 0 || ( $i+1 ) == $count_items ){?> </div><?php } ?>
				<?php $i ++; endwhile; wp_reset_query();?>
				</div>
			</div>            
        </div>
    <?php
    } 
?>