<?php 
// **********************************************************************// 
// ! Register New Element: Feedburner Subscription shortcode
// **********************************************************************//
if (!function_exists('wd_feedburner_shortcode')) {
	function wd_feedburner_shortcode($atts, $content = null) {
		
		$args = array(
            "feedburner"                => "wpdance",
            "intro"                     => "",
			"button_text"				=> "notify me",
            "background_color"          => "#14679d",
			"text_color"                => "#ffffff",
        );
        
        extract(shortcode_atts($args, $atts));
		
		$html = '';
		if(strlen(trim($intro)) > 0){
			$intro = '<div class="newsletter">'.$intro.'</div>';
		}
		$html .='<div class="subscribe_widget">'.$intro.
				'<form class="subscribe_form" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(\'http://feedburner.google.com/fb/a/mailverify?uri='.$feedburner.'\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true">
					<p class="subscribe-email"><input type="text" name="email" class="subscribe_email" data-default="'.__('Put your email address here...','wpdance').'" value="" /></p>
					<input type="hidden" value="'.$feedburner.'" name="uri"/>
					<input type="hidden" value="'.get_bloginfo( 'name' ).'" name="title"/>
					<input type="hidden" name="loc" value="en_US"/>';
				
		if((strlen(trim($background_color)) > 0) && (strlen(trim($text_color)) > 0)){
			$button_out = 'style="';
			
			$button_out .= 'background:'.$background_color.';';
			
			$button_out .= 'color:'.$text_color.';';

			$button_out .= '"';

		}
		$html .= '<button class="button big" '.$button_out.' type="submit" title="submit">'.$button_text.'</button>';		
		$html .='</form></div>';
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				"use strict";
				
				var subscribe_input = jQuery(".subscribe_widget input.subscribe_email");
				var value_default = subscribe_input.attr('data-default');
				subscribe_input.val(value_default);
				subscribe_input.click(function(){
					if( jQuery(this).val() === value_default ) jQuery(this).val("");
				});
				subscribe_input.blur(function(){
					if( jQuery(this).val() === "" ) jQuery(this).val(value_default);
				});
			});
		</script>
		<?php 
		return $html;
	}
}
add_shortcode('wd_feedburner', 'wd_feedburner_shortcode');
?>