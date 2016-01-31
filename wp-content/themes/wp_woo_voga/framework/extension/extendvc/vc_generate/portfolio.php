<?php

// **********************************************************************// 

// ! Register New Element: WD Portfolio

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Portfolio
// **********************************************************************//
if( class_exists('WD_Portfolio') ){
	
	$portfolio_params = array(
		"name" => "Portfolio",
		"base" => "wd-portfolio",
		"icon" => "icon-wpb-wpdance",
		"category" => "WPDance Elements",
		"params" => array(
		
			// Heading
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Columns", "wpdance"),
				"admin_label" => true,
				"param_name" => "columns",
				"value" => '4',
				"description" => "",
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Style", "wpdance"),
				"admin_label" => true,
				"param_name" => "style",
				"value" => array(
						'style 1' => 'style-1',
						'style 2' => 'style-2'
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Filter", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_filter",
				"value" => array(
						'Yes' => 'yes',
						'No' => 'no'
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Categories", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_categories",
				"value" => array(
						'Yes' => 'yes',
						'No' => 'no'
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Title", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_title",
				"value" => array(
						'Yes' => 'yes',
						'No' => 'no'
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Description", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_desc",
				"value" => array(
						'No' => 'no',
						'Yes' => 'yes'
					),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Limit", "wpdance"),
				"admin_label" => true,
				"param_name" => "count",
				"value" => '-1',
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Pagination", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_pagination",
				"value" => array(
						'Yes' => 'yes',
						'No' => 'no'
					),
				"description" => ""
			),
			array(
				"type" => "textarea",
				"class" => "",
				"heading" => __("Category IDs", "wpdance"),
				"admin_label" => true,
				"param_name" => "category",
				"value" => '',
				"description" => "",
			)
		)
	);
	vc_map( $portfolio_params );
}
?>