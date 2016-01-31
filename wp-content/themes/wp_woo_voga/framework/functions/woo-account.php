<?php

if ( ! function_exists( 'wd_tini_account' ) ) {
	function wd_tini_account(){
		global $wd_data;
		
		$woo_header = isset($wd_data['wd_woo_header']) && $wd_data['wd_woo_header'];
		$has_woocommerce = true;
		
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
			$has_woocommerce = false;
		}
		
		ob_start();
		
		if( $woo_header && $has_woocommerce ){
			global $woocommerce;
			$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
			if ( $myaccount_page_id ) {
			  $myaccount_page_url = get_permalink( $myaccount_page_id );
			}
			else{
				$myaccount_page_url = '';
			}
			
			$_user_logged = is_user_logged_in();
			
			?>
			<?php do_action( 'wd_before_tini_account' ); ?>
			
			
			<div class="wd_tini_account_wrapper">
				<div class="wd_tini_account_control">
				
					<a href="<?php echo esc_url($myaccount_page_url); ?>" title="<?php _e('My Account','wpdance');?>">
						<?php if(is_user_logged_in()): ?>	
							<span><?php _e('My Account','wpdance');?></span>
						<?php else:?>
							<span><?php _e('Login / Register','wpdance');?></span>
						<?php endif;?>	
						<i class="fa fa-user"></i>
					</a>	
				
				</div>
				<div class="form_drop_down drop_down_container <?php echo ($_user_logged ? "hidden" : "");?>">
					<?php 
						if( !$_user_logged ):
					?>
						
						<div class="form_wrapper">				
							<div class="form_wrapper_body">
								<form method="post" class="login" id="loginform-custom" action="<?php echo esc_url(wp_login_url()); ?>" >
				
									<?php do_action( 'woocommerce_login_form_start' ); ?>
									<p class="login-username">
										<label for="log"><?php _e( 'User or Email', 'wpdance' ); ?><span class="required">*</span></label>
										<input type="text" size="20" value="" class="input" id="log" name="log">
									</p>
									<p class="login-password">
										<label for="pwd"><?php _e( 'Password', 'wpdance' ); ?> <span class="required">*</span></label>
										<input type="password" size="20" value="" class="input" id="pwd" name="pwd">
									</p>
									
									<div class="clear"></div>
									
									<?php do_action( 'woocommerce_login_form' ); ?>											
									
									<p class="login-submit">
										<input type="submit" class="button-body button big" name="login" value="<?php _e( 'Login', 'wpdance' ); ?>" />
									</p>
									
									<?php do_action( 'woocommerce_login_form_end' ); ?>
									
								</form>
							</div>
							<div class="form_wrapper_footer">
								<p><strong><a class="forgot-password bold" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Forgot password?','wpdance'); ?></a></strong></p>
								<p><strong><a class="register-button bold" href="<?php echo esc_url($myaccount_page_url); ?>"><?php _e('Register new account','wpdance'); ?></a></strong></p>
							</div>
						</div>	
					<?php else: ?>	
						<span class="my_account_wrapper"><a href="<?php echo admin_url( 'profile.php', 'https' ); ?>" title="<?php _e('My Account','wpdance');?>"><?php _e('My Account','wpdance');?></a></span>
						<span class="logout_wrapper"><a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Logout','wpdance');?>"><?php _e('Logout','wpdance');?></a></span>
					<?php
						endif
					?>
				</div>
			</div>
			<?php do_action( 'wd_after_tini_account' ); ?>
			<?php
		}
		else{
			
			if( !class_exists('ec_accountpage') ){
				return '';
			}
		
			$accountpage_id = get_option('ec_option_accountpage');
			if( function_exists( 'icl_object_id' ) ){
				$accountpage_id = icl_object_id( $accountpage_id, 'page', true, ICL_LANGUAGE_CODE );
			}
			$accountpage_url = get_permalink( $accountpage_id );
			
			if( class_exists( "WordPressHTTPS" ) && isset( $_SERVER['HTTPS'] ) ){
				$https_class = new WordPressHTTPS( );
				$accountpage_url = $https_class->makeUrlHttps( $accountpage_url );
			}
			
			$_user_logged = isset( $_SESSION['ec_password'] ) && $_SESSION['ec_password'] != "guest";
			
			if( substr_count( $accountpage_url, '?' ) ){
				$permalink_divider = "&";
			}
			else{
				$permalink_divider = "?";
			}
			
			$forgot_password_url = $accountpage_url . $permalink_divider . 'ec_page=forgot_password';
			$register_url = $accountpage_url . $permalink_divider . 'ec_page=register';
			$logout_url = $accountpage_url . $permalink_divider . 'ec_page=logout';
			$profile_url = $accountpage_url . $permalink_divider . 'ec_page=dashboard';
			?>
			<?php do_action( 'wd_before_tini_account' ); ?>
			
			
			<div class="wd_tini_account_wrapper">
				<div class="wd_tini_account_control">
					<a href="<?php echo esc_url($accountpage_url); ?>" title="<?php _e('My Account', 'wpdance'); ?>">
						<?php if( $_user_logged ): ?>	
							<span><?php _e('My Account','wpdance');?></span>
						<?php else:?>
							<span><?php _e('Login / Register','wpdance');?></span>
						<?php endif;?>	
						<i class="fa fa-user"></i>
					</a>	
				</div>
				<div class="form_drop_down drop_down_container <?php echo ($_user_logged ? "hidden" : "");?>">
					<?php 
						if( !$_user_logged ):
					?>
						
						<div class="form_wrapper">				
							<div class="form_wrapper_body">
								<form method="post" class="login" id="loginform-custom" action="<?php echo esc_url($accountpage_url); ?>" >
				
									<p class="login-username">
										<label><?php _e( 'Email address', 'wpdance' ); ?><span class="required">*</span></label>
										<input type="text" size="20" value="" class="input" name="ec_account_login_email">
									</p>
									<p class="login-password">
										<label><?php _e( 'Password', 'wpdance' ); ?> <span class="required">*</span></label>
										<input type="password" size="20" value="" class="input" name="ec_account_login_password">
									</p>
									
									<div class="clear"></div>									
									
									<p class="login-submit">
										<input type="submit" class="button-body button big" name="login" value="<?php _e( 'Login', 'wpdance' ); ?>" />
										<input type="hidden" name="ec_account_form_action" value="login">
									</p>
									
								</form>
							</div>
							<div class="form_wrapper_footer">
								<p><strong><a class="forgot-password bold" href="<?php echo esc_url($forgot_password_url); ?>"><?php _e('Forgot password?','wpdance'); ?></a></strong></p>
								<p><strong><a class="register-button bold" href="<?php echo esc_url($register_url); ?>"><?php _e('Register new account','wpdance'); ?></a></strong></p>
							</div>
						</div>	
					<?php else: ?>	
						<span class="my_account_wrapper"><a href="<?php echo esc_url($profile_url); ?>" title="<?php _e('My Account','wpdance');?>"><?php _e('My Account','wpdance');?></a></span>
						<span class="logout_wrapper"><a href="<?php echo esc_url($logout_url); ?>" title="<?php _e('Logout','wpdance');?>"><?php _e('Logout','wpdance');?></a></span>
					<?php
						endif
					?>
				</div>
			</div>
			<?php do_action( 'wd_after_tini_account' ); ?>
			<?php
		}
		$tini_account = ob_get_clean();
		return $tini_account;
	}
}

if ( ! function_exists( 'wd_update_tini_account' ) ) {
	function wd_update_tini_account() {
		die($_tini_account_html = wd_tini_account());
	}
}



function wd_login_fail( $username ) {
	if(isset( $_REQUEST['redirect_to']) && ($_REQUEST['redirect_to'] == admin_url())){
		return;
	}
	if(isset( $_REQUEST['redirect_to']) && strripos($_REQUEST['redirect_to'],'wp-admin') > 0 ){
		return;
	}
	$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
	if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
		return 'Woocommerce Plugin do not active';
	}
	global $woocommerce;
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	if ( $myaccount_page_id ) {
		$myaccount_page_url = get_permalink( $myaccount_page_id );
		wp_safe_redirect( $myaccount_page_url );
		exit;
	}		
}
add_action( 'wp_login_failed', 'wd_login_fail' );  // hook failed login
add_action('wp_ajax_update_tini_account', 'wd_update_tini_account');
add_action('wp_ajax_nopriv_update_tini_account', 'wd_update_tini_account');

?>
