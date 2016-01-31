<?php
// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
//***********************************************************************
// Row
//***********************************************************************

vc_remove_param('vc_row', 'full_width');
vc_remove_param('vc_row', 'parallax');
vc_remove_param('vc_row', 'parallax_image');

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"show_settings_on_create"=>true,
	"heading" => __("Row Type", "wpdance"),
	"param_name" => "row_type",
	"value" => array(
		"Row" => "row",
		"Section" => "section"
	)
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Layout", "wpdance"),
	"param_name" => "layout",
	"value" => array(
		"Wide" => "row-wide",
		"Box" => "row-boxed"	
	),
	"dependency" => Array('element' => "row_type", 'value' => array('row'))
));

// hidden phone
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Hidden on Phones", "wpdance"),
	"param_name" => "hidden_on_phones",
	"value" => array(
		"" => "true"
	),
));

vc_add_param("vc_row", array(
	"type" => "dropdown",
	"class" => "",
	"heading" => __("Type", "wpdance"),
	"param_name" => "type",
	"value" => array(
		"In Grid" => "grid",
		"Full Width" => "full"	
	),
	"dependency" => Array('element' => "row_type", 'value' => array('section'))
));


vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Content In Grid", "wpdance"),
	"param_name" => "content_grid",
	"value" => array(
		"" => "false"
	),
	"dependency" => Array('element' => "row_type", 'value' => array('section'))
));

// parallax speed
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Enable parallax", "wpdance"),
	"param_name" => "enable_parallax",
	"value" => array(
		"" => "false"
	),
	"dependency" => Array('element' => "row_type", 'value' => array('section'))
));
vc_add_param("vc_row", array(
	"type" => "checkbox",
	"class" => "",
	"heading" => __("Fixed image", "wpdance"),
	"param_name" => "parallax_fixed",
	"value" => array(
		"" => "true"
	),
	"dependency" => Array('element' => "row_type", 'value' => array('section'))
));
vc_add_param("vc_row", array(
	"type" => "textfield",
	"class" => "",
	"heading" => __("Parallax speed", "wpdance"),
	"param_name" => "parallax_speed",
	"value" => "0.5",
	"dependency" => array(
		"element" => "enable_parallax",
		"not_empty" => true
	)
));

vc_remove_param('vc_tta_tabs', 'color');
vc_remove_param('vc_tta_tabs', 'style');
vc_remove_param('vc_tta_accordion', 'color');
vc_remove_param('vc_tta_accordion', 'style');
?>