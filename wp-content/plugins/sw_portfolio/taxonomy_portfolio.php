<?php
add_action("admin_init", "portfolio_init");
function portfolio_init(){
	add_meta_box("Portfolio Meta", "Portfolio Meta", "portfolio_detail", "portfolio", "normal", "low");
	}
function portfolio_detail(){
	global $post;
	$skill = get_post_meta( $post->ID, 'skill', true );	
	$p_url = get_post_meta( $post->ID, 'p_url', true );
	$copyright = get_post_meta( $post->ID, 'copyright', true );
	$img_size = get_post_meta( $post->ID, 'img_size', true );
	$arr_size = array( 'Default' => 'default', 'Double Width' => 'p-double-width', 'Double Width & Height' => 'p-double-wh' );
?>	
	<p><label><b><?php _e('Skill Needed', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "skill" value ="<?php echo esc_attr( $skill );?>" size="50%" />
	</p>
	<p><label><b><?php _e('URL', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "p_url" value ="<?php echo esc_attr( $p_url );?>" size="50%" />
	</p>
	<p><label><b><?php _e('Copyright', 'yatheme'); ?>:</b></label><br/>
		<input type ="text" name = "copyright" value ="<?php echo esc_attr( $copyright );?>" size="50%" />
	</p>
	<p><label><b><?php _e('Image Size Mansonry Layout', 'yatheme'); ?>:</b></label><br/>
		<select name = "img_size">
		<?php
			$option ='';
			foreach ($arr_size as $key => $value) :
				$option .= '<option value="' . $value . '" ';
				if ($value == $img_size){
					$option .= 'selected="selected"';
				}
				$option .=  '>'.$key.'</option>';
			endforeach;
			echo $option;
		?>
		</select>
	</p>
	
<?php }
add_action( 'save_post', 'portfolio_save_meta' );
function portfolio_save_meta(){
	global $post;
	$list_meta = array('skill', 'p_url', 'copyright', 'img_size');
	foreach( $list_meta as $meta ){
		if( isset( $_POST[$meta] ) && $_POST[$meta] !=  NULL ){
			update_post_meta($post->ID, $meta, $_POST[$meta]);
		}		
	}
}
?>