<?php
//remove default hook
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

//add filter hook
add_filter('woocommerce_widget_cart_product_title','add_sku_after_title',100000000000000000000000000000,2);
//add tab to prod page
add_filter( 'woocommerce_product_tabs', 'wd_addon_product_tabs',13 );
//add new tab to prod page
add_filter( 'woocommerce_product_tabs', 'wd_addon_custom_tabs',12 );
//set default columns
add_filter('loop_shop_columns', 'loop_columns');
//set number of products per page
add_filter('loop_shop_per_page', 'wd_change_posts_per_page_category' );


/**********************Breadcumns Woocommerce Page***********************/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
add_action( 'wd_before_main_content', 'woocommerce_breadcrumb', 10, 0 );
add_action('wd_before_main_content', 'wd_product_category_banner', 5);
/**********************End Breadcumns Woocommerce Page***********************/

/***************** Begin Content Product *******************/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
//add sale,featured and off save label
add_action( 'woocommerce_before_shop_loop_item', 'wd_add_label_to_product', 5 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'wd_template_loop_product_thumbnail', 10 );	
add_action( 'woocommerce_before_shop_loop_item', 'wd_list_template_loop_add_to_cart', 5 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'get_product_categories', 2);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 3);
add_action( 'woocommerce_after_shop_loop_item', 'add_product_title', 4);
add_action( 'woocommerce_after_shop_loop_item', 'add_sku_to_product_list', 5);
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
add_action( 'woocommerce_after_shop_loop_item', 'add_short_content', 6);
add_action( 'woocommerce_after_shop_loop_item', 'wd_list_template_loop_add_to_cart', 13 );

/************************ End Content Product *********************/

add_action( 'wd_ads_sidebar', 'wd_ads_sidebar', 10, 1 );

/***************** Begin Content Single Product *******************/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );	
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

add_action( 'woocommerce_single_product_summary', 'wd_template_single_sku', 6 );
add_action( 'woocommerce_single_product_summary', 'wd_template_single_availability', 7 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'wd_template_single_review', 15 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
add_action( 'woocommerce_single_product_summary', 'wd_before_single_wishlist_compare', 30 );
add_action( 'woocommerce_single_product_summary', 'wd_after_single_wishlist_compare', 36 ); /* After compare */
add_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
add_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
add_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
add_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
add_action( 'wd_single_before_product_image', 'wd_add_label_to_product', 10 );

add_action( 'woocommerce_after_single_product_summary', 'wd_template_single_banner', 5 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 15 );
add_action( 'woocommerce_after_single_product_summary', 'wd_upsell_display', 120 );
/***************** End Content Single Product *********************/

/***************** Begin Checkout Page *******************/
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'wd_after_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_after_checkout_form', 'wd_checkout_add_on_js', 10 );
add_action( 'woocommerce_before_checkout_registration_form', 'wd_checkout_fields_form', 10 );
/***************** End Checkout Page *********************/

/***************** Begin Product-image *******************/
add_action( 'wd_single_after_product_image', 'wd_template_shipping_return', 10 );
/***************** End Product-image *********************/

//custom hook
function wd_list_template_loop_add_to_cart(){
	global $wd_data;
	if( isset($wd_data['wd_catelog_mod']) && (int)$wd_data['wd_catelog_mod'] == 1 ){
		return;
	}
	echo "<div class='list_add_to_cart'>";
	woocommerce_template_loop_add_to_cart();
	echo "</div>";
}



function add_short_content(){
	global $product, $wd_data, $post;
	$limit_grid = trim($wd_data['wd_prod_cat_word_disc_grid']);
	$limit_list = trim($wd_data['wd_prod_cat_word_disc_list']);
	
	if( $limit_grid != -1 )
		$limit_grid = absint( $limit_grid );
	if( $limit_list != -1 )
		$limit_list = absint( $limit_list );
		
	$is_grid_list = class_exists('WD_List_Grid');
	
	
	$rs = '';
	if( !(is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( "product" )) ){
		$rs .= '<div class="short-description">';
		$rs .= the_excerpt_max_words($limit_grid, $post, false);
		$rs .= '</div>';
	}
	else{
		if( $wd_data['wd_prod_cat_disc_grid'] ){
			$rs .= '<div class="short-description grid" '.($is_grid_list?'style="display:none"':'').'>';
			$rs .= the_excerpt_max_words($limit_grid, $post, false);
			$rs .= '</div>';
		}
		if( $wd_data['wd_prod_cat_disc_list'] ){
			$rs .= '<div class="short-description list" style="display:none">';
			$rs .= the_excerpt_max_words($limit_list, $post, false);
			$rs .= '</div>';
		}
	}
	echo apply_filters('the_content', $rs);
}
function get_product_categories(){
	global $product;
	$rs = '';
	$rs .= '<div class="wd_product_categories">';
	$product_categories = wp_get_post_terms(get_the_ID($product),'product_cat');
	$count = count($product_categories);
	if ( $count > 0 ){
		foreach ( $product_categories as $term ) {
		$rs.= '<a href="'.get_term_link($term->slug,$term->taxonomy).'">'.$term->name . "</a>";

		}
	}
	$rs .= '</div>';
	echo ($rs);
}




function wd_template_loop_product_thumbnail(){
	global $product,$post;
	$_prod_galleries = $product->get_gallery_attachment_ids( );
	
	$_classes = "product-image";
	if ( !has_post_thumbnail() ){
		$_classes = $_classes . " default-thumb";
	}	
	
	echo "<div class='{$_classes}'>";
	echo woocommerce_get_product_thumbnail();
	echo '<span class="product-image-hover"></span>';
	echo '</div>';

}


function add_product_title(){
	global $post, $product,$product_datas;
	$_uri = esc_url(get_permalink($post->ID));
	echo "<h3 class=\"heading-title product-title link \">";
	echo "<a href='{$_uri}'>". esc_attr(get_the_title()) ."</a>";
	echo "</h3>";
}


function wd_add_label_to_product(){
	global $post, $product,$product_datas;
	echo '<div class="product_label">';
	if ($product->is_on_sale()){ 
		if( $product->regular_price > 0 ){
			$_off_percent = (1 - round($product->get_price() / $product->regular_price, 2))*100;
			$_off_price = round($product->regular_price - $product->get_price(), 0);
			$_price_symbol = get_woocommerce_currency_symbol();
			echo "<span class=\"onsale show_off product_label\">".__( 'Save','wpdance' )."<span class=\"off_number\">{$_price_symbol}{$_off_price}</span></span>";	
		}else{
			echo "<span class=\"onsale product_label\">".__( 'Save','wpdance' )."</span>";
		}
	}
	if ($product->is_featured()){
		echo "<span class=\"featured product_label\">".__( 'Hot','wpdance' )."</span>";
	}
	echo "</div>";
}

function add_sku_to_product_list(){
	global $product, $woocommerce_loop;
	echo "<span class=\"product_sku\">" . esc_attr($product->get_sku()) . "</span>";
}


function wd_template_loop_product_big_thumbnail(){
	global $product,$post;	
	$thumb = get_post_thumbnail_id($post->ID);
	$_prod_galleries = $product->get_gallery_attachment_ids( );
	?>
		<!--<div class="product-image-big-layout">
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_1',array('class' => 'big_layout')); 
				} 				
			?>
		</div>-->	
		<div class="product-image">			
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_1',array('class' => 'big_layout') ); 
				} 				 
			?>
			<span class="product-image-hover"></span>
		</div>	
	<?php	
}

/* Number of products per page */
function wd_change_posts_per_page_category(){
	global $wd_data;
    if( is_archive() ){
        if( isset($wd_data["wd_prod_cat_per_page"]) && (int)$wd_data["wd_prod_cat_per_page"] > 0){
            return (int)$wd_data["wd_prod_cat_per_page"];
        }
    }
}

/***** Custom Wishlist - Compare *****/
if( class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL') ){
	add_filter('yith_wcwl_add_to_wishlisth_button_html', 'wd_override_wishlist_button_html', 10, 4);
	function wd_override_wishlist_button_html( $html, $url, $product_type, $exists ){
		global $yith_wcwl, $product;

        $label_option = get_option( 'yith_wcwl_add_to_wishlist_text' );
        $localize_label = function_exists( 'icl_translate' ) ? icl_translate( 'Plugins', 'plugin_yit_wishlist_button', $label_option ) : $label_option;

        $label = apply_filters( 'yith_wcwl_button_label', $localize_label );
        $icon = get_option( 'yith_wcwl_add_to_wishlist_icon' ) != 'none' ? '<i class="' . get_option( 'yith_wcwl_add_to_wishlist_icon' ) . '"></i>' : '';

        $classes = get_option( 'yith_wcwl_use_button' ) == 'yes' ? 'class="add_to_wishlist single_add_to_wishlist button alt"' : 'class="add_to_wishlist"';

        $html  = '<div class="yith-wcwl-add-to-wishlist add-to-wishlist-'.$product->id.'">';
			$html .= '<span class="wd_tooltip">'.__('+Wishlist', 'wpdance').'</span>';
			
			$html .= '<div class="yith-wcwl-add-button'; 

			$html .= $exists ? ' hide" style="display:none;"' : ' show"';

			$html .= '><a href="' . esc_url( $yith_wcwl->get_addtowishlist_url() ) . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' >' . $icon . $label . '</a>';
			$html .= '<img src="' . esc_url( get_template_directory_uri().'/images/ajax-loader.gif' ) . '" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />';
			$html .= '</div>';

			$html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><span class="feedback">' . __( 'Product added!','wpdance' ) . '</span> <a href="' . esc_url( $url ) . '">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'wpdance' ) ) . '</a></div>';
			$html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><span class="feedback">' . __( 'The product is already in the wishlist!', 'wpdance' ) . '</span> <a href="' . esc_url( $url ) . '">' . apply_filters( 'yith-wcwl-browse-wishlist-label', __( 'Browse Wishlist', 'wpdance' ) ) . '</a></div>';
			$html .= '<div style="clear:both"></div><div class="yith-wcwl-wishlistaddresponse"></div>';

        $html .= '</div>';
        $html .= '<div class="clear"></div>';
		
		return $html;
	}

	function wd_add_wishlist_button_to_product_list(){
		echo do_shortcode('[yith_wcwl_add_to_wishlist]');
	}
	add_action( 'woocommerce_before_shop_loop_item', 'wd_add_wishlist_button_to_product_list', 15 );
	add_action( 'woocommerce_after_shop_loop_item', 'wd_add_wishlist_button_to_product_list', 15 ); /* List mode */
}

if( class_exists('YITH_Woocompare_Frontend') && defined( 'YITH_WOOCOMPARE' ) ){
	global $yith_woocompare;
	$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX );
	if( $yith_woocompare->is_frontend() || $is_ajax ) {
		if( $is_ajax ){
			$yith_woocompare->obj = new YITH_Woocompare_Frontend();
		}
		if ( get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ){
			remove_action( 'woocommerce_after_shop_loop_item', array( $yith_woocompare->obj, 'add_compare_link' ), 20 );
			function wd_add_compare_button_to_product_list(){
				if( wp_is_mobile() )
					return;
				global $yith_woocompare;
				echo '<div class="wd_compare_wrapper">';
				echo '<span class="wd_tooltip">'.__('+Compare', 'wpdance').'</span>';
				$yith_woocompare->obj->add_compare_link();
				echo '</div>';
			}
			add_action( 'woocommerce_before_shop_loop_item', 'wd_add_compare_button_to_product_list', 20 );
			add_action( 'woocommerce_after_shop_loop_item', 'wd_add_compare_button_to_product_list', 16 ); /* List mode */
		}
	}
}

function wd_add_style_yith_compare(){

	$css_file = get_template_directory_uri() .'/framework/includes/css/font-awesome.css';
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.$css_file.'" />';

	$css_file = get_template_directory_uri() .'/css/yith_compare.css';
	echo '<link rel="stylesheet" type="text/css" media="all" href="'.$css_file.'" />';
	$js_file =  get_template_directory_uri() .'/js/yith_compare.js';
	echo '<script type="text/javascript" src="'.$js_file.'"></script>';
	
	/* Add google font */
	wd_load_google_font_yith_compare('Montserrat');
	wd_load_google_font_yith_compare('Source+Sans+Pro');
}
if( isset($_GET['action']) && $_GET['action'] == 'yith-woocompare-view-table' )
	add_action('wp_head','wd_add_style_yith_compare');
	
function wd_load_google_font_yith_compare($wd_font_name){
	if( isset($wd_font_name) && strlen( $wd_font_name ) > 0 ){
		$font_name_id = str_replace('+', '_', strtolower($wd_font_name));
		$protocol = is_ssl() ? 'https' : 'http';
		$link = $protocol.'://fonts.googleapis.com/css?family='.$wd_font_name;
		echo '<link rel="stylesheet" type="text/css" id="wd_'.$font_name_id.'" media="all" href="'.$link.'" />';	
	}
}
	

function custom_product_thumbnail(){
	global $product,$post;
	$thumb = get_post_thumbnail_id($post->ID);
	$_prod_galleries = $product->get_gallery_attachment_ids( );					
	?>
		<div class="product-image">			
			<?php 
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('prod_midium_thumb_2',array('class' => 'big_layout') ); 
				} 				 
			?>
			<span class="product-image-hover"></span>
		</div>			
	<?php					
}



function add_sku_after_title($title,$product){
	$prod_uri = "<a href='".get_permalink( $product->id )."'>";
	$_sku_string = "</a>{$prod_uri}<span class=\"product_sku\">{$product->get_sku()}</span>";
	return $title.$_sku_string;
}




function wd_addon_product_tabs( $tabs = array() ){
		global $product, $post,$wd_data;
		// Description tab - shows product content
		if ( $post->post_excerpt )
			$tabs['description'] = array(
				'title'    => __( 'Description', 'wpdance' ),
				'priority' => 10,
				'callback' => 'woocommerce_product_description_tab'
			);

		
		// Reviews tab - shows comments
		if ( comments_open() && $wd_data['wd_prod_review'] )
			$tabs['reviews'] = array(
				'title'    => sprintf( __( 'Reviews (%d)', 'wpdance' ), get_comments_number( $post->ID ) ),
				'priority' => 90,
				'callback' => 'comments_template'
			);

		if ( $product->has_attributes() || ( get_option( 'woocommerce_enable_dimension_product_attributes' ) == 'yes' && ( $product->has_dimensions() || $product->has_weight() ) ) )
			$tabs['additional_information'] = array(
				'title'    => __( 'Additional Information', 'wpdance' ),
				'priority' => 20,
				'callback' => 'woocommerce_product_additional_information_tab'
			);	
		return $tabs;
}

function wd_addon_custom_tabs ( $tabs = array() ){
	global $wd_data;
	if($wd_data['wd_prod_customtab']) {
		$tabs['wd_custom'] = array(
			'title'    =>  sprintf( __( '%s','wpdance' ), stripslashes(esc_html($wd_data['wd_prod_customtab_title'])) )
			,'priority' => 70
			,'callback' => "print_custom_tabs"
		);
	}
	return $tabs;
}

function print_custom_tabs(){
	global $wd_data;
	echo stripslashes(htmlspecialchars_decode($wd_data['wd_prod_customtab_content']));
}


function product_tags_template(){
	global $product, $post;
	$_terms = wp_get_post_terms( $product->id, 'product_tag');
	
	echo '<div class="tagcloud">';
	
	$_include_tags = '';
	if( count($_terms) > 0 ){
		echo '<span class="tag_heading">'.__('Tags:','wpdance').'</span>';
		foreach( $_terms as $index => $_term ){
			$_include_tags .= ( $index == 0 ? "{$_term->term_id}" : ",{$_term->term_id}" ) ;
		}
		wp_tag_cloud( array('taxonomy' => 'product_tag', 'include' => $_include_tags ) );
	} else {
		echo '<p>'.__('No Tags for this product', 'wpdance').'</p>';
	}
	
	echo "</div>\n";	
	
}

/// end new tabs




function wd_template_single_review(){
	global $product;

	if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
		return;		
		
	if ( $rating_html = $product->get_rating_html() ) {
		echo "<div class=\"review_wrapper\">";
		echo ($rating_html); 
		echo '<span class="review_count">'.$product->get_rating_count()," ";
		_e("Review(s)",'wpdance');
		echo "</span>";
		echo '<span class="add_new_review"><a href="#review_form" class="button inline show_review_form woocommerce-review-link" title="Review for '. esc_attr($product->get_title()) .' ">' . __( 'Write review', 'wpdance' ) . '</a></span>';
		echo "</div>";
	}else{
		echo '<span class="add_new_review"><a href="#review_form" class="button inline show_review_form woocommerce-review-link" title="Review for '. esc_attr($product->get_title()) .' ">' . __( 'Be the first to review', 'wpdance' ) . '</a></span>';

	}

	
}

function wd_template_single_mail() {
	echo '<a href="mailto:?subject=I wanted you to see this site&amp;body=Check out this site '.site_url().'" title="Share by Email">
				Email to a Friend
			</a>';
}
function wd_template_single_content() {
	global $product;
	echo '<div class="wd_product_content">';
	echo get_the_content($product->ID);
	echo '</div>';
}

function wd_before_single_wishlist_compare(){
	echo '<div class="group_wishlist_compare">';
}

function wd_after_single_wishlist_compare(){
	echo '</div>';
}


function wd_template_shipping_return(){
	global $wd_data;
?>
	<div class="return-shipping">
		<header>
			<h4 class="title-quickshop">
				<?php 
					echo sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_data['wd_prod_ship_return_title'])) );
				?>
			</h4>
		</header>
		<?php echo stripslashes($wd_data['wd_prod_ship_return_content']);?>
	</div>
<?php
}
function wd_template_single_banner(){
	global $wd_data;
?>
	<div class="wd_single-product_banner">
		<?php echo stripslashes($wd_data['wd_prod_detail_banner_content']);?>
	</div>
<?php
}


function wd_output_related_products() {
	woocommerce_related_products( 5, 5 );
}




function get_product_availability($product) {
	$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
	if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
		return;
	}	
	$availability = $class = "";

	if ( $product->managing_stock() ) {
		if ( $product->is_in_stock() ) {

			if ( $product->get_total_stock() > 0 ) {

				$format_option = get_option( 'woocommerce_stock_format' );

				switch ( $format_option ) {
					case 'no_amount' :
						$format = __( 'In stock', 'wpdance' );
					break;
					case 'low_amount' :
						$low_amount = get_option( 'woocommerce_notify_low_stock_amount' );

						$format = ( $product->get_total_stock() <= $low_amount ) ? __( 'Only %s left in stock', 'wpdance' ) : __( 'In stock', 'wpdance' );
					break;
					default :
						$format = __( '%s in stock', 'wpdance' );
					break;
				}

				$availability = sprintf( $format, $product->stock );
				$class = 'in-stock';

				if ( $product->backorders_allowed() && $product->backorders_require_notification() )
					$availability .= ' ' . __( '(backorders allowed)', 'wpdance' );

			} else {

				if ( $product->backorders_allowed() ) {
					if ( $product->backorders_require_notification() ) {
						$availability = __( 'Available on backorder', 'wpdance' );
						$class        = 'available-on-backorder';
					} else {
						$availability = __( 'In stock', 'wpdance' );
					}
				} else {
					$availability = __( 'Out of stock', 'wpdance' );
					$class        = 'out-of-stock';
				}

			}

		} elseif ( $product->backorders_allowed() ) {
			$availability = __( 'Available on backorder', 'wpdance' );
			$class        = 'available-on-backorder';
		} else {
			$availability = __( 'Out of stock', 'wpdance' );
			$class        = 'out-of-stock';
		}
	} elseif ( ! $product->is_in_stock() ) {
		$availability = __( 'Out of stock', 'wpdance' );
		$class        = 'out-of-stock';
	} elseif ( $product->is_in_stock() ){
		$availability = __( 'In stock', 'wpdance' );
		$class        = 'in-stock';		
	}

	return apply_filters( 'woocommerce_get_availability', array( 'availability' => $availability, 'class' => $class ), $product );
}

function wd_template_single_availability(){
	global $product;
	$_product_stock = get_product_availability($product);
	?>	
	<p class="availability stock <?php echo esc_attr($_product_stock['class']);?>"><span class="wd_availability"><?php _e('Availability:','wpdance'); ?></span><span><?php echo esc_attr($_product_stock['availability']);?></span></p>	
<?php	
}	

function wd_template_single_sku(){
	global $product, $post;
	echo "<p class='wd_product_sku'>".__("sku: ","wpdance")."<span class=\"product_sku\">" . esc_attr($product->get_sku()) . "</span></p>";
}	

function wd_template_single_rating(){
	global $product, $post;
	echo ($product->get_rating_html());
}



function button_add_to_card(){
	global $wd_data,$product;
	$_layout_config = explode("-",$wd_data['wd_layout_style']);
	$_left_sidebar = (int)$_layout_config[0];
	$_right_sidebar = (int)$_layout_config[2];
	$temp_class = '';
	if($_left_sidebar || $_right_sidebar) {
		if($product->product_type == 'variable') { 
			$temp_class= ' variable_hidden';
		}
		if($product->product_type == 'external') { ?>
			<!--<p class="cart"><a href="<?php echo esc_url($product->get_product_url()); ?>" rel="nofollow" class="single_add_to_cart_button button alt hidden-phone"><?php echo apply_filters('single_add_to_cart_text',$product->get_button_text(), 'external'); ?></a></p>-->
			<p class="cart"><a href="<?php echo esc_url($product->get_product_url()); ?>" rel="nofollow" class="single_add_to_cart_button button alt hidden-phone"><?php echo esc_html($product->get_button_text()); ?></a></p>
		<?php  } else {
			echo '<button type="button" class="virtual single_add_to_cart_button button alt hidden-phone'.$temp_class.'">';
			echo apply_filters('single_add_to_cart_text', __( 'Add to cart', 'wpdance' ), $product->product_type); 
			echo '</button>';
		}
	}	
}


function wd_upsell_display( $posts_per_page = '-1', $columns = 5, $orderby = 'rand' ){
	wc_get_template( 'single-product/up-sells.php', array(
				'posts_per_page'  => 15,
				'orderby'    => 'rand',
				'columns'    => 15
		) );
}

add_filter('woocommerce_breadcrumb_defaults', 'wd_woocommerce_breadcrumb_defaults_filter');
function wd_woocommerce_breadcrumb_defaults_filter( $defaults = array() ){
	$defaults['delimiter'] = '<span class="brn_arrow">&#47;</span>';
	$defaults['wrap_before'] = '<nav id="crumbs" class="woocommerce-breadcrumb container heading">';
	$defaults['wrap_after'] = '</nav>';
	$defaults['before'] = '<span>';
	$defaults['after'] = '</span>';
	return $defaults;
}

function wd_product_category_banner(){
	global $wd_data;
	if( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( "product" ) ){
		if( isset($wd_data['wd_prod_cat_banner']) && strlen(trim($wd_data['wd_prod_cat_banner'])) > 0 ){
			echo '<div class="product-category-top-banner">';
			echo '<img src="'.$wd_data['wd_prod_cat_banner'].'" alt="" />';
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'wd_checkout_fields_form' ) ) {
	function wd_checkout_fields_form($checkout){
		$checkout->checkout_fields['account']    = array(
			'account_username' => array(
				'type' => 'text',
				'label' => __('Account username', 'wpdance'),
				'placeholder' => _x('Username', 'placeholder', 'wpdance')
				),
			'account_password' => array(
				'type' => 'password',
				'label' => __('Account password', 'wpdance'),
				'placeholder' => _x('Password', 'placeholder', 'wpdance'),
				'class' => array('form-row-first')
				),
			'account_password-2' => array(
				'type' => 'password',
				'label' => __('Account password', 'wpdance'),
				'placeholder' => _x('Comfirm Password', 'placeholder', 'wpdance'),
				'class' => array('form-row-last'),
				'label_class' => array('hidden')
				)
		);
	}
}


function update_add_to_cart_text( $button_text ){
	return $button_text = __('Add to Cart','wpdance');
}
function update_single_product_wrapper_class( $_wrapper_class ){
	return $_wrapper_class = "without_related";
}



if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 5; // 5 products per row
	}
}

if (!function_exists('wd_ads_sidebar')) {
	function wd_ads_sidebar($position){
		global $product;
		$wd_ads_sidebars = maybe_unserialize( get_post_meta( $product->id, THEME_SLUG.'product_ads_sidebar', true ) );
		$wd_ads_count = sizeof( $wd_ads_sidebars );
		if($wd_ads_sidebars && $wd_ads_count > 0){
			$return = '<div class="wd_ads_sidebar_'.$position.'">';
			$i = -1;
			$check = 0;
			foreach($wd_ads_sidebars as $wd_ads_sidebar_item ) {
				$i++;
				//if ( ! $wd_ads_sidebar_item['name'] )
				//	continue;
				if ( $wd_ads_sidebar_item['position'] == $position)	{
					$return .= '<div class="wd_ads_item_'.$i.'">';
					if(strlen(trim($wd_ads_sidebar_item['name'])) > 0 ){
						$return .= '<h3>'.$wd_ads_sidebar_item['name'].'</h3>';
					}
					$return .= '<div>'.$wd_ads_sidebar_item['content'].'</div>';
					$return .= '</div>';
					$check = 1;
				}	
			}
			$return .= '</div>';
		}
		if($check == 1){
			echo ($return);
		}	
		return '';
	}
}

add_action('wd_before_main_container', 'wd_add_facebook_sdk');
if( !function_exists('wd_add_facebook_sdk') ){
	function wd_add_facebook_sdk(){
	?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
	}
}

if( !function_exists('wd_blog_details_sharing') ){
	function wd_blog_details_sharing(){
	?>
	<div class="social_sharing">
		
		<div class="social_icon">
			<div class="facebook">
				<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>
			</div>			
				
			<!-- Place this render call where appropriate -->
			<script type="text/javascript">
			  (function() {
				"use strict";
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
			
			<div class="twitter">
				<a href="<?php echo "https://twitter.com/share"; ?>" class="twitter-share-button" data-count="none"></a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<?php 
				$image_id = get_post_thumbnail_id();
				$image_url = wp_get_attachment_image_src($image_id,'full', true);
			?>
			<div>
				<a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($image_url[0]); ?>&amp;" data-pin-do="buttonPin" data-pin-config="none">
					<img alt="pinterest" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
				</a>
				<script type="text/javascript">
					(function(d){
					  "use strict";
					  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
					  p.type = 'text/javascript';
					  p.async = true;
					  p.src = '//assets.pinterest.com/js/pinit.js';
					  f.parentNode.insertBefore(p, f);
					}(document));
				</script>
			</div>
			
		</div>              
	</div>
	<?php
	}
}

/* Fix Woo Testimonial Args */
add_filter('woothemes_get_testimonials_args', 'wd_woo_testimonial_args_filter');
function wd_woo_testimonial_args_filter($args){
	if( !isset($args['size']) ){
		$args['size'] = 'full';
	}
	return $args;
}

/* Fix Woo Feature Args */
add_filter('woothemes_get_features_args', 'wd_woo_feature_args_filter');
function wd_woo_feature_args_filter($args){
	if( !isset($args['size']) ){
		$args['size'] = 'full';
	}
	return $args;
}

/* Remove Cart Totals */
remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);

if ( ! function_exists( 'wd_checkout_add_on_js' ) ) {
	function wd_checkout_add_on_js(){
?>
	<script type='text/javascript'>
		jQuery(document).ready(function() {
			"use strict";
			jQuery('input.checkout-method').on('change',function(event){
				if( jQuery(this).val() == 'account' && jQuery(this).is(":checked") ){
					jQuery('.accordion-createaccount').removeClass('hidden');
					jQuery('#collapse-login-regis').find('input.next_co_btn').attr('rel','accordion-account');
					
				}else{
					jQuery('.accordion-createaccount').addClass('hidden');
					jQuery('#collapse-login-regis').find('input.next_co_btn').attr('rel','accordion-billing');				
				}
			});
			jQuery('input.checkout-method').trigger('change');
			
			jQuery('.next_co_btn').on('click',function(){
				var _next_id = '#'+jQuery(this).attr('rel');
				jQuery('.accordion-group').not(_next_id).find('.accordion-body').each(function(index,value){
					if( jQuery(value).hasClass('in') )
						jQuery(value).siblings('.accordion-heading').children('a.accordion-toggle').trigger('click');
				});
				if( !jQuery(_next_id).find('.accordion-body').hasClass('in') ){	
					jQuery(_next_id).find('.accordion-body').siblings('.accordion-heading').children('a.accordion-toggle').trigger('click');
				}
			});    
		
		});
	</script>
<?php	
	}
}
?>