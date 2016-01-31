<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $wd_data;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

	// Ensure visibility
if ( ! $product && ! $product->is_visible() )
	return;	
	
//>=1200 >=992 >=768 >=480 >=320
$_sub_class = "wd-col-lg-4 wd-col-md-4 wd-col-sm-3 wd-col-xs-2 wd-col-mb-1";
if( absint($wd_data['wd_prod_cat_column']) > 0 ){
	$_columns = absint($wd_data['wd_prod_cat_column']);
	$_sub_class = "wd-col-lg-".$_columns;
	$_sub_class .= ' wd-col-md-'.floor($_columns * 992 / 1200);
	$_sub_class .= ' wd-col-sm-'.floor($_columns * 768 / 1200);
	$_sub_class .= ' wd-col-xs-'.floor($_columns * 480 / 1200);
	$_sub_class .= ' wd-col-mb-1';
}else{
	$_columns = absint($woocommerce_loop['columns']);
	$_sub_class = "wd-col-lg-".$_columns;
	$_sub_class .= ' wd-col-md-'.floor($_columns * 992 / 1200);
	$_sub_class .= ' wd-col-sm-'.floor($_columns * 768 / 1200);
	$_sub_class .= ' wd-col-xs-'.floor($_columns * 480 / 1200);
	$_sub_class .= ' wd-col-mb-1';
}	

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

//add on column class on cat page	
$classes[] = $_sub_class ;	
$classes[] = 'product' ;	
	
?>
<section <?php post_class( $classes ); ?>>
	<div class="product-item-wrapper">
		<?php do_action('wd_before_thumbnail_wrapper');
		global $wd_data;
		$quickshop_ready = '';
		$compare_ready ='';
		$wishlist_ready ='';
		$addcart_ready ='';
		
		$hover_ready = '';
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		
		if( in_array( "wd_quickshop/wd_quickshop.php", $_actived ) ){	
			$quickshop_ready = "active-quickshop ";
			$hover_ready = "active-hover";
		}
		if( defined( 'YITH_WOOCOMPARE' ) && get_option('yith_woocompare_compare_button_in_products_list') == 'yes' ){	
			$compare_ready = "active-compare ";
			$hover_ready = "active-hover";
		}
		if( class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL') ){	
			$wishlist_ready ="active-wishlist ";
			$hover_ready = "active-hover";
		}
		if(absint($wd_data['wd_catelog_mod']) == 0){
			$addcart_ready = "active-addcart ";
			$hover_ready = "active-hover";
		}
		
		?>
		<div class="product-thumbnail-wrapper <?php echo esc_attr($quickshop_ready) ?><?php echo esc_attr($compare_ready); ?><?php echo esc_attr($wishlist_ready); ?><?php echo esc_attr($addcart_ready); ?><?php echo esc_attr($hover_ready); ?>">
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		
			<a href="<?php the_permalink(); ?>">

				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</a>
		</div>
		<div class="product-meta-wrapper">
			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */
				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

		

			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>
	</div>
</section>