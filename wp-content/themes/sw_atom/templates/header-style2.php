<?php 
	$ya_colorset = ya_options()->getCpanelValue('scheme');
	$search = ya_options()->getCpanelValue('search');
?>
<header id="header" class="header">
    <div class="header-msg">
        <div class="container">
        <?php if (is_active_sidebar_YA('top')) {?>
            <div id="sidebar-top" class="sidebar-top">
                <?php dynamic_sidebar('top'); ?>
            </div>
        <?php }?>
        </div>
    </div>
	<div class="container top">
		<div class="top-header">
			<div class="ya-logo pull-left col-lg-4 col-md-3 col-xs-12">
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
			<div id="sidebar-top-header" class="sidebar-top-header pull-left col-lg-6 col-md-6 col-xs-6">
				<?php if($search !='') {?>
					<div class="widget ya_top-3 ya_top non-margin pull-right"><div class="widget-inner">
						 <?php get_template_part( 'templates/searchform' ); ?>
					</div></div>
				<?php }?>
			</div>
			<a href="#" class="phone-icon-menu"></a>
			<div class="mycart col-lg-2 col-md-3 col-xs-6">
				<div id="sidebar-top-menu" class="sidebar-top-menu pull-right">
					<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
				</div>
			</div>
		</div>
	</div>
</header>
<?php if ( has_nav_menu('primary_menu') ) {?>
	<!-- Primary navbar -->
<div id="main-menu" class="main-menu">
	<nav id="primary-menu" class="primary-menu">
		<div class="container">
			<div class="mid-header clearfix">
				<div class="navbar-inner navbar-inverse">
						<?php
							$ya_menu_class = 'nav nav-pills';
							if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
								$ya_menu_class .= ' nav-mega';
							} else $ya_menu_class .= ' nav-css';
						?>
						<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $ya_menu_class)); ?>
				</div>
			</div>
		</div>
	</nav>
</div>
	<!-- /Primary navbar -->
<?php 
	} 
?>

