<?php
/**
 * @package WordPress
 * @subpackage Voga
 * @since voga
 **/
$_template_path = get_template_directory();
require_once $_template_path."/framework/abstract.php";
$theme = new WdTheme(array(
	'theme_name'	=>	"Voga",
	'theme_slug'	=>	'voga'
));
$theme->init();
require_once ('admin/index.php');
function woocommerce_paypal_args_for_inr($paypal_args){
    if ( $paypal_args['currency_code'] == 'INR'){

        $convert_rate = 70;

        $count = 1;
        while( isset($paypal_args['amount_' . $count]) ){
            $paypal_args['amount_' . $count] = round( $paypal_args['amount_' . $count] / $convert_rate, 2);
            $count++;
        }
 $paypal_args['tax_cart'] = round( $paypal_args['tax_cart'] / $convert_rate, 2);
    }
    return $paypal_args;
}
add_filter('woocommerce_paypal_args', 'woocommerce_paypal_args_for_inr');
?>
