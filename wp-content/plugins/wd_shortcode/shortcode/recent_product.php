<?php
if(!function_exists('wd_recent_product_by_categories_function')){
	function wd_recent_product_by_categories_function($atts,$content){
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
			return;
		}
		global $woocommerce_loop, $woocommerce,$wd_data;
		extract(shortcode_atts(array(
			'columns' 				=> 4
			,'per_page' 			=> 4
			,'cat_slug'				=> ''
			,'product_tag'			=> ''
			,'title' 				=> ''
			,'desc' 				=> ''
			,'show_type' 			=> 'grid'
			,'show_image' 			=> 1
			,'show_title' 			=> 1
			,'show_sku' 			=> 0
			,'show_price' 			=> 1
			,'show_rating' 			=> 1
			,'show_label' 			=> 1
			,'show_categories' 		=> 1
			,'show_add_to_cart'		=> 1
			,'show_short_content' 	=> 0
			,'show_load_more'		=> 1		
			,'bt_load_more_text'	=> 'Load more'		
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
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'orderby' => 'date',
			'order' => 'desc',				
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
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
		
		if ( $products->have_posts() ) : 
		$rand_id 		= 'recent-product-sc-'.rand(0, 1000);
		$post_count 	= $products->post_count;
		$found_posts 	= $products->found_posts;
		?>
			<div class="recent-product-sc shortcode-product <?php echo $show_type ?>" id="<?php echo $rand_id; ?>">
				<?php if(strlen(trim($title)) >0 || strlen(trim($desc)) >0) : ?>
				<header class="shortcode-title-wrapper"> 
					<?php
						if(strlen(trim($title)) >0)
							echo "<h3 class='heading-title slider-title'>".esc_html($title)."</h3>";
					?>
				</header>
				<?php 
				if(strlen(trim($desc)) >0)	
						echo "<p class='desc-wrapper'>".esc_html($desc)."</p>";
				?>
				<?php endif;?>
				<div class="<?php echo $show_type; ?> product-wrapper ">	
					<div class="product-inner">
						
						<?php woocommerce_product_loop_start(); ?>
							
							<?php $woocommerce_loop['columns'] = $columns; ?>
							
							<?php while ( $products->have_posts() ) : $products->the_post(); ?>
																								
								<?php wc_get_template_part( 'content', 'product' ); ?>
								
								
							<?php endwhile; // end of the loop. ?>
						<?php woocommerce_product_loop_end(); ?>
						
					</div>
				</div>
				<?php if( $show_load_more && $post_count < $found_posts ): ?>
				<div class="load-more-wrapper">
					<span class="paged" style="display: none">2</span>
					<a href="#" class="load-more-button button big"><?php echo esc_html($bt_load_more_text); ?></a>
				</div>
				<?php endif; ?>
				
				<div class="clear"></div>
			</div>
			
			<script type="text/javascript">
				jQuery(document).ready(function($){
					"use strict";
					var ajax_uri = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>';
					var _rand_id = '<?php echo $rand_id; ?>';
					$('#' + _rand_id + ' .load-more-button').bind('click', function(e){
						e.preventDefault();
						
						var _this = $(this);
						_this.addClass('loading');
						
						var paged = parseInt( $('#' + _rand_id + ' .load-more-wrapper .paged').text() );
						var data = {
							'action' : 'wd_load_recent_product_content'
							,'atts' : <?php echo json_encode($atts); ?>
							,'paged' : paged
						};
						
						$.ajax({
							type : 'POST'
							,url : ajax_uri
							,data : data
							,error : function(xhr, status){
								
							}
							,success : function(response){
								$('#' + _rand_id + ' .product-inner .products').append(response);
								
								_this.removeClass('loading');
								
								if( $('#' + _rand_id + ' .wd_flag_end_page').length > 0 ){ /* No product to load */
									$('#' + _rand_id + ' .load-more-wrapper').remove();
									$('#' + _rand_id + ' .wd_flag_end_page').remove();
								}
								else{ /* Update paged */
									paged += 1;
									$('#' + _rand_id + ' .load-more-wrapper .paged').text(paged);
								}
								
								/* Update first last classes */
								var columns = '<?php echo esc_js($columns); ?>';
								columns = parseInt(columns);
								$('#' + _rand_id + ' .product-inner .products .product').removeClass('first last');
								$('#' + _rand_id + ' .product-inner .products .product').each(function(index, ele){
									if( index % columns == 0 ){
										$(ele).addClass('first');
									}
									if( index % columns == columns - 1 ){
										$(ele).addClass('last');
									}
								});
								
								/* Register quickshop */
								if( typeof wd_qs_prettyPhoto == 'function' ){
									wd_qs_prettyPhoto();
								}
							}
						});
						
					});
				});
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
add_shortcode('recent_product_by_categories','wd_recent_product_by_categories_function');	

/* Recent product load more */
add_action( 'wp_ajax_wd_load_recent_product_content', 'wd_recent_product_by_categories_load_more_function' );
add_action( 'wp_ajax_nopriv_wd_load_recent_product_content', 'wd_recent_product_by_categories_load_more_function' );
function wd_recent_product_by_categories_load_more_function(){
	$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
	if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
		die();
	}
		
	if( !isset($_POST['atts']) ){
		die();
	}
	else{
		$atts = $_POST['atts'];
	}
	
	$paged = isset($_POST['paged'])?$_POST['paged']:1;
	
	extract(shortcode_atts(array(
			'columns' 				=> 4
			,'per_page' 			=> 4
			,'cat_slug'				=> ''
			,'product_tag'			=> ''
			,'title' 				=> ''
			,'desc' 				=> ''
			,'show_type' 			=> 'grid'
			,'show_image' 			=> 1
			,'show_title' 			=> 1
			,'show_sku' 			=> 1
			,'show_price' 			=> 1
			,'show_rating' 			=> 1
			,'show_label' 			=> 1
			,'show_categories' 		=> 1
			,'show_add_to_cart'		=> 1
			,'show_short_content' 	=> 1
			,'show_load_more'		=> 0		
			,'bt_load_more_text'	=> 'Load more'		
		),$atts));
		
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
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'ignore_sticky_posts'	=> 1,
		'posts_per_page' => $per_page,
		'paged'			=> $paged,
		'orderby' => 'date',
		'order' => 'desc',				
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
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
	
	global $woocommerce_loop;
	$_old_woocommerce_loop_columns = $woocommerce_loop['columns'];
	$products = new WP_Query( $args );

	$woocommerce_loop['columns'] = $columns;
	
	$products = new WP_Query( $args );
	if( $products->have_posts() ){
		while ( $products->have_posts() ) : $products->the_post();							
			wc_get_template_part( 'content', 'product' );
		endwhile;
	}
	
	if( $products->max_num_pages == $paged || !$products->have_posts() ){
		echo '<span class="wd_flag_end_page" style="display: none"></span>';
	}
	
	wp_reset_postdata();
	
	wd_restore_function_to_product_hook();
	
	$woocommerce_loop['columns'] = $_old_woocommerce_loop_columns;
	if(isset($_old_wd_prod_cat_column) && absint($_old_wd_prod_cat_column > 0 )){
		$wd_data['wd_prod_cat_column'] = $_old_wd_prod_cat_column  ;
	}
	
	$html = ob_get_clean();
	die($html);
}
?>