<?php 

if(!function_exists ('hightlight_text')){
	function hightlight_text($atts,$content){
		extract(shortcode_atts(array(
			'background'=>'000'
		),$atts));
		return "<span style='background-color:{$background};padding-left:2px'>{$content}</span>";
	}
}
add_shortcode('hightlight_text','hightlight_text');

if(!function_exists ('add_line')){
	function add_line($atts)
	{
		extract(shortcode_atts(array(
						'height_line'	=>	'1'
						,'color'		=>	'black'
						,'class'		=>	''
		),$atts));
		return "<p class='add-line' class='{$class}' style='width:100%;height:{$height_line}px;background-color:{$color};text-indent:-9999px'>wpdance</p>";

	}
}
add_shortcode('add_line','add_line');



if(!function_exists ('wd_icon_function')){
	function wd_icon_function($atts)
	{
		$default_atts = array(
            "title"                => "", 
            "size"                 => "", 
            "custom_size"          => "", 
            "icon"                 => "", 
            "type"                 => "", 
            "background_color"     => "", 
            "border_width"         => "", 
            "border_color"         => "", 
            "icon_color"           => "", 
            "margin"               => "",
            "css_animation"        => "",
            "link"                 => "",
            "target"               => "",
            "distance"             => "",
            "class"                => ""
        );
        
        extract(shortcode_atts($default_atts, $atts));
        
        $html = "";
        if($icon != "") {
        
            //generate inline icon styles
            $style = '';
            $style_normal = '';
            //$icon_stack_classes = '';
            $animation_delay_style = '';
            
            //generate icon stack styles
            $icon_stack_style = '';
            $icon_stack_base_style = '';
            $icon_stack_circle_styles = '';
            $icon_stack_square_styles = '';
            $icon_stack_normal_style  = '';

            if($custom_size != "") {
                $style .= 'font-size: '.$custom_size;
                $icon_stack_circle_styles .= 'font-size: '. ( $custom_size + intval($distance) );
                $icon_stack_square_styles .= 'font-size: '.$custom_size;
                
                if(!strstr($custom_size, 'px')) {
                    $style .= 'px;';
                    $icon_stack_circle_styles .= 'px;';
                    $icon_stack_square_styles .= 'px;';
                }
            }

            if($icon_color != "") {
                $style .= 'color: '.$icon_color.';';
            }
			
			if($background_color != "") {
                $icon_stack_base_style .= 'color: '.$background_color.';';
                $icon_stack_style .= 'background-color: '.$background_color.';';
                $icon_stack_square_styles .= 'background-color: '.$background_color.';';
            }

            if( $border_width != '' && $border_color != "") {
				$icon_stack_style .= 'border-width:'.$border_width.(is_numeric($border_width)?'px':'').';';
                $icon_stack_style .= 'border-color: '.$border_color.';';
				$icon_stack_style .= 'border-style: solid;';
            }
            
            if($margin != "") {
                $icon_stack_style .= 'margin: '.$margin.(is_numeric($margin)?'px':'').';';
                $icon_stack_circle_styles .= 'margin: '.$margin.(is_numeric($margin)?'px':'').';';
                $icon_stack_normal_style .= 'margin: '.$margin.(is_numeric($margin)?'px':'').';';
            }
			
			$css_animation = WPBakeryShortCode_Settings::getCSSAnimation($css_animation);
			
            switch ($type) {
                case 'circle':
                    $html = '<span class="fa-stack wd_font_awsome_icon_stack '.$size.' '.$css_animation.'" style="'.$icon_stack_circle_styles.'">';
                    if($link != ""){
                        $html .= '<a href="'.$link.'" target="'.$target.'">';
                    }
                    $html .= '<i class="fa fa-circle fa-stack-base fa-stack-2x" style="'.$icon_stack_base_style.'"></i>';
                    $html .= '<i class="fa '.$icon.' fa-stack-1x" style="'.$style.'"></i>';
                    break;
                case 'square':
                    $html = '<span class="fa-stack wd_font_awsome_icon_square '.$size.' '.$css_animation.'" style="'.$icon_stack_style.$icon_stack_square_styles.'">';
                    if($link != ""){
                        $html .= '<a href="'.$link.'" target="'.$target.'">';
                    }
                    $html .= '<i class="fa '.$icon.' fa-stack-1x" style="'.$style.'"></i>';
                    break;
                default:
                    $html = '<span class="wd_font_awsome_icon '.$size.' '.$css_animation.'" style="'.$icon_stack_normal_style.'">';
                    if($link != ""){
                        $html .= '<a href="'.$link.'" target="'.$target.'">';
                    }
                    $html .= '<i class="fa '.$icon.' fa-stack-1x" style="'.$style.'"></i>';
                    break;
            }

            if($link != ""){
                $html .= '</a>';
            }

            $html.= '</span>';
        }

		if($class != '')
			$html = '<span class="'. $class .'">' . $html . '</span>';
		
		if($title != "") {
			
			$html = '<div class="icon-wrapper"><span class="icon-item">' . $html . '</span><span class="h4 icon-item">'.$title.'</span></div>';
		}
		
        return $html;

	}
}

add_shortcode('wd_icon','wd_icon_function');

if(!function_exists ('hide_phone_function')){
	function hide_phone_function($atts,$content){
		return "<div class='hidden-phone'>".do_shortcode($content)."</div>";
	}
}

add_shortcode('hidden_phone','hide_phone_function');


if(!function_exists ('dropcap_function')){
	function dropcap_function($atts,$content)
	{
		extract(shortcode_atts(array(
						'color'=>'',
						'dropcap' => ''
		),$atts));
		if( strlen($color) > 0 ){
			$inline_css = " style=\"color:{$color}\"";
		}
		return "<span><span class=\"dropcap\"{$inline_css}>{$dropcap}</span>{$content}</span>";

	}
}
add_shortcode('dropcap','dropcap_function');
?>