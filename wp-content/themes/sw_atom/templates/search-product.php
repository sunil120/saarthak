<?php
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$product_cat = $_GET['search_category'];
	$s = $_GET['s'];	
	$args_product = array(
		's' => $s,
		'post_type'	=> 'product',
		'posts_per_page' => 12,
		'paged' => $paged,
		'meta_query' 	=> array(
			array(
			'key' 		=> '_visibility',
			'value' 	=> array( 'catalog', 'visible' ),
			'compare' 	=> 'IN'
			)
		)
	);
	if( isset( $product_cat ) && $product_cat != '' ){
		$args_product['tax_query'] = array(
			array(
				'taxonomy'	=> 'product_cat',
				'field'		=> 'id',
				'terms'	=> $product_cat				
			)
		);
	}
?>
<div class="content-list-category container">
	<div class="content_list_product">
		<div class="products-wrapper">		
		<?php
			$product_query = new wp_query( $args_product );
			//print '<pre>';var_dump( $product_query ); print '</pre>';
			if( $product_query -> have_posts() ){
			?>
			<ul id="loop-products" class="products-loop row clearfix grid-view grid">
			<?php while( $product_query -> have_posts() ) : $product_query -> the_post(); global $product, $post;?>
				<div class="item col-lg-3 col-md-4 col-sm-4 col-xs-6">
					<div class="item-wrap">
						<div class="item-detail">										
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
									<div class="star"><?php echo ( $average > 0 ) ?'<span style="width:'. ( $average*11 ).'px"></span>' : ''; ?></div>
								</div>	
								<!-- end rating  -->
								<?php if ( $price_html = $product->get_price_html() ){?>
								<div class="item-price">
									<span>
										<?php echo $price_html; ?>
									</span>
								</div>
								<?php } ?>
								<div class="item-cart">
										<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
											sprintf( '<a href="%s" rel="nofollow" title="Add To Cart" data-product_id="%s" data-product_sku="%s" class="button %s product_type_%s">%s</a>',
												esc_url( $product->add_to_cart_url() ),
												esc_attr( $product->id ),
												esc_attr( $product->get_sku() ),
												$product->is_purchasable() ? 'add_to_cart_button' : '',
												esc_attr( $product->product_type ),
												esc_html( $product->add_to_cart_text() )
											), $product );
										?>
								</div>
							</div>
							<div class="item-bottom clearfix">
								<?php if ( in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
										
										if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
											echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
										}
										if ( in_array( 'yith-woocommerce-compare/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
											echo do_shortcode('[yith_compare_button]');
										}
									}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php	endwhile;
				
			?>
			</ul>
			<!--Pagination-->
			<?php if ($product_query->max_num_pages > 1) : ?>
			<div class="pag-search ">
				<div class="pagination nav-pag pull-right">
					<ul class="list-inline">
						<?php if (get_previous_posts_link()) : ?>
						 <li class="prev"><?php previous_posts_link(__('<i class="fa fa-caret-left"></i>', 'yatheme')); ?></li>
						<?php else: ?>
							<li class="disabled prev"><a><?php esc_html_e('<i class="fa fa-caret-left"></i>', 'yatheme'); ?></a></li>
						<?php endif; ?>

						<?php 
					if ($paged < 3){
						$i = 1;
					}
					elseif ($paged < $product_query->max_num_pages - 2){
						$i = $paged -1 ;
					}
					else {
						$i = $product_query->max_num_pages - 3;
					}
					 
					if ($product_query->max_num_pages > $i + 3){
						$max = $i + 2;
					}
					else $max = $product_query->max_num_pages;
			
					if ($paged > 3 && $product_query->max_num_pages > 4) {?>
						<li><a href="<?php echo get_pagenum_link('1')?>">1</a></li>
						<li><a>...</a></li>
						<?php }
					for ($i = 1; $i<= $max ; $i++){?>
					<?php if (($paged == $i) || ( $paged ==1 && $i==1)){?>
						<li class="disabled"><a><?php echo $i?> </a></li>
						<?php } else {?>
						<li><a href="<?php echo get_pagenum_link($i)?>"><?php echo $i?></a></li>
						<?php }?>
					<?php }?>

						<?php if ($max < $product_query->max_num_pages) {?>
						<li><a>...</a></li>
						<li><a
							href="<?php echo get_pagenum_link($product_query->max_num_pages)?>"><?php echo $product_query->max_num_pages?>
						</a></li>
						<?php }?>

						<?php if ( get_next_posts_link() && ( $paged < $product_query->max_num_pages ) ) :  ?>
						<li class="pagination"><?php next_posts_link(__('<i class="fa fa-caret-right"></i>', 'yatheme') ); ?>
						</li>
						<?php else: ?>
						<li class="disabled pagination"><a><?php esc_html_e('<i class="fa fa-caret-right"></i>', 'yatheme'); ?>
						</a></li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
	<?php endif;wp_reset_postdata(); ?>
	<!--End Pagination-->
	<?php 
		}else{
	?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p><?php esc_html_e('No product found.', 'yatheme'); ?></p>
		</div>
	<?php
		}
	?>
		</div>
	</div>
</div>