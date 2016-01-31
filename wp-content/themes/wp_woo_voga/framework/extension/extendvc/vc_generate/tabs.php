<?php

// **********************************************************************// 

// ! Register New Element: WD Tabs

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Tabs
// **********************************************************************//
$tabs_params = array(
	"name" => "Tabs",
	"base" => "wd_tabs",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
	
		// Heading
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Style", "wpdance"),
			"admin_label" => true,
			"param_name" => "style",
			"value" => array(
					'Default 1' => 'default1',
					'Default 2' => 'default2',
					'Left' 		=> 'left',
					'Right' 	=> 'right',
					),
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Color", "wpdance"),
			"admin_label" => true,
			"param_name" => "color",
			"value" => '',
			"description" => "",
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
vc_map( $tabs_params );
?>