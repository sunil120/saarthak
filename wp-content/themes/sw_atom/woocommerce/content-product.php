<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}
$col_lg = ya_options()->getCpanelValue('product_col_large');
$col_md = ya_options()->getCpanelValue('product_col_medium');
$col_sm = ya_options()->getCpanelValue('product_col_sm');
$column1 = 12 / $col_md;
$column2 = 12 / $col_sm;
$class_col= "";
$col_large = 0;
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$col_large = 12 / $col_lg;
}else{
	$col_large = 12 / $woocommerce_loop['columns'];
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

$class_col .= ' col-lg-'.$col_large.' col-md-'.$column1.' col-sm-'.$column2.' clearfix';

if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $col_lg || 1 == $col_lg ) {
	$class_col .= ' clear_lg';
}
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $col_md || 1 == $col_md ) {
	$class_col .= ' clear_md';
}
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $col_sm || 1 == $col_sm ) {
	$class_col .= ' clear_sm';
}

?>
<li <?php post_class($class_col); ?>>
	<div class="products-entry clearfix">
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<div class="products-thumb">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
				
			?>
		</div>
		<div class="products-content">
		<?php
			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		<?php
			/**
			 * woocommerce_after_shop_loop_item hook
			 *
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
		?>
		</div>
	</div>
</li>