<?php
// **********************************************************************// 
// ! Register New Element: Feedburner Subscription
// **********************************************************************//
vc_map( array(
		"name" => "Feedburner Subscription",
		"base" => "wd_feedburner",
		"icon" => "icon-wpb-wpdance",
		"category" => "WPDance Elements",
		"allowed_container_element" => 'vc_row',
		"params" => array(
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Feedburner ID", "wpdance"),
				"param_name" => "feedburner",
				"value" => "",
				"description" => ""
			),
			array(
				"type" => "textarea_html",
				"holder" => "div",
				"class" => "",
				"heading" => __("Content", "wpdance"),
				"param_name" => "intro",
				"value" => "",
				"description" => "Ex:Sign-up for our newsletter. We promise only send good news!"
			),			
			
			// Custom button
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Button text", "wpdance"),
				"param_name" => "button_text",
				"description" => "Ex:notify me"
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background button color", "wpdance"),
				"param_name" => "background_color",
				"value" => "#14679d",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Text button color", "wpdance"),
				"param_name" => "text_color",
				"value" => "#ffffff",
				"description" => ""
			),
			
			
		)
) );
?>