<?php 
// Show jquery ui tabs
if(!function_exists ('wd_tabs_function')){
	function wd_tabs_function($atts,$content){
		extract(shortcode_atts(array(
			'style'	=>	'default1',
			'color'	=>	'',
		),$atts));
		$temp = '';
		if($style=='default1'){
			$style = 'default';
			$temp = 'style1';
		}
		if($style=='default2'){
			$style = 'default';
			$temp = 'style2';
		}
		if($style=='left'){
			$style = 'left';
		}
		if($style=='right'){
			$style = 'right';
		}
		$id = 'multitabs_'.rand();
		$inside_id = $id.'_inside';
		$result = "<div class='tabbable wd-{$color} tabs-{$style} {$temp}'  id='{$id}'>\n\t";
		
		$tabs_match = preg_match_all('/\[tab_item\s*?title="(.*?)"\](.*?)\[\/tab_item\]/ism',$content,$match);
		if( $tabs_match && is_array($match) && count($match) > 0 ){
			$_title_contents = '';
			$_tabs_contents = '';
			$_init_class_title = 'active';
			$_init_class_content = 'active in';
			$check = '';
			for( $_count = 0 ; $_count < count($match[0]) ; $_count++ ){
				$_content_id = $inside_id.$_count;
				$_inside_content = do_shortcode($match[2][$_count]);
				if($_count + 1 == count($match[0])){
					$check = 'last ';
				}
				$match[1][$_count] = strlen( $match[1][$_count] ) <= 0 ? 'Tab title' : $match[1][$_count];
				$_title_contents .= "\n\t\t\t<li class=\"{$check}{$_init_class_title}\"><a href=\"#{$_content_id}\" data-toggle=\"tab\">{$match[1][$_count]}</a></li>";
				$_tabs_contents .= "\n\t\t\t<div class=\"tab-pane fade {$_init_class_content}\" id=\"{$_content_id}\">{$_inside_content}</div>";
				$_init_class_title = $_init_class_content = '';
			}
			$_title_contents = "\n\t\t<ul class=\"nav nav-tabs\" id=\"{$inside_id}\">".$_title_contents."\n\t\t</ul>";
			$_tabs_contents = "\n\t\t<div class=\"tab-content\" id=\"{$inside_id}Content\">".$_tabs_contents."\n\t\t</div>";
		}
		$result .= $_title_contents.$_tabs_contents."\n\t</div>";
		
		return $result;
	}
}
add_shortcode('wd_tabs','wd_tabs_function');
?>