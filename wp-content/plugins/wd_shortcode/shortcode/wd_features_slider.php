<?php 
	if(!function_exists('wd_features_slider_function')){
		function wd_features_slider_function($atts,$content){
			extract(shortcode_atts(array(
				'slug'					=>		''
				,'id'					=>		0
				,'columns'				=> 		3
				,'show_title'			=>		1
				,'show_thumbnail'		=>		1
				,'show_excerpt'			=>		1
				,'limit'				=>		4
				,'show_nav' 			=> 		1
				,'show_icon_nav' 		=> 		0
				,'autoplay' 			=> 		1
				
			),$atts));
			
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "features-by-woothemes/woothemes-features.php", $_actived ) ) {
				return;
			}
			
			if( absint($id) > 0 ){
				$_feature = woothemes_get_features( array('id' => $id ));
			}elseif( strlen(trim($slug)) > 0 ){
				$_feature = get_page_by_path($slug, OBJECT, 'feature');
				if( !is_null($_feature) ){
					$_feature = woothemes_get_features( array('id' => $_feature->ID ,'limit' => 1, 'size' => 100 ));
				}else{
					return;
				}
			}else{
				// Load multi testimonial
				$_feature = woothemes_get_features( array('limit' => $limit, 'size' => 100 ));
				//invalid input params.
			}
			
			//nothing found
			if( !is_array($_feature) && count($_feature) <= 0 ){
				return;
			}else{
				global $post;
			}
			
			//handle features
			
			ob_start();
			$random_id = 'wd_feature_wrapper_'.rand(0,1000);
			?>
			<div class="wd_shortcode_feature_slider loading ">
				<div id="<?php echo $random_id ?>" <?php post_class('shortcode')?> >
				<?php foreach( $_feature as $feature ){ 
					$post = $feature;
					setup_postdata( $post );
				?>
					<div class="item">
						<div class="feature_content_wrapper">	
						<?php if($show_thumbnail) :?>
							<div class="feature_thumbnail">
								<a href="<?php echo esc_url($feature->url);?>">
								<?php 
									if( has_post_thumbnail() ) : 
										the_post_thumbnail( 'woo_feature', array( 'alt' => esc_attr(get_the_title()), 'title' => esc_attr(get_the_title()) ) );
									endif;
								?>
								<div class="wd-effect"></div>
								</a>
							</div>
						<?php endif;?>
						<?php if($show_title) :?>
							<h3 class="feature_title heading_title bold-upper-big">
								<a href="<?php echo esc_url($feature->url);?>"><?php the_title(); ?></a>
							</h3>
						<?php endif;?>
						<?php if($show_excerpt) :?>
							<div class="feature_excerpt text-strong">
								<?php the_excerpt(); ?>
							</div>
						<?php endif;?>
						</div>
					</div>
				<?php } ?>
				</div>
			</div>	
			<script type='text/javascript'>
				jQuery(document).ready(function(){
					"use strict";
					var temp_visible = <?php echo esc_js($columns);?>;
					
					var row = 1;

					var item_width = 180;
					
					var show_nav = <?php if($show_nav): ?> true <?php else: ?> false <?php endif;?>;

					var show_icon_nav = <?php if($show_icon_nav): ?> true <?php else: ?> false <?php endif;?>;
					
					var object_selector = "#<?php echo esc_js($random_id) ?>";
						
					var autoplay = <?php if($autoplay): ?> true <?php else: ?> false <?php endif;?>;
						
					var slider_data = {
							nav : show_nav
							,dots : show_icon_nav
							,autoplay : autoplay
							,responsive: {
								0 : {
									items: 1
								}
								,400 : {
									items: 2
								}
								,800 : {
									items: 3
								}
								,1160 : {
									items: <?php echo esc_js($columns) ?>
								}
							}
					}
						
					generate_horizontal_slide(slider_data, row, object_selector);
				});
			</script>
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();
			return $output;
		}
	}
	add_shortcode('wd_feature_slider','wd_features_slider_function');
?>