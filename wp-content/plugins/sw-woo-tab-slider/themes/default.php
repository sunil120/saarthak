<?php 
	if( $category == '' ){
		echo __( 'Please select a category!', 'smartaddons' );
		return ;
	}
	$ya_direction = ya_options()->getCpanelValue( 'direction' );
	$id = $this -> number;
	$id ++;
	$tag_id = 'sw_woo_tab_' .rand().time();
	//var_dump( $select_order );
	if( !is_array( $select_order ) ){
		$select_order = explode( ',', $select_order );
	}
	$term = get_term($category, 'product_cat');	
	if( $term == NULL ){
		echo __( 'Please select a category!', 'smartaddons' );
		return ;
	}
?>
<div class="sw-woo-tab loading" id="<?php echo esc_attr( $tag_id ); ?>" >
	<div class="resp-tab" style="position:relative;">
		<div class="top-tab-slider clearfix">
			<div class="order-title">
				<?php echo '<h2>'. $term->name . '</h2>'; ?>
			</div>
			<ul class="nav nav-tabs">
			<?php 
					$tab_title = '';
					foreach( $select_order as $i  => $so ){						
						switch ($so) {
						case 'latest':
							$tab_title = __( 'Latest Products', 'smartaddons' );
						break;
						case 'rating':
							$tab_title = __( 'Top Rating Products', 'smartaddons' );
						break;
						case 'bestsales':
							$tab_title = __( 'Best Selling Products', 'smartaddons' );
						break;						
						default:
							$tab_title = __( 'Featured Products', 'smartaddons' );
						}
				?>
				<li <?php echo ( $i == 0 )? 'class="active"' : ''; ?>>
					<a href="#<?php echo $so . '_' . $category.$id; ?>" data-toggle="tab">
						<?php echo esc_html( $tab_title ); ?>
					</a>
				</li>			
			<?php } ?>
			</ul>
		</div>		
		<div class="category-slider-content clearfix">
			<!-- Get child category -->
			<?php 
				$termchild = get_term_children( $category, 'product_cat' );
				if( count( $termchild ) > 0 ){
			?>
			<div class="childcat-slider pull-left">
			<?php 
				$thumbnail_id 	= absint( get_metadata( 'woocommerce_term', $category, 'thumbnail_id', true ) ); 
				$thumb 			= wp_get_attachment_image( $thumbnail_id, 'full' );
			?>
				<div class="childcat-thumb">
					<?php echo $thumb; ?>			
				</div>
				<div class="childcat-content">
				<?php 
					$termchild = get_term_children( $term->term_id, 'product_cat' );
					echo '<ul>';
					foreach ( $termchild as $child ) {
						$term = get_term_by( 'id', $child, 'product_cat' );
						echo '<li><a href="' . get_term_link( $child, 'product_cat' ) . '">' . $term->name . '</a></li>';
					}
					echo '</ul>';
				?>
				</div>
			</div>
			<?php } ?>
		<!-- End get child category -->		
			<div class="tab-content clearfix">	
			<!-- Product tab slider -->
			<?php foreach( $select_order as $i  => $so ){ ?>
				<div class="tab-pane <?php echo ( $i == 0 ) ? 'active' : ''; ?>" id="<?php echo $so . '_' . $category.$id; ?>">
				<?php
					global $woocommerce;
					$default = array();
					if( $so == 'latest' ){
						$default = array(
							'post_type'	=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'		=> 'id',
									'terms'		=> $category,
									'operator' 	=> 'IN'
								)
							),
							'paged'		=> 1,
							'showposts'	=> $numberposts,
							'orderby'	=> 'date'
						);
					}
					if( $so == 'rating' ){
						$default = array(
							'post_type'		=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'		=> 'id',
									'terms'		=> $category,
									'operator' 	=> 'IN'
								)
							),
							'post_status' 	=> 'publish',
							'no_found_rows' => 1,					
							'showposts' 	=> $numberposts						
						);
						$default['meta_query'] = WC()->query->get_meta_query();
						add_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
						//var_dump($woocommerce->query);
					}
					if( $so == 'bestsales' ){
						$default = array(
							'post_type' 			=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'	=> 'id',
									'terms'	=> $category,
									'operator' => 'IN'
								)
							),
							'post_status' 			=> 'publish',
							'ignore_sticky_posts'   => 1,
							'paged'	=> 1,
							'showposts'				=> $numberposts,
							'meta_key' 		 		=> 'total_sales',
							'orderby' 		 		=> 'meta_value_num',
							'meta_query' 			=> array(
								array(
									'key' 		=> '_visibility',
									'value' 	=> array( 'catalog', 'visible' ),
									'compare' 	=> 'IN'
								)
							)
						);
					}
					if( $so == 'featured' ){
						$default = array(
							'post_type'	=> 'product',
							'tax_query' => array(
								array(
									'taxonomy'	=> 'product_cat',
									'field'	=> 'id',
									'terms'	=> $category,
									'operator' => 'IN'
								)
							),
							'post_status' 			=> 'publish',
							'ignore_sticky_posts'	=> 1,
							'posts_per_page' 		=> $numberposts,
							'meta_query'			=> array(
								array(
									'key' 		=> '_visibility',
									'value' 	=> array('catalog', 'visible'),
									'compare'	=> 'IN'
								),
								array(
									'key' 		=> '_featured',
									'value' 	=> 'yes'
								)
							)
						);
					}
					$list = new WP_Query( $default );
					$max_page = $list -> max_num_pages;
					if( $so == 'rating' ){
						remove_filter( 'posts_clauses',  array( $this, 'order_by_rating_post_clauses' ) );
					}
				?>
					<div id="<?php echo $so.'_category_id_'.$category.$id; ?>" class="woo-tab-container-slider responsive-slider clearfix" data-lg="<?php echo esc_attr( $columns ); ?>" data-md="<?php echo esc_attr( $columns1 ); ?>" data-sm="<?php echo esc_attr( $columns2 ); ?>" data-xs="<?php echo esc_attr( $columns3 ); ?>" data-mobile="<?php echo esc_attr( $columns4 ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-scroll="<?php echo esc_attr( $scroll ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>" data-rtl="<?php echo ( is_rtl() || $ya_direction == 'rtl' )? 'true' : 'false';?>" data-autoplay="<?php echo esc_attr( $autoplay ); ?>">
						<div class="resp-slider-container">
							<div class="slider responsive">
							<?php 
								$i = 1;
								while($list->have_posts()): $list->the_post();
								global $product, $post, $wpdb, $average;
							?>
								<div class="item">
									<div class="item-wrap">
										<div class="item-detail">										
											<div class="item-img products-thumb">											
												<!-- quickview & thumbnail  -->
												<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
												<?php //do_action('wp_ajax_ya_quickviewproduct' );?>
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
												<!-- price -->
												<?php if ( $price_html = $product->get_price_html() ) : ?>
													<div class="item-price"><?php echo $price_html; ?></div>
												<?php endif; ?>
												<!-- price -->
												<!-- Add To Cart  -->
												<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
											</div>												
										</div>
									</div>
								</div>
								<?php $i++; endwhile; wp_reset_postdata();?>
							</div>
						</div>
					</div>			
				</div>
			<?php } ?>
			<!-- End product tab slider -->
			<?php if( $show_more == 'yes' ){?>
				<div class="catslide-more">
					<a href="<?php echo get_term_link( intval($category), 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php esc_html_e( 'See More Products', 'smartaddons' ); ?></a>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>