<?php

// **********************************************************************// 

// ! Register New Element: WD Code

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Code
// **********************************************************************//

$code_params = array(
	"name" => "Code",
	"base" => "wd_code",
	"icon" => "icon-wpb-wpdance",
	"category" => 'WPDance Elements',
	"params" => array(
	
		array(
			"type" => "textarea",
			"class" => "",
			"heading" => __("Code", "wpdance"),
			"admin_label" => true,
			"param_name" => "content",
			"value" => "",
			"description" => "",
		)
	
	)
);
vc_map( $code_params );
?>