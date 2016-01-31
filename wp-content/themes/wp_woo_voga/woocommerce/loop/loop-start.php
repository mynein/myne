<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce_loop, $wd_data;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
$_grid_clas = " columns-4";
if( absint($wd_data['wd_prod_cat_column']) > 0 ){
	$_columns = absint($wd_data['wd_prod_cat_column']);
	$_grid_clas = " columns-".$_columns;
}else{
	$_columns = absint($woocommerce_loop['columns']);
	$_grid_clas = " columns-".$_columns;
}
	
 ?>
<div class="products<?php echo $_grid_clas; ?>">