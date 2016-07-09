<?php 
	do_action( 'before' ); 
?>
<?php if ( (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) ) { ?>
<?php
	$ya_header  = ya_options()->getCpanelValue( 'header_style' );
	if( $ya_header == 'style2' ){
		get_template_part( 'woocommerce/minicart-ajax' ); 
	}else{
		get_template_part( 'woocommerce/minicart-ajax-style1' );
	}
	
?>
<?php } ?>