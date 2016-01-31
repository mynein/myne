<?php get_header(); ?>
	<?php do_action('wd_set_post_views'); ?>
	<div class="top-page">
		<?php dimox_breadcrumbs(); ?>
	</div>
	<div id="wd-container" class="blog-template content-wrapper content-area container">
		<div id="content-inner" class="row">
			<?php
				global $wd_data;
				
				$_layout_config = explode("-",$wd_data['wd_post_layout']);
				$_left_sidebar = (int)$_layout_config[0];
				$_right_sidebar = (int)$_layout_config[2];
				$_main_class = ( $_left_sidebar + $_right_sidebar ) == 2 ? "col-sm-12" : ( ( $_left_sidebar + $_right_sidebar ) == 1 ? "col-sm-18" : "col-sm-24" );
			?>
			<?php if( $_left_sidebar ): ?>
			<div id="left-content" class="col-sm-6">
				<div class="sidebar-content">
				<?php
					if ( is_active_sidebar($wd_data['wd_post_left_sidebar']) ) : ?>
						<ul class="xoxo">
							<?php dynamic_sidebar($wd_data['wd_post_left_sidebar']); ?>
						</ul>
				<?php endif; ?>
				</div>
			</div><!-- end left sidebar -->
			<?php endif; ?>
			<div id="main-content" class="<?php echo esc_attr($_main_class) ?>">	
				<article class="single-content">
					<?php	
					if(have_posts()) : 
						while(have_posts()) : the_post(); 
						global $post,$wd_data;										
						?>
							<div class="post-meta">
								<div class="navi">
									<div class="navi-next"><?php next_post_link('%link', 'Next &rarr;'); ?></div>
									<div class="navi-prev"><?php previous_post_link('%link', '&larr; Prev '); ?> </div>
								</div>
								<?php edit_post_link( __( 'Edit', 'wpdance' ), '<span class="wd-edit-link hidden-phone">', '</span>' ); ?>	
							</div>
							<div <?php post_class("single-post");?>>
								
								<div class="post_inner">	
								
									<div class="post-info-meta-top post-info-meta">

										<?php if( absint($wd_data['wd_blog_details_author']) == 1 ) : ?>	
											<span class="author"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
										<?php endif; ?>
										<?php if( absint($wd_data['wd_blog_details_comment']) == 1 ) : ?>
											<span class="comments-count"><i class="fa fa-comment-o"></i><?php $comments_count = wp_count_comments($post->ID);  echo esc_html($comments_count->approved);?></span>
										<?php endif; ?>
										<?php if( absint($wd_data['wd_blog_details_views']) == 1 ) : ?>
											<span class="post-views"><i class="fa fa-eye"></i><?php wd_get_post_views(); ?></span>
										<?php endif ?>
										<?php if( absint($wd_data['wd_blog_details_time']) == 1 ) : ?>			
											<span class="entry-date"><i class="fa fa-calendar"></i><?php echo get_the_date('d M y') ?></span>
										<?php endif; ?>
										
									</div>
									
									<?php if( $wd_data['wd_blog_details_thumbnail'] == 1 ) : ?>
									<?php 
										$_post_config = get_post_meta($post->ID,THEME_SLUG.'custom_post_config',true);
										$_post_config = unserialize($_post_config);
										$video_url = '';
										if( isset($_post_config['video']) && $_post_config['video']!= '' ){
											$video_url = esc_url($_post_config['video']);
										}
									?>
									<div class="thumbnail <?php echo !empty($video_url)?'video':'' ?>">
										<?php 
											if( !empty($video_url) ){
												echo wd_get_embbed_video( $video_url, 800, 470 );
											}
											else{
												?>
												<div class="image">
													<!--<a class="thumb-image" href="<?php the_permalink() ; ?>">-->
													<?php 
														if ( has_post_thumbnail() ) {
															the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-blog'));
														} 			
													?>	
														<!--<div class="thumbnail-shadow"></div>	
													</a>-->
													
												</div>
												<?php
											}
										?>	
									</div>
									<?php endif;?>
									<header class="post-title">
										<h3 class="heading-title"><?php the_title(); ?></h3>	
									</header>
									
									<div class="post-info-content">
										<div class="post-description"><?php the_content(); ?></div>
										
										<?php wp_link_pages(); ?>
										
									</div>
											
								</div>
								<div class="post-info-meta-bottom">	
								<!--Category List-->
								<?php if( $wd_data['wd_blog_details_categories'] == 1 ) : ?>
									<?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
									<?php
										/* translators: used between list items, there is a space after the comma */
										$categories_list = get_the_category_list( __( '&nbsp; &nbsp; &nbsp;', 'wpdance' ) );
											if ( $categories_list ):
										?>
										<div class="categories">
											<span class="cat-links">
												<?php printf( __( '<span>Categories </span> %2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );?>
											</span>
										</div>
										<?php endif; // End if categories ?>
									<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>	
								
								<?php endif;?>	
									
								<?php if( absint($wd_data['wd_blog_details_socialsharing']) == 1 ) : ?>
									<?php wd_blog_details_sharing(); ?>
								<?php endif;?>
									
								<?php if( absint($wd_data['wd_blog_details_tags']) == 1 ) : ?>
									<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
									<?php
										/* translators: used between list items, there is a space after the comma */
										$tags_list = get_the_tag_list('','&nbsp; &nbsp; &nbsp; ','');
										 
										if ( $tags_list ):
										?>
											<div class="tags">
												<span class="tag-title"><?php _e('Tags','wpdance');?></span>
												<span class="tag-links">
													<?php printf( __( '<span class="%s"> </span> %s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
													$show_sep = true; ?>
												</span>
											</div>
										<?php endif; // End if $tags_list ?>
									<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>
								<?php endif; ?>
																				
								</div>
							</div>
								
							<?php if( absint($wd_data['wd_blog_details_authorbox']) == 1 ) : ?>
							<div id="entry-author-info">
								<div class="author-inner">
									<div id="author-avatar" class="image-style">
										<?php echo get_avatar( get_the_author_meta( 'user_email' ), 139 ); ?>
									</div><!-- #author-avatar -->		
									<div class="author-desc">		
										<ul class="author-detail">
											<li class="first bold-upper-normal"><?php the_author_posts_link();?></li>
											<li class="second">
												<i><?php echo get_user_role(get_the_author_meta('ID'));?></i>
											</li>
										</ul>
										<p><?php the_author_meta( 'description' ); ?><p>
									</div>
								</div><!-- #author-inner -->
							</div><!-- #entry-author-info -->
							<?php endif; ?>	
							<?php if( absint($wd_data['wd_blog_details_related']) == 1 ) : ?>
								<?php 
									get_template_part( 'templates/related_posts' );
								?>
							<?php endif;?>
							
							<?php 
							if( $wd_data['wd_blog_details_commentlist'] ){
								comments_template( '', true );
							}
							
							endwhile;
							wp_reset_postdata();
						endif;	
						?>
				</article>
			</div>
			<?php if( $_right_sidebar  ): ?>
					<div id="right-content" class="col-sm-6">
						<div class="sidebar-content">
						<?php
							if ( is_active_sidebar( $wd_data['wd_post_right_sidebar']) ) : ?>
								<ul class="xoxo">
									<?php dynamic_sidebar( $wd_data['wd_post_right_sidebar'] ); ?>
								</ul>
						<?php endif; ?>
						</div>
					</div><!-- end right sidebar -->
		<?php endif;?>	
		</div>
	</div><!-- #primary -->

<?php
get_footer();
