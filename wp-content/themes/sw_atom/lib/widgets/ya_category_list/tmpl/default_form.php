<?php
$categoriesid = isset( $instance['categories'] )    ? $instance['categories'] : array();
$orderby    = isset( $instance['orderby'] )     ? strip_tags($instance['orderby']) : 'ID';
$order      = isset( $instance['order'] )       ? strip_tags($instance['order']) : 'ASC';
$number     = isset( $instance['number'] ) ? intval($instance['number']) : 5;
$exclude    = isset( $instance['exclude'] ) ? strip_tags($instance['exclude']) : 0;

?>

<p>
	<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>"><?php esc_html_e('Categories Name', 'yatheme')?></label>
	<br />
	<?php echo $this->product_select('categories', array('allow_select_all' => true, 'multiple' => true), $categoriesid); ?>
</p>