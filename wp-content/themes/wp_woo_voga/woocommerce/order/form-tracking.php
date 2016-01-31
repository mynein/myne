<?php
/**
 * Order tracking form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;
?>
<p class="bold track_order"><?php _e( 'To track your order please enter your Order ID in the box below and press enter. This was given to you on your receipt and in the 
confirmation email you should have received.', 'wpdance' ); ?></p>
<form action="<?php echo esc_url( get_permalink($post->ID) ); ?>" method="post" class="track_order">
	<div class="image_trackorder"><img title="<?php _e('track order','wpdance') ?>" alt="<?php _e('track order','wpdance') ?>" src="<?php echo get_template_directory_uri().'/images/bg-track-order.png' ?>" /></div>
	<p class="form-row form-row-wide"><label for="orderid"><?php _e( 'Order ID', 'wpdance' ); ?></label> <input class="input-text" type="text" name="orderid" id="orderid" placeholder="<?php _e( 'Found in your order confirmation email.', 'wpdance' ); ?>" /></p>
	<p class="form-row form-row-wide"><label for="order_email"><?php _e( 'Billing Email', 'wpdance' ); ?></label> <input class="input-text" type="text" name="order_email" id="order_email" placeholder="<?php _e( 'Email you used during checkout.', 'wpdance' ); ?>" /></p>
	<div class="clear"></div>

	<p class="form-row"><input type="submit" class="button" name="track" value="<?php _e( 'Track order', 'wpdance' ); ?>" /></p>
	<?php wp_nonce_field( 'woocommerce-order_tracking' ); ?>

</form>