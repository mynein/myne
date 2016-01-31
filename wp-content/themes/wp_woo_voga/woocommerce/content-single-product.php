<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
	 
	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<?php 
	$active_plugin ='';
	global $wd_data;
	if( class_exists('YITH_WCWL_UI') && class_exists('YITH_WCWL') ){	
		$active_plugin .="active-wishlist ";
	}
	if( defined( 'YITH_WOOCOMPARE' ) && get_option('yith_woocompare_compare_button_in_product_page') == 'yes' ){	
		$active_plugin .="active-compare ";
	}
	if(absint($wd_data['wd_catelog_mod']) == 0){
		$active_plugin .= "active-addcart ";
	}
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class($active_plugin); ?>>
	<div class="image_summary">
		<?php
			/**
			 * woocommerce_show_product_images hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>

		
		<div class="summary entry-summary">

			<?php
				/**
				 * woocommerce_single_product_summary hook
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_review - 14
				 * @hooked woocommerce_template_single_avaibility - 16
				 * @hooked woocommerce_template_single_sku - 18			 
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_price - 29
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_sharing - 35	
				 * @hooked woocommerce_template_single_meta - 40
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>

		</div><!-- .summary -->		
	</div>	
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_banner - 5 
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
	
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>