<?php
/**
 * Show a grid of thumbnails
 */
?>
<ul class="brand-thumbnails">
	
	<?php foreach ( $brands as $index => $brand ) : 
		$thumbnail_id = get_woocommerce_term_meta( $brand->term_id, 'thumbnail_id', true );
		$thumbnail='';
		if ( $thumbnail_id )
			$thumbnail = current( wp_get_attachment_image_src( $thumbnail_id, 'full' ) );				
			
		//$thumbnail = pw_woocommerc_brans_Wc_Brands::get_brand_thumbnail_url( $brand->term_id, apply_filters( 'woocommerce_brand_thumbnail_size', 'brand-thumb' ) );
		
		if ( ! $thumbnail )
			$thumbnail = woocommerce_placeholder_img_src();
		
		$class = '';
		
		if ( $index == 0 || $index % $columns == 0 )
			$class = 'first';
		elseif ( ( $index + 1 ) % $columns == 0 )
			$class = 'last';
		
		$width = floor( ( ( 100 - ( ( $columns - 1 ) * 2 ) ) / $columns ) * 100 ) / 100;
		?>
		<li class="<?php echo $class; ?>" style="width: <?php echo $width; ?>%;">
			<a href="<?php echo get_term_link( $brand->slug, 'product_brand' ); ?>" title="<?php echo $brand->name; ?>">
				<img src="<?php echo $thumbnail; ?>" alt="<?php echo $brand->name; ?>" />
			</a>
		</li>
	<?php endforeach; ?>
</ul>