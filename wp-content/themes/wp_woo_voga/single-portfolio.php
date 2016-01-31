<?php
get_header(); ?>
<div class="top-page">
	<?php dimox_breadcrumbs(); ?>
</div>
<div id="wd-container" class="single-portfolio content-wrapper content-area container">
	<div id="content-inner" class="row">
		<div id="main-content" class="col-sm-18">
			<article class="single-content">
				<?php	
					if(have_posts()) : 
						while(have_posts()) : the_post(); global $post,$smof_data;
							$thumb = esc_html(get_post_thumbnail_id($post->ID));
							$post_title = esc_html(get_the_title($post->ID));
							$post_url =  esc_url(get_permalink($post->ID));
							$url_video = esc_url(get_post_meta($post->ID,THEME_SLUG.'video_portfolio',true));
							$proj_link = esc_url(get_post_meta($post->ID,THEME_SLUG.'proj_link',true));
							if(	strlen(trim($proj_link)) < 0 ){
								$proj_link = $post_url;
							}

							if( strlen( trim($url_video) ) > 0 ){
								$rand_id = rand().time();
								$slider_start_li = array(	'id' => $rand_id,
															'alt' => $post_title,
															'title' => $post_title
														);
								if(strstr($url_video,'youtube.com') || strstr($url_video,'youtu.be')){
									$thumb_url = array(get_thumbnail_video_src($url_video , 850 ,340));
									$item_class = "thumb-video youtube-fancy";
								}
								if(strstr($url_video,'vimeo.com')){
									$thumb_url = array(wp_parse_thumbnail_vimeo(wp_parse_vimeo_link($url_video), 850, 340));	
									$item_class = "thumb-video vimeo-fancy";
								}
								if( $thumb ){
									$thumb_url = wp_get_attachment_image_src($thumb,'full');
								}
								$light_box_url = $url_video;
							}else{
								$thumb_url = wp_get_attachment_image_src($thumb,'full');
								$item_class = "thumb-image";
								$light_box_url = esc_url($thumb_url[0]);
							}								
							
							$portfolio_slider = get_post_meta($post->ID,THEME_SLUG.'_portfolio_slider',true);
							$portfolio_slider = unserialize($portfolio_slider);
							$slider_thumb = false;
							if( is_array($portfolio_slider) && count($portfolio_slider) > 0 ){
								$slider_thumb = true;
							}
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
											<?php if( absint($wd_data['wd_blog_details_views']) == 1 ) : ?>
												<span class="post-views"><i class="fa fa-eye"></i><?php wd_get_post_views(); ?></span>
											<?php endif ?>
											<?php if( absint($wd_data['wd_blog_details_time']) == 1 ) : ?>			
												<span class="entry-date"><i class="fa fa-calendar"></i><?php echo get_the_date('d M y') ?></span>
											<?php endif; ?>
											
										</div>
										
										<?php if( 1||$data['wd_blog_details_thumbnail'] == 1 ) : ?>
										<div class="thumbnail"><?php //if( $single_post_config['show_thumb_phone'] != 1 ) echo " hidden-phone";?>
											<?php 
												$_post_config = get_post_meta($post->ID,THEME_SLUG.'custom_post_config',true);
												$_post_config = unserialize($_post_config);
												if( isset($_post_config['video']) && $_post_config['video']!= '' ){
													echo wd_get_embbed_video( esc_url($_post_config['video']), 800, 470 );
												}
												else{
													?>
													<div class="image">
														<!--<a class="thumb-image" href="<?php the_permalink() ; ?>">-->
														<?php 
															if ( has_post_thumbnail() ) {
																the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-blog'));
																//the_post_thumbnail('blog_thumb',array('class' => 'thumbnail-effect-2'));
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
										<div class="categories">
											<!--Category List-->
											<?php
												/* translators: used between list items, there is a space after the comma */
												$cat_post =  wp_get_post_terms(get_the_ID(),'wd-portfolio-category'); 
												if(is_array($cat_post)){
												$categories = __('<span>Categories</span> ','wpdance');
												foreach($cat_post as $cat){
														$temp  = '<a href="'.get_term_link($cat->slug,$cat->taxonomy).'">'.$cat->name.'</a>'. '&nbsp; &nbsp; &nbsp; ';
														$categories .= $temp ;
													}      
												}
												$categories = substr($categories,0,-2) .''  ;							  
														
												?>
											<span class="cat-links">
												<?php printf( __( '%2$s', 'wpdance' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories );?>
											</span>
										
										</div>	
									<?php endif;?>									
																					
									</div>
								</div>							
								
							<div class="related related_portfolio">
								<header class="title-wrapper">
									<h3 class="heading-title"><?php _e("Related Posts",'wpdance'); ?></h3>
								</header>
								<div class="related_wrapper post-slider loading">
									<div class="slides">
									<?php
										$gallery_ids = array();
										$galleries = wp_get_post_terms($post->ID,'gallery');
										if(!is_array($galleries))
											$galleries = array();
										foreach($galleries as $gallery){
											if( $gallery->count > 0 ){
												array_push( $gallery_ids,$gallery->term_id );
											}	
										}
										if(!empty($galleries) && count($gallery_ids) > 0 )
											$args = array(
												'post_type'=>$post->post_type,
													'tax_query' => array(
													array(
														'taxonomy' => 'gallery',
														'field' => 'id',
														'terms' => $gallery_ids
													)
												),
												'post__not_in'=>array($post->ID),
												'posts_per_page'=> get_option('posts_per_page'),//get_option(THEME_SLUG.'num_post_related', 10)
											);
										else
											$args = array(
											'post_type'=>$post->post_type,
											'post__not_in'=>array($post->ID),
											'posts_per_page'=> get_option('posts_per_page'),//get_option(THEME_SLUG.'num_post_related', 10)
										);
										
										$related=new wp_query($args);$count=0;
										if($related->have_posts()) : 
											while($related->have_posts()) : $related->the_post();global $post;$count++;
												$thumb = (int)get_post_thumbnail_id($post->ID);
												$thumb_url = wp_get_attachment_image_src($thumb,'related_portfolio');
												if(!$thumb_url[0]){ //truong hop slider
													$portfolio_slider = get_post_meta($post->ID,THEME_SLUG.'_portfolio_slider',true);
													$portfolio_slider = unserialize($portfolio_slider);
													if($portfolio_slider)
														$thumb_url = wp_get_attachment_image_src( $portfolio_slider[0]['thumb_id'], 'related_portfolio', false );
												}
												
												?>
												<article class="related-item <?php if($count==1) echo " first";if($count==$related->post_count) echo " last";?>">
													<div>
														<div class="date-time">
															<span class="day"><?php the_time('d'); ?></span>
															<span class="month"><?php the_time('M'); ?></span>
														</div>
														<a class="thumbnail" href="<?php the_permalink(); ?>">
															<?php 
																if ( has_post_thumbnail() ) {
																	the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-blog'));
																} 							
															?>
															<div class="effect_hover_image"></div>
														</a>
														<a class="title bold-upper-normal" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
														<!--<p class="excerpt"><?php //the_excerpt_max_words(10); ?></p>-->
														<span class="author vcard"><i class="fa fa-user"></i><?php the_author_link(); ?></span>
													</div>
												</article>
												<?php
											endwhile;
											wp_reset_postdata();
										endif;
									?>
									</div>
								</div>
							</div>									
								
							
							<?php echo stripslashes(get_option(THEME_SLUG.'code_to_bottom_post'));?>	
						<?php						
						endwhile;
					endif;	
				?>	
			</article>				
		</div><!-- #content -->
			<div id="right-sidebar" class="col-sm-6">
				<div class="right-sidebar-content">
				<?php
					if ( is_active_sidebar( 'category-widget-area' ) ) : ?>
						<ul class="xoxo">
							<?php dynamic_sidebar( 'category-widget-area' ); ?>
						</ul>
				<?php endif; ?>
				</div>
			</div><!-- end right sidebar -->
		</div>	
			<script type="text/javascript">
			jQuery(document).ready(function() {
				"use strict";
				
				var $_this = jQuery('.related_portfolio .related_wrapper');

				var owl = $_this.find('.slides').owlCarousel({
					item : 3
					,responsive		:{
						0:{
							items:1
						},
						480:{
							items:2
						},
						768:{
							items: 2
						},
						992:{
							items: 3
						},
						1200:{
							items:3
						}
					}
					,nav : true
					,navText		: [ '<', '>' ]
					,dots			: false
					,loop			: true
					,lazyload		:true
					,margin			: 20
					,onInitialized: function(){
						$_this.addClass('loaded').removeClass('loading');
					}
				});
			});	
		</script>
	</div><!-- #container -->
<?php get_footer(); ?>