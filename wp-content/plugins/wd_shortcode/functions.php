<?php
if(!function_exists('wd_product_by_id_function')){
	function wd_product_by_id_function($id){
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
			return;
		}
		
		$big_args = array(
			'post_type' => 'product',
			'posts_per_page' => 1,
			'no_found_rows' => 1,
			'p' => $id,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				)
			)
		);
		
		$big_product = new WP_Query( $big_args );
		if ( $big_product->have_posts() ) : 
			global $post;
			$big_product->the_post();
			$product = wc_get_product( $post->ID );
			wp_reset_postdata();
			return $product;
		endif;
		return NULL;		
	}
}
if( !function_exists('wd_remove_function_from_product_hook') ){
	function wd_remove_function_from_product_hook( $options = array() ){
		if( isset($options['show_image']) && !$options['show_image'] ){
			remove_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
		}
		
		if( isset($options['show_categories']) && !$options['show_categories'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
		}
		
		if( isset($options['show_title']) && !$options['show_title'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 4 );
		}
		
		if( isset($options['show_rating']) && !$options['show_rating'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 3 );
		}
		
		if( isset($options['show_sku']) && !$options['show_sku'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 5 );
		}
		
		if( isset($options['show_short_content']) && !$options['show_short_content'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'add_short_content',6 );
		}
		
		if( isset($options['show_price']) && !$options['show_price'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
		}
		
		if( isset($options['show_label']) && !$options['show_label'] ){
			remove_action( 'woocommerce_before_shop_loop_item', 'wd_add_label_to_product', 5 );
		}
		
		if( isset($options['show_add_to_cart']) && !$options['show_add_to_cart'] ){
			remove_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 13 );
			remove_action( 'woocommerce_before_shop_loop_item', 'wd_list_template_loop_add_to_cart', 5 );
		}
	}
}

if( !function_exists('wd_restore_function_to_product_hook') ){
	function wd_restore_function_to_product_hook(){
		add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 4 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 3 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 5 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'add_short_content',6 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
		
		add_action( 'woocommerce_before_shop_loop_item', 'wd_add_label_to_product', 5 );
		
		add_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 13 );
		add_action( 'woocommerce_before_shop_loop_item', 'wd_list_template_loop_add_to_cart', 5 );
	}
}

if( !function_exists('wd_order_by_rating_post_clauses') ){
	function wd_order_by_rating_post_clauses( $args ) {

		global $wpdb;

		$args['where'] .= " AND $wpdb->commentmeta.meta_key = 'rating' ";

		$args['join'] .= "
			LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}
}
?>