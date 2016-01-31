<?php 
if(!function_exists ('wd_recent_blogs_slider_functions')){
	function wd_recent_blogs_slider_functions($atts,$content = false){
		extract(shortcode_atts(array(
			'category'		=>	''
			,'columns'		=> 4
			,'number_posts'	=> 4
			,'show_type' 	=> 'grid'
			,'title'		=> 1
			,'thumbnail'	=> 1
			,'meta'			=> 1
			,'show_date'	=> 1
			,'excerpt'		=> 1
			,'excerpt_words'=> 20
			,'show_nav' 		=> 0
			,'show_icon_nav' 	=> 0
			,'autoplay' 		=> 0
		),$atts));	

		$args = array(
				'post_type' 			=> 'post'
				,'ignore_sticky_posts' 	=> 1
				,'posts_per_page' 		=> $number_posts
		);	
		if( strlen($category) > 0 ){
			$args = array(
				'post_type' 			=> 'post'
				,'ignore_sticky_posts' 	=> 1
				,'posts_per_page' 		=> $number_posts
				,'category_name' 		=> $category
			);	
		}		
		
		$recent_posts = new WP_Query($args);
		
		$ret_html = '';
		if( $recent_posts->have_posts() ) :
			$num_count = $recent_posts->post_count;
			$id_widget = 'recent-blog-wrapper'.rand(0,1000);
			ob_start();
			echo '<div class="shortcode-recent-blogs wd-slider loading '.$show_type.' columns-'.$columns.'">';?>
			<div id="<?php echo $id_widget ?>" class="blog-wrapper">
			<?php 
			$i = 0;
			while( $recent_posts->have_posts() ){
				$recent_posts->the_post();
				global $post;
				?>
				<article class="item <?php if( $i == 0 || $i % $columns == 0 ) echo ' first';?><?php if( $i == $num_count-1 || $i % $columns == $columns-1 ) echo ' last';?>">
					<div class="header-wrapper">
						<?php if($thumbnail) :?>
						<a class="thumbnail" href="<?php the_permalink(); ?>">
							<?php 
								the_post_thumbnail('blog_shortcode',array('class' => 'thumbnail-effect-1'));
							?>
							<div class="effect_hover_image"></div>
						</a>
						<?php endif ?>
						<?php if( $show_date ): ?>
							<span class="date-time">
								<span><?php echo get_the_time('d'); ?></span>
								<span><?php echo get_the_time('M'); ?></span>
							</span>
						<?php endif; ?>
					</div>
					<div class="detail">
						<?php if($title) : ?>
						<h3 class="heading-title"><a href="<?php echo get_permalink($post->ID); ?>" class="wpt_title"  ><?php echo get_the_title($post->ID); ?></a></h3>
						<?php endif; ?>
						
						<?php if($excerpt): ?>
						<p class="excerpt"><?php the_excerpt_max_words($excerpt_words); ?></p>
						<?php endif; ?>
						
						<?php if($meta): ?>
						<div class="info-meta">
							<span class="author"><i class="fa fa-user"></i><?php _e('','wpdance'); ?> <?php the_author_posts_link(); ?> 
							</span>
							
							<span class="comments-count"><i class="fa fa-comment-o"></i><span class="number"><?php $comments_count = wp_count_comments($post->ID); if($comments_count->approved < 10 && $comments_count->approved > 0) echo '0'; echo $comments_count->approved;?></span>
							</span>
						</div>
						<?php endif; ?>
					</div>	
				</article>
			<?php
				$i++;
			}
			echo '</div>';
			echo '</div>';
			?>
			<script type='text/javascript'>
			//<![CDATA[
				jQuery(document).ready(function() {
					"use strict";
					var temp_visible = <?php echo esc_js($columns); ?>;
					
					var row = 1;
					
					if(jQuery("#<?php echo $id_widget?>").parent('.shortcode-recent-blogs').hasClass('list')){
						row = <?php echo esc_js($columns); ?>;
						temp_visible = 1;
					}
					
					var show_nav = <?php if($show_nav): ?> true <?php else: ?> false <?php endif;?>;

					var show_icon_nav = <?php if($show_icon_nav): ?> true <?php else: ?> false <?php endif;?>;
					
					var object_selector = "#<?php echo $id_widget?>";
					
					var margin = 20;					
						
					var slider_data = {
							nav : show_nav
							,dots : show_icon_nav
							,autoplay : false
							,responsive	: {
								0 : {
									items:1
								},
								300 : {
									items: 2
								},
								600 : {
									items: 3
								},
								1000 : {
									items: 4
								},
								1160 : {
									items: <?php echo esc_js($columns); ?>
								}
							}
					}
					
					<?php if( $columns == 1 ): ?>
						slider_data.responsive = {0:{items: 1}};
					<?php endif; ?>
						
					generate_horizontal_slide(slider_data, row, object_selector,margin);
				});
			//]]>	
			</script>
			<?php
			$ret_html = ob_get_contents();
			ob_end_clean();
			//ob_end_flush();
		endif;
		wp_reset_postdata();
		return $ret_html;
	}
} 
add_shortcode('wd_recent_blogs_slider','wd_recent_blogs_slider_functions');

?>