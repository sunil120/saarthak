<?php get_header(); ?>
<div class="category-header">
	<div class="container">
		<h1 class="entry-title"><?php esc_html_e( 'Search', 'yatheme' ); ?></h1>		
		<div class="bread">
		<?php

			/* if (function_exists('ya_breadcrumb')){
				 ya_breadcrumb('<div class="breadcrumbs theme-clearfix"><div class="container">', '</div></div>');
			 } */

		?>
		</div>
	</div>
</div>
<div class="container">
	<?php
		$ya_post_type = isset( $_GET['search_posttype'] ) ? $_GET['search_posttype'] : '';
		if( ( $ya_post_type != '' ) &&  locate_template( 'templates/search-' . $ya_post_type . '.php' ) ){
			get_template_part( 'templates/search', $ya_post_type );
		}else{ 
			if( have_posts() ){
		?>
			<div class="blog-content">
		<?php 
			while (have_posts()) : the_post(); 
			global $post;
			$post_format = get_post_format();
		?>
			<div id="post-<?php the_ID();?>" <?php post_class( 'theme-clearfix' ); ?>>
				<div class="entry clearfix">
					<?php if (get_the_post_thumbnail()){?>
					<div class="entry-thumb pull-left">
						<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">			
							<?php the_post_thumbnail("thumbnail")?>
						</a>
					</div>
					<?php }?>
					<div class="entry-content">
						<div class="title-blog">
							<h3>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a>
							</h3>
						</div>
						<div class="entry-meta">
							<span class="entry-author"><i class="fa fa-user"></i><?php esc_html_e('', 'yatheme'); ?><?php the_author_posts_link(); ?></span>
							<span class="entry-date">
								<i class="fa fa-clock-o"></i><?php echo ( get_the_title() ) ? date( 'F j, Y',strtotime($post->post_date)) : '<a href="'.get_the_permalink().'">'.date( 'F j, Y',strtotime($post->post_date)).'</a>'; ?>
							</span>
							<span class="entry-comment"><i class="fa fa-comments"></i><?php echo esc_html( $post->comment_count ) ?><?php esc_html_e(' Comment(s)', 'yatheme'); ?></span>
						</div>
						<div class="entry-description">
							<?php 
														
								if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
									$content = explode($matches[0], $post->post_content, 2);
									$content = $content[0];
									$content = wp_trim_words($post->post_content, 30, '...');
									echo $content;	
								} else {
									$content = wp_trim_words($post->post_content, 25, '...');
									echo $content;	
								}		
							?>
						</div>
						<div class="bl_read_more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more','yatheme')?><i class="fa fa-angle-double-right"></i></a></div>
						 <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'yatheme' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
					</div>
				</div>
			</div>			
		<?php endwhile; ?>
		<?php get_template_part('templates/pagination'); ?>
		</div>
	<?php
		}else{
				get_template_part('templates/no-results');
			}
		}
	?>
</div>
<?php get_footer(); ?>