<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$sidebar_product = ya_options() -> getCpanelValue('sidebar_product');
?>
<?php get_template_part('header'); ?>

<div class="container">
<div class="row">
<?php if ( is_active_sidebar_YA('left-product') && $sidebar_product == 'left' ):
	$left_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_left_expand');
	$left_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_left_expand_md');
	$left_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_left_expand_sm');
?>
<aside id="left" class="sidebar <?php echo esc_attr($left_span_class); ?>">
	<?php dynamic_sidebar('left-product'); ?>
</aside>

<?php endif; ?>
<div id="contents" <?php ya_content_product(); ?> role="main">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		 global $post;
		do_action('woocommerce_before_main_content');
	?>
		<div class="products-wrapper">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
			<div class="listing-title">
			
				<h1><span><?php woocommerce_page_title(); ?></span></h1>
				
			</div>
		<?php endif; ?>
		
		<?php if ( is_active_sidebar_YA('sidebar-top-cat') ):?>
			<div class="sidebar-top-cat clearfix">
				<?php dynamic_sidebar('sidebar-top-cat'); ?>
			</div>
		<?php endif; ?>
		
		<?php if ( have_posts() ) : ?>
		    <?php do_action('woocommerce_message'); ?>
			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			<div class="clear"></div>
			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>
				
				<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
			<div class="clear"></div>			
			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
	</div>
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

</div>
<?php if ( is_active_sidebar_YA('right-product') && $sidebar_product == 'right' ):
	$right_span_class = 'col-lg-'.ya_options()->getCpanelValue('sidebar_right_expand');
	$right_span_class .= ' col-md-'.ya_options()->getCpanelValue('sidebar_right_expand_md');
	$right_span_class .= ' col-sm-'.ya_options()->getCpanelValue('sidebar_right_expand_sm');
?>
<aside id="right" class="sidebar <?php echo esc_attr($right_span_class); ?>">
	<?php dynamic_sidebar('right-product'); ?>
</aside>
<?php endif; ?>

</div>
</div>
</div>
<script>
(function($) {
	"use strict";
$( window ).load(function() {
	/* Change Layout */
	$('.grid-view').on('click',function(){
		$('.list-view').removeClass('active');
		$('.grid-view').addClass('active');
		jQuery("ul.products-loop").fadeOut(300, function() {
			$(this).removeClass("list").fadeIn(300).addClass( 'grid' );			
		});
	});
	
	$('.list-view').on('click',function(){
		$( '.grid-view' ).removeClass('active');
		$( '.list-view' ).addClass('active');
		$("ul.products-loop").fadeOut(300, function() {
			jQuery(this).addClass("list").fadeIn(300).removeClass( 'grid' );
		});
	});
	/* End Change Layout */
   
});
})(jQuery);					
</script>
<?php get_template_part('footer'); ?>
