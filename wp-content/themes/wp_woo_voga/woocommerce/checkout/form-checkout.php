<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'wpdance' ) );
	return;
}

$_user_logged = is_user_logged_in();
$_counter = 1;
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>



	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<div class="accordion" id="accordion-checkout-details">
		
		<?php if(!$_user_logged):?>
			<div class="accordion-group" id="accordion-method">
				<div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-checkout-details" href="#collapse-login-regis">
						<h3 id="order_review_heading" class="heading-title checkout-title"><?php _e("Checkout Method",'wpdance'); ?></h3>
					</a>
				</div>
				<div id="collapse-login-regis" class="accordion-body collapse <?php echo $_counter == 1 ? "in" : ""; ?>">
					<div class="accordion-inner">
						<div class="col-sm-12 first block-wrapper">
							<header class="title-wrapper">
								<h3 class="heading-title"><?php _e('New Customer','wpdance');?></h3>
							</header>
							<div class="login-regis text-strong">
								<p style="margin-bottom:5px;"><input type="radio" class="checkout-method" name="checkout-method" checked value="guest"><?php _e('Checkout as Guest','wpdance');?></p>
								<p><input type="radio" class="checkout-method" name="checkout-method" value="account"><?php _e('Create an Account with Us','wpdance');?></p>
							</div>
							<div class="description text-strong">
								<span><?php _e('Register with us for future convenience:','wpdance');?></span>
								<ul>
									<li><?php _e('+ Fast and easy checkout.','wpdance');?></li>
									<li><?php _e('+ Easy access to your dorder history and status.','wpdance');?></li>
								</ul>
							</div>
							<input type="button" value="<?php _e( "Continue","wpdance" );?>" name="button_create_account_continue" class="button_create_account_continue button next_co_btn" rel="accordion-billing">
						</div>
						<div class="col-sm-12 second block-wrapper text-strong">	
							<header class="title-wrapper">
								<h3 class="heading-title"><?php _e('Login','wpdance');?></h3>
							</header>
							<?php woocommerce_checkout_login_form(); ?>
							
						</div>
						
						<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					</div>
				</div>
			</div>		
			<?php $_counter++;?>
		<?php endif;?>	
		
			<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">		
				
				<div class="accordion-group hidden accordion-createaccount" id="accordion-account">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-checkout-details" href="#collapse-createaccount">
							<h3 id="order_review_heading" class="heading-title checkout-title"><?php _e("Create an account",'wpdance'); ?></h3>
						</a>
					</div>
					<div id="collapse-createaccount" class="accordion-body collapse">
						<div class="accordion-inner">
							<?php if ( ! is_user_logged_in() && $checkout->enable_signup ) : ?>

								<?php if ( $checkout->enable_guest_checkout ) : ?>

									<p class="form-row form-row-wide">
										<input class="input-checkbox" id="createaccount" <?php checked($checkout->get_value('createaccount'), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e( 'Create an account?', 'wpdance' ); ?></label>
									</p>

								<?php endif; ?>

								<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

								<div class="create-account">

									<!--<p><?php _e( 'Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'wpdance' ); ?></p>-->

									<?php foreach ($checkout->checkout_fields['account'] as $key => $field) : ?>

										<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

									<?php endforeach; ?>

									<div class="clear"></div>

								</div>
								
								<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
							<?php endif; ?>	
							<input type="button" value="<?php _e( "Continue","wpdance" );?>" name="button_billing_address_continue" class="button_billing_address_continue button next_co_btn" rel="accordion-billing">
						</div>
					</div>
				</div>					
							

				<div class="accordion-group" id="accordion-billing">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-checkout-details" href="#collapse-billing">
							<h3 id="order_review_heading" class="heading-title checkout-title"><?php _e("Billing Address",'wpdance'); ?></h3>
						</a>
					</div>
					<div id="collapse-billing" class="accordion-body collapse <?php echo $_counter == 1 ? "in" : ""; ?>">
						<div class="accordion-inner">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
							<input type="button" value="<?php _e( "Continue","wpdance" );?>" name="button_shipping_address_continue" class="button_shipping_address_continue button next_co_btn" rel="accordion-shipping">
						</div>
					</div>
				</div>
				<?php $_counter++;?>

				<div class="accordion-group" id="accordion-shipping">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-checkout-details" href="#collapse-shipping">
							<h3 id="order_review_heading" class="heading-title checkout-title"><?php _e("Shipping Address",'wpdance'); ?></h3>
						</a>
					</div>
					<div id="collapse-shipping" class="accordion-body collapse <?php echo $_counter == 1 ? "in" : ""; ?>">
						<div class="accordion-inner">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
							<input type="button" value="<?php _e( "Continue","wpdance" );?>" name="button_review_order_continue" class="button_review_order_continue button next_co_btn" rel="accordion-review">
						</div>
					</div>
				</div>	
				<?php $_counter++;?>

				<div class="accordion-group" id="accordion-review">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-checkout-details" href="#collapse-order-review">
							<h3 id="order_review_heading" class="heading-title checkout-title"><?php _e( 'Your order', 'wpdance' ); ?></h3>
						</a>
					</div>
					<div id="collapse-order-review" class="accordion-body collapse <?php echo $_counter == 1 ? "in" : ""; ?>">
						<div class="accordion-inner" id="order_review">
							<?php do_action( 'woocommerce_checkout_order_review' ); ?>
						</div>
					</div>
				</div>
				<?php $_counter++;?>
				
			</form>	
		
		</div>
	

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>

<div class="after_checkout_form">
	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
	<?php do_action( 'wd_after_checkout_form', $checkout ); ?>
</div>