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
		<div class="top-header col-lg-5 col-md-4 col-sm-4">
			<div class="ya-logo pull-left">
				<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php $logo = get_template_directory_uri().'/assets/img/logo-homepage2.png';?>
						<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
				</a>
			</div>
		</div>
		<div id="sidebar-top-header" class="sidebar-top-header col-lg-7 col-md-8 col-sm-8">
				<?php if($search !='') {?>
						<div class="widget ya_top-3 ya_top non-margin pull-right">
							<div class="widget-inner">
								<?php get_template_part( 'widgets/ya_top/searchcate' ); ?>
							</div>
						</div>
				<?php }?>
		</div>
	</div>
</header>
<?php if ( has_nav_menu('primary_menu') ) {?>
	<!-- Primary navbar -->
<div id="main-menu" class="main-menu">
	<nav id="primary-menu" class="primary-menu">
		<div class="container">
			<div class="mid-header clearfix">
				<a href="#" class="phone-icon-menu"></a>
				<a class="phone-icon-search  fa fa-search" href="#" title="Search"></a>
				<div class="navbar-inner navbar-inverse">
						<?php
							$ya_menu_class = 'nav nav-pills';
							if ( 'mega' == ya_options()->getCpanelValue('menu_type') ){
								$ya_menu_class .= ' nav-mega';
							} else $ya_menu_class .= ' nav-css';
						?>
						<?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $ya_menu_class)); ?>
				</div>
				<div id="sidebar-top-menu" class="sidebar-top-menu">
						<?php get_template_part( 'woocommerce/minicart-ajax-style1' ); ?>
				</div>
			</div>
		</div>
	</nav>
</div>
	<!-- /Primary navbar -->
<?php 
	} 
?>

