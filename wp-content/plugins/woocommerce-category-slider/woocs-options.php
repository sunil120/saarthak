<?php

function woocs_admin_menu() {
	add_menu_page('Category Slider Settings', 'Category Slider', 'manage_options', 'woocs.php', 'woocs_show_options', plugins_url('/styles/images/mini.png', __FILE__), 1247);
}

add_action('admin_menu', 'woocs_admin_menu');


function woocs_register_settings() {
	register_setting('woocs-settings-group', 'woocs_enabled');
	register_setting('woocs-settings-group', 'woocs_type');
	register_setting('woocs-settings-group', 'woocs_bgcolor');
	
	register_setting('woocs-settings-group', 'woocs_ph_pcats_in_section');
	register_setting('woocs-settings-group', 'woocs_ph_products');
	register_setting('woocs-settings-group', 'woocs_ph_from');
	register_setting('woocs-settings-group', 'woocs_ph_to');
	register_setting('woocs-settings-group', 'woocs_ph_all_for');
	register_setting('woocs-settings-group', 'woocs_ph_veiw_all_prod');
	
	register_setting('woocs-settings-group', 'woocs_t1_autoslide');
	register_setting('woocs-settings-group', 'woocs_t2_autoslide');
	
	register_setting('woocs-settings-group', 'woocs_t1_speed');
	register_setting('woocs-settings-group', 'woocs_t2_speed');
	
	register_setting('woocs-settings-group', 'woocs_t1_pager');
	register_setting('woocs-settings-group', 'woocs_t2_pager');
	
	register_setting('woocs-settings-group', 'woocs_t1_controls');
	register_setting('woocs-settings-group', 'woocs_t2_controls');
	
	register_setting('woocs-settings-group', 'woocs_t1_title_length');
	register_setting('woocs-settings-group', 'woocs_t2_title_length');
	
	register_setting('woocs-settings-group', 'woocs_t2_numberofrows');
	
}

add_action('admin_init', 'woocs_register_settings');


function woocs_show_options(){ ?>
<style type="text/css"> .woocs-label{ font-size:14px; font-weight:bold;} .woocs .submit{ text-align:right;} .wcs-ph{ width:190px; float:left; padding:10px; }</style>

<div class="wrap">

    <div style="float:left; width:50px; height:55px; margin:10px 10px 20px 0px;">
        <img src="<?php echo plugins_url('/styles/images/icon.png', __FILE__); ?>" style="height:43px;"/>
    </div>
    <h1 style="padding-bottom:20px; padding-top:15px;"><?php _e('WooCommerce Category Slider Settings', 'woodiscuz'); ?></h1>
    <br style="clear:both" />
    <link rel="stylesheet" href="<?php echo WOOCS_PATH ?>bxslider/jquery.bxslider.css" type="text/css" />
	<script src="<?php echo WOOCS_PATH ?>bxslider/jquery.min.js"></script>
	<script src="<?php echo WOOCS_PATH ?>bxslider/jquery.bxslider.js"></script>
	
	<table width="100%" border="0">
          <tr>
            <td style="padding:10px; padding-left:0px; vertical-align:top; width:500px; height:470px;">
                    <div class="slider">
                        <ul class="bxslider">
						<li>
						  	<div style="width:470px; margin:0px auto;"><a href="http://gvectors.com/product/woocommerce-category-slider-pro/"><img src="<?php echo WOOCS_PATH ?>styles/images/gc/0.png" title="" style="padding:0px; width:469px" /></a></div>
						  	<div style="padding:10px;">
								<p style="padding:0px; margin:0px; text-align:center; color:#CC3300; font-size:24px; font-family:Georgia, 'Times New Roman', Times, serif;">
									Get More! +3 Awesome Slider Layouts!
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;">
									<a href="http://gvectors.com/product/woocommerce-category-slider-pro/" style="text-decoration:none;">
										<span style="font-size:16px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif;">WooCommerce Category Slider PRO</span>
									</a>
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;"><a class="button button-primary" target="_blank" href="http://gvectors.com/product/woocommerce-category-slider-pro/">Update to Pro Now!</a></p>
							</div>
						  </li>
                          <li>
						    <div style="padding:10px;">
								<p style="padding:0px; margin:0px; text-align:center; color:#CC3300; font-size:24px; font-family:Georgia, 'Times New Roman', Times, serif;">
									Slider Layout #3
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;">
									<a href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl3" style="text-decoration:none;">
										<span style="font-size:16px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif;">WooCommerce Category Slider PRO</span>
									</a>
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;"><a class="button button-primary" target="_blank" href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl3">Update to Pro Now!</a></p>
							</div>
						  	<div style="width:410px; margin:0px auto;"><a href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl3"><img src="<?php echo WOOCS_PATH ?>styles/images/gc/1.png" title="" style="padding:0px" /></a></div>
						  </li>
                          <li>
						  	<div style="padding:10px;">
								<p style="padding:0px; margin:0px; text-align:center; color:#CC3300; font-size:24px; font-family:Georgia, 'Times New Roman', Times, serif;">
									Slider Layout #4
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;">
									<a href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl4" style="text-decoration:none;">
										<span style="font-size:16px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif;">WooCommerce Category Slider PRO</span>
									</a>
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;"><a class="button button-primary" target="_blank" href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl4">Update to Pro Now!</a></p>
							</div>
						  	<div style="width:410px; margin:0px auto;"><a href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl4"><img src="<?php echo WOOCS_PATH ?>styles/images/gc/2.png" title="" style="padding:0px" /></a></div>
						  </li>
						  <li>
						  	<div style="padding:10px;">
								<p style="padding:0px; margin:0px; text-align:center; color:#CC3300; font-size:24px; font-family:Georgia, 'Times New Roman', Times, serif;">
									Slider Layout #5
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;">
									<a href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl5" style="text-decoration:none;">
										<span style="font-size:16px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif;">WooCommerce Category Slider PRO</span>
									</a>
								</p>
								<p style="padding:0px; margin:0px; padding-bottom:15px; text-align:center;"><a class="button button-primary" target="_blank" href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl5">Update to Pro Now!</a></p>
							</div>
						  	<div style="width:410px; margin:0px auto;"><a href="http://gvectors.com/product/woocommerce-category-slider-pro/#sl5"><img src="<?php echo WOOCS_PATH ?>styles/images/gc/3.png" title="" style="padding:0px" /></a></div>
						  </li>
                        </ul>
                    </div>
                    <div style="clear:both"></div>
            </td>
            <td valign="top" style="padding:10px; padding-right:0px;">
            	<table width="100%" cellspacing="1" border="0" class="widefat">
            		<tbody>
                        <tr>
                            <td valign="top" style="padding:10px;">
                                <table width="100%" cellspacing="1" border="0">
                                    <thead>
                                        <tr>
                                            <th style="font-size:16px;"><strong>Like WooCommerce Category Slider?</strong> <br><span style="font-size:14px">We really need your reviews!</span></th>
                                            <th style="font-size:16px; width:75px; text-align:center; border-bottom:1px solid #008EC2;"><a target="_blank" style="color:#008EC2; overflow:hidden; outline:none;" href="http://gvectors.com/forum/">Support</a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr valign="top">
                                        <td style="background:#FFF; text-align:left; font-size:14px;" colspan="2">
                                            We do our best to make WooCommerce Category Slider better every day. Thousands users are currently satisfied with WooCommerce Category Slider but only about 1% of them give us 5 start rating.
                                            However we have a very few users who for some very specific reasons are not satisfied and they are very active in decreasing WooCommerce Category Slider rating.
                                            <br />Please help us keep plugin rating high, encouraging us to develop and maintain this plugin. Take a one minute to leave <a title="Go to WooCommerce Category Slider Reviews section on Wordpress.org" href="https://wordpress.org/support/view/plugin-reviews/woocommerce-category-slider?filter=5"><img border="0" align="absmiddle" src="<?php echo WOOCS_PATH ?>styles/images/gc/5s.png"></a> star review on <a href="https://wordpress.org/support/view/plugin-reviews/woocommerce-category-slider?filter=5">Wordpress.org</a>. Thank You!
                                        	<hr />
                                            <span style="color:#724E42">NOTE: If you find some problem please do not decrease this plugin rating. Just open a new support topic and we'll help to fix it as soon as possible.</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
          </tr>
        </table>

	<form method="post" action="options.php">
		<?php settings_fields('woocs-settings-group'); ?>
    	<?php do_settings_sections('woocs-settings-group'); ?>
    	<table cellspacing="0" class="wp-list-table widefat plugins woocs" style="border-color:#CCCCCC;">
            <thead>
                <tr style="background:#F2FBFF">
                    <th scope="col" colspan="2" style="font-size:20px;">General Settings</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:right"><?php submit_button(); ?></th>
                </tr>
            </tfoot>
            <tbody>
            <tr style="background:#F8F8F8;">
                <td style="width:40%"><span class="woocs-label">Enable Slider</span></td>
                <td>
                    <p><input type="checkbox" name="woocs_enabled" id="woocs_enabled" value="1" <?php checked('1', get_option('woocs_enabled')); ?> />
                    <label for="woocs_enabled">Enable</label></p>
                </td>
            </tr>
            <tr>
                <td><span class="woocs-label">Slider Type</span></td>
                <td>
                	
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>
                        	<img src="<?php echo plugins_url('/styles/images/L1.png', __FILE__); ?>"/><br />
                        	<p><label for="woocs0">Layout 1</label>&nbsp;<input name="woocs_type" id="woocs0" type="radio" value="1" <?php checked('1', get_option('woocs_type')); ?> /></p>
                        </td>
                        <td>
                        	<img src="<?php echo plugins_url('/styles/images/L2.png', __FILE__); ?>"/><br />
                            <p><label for="woocs1">Layout 2</label>&nbsp;<input name="woocs_type" id="woocs1" type="radio" value="2" <?php checked('2', get_option('woocs_type')); ?> /></p>
                        </td>
                      </tr>
                    </table>
                    
                </td>
            </tr>
            <tr style="background:#F8F8F8;">
                <td><span class="woocs-label">Slider Background Color</span></td>
                <td><input class="color" name="woocs_bgcolor" value="<?php echo esc_attr(get_option('woocs_bgcolor')); ?>" style="border:#CCCCCC 1px solid;"> </td>
            </tr>
            <tr>
                <td colspan="2">
					<div style="padding:10px 0px 10px 5px;"><span class="woocs-label">Slider Front-end Phrases</span></div>
					<div class="wcs-ph"><input type="text" name="woocs_ph_pcats_in_section" value="<?php echo esc_attr(get_option('woocs_ph_pcats_in_section')); ?>" class="woocs_phrase"></div>
					<div class="wcs-ph"><input type="text" name="woocs_ph_products" value="<?php echo esc_attr(get_option('woocs_ph_products')); ?>" class="woocs_phrase"></div>
					<div class="wcs-ph"><input type="text" name="woocs_ph_from" value="<?php echo esc_attr(get_option('woocs_ph_from')); ?>" class="woocs_phrase"></div>
					<div class="wcs-ph"><input type="text" name="woocs_ph_to" value="<?php echo esc_attr(get_option('woocs_ph_to')); ?>" class="woocs_phrase"></div>
					<div class="wcs-ph"><input type="text" name="woocs_ph_all_for" value="<?php echo esc_attr(get_option('woocs_ph_all_for')); ?>" class="woocs_phrase"></div>
					<div class="wcs-ph"><input type="text" name="woocs_ph_veiw_all_prod" value="<?php echo esc_attr(get_option('woocs_ph_veiw_all_prod')); ?>" class="woocs_phrase"></div>
					<div style="clear:both;"></div>
                </td>
            </tr>
            </tbody>
        </table>
		
        <table cellspacing="0" class="wp-list-table widefat plugins woocs" style="border-color:#CCCCCC; margin-top:25px;">
            <thead>
                <tr style="background:#F2FBFF">
                    <th scope="col" colspan="2" style="font-size:20px;">Options - Layout #1</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:right"><?php submit_button(); ?></th>
                </tr>
            </tfoot>
            <tbody>
            <tr style="background:#F8F8F8;">
                <td style="width:40%"><span class="woocs-label"><label for="woocs_t1_title_length">Title length</label></span></td>
                <td><input type="number" min="10" max="100" name="woocs_t1_title_length" class="woocs_length" id="woocs_t1_title_length" value="<?php echo esc_attr(get_option('woocs_t1_title_length')); ?>" /></td>
            </tr>
            <tr>
                <td><span class="woocs-label"><label for="woocs_t1_pager">Pager</label></span></td>
                <td>&nbsp;&nbsp;<input type="checkbox" name="woocs_t1_pager" class="woocs_pager" id="woocs_t1_pager" value="1" <?php checked('1', get_option('woocs_t1_pager')); ?> /></td>
            </tr>
            <tr style="background:#F8F8F8;">
                <td><span class="woocs-label"><label for="woocs_t1_controls">Controls</label></span></td>
                <td>&nbsp;&nbsp;<input type="checkbox" name="woocs_t1_controls" class="woocs_controls" id="woocs_t1_controls" value="1" <?php checked('1', get_option('woocs_t1_controls')); ?> /></td>
            </tr>
            <tr>
                <td><span class="woocs-label"><label for="woocs_t1_autoslide">Autoslide</label></span></td>
                <td>&nbsp;&nbsp;<input type="checkbox" name="woocs_t1_autoslide" class="woocs_autoslide" id="woocs_t1_autoslide" value="1" <?php checked('1', get_option('woocs_t1_autoslide')); ?> /></td>
            </tr>
            <tr style="background:#F8F8F8;">
                <td><span class="woocs-label"><label for="woocs_t1_speed">Autoslide speed</label></span></td>
                <td><input type="number" min="10" max="5000" name="woocs_t1_speed" class="woocs_speed" id="woocs_t1_speed" value="<?php echo esc_attr(get_option('woocs_t1_speed')); ?>" /></td>
            </tr>
			<tr style="background:#F8F8F8;">
                <td><span class="woocs-label">Shortcode</span></td>
                <td><table>
				<tr><td><label for="woocs_t1_allcats">Display subCategories of this Parent Category:</label>
				<select name='woocs_t1_allcats' class='woocs_allcats'>
				<option value=0><b>Root</b></option>
				<?php $woocs_allcats = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => true));
				foreach($woocs_allcats as $woocat){
					echo "<option value='".$woocat->term_id."'>".$woocat->name."</option>";
				} ?>
				</select></td></tr>
				<tr><td><label for="woocs_t1_shortcode">Shortcode to paste in content:</label><input type="text" id="woocs_t1_shortcode" class="woocs_shortcode" name="woocs_t1_shortcode" value='[wcslider type="1" catid="0" title_length="<?php echo esc_attr(get_option('woocs_t1_title_length')); ?>" pager="<?php echo (int)esc_attr(get_option('woocs_t1_pager')); ?>" controls="<?php echo (int)esc_attr(get_option('woocs_t1_controls')); ?>" autoslide="<?php echo (int)esc_attr(get_option('woocs_t1_autoslide')); ?>" speed="<?php echo esc_attr(get_option('woocs_t1_speed')); ?>"]' size=90 /></td></tr>
				<tr><td><label for="woocs_t1_phpshortcode">Shortcode to paste in PHP file:</label><input type="text" id="woocs_t1_phpshortcode" class="woocs_phpshortcode" name="woocs_t1_phpshortcode" value='&lt;?php do_shortcode(&#39;[wcslider type="1" catid="0" title_length="<?php echo esc_attr(get_option('woocs_t1_title_length')); ?>" pager="<?php echo (int)esc_attr(get_option('woocs_t1_pager')); ?>" controls="<?php echo (int)esc_attr(get_option('woocs_t1_controls')); ?>" autoslide="<?php echo (int)esc_attr(get_option('woocs_t1_autoslide')); ?>" speed="<?php echo esc_attr(get_option('woocs_t1_speed')); ?>"]&#39;); ?&gt;' size=90 /></td></tr>
				</table></td>
            </tr>
            </tbody>
        </table>
        
        <table cellspacing="0" class="wp-list-table widefat plugins woocs" style="border-color:#CCCCCC; margin-top:25px;">
            <thead>
                <tr style="background:#F2FBFF">
                    <th scope="col" colspan="2" style="font-size:20px;">Options - Layout #2</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:right"><?php submit_button(); ?></th>
                </tr>
            </tfoot>
            <tbody>
            <tr>
                <td style="width:40%"><span class="woocs-label"><label for="woocs_t2_title_length">Title length</label></span></td>
                <td><input type="number" min="10" max="100" name="woocs_t2_title_length" class="woocs_length" id="woocs_t2_title_length" value="<?php echo esc_attr(get_option('woocs_t2_title_length')); ?>" /></td>
            </tr>
            <tr style="background:#F8F8F8;">
                <td><span class="woocs-label"><label for="woocs_t2_pager">Pager</label></span></td>
                <td>&nbsp;&nbsp;<input type="checkbox" name="woocs_t2_pager" class="woocs_pager" id="woocs_t2_pager" value="1" <?php checked('1', get_option('woocs_t2_pager')); ?> /></td>
            </tr>
            <tr>
                <td><span class="woocs-label"><label for="woocs_t2_controls">Controls</label></span></td>
                <td>&nbsp;&nbsp;<input type="checkbox" name="woocs_t2_controls" class="woocs_controls" id="woocs_t2_controls" value="1" <?php checked('1', get_option('woocs_t2_controls')); ?> /></td>
            </tr>
            <tr style="background:#F8F8F8;">
                <td><span class="woocs-label"><label for="woocs_t2_autoslide">Autoslide</label></span></td>
                <td>&nbsp;&nbsp;<input type="checkbox" name="woocs_t2_autoslide" class="woocs_autoslide" id="woocs_t2_autoslide" value="1" <?php checked('1', get_option('woocs_t2_autoslide')); ?> /></td>
            </tr>
            <tr>
                <td><span class="woocs-label"><label for="woocs_t2_speed">Autoslide speed</label></span></td>
                <td><input type="number" min="10" max="5000" name="woocs_t2_speed" class="woocs_speed" id="woocs_t2_speed" value="<?php echo esc_attr(get_option('woocs_t2_speed')); ?>" /></td>
            </tr>
            <tr style="background:#F8F8F8;">
                <td><span class="woocs-label"><label for="woocs_t2_numberofrows">Number of Rows</label></span></td>
                <td><input type="number" min="2" max="6" name="woocs_t2_numberofrows" id="woocs_t2_numberofrows" class="woocs_numberofrows" value="<?php echo esc_attr(get_option('woocs_t2_numberofrows')); ?>"></td>
            </tr>
			<tr style="background:#F8F8F8;">
                <td><span class="woocs-label">Shortcode</span></td>
                <td><table>
				<tr><td><label for="woocs_t2_allcats">Display subCategories of this Parent Category:</label>
				<select name='woocs_t2_allcats' class='woocs_allcats'>
				<option value=0><b>Root</b></option>
				<?php $woocs_allcats = get_categories(array('taxonomy' => 'product_cat', 'hide_empty' => true));
				foreach($woocs_allcats as $woocat){
					echo "<option value='".$woocat->term_id."'>".$woocat->name."</option>";
				} ?>
				</select></td></tr>
				<tr><td><label for="woocs_t2_shortcode">Shortcode to paste in content:</label><input type="text" id="woocs_t2_shortcode" class="woocs_shortcode" name="woocs_t2_shortcode" value='[wcslider type="2" catid="0" title_length="<?php echo esc_attr(get_option('woocs_t2_title_length')); ?>" pager="<?php echo (int)esc_attr(get_option('woocs_t2_pager')); ?>" controls="<?php echo (int)esc_attr(get_option('woocs_t2_controls')); ?>" autoslide="<?php echo (int)esc_attr(get_option('woocs_t2_autoslide')); ?>" speed="<?php echo esc_attr(get_option('woocs_t2_speed')); ?>" numberofrows="<?php echo esc_attr(get_option('woocs_t2_numberofrows')); ?>"]' size=90 /></td></tr>
				<tr><td><label for="woocs_t2_phpshortcode">Shortcode to paste in PHP file:</label><input type="text" id="woocs_t2_phpshortcode" class="woocs_phpshortcode" name="woocs_t2_phpshortcode" value='&lt;?php do_shortcode(&#39;[wcslider type="2" catid="0" title_length="<?php echo esc_attr(get_option('woocs_t2_title_length')); ?>" pager="<?php echo (int)esc_attr(get_option('woocs_t2_pager')); ?>" controls="<?php echo (int)esc_attr(get_option('woocs_t2_controls')); ?>" autoslide="<?php echo (int)esc_attr(get_option('woocs_t2_autoslide')); ?>" speed="<?php echo esc_attr(get_option('woocs_t2_speed')); ?>"]&#39;); ?&gt;' size=90 /></td></tr>
				</table></td>
            </tr>
            </tbody>
        </table>
        
	</form>
</div>
<script>
$('.bxslider').bxSlider({
  mode: 'fade',
  captions: false,
  auto: true,
  controls: false,
  adaptiveHeight: false
});
</script>
	<?php 
}