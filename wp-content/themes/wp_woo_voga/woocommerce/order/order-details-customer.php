<?php
/**
 * Order Customer Details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<header class="title-wrapper"><h3 class="heading-title"><?php _e( 'Customer Details', 'wpdance' ); ?></h3></header>

<table class="shop_table shop_table_responsive customer_details">
	<?php if ( $order->customer_note ) : ?>
		<tr>
			<th><?php _e( 'Note:', 'wpdance' ); ?></th>
			<td><?php echo wptexturize( $order->customer_note ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( $order->billing_email ) : ?>
		<tr>
			<th><?php _e( 'Email:', 'wpdance' ); ?></th>
			<td><?php echo esc_html( $order->billing_email ); ?></td>
		</tr>
	<?php endif; ?>

	<?php if ( $order->billing_phone ) : ?>
		<tr>
			<th><?php _e( 'Telephone:', 'wpdance' ); ?></th>
			<td><?php echo esc_html( $order->billing_phone ); ?></td>
		</tr>
	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>
</table>

<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

<div class="col2-set addresses">
	<div class="col-1">

<?php endif; ?>

<header class="title">
	<h4><?php _e( 'Billing Address', 'wpdance' ); ?></h4>
</header>
<address>
	<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'wpdance' ); ?>
</address>

<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

	</div><!-- /.col-1 -->
	<div class="col-2">
		<header class="title">
			<h4><?php _e( 'Shipping Address', 'wpdance' ); ?></h4>
		</header>
		<address>
			<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'wpdance' ); ?>
		</address>
	</div><!-- /.col-2 -->
</div><!-- /.col2-set -->

<?php endif; ?>
