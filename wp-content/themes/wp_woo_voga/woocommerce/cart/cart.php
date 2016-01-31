<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="wd_form_cart" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-thumbnail first"><span class="nobr"><?php _e( 'Items', 'wpdance' ); ?></span></th>
			<th class="product-price"><span class="nobr"><?php _e( 'Price', 'wpdance' ); ?></span></th>
			<th class="product-quantity"><span class="nobr"><?php _e( 'Quantity', 'wpdance' ); ?></span></th>
			<th class="product-subtotal"><span class="nobr"><?php _e( 'Total', 'wpdance' ); ?></span></th>
			<th class="product-remove last"><span class="nobr">&nbsp;</span></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class = "<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<!-- The thumbnail -->
					<td class="product-thumbnail product-name">
						<div class="wd_product_wrapper">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
							echo '<div class="wd_product_thumbnail">';
							if ( ! $_product->is_visible() )
								echo $thumbnail;
							else
								printf('<a href="%s">%s</a>',  $_product->get_permalink( $cart_item ), $thumbnail );
							echo '</div>';
							echo '<div class="wd_product_meta">';
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

							// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'wpdance' ) . '</p>';
						
							//echo '<p class="wd_product_number">'.apply_filters( 'woocommerce_checkout_item_quantity', '<strong class="product-quantity">&times; ' . $cart_item['quantity'] . '</strong>', $cart_item, $cart_item_key ).'</p>';
							//echo '<p class="wd_product_excerpt">'.substr(strip_tags($_product->post->post_excerpt),0,60).'...</p>';
							echo '</div>';
						?>
					
						</div>
					<!-- Product Name -->
							
					</td>

					<!-- Product price -->
					<td class="product-price">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<!-- Quantity inputs -->
					<td class="product-quantity">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<!-- Product subtotal -->
					<td class="product-subtotal">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-removelink">
					<?php 
					//Remove from cart link
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove button" title="%s">remove</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'wpdance' ) ), $cart_item_key );				
					?>
					</td>
				</tr>
				<?php
			}
		}
		

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr class="hidden">
			<td colspan="6" class="actions">

			<input type="submit" class="button hidden wd_update_button_invisible" name="update_cart" value="<?php _e( 'Update Cart', 'wpdance' ); ?>" /> 
			
			
			<!--<input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout', 'wpdance' ); ?>" />-->
			<?php do_action('woocommerce_proceed_to_checkout'); ?>

			<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>
<div class="wd_cart_buttons">
	<a class="button backtoshop" href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"><?php _e( '&larr; Back To Shop', 'wpdance' ) ?></a>
	<a href="#" class="button wd_update_button_visible"><?php _e( 'Update Cart', 'wpdance' ); ?></a>
</div>
<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">
	<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">	
		<div class="coupon_wrapper">
		
				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<div class="coupon">

						<header class="title-wrapper"><h3 class="heading-title"><?php _e( 'Discount code', 'wpdance' ); ?></h3></header>
						<p class="form-row form-row-wide"><label><?php _e( 'Coupon code', 'wpdance' ); ?></label>
						<input name="coupon_code" class="input-text" id="coupon_code" value="" /> 
						</p>
						<p><input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', 'wpdance' ); ?>" /></p>

						<?php do_action('woocommerce_cart_coupon'); ?>

					</div>
				<?php } ?>

		</div>
	</form>
	
	<?php woocommerce_shipping_calculator(); ?>
	
	<?php woocommerce_cart_totals(); ?>

	<?php do_action('woocommerce_cart_collaterals'); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>