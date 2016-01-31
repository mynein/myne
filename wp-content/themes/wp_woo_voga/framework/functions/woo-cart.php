<?php
if ( ! function_exists( 'wd_tini_cart' ) ) {
	function wd_tini_cart(){
		global $wd_data;
		
		$woo_header = isset($wd_data['wd_woo_header']) && $wd_data['wd_woo_header'];
		
		if( isset($_POST['is_ec_page']) ){
			$woo_header = !$_POST['is_ec_page'];
		}
		
		$has_woocommerce = true;
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
			$has_woocommerce = false;
		}
		
		if( $woo_header && $has_woocommerce ){
		
			$_cart_empty = sizeof( WC()->cart->get_cart() ) > 0 ? false : true ;
			
			ob_start();
			
			?>
			<?php do_action( 'wd_before_tini_cart' ); ?>
			<div class="wd_tini_cart_wrapper">
				<div class="wd_tini_cart_control heading">
					
					<div class="cart_size">
						<a href="<?php echo WC()->cart->get_cart_url();?>" title="<?php _e('View your shopping bag','wpdance');?>">
							<span class="label"><?php _e('shopping cart','wpdance');?> </span>
							<span class="number"><?php echo WC()->cart->cart_contents_count;?></span>
						</a>
						<span class="cart_size_value_head">
							<span class="wd_cart_total"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
							<i class="fa fa-align-justify"></i>
						</span>
					</div>
				</div>
				<div class="cart_dropdown drop_down_container">
					<div class="cart_dropdown_wrapper">
						<?php if ( !$_cart_empty ) : ?>
						<div class="dropdown_body woocommerce ">
							<ul class="cart_list product_list_widget">
									
									<?php
										$_cart_array = WC()->cart->get_cart();
										$_index = 0;
									?>
									
									<?php foreach ( $_cart_array as $cart_item_key => $cart_item ) :
										
										$_product = $cart_item['data'];

										// Only display if allowed
										if ( ! apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 )
											continue;

										// Get price
										$product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? $_product->get_price_excluding_tax() : $_product->get_price_including_tax();

										$product_price = apply_filters( 'woocommerce_cart_item_price_html', wc_price( $product_price ), $cart_item, $cart_item_key );
										?>

										<li class="<?php echo ($_index == 0 ? "first" : ($_index == count($_cart_array) - 1 ? "last" : "")) ?>">
											<a class="product-thumbnail">
												<?php echo ($_product->get_image('shop_thumbnail')); ?>
											</a>
											<div class="product-meta">
												<a href="<?php echo get_permalink( $cart_item['product_id'] ); ?>">
													<?php echo esc_html($_product->get_title()); ?>
												</a>
												<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s',$product_price, $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>
												<?php
												
												echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'wpdance' ) ), $cart_item_key );
												?>
											</div>
										</li>

										<?php $_index++; ?>
										
									<?php endforeach; ?>
							</ul><!-- end product list -->
						</div>
						<?php else: ?>
						<div class="size_empty">
							<?php _e('You have no items in your shopping cart.','wpdance');?>
						</div>
						<?php endif; ?>
						<?php if ( !$_cart_empty ) : ?>
							<div class="dropdown_footer">
								<p class="total"><span class="bold font-second"><?php _e( 'Subtotal', 'wpdance' ); ?></span> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

								<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
								
								<p class="buttons">
									<a class="checkout big" href="<?php echo WC()->cart->get_checkout_url(); ?>" class="button checkout"><?php _e( 'checkout', 'wpdance' ); ?></a>
									<a class="cart button-body big" href="<?php echo WC()->cart->get_cart_url();?>"><?php _e('go to cart','wpdance');?></a>
								</p>
								
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php do_action( 'wd_after_tini_cart' ); ?>
	<?php
			$tini_cart = ob_get_clean();
			return $tini_cart;
		}
		else{
			if( !isset($_SESSION['ec_cart_id']) || !class_exists('ec_cart') ){
				return;
			}
			
			$cart = new ec_cart( $_SESSION['ec_cart_id'] );
			
			$ec_cartpage = new ec_cartpage();
			$cart_url = $ec_cartpage->cart_page; 
			$checkout_url = $ec_cartpage->cart_page . $ec_cartpage->permalink_divider . 'ec_page=checkout_info';
			
			if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
				$https_class = new WordPressHTTPS( );
				$cart_url = $https_class->makeUrlHttps( $cart_url );
				$checkout_url = $https_class->makeUrlHttps( $checkout_url );
			}
			?>
			<div class="wd_tini_cart_wrapper">
				<div class="wd_tini_cart_control heading">
					
					<div class="cart_size">
						<a href="<?php echo esc_url($cart_url); ?>" title="<?php _e('View your shopping bag','wpdance');?>">
							<span class="label"><?php _e('shopping cart','wpdance');?> </span>
							<span class="number"><?php echo esc_html($cart->get_total_items()); ?></span>
						</a>
						<span class="cart_size_value_head">
							<span class="wd_cart_total"><span class="amount"><?php echo esc_html($GLOBALS['currency']->get_currency_display($cart->subtotal)); ?></span></span>
							<i class="fa fa-align-justify"></i>
						</span>
					</div>
				</div>
				<div class="cart_dropdown drop_down_container">
					<div class="cart_dropdown_wrapper">
						<?php if ( count($cart->cart) > 0 ) : ?>
						<div class="dropdown_body woocommerce ">
							<ul class="cart_list product_list_widget">
									
									<?php
										$_index = 0;
									?>
									
									<?php foreach ( $cart->cart as $cart_item_key => $cart_item ) : ?>

										<li class="<?php echo ($_index == 0 ? "first" : ($_index == count($cart->cart) - 1 ? "last" : "")) ?>">
											<a href="<?php echo esc_url($cart_item->get_product_url()); ?>" class="product-thumbnail">
												<img src="<?php echo esc_url($cart_item->get_image_url()); ?>" alt="" />
											</a>
											<div class="product-meta">
												<?php $cart_item->display_title_link(); ?>
												<span class="quantity"><?php echo esc_html($cart_item->display_unit_price( 0, 0 )); ?> &times; <?php echo esc_html($cart_item->quantity); ?></span>
												<a href="javascript: void(0)" class="remove ec_remove_item" title="Remove items" data-cartitem_id="<?php echo esc_attr($cart_item->cartitem_id) ?>" data-model_number="<?php echo esc_attr($cart_item->model_number) ?>">&times;</a>
											</div>
										</li>

										<?php $_index++; ?>
										
									<?php endforeach; ?>
							</ul><!-- end product list -->
						</div>
						<?php else: ?>
						<div class="size_empty">
							<?php _e('You have no items in your shopping cart.','wpdance');?>
						</div>
						<?php endif; ?>
						<?php if ( count($cart->cart) > 0 ) : ?>
							<div class="dropdown_footer">
								<p class="total"><span class="bold font-second"><?php _e( 'Subtotal', 'wpdance' ); ?></span><span class="amount"><?php echo esc_html($GLOBALS['currency']->get_currency_display( $cart->subtotal )); ?></span></p>
								
								<p class="buttons">
									<a class="checkout big" href="<?php echo esc_url($checkout_url); ?>" class="button checkout"><?php _e( 'checkout', 'wpdance' ); ?></a>
									<a class="cart button-body big" href="<?php echo esc_url($cart_url); ?>"><?php _e('go to cart','wpdance');?></a>
								</p>
								
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'wd_update_tini_cart' ) ) {
	function wd_update_tini_cart() {
		die($_tini_cart_html = wd_tini_cart());
	}
}

add_action('wp_ajax_update_tini_cart', 'wd_update_tini_cart');
add_action('wp_ajax_nopriv_update_tini_cart', 'wd_update_tini_cart');

?>