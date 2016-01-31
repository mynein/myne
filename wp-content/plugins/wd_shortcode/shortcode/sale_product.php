<?php
if(!function_exists('wd_sale_product_function')){
		function wd_sale_product_function($atts,$content){
			$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
			if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
				return;
			}
			global $woocommerce_loop, $woocommerce,$wd_data;
			extract(shortcode_atts(array(
				'columns' 			=> 4
				,'per_page' 		=> 4
				,'cat_slug'			=> ''
				,'product_tag'		=> ''
				,'title' 			=> ''
				,'desc' 			=> ''
				,'show_type' 		=> 'grid'
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
			if($per_page < 1) { $per_page = 6; }
			if($columns < 1) { $columns = 2; }
			if($columns > 6) { $columns = 6; }
			
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
			
			$args = array(
				'post_type'			=> 'product',
				'post_status' 		=> 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page'	=> $per_page,
				'order' 			=> 'desc',			
				'meta_query' => array(
					array(
						'key' => '_visibility',
						'value' => array('catalog', 'visible'),
						'compare' => 'IN'
					),
					array(
						'key' => '_sale_price',
						'value' =>  0,
						'compare'   => '>',
						'type'      => 'NUMERIC'
					)
				)
			);	
			
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
				<div class="sale-product-sc shortcode-product <?php echo $show_type ?>">
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
						
					<div class="<?php echo $show_type; ?> product-wrapper ">	
						<div class="product-inner">
							
							<?php $current_row = 0; ?>
							
							<?php woocommerce_product_loop_start(); ?>
								
								<?php $woocommerce_loop['columns'] = $columns; ?>
								
								<?php while ( $products->have_posts() ) : $products->the_post(); ?>
																									
									<?php wc_get_template_part( 'content', 'product' ); ?>
									
									
								<?php endwhile; // end of the loop. ?>
							<?php woocommerce_product_loop_end(); ?>
							
						</div>
					</div>	
					<div class="clear"></div>
				</div>
				
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
	add_shortcode('sale_product','wd_sale_product_function');	
?>