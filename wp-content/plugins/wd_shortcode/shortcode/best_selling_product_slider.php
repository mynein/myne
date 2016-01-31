<?php
if(!function_exists('wd_best_selling_product_slider_function')){
		function wd_best_selling_product_slider_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'row' 				=> 1
				,'big_product'		=> ''
				,'per_page' 		=> 4
				,'cat_slug'			=> ''
				,'product_tag'		=> ''
				,'title' 			=> ''
				,'desc' 			=> ''
				,'show_type' 		=> 'grid'
				,'show_nav' 		=> 1
				,'show_icon_nav' 	=> 0
				,'autoplay' 		=> 1
				,'show_image' 		=> 1
				,'show_title' 		=> 1
				,'show_sku' 		=> 0
				,'show_price' 		=> 1
				,'show_rating' 		=> 1
				,'show_label' 		=> 1
                ,'show_categories' 	=> 1
				,'show_add_to_cart'	=> 1
				,'show_short_content' => 0
						
			),$atts));
			
			if($columns > 6){
				$columns = 6;
			}
			$extra_class_row = '';
			if($row > 1){
				$extra_class_row = "over-row";
			}
			if($row > 4){
				$columns = 4;
			}
			if($per_page < 1) { $per_page = 6; }
			if($columns < 1) { $columns = 2; }
			if($columns > 6) { $columns = 6; }
			if($row < 1) { $per_page = 2; }
			if($row > 4) { $row = 4; }
			
			$options = array(
					'show_image'			=> $show_image
					,'show_categories'		=> $show_categories
					,'show_title'			=> $show_title
					,'show_rating'			=> $show_rating
					,'show_sku'				=> $show_sku
					,'show_short_content'	=> $show_short_content
					,'show_price'			=> $show_price
					,'show_label'			=> $show_label
					,'show_add_to_cart'		=> $show_add_to_cart
					);
					
			wd_remove_function_from_product_hook( $options );
			
			if(strlen(trim($big_product)) > 0){
				$_big_prod = wd_product_by_id_function($big_product);
				if(isset($_big_prod) && $_big_prod->is_visible() ){
					$temp_add_to_cart_data = do_shortcode('[add_to_cart style="" show_price="false" id="'.$_big_prod->id.'"]');
				}
			}
			$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page' => $per_page,
				'order' => 'desc',		
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',				
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					)
				)
			);
			
			if(isset($_big_prod) && $_big_prod->is_visible() && strlen(trim($_big_prod->id)) > 0){
				$args['post__not_in'] = array($_big_prod->id);
			} 
			
			if(trim($cat_slug) != ''){
				$args['tax_query'] 			= array(
						array(
							'taxonomy' 		=> 'product_cat',
							'terms' 		=> array( esc_attr($cat_slug) ),
							'field' 		=> 'slug',
							'operator' 		=> 'IN'
						)
				);
			}
			
			if( strlen($product_tag) > 0 && strcmp('all-product-tags',$product_tag) != 0 ){
				$args = array_merge($args, array('product_tag' => $product_tag));
			}
			ob_start();

			if(isset($wd_data['wd_prod_cat_column']) && absint($wd_data['wd_prod_cat_column']) > 0 ){
				$_old_wd_prod_cat_column = $wd_data['wd_prod_cat_column'];
				$wd_data['wd_prod_cat_column'] = $columns;
			} 
			
			$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
			$products = new WP_Query( $args );

			$woocommerce_loop['columns'] = $columns;
			
			$extra_class ='';
			
			if ( $products->have_posts() ) : ?>
				<?php $_random_id = 'recent_product_by_category_slider_wrapper_'.rand(); ?>
				<div class="recent-product-sc shortcode-slider shortcode-product <?php echo $show_type ?> <?php echo $extra_class_row ?> <?php echo (strlen(trim($big_product)) > 0)?'big_product':'' ?>" id="<?php echo $_random_id;?>">
					<?php if(strlen(trim($title)) >0 || strlen(trim($desc)) >0) : ?>
					<header class="shortcode-title-wrapper"> 
						<?php
							if(strlen(trim($title)) >0)
								echo "<h3 class='heading-title slider-title'>".esc_html($title)."</h3>";
						?>
					</header>
					<?php 
					if(strlen(trim($desc)) >0)	
							echo "<p class='slider-desc-wrapper'>".esc_html($desc)."</p>";
					?>
					<?php endif;?>
					<?php
						if(isset($_big_prod) && $_big_prod->is_visible()){
						$_product = wc_get_product( $_big_prod->id );
						$post = $_product->post;
						$extra_class ='col-sm-12';
						$product = wc_setup_product_data( $post );
						
						$image_title 		= esc_attr( $_product->get_title() );
						$product_link 		= esc_url( $_product->get_permalink());
						$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),array( 'alt' => $image_title, 'title' => $image_title ) );								
						echo '<div class="wd-big-product product '.$extra_class.'">';
						echo sprintf( '<div class="wd_image product-thumbnail-wrapper"><a title="%s" href="%s">%s</a></div>',$image_title,$product_link,$image );
						echo '<div class="wd_meta product-meta-wrapper"><p class="price">'.$_product->get_price_html().'</p>';
						woocommerce_template_loop_add_to_cart();
						//echo $temp_add_to_cart_data; 	
						echo '</div></div>';
						wc_setup_product_data( $post );
					}
					?>	
					<div class="<?php echo $show_type; ?> product-slider-wrapper ">	
						<div class="product-slider-inner loading">
							
							<?php $current_row = 0; ?>
							
							<?php woocommerce_product_loop_start(); ?>
								
								<?php $woocommerce_loop['columns'] = 1; ?>
								
								<?php while ( $products->have_posts() ) : $products->the_post(); ?>
									
									<?php
										if($row > 1 && ($current_row % $row == 0)){
											echo '<div class="products_group">';
										}
									?>
									
									<?php woocommerce_get_template_part( 'content', 'product' ); ?>
									
									<?php
										if($row > 1 && ($current_row % $row + 1== $row)){
											echo '</div>';
										}
										
										$current_row++;
									?>
									
								<?php endwhile; // end of the loop. ?>
							<?php woocommerce_product_loop_end(); ?>
							
						</div>
					</div>	
					<div class="clear"></div>
				</div>
				<script type='text/javascript'>
				//<![CDATA[
					jQuery(document).ready(function() {
						"use strict";
						var temp_visible = <?php echo esc_js($columns); ?>;
						
						var row = <?php echo esc_js($row); ?>;

						var item_width = 180;
						
						var show_nav = <?php if($show_nav): ?> true <?php else: ?> false <?php endif;?>;

						var show_icon_nav = <?php if($show_icon_nav): ?> true <?php else: ?> false <?php endif;?>;
						
						var object_selector = "#<?php echo $_random_id?>  .products";
						
						var autoplay = <?php if($autoplay): ?> true <?php else: ?> false <?php endif;?>;
						
						var slider_data = {
								nav : show_nav
								,dots : show_icon_nav
								,autoplay : autoplay
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
									900 : {
										items: 4
									},
									1160 : {
										items: <?php echo esc_js($columns); ?>
									}
								}
						}
							
						generate_horizontal_slide(slider_data, row, object_selector);
					});
				//]]>	
				</script>
				
			<?php endif;
			wp_reset_postdata();
			
			wd_restore_function_to_product_hook();
			
			
			$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns;
			if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
				$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
			}
			return '<div class="woocommerce">' . ob_get_clean() . '</div>';	
			
		}
	}		
	add_shortcode('best_selling_product_slider','wd_best_selling_product_slider_function');	
?>