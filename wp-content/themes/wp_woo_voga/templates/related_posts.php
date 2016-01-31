<?php
	global $wd_data;
?>
<div class="related-post related block-wrapper">
	<header class="title-wrapper">
		<h3 class="heading-title"><?php echo stripslashes(esc_attr($wd_data['wd_blog_details_relatedlabel'])); ?></h3>
	</header>
	<div class="related_wrapper post-slider">
		<div class="slides">
		<?php
			$is_slider = false;
		
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
			
			$related=new WP_Query($args);$count=0;
			if($related->have_posts()) : 
				
				if( $related->post_count > 1 ){
					$is_slider = true;
				}
			
				while($related->have_posts()) : $related->the_post();global $post;$count++;
					$thumb = (int)get_post_thumbnail_id($post->ID);
					$thumb_url = wp_get_attachment_image_src($thumb,'related_post');
					if(!$thumb_url[0]){ //truong hop slider
						$blog_slider = get_post_meta($post->ID,THEME_SLUG.'_blog_slider',true);
						$blog_slider = unserialize($blog_slider);
						if($blog_slider)
							$thumb_url = wp_get_attachment_image_src( $blog_slider[0]['thumb_id'], 'related_post', false );
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
										else{ ?>
											<img alt="<?php the_title(); ?>" title="<?php the_title();?>" src="<?php echo get_template_directory_uri(); ?>/images/no-image-thumbnail.jpg"/>
										<?php
										}										
									?>
									<div class="effect_hover_image"></div>
								</a>
								<a class="title bold-upper-normal" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								<p class="excerpt"><?php the_excerpt_max_words(20); ?></p>
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

<?php if( $is_slider ): ?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		"use strict";
		
		if( jQuery('.related-post .related_wrapper .related-item').length > 1 ){
			var $_this = jQuery('.related-post .related_wrapper');

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
		}
	});	
</script>
<?php endif; ?>