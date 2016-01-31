<?php 
if(!function_exists ('wd_button_function')){
	function wd_button_function($atts,$content){
		extract(shortcode_atts(array(
			'font_size'				=> 14
			,'color'				=> ''
			,'color_hover'			=> ''
			,'margin'     			=> ''
			,'padding'				=> ''
			,'link'					=> ''
			,'bg_color'				=> ''
			,'bg_color_hover'		=> ''
			,'opacity'				=> 100
			,'border_width'			=> ''
			,'border_color'			=> ''
			,'border_color_hover'	=> ''
			,'custom_class'			=> ''
		),$atts));
		
		static $wd_button_index = 0;
		$wd_button_index++;

		$custom_class = (!empty($custom_class)) ? " {$custom_class}" : '';
		
		$classes = array();
		$classes[] = $custom_class;
		
		$styles_hover = '';
		$styles = '';
		
		if( $font_size != '' ){
			$styles .= 'font-size:'. $font_size .(is_numeric($font_size)?'px':'').';';
			$styles_hover .= 'font-size:'. $font_size .(is_numeric($font_size)?'px':'').';';
		}
		
		if( $color != '' ){
			$styles .= 'color:'. $color .';';
			$styles_hover .= 'color:'. $color_hover .';';
		}
		elseif(( $color == '' ) && ( $color_hover != '' )){
			$styles .= 'color:#fff;';
			$styles_hover .= 'color:'. $color_hover .';';
		}
		elseif(( $color != '' ) && ( $color_hover == '' )){
			$styles .= 'color:'. $color .';';
			$styles_hover .= 'color:#fff;';
		}
		else{
			$styles .= 'color:#fff;';
			$styles_hover .= 'color:#fff;';
		}
		
		if(( $bg_color != '') && ( $bg_color_hover != '')){
			$styles .= 'background-color:'. $bg_color .';';
			$styles_hover .= 'background-color:'. $bg_color_hover .';';
		}
		elseif (( $bg_color != '') &&  ( $bg_color_hover == '')){
			$styles .= 'background-color:'. $bg_color .';';
			$styles_hover .= 'background:transparent;';
		}
		elseif (( $bg_color == '') &&  ( $bg_color_hover != '')){
			$styles .= 'background:transparent;';
			$styles_hover .= 'background-color:'. $bg_color_hover .';';
		}
		else{
			$styles .= 'background:transparent;';
			$styles_hover .= 'background:transparent;';
		}
		if ( $margin != '' ) {
			$styles .= 'margin:'. $margin .';';
			$styles_hover .= 'margin:'. $margin .';';
		}
		if( $padding != '' ){
			$styles .= 'padding:'. $padding .';';
			$styles_hover .= 'padding:'. $padding .';';
		}
		
		if( $border_width != ''	){
			$styles .= 'border-width:'. $border_width .(is_numeric($border_width)?'px':'').';';
			$styles_hover .= 'border-width:'. $border_width .(is_numeric($border_width)?'px':'').';';
		}
		
		if( $border_color != ''	){
			$styles .= 'border-color:'. $border_color .';';
			$styles_hover .= 'border-color:'. $border_color_hover .';';
		}
		
		if( !is_numeric($opacity) )
			$opacity = 100;
		$opacity = (int)$opacity;
		if( $opacity >= 0 && $opacity <= 100 ){
			$styles .= 'opacity:'. ($opacity/100) .';';
			$styles .= 'filter:alpha(opacity='. $opacity .');';
			$styles_hover .= 'opacity:'. ($opacity/100) .';';
			$styles_hover .= 'filter:alpha(opacity='. $opacity .');';
		}
		
		
		$classes[] = 'wd-shortcode-button-'.$wd_button_index;
		$classes = implode( ' ', $classes );
		
		ob_start();
		
		if( strlen(trim($link)) > 0 ){
			echo '<a class="wd-shortcode-button ' . esc_attr( $classes ) . '" href="' . esc_url($link) . '"' . '>' . do_shortcode($content) . '</a>';
		}
		else{
			echo '<button class="wd-shortcode-button '. esc_attr( $classes ) . '">' . do_shortcode($content) . '</button>';	
		}
		
		echo '<style type="text/css">';
		echo '.wd-shortcode-button-'.$wd_button_index.'{'.$styles.'}';
		echo '.wd-shortcode-button-'.$wd_button_index.':hover{'.$styles_hover.'}';
		echo '</style>';
		
		return ob_get_clean();
	}
}
add_shortcode('wd_button','wd_button_function');


if(!function_exists ('wd_button_group_function')){
	function wd_button_group_function($atts,$content){
		extract(shortcode_atts(array(
			'vertical' => 0
		),$atts));
		$_vertical = '';
		if( $vertical == 1 )
			$_vertical = " btn-group-vertical";
			
		return "<div class='btn-toolbar'><div class='btn-group{$_vertical}'>".do_shortcode($content)."</div></div>";
	}
}
add_shortcode('wd_button_group','wd_button_group_function');
?>