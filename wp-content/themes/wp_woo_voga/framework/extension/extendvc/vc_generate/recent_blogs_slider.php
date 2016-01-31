<?php

// **********************************************************************// 

// ! Register New Element: WD Recent Blogs Slider

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Recent Blogs Slider
// **********************************************************************//
$categories = get_categories();
$list_categories = array(''=>'');
foreach($categories as $category ){
	$list_categories[$category->name] = $category->slug;
}
$recent_blogs_params = array(
	"name" => "Recent Blogs Slider",
	"base" => "wd_recent_blogs_slider",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
	
		// Heading
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Category", "wpdance"),
			"admin_label" => true,
			"param_name" => "category",
			"value" => $list_categories,
			"description" => ""
		),
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
			"type" => "textfield",
			"class" => "",
			"heading" => __("Limit", "wpdance"),
			"admin_label" => true,
			"param_name" => "number_posts",
			"value" => '4',
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Type", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_type",
			"value" => array(
					'Grid' => 'grid',
					'List' => 'list'
				),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Thumbnail", "wpdance"),
			"admin_label" => true,
			"param_name" => "thumbnail",
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
			"param_name" => "title",
			"value" => array(
					'Yes' => 1,
					'No' => 0
				),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Date Time", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_date",
			"value" => array(
					'Yes' => 1,
					'No' => 0
				),
			"description" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Post Meta", "wpdance"),
			"admin_label" => true,
			"param_name" => "meta",
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
			"type" => "textfield",
			"class" => "",
			"heading" => __("Limit Excerpt Words", "wpdance"),
			"admin_label" => true,
			"param_name" => "excerpt_words",
			"value" => '20',
			"description" => "",
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Nav", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_nav",
			"value" => array(
				"No" => "0",
				"Yes" => "1"
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
			"description" => "Only support when Row = 1",
		),
		// auto play products
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Auto play", "wpdance"),
			"admin_label" => true,
			"param_name" => "autoplay",
			"value" => array(
				"No" => "0",
				"Yes" => "1"
			),
			"description" => ""
		),
		
	)
);
vc_map( $recent_blogs_params );
?>