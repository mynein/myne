<?php
add_image_size('testimonial',115,115);
if(!function_exists('wd_testimonial_function')){
	function wd_testimonial_function($atts,$content){
		extract(shortcode_atts(array(
			'slug'				=>		''
			,'id'				=>		0
			,'style'			=>		'style-1'
			,'background'		=> 		''
			
		),$atts));
		
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "testimonials-by-woothemes/woothemes-testimonials.php", $_actived ) ) {
			return;
		}
		
		global $post;
		$count = 0;
		if( absint($id) > 0 ){
			$_feature = woothemes_get_testimonials( array('id' => $id,'limit' => 1 ));
		}elseif( strlen(trim($slug)) > 0 ){
			$_feature = get_page_by_path($slug, OBJECT, 'testimonial');
			if( !is_null($_feature) ){
				$_feature = woothemes_get_testimonials( array('id' => $_feature->ID,'limit' => 1 ));
			}else{
				return;
			}
		}else{
			return;
			//invalid input params.
		}
		
		if( !is_array($_feature) && count($_feature) <= 0 ){
			return;
		}else{
			global $post;
			$_feature = $_feature[0];
			$post = $_feature;
			setup_postdata( $post ); 
		}
		ob_start();
		?>
			<?php if ($style == "style-1"): ?>
			<div class="testimonial-item testimonial <?php echo $style ?>" style="background:<?php echo $background ?>">
				<blockquote class="testimonial-content"><span class="icon-quote">&ldquo;</span><?php echo get_the_content();?><span class="icon-quote-right">&rdquo;</span></blockquote>
				<div class="avartar">
					<a href="#"><?php the_post_thumbnail('woo_shortcode');?></a>
				</div>							
				<div class="detail">
					<header>
						<h3 class="bold-upper-big"><?php the_title();?></h3>
						<div class="job"><i><?php echo get_post_meta($post->ID,'_byline',true);?></i></div>
					</header>
					<!--<div class="twitter_follow"><a class="first" href="<?php echo get_post_meta($post->ID,'_url',true);?>">Follow</a> <a class="second" href="<?php echo get_post_meta($post->ID,'_url',true);?>">@<?php echo get_post_meta($post->ID,THEME_SLUG.'username_twitter_testimonial',true);?></a></div>-->
				</div>						
			</div>
			<?php elseif ($style == "style-2"): ?>
			<div class="testimonial-item testimonial <?php echo $style ?>" style="background:<?php echo $background ?>">
				<div class="detail">
					<header>
						<h3 class="bold-upper-big"><?php the_title();?></h3>
						<div class="job"><i><?php echo get_post_meta($post->ID,'_byline',true);?></i></div>
					</header>
					<!--<div class="twitter_follow"><a class="first" href="<?php echo get_post_meta($post->ID,'_url',true);?>">Follow</a> <a class="second" href="<?php echo get_post_meta($post->ID,'_url',true);?>">@<?php echo get_post_meta($post->ID,THEME_SLUG.'username_twitter_testimonial',true);?></a></div>-->
				</div>	
				<blockquote class="testimonial-content"><span class="icon-quote">&ldquo;</span><?php echo get_the_content();?><span class="icon-quote-right">&rdquo;</span></blockquote>
				<div class="avartar">
					<a href="#"><?php the_post_thumbnail('woo_shortcode');?></a>
				</div>												
			</div>
			<?php endif; ?>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		wp_reset_postdata();
		return $output;
	}
}
add_shortcode('wd_testimonial','wd_testimonial_function');

if(!function_exists('wd_testimonial_slider_shortcode')){
	function wd_testimonial_slider_shortcode($atts,$content){
		extract(shortcode_atts(array(
			'style'				=>	'style-1'
			,'background'		=> 	''
			,'limit'			=>	2
			,'show_nav' 		=>  0
			,'show_pagination'	=>  0
		),$atts));
		
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "testimonials-by-woothemes/woothemes-testimonials.php", $_actived ) ) {
			return;
		}
		$args = array(
			'posts_per_page'   => $limit
			,'post_type' 	   => 'testimonial'
			,'orderby'         => 'date'
			,'order'           => 'desc'
			,'post_status'     => 'publish'
		);
		$testimonials = new WP_Query($args );
		ob_start();
		$rand_id = 'wd_testimonial_'.rand();
		?>
		
		<div id="<?php echo $rand_id; ?>" class="wd_testimonial_slider <?php echo (isset($testimonials->post_count) && $testimonials->post_count > 1)?'loading':'' ?>">
		<?php
			if( $testimonials->have_posts() ){
				while( $testimonials->have_posts() ){
					$testimonials->the_post();
					?>
						<?php if( $style == "style-1" ): ?>
						<div class="testimonial-item testimonial item <?php echo $style ?>" style="background:<?php echo $background ?>">
							<blockquote class="testimonial-content"><span class="icon-quote">&ldquo;</span><?php echo get_the_content();?><span class="icon-quote-right">&rdquo;</span></blockquote>
							<div class="avartar">
								<a href="#"><?php the_post_thumbnail('woo_shortcode');?></a>
							</div>							
							<div class="detail">
								<header>
									<h3 class="bold-upper-big"><?php the_title();?></h3>
									<div class="job"><i><?php echo get_post_meta(get_the_ID(),'_byline',true);?></i></div>
								</header>
							</div>						
						</div>
						<?php elseif( $style == "style-2" ): ?>
						<div class="testimonial-item testimonial <?php echo $style ?>" style="background:<?php echo $background ?>">
							<div class="detail">
								<header>
									<h3 class="bold-upper-big"><?php the_title();?></h3>
									<div class="job"><i><?php echo get_post_meta(get_the_ID(),'_byline',true);?></i></div>
								</header>
							</div>	
							<blockquote class="testimonial-content"><span class="icon-quote">&ldquo;</span><?php echo get_the_content();?><span class="icon-quote-right">&rdquo;</span></blockquote>
							<div class="avartar">
								<a href="#"><?php the_post_thumbnail('woo_shortcode');?></a>
							</div>												
						</div>
						<?php endif; ?>
		
				<?php
				}//end for each
			
			}//end if
		
		$show_nav = $show_nav? 'true' : 'false';
		$show_pagination = $show_pagination? 'true' : 'false' ;
		
		?>
		</div>
		<script type='text/javascript'>				
			jQuery(document).ready(function(){
				"use strict";
				if( jQuery("#<?php echo esc_js($rand_id); ?> .testimonial-item").length > 1 ){
					jQuery("#<?php echo esc_js($rand_id); ?>").owlCarousel({
						loop: true
						,items: 1
						,margin: 0
						,animateOut: 'fadeOut'
						,animateIn: 'fadeIn'
						,nav: <?php echo esc_js($show_nav); ?>
						,mouseDrag: false
						,dots: <?php echo esc_js($show_pagination); ?>
						,autoplay: true
						,autoplayHoverPause: true
						,onInitialized: function(){
							jQuery("#<?php echo esc_js($rand_id); ?>").addClass('loaded').removeClass('loading');
						}
					});
				}
			});
		</script>
		<?php
		$output = ob_get_clean();
		wp_reset_postdata();
		return $output;
	}
}
add_shortcode('wd_testimonial_slider', 'wd_testimonial_slider_shortcode');
?>