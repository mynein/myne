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
	$features = woothemes_get_features( array('limit' => -1 ));
	$list_features = array();
	if( is_array($features) ){
		foreach( $features as $feature ){
			$list_features[$feature->post_title] = $feature->ID;
		}
	}
	
	$feature_params = array(
		"name" => __("Feature", "wpdance"),
		"base" => "wd_feature",
		"icon" => "icon-wpb-wpdance",
		"category" => __("WPDance Elements", "wpdance"),
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Feature", "wpdance"),
				"admin_label" => true,
				"param_name" => "id",
				"value" => $list_features,
				"description" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Icon Feature", "wpdance"),
				"admin_label" => true,
				"param_name" => "icon_image",
				"value" => "",
				"description" => __("Ex:fa fa-home (use font Awesome icon)", "wpdance")
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Style", "wpdance"),
				"admin_label" => true,
				"param_name" => "style",
				"value" => array(
						'Vertical' => 'vertical',
						'Horizontal' => 'horizontal'
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Style", "wpdance"),
				"admin_label" => true,
				"param_name" => "icon_style",
				"value" => array(
						'No Border' => 'icon-no-border',
						'Square Border' => 'icon-square-border',
						'Circle Border' => 'icon-circle-border'
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Icon", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_icon",
				"value" => array(
						'Yes' => 1,
						'No' => 0
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Image", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_image",
				"value" => array(
						'Yes' => 1,
						'No' => 0
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show learn more", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_feature_learnmore",
				"value" => array(
						'Yes' => 1,
						'No' => 0
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
						'Yes' => 1,
						'No' => 0
					),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show Excerpt", "wpdance"),
				"admin_label" => true,
				"param_name" => "excerpt",
				"value" => array(
						'Yes' => 1,
						'No' => 0
					),
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Icon color", "wpdance"),
				"admin_label" => false,
				"param_name" => "icon_color",
				"value" => "",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Icon hover color", "wpdance"),
				"admin_label" => false,
				"param_name" => "icon_hover_color",
				"value" => "",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Border color", "wpdance"),
				"admin_label" => false,
				"param_name" => "border_color",
				"value" => "",
				"description" => ""
			),
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Border hover color", "wpdance"),
				"admin_label" => false,
				"param_name" => "border_hover_color",
				"value" => "",
				"description" => ""
			),
			//trung edit
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background color", "wpdance"),
				"admin_label" => false,
				"param_name" => "background_color",
				"value" => "",
				"description" => ""
			),
			//trung edit
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background hover color", "wpdance"),
				"admin_label" => false,
				"param_name" => "background_hover_color",
				"value" => "",
				"description" => ""
			),
		)
	);
	vc_map( $feature_params );
}
?>