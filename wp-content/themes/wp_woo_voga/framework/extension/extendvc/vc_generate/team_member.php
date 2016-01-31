<?php

// **********************************************************************// 

// ! Register New Element: WD Team

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
if ( in_array( "wd_team/wd_team.php", $_actived ) ) {
	/// ! Team
	vc_map( array(
		"name" => "Team member",
		"base" => "team_member",
		"icon" => "icon-wpb-wpdance",
		"category" => "WPDance Elements",
		"params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Appearance", "wpdance"),
				"param_name" => "style",
				"value" => array(
					"Style 1" => "style1",
					"Style 2" => "style2",
				),
				"description" => ""
			),
			
			// Column width
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Slug", "wpdance"),
				"param_name" => "slug",
				"value" => "",
				"description" => __("Slug of Team member item", "wpdance")
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Except", "wpdance"),
				"param_name" => "except",
				"value" => "50",
				"description" => __("Ex:50", "wpdance")
			),


			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Width", "wpdance"),
				"param_name" => "width",
				"value" => "300"
			),


			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Height", "wpdance"),
				"param_name" => "height",
				"value" =>"380"
			)
		)
	) );
}
?>