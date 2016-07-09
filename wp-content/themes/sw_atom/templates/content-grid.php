<?php if (!have_posts()) : ?>
<?php get_template_part('templates/no-results'); ?>
<?php endif; ?>
<?php
	$blog_columns = ya_options()->getCpanelValue('blog_column');	
	$col = 'col-sm-'.(12/$blog_columns).' theme-clearfix';
	global $instance;
?>
<div class="row grid-blog">
<?php 
	while (have_posts()) : the_post(); 
	$format = get_post_format();
	global $post;
?>
	<div id="post-<?php the_ID();?>" <?php post_class($col); ?>>
		<div class="entry clearfix">
			<?php if( $format == '' ){?>
				<?php if ( get_the_post_thumbnail() ){?>
				<div class="entry-thumb">	
					<div class="entry-thumb-content">
						<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('ya_grid_blog');?>				
						</a>	
					</div>
				</div>			
			<?php }else{ ?>
				<div class="entry-thumb">
					<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<div class="img_over">
							<img src="<?php echo get_template_directory_uri().'/assets/img/format/medium-'.$format.'.png'; ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>" />
						</div>
					</a>
				</div>
			<?php } ?>

			<div class="entry-content">				
				<span class="entry-date">
						<span class="day-post"><?php echo ( get_the_title() ) ? date( 'j',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'j',strtotime($post->post_date)).'</a>'; ?></span>
						<span class="month-post"><?php echo ( get_the_title() ) ? date( 'F',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'F',strtotime($post->post_date)).'</a>'; ?></span>
				</span>
				<div class="content-right">
					<div class="title-blog">
						<h3>
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
						</h3>
					</div>
					<div class="entry-summary">
						<?php 												
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								$content = explode($matches[0], $post->post_content, 2);
								$content = $content[0];
								$content = wp_trim_words($post->post_content, 22, '...');
								echo $content;	
							} else {
								the_content('...');
							}		
						?>	
					</div>
				 <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'yatheme' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
					<div class="entry-bottom">
						<span class="category-blog"><i class="fa fa-folder-open"></i><?php esc_html_e( '', 'yatheme' ); ?> <?php the_category(', '); ?></span>		 
						<span class="entry-comment"><?php echo esc_html( $post->comment_count ) .'<span>'. __(' comments', 'yatheme').'</span>'; ?></span>		
						<span class="author"><?php esc_html_e('By', 'yatheme'); ?> <?php the_author_posts_link(); ?></span>	
					 </div>
				</div>
			</div>
			<?php } elseif( !$format == ''){?>
				<div class="entry-thumb">	
						<?php if( $format == 'video' || $format == 'audio' ){ ?>	
							<?php echo ( $format == 'video' ) ? '<div class="video-wrapper">'. get_entry_content_asset($post->ID) . '</div>' : get_entry_content_asset($post->ID); ?>										
						<?php } ?>
						<?php if( $format == 'image' ){?>
							<div class="entry-thumb-content">
								<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
									<?php the_post_thumbnail(array( 420, 250));?>				
								</a>	
							</div>
						<?php } ?>
						<?php if( $format == 'gallery' ) { 
							if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
								$attrs = array();
								if (count($matches[1])>0){
									foreach ($matches[1] as $m){
										$attrs[] = shortcode_parse_atts($m);
									}
								}
								if (count($attrs)> 0){
									foreach ($attrs as $attr){
										if (is_array($attr) && array_key_exists('ids', $attr)){
											$ids = $attr['ids'];
											break;
										}
									}
								}
							?>
								<div id="gallery_slider_<?php echo $post->ID; ?>" class="carousel slide gallery-slider" data-interval="0">	
									<div class="carousel-inner">
										<?php
											$ids = explode(',', $ids);						
											foreach ( $ids as $i => $id ){ ?>
												<div class="item<?php echo ( $i== 0 ) ? ' active' : '';  ?>">			
														<?php echo wp_get_attachment_image($id, 'full'); ?>
												</div>
											<?php }	?>
									</div>
									<a href="#gallery_slider_<?php echo $post->ID; ?>" class="left carousel-control" data-slide="prev"><?php esc_html_e( 'Prev', 'yatheme' ) ?></a>
									<a href="#gallery_slider_<?php echo $post->ID; ?>" class="right carousel-control" data-slide="next"><?php esc_html_e( 'Next', 'yatheme' ) ?></a>
								</div>
							<?php }	?>							
						<?php } ?>

						<?php if( $format == 'quote' ) { ?>
							<div class="entry-thumb" style="display: none;">
							</div>
						<?php } ?>
				</div>
					<div class="entry-content">
						<div class="title-blog">
							<h3>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
							</h3>
						</div>
						<div class="entry-meta">
							<span class="entry-date">
								<i class="fa fa-clock-o"></i><?php echo ( get_the_title() ) ? date( 'l, F j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'l, F j, Y',strtotime($post->post_date)).'</a>'; ?>
							</span>
							<span class="category-blog"><i class="fa fa-folder-open"></i><?php esc_html_e( '', 'yatheme' ); ?> <?php the_category(', '); ?></span>
						</div>
						<div class="entry-comment">
							<span class="comment"><?php echo esc_html( $post->comment_count ) .'<span>'. __(' comments', 'yatheme').'</span>'; ?></span>		
							<span class="author"><?php esc_html_e('By', 'yatheme'); ?> <?php the_author_posts_link(); ?></span>	
						</div>
						<div class="entry-summary">
						  <?php the_content( '...' ); ?>
						  <div class="bl_read_more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','yatheme')?></a></div>
						</div>
					  </div>
				
			<?php } ?>
				
		</div>
	</div>
<?php endwhile; ?>
</div>
<div class="clearfix"></div>


