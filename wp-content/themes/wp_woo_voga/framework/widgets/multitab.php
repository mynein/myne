<?php
/**
 * Multitab
 */
if(!class_exists('WP_Widget_multitab')){
	class WP_Widget_multitab extends WP_Widget {

		function WP_Widget_multitab() {
			$widget_ops = array( 'classname' => 'widget_multitab', 'description' => __( "WD - Multi Tabs",'wpdance' ) );
			$this->WP_Widget('multitab', __('WD - MultiTab','wpdance'), $widget_ops);
		}

		function widget( $args, $instance ) {
			extract( $args );
			global $wpdb; // call global for use in function

			$title_popular = empty( $instance['title_popular'] ) ? __( 'Popular','wpdance' ) : $instance['title_popular'];
			$title_recent = empty( $instance['title_recent'] ) ? __( 'Recent','wpdance' ) : $instance['title_recent'];
			$title_comment = empty( $instance['title_comment'] ) ? __( 'Comments','wpdance' ) : $instance['title_comment'];

			$num_popular = empty( $instance['num_popular'] ) ? 5 : absint($instance['num_popular']);
			$num_recent = empty( $instance['num_recent'] ) ? 5 : absint($instance['num_recent']);
			$num_comment = empty( $instance['num_comment'] ) ? 5 : absint($instance['num_comment']);

			echo $before_widget;
			
			$pc_rand_id = 'container-tabs-'.rand(0, 1000);
	?>
		<div class="container-tabs" id="<?php echo $pc_rand_id; ?>">
			<div id="tabs-post-sidebar" class="tabs-post-sidebar">
				<ul class="nav nav-tabs wd-widget-multitabs">
					<li class="first active"><a href="#popular-tab"><span><span><?php echo esc_attr($title_popular); ?></span></span></a></li>
					<li class=""><a href="#recent-tab"><span><span><?php echo esc_attr($title_recent); ?></span></span></a></li>
					<li class="last"><a href="#comment-tab"><span><span><?php echo esc_attr($title_comment); ?></span></span></a></li>     				
				</ul>
			

				
				<div class="tab-content">
					<!-- Popular Tab -->
					<div id="popular-tab" class="tab-post-content" style="display: block">
						<div class='top-left'><div class='top-right'></div></div>
					<?php 
						$args = array(
									'posts_per_page' 		=> $num_popular
									,'no_found_rows'		=> true
									,'post_status'			=> 'publish'
									,'ignore_sticky_posts'	=> true
									,'meta_key'				=> '_wd_post_views_count'
									,'orderby'				=> 'meta_value_num'
									,'order'				=> 'desc'
									);
						$populars = new WP_Query($args);
						if( $populars->have_posts() ){
							$i = 0;
							?>
							<div class="contentcenter">
								<ul class="popular-post-list tabs-post-list">
							<?php
							while( $populars->have_posts() ){
								global $post;
								$populars->the_post();
								?>
									<li <?php if($i==0) echo "class='first'"; else if($i == $populars->post_count - 1) echo "class='last'";?>>
										<div class="image">
											<a class="thumbnail" href="<?php the_permalink(); ?>">
												<?php 
													if ( has_post_thumbnail() ) {
														the_post_thumbnail('blog_tini_thumb',array('title' => esc_attr(get_the_title()),'alt' => esc_attr(get_the_title()) ));
													} 
												?>
											</a>
											<span class="shadow"></span>
										</div>
										<div class="content">
											<h4 class="bold-upper"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<span class="post-meta">
												<span class="comment"><i class="fa fa-comments"></i><?php $comments_count = wp_count_comments($post->ID);  echo $comments_count->approved;?></span>
												<span class="post-views"><i class="fa fa-eye"></i><?php wd_get_post_views(); ?></span>
												<span class="date-time"><?php the_time(get_option( 'date_format' )); ?></span>
											</span>
										</div>
									</li>
								<?php
								$i++;
							}
							?>
								</ul>
							</div>
							<?php
						}
					?>
						<div class='bot-left'><div class='bot-right'></div></div>
					</div>
					<!-- Recent Tab -->
					<?php $r = new WP_Query(array('posts_per_page' => $num_recent, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true));?>
					<div id="recent-tab" class="tab-post-content" style="display: none">
						<div class='top-left'><div class='top-right'></div></div>
						<?php if ($r->have_posts()) {$i = 0; ?>
						<div class="contentcenter">
						<ul class="recent-post-list tabs-post-list">
						<?php  while ($r->have_posts()) { 
								global $post;
								$r->the_post();
							?>
									<li <?php if($i==0) echo "class='first'";else if($i == $r->post_count - 1) echo "class='last'";?>>
										<div class="image">
											<a class="thumbnail" href="<?php the_permalink(); ?>">
												<?php 
													if ( has_post_thumbnail() ) {
														the_post_thumbnail('blog_tini_thumb',array('title' => esc_attr(get_the_title()),'alt' => esc_attr(get_the_title()) ));
													} 
												?>
											</a>
											<span class="shadow"></span>
										</div>
										<div class="content">
											<h4 class="bold-upper"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
											<span class="post-meta">
												<span class="comment"><i class="fa fa-comments"></i><?php $comments_count = wp_count_comments($post->ID);  echo $comments_count->approved;?></span>
												<span class="post-views"><i class="fa fa-eye"></i><?php wd_get_post_views(); ?></span>
												<span class="date-time"><?php the_time(get_option( 'date_format' )); ?></span>
											</span>
										</div>
									</li>
						<?php $i++;} ?>
						</ul>
						</div>
						<?php }?>
						<div class='bot-left'><div class='bot-right'></div></div>
					</div><!-- End #recent-tab -->

					<!-- Comment Tab -->
					<?php
					$recent_comments = get_comments( array(
						'number'    => $num_comment,
						'status'    => 'approve'
					) );?>
					<div id="comment-tab" class="tab-post-content" style="display: none">
						<div class='top-left'><div class='top-right'></div></div>
						<?php
						if(count($recent_comments)){$i = 0;
						?>	<div class="contentcenter">
							<ul class="tabs-comments-list">
							<?php  
								foreach ($recent_comments as $comment) { $GLOBALS['comment'] = $comment;
									switch ( $comment->comment_type ) :
										case '':
										$class = "";
										if($i == 0)
											$class .= "first ";
										if(++$i == count($recent_comments))
											$class .= "last";
								?>
										<li <?php if($class) echo "class='$class'";?>>
											<div class="avarta"><a href="<?php comment_link() ; ?>"><?php echo get_avatar( $comment, 58 ); ?></a></div>
											<div class="detail">
												<span class="comment-author vcard">
													<?php printf( __( '%s', 'wpdance' ), sprintf( '<cite class="fn"><a href="%1$s" rel="external nofollow" class="url">%2$s</a></cite>', get_comment_author_url(),get_comment_author() ) ); ?>
												</span><!-- .comment-author .vcard -->
												<?php _e("in","wpdance")?> <a class="bold-upper" href="<?php echo esc_url(get_permalink( $comment->comment_post_ID ));?>"><?php echo esc_attr(get_the_title( $comment->comment_post_ID ));?></a>
												<blockquote class="comment-body"><?php echo  string_limit_words(get_comment_text(),10); ?></blockquote>
												
											</div>
										</li>
									<?php
											break;
										case 'pingback'  :
										case 'trackback' :
											break;
									endswitch;		
									?>
							<?php } ?>
							</ul>
							</div>
						<?php } ?>
						<div class='bot-left'><div class='bot-right'></div></div>
					</div>
				</div>
			</div>
		</div>
		
		
  
			<?php 
				$rand_id = rand();
				$random_id = "accordion-".$rand_id;
			?>
			<div class="accordion-tabs wd-widget-multitabs-accordion" id="<?php echo esc_attr($random_id); ?>" style="display:none;">
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseOne-<?php echo esc_attr($rand_id); ?>" data-parent="#<?php echo esc_attr($random_id); ?>" data-toggle="collapse"><span><span><?php echo esc_html($title_popular); ?></span></span></a>
					</div>
					<div class="accordion-body collapse" id="collapseOne-<?php echo esc_attr($rand_id); ?>">
						<div class="accordion-inner">
						</div>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseTwo-<?php echo esc_attr($rand_id); ?>" data-parent="#<?php echo esc_attr($random_id); ?>" data-toggle="collapse"><span><span><?php echo esc_html($title_recent); ?></span></span></a>
					</div>
					<div class="accordion-body collapse" id="collapseTwo-<?php echo esc_attr($rand_id); ?>">
						<div class="accordion-inner">
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" href="#collapseThree-<?php echo esc_attr($rand_id); ?>" data-parent="#<?php echo esc_attr($random_id); ?>" data-toggle="collapse"><span><span><?php echo esc_html($title_comment); ?></span></span></a>
					</div>
					<div class="accordion-body collapse" id="collapseThree-<?php echo esc_attr($rand_id); ?>">
						<div class="accordion-inner">
						</div>
					</div>
				</div>
			</div>	
			
			<script type="text/javascript">
			//<![CDATA[
				 jQuery(function() {
					"use strict";
					
					var windowWidth = jQuery(window).width();	
					var pc_rand_id = '#<?php echo esc_js($pc_rand_id); ?>';
					var mobile_rand_id = '#<?php echo esc_js($random_id); ?>';
					jQuery(pc_rand_id+' .tabs-post-sidebar > ul > li a').bind('click', function(e){
						e.preventDefault();
					});
					jQuery(pc_rand_id+' .tabs-post-sidebar > ul > li').bind('click', function(){
						if( jQuery(this).hasClass('active') ){
							return;
						}
						var current_id = jQuery(pc_rand_id+' .tabs-post-sidebar > ul > li.active').find('a').attr('href');
						jQuery(pc_rand_id+' .tabs-post-sidebar > ul > li').removeClass('active');
						var new_id = jQuery(this).find('a').attr('href');
						jQuery(this).addClass('active');
						
						jQuery(pc_rand_id+' .tab-content '+current_id).fadeOut(300, function(){
							jQuery(pc_rand_id+' .tab-content '+new_id).fadeIn(300);
						});
					});	
					
					jQuery(window).bind('multitab_resize', function(){
						windowWidth = jQuery(window).width();
						if( windowWidth < 768 ){
							jQuery(pc_rand_id).hide();
							jQuery(mobile_rand_id).show();
							jQuery(mobile_rand_id +' .accordion-group').each(function(index,value){
								var popular_html = jQuery(pc_rand_id+' .tab-content #popular-tab').html();
								var recent_html = jQuery(pc_rand_id+' .tab-content #recent-tab').html();
								var comment_html = jQuery(pc_rand_id+' .tab-content #comment-tab').html();
								
								jQuery(value).find('#collapseOne-<?php echo esc_js($rand_id); ?>').children().html(popular_html);
								jQuery(value).find('#collapseTwo-<?php echo esc_js($rand_id); ?>').children().html(recent_html);
								jQuery(value).find('#collapseThree-<?php echo esc_js($rand_id); ?>').children().html(comment_html);
							});
							
							jQuery(mobile_rand_id +' .accordion-group a.accordion-toggle').unbind('click').bind('click', function(e){
								e.preventDefault();
								var group  = jQuery(this).parents('.accordion-group');
								group.find('.accordion-body').slideToggle(400);
							});
							
						}else{
							jQuery(pc_rand_id).show();
							jQuery(mobile_rand_id).hide();
						}
					});	
					
					jQuery(window).resize(function() {
						jQuery(window).trigger('multitab_resize');
					});
					jQuery(window).trigger('multitab_resize');
					
				 });
			//]]>	 
			</script>
		

	<?php
			wp_reset_postdata();

			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
				$instance = $old_instance;
				$instance['title_popular'] = strip_tags($new_instance['title_popular']);
				$instance['title_recent'] = strip_tags($new_instance['title_recent']);
				$instance['title_comment'] = strip_tags($new_instance['title_comment']);
			   
				$instance['num_popular'] = strip_tags($new_instance['num_popular']);
				$instance['num_recent'] = strip_tags($new_instance['num_recent']);
				$instance['num_comment'] = strip_tags($new_instance['num_comment']);

				return $instance;
		}

		function form( $instance ) {
				//Defaults
				$defaults = array(
							'title_popular'		=> 'Popular'
							,'title_recent'		=> 'Recent'
							,'title_comment'	=> 'Comments'
							,'num_popular'		=> 5
							,'num_comment'		=> 5
							,'num_recent'		=> 5
							);
				
				$instance = wp_parse_args( (array) $instance, $defaults );
				
				$title_popular = isset($instance['title_popular']) ? esc_attr( $instance['title_popular'] ) : '';
				$title_recent = isset($instance['title_recent']) ? esc_attr( $instance['title_recent'] ) : '';
				$title_comment = isset($instance['title_comment']) ? esc_attr( $instance['title_comment'] ) : '';

				$num_popular = isset($instance['num_popular']) ? absint($instance['num_popular']) : 5;
				$num_comment = isset($instance['num_comment']) ? absint($instance['num_comment']) : 5;
				$num_recent = isset($instance['num_recent']) ? absint($instance['num_recent']) : 5;
						
	?>			
				<p><label for="<?php echo $this->get_field_id('title_popular'); ?>"><?php _e( 'Title for popular tab','wpdance' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_popular'); ?>" name="<?php echo $this->get_field_name('title_popular'); ?>" type="text" value="<?php echo esc_attr($title_popular); ?>" /></p>
	
				<p><label for="<?php echo $this->get_field_id('title_recent'); ?>"><?php _e( 'Title for latest tab','wpdance' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_recent'); ?>" name="<?php echo $this->get_field_name('title_recent'); ?>" type="text" value="<?php echo esc_attr($title_recent); ?>" /></p>

				<p><label for="<?php echo $this->get_field_id('title_comment'); ?>"><?php _e( 'Title for comment tab','wpdance' ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title_comment'); ?>" name="<?php echo $this->get_field_name('title_comment'); ?>" type="text" value="<?php echo esc_attr($title_comment); ?>" /></p>
				
				<p><label for="<?php echo $this->get_field_id('num_popular'); ?>"><?php _e( 'The number of popular posts','wpdance' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_popular'); ?>" name="<?php echo $this->get_field_name('num_popular'); ?>" type="text" value="<?php echo esc_attr($num_popular); ?>" /></p>
				
				<p><label for="<?php echo $this->get_field_id('num_recent'); ?>"><?php _e( 'The number of latest posts','wpdance' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_recent'); ?>" name="<?php echo $this->get_field_name('num_recent'); ?>" type="text" value="<?php echo esc_attr($num_recent); ?>" /></p>

				<p><label for="<?php echo $this->get_field_id('num_comment'); ?>"><?php _e( 'The number of comments','wpdance' ); ?>:</label>
				<input class="widefat" id="<?php echo $this->get_field_id('num_comment'); ?>" name="<?php echo $this->get_field_name('num_comment'); ?>" type="text" value="<?php echo esc_attr($num_comment); ?>" /></p>

	<?php
		}
	}
}
?>
