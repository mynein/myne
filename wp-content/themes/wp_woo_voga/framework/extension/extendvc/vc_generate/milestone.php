<?php

// **********************************************************************// 

// ! Register New Element: WD Milestone

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Milestone
// **********************************************************************//
$milestone_params = array(
	"name" => "Milestone",
	"base" => "wd_milestone",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Number", "wpdance"),
			"admin_label" => true,
			"param_name" => "number",
			"value" => "0",
			"description" => "",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Symbol", "wpdance"),
			"admin_label" => true,
			"param_name" => "symbol",
			"value" => "",
			"description" => "Use FontAwesome. Ex: fa fa-home",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Subject", "wpdance"),
			"admin_label" => true,
			"param_name" => "subject",
			"value" => "",
			"description" => "",
		),
	)
);
vc_map( $milestone_params );
?>