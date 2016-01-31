<?php

// **********************************************************************// 

// ! Register New Element: WD Testimonial

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Testimonial
// **********************************************************************//
$is_woo_testimonial = true;
$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
if ( !in_array( "testimonials-by-woothemes/woothemes-testimonials.php", $_actived ) ) {
	$is_woo_testimonial = false;
}
if( $is_woo_testimonial ){
	$testimonials = woothemes_get_testimonials(array('limit'=>-1));
	$list_testimonials = array();
	if( $testimonials ){
		foreach( $testimonials as $testimonial ){
			$list_testimonials[$testimonial->post_title] = $testimonial->ID;
		}
	}
	$testimonial_params = array(
		"name" => "Testimonial",
		"base" => "wd_testimonial",
		"icon" => "icon-wpb-wpdance",
		"category" => "WPDance Elements",
		"params" => array(
			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Style", "wpdance"),
				"admin_label" => true,
				"param_name" => "style",
				"value" => array(
					"Style 1" => "style-1",
					"Style 2" => "style-2"
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Testimonial", "wpdance"),
				"admin_label" => true,
				"param_name" => "id",
				"value" => $list_testimonials,
				"description" => ""
			),
			// Heading
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background", "wpdance"),
				"admin_label" => true,
				"param_name" => "background",
				"value" => "#ffffff",
				"description" => "",
			),
		)
	);
	vc_map( $testimonial_params );
	
	/* Testimonial Slider */
	$testimonial_slider_params = array(
		"name" => "Testimonial Slider",
		"base" => "wd_testimonial_slider",
		"icon" => "icon-wpb-wpdance",
		"category" => "WPDance Elements",
		"params" => array(
			
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Style", "wpdance"),
				"admin_label" => true,
				"param_name" => "style",
				"value" => array(
					"Style 1" => "style-1",
					"Style 2" => "style-2"
				),
				"description" => ""
			),
			array(
				"type" => "textfield",
				"class" => "",
				"heading" => __("Limit", "wpdance"),
				"admin_label" => true,
				"param_name" => "limit",
				"value" => 2,
				"description" => ""
			),
			// Heading
			array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Background", "wpdance"),
				"admin_label" => true,
				"param_name" => "background",
				"value" => "#ffffff",
				"description" => "",
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show navigation buttons", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_nav",
				"value" => array(
					"No" => 0
					,"Yes" => 1
				),
				"description" => ""
			),
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Show pagination buttons", "wpdance"),
				"admin_label" => true,
				"param_name" => "show_pagination",
				"value" => array(
					"No" => 0
					,"Yes" => 1
				),
				"description" => ""
			),
		)
	);
	vc_map( $testimonial_slider_params );
}
?>