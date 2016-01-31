<?php

// **********************************************************************// 

// ! Register New Element: WD Button

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Button
// **********************************************************************//

$button_params = array(
	"name" => "Button",
	"base" => "wd_button",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Font size", "wpdance"),
			"admin_label" => true,
			"param_name" => "font_size",
			"value" => '14',
			"description" => __("In Pixels. Text font size", "wpdance"),
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text Color", "wpdance"),
			"admin_label" => true,
			"param_name" => "color",
			"value" => '',
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Text Color On Hover", "wpdance"),
			"admin_label" => true,
			"param_name" => "color_hover",
			"value" => '',
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background Color", "wpdance"),
			"admin_label" => true,
			"param_name" => "bg_color",
			"value" => '',
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Background Color On Hover", "wpdance"),
			"admin_label" => true,
			"param_name" => "bg_color_hover",
			"value" => '',
			"description" => ""
		),
		
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Color", "wpdance"),
			"admin_label" => true,
			"param_name" => "border_color",
			"value" => '',
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border Color On Hover", "wpdance"),
			"admin_label" => true,
			"param_name" => "border_color_hover",
			"value" => '',
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Border Width", "wpdance"),
			"admin_label" => true,
			"param_name" => "border_width",
			"value" => '0',
			"description" => "EX: 1,2,3,.."
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Margin", "wpdance"),
			"admin_label" => true,
			"param_name" => "margin",
			"value" => '',
			"description" => "EX: 15px 20px 15px 20px (top right bottom left)",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding", "wpdance"),
			"admin_label" => true,
			"param_name" => "padding",
			"value" => '',
			"description" => "15px 20px 15px 20px (top right bottom left)",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link", "wpdance"),
			"admin_label" => true,
			"param_name" => "link",
			"value" => '',
			"description" => __("Input URL you want it to link to", "wpdance"),
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Opacity", "wpdance"),
			"admin_label" => true,
			"param_name" => "opacity",
			"value" => '100',
			"description" => __("Input Opacity Number. Min: 0, Max: 100", "wpdance")
		),
		
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Text", "wpdance"),
			"admin_label" => true,
			"param_name" => "content",
			"value" => "",
			"description" => "",
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Custom Class", "wpdance"),
			"admin_label" => true,
			"param_name" => "custom_class",
			"value" => '',
			"description" => "",
		),
		
	)
);
vc_map( $button_params );
?>