<?php 
	if(!function_exists('wd_features_function')){
		function wd_features_function($atts,$content){
			extract(shortcode_atts(array(
				'slug'					=> ''
				,'id'					=> 0
				,'icon_image'			=> ''
				,'style'				=> 'vertical'
				,'icon_style'			=> 'icon-no-border' /* square border, circle border */
				,'show_icon'			=> 1
				,'show_title'			=> 1
				,'show_excerpt'			=> 1
				,'icon_color'			=> ''
				,'border_color'			=> ''
				,'icon_hover_color'		=> ''
				,'border_hover_color'	=> ''
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
					$_feature = woothemes_get_features( array('id' => $_feature->ID ));
				}else{
					return;
				}
			}else{
				return;
				//invalid input params.
			}
			
			//nothing found
			if( !is_array($_feature) && count($_feature) <= 0 ){
				return;
			}else{
				global $post;
				$_feature = $_feature[0];
				$post = $_feature;
				setup_postdata( $post ); 
			}
			
			static $wd_feature_number = 1;
			$unique_class = 'wd_shortcode_feature_'.$wd_feature_number;
			$wd_feature_number++;
			
			$custom_style = '';
			if( $icon_color != '' ){
				$custom_style .= '.'.$unique_class.' .feature_icon a span{color:'.$icon_color.'}';
			}
			
			if( $icon_hover_color != '' ){
				$custom_style .= '.'.$unique_class.' .feature_icon a:hover span{color:'.$icon_hover_color.'}';
			}
			
			if( $border_color != '' && $icon_style != 'icon-no-border' ){
				$custom_style .= '.'.$unique_class.' .feature_icon a{border-color:'.$border_color.'}';
			}
			
			if( $border_hover_color != '' && $icon_style != 'icon-no-border' ){
				$custom_style .= '.'.$unique_class.' .feature_icon a:hover{border-color:'.$border_hover_color.'}';
			}
			
			//handle features
			
			ob_start();
			
			if( $custom_style != '' ){
				$custom_style = '<style type="text/css">'.$custom_style.'</style>';
				echo $custom_style;
			}
			?>
			<div class="wd_shortcode_feature <?php echo esc_attr($unique_class); ?> <?php echo esc_attr($style); ?> <?php echo esc_attr($icon_style) ?>">
				<div id="post-<?php the_ID(); ?>" <?php post_class('shortcode')?>>
					
					<div class="feature_content_wrapper">	
					<?php if($show_icon) :?>
						<div class="feature_icon">
							<a href="<?php echo esc_url($_feature->url);?>">
								<span class="<?php echo $icon_image ?>" ></span>
							</a>
						</div>
					<?php endif;?>
					
						<div class="feature_title_excerpt">
							<?php if($show_title):?>
								<h3 class="feature_title heading_title bold-upper-big ">
									<a href="<?php echo esc_url($_feature->url);?>"><?php the_title(); ?></a>
								</h3>
							<?php endif;?>
							
							<?php if($show_excerpt) :?>
								<div class="feature_excerpt text-strong">
									<?php the_excerpt(); ?>
								</div>
							<?php endif;?>
						</div>
					</div>
				
				</div>
			</div>
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();
			return $output;
		}
	}
	add_shortcode('wd_feature','wd_features_function');
?>