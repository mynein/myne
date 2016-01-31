<?php

// **********************************************************************// 

// ! Register New Element: WD Recent Blogs

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Recent Blogs
// **********************************************************************//
$categories = get_categories();
$list_categories = array(''=>'');
foreach($categories as $category ){
	$list_categories[$category->name] = $category->slug;
}
$recent_blogs_params = array(
	"name" => "Recent Blogs",
	"base" => "wd_recent_blogs",
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
		
	)
);
vc_map( $recent_blogs_params );
?>