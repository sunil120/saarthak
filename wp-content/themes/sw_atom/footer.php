<?php if (is_active_sidebar_YA('above-footer')){ ?>

<div class="sidebar-above-footer theme-clearfix">
       <div class="container theme-clearfix">	   
		<?php dynamic_sidebar('above-footer'); ?>
	    </div>
</div>
<?php } ?>
<footer class="footer theme-clearfix" >
	<div class="container theme-clearfix">
		<div class="footer-top">
			<div class="row">
				<?php if (is_active_sidebar_YA('footer')){ ?>
									
						<?php dynamic_sidebar('footer'); ?>
					
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="copyright theme-clearfix">
		<div class="container clearfix">
			<div class="col-lg-8 col-md-8 col-sm-8 pull-left clearfix">
				<div class="copyright-text pull-left">
                                    <p>&copy;<?php echo date('Y'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Saarthak Store', 'yatheme'); ?></a><?php esc_html_e('All Rights Reserved. ','yatheme'); ?></p>
				</div>
			</div>
			<?php if (is_active_sidebar_YA('footer-copyright')){ ?>
				<div class="sidebar-copyright pull-right">
						<div class="col-md-12 theme-clearfix">
							<?php dynamic_sidebar('footer-copyright'); ?>
						</div>
				</div>
			<?php } ?>
		</div>
	</div>
</footer>
<?php if (is_active_sidebar_YA('floating') ){ ?>
<div class="floating theme-clearfix">
	<?php dynamic_sidebar('floating');  ?>
</div>
</div>
<?php } ?>
<?php if(ya_options()->getCpanelValue('back_active') == '1') { ?>
<a id="ya-totop" href="#" ></a>
<?php }?>
<?php wp_footer(); ?>
</body>
</html>