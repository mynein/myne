<?php

// **********************************************************************// 

// ! Register New Element: WD Quote

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Quote
// **********************************************************************//

$quote_params = array(
	"name" => "Quote",
	"base" => "wd_quote",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
	
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Custom class", "wpdance"),
			"admin_label" => true,
			"param_name" => "class",
			"value" => '',
			"description" => "",
		),
		array(
			"type" => "textarea",
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
vc_map( $quote_params );
?>