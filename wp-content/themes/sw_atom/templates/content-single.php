<?php while (have_posts()) : the_post(); ?>
<?php
	$related_post_column = ya_options()->getCpanelValue('sidebar_blog');
?>
  <?php setPostViews(get_the_ID()); ?>
  <div <?php post_class(); ?>>
	<?php $pfm = get_post_format();?>
    <header class="header-single">
    </header>
    <div class="entry-content">
	<?php if( $pfm == '' || $pfm == 'image' ){?>
	  <?php if( has_post_thumbnail() ){ ?>
	  <div class="single-thumb">
		<?php the_post_thumbnail('ya_detail_thumb'); ?>
	  </div>
	  <?php } }?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
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
	  <div class="single-content">
		  <?php the_content(); ?>
	  </div>
		<!-- Tag -->
	  <?php if(get_the_tag_list()) { ?>
		  <div class="single-tag">
				<?php echo get_the_tag_list('<span>Tags: </span>',', ','');  ?>
		  </div>
	  <?php } ?>
	  <!-- Social -->
	  <?php get_social(); ?>
	  <!-- link page -->
	  <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'yatheme' ).'</span>', 'after' => '</div>' , 'link_before' => '<span>', 'link_after'  => '</span>' ) ); ?>
    </div>
	 <div id="authorDetails">
		<h4 class="title">About the author </h4>
	  <div class="authorDetail">
		  <?php get_the_author_meta() ?>
		  <div class="avatar">
			  <?php echo get_avatar( $post->post_author , 100 ); ?>
		  </div>
		  <div class="infomation">
			  <h4><a href="<?php the_author_meta('url'); ?>"><?php echo get_the_author()?></a></h4>
			 <p> <?php echo the_author_meta('description') ;?></p>
			  Website: <a href="<?php echo the_author_meta('url');?>"><?php echo the_author_meta('url');?></a>
		  </div>
	  </div>
	</div> 
		  <!-- Relate Post -->
	  <?php 
			global $post;
			global $related_term;
			$class_col= "";
			$categories = get_the_category($post->ID);								
			$category_ids = array();
			foreach($categories as $individual_category) {$category_ids[] = $individual_category->term_id;}
			if ($categories) {
				if($related_post_column =='full'){
					$class_col .= 'col-lg-3 col-md-3 col-sm-3 clearfix';
					$related = array(
						'category__in' => $category_ids,
						'post__not_in' => array($post->ID),
						'showposts'=>4,
						'orderby'	=> 'rand',	
						'ignore_sticky_posts'=>1
					   );
				}else{
					$class_col .= 'col-lg-4 col-md-4 col-sm-4 clearfix';
					$related = array(
						'category__in' => $category_ids,
						'post__not_in' => array($post->ID),
						'showposts'=>3,
						'orderby'	=> 'rand',	
						'ignore_sticky_posts'=>1
					   );
				}
		?>
	  <div class="single-post-relate">
		<h3><?php esc_html_e('Related Posts', 'yatheme'); ?></h3>
		<div class="row">
		<?php
			$related_term = new WP_Query($related);
			while($related_term -> have_posts()):$related_term -> the_post();
		?>
			<div <?php post_class($class_col); ?> >
				<div class="item-relate-img">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('ya_related_post'); ?></a>
				</div>
				<div class="item-relate-content">
					<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					<p>
						<?php
							$text = strip_shortcodes( $post->post_content );
							$text = apply_filters('the_content', $text);
							$text = str_replace(']]>', ']]&gt;', $text);
							$content = wp_trim_words($text, 10,'...');
							echo esc_html($content);
						?>
					</p>
				</div>
			</div>
		<?php
			endwhile;
			wp_reset_postdata();
		?>
		</div>
	  </div>
	  <?php } ?>
	<nav>
    	<ul class="pager">
      		<li class="previous"><?php previous_post_link( '%link', __( '<span class="fa fa-arrow-circle-left"></span> %title', 'yatheme' ), true );?></li>
      		<li class="next"><?php next_post_link( '%link', __( '%title <span class="fa fa-arrow-circle-right "></span>', 'yatheme' ), true ); ?></li>
    	</ul>
  	</nav>
    <?php comments_template('/templates/comments.php'); ?>
  </div>
<?php endwhile; ?>
