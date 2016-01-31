<?php 
if(!function_exists ('heading_function')){
	function heading_function($atts, $content = null){
		extract(shortcode_atts(array(
			'size' 			=> '1',
			'style' 		=> 'style-default', /*style-default, style-widget*/
			'border_color' 	=> '',
		), $atts));
		static $wd_heading_number = 1;
		$unique_class = 'heading-title-block-'.$wd_heading_number;
		$wd_heading_number++;
		
		if( !empty($border_color) ){
			$style_inline = ".{$unique_class} h{$size}{border-color:{$border_color};}";
			$style_inline .= ".{$unique_class}:before{border-color:{$border_color};}";
		}
		
		$html = "<div class='heading-title-block {$unique_class} {$style}'><h{$size}>".do_shortcode($content)."</h{$size}></div>";
		
		if( !empty($style_inline) ){
			$html .= '<style type="text/css">';
			$html .= $style_inline;
			$html .= '</style>';
		}
		
		return $html;
	}
}
add_shortcode('wd_heading','heading_function');



if(!function_exists ('checklist_function')){
	function checklist_function($atts, $content){
		extract(shortcode_atts(array(
			'icon' 		=> 'none',
		), $atts));
		
		$icon = trim($icon);
		
		$match = preg_match('/.*?<ul>(.*?)<\/ul>.*?/ism',$content,$content_match);
		if( $match ){
			$math = preg_match_all('/<li>(.*?)<\/li>/ism',$content,$content_match);
			if( $math ){
				$new_string = "<li><i class=\"{$icon}\"></i>";
				$content = str_replace ( "<li>" , $new_string , $content );
			}
		}
		

		return "<div class='checklist-block shortcode-icon-list shortcode-icon-{$icon}'>".do_shortcode($content)."</div>";
	}
}
add_shortcode('wd_checklist','checklist_function');
?>