<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices(); ?>

<p class="myaccount_user">
	<?php
	echo '<div class="bold myaccount_desc">';
	printf(
		__( 'Welcome back, <span>%s</span> !', 'wpdance' ),
		$current_user->display_name);
	printf (__('</br><u><a class="bold" href="%s">Change password</a></u><br/>', 'wpdance'),esc_url(wc_customer_edit_account_url()));
	echo '<u><a class="bold" href="'. wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) .'">'.__('Log out', 'wpdance').'</a></u>';
	echo '</div>';
	?>
</p>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>

<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>

<?php wc_get_template( 'myaccount/my-address.php' ); ?>

<?php do_action( 'woocommerce_after_my_account' ); ?>