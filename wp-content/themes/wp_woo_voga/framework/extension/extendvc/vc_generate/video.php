<?php

// **********************************************************************// 

// ! Register New Element: WD Video

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Video
// **********************************************************************//
$video_params = array(
	"name" => "Video",
	"base" => "wd_video",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("MP4 Video", "wpdance"),
			"admin_label" => true,
			"param_name" => "video_mp4",
			"value" => "",
			"description" => "",
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("OGG Video", "wpdance"),
			"admin_label" => true,
			"param_name" => "video_ogg",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("WEBM Video", "wpdance"),
			"admin_label" => true,
			"param_name" => "video_webm",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Volumn", "wpdance"),
			"admin_label" => true,
			"param_name" => "volume",
			"value" => "0",
			"description" => "Min: 0, Max: 1"
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Height", "wpdance"),
			"admin_label" => true,
			"param_name" => "height",
			"value" => "300",
			"description" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Background color opacity", "wpdance"),
			"admin_label" => true,
			"param_name" => "bg_opacity",
			"value" => "0.35",
			"description" => "Min: 0, Max: 1"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Background color", "wpdance"),
			"admin_label" => true,
			"param_name" => "bg_color",
			"value" => array(
					'Black' => 'black',
					'White' => 'white'
				),
			"description" => ""
		),
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Background image", "wpdance"),
			"admin_label" => true,
			"param_name" => "bg_image",
			"value" => "",
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Auto play", "wpdance"),
			"admin_label" => true,
			"param_name" => "auto_play",
			"value" => array(
					'No' => 0,
					'Yes' => 1
				),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Loop", "wpdance"),
			"admin_label" => true,
			"param_name" => "loop",
			"value" => array(
					'Yes' => 1,
					'No' => 0
				),
			"description" => ""
		)
	)
);
vc_map( $video_params );
?>