<?php $ya_box_layout = ya_options()->getCpanelValue('layout'); ?>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
<div class="body-wrapper theme-clearfix<?php echo ( $ya_box_layout == 'boxed' )? ' box-layout' : '';?> ">
<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$ya_header_style = ya_options()->getCpanelValue('header_style');
if ($ya_header_style == 'default'){
?>
<header id="header" role="banner" class="header">
    <div class="header-msg">
        <div class="container">
        <?php if (is_active_sidebar_YA('top')) {?>
            <div id="sidebar-top" class="sidebar-top">
                <?php dynamic_sidebar('top'); ?>
            </div>
        <?php }?>
        </div>
    </div>
	<div class="container">
		<div class="top-header">
			<div class="ya-logo pull-left">
				<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php if(ya_options()->getCpanelValue('sitelogo')){ ?>
							<img src="<?php echo esc_attr( ya_options()->getCpanelValue('sitelogo') ); ?>" alt="<?php bloginfo('name'); ?>"/>
						<?php }else{
							if ($ya_colorset){$logo = get_template_directory_uri().'/assets/img/logo-'.$ya_colorset.'.png';}
							else $logo = get_template_directory_uri().'/assets/img/logo-default.png';
						?>
							<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
						<?php } ?>
				</a>
			</div>
			<?php if (is_active_sidebar_YA('top-header')) {?>
				<div id="sidebar-top-header" class="sidebar-top-header">
						<?php dynamic_sidebar('top-header'); ?>
				</div>
			<?php }?>
		</div>
	</div>
</header>
<?php if ( has_nav_menu('primary_menu') ) {?>
	<!-- Primary navbar -->
<div id="main-menu" class="main-menu">
	<nav id="primary-menu" class="primary-menu" role="navigation">
		<div class="container">
			<div class="mid-header clearfix">
				<a href="#" class="phone-icon-menu"></a>
				<div class="navbar-inner navbar-inverse">
						<?php
							$ya_menu_class = 'nav nav-pills';
							if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
								$ya_menu_class .= ' nav-mega';
							} else $ya_menu_class .= ' nav-css';
						?>
						<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $ya_menu_class)); ?>
				</div>
				<?php if (is_active_sidebar_YA('top-menu')) {?>
					<div id="sidebar-top-menu" class="sidebar-top-menu">
							<?php dynamic_sidebar('top-menu'); ?>
					</div>
				<?php }?>
			</div>
		</div>
	</nav>
</div>
	<!-- /Primary navbar -->
<?php 
	}
} else {
    echo '<div class="header-' . $ya_header_style . '">';
    get_template_part('templates/header', $ya_header_style);
    echo '</div>';
}	
?>

<div id="main" class="theme-clearfix" role="document">
<?php
	if (!is_front_page() ) {
		if (function_exists('ya_breadcrumb')){
			ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
		} 
	} 

?>