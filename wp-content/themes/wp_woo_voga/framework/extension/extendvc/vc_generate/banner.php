<?php
// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 

// ! Register New Element: WD BANNER

// **********************************************************************//

$specipic_product_params = array(
	"name" => "Banner",
	"base" => "banner",
	"icon" => "icon-wpb-wpdance",
	"category" => 'WPDance Elements',
	"params" => array(
	
		// Heading
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Sub title", "wpdance"),
			"admin_label" => true,
			"param_name" => "subtitle",
			"value" => "",
			"description" => "",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Padding subtitle", "wpdance"),
			"admin_label" => true,
			"param_name" => "padding_subtitle",
			"value" => "",
			"description" => "Ex: 0 0 15% 0 (top right bottom left)",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", "wpdance"),
			"admin_label" => true,
			"param_name" => "title",
			"value" => "",
			"description" => "",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Description", "wpdance"),
			"admin_label" => true,
			"param_name" => "desc",
			"value" => "",
			"description" => "",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Color text", "wpdance"),
			"admin_label" => true,
			"param_name" => "color",
			"value" => "#ffffff",
			"description" => "#2020202",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Background image", "wpdance"),
			"admin_label" => true,
			"param_name" => "bg_image",
			"value" => "",
			"description" => "Input image URL",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link", "wpdance"),
			"admin_label" => true,
			"param_name" => "link_url",
			"value" => "",
			"description" => "Ex:https://www.google.com",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Sep padding", "wpdance"),
			"admin_label" => true,
			"param_name" => "sep_padding",
			"value" => "12%",
			"description" => "Ex: 14% 0 0 0 (top right bottom left)",
		),	
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style responsive", "wpdance"),
			"admin_label" => true,
			"param_name" => "style_responsive",
			"value" => array(
				"Vertical" => "vertical-responsive",
				"Horizontal" => "horizontal-responsive"
			),
			"description" => "",
		),	
		
	)
);
vc_map( $specipic_product_params );
?>