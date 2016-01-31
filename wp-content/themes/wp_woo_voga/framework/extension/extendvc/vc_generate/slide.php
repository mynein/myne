<?php

// **********************************************************************// 

// ! Register New Element: WD Slide

// **********************************************************************//

// ! File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// **********************************************************************// 
// ! Register New Element: WD Slide
// **********************************************************************//
$list_slides = array();
$args = array(
			'posts_per_page'	=> -1
			,'post_type'		=> 'slide'
			,'post_status'		=> 'publish'
			);
$slides = new WP_Query($args);
if( $slides->have_posts() ){
	global $post;
	while( $slides->have_posts() ){
		$slides->the_post();
		$sliders_config = get_post_meta($post->ID, 'wd_slider_config', true);
		$sliders_config = unserialize($sliders_config);
		$key = (isset($sliders_config['title']) && strlen(trim($sliders_config['title'])) > 0)?$sliders_config['title']:$post->ID;
		$value = $post->ID;
		$list_slides[$key]	= $value;
	}
	wp_reset_postdata();
}

$slide_params = array(
	"name" => "Slide",
	"base" => "wd_slider",
	"icon" => "icon-wpb-wpdance",
	"category" => "WPDance Elements",
	"params" => array(
		array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __('Select Slider ID', 'wpdance'),
				"admin_label" => true,
				"param_name" => "id",
				"value" => $list_slides,
				"description" => ""
			),
	)
);
vc_map( $slide_params );
?><?php ?>