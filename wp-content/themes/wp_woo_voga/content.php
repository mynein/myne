<?php
	global $wd_data, $post;
	$post_id = get_the_ID();
?>
<li <?php post_class(); ?>>
	<div class="post-info-thumbnail">
		<?php if( $wd_data['wd_blog_thumbnail'] == 1 ) : ?>
			<?php 
			$_post_config = get_post_meta($post_id, THEME_SLUG.'custom_post_config', true);
			$_post_config = unserialize($_post_config);
			$video_url = '';
			if( isset($_post_config['video']) && $_post_config['video']!= '' ){
				$video_url = esc_url($_post_config['video']);
			}
			?>
			<div class="thumbnail-content <?php echo !empty($video_url)?'video':'' ?>">
				<?php 
					if( !empty($video_url) ){
						echo wd_get_embbed_video( $video_url, 800, 470 );
					}
					else{
						?>
							<a class="thumbnail" href="<?php the_permalink() ; ?>">
							<?php 
								if ( has_post_thumbnail() ) {
									the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-blog')); 
								} else { ?>
									<img alt="<?php the_title(); ?>" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-image-blog.gif"/>
							<?php	}										
							?>
							<div class="effect_hover_image"></div>									
							</a>
						<?php
					}
				?>	
			</div>
			
		<?php endif;?>
	</div>
	
	<div class="post-info-content">
		<header class="post-title">
			<h3 class="heading-title"><a class="post-title heading-title" href="<?php the_permalink() ; ?>"><?php the_title(); ?></a></h3>
			<?php edit_post_link( __( 'Edit', 'wpdance' ), '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>	
		</header>
		<?php if( $wd_data['wd_blog_excerpt'] == 1 ) : ?>
			<div class="short-content"><?php the_excerpt_max_words(50,$post); ?></div>
		<?php endif; ?>					
		<div class="post-info-meta">	
			
			<?php if( $wd_data['wd_blog_author'] == 1 ) : ?>
				<span class="author">
					<i class="fa fa-user"></i><?php //_e('Post by','wpdance')?><?php the_author_posts_link(); ?>
				</span>
			<?php endif;?>
			
			<?php if( $wd_data['wd_blog_comment_number'] == 1 ) : ?>	
				<span class="comments-count"><i class="fa fa-comments"></i><?php $comments_count = wp_count_comments($post_id); if($comments_count->approved < 10 && $comments_count->approved > 0) echo '0'; echo esc_html($comments_count->approved); ?></span>
			<?php endif;?>
			
			<?php if( absint($wd_data['wd_blog_views']) == 1 ) : ?>
				<span class="post-views"><i class="fa fa-eye"></i><?php wd_get_post_views($post_id); ?></span>
			<?php endif ?>
			
			<?php if( $wd_data['wd_blog_time'] == 1 ) : ?>	
				<span class="entry-date"><?php echo get_the_date('M d Y') ?></span>
			<?php endif;?>
			
			<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) && $wd_data['wd_blog_categories'] == 1 ) : ?>
			<?php
				$categories_list = get_the_category_list( __( '&nbsp; &nbsp; &nbsp; ', 'wpdance' ) );
					if ( $categories_list ):
				?>
				<div class="cat-links">
					<?php printf( __( '<span>Categories </span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );?>
				</div>
				<?php endif;?>
			<?php endif; ?>	
			
			<?php if( absint($wd_data['wd_blog_readmore']) == 1 ) : ?>
				<span class="read-more"><a class="bold-upper-small" href="<?php the_permalink() ; ?>"><?php _e('Read','wpdance'); ?><i class="fa fa-long-arrow-right"></i></a></span>
			<?php endif;?>
			
		</div>
		<?php wp_link_pages(); ?>

	</div><!-- end post ... -->
</li>