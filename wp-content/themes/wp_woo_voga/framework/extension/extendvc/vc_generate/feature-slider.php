<?php

// **********************************************************************// 

// ! Register New Element: WD Feature

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Feature
// **********************************************************************//
$wd_is_feature = true;
$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
	if ( !in_array( "features-by-woothemes/woothemes-features.php", $_actived ) ) {
		$wd_is_feature = false;
	}
if( $wd_is_feature ){
	
	$feature_params = array(
		"name" => "Feature Slider",
		"base" => "wd_feature_slider",
		"icon" => "icon-wpb-wpdance",
		"category" => "WPDance Elements",
		"params" => array(
			// id
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Columns", "wpdance"),
				"admin_label" => true,
				"param_name" => "columns",
				"value" => "3",
				"description" => ""
			),
			array(
				"type" 			=> "textfield",
				"class" 		=> "",
				"heading" 		=> __("Limit", "wpdance"),
				"admin_label" 	=> true,
				"param_name" 	=> "limit",
				"value" 		=> "4",
				"description" 	=> ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Title", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_title",
				"value" => array(
						"Yes" => "1",
						"No" => "0"
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Thumbnail", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_thumbnail",
				"value" => array(
						"Yes" => "1",
						"No" => "0"
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Excerpt", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_excerpt",
				"value" => array(
						"Yes" => "1",
						"No" => "0"
					),
				"description" => ""
			),
			// add nav dropdown
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Nav", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_nav",
				"value" => array(
						"Yes" => "1",
						"No" => "0"
				),
				"description" => ""
			),
			
			// add icon nav dropdown
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Pagination", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_icon_nav",
				"value" => array(
						"No" => "0",
						"Yes" => "1"
				),
				"description" => "",
			),
			
			// auto play products
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Auto play", "wpdance"),
				"admin_label" => true,
				"param_name" => "autoplay",
				"value" => array(
						"Yes" => "1",
						"No" => "0"
				),
				"description" => ""
			),
			
		)
	);
	vc_map( $feature_params );
}
?>