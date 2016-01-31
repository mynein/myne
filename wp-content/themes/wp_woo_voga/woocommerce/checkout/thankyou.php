<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p class="bold"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'wpdance' ); ?></p>

		<p class="bold"><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'wpdance' );
			else
				_e( 'Please attempt your purchase again.', 'wpdance' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'wpdance' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'wpdance' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p class="bold thankyou_desc"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Your order has been received, thank you for your purchase!', 'wpdance' ), $order ); ?></p>

		<ul class="order_details">
			<li class="image_thankyou"><img title="<?php _e('order received','wpdance') ?>" alt="<?php _e('order received','wpdance') ?>" src="<?php echo get_template_directory_uri().'/images/bg-order-received.png' ?>" /></li>
			<li class="order">
				<span><?php _e( 'Your order number is :', 'wpdance' ); ?></span>
				<span class="bold"><?php echo $order->get_order_number(); ?></span>
			</li>
			<li class="date">
				<span><?php _e( 'Date:', 'wpdance' ); ?></span>
				<span class="bold"><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></span>
			</li>
			<li class="total">
				<span><?php _e( 'Total:', 'wpdance' ); ?></span>
				<span class="bold"><?php echo $order->get_formatted_order_total(); ?></span>
			</li>
			<?php if ( $order->payment_method_title ) : ?>
			<li class="method">
				<span><?php _e( 'Payment method:', 'wpdance' ); ?></span>
				<span class="bold"><?php echo $order->payment_method_title; ?></span>
			</li>
			<?php endif; ?>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
	<?php do_action( 'woocommerce_thankyou', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'wpdance' ), null ); ?></p>

<?php endif; ?>