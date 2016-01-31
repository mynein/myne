<?php

// **********************************************************************// 

// ! Register New Element: WD Best Selling Products Slider

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$args = array(
	'number'     => '',
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => true,
	'include'    => array()
);

// **********************************************************************// 
// ! Register New Element: WD Best Selling Products Slider
// **********************************************************************//
$feature_product_params = array(
	"name" => "WD Best Selling Products Slider",
	"base" => "best_selling_product_slider",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Product",
	"params" => array(
	
		// Heading
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Heading", "wpdance"),
			"admin_label" => true,
			"param_name" => "title",
			"value" => "",
			"description" => "",
		),
		
		// Heading
		array(
			"type" => "textarea",
			"class" => "",
			"heading" => __("Description", "wpdance"),
			"admin_label" => true,
			"param_name" => "desc",
			"value" => "",
			"description" => "",
		),
		
		// Columns
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Columns", "wpdance"),
			"admin_label" => true,
			"param_name" => "columns",
			"value" => "4",
			"description" => "",
		),
				
		// add Row
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Row", "wpdance"),
			"admin_label" => true,
			"param_name" => "row",
			"value" => "1",
			"description" => ""
		),
		
		// category
		array(
			"type" => "wd_taxonomy",
			"taxonomy" => "product_cat",
			"class" => "",
			"heading" => __("Category Slug", "wpdance"),
			"admin_label" => true,
			"param_name" => "cat_slug",
			"value" => "",
			"description" => ""
		),
		
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show type", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_type",
			"value" => array(
				"Grid" => "grid",
				"List" => "list"
			),
			"description" => ""
		),	
		
		/* Big product
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Big Product", "wpdance"),
			"admin_label" => true,
			"param_name" => "big_product",
			"value" => "",
			"description" => "Enter the ID product",
		),*/
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Limit", "wpdance"),
			"admin_label" => true,
			"param_name" => "per_page",
			"value" => "4",
			"description" => __("Limit number of product", "wpdance")
		),
	
		// add image dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Product Image", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_image",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => ""
		),
		
		// add title dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Product Title", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_title",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => ""
		),
		
		// add Sku dropdown
		array(
			"type" 			=> "dropdown",
			"class" 		=> "",
			"heading" 		=> __("Show Product Sku", "wpdance"),
			"admin_label" 	=> true,
			"param_name"	=> "show_sku",
			"value" => array(
				"No" => "0",
				"Yes" => "1"
			),
			"description" => ""
		),
		
		// add Price dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Product Price", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_price",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => ""
		),
		
		// add Rating dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Product Rating", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_rating",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => ""
		),
		// add add to cart
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Add To Cart", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_add_to_cart",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => ""
		),
		// add Label dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Product Label", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_label",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => ""
		),
		
		// add Categories dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Categories of Product", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_categories",
			"value" => array(
				"Yes" => "1",
				"No" => "0"
			),
			"description" => __("Show all categories of each product", "wpdance")
		),
		
		// add Categories dropdown
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Show Short Content of Product", "wpdance"),
			"admin_label" => true,
			"param_name" => "show_short_content",
			"value" => array(
				"No" => "0",
				"Yes" => "1"
			),
			"description" => __("Show short content of each product", "wpdance")
		),
		
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
				"Yes" => "1",
				"No" => "0"
			),
			"description" => "Only support when Row = 1",
			"dependency" => array(
				"element" => "row",
				"value" => "1"
			)
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
vc_map( $feature_product_params );
?>