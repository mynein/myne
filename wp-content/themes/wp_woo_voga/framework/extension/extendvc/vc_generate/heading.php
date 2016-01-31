<?php

// **********************************************************************// 

// ! Register New Element: WD Heading

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Heading
// **********************************************************************//
$heading_params = array(
	"name" => "Heading",
	"base" => "wd_heading",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
	
		// Heading
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Size", "wpdance"),
			"admin_label" => true,
			"param_name" => "size",
			"value" => "1",
			"description" => "",
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style", "wpdance"),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
				"Default" => "style-default",
				"Widget" => "style-widget"
			),
			"description" => ""
		),
		array(
			"type" => "colorpicker",
			"class" => "",
			"heading" => __("Border color", "wpdance"),
			"admin_label" => true,
			"param_name" => "border_color",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Content", "wpdance"),
			"admin_label" => true,
			"param_name" => "content",
			"value" => "",
			"description" => "",
		),
	)
);
vc_map( $heading_params );
?>