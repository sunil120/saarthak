<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', dirname(__FILE__) ) );
$lib_abs = trailingslashit( str_replace( '\\', '/', ABSPATH ) );

if( !defined('YA_DIR') ){
	define( 'YA_DIR', $lib_dir );
}

if( !defined('YA_URL') ){
	define( 'YA_URL', site_url( str_replace( $lib_abs, '', $lib_dir ) ) );
}

defined('__THEME__') or die;

if (!isset($content_width)) { $content_width = 940; }

define("PRODUCT_TYPE","product");
define("PRODUCT_DETAIL_TYPE","product_detail");

require_once( get_template_directory().'/lib/options.php' );
function Ya_Options_Setup(){
	global $ya_options, $options, $options_args;

	$options = array();

	$options[] = array(
			'title' => __('About', 'yatheme'),
			'desc' => __('<p class="description">SW Atom is an outstanding responsive WordPress theme for multipurpose store, this theme is suitable for any kind of online store that needs a feature rich and beautiful presence online.<br><br>
			Theme Name:         SW Atom<br>
			Theme URI:         <a href="http://smartaddons.com/">http://smartaddons.com/</a><br>
			Description:        SW Atom is base theme.<br>
			Version:            1.0.4<br>
			Author:             Magentech<br>
			Author URI:         <a href="http://smartaddons.com/">http://smartaddons.com/</a>
	</p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_062_attach.png'
			//Lets leave this as a blank section, no options just some intro text set above.
			//'fields' => array()
		);

	$options[] = array(
			'title' => __('General', 'yatheme'),
			'desc' => __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Start your own color scheme by selecting one of 6 predefined schemes. Upload new logo and favicon or get their URL.</p><img src="http://www.themelist.org/we.jpg">', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'scheme',
							'type' => 'radio_img',
							'title' => __('Color Scheme', 'yatheme'),
							'sub_desc' => __( 'Select one of 6 predefined schemes', 'yatheme' ),
							'desc' => '',
							'options' => array(
											'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
											'blue' => array('title' => 'Blue', 'img' => get_template_directory_uri().'/assets/img/blue.png'),
											'green' => array('title' => 'Green', 'img' => get_template_directory_uri().'/assets/img/green.png'),
											'orange' => array('title' => 'Orange', 'img' => get_template_directory_uri().'/assets/img/orange.png'),
											'fern' => array('title' => 'Fern', 'img' => get_template_directory_uri().'/assets/img/fern.png'),
											'purple' => array('title' => 'Purple', 'img' => get_template_directory_uri().'/assets/img/purple.png'),
												),//Must provide key => value(array:title|img) pairs for radio options
							'std' => 'default'
						),

					array(
							'id' => 'bg_img',
							'type' => 'upload',
							'title' => __('Background Image', 'yatheme'),
							'sub_desc' => '',
							'std' => ''
							),

					array(
							'id' => 'bg_color',
							'type' => 'color',
							'title' => __('Color Option', 'yatheme'),
							'sub_desc' => __('Only color validation can be done on this field type', 'yatheme'),
							'desc' => __('This is the description field, again good for additional info.', 'yatheme'),
							'std' => '#FFFFFF'
							),
					array(
							'id' => 'bg_repeat',
							'type' => 'checkbox',
							'title' => __('Background Repeat', 'yatheme'),
							'sub_desc' => '',
							'desc' => '',
							'std' => '1'// 1 = on | 0 = off
							),

					array(
							'id' => 'favicon',
							'type' => 'upload',
							'title' => __('Favicon Icon', 'yatheme'),
							'sub_desc' => __( 'Use the Upload button to upload the new favicon and get URL of the favicon', 'yatheme' ),
							'std' => get_template_directory_uri().'/assets/img/favicon.ico'
						),

					array(
							'id' => 'responsive_support',
							'type' => 'checkbox',
							'title' => __('Responsive Support', 'yatheme'),
							'sub_desc' => __( 'Support reponsive layout, if you do not want to use this function, please uncheck.', 'yatheme' ),
							'desc' => '',
							'std' => '1'// 1 = on | 0 = off
						),
					array(
							'id' => 'sitelogo',
							'type' => 'upload',
							'title' => __('Logo Image', 'yatheme'),
							'sub_desc' => __( 'Use the Upload button to upload the new logo and get URL of the logo', 'yatheme' ),
							'std' => get_template_directory_uri().'/assets/img/logo-default.png'
						),
				)
		);

	$options[] = array(
			'title' => __('Layout', 'yatheme'),
			'desc' => __('<p class="description">Ya Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'layout',
							'type' => 'select',
							'title' => __('Box Layout', 'yatheme'),
							'sub_desc' => __( 'Select Layout Box or Wide', 'yatheme' ),
							'options' => array(
									'full' => 'Wide'
									),
							'std' => 'wide'
						),
					
					array(
							'id' => 'bg_box_img',
							'type' => 'upload',
							'title' => __('Background Box Image', 'yatheme'),
							'sub_desc' => '',
							'std' => ''
						),
					array(
							'id' => 'sidebar_left_expand',
							'type' => 'select',
							'title' => __('Left Sidebar Expand', 'yatheme'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12', 
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => __( 'Select width of left sidebar.', 'yatheme' ),
						),
					
					array(
							'id' => 'sidebar_right_expand',
							'type' => 'select',
							'title' => __('Right Sidebar Expand', 'yatheme'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '3',
							'sub_desc' => __( 'Select width of right sidebar medium desktop.', 'yatheme' ),
						),
						array(
							'id' => 'sidebar_left_expand_md',
							'type' => 'select',
							'title' => __('Left Sidebar Medium Desktop Expand', 'yatheme'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => __( 'Select width of left sidebar medium desktop.', 'yatheme' ),
						),
					array(
							'id' => 'sidebar_right_expand_md',
							'type' => 'select',
							'title' => __('Right Sidebar Medium Desktop Expand', 'yatheme'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => __( 'Select width of right sidebar.', 'yatheme' ),
						),
						array(
							'id' => 'sidebar_left_expand_sm',
							'type' => 'select',
							'title' => __('Left Sidebar Tablet Expand', 'yatheme'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => __( 'Select width of left sidebar tablet.', 'yatheme' ),
						),
					array(
							'id' => 'sidebar_right_expand_sm',
							'type' => 'select',
							'title' => __('Right Sidebar Tablet Expand', 'yatheme'),
							'options' => array(
									'2' => '2/12',
									'3' => '3/12',
									'4' => '4/12',
									'5' => '5/12',
									'6' => '6/12',
									'7' => '7/12',
									'8' => '8/12',
									'9' => '9/12',
									'10' => '10/12',
									'11' => '11/12',
									'12' => '12/12'
								),
							'std' => '4',
							'sub_desc' => __( 'Select width of right sidebar tablet.', 'yatheme' ),
						),				
				)
		);
	$options[] = array(
		'title' => __('Header', 'yatheme'),
			'desc' => __('<p class="description">Ya Framework comes with a header setting that allows you to build style header.</p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
				 array(
							'id' => 'header_style',
							'type' => 'select',
							'title' => __('Header Style', 'yatheme'),
							'sub_desc' => 'Select Header style',
							'options' => array(
									'style1'  => 'Style 1',
									'style2'  => 'Style 2',
									'style3'  => 'Style 3'						
									),
							'std' => 'style1'
						),
				 array(
							'id' => 'search',
							'title' => __( 'Search form', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => __( 'Hide or show search form', 'yatheme' ),
							'desc' => '',
							'std' => '1'
						),
				 array(
							'id' => 'popular_search',
							'type' => 'text',
							'sub_desc' => __( 'Each keyword separated by commas.', 'yatheme' ),
							'title' => __( 'Popular search text.', 'yatheme' )
						),
				
			)



	);
	$options[] = array(
			'title' => __('Navbar Options', 'yatheme'),
			'desc' => __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
				array(
						'id' => 'menu_type',
						'type' => 'select',
						'title' => __('Menu Type', 'yatheme'),
						'options' => array( 'dropdown' => 'Dropdown Menu', 'mega' => 'Mega Menu' ),
						'std' => 'mega'
					),
				array(
						'id' => 'menu_location',
						'type' => 'select',
						'title' => __('Theme Location', 'yatheme'),
						'sub_desc' => __( 'Select theme location to active mega menu.', 'yatheme' ),
						'options' => array( '' => 'Non Location', 'primary_menu' => 'Primary Menu' ),
						'std' => 'primary_menu'
					),
				array(
						'id' => 'menu_visible',
						'type' => 'select',
						'title' => __('Responsive Menu Visible', 'yatheme'),
						'sub_desc' => __( 'Select option to show responsive menu visible', 'yatheme' ),
						'options' => array( 'visible-tablet' => 'Visible Tablet', 'visible-phone' => 'Visible Phone' ),
						'std' => 'primary_menu'
					),
				array(
						'id' => 'menu_style',
						'type' => 'select',
						'title' => __('Select Menu Style', 'yatheme'),
						'sub_desc' => __( 'Select fixed menu or not', 'yatheme' ),
						'options' => array( '' => 'Default', 'fixed_menu' => 'Fixed Menu' ),
						'std' => ''
					),
			)
		);
	$options[] = array(
		'title' => __('Blog Options', 'yatheme'),
		'desc' => __('<p class="description">Select layout in blog listing page.</p>', 'yatheme'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => YA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
				array(
						'id' => 'sidebar_blog',
						'type' => 'select',
						'title' => __('Sidebar Blog Layout', 'yatheme'),
						'options' => array(
								'full' => 'Full Layout',		
								'left_sidebar'	=> 'Left Sidebar',
								'right_sidebar' =>'Right Sidebar',
								 'lr_sidebar'   =>'Left Right Sidebar'						
						),
						'std' => 'left_sidebar',
						'sub_desc' => __( 'Select style sidebar blog', 'yatheme' ),
					),
					array(
						'id' => 'blog_layout',
						'type' => 'select',
						'title' => __('Layout blog', 'yatheme'),
						'options' => array(
								'default' => 'Default',
								'list'	=> 'List Layout',
								'rsidebar'      =>'Right Sidebar',
								'grid' => 'Grid Layout'								
						),
						'std' => 'default',
						'sub_desc' => __( 'Select style layout blog', 'yatheme' ),
					),
					array(
						'id' => 'blog_column',
						'type' => 'select',
						'title' => __('Blog column', 'yatheme'),
						'options' => array(								
								'2' => '2 columns',
								'3' => '3 columns',
								'4' => '4 columns'								
							),
						'std' => '2',
						'sub_desc' => __( 'Select style number column blog', 'yatheme' ),
					),
			)
	);	
	$options[] = array(
		'title' => __('Product Options', 'yatheme'),
		'desc' => __('<p class="description">Select layout in product listing page.</p>', 'yatheme'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => YA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
			array(
				'id' => 'product_col_large',
				'type' => 'select',
				'title' => __('Product Listing column Desktop', 'yatheme'),
				'options' => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',							
						'6' => '6'							
					),
				'std' => '4',
				'sub_desc' => __( 'Select number of column on Desktop Screen', 'yatheme' ),
			),
			array(
				'id' => 'product_col_medium',
				'type' => 'select',
				'title' => __('Product Listing column Medium Desktop', 'yatheme'),
				'options' => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',							
						'6' => '6'							
					),
				'std' => '3',
				'sub_desc' => __( 'Select number of column on Medium Desktop Screen', 'yatheme' ),
			),
			array(
				'id' => 'product_col_sm',
				'type' => 'select',
				'title' => __('Product Listing column Tablet', 'yatheme'),
				'options' => array(
						'2' => '2',
						'3' => '3',
						'4' => '4',							
						'6' => '6'							
					),
				'std' => '2',
				'sub_desc' => __( 'Select number of column on Tablet Screen', 'yatheme' ),
			),
			array(
					'id' => 'sidebar_product',
					'type' => 'select',
					'title' => __('Sidebar Product Layout', 'yatheme'),
					'options' => array(
							'left'	=> 'Left Sidebar',
							'full' => 'Full Layout',		
							'right' =>'Right Sidebar',
							 'lr'   =>'Left Right Sidebar'						
					),
					'std' => 'left',
					'sub_desc' => __( 'Select style sidebar product', 'yatheme' ),
				),
			array(
				'id' => 'product_layout',
				'type' => 'select',
				'title' => __('Layout product', 'yatheme'),
				'options' => array(
						'grid' => __( 'Grid Layout', 'yatheme' ),		
						'list'	=> __( 'List Layout', 'yatheme' )						
				),
				'std' => 'grid',
				'sub_desc' => __( 'Select style layout product', 'yatheme' ),
			),
		)
);		
	$options[] = array(
		'title' => __('Portfolio Options', 'yatheme'),
		'desc' => __('<p class="description">Select layout in Portfolio listing page.</p>', 'yatheme'),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
		'icon' => YA_URL.'/options/img/glyphicons/glyphicons_319_sort.png',
		//Lets leave this as a blank section, no options just some intro text set above.
		'fields' => array(
				array(
					'id' => 'portfolio_id',
					'type' => 'multi_select_terms',
					'title' => __('Portfolio Categories', 'yatheme'),				
					'std' => 'portfolio_cat',
					'sub_desc' => __( 'Select Portfolio Category', 'yatheme' ),
				),
				array(
					'id' => 'p_style',
					'type' => 'select',
					'title' => __('Portfolio column Desktop', 'yatheme'),
					'options' => array(
						'default'	=> 'Default Column(s)',
						'fitrows'	=> 'FitRows',
						'masonry'	=> 'Masonry'
					),
					'std' => 'default',
					'sub_desc' => __( 'Select number of column on Desktop Screen', 'yatheme' ),
				),
				array(
					'id' => 'p_col_large',
					'type' => 'select',
					'title' => __('Portfolio column Desktop', 'yatheme'),
					'options' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',							
							'6' => '6'							
						),
					'std' => '4',
					'sub_desc' => __( 'Select number of column on Desktop Screen', 'yatheme' ),
				),
				array(
					'id' => 'p_col_medium',
					'type' => 'select',
					'title' => __('Portfolio column Medium Desktop', 'yatheme'),
					'options' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',							
							'6' => '6'							
						),
					'std' => '3',
					'sub_desc' => __( 'Select number of column on Medium Desktop Screen', 'yatheme' ),
				),
				array(
					'id' => 'p_col_sm',
					'type' => 'select',
					'title' => __('Portfolio column Tablet', 'yatheme'),
					'options' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',							
							'6' => '6'							
						),
					'std' => '3',
					'sub_desc' => __( 'Select number of column on Tablet Screen', 'yatheme' )
				),
				array(
					'id' => 'p_col_xs',
					'type' => 'select',
					'title' => __('Portfolio column Smartphone', 'yatheme'),
					'options' => array(
							'1' => '1',
							'2' => '2',
							'3' => '3',
							'4' => '4',							
							'6' => '6'								
						),
					'std' => '2',
					'sub_desc' => __( 'Select number of column on Smartphone Screen', 'yatheme' ),
				)
			)
	);	
	$options[] = array(
			'title' => __('Typography', 'yatheme'),
			'desc' => __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'google_webfonts',
							'type' => 'text',
							'title' => __('Use Google Webfont', 'yatheme'),
							'sub_desc' => __( 'Insert font style that you actually need on your webpage.', 'yatheme' ), 
							'std' => ''
						),
					array(
							'id' => 'webfonts_weight',
							'type' => 'multi_select',
							'sub_desc' => __( 'For weight, see Google Fonts to custom for each font style.', 'yatheme' ),
							'title' => __('Webfont Weight', 'yatheme'),
							'options' => array(
									'100' => '100',
									'200' => '200',
									'300' => '300',
									'400' => '400',
									'600' => '600',
									'700' => '700',
									'800' => '800',
									'900' => '900'
								),
							'std' => ''
						),
					array(
							'id' => 'webfonts_assign',
							'type' => 'select',
							'title' => __( 'Webfont Assign to', 'yatheme' ),
							'sub_desc' => __( 'Select the place will apply the font style headers, every where or custom.', 'yatheme' ),
							'options' => array(
									'headers' => __( 'Headers',    'yatheme' ),
									'all'     => __( 'Everywhere', 'yatheme' ),
									'custom'  => __( 'Custom',     'yatheme' )
								)
						),
					 array(
							'id' => 'webfonts_custom',
							'type' => 'text',
							'sub_desc' => __( 'Insert the places will be custom here, after selected custom Webfont assign.', 'yatheme' ),
							'title' => __( 'Webfont Custom Selector', 'yatheme' )
						),
				)
		);

	$options[] = array(
			'title' => __('Social share', 'yatheme'),
			'desc' => __('<p class="description">Social sharing is ready to use and built in. You can share your pages with just a click and your post can go to their wall and you can gain vistitors from Social Networks. Check Social Networks that you want to use.</p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_222_share.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'social-share',
							'title' => __( 'Social share', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '0'
						),
					array(
							'id' => 'social-share-fb',
							'title' => __( 'Facebook', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
					array(
							'id' => 'social-share-tw',
							'title' => __( 'Twitter', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
					array(
							'id' => 'social-share-in',
							'title' => __( 'Linked_in', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
					array(
							'id' => 'social-share-go',
							'title' => __( 'Google+', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => '',
							'desc' => '',
							'std' => '1',
						),
	//				array(
	//						'id' => 'social-share-pi',
	//						'title' => '<div class="social-share">Pinterest</div>',//__( 'Facebook', 'yatheme' ),
	//						'type' => 'checkbox',
	//						'sub_desc' => '',
	//						'desc' => '',
	//						'std' => '1',
	//					)

				)
		);

	$options[] = array(
			'title' => __('Advanced', 'yatheme'),
			'desc' => __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'yatheme'),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it blank for default.
			'icon' => YA_URL.'/options/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a blank section, no options just some intro text set above.
			'fields' => array(
					array(
							'id' => 'show_cpanel',
							'title' => __( 'Show cPanel', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => __( 'Turn on/off Cpanel', 'yatheme' ),
							'desc' => '',
							'std' => ''
						),
					array(
							'id' => 'widget-advanced',
							'title' => __('Widget Advanced', 'yatheme'),
							'type' => 'checkbox',
							'sub_desc' => __( 'Turn on/off Widget Advanced', 'yatheme' ),
							'desc' => '',
							'std' => '1'
						),
					array(
							'id' => 'developer_mode',
							'title' => __( 'Developer Mode', 'yatheme' ),
							'type' => 'checkbox',
							'sub_desc' => __( 'Turn on/off preset', 'yatheme' ),
							'desc' => '',
							'std' => '0'
						),
					array(
							'id' => 'back_active',
							'type' => 'checkbox',
							'title' => __('Back to top', 'yatheme'),
							'sub_desc' => '',
							'desc' => '',
							'std' => '1'// 1 = on | 0 = off
							),
					array(
							'id' => 'sticky_menu',
							'type' => 'checkbox',
							'title' => __('Active sticky menu', 'yatheme'),
							'sub_desc' => '',
							'desc' => '',
							'std' => '0'// 1 = on | 0 = off
							),			
					array(
							'id' => 'direction',
							'type' => 'select',
							'title' => __('Direction', 'yatheme'),
							'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
							'std' => 'ltr'
						),
					array(
							'id' => 'popup_active',
							'type' => 'checkbox',
							'title' => __('Active Popup Subscribe', 'yatheme'),
							'sub_desc' => __( 'Check to active popup subscribe', 'yatheme' ),
							'desc' => '',
							'std' => '0'// 1 = on | 0 = off
							),	
					array(
							'id' => 'popup_shortcode',
							'type' => 'textarea',
							'sub_desc' => __( 'Insert the popup shortcode here', 'yatheme' ),
							'title' => __( 'Popup Shortcode', 'yatheme' )
						),
					array(
							'id' => 'advanced_head',
							'type' => 'textarea',
							'sub_desc' => __( 'Insert your own CSS into this block. This overrides all default styles located throughout the theme', 'yatheme' ),
							'title' => __( 'Custom CSS/JS', 'yatheme' )
						)
				)
		);

	$options_args = array();

	//Setup custom links in the footer for share icons
	$options_args['share_icons']['facebook'] = array(
			'link' => 'https://www.facebook.com/SmartAddons.page',
			'title' => 'Facebook',
			'img' => YA_URL.'/options/img/glyphicons/glyphicons_320_facebook.png'
	);
	$options_args['share_icons']['twitter'] = array(
			'link' => 'https://twitter.com/smartaddons',
			'title' => 'Folow me on Twitter',
			'img' => YA_URL.'/options/img/glyphicons/glyphicons_322_twitter.png'
	);
	$options_args['share_icons']['linked_in'] = array(
			'link' => 'http://www.linkedin.com/in/smartaddons',
			'title' => 'Find me on LinkedIn',
			'img' => YA_URL.'/options/img/glyphicons/glyphicons_337_linked_in.png'
	);

	//Choose to disable the import/export feature
	// $options_args['show_import_export'] = true;

	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
	$options_args['opt_name'] = __THEME__;

	$options_args['google_api_key'] = '';//must be defined for use with google webfonts field type

	//Custom menu icon
	//$options_args['menu_icon'] = '';

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = __('Theme Options', 'yatheme');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = __('YA Options :: ', 'yatheme') . wp_get_theme()->get('Name');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "ya_theme_options"
	$options_args['page_slug'] = 'ya_theme_options';

	//Custom page capability - default is set to "manage_options"
	//$options_args['page_cap'] = 'manage_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//parent menu - default is set to "themes.php" (Appearance)
	//the list of available parent menus is available here: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	//$options_args['page_parent'] = 'themes.php';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$ya_options = new YA_Options($options, $options_args);
}
add_action( 'admin_init', 'Ya_Options_Setup', 0 );
Ya_Options_Setup();

function ya_widget_setup_args(){
	$ya_widget_areas = array(
		
		array(
				'name' => __('Sidebar Left Blog', 'yatheme'),
				'id'   => 'left-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => __('Sidebar Right Blog', 'yatheme'),
				'id'   => 'right-blog',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => __('Top', 'yatheme'),
				'id'   => 'top',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => __('Sidebar Left Detail Product', 'yatheme'),
				'id'   => 'left-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		array(
				'name' => __('Sidebar Bottom Detail Product', 'yatheme'),
				'id'   => 'bottom-detail-product',
				'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		
		array(
				'name' => __('Sidebar Top Product Category', 'yatheme'),
				'id'   => 'sidebar-top-cat',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => __('Sidebar Left Product', 'yatheme'),
				'id'   => 'left-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => __('Sidebar Right Product', 'yatheme'),
				'id'   => 'right-product',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="block-title-widget"><h2><span>',
				'after_title' => '</span></h2></div>'
		),
		
		array(
				'name' => __('Above Footer', 'yatheme'),
				'id'   => 'above-footer',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => __('Footer', 'yatheme'),
				'id'   => 'footer',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => __('Footer Copyright', 'yatheme'),
				'id'   => 'footer-copyright',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		),
		array(
				'name' => __('Floating', 'yatheme'),
				'id'   => 'floating',
				'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>'
		)
	);
	return $ya_widget_areas;
}
