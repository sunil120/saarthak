<?php
	global $wpdb;
	$ya_direction 	  = ya_options()->getCpanelValue( 'direction' );
	$id 			  = $this -> number;
	$id ++;
	$widget_id 		  = isset( $widget_id ) ? $widget_id : 'total_sale_slider_'.$id;
	$query            = array();
	$query['fields']  = "select SUM( order_item_meta.meta_value ) as qty, order_item_meta_2.meta_value as product_id
		FROM {$wpdb->posts} as posts";
	$query['join']    = "INNER JOIN {$wpdb->prefix}woocommerce_order_items AS order_items ON posts.ID = order_id ";
	$query['join']   .= "INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id ";
	$query['join']   .= "INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS order_item_meta_2 ON order_items.order_item_id = order_item_meta_2.order_item_id ";
	$query['where']   = "WHERE posts.post_type IN ( '" . implode( "','", wc_get_order_types( 'order-count' ) ) . "' ) ";
	$query['where']  .= "AND posts.post_status IN ( 'wc-" . implode( "','wc-", apply_filters( 'woocommerce_reports_order_statuses', array( 'completed', 'processing', 'on-hold' ) ) ) . "' ) ";
	$query['where']  .= "AND order_item_meta.meta_key = '_qty' ";
	$query['where']  .= "AND order_item_meta_2.meta_key = '_product_id' ";
	if( $from_date != '' ){
		$query['where']  .= "AND posts.post_date >= '" . date( 'Y-m-d', strtotime( $from_date ) ) . "' ";
	}
	if( $to_date != '' ){
		$query['where']  .= "AND posts.post_date <= '" . date( 'Y-m-d', strtotime( $to_date ) ) . "' ";
	}
	$query['groupby'] = "GROUP BY product_id";
	$query['orderby'] = "ORDER BY qty DESC";
	$query['limits']  = "LIMIT $numberposts";
	
	$top_seller = $wpdb->get_results( implode( ' ', apply_filters( 'woocommerce_dashboard_status_widget_top_seller_query', $query ) ) );
	
	/* 	add_filter(  'posts_where', 'ya_filter_where' );
	function ya_filter_where( $where ) {
		$where .= " AND post_date >= '2015-07-29' AND post_date <= '2015-08-01'";
		return $where;
	}
	$query = new wp_query( array( 'post_type' => 'shop_order', 'post_status' => 'wc-on-hold' ) );
	print '<pre>';var_dump( $top_seller ); print '</pre>';
	remove_filter( 'posts_where', 'ya_filter_where' ); */
	if( count( $top_seller ) < 1 ){
		return;
	}
	$post_id	= array();
	$total_sale = array();
	foreach( $top_seller as $key => $top ){
		$post_id[$key] 		= $top->product_id;
		$total_sale[$key]	= $top->qty;
	}
	$args = array(
		'post_type'	=> 'product',
		'post__in'	=> $post_id
	);
	$list = new WP_Query( $args );
	if ( $list -> have_posts() ){
		$i = 0;
?>
	<div id="<?php echo $widget_id; ?>" class="sw-woo-container-slider woo-total-sale-slider responsive-slider loading <?php echo esc_html($style); ?>" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
		<div class="block-title" >
			<h2><?php echo $title1; ?></h2>
		</div>          
		<div class="resp-slider-container">
			<div class="slider responsive">	
			<?php 
				while($list->have_posts()): $list->the_post();
				global $product, $post, $wpdb, $average; 				
			?>
				<div class="item">
						<div class="item-wrap">
							<div class="item-detail">
								<div class="item-top">
									<span class="item-number"><?php echo $i + 1; ?></span>
									<span class="item-total-sales"><?php echo $total_sale[$i] .__( ' sale(s)', 'smartaddons' ); ?></span>
								</div>
								<div class="item-img products-thumb">											
									<!-- quickview & thumbnail  -->
									<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
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
										<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*13 ).'px"></span>' : ''; ?></div>
										<div class="item-number-rating">
											<?php //echo $review_count; _e(' Review(s)', 'yatheme');?>
										</div>
									</div>	
									<!-- end rating  -->
									<?php if ( $price_html = $product->get_price_html() ){?>
									<div class="item-price theme-clearfix">
										<span>
											<?php echo $price_html; ?>
										</span>
									</div>
									<?php } ?>
									<!-- Add To Cart  -->
									<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
								</div>																
							</div>
						</div>
					</div>
				<?php $i ++; endwhile; wp_reset_postdata();?>
			</div>
		</div>            
	</div>
<?php 
	}
?>