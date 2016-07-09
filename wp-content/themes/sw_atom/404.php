<?php get_template_part('header'); ?>
<div class="container">
		<div class="row">
            <div class="col-lg-12 col-md-12">
				<div class="col-1-wrapper">
					<div class="std">
						<div class="wrapper_404page">
							<div class="error-code">
								<span class="erro-key">
									<img class="img_logo" alt="404" src="<?php echo get_template_directory_uri(); ?>/assets/img/img-404.png">
								</span>
							</div>
							<div class="block-main">
								<div class="block-inner">
									<div class="mess-code"><p>The page you were looking for could not be found :(</p></div>
									<div class="second-block">
									<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="Go back to Home"><?php _e( "Go back to Home", 'yatheme' )?></a>
									</div>
								</div>
							</div>
							<div style="clear:both; height:0px">&nbsp;</div>
							<script>
							function goBack() {
								window.history.back()
							}
							</script>
						</div>
					</div>   
				</div>
			</div>
        </div>
</div>
<?php get_template_part('footer'); ?>