<?php
/**
 * Login Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.6
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php wc_print_notices(); ?>

<?php do_action('woocommerce_before_customer_login_form'); ?>

<?php if (get_option('woocommerce_enable_myaccount_registration')=== 'yes') : ?>

<div class="col2-set" id="customer_login">

	<div class="col login_wrapper">

<?php endif; ?>
	<div class="customer_login login active">
		<h3><?php _e( 'Login', 'wpdance' ); ?></h3>
		
		<?php if (get_option('woocommerce_enable_myaccount_registration')=== 'yes') : ?>
			<p class="bold login_desc"><?php _e('Please enter your email address and password to login, or <a title="register" id="wd_login" href="#">click here</a> to register.','wpdance') ?></p>
		<?php else : ?>
			<p class="bold login_desc"><?php _e('Please enter your email address and password to login','wpdance') ?></p>
		<?php endif; ?>
		
		
		<form method="post" class="login">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
			<div class="image_login"><img title="<?php _e('register','wpdance') ?>" alt="<?php _e('register','wpdance') ?>" src="<?php echo get_template_directory_uri().'/images/bg-login.png' ?>" /></div>
			<p class="form-row form-row-first">
				<label for="username"><?php _e( 'Your email address', 'wpdance' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="username" id="username" />
			</p>
			<p class="form-row form-row-last">
				<label for="password"><?php _e( 'Your password', 'wpdance' ); ?> <span class="required">*</span></label>
				<input class="input-text" type="password" name="password" id="password" />
			</p>
			<div class="clear"></div>
			
			<?php do_action( 'woocommerce_login_form' ); ?>
			
			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login' ); ?>
				<input type="submit" class="button" name="login" value="<?php _e( 'Login', 'wpdance' ); ?>" />
				<label class="rememberme" for="rememberme" class="inline">
					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'wpdance' ); ?>
				</label>
				<p class="lost_password">
					<a class="bold-upper-small" href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Forgot password?', 'wpdance' ); ?></a>
				</p>
			</p>
			
			<?php do_action( 'woocommerce_login_form_end' ); ?>
			
		</form>
	</div>
<?php if (get_option('woocommerce_enable_myaccount_registration')=='yes') : ?>
	</div><!-- close div .login_wrapper -->
		<div class="col register_wrapper">
		
			<div class="customer_login register">
			
				<h3><?php _e( 'register', 'wpdance' ); ?></h3>

				<p class="bold login_desc"><?php _e('Please enter your email address and password to register, or <a id="wd_register" title="login" href="#"> click here</a> to login.','wpdance') ?>
				
				<form method="post" class="register">
					<?php do_action( 'woocommerce_register_form_start' ); ?>
					<div class="image_register"><img title="<?php _e('register','wpdance') ?>" alt="<?php _e('register','wpdance') ?>" src="<?php echo get_template_directory_uri().'/images/bg-register.png' ?>" /></div>
					<?php if ( get_option( 'woocommerce_registration_generate_username' ) == 'no' ) : ?>

						<p class="form-row form-row-first">
							<label for="reg_username"><?php _e( 'username', 'wpdance' ); ?> <span class="required">*</span></label>
							<input type="text" class="input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
						</p>

						<p class="form-row form-row-last">

					<?php else : ?>

						<p class="form-row form-row-wide">

					<?php endif; ?>

						<label for="reg_email"><?php _e( 'Your email address', 'wpdance' ); ?> <span class="required">*</span></label>
						<input type="email" class="input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
					</p>

					<div class="clear"></div>
					
					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
					
					<p class="form-row form-row-wide">
						<label for="reg_password"><?php _e( 'Your password', 'wpdance' ); ?> <span class="required">*</span></label>
						<input type="password" class="input-text" name="password" id="reg_password" value="<?php if ( ! empty( $_POST['password'] ) ) echo esc_attr( $_POST['password'] ); ?>" />
					</p>

					<?php endif; ?>
					
					<div class="clear"></div>

					<!-- Spam Trap -->
					<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'wpdance' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

					<?php do_action( 'woocommerce_register_form' ); ?>
					<?php do_action( 'register_form' ); ?>
					
					<p class="form-row">
						<?php wp_nonce_field( 'woocommerce-register' ); ?>
						<input type="submit" class="button" name="register" value="<?php _e( 'Register', 'wpdance' ); ?>" />
					</p>
					
					<?php do_action( 'woocommerce_register_form_end' ); ?>
					
				</form>

			</div>
		</div>

</div>
<?php endif; ?>

<?php do_action('woocommerce_after_customer_login_form'); ?>