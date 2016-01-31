<?php 
if(!function_exists ('wd_progress_function')){
	function wd_progress_function($atts,$content){
		extract(shortcode_atts(array(
			'animated_bars' => '0'
			,'striped_bars' => '0'
		),$atts));
		$class = '';
		if( (int)$animated_bars == 1 ){
			$class .= ' active';
		}
		if( (int)$striped_bars == 1 ){
			$class .= ' progress-striped';
		}
		$_bars_html = '';
		$bars_match = preg_match_all('/\[bar(.*?)"\](.*?)\[\/bar\]/ism',$content,$match);
		if( $bars_match && is_array($match) && count($match) > 0 ){
			foreach( $match[0] as $index => $bar_code){
				$_bars_html .= do_shortcode($bar_code);
			}
		}
		$result="<div class='progress {$class}'>{$_bars_html}</div>";
		return $result;
	}
}
add_shortcode('wd_progress','wd_progress_function');

if(!function_exists ('bar_code')){
	function bar_code($atts,$content){
		extract(shortcode_atts(array(
			'color' => ''
			,'percent_bars' => '10'
		),$atts));
		$result="<div class=\"bar {$color}\" style=\"width: {$percent_bars}%;\">".do_shortcode($content)."</div>";
		return $result;
	}
}

add_shortcode('bar','bar_code');



?>
