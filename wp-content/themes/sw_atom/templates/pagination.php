<?php if ($wp_query->max_num_pages > 1) : ?>
	<?php global $paged, $posts_per_page; ?>
<div class="pagination nav-pag">
	<div class="count-item-perpage pull-left"><span class="bold"><?php echo esc_attr($posts_per_page) ;?> <?php esc_html_e('Items ', 'yatheme'); ?></span><?php esc_html_e('of page', 'yatheme'); ?></div>
    <ul>
    	<?php if (get_previous_posts_link()) : ?>
	        <li class="prev"><?php previous_posts_link(__('Prev', 'yatheme')); ?></li>
	    <?php else: ?>
	 		<li class="disabled prev"><a><?php esc_html_e('Prev', 'yatheme'); ?></a></li>
	    <?php endif; ?>
	      
	      <?php 
	      	//var_dump( $paged );
	      	if($paged == 1 || $wp_query->max_num_pages <= 3){
	      		$i = 1;
	      	} elseif ($paged > $wp_query->max_num_pages - 3 && $paged > 3 ) {
	      		$i = $wp_query->max_num_pages - 3;
	      	} else $i = $paged -1;
	      	
	      	if ($wp_query->max_num_pages - $i > 3){
	      		$max_num_pages = $i + 3;
	      	} else $max_num_pages = $wp_query->max_num_pages;
	      	
	      	for ($i = 1; $i<= $max_num_pages ; $i++){?>
	      		<?php if ( ( $paged == $i ) || ( $paged == 0 && $i==1 ) ){?>
	      			<li class="disabled"><a><?php echo $i?></a></li>
	      		<?php } else {?>
	      			<li><a href="<?php echo get_pagenum_link($i)?>"><?php echo $i?></a></li>
	      		<?php }?>
	      	<?php }?>
      		
	      <?php if (get_next_posts_link()) : ?>
	        <li class="next"><?php next_posts_link(__('Next', 'yatheme')); ?></li>
	      <?php else: ?>
	        <li class="disabled next"><a><?php esc_html_e('Next', 'yatheme'); ?></a></li>
	      <?php endif; ?>
    </ul>
</div>
<?php endif; ?>
<!--End Pagination-->