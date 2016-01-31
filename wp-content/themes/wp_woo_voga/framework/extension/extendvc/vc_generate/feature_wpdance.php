<?php
// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
// **********************************************************************// 
// ! Register New Element: WD Feature Wpdance
// **********************************************************************//
$feature_wpdance_params = array(
	"name" => "WD Feature WPdance",
	"base" => "feature_wpdance",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"description"	=> "",
	"params" => array(
		// Title
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Image", "wpdance"),
			"admin_label" => true,
			"param_name" => "image",
			"value" => "",
			"description" => "Input image URL"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", "wpdance"),
			"admin_label" => true,
			"param_name" => "title",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Time", "wpdance"),
			"admin_label" => true,
			"param_name" => "time",
			"value" => "",
			"description" => ""
		),
		// desc
		array(
			"type" => "textarea",
			"class" => "",
			"heading" => __("Description", "wpdance"),
			"admin_label" => true,
			"param_name" => "desc",
			"value" => "",
			"description" => ""
		),	
		// desc
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Min height", "wpdance"),
			"admin_label" => true,
			"param_name" => "min_height",
			"value" => "",
			"description" => "Ex:445px"
		),	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link", "wpdance"),
			"admin_label" => true,
			"param_name" => "link",
			"value" => "",
			"description" => "Input URL"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Text more", "wpdance"),
			"admin_label" => true,
			"param_name" => "text_more",
			"value" => "",
			"description" => ""
		),
	)
);
vc_map( $feature_wpdance_params );
?>