<?php

if(!function_exists('menu_function')){
	function menu_function($atts){
		extract(shortcode_atts(array(
				'menu' => ''
				,'depth' => 1
		),$atts));

		ob_start();
		wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $menu, 'depth' => $depth ) );					
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
}
add_shortcode('menu','menu_function');
?>