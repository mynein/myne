<?php 
	add_action( 'wd_header_init', 'wd_print_header_top', 10 );
	if(!function_exists ('wd_print_header_top')){
		function wd_print_header_top(){ 
			global $wd_data;
			$header_layout = 'v1';
			if( isset($wd_data['wd_header_layout']) ){
				$header_layout = $wd_data['wd_header_layout'];
			}
		?>
			<div class="header-top" id="header-top">
				<div class="header-top-content container">
					<?php 
					if( $header_layout == 'v2' || $header_layout == 'v3' ){
						theme_logo(); 
					}
					?>
					<div class="nav wd_mega_menu_wrapper">
						<?php 
							if ( has_nav_menu( 'primary' )) {
								wp_nav_menu( array( 'container_class' => 'main-menu pc-menu wd-mega-menu-wrapper','theme_location' => 'primary','walker' => new WD_Walker_Nav_Menu() ) );
							}else{
								wp_nav_menu( array( 'container_class' => 'main-menu pc-menu wd-mega-menu-wrapper', 'walker' => new WD_Walker_Nav_Menu() ) );
							}
						?>
					</div>
					
					<?php if( $header_layout == 'v1' ): ?>
					<div class="header_woo_content visible-sticky">
						<div class="shopping-cart shopping-cart-wrapper">
							<?php echo wd_tini_cart();?>
						</div>
					</div>
					<?php endif; ?>
					
					<div class="wd_mobile_menu_wrapper hidden-sticky">
						<span class="menu-icon"></span>
					</div>
					
					<div class="header_search hidden-sticky"><?php get_search_form(); ?></div>
					<div class="header-account hidden-sticky">
						<?php echo wd_tini_account(); ?>
					</div>
					<div class="header-currency hidden-sticky">
						<?php 
						wd_header_currency_convert();
						?>
					</div>
					<div class="header-language hidden-sticky">
						<?php do_action('icl_language_selector'); ?>
					</div>
					
					<div class="clear"></div>
				</div>
			</div>
		<?php
		}
	}	
		
	add_action( 'wd_header_init', 'wd_print_header_body', 20 );
	if(!function_exists ('wd_print_header_body')){
		function wd_print_header_body(){
			global $wd_data;
			$header_layout = 'v1';
			if( isset($wd_data['wd_header_layout']) ){
				$header_layout = $wd_data['wd_header_layout'];
			}
	?>	
			<div class="header-middle">
				<div class="wd_mobile_menu_content">
					<?php 
					if ( has_nav_menu( 'mobile' )) {
						wp_nav_menu( array( 'container_class' => 'mobile-menu','theme_location' => 'mobile' ) );
					}else{
						wp_nav_menu( array( 'container_class' => 'mobile-menu','theme_location' => 'primary' ) );
					}
					?>
				</div>
				<div class="header-middle-content container <?php echo ($header_layout != 'v1')?'visible-xs':'' ?>">
					<?php theme_logo(); ?>
					
						<div class="header_woo_content">
							<?php if( $header_layout == 'v1' ): ?>
							<div class="shopping-cart shopping-cart-wrapper visible-phone">
								<?php echo wd_tini_cart();?>
							</div>
							<?php endif; ?>
							<div class="phone_quick_menu_1 visible-xs">
								<div class="mobile_my_account">
									<?php if ( is_user_logged_in() ) { ?>
										<a class="bold-upper-small" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('My Account','wpdance'); ?>"><?php _e('My Account','wpdance'); ?></a>
									<?php }
									else { ?>
										<a class="bold-upper-small" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','wpdance'); ?>"><?php _e('Login / Register','wpdance'); ?></a>
									<?php } ?>
								</div>
							</div>
							<?php if( $header_layout == 'v1' ): ?>
							<div class="mobile_cart_container visible-xs">
								<div class="mobile_cart">
								<?php
									global $woocommerce;
									if( isset($woocommerce) && isset($woocommerce->cart) ){
										$cart_url = $woocommerce->cart->get_cart_url();
										echo "<a class='bold-upper-small' href='{$cart_url}' title='View Cart'>".__('View Cart','wpdance')."</a>";
									}

								?>
								</div>
								<div class="mobile_cart_number">0</div>
							</div>
							<?php endif; ?>
						</div>
					
					<div class="clear"></div>
				</div>
			</div><!-- end .header-middle -->			
		
	<?php	
		}	
	}

	add_action( 'wd_header_init', 'wd_print_header_footer', 30 );
	if(!function_exists ('wd_print_header_footer')){
		function wd_print_header_footer(){
		global $page_datas, $wd_data;
		if( isset($wd_data['wd_header_layout']) && $wd_data['wd_header_layout'] == 'v2' ){
			return;
		}
	?>	
			<div class="header-bottom" id="header-bottom">
				<div class="header-bottom-content container">
					<?php 
					if( isset($wd_data['wd_bottom_header_content']) && strlen(trim($wd_data['wd_bottom_header_content'])) ){
						echo do_shortcode(stripslashes($wd_data['wd_bottom_header_content']));
					}
					?>
				</div>
			</div><!-- end .header-bottom -->

	<?php		
		}	
	}
	
	
	function theme_logo(){
		global $wd_data;
		$logo = strlen(trim($wd_data['wd_logo'])) > 0 ? esc_url($wd_data['wd_logo']) : '';
		$default_logo = get_template_directory_uri()."/images/logo.png";
		$textlogo = stripslashes(esc_attr($wd_data['wd_text_logo']));
	?>
		<div class="logo heading-title">
		<?php if( strlen( trim($logo) ) > 0 ){?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo esc_url($logo); ?>" alt="<?php echo ($textlogo ? esc_attr($textlogo) : get_bloginfo('name'));?>" title="<?php echo ($textlogo ? esc_attr($textlogo) : get_bloginfo('name'));?>"/></a>	
		<?php } else {
			if($textlogo){
			?>
				<a href="<?php  echo home_url();?>" title="<?php echo esc_attr($textlogo); ?>"><?php echo esc_html($textlogo); ?></a>		
			<?php }else{ ?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo esc_url($default_logo); ?>"  alt="<?php echo get_bloginfo('name');?>" title="<?php echo get_bloginfo('name');?>"/></a>
			<?php
			}
		}?>	
		</div>
	<?php 
	}
	function theme_logo_coming(){
		global $wd_data;
		$logo = strlen(trim($wd_data['wd_logo_coming_soon'])) > 0 ? esc_url($wd_data['wd_logo_coming_soon']) : '';
		$default_logo = get_template_directory_uri()."/images/logo-coming-soon.png";
		$textlogo = stripslashes(esc_attr($wd_data['wd_text_logo']));
	?>
		<div class="logo heading-title">
		<?php if( strlen( trim($logo) ) > 0 ){?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo esc_url($logo); ?>" alt="<?php echo ($textlogo ? esc_attr($textlogo) : get_bloginfo('name'));?>" title="<?php echo ($textlogo ? esc_attr($textlogo) : get_bloginfo('name')); ?>"/></a>	
		<?php } else {
			if($textlogo){
			?>
				<a href="<?php  echo home_url();?>" title="<?php echo esc_attr($textlogo); ?>"><?php echo esc_html($textlogo); ?></a>		
			<?php }else{ ?>
				<a href="<?php  echo home_url();?>"><img src="<?php echo esc_url($default_logo); ?>"  alt="<?php echo get_bloginfo('name');?>" title="<?php echo get_bloginfo('name');?>"/></a>
			<?php
			}
		}?>	
		</div>
	<?php 
	}
	
	function theme_logo_fullwidth(){
		global $wd_data;
		$logo = strlen(trim($wd_data['wd_logo_fullwidth'])) > 0 ? esc_url($wd_data['wd_logo_fullwidth']) : '';
		$default_logo = get_template_directory_uri()."/images/logo.png";
		$textlogo = stripslashes(esc_attr($wd_data['wd_text_logo']));
	?>
		<div class="logo heading-title">
		<?php if( strlen( trim($logo) ) > 0 ){?>
				<a href="<?php  echo home_url(); ?>"><img src="<?php echo esc_url($logo); ?>" alt="<?php echo ($textlogo ? esc_attr($textlogo) : get_bloginfo('name')); ?>" title="<?php echo ($textlogo ? esc_attr($textlogo) : get_bloginfo('name')); ?>"/></a>	
		<?php } ?>	
		</div>
	<?php 
	}
	
	function theme_icon(){
		global $wd_data;
		$icon = $wd_data['wd_icon'];
		if( strlen(trim($icon)) > 0 ):?>
			<link rel="shortcut icon" href="<?php echo esc_url($icon);?>" />
		<?php endif;
	}
	
	function wd_header_currency_convert(){
		global $wd_data;
		if( !isset($wd_data['wd_currency_codes']) || strlen($wd_data['wd_currency_codes']) == 0 ){
			return;
		}
		
		$woo_header = isset($wd_data['wd_woo_header']) && $wd_data['wd_woo_header'];
		
		if( $woo_header ){
			if( class_exists('WooCommerce_Widget_Currency_Converter') && class_exists('WooCommerce') ){
				$args = array(
								'title' => ''
								,'currency_codes' => $wd_data['wd_currency_codes']
							);
				$list_currencies = get_woocommerce_currencies();
				$currency_symbol = get_woocommerce_currency_symbol('USD');
				?>
				<div class="currency_control">
					<a href="javascript: void(0)">
						<span class="current_currency"><?php echo get_option( 'woocommerce_currency' ); ?></span>
						<span class="symbol"></span>
					</a>
				</div>
				<div class="currency_dropdown drop_down_container" style="display: none">
					<form method="post">
						<div>
							<?php
								if ( isset($args['message']) && $args['message'] )
									echo wpautop( $args['message'] );

								$currencies = array_map( 'trim', array_filter( explode( "\n", $args['currency_codes'] ) ) );

								if ( $currencies ) {

									echo '<ul class="currency_switcher font-second">';

									foreach ( $currencies as $currency ) {

										$class    = '';

										if ( $currency == get_option( 'woocommerce_currency' ) )
											$class = 'reset default';
										$text_line = '';
										$text_line .= '<span class="name">'.esc_html($currency).'</span>';
										$text_line .= '<span class="symbol">'.esc_html(get_woocommerce_currency_symbol($currency)).'</span>';
										echo '<li><a href="#" class="' . esc_attr( $class ) . '" data-currencycode="' . esc_attr( $currency ) . '">' . $text_line . '</a></li>';
									}

									if ( isset($args['show_reset']) && $args['show_reset'] )
										echo '<li><a href="#" class="reset">' . __('Reset', 'wpdance') . '</a></li>';

									echo '</ul>';
								}
							?>
						</div>
					</form>
				</div>
				<?php
			}
		}
		else{ /* Easycart */
			$currencies = array_map( 'trim', array_filter( explode( "\n", $wd_data['wd_currency_codes'] ) ) );
			$selected_currency = get_option( 'ec_option_base_currency' );
			if( isset( $_SESSION['ec_convert_to'] ) ){
				$selected_currency = $_SESSION['ec_convert_to'];
			}
			?>
			<div class="currency_control">
				<a href="javascript: void(0)">
					<span class="current_currency"><?php echo esc_html($selected_currency); ?></span>
					<span class="symbol">
					<?php 
						$currency_symbol = $GLOBALS['currency']->get_currency_symbol($selected_currency);
						if( !empty($currency_symbol) ){
							$currency_symbol = str_replace($selected_currency.' ', '', $currency_symbol);
						}
						echo esc_html($currency_symbol); 
					?>
					</span>
				</a>
			</div>
			<div class="currency_dropdown drop_down_container ec_currency" style="display: none">
				<form method="post">
					<div>
						<?php
						
							if ( $currencies ) {
								echo '<ul class="currency_switcher font-second">';

								foreach ( $currencies as $currency ) {
									$currency_symbol = $GLOBALS['currency']->get_currency_symbol($currency);
									if( !empty($currency_symbol) ){
										$currency_symbol = str_replace($currency.' ', '', $currency_symbol);
									}
								
									$text_line = '';
									$text_line .= '<span class="name">'.esc_html($currency).'</span>';
									$text_line .= '<span class="symbol">'.esc_html($currency_symbol).'</span>';
									echo '<li><a href="#" data-currencycode="' . esc_attr( $currency ) . '">' . $text_line . '</a></li>';
								}

								echo '</ul>';
							}
						?>
					</div>
					<input type="hidden" value="" name="ec_currency_conversion" />
				</form>
			</div>
			<?php
		}
	}
?>