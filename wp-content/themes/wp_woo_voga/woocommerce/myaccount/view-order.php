<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page
 *
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version   2.2.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

wc_print_notices();

echo '<p class="order_info bold">' . sprintf( __( 'Order <mark class="order-number">%s</mark> was placed on <mark class="order-date">%s</mark> and is currently <mark class="order-status">%s</mark>.', 'wpdance' ), $order->get_order_number(), date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ), __( $status->name, 'wpdance' ) ) . '</p>';

$notes = $order->get_customer_order_notes();
if ( $notes ) :
	?>
	<header class="title-wrapper"><h3 class="heading-title"><?php _e( 'Order Updates', 'wpdance' ); ?></h3></header>
	<ol class="commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="comment note">
			<div class="comment_container">
				<div class="comment-text">
					<p class="meta"><?php echo date_i18n( __( 'l jS \o\f F Y, h:ia', 'wpdance' ), strtotime( $note->comment_date ) ); ?></p>
					<div class="description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php
endif;
do_action( 'woocommerce_view_order', $order_id );
?>