<?php 
/*
	Generate theme control.
	Input : 
		- int $num_pages_per_phrase : the number of page per group.
	No output.
*/


add_action( 'template_redirect', 'my_page_template_redirect' );
function my_page_template_redirect(){
	global $wp_query,$post,$page_datas,$wd_data;
	$wd_data['wd_layout_style'] = (isset($wd_data['wd_layout_styles']) ? $wd_data['wd_layout_styles'] : 'wide' ) ;
	if($wp_query->is_page()){
		global $page_datas,$wd_custom_style_config,$wd_data;
		$page_datas = unserialize(get_post_meta($post->ID,THEME_SLUG.'page_configuration',true));
		$page_datas = wd_array_atts(array(	
											"page_layout" 					=> '0'
											,"header_layout"				=> ''
											,"page_column" 					=> '0-1-0'
											,"left_sidebar" 				=> 'primary-widget-area'
											,"right_sidebar" 				=> 'primary-widget-area'
											,"page_slider" 					=> 'none'
											,"page_revolution" 				=> ''
											,"page_layerslider"				=> ''	
											,"product_tag"					=> ''
											,"hide_breadcrumb" 				=> 0		
											,"hide_title" 					=> 0										
											,"hide_top_content_widget_area" => 1										
											,"page_logo" 					=> ''										
										),$page_datas);		
		$wd_data['wd_layout_style'] = strcmp($page_datas['page_layout'],'0') == 0 ? (isset($wd_data['wd_layout_styles']) ? $wd_data['wd_layout_styles'] : 'wide' ) : $page_datas['page_layout'] ;
		
		if( !empty($page_datas['header_layout']) ){
			$wd_data['wd_header_layout'] = $page_datas['header_layout'];
		}
		
		if( !empty($page_datas['page_logo']) ){
			$wd_data['wd_logo'] = $page_datas['page_logo'];
		}
		
		/* Easycart - demo layout */
		if( class_exists('ec_cart') ){
			$storepageid = get_option('ec_option_storepage');
			if( function_exists( 'icl_object_id' ) ){
				$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
			}
			if( is_page($storepageid) ){
				if( isset($_GET['ec_layout']) && $_GET['ec_layout'] == 'full' ){
					$page_datas['page_column'] = '0-1-0';
				}
			}
		}
	}
	
	if(is_single()){
		global $wd_data,$post;
		/******************* Start Load Config On Single Post ******************/
		$_post_config = get_post_meta($post->ID,THEME_SLUG.'custom_post_config',true);
		
		if( strlen($_post_config) > 0 ){
			$_post_config = unserialize($_post_config);
			
			if( is_array($_post_config) && count($_post_config) > 0 ){
				$wd_data['wd_post_layout'] = ( isset($_post_config['layout']) && strlen($_post_config['layout']) > 0 && strcmp($_post_config["layout"],'0') != 0 ) ? $_post_config['layout'] : $wd_data['wd_post_layout'];
				$wd_data['wd_post_left_sidebar'] = ( isset($_post_config['left_sidebar']) && strlen($_post_config['left_sidebar']) > 0 && strcmp($_post_config["left_sidebar"],'0') != 0 ) ? $_post_config['left_sidebar'] : $wd_data['wd_post_left_sidebar'];
				$wd_data['wd_post_right_sidebar'] = ( isset($_post_config['right_sidebar']) && strlen($_post_config['right_sidebar']) > 0 && strcmp($_post_config["right_sidebar"],'0') != 0 ) ? $_post_config['right_sidebar'] : $wd_data['wd_post_right_sidebar'];
				if( ( strcmp( trim($_post_config['left_sidebar']),"0" ) != 0 || strcmp( trim($_post_config['right_sidebar']),"0" ) != 0 ) && strcmp($wd_data['wd_prod_layout'],'0-1-0') != 0 ){
				}
			}
		}	
	}
	
	if( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( "product" ) ){
		global $wp_query,$category_prod_datas;
		$term = $wp_query->queried_object;
		
		if( is_object($term) ){
			$_term_config = get_metadata( 'woocommerce_term', $term->term_id, "cat_config", true );
			
			if( strlen($_term_config) > 0 ){
				$_term_config = unserialize($_term_config);	
				
				if( is_array($_term_config) && count($_term_config) > 0 ){
					$wd_data['wd_prod_cat_column'] = ( isset($_term_config['cat_columns']) && strlen($_term_config['cat_columns']) > 0 && (int)$_term_config['cat_columns'] != 0 ) ? $_term_config['cat_columns'] : $wd_data['wd_prod_cat_column'];
					$wd_data['wd_prod_cat_layout'] = ( isset($_term_config['cat_layout']) && strlen($_term_config['cat_layout']) > 0 && strcmp($_term_config["cat_layout"],'0') != 0 ) ? $_term_config['cat_layout'] : $wd_data['wd_prod_cat_layout'];
					$wd_data['wd_prod_cat_left_sidebar'] = ( isset($_term_config['cat_left_sidebar']) && strlen($_term_config['cat_left_sidebar']) > 0 && strcmp($_term_config["cat_left_sidebar"],'0') != 0 ) ? $_term_config['cat_left_sidebar'] : $wd_data['wd_prod_cat_left_sidebar'];
					$wd_data['wd_prod_cat_right_sidebar'] = ( isset($_term_config['cat_right_sidebar']) && strlen($_term_config['cat_right_sidebar']) > 0 && strcmp($_term_config["cat_right_sidebar"],'0') != 0 ) ? $_term_config['cat_right_sidebar'] : $wd_data['wd_prod_cat_right_sidebar'];
					$wd_data['wd_prod_cat_custom_content'] = ( isset($_term_config['cat_custom_content']) && strlen($_term_config['cat_custom_content']) > 0 ) ? $_term_config['cat_custom_content'] : (isset($wd_data['wd_prod_cat_custom_content'])?$wd_data['wd_prod_cat_custom_content']:'');
				}
				
			}
		}
		
		if( isset($wd_data['wd_prod_cat_disc_grid']) && isset($wd_data['wd_prod_cat_disc_list']) ){
			add_action( 'wp_enqueue_scripts', 'wd_inline_style_list_grid_disc', 1000 );
		}
		
		add_action('woocommerce_before_shop_loop','wd_remove_shop_archive_control',1);
		add_action('woocommerce_after_shop_loop','wd_add_shop_archive_control',1);
			
	}
	if ( is_singular('product') ) {
		global $wd_data,$post;
		/******************* Start Load Config On Single Post ******************/
		$_prod_config = get_post_meta($post->ID,THEME_SLUG.'custom_product_config',true);
		
		if( strlen($_prod_config) > 0 ){
			$_prod_config = unserialize($_prod_config);
			
			if( is_array($_prod_config) && count($_prod_config) > 0 ){
				
				$wd_data['wd_prod_layout'] = ( isset($_prod_config['layout']) && strlen($_prod_config['layout']) > 0 && strcmp($_prod_config["layout"],'0') != 0 ) ? $_prod_config['layout'] : $wd_data['wd_prod_layout'];
				$wd_data['wd_prod_left_sidebar'] = ( isset($_prod_config['left_sidebar']) && strlen($_prod_config['left_sidebar']) > 0 && strcmp($_prod_config["left_sidebar"],'0') != 0 ) ? $_prod_config['left_sidebar'] : $wd_data['wd_prod_left_sidebar'];
				$wd_data['wd_prod_right_sidebar'] = ( isset($_prod_config['right_sidebar']) && strlen($_prod_config['right_sidebar']) > 0 && strcmp($_prod_config["right_sidebar"],'0') != 0 ) ? $_prod_config['right_sidebar'] : $wd_data['wd_prod_right_sidebar'];
			}
		}			
		
		/******************* End Config On Single Post ******************/
		
		if( !$wd_data['wd_prod_image']  )	
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );	

		if( !$wd_data['wd_prod_label'] )	
			remove_action( 'wd_single_before_product_image', 'wd_add_label_to_product', 10 );

		if( !$wd_data['wd_prod_title'] )	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
		
		if( !$wd_data['wd_prod_sku'] )
			remove_action( 'woocommerce_single_product_summary', 'wd_template_single_sku', 6 );
		
		if( !$wd_data['wd_prod_review']  )	
			remove_action( 'woocommerce_single_product_summary', 'wd_template_single_review', 15 );

		if( !$wd_data['wd_prod_availability'] )	
			remove_action( 'woocommerce_single_product_summary', 'wd_template_single_availability', 7 );
		
		if( !$wd_data['wd_prod_cart']){
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		}

		if( !$wd_data['wd_prod_price'] ){	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price',25 );
			remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation', 10);
		}
		if( !$wd_data['wd_prod_shortdesc'] )	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
		if( !$wd_data['wd_prod_meta'] )	{
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
		}
		if( !$wd_data['wd_prod_related']){	
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 15 );
			add_filter( "single_product_wrapper_class", "update_single_product_wrapper_class", 10);
		}else{
			global $post;
			$_product = wc_get_product($post);
			if ( sizeof( $_product->get_related() ) == 0 )
				add_filter( "single_product_wrapper_class", "update_single_product_wrapper_class", 10);
		}

		if( !$wd_data['wd_prod_share'] )	
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 20 );
			
		if( !$wd_data['wd_prod_detail_banner'] ){
			remove_action( 'woocommerce_after_single_product_summary', 'wd_template_single_banner', 5 );
		}
			
		if( !$wd_data['wd_prod_ship_return'] )	
			remove_action( 'wd_single_after_product_image', 'wd_template_shipping_return', 10 );

		if( !$wd_data['wd_prod_tabs'] )	
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			
		if( !$wd_data['wd_prod_customtab'] ){
			remove_filter( 'woocommerce_product_tabs', 'wd_addon_custom_tabs',13 );
		}		

		if( isset($wd_data['wd_prod_upsell']) && !$wd_data['wd_prod_upsell']  )	
			remove_action( 'woocommerce_after_single_product_summary', 'wd_upsell_display', 120 );
		
		
	
	}
	if($wd_data['wd_catelog_mod'] == 1){	
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
		remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
		remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
		remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
		remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		
		remove_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 8 );
		//add to cart ajax
		remove_action( 'woocommerce_after_shop_loop_item_title', 'wd_list_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );; 
		remove_action( 'wd_quickshop_single_product_summary', 'woocommerce_template_single_add_to_cart', 11 );  	
	}
}



/**************************important hook**************************/

//add_filter( 'option_posts_per_page' , 'wd_change_posts_per_page'); //filter and change posts_per_page
add_action ('pre_get_posts','prepare_post_query',9); //hook into pre_get_posts to reset some querys

/*merge query post type function*/

function merge_post_type($query,$new_type = array()){
	$defaut_post_type = ( post_type_exists( 'portfolio' ) ? array('portfolio','post') : array('post') );
	$new_type = (is_array($new_type) && count($new_type) > 0) ? $new_type : $defaut_post_type;
	$default_post_type = $query->get('post_type');
	if(is_array($default_post_type)){
		$new_type = array_merge($default_post_type, $new_type);
	}else{
		$new_type = array_merge(array($default_post_type), $new_type);
	}
	return ( $new_type = array_unique($new_type) );
}
/*end merge query post type function*/

function remove_page_from_search_query($where_query){
	global $wpdb;
	$where_query .= " AND ".$wpdb->prefix."posts.post_type NOT IN ('page') ";
	return $where_query;
}

function add_a2z_query($where_query){
	global $wpdb;
	$_start_char = get_query_var('start_char');
	$_up_char = strtoupper($_start_char);
	$_down_char = strtolower($_start_char);
	$where_query .= " AND left(".$wpdb->prefix."posts.post_title,1) IN ('{$_up_char}','{$_down_char}') ";
	return $where_query;
}


function prepare_post_query($query){
	
	global $page_datas,$post;
	$paged = (int)get_query_var('paged');
		
	
	if($paged>0){
		set_query_var('page',$paged);
	}
	if($query->is_tag()){
		$query->set('post_type',merge_post_type($query) );
	}
	if($query->is_search() && !is_admin()){	
		add_action( "posts_where", "remove_page_from_search_query", 10 );
	}	
	if($query->is_date()){
		$query->set('post_type',merge_post_type($query) );
	}

	if($query->is_author()){
		$query->set('post_type',merge_post_type($query) );
	}
	if($query->is_archive){
		if(isset($_GET['term']) && $_GET['term']=="" && isset($_GET['s']) && $_GET['s']=="" && isset($_GET['taxonomy']))
			$query->query_vars['taxonomy'] = "";
	}
	return $query;
	
}



function wd_change_posts_per_page($option_posts_per_page){
	global $wp_query;
	if($wp_query->is_search()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_search') > 0 ? (int)get_option(THEME_SLUG.'num_post_search') : $option_posts_per_page );
        return $posts_per_page;
	}
	//if($wp_query->is_front_page() || $wp_query->is_home()){
	if( $wp_query->is_home() ){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_home') > 0 ? (int)get_option(THEME_SLUG.'num_post_home') : $option_posts_per_page );
        return $posts_per_page;
	}
	//if( is_page_template('page-templates/blog-template.php') ){
	if( $wp_query->is_page() ){
		$blog_template_array = array('blog-template.php','blogtemplate.php','portfolio.php');
		//$template_name = get_post_meta( $wp_query->queried_object_id, '_wp_page_template', true );
		$template_name = get_post_meta( $wp_query->query_vars['page_id'], '_wp_page_template', true );
		if(in_array($template_name,$blog_template_array)){
			$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_blog_page') > 0 ? (int)get_option(THEME_SLUG.'num_post_blog_page') : $option_posts_per_page );
			return $posts_per_page;
		}
	}

	if($wp_query->is_single()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_related') > 0 ? (int)get_option(THEME_SLUG.'num_post_related') : $option_posts_per_page );
        return $posts_per_page;
	}
	if($wp_query->is_category()){
		
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_cat') > 0 ? (int)get_option(THEME_SLUG.'num_post_cat') : $option_posts_per_page );
        return $posts_per_page;
	}
	if($wp_query->is_tag()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_tag') > 0 ? (int)get_option(THEME_SLUG.'num_post_tag') : $option_posts_per_page );
        return $posts_per_page;
	}
    if ($wp_query->is_category() ) {
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_cat') > 0 ? (int)get_option(THEME_SLUG.'num_post_cat') : $option_posts_per_page );
        return $posts_per_page;
    }
	if($wp_query->is_archive()){
		$posts_per_page = ( (int)get_option(THEME_SLUG.'num_post_archive') > 0 ? (int)get_option(THEME_SLUG.'num_post_archive') : $option_posts_per_page );
        return $posts_per_page;
	}
    return $option_posts_per_page;
}

function wd_inline_style_list_grid_disc(){
	$custom_css = "";
	$custom_css .= ".products.list .short-description.list{display: block !important;}";
	$custom_css .= ".products.grid .short-description.grid{display: block !important;}";
    wp_add_inline_style( 'responsive', $custom_css );
}

function wd_remove_shop_archive_control(){
	global $wd_data;
	
	if( !$wd_data['wd_prod_cat_label'] ){
		remove_action( 'woocommerce_before_shop_loop_item', 'wd_add_label_to_product', 5 );
	}
	
	if( !$wd_data['wd_prod_cat_rating'] ){
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 3);
	}
	
	if( !$wd_data['wd_prod_cat_categories'] ){
		remove_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2);
	}
	
	if( !$wd_data['wd_prod_cat_title'] ){
		remove_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 4);
	}
	
	if( !$wd_data['wd_prod_cat_sku'] ){
		remove_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 5);
	}
	
	if( !$wd_data['wd_prod_cat_price'] ){
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
	}
	
	if( !$wd_data['wd_prod_cat_add_to_cart'] ){
		remove_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 13 );
		remove_action( 'woocommerce_before_shop_loop_item', 'wd_list_template_loop_add_to_cart', 5 );
	}
}

function wd_add_shop_archive_control(){
	add_action( 'woocommerce_before_shop_loop_item', 'wd_add_label_to_product', 5 );
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 3);
	add_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2);
	add_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 4);
	add_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 5);
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
	add_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 13 );
	add_action( 'woocommerce_before_shop_loop_item', 'wd_list_template_loop_add_to_cart', 5 );
}

/**************************end the hook**************************/
?>