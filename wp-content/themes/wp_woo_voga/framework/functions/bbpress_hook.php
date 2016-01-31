<?php
if (!function_exists('wd_bbp_breadcrumb')) {
	function wd_bbp_breadcrumb(){
		$args = array('before' => '<div class="bbp-breadcrumb container"><p>');
		echo bbp_get_breadcrumb( $args );
	}
}	
?>