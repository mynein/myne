<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $full_width = $el_id = $parallax_image = $parallax = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$full_width = false;

wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

if($hidden_on_phones) {
	$el_class .= ' hidden-xs';
}

// use default video if user checked video, but didn't chose url
if ( ! empty( $video_bg ) && empty( $video_bg_url ) ) {
	$video_bg_url = 'https://www.youtube.com/watch?v=lMJXxhRFO1k';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

if( $has_video_bg ){
	$enable_parallax = false;
}

if($row_type == "row"){
	$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row vc_row '.get_row_css_class().$el_class.vc_shortcode_custom_css_class($css, ' '), $this->settings['base']);
	
	if ( ! empty( $full_height ) ) {
		$css_class .= ' vc_row-o-full-height';
		if ( ! empty( $content_placement ) ) {
			$css_class .= ' vc_row-o-content-' . $content_placement;
		}
	}

	$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
	
	$data_attr = '';
	if( ! empty( $full_width ) ){
		$data_attr .= ' data-vc-full-width="true" data-vc-full-width-init="false"';
		if ( $full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces' ) {
			$data_attr .= ' data-vc-stretch-content="true"';
		}
	}
	
	if( $has_video_bg && !empty($video_bg_url) ){
		wp_enqueue_script( 'vc_youtube_iframe_api_js' );
		wp_enqueue_script( 'vc_jquery_skrollr_js' );
		$data_attr .= ' data-vc-parallax="1.5"'; // parallax speed
		$css_class .= ' vc_video-bg-container';
		
		if( !empty($video_bg_parallax) ){
			$css_class .= ' vc_general vc_parallax vc_parallax-' . $video_bg_parallax;
			if ( strpos( $video_bg_parallax, 'fade' ) !== false ) {
				$css_class .= ' js-vc_parallax-o-fade';
				$data_attr .= ' data-vc-parallax-o-fade="on"';
			} elseif ( strpos( $video_bg_parallax, 'fixed' ) !== false ) {
				$css_class .= ' js-vc_parallax-o-fixed';
			}
		}
		
		$data_attr .= ' data-vc-parallax-image="' . esc_attr( $video_bg_url ) . '"';
		$data_attr .= ' data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
	}

	$output .= '<div '.(isset( $el_id ) && ! empty( $el_id )?'id="'.esc_attr( $el_id ).'"':'').' class="'.$css_class.($full_width == 'stretch_row_content_no_spaces'?' vc_row-no-padding':'').'"'.$style.$data_attr.'>';
	
	if(strpos($css,'background-image:'))
		$output .= '<div class="row-bg-mask"></div>';
		
	$output .= '<div class="'.$layout.'"><div class="wd_row_content">';
	$output .= wpb_js_remove_wpautop($content);
	$output .= '</div></div>';
	
	$output .= '</div>'.$this->endBlockComment('row');
	if ( ! empty( $full_width ) ) {
		$output .= '<div class="vc_row-full-width"></div>';
	}
}

if($row_type == "section") {
	$stripe_classes = array( 'stripe' );
	$stripe_classes[] = 'stripe-style-' . esc_attr($type);
	
	$data_attr = '';
	if ( '' != $parallax_speed && $enable_parallax ) {

		$parallax_speed = floatval($parallax_speed);
		if ( false == $parallax_speed ) {
			$parallax_speed = 0.1;
		}

		$stripe_classes[] = 'stripe-parallax-bg';
		$data_attr .= ' data-prlx-speed="' . $parallax_speed . '"';
		$data_attr .= ' data-prlx-fixed="' . $parallax_fixed . '"';
	}
	
	$data_attr_2 = '';
	if( ! empty( $full_width ) ){
		$data_attr_2 .= ' data-vc-full-width="true" data-vc-full-width-init="false"';
		if ( $full_width == 'stretch_row_content' || $full_width == 'stretch_row_content_no_spaces' ) {
			$data_attr_2 .= ' data-vc-stretch-content="true"';
		}
	}
	
	$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row vc_row '.get_row_css_class().$el_class, $this->settings['base']);
	
	if ( ! empty( $full_height ) ) {
		$css_class .= ' vc_row-o-full-height';
		if ( ! empty( $content_placement ) ) {
			$css_class .= ' vc_row-o-content-' . $content_placement;
		}
	}
	
	if( $has_video_bg && !empty($video_bg_url) ){
		wp_enqueue_script( 'vc_youtube_iframe_api_js' );
		wp_enqueue_script( 'vc_jquery_skrollr_js' );
		$data_attr_2 .= ' data-vc-parallax="1.5"'; // parallax speed
		$css_class .= ' vc_video-bg-container';
		
		if( !empty($video_bg_parallax) ){
			$css_class .= ' vc_general vc_parallax vc_parallax-' . $video_bg_parallax;
			if ( strpos( $video_bg_parallax, 'fade' ) !== false ) {
				$css_class .= ' js-vc_parallax-o-fade';
				$data_attr_2 .= ' data-vc-parallax-o-fade="on"';
			} elseif ( strpos( $video_bg_parallax, 'fixed' ) !== false ) {
				$css_class .= ' js-vc_parallax-o-fixed';
			}
		}
		
		$data_attr_2 .= ' data-vc-parallax-image="' . esc_attr( $video_bg_url ) . '"';
		$data_attr_2 .= ' data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
	}

	$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
	
	$output .= '<div '.(isset( $el_id ) && ! empty( $el_id )?'id="'.esc_attr( $el_id ).'"':'').' class="' . esc_attr(implode(' ', $stripe_classes)) . vc_shortcode_custom_css_class($css, ' ') . '"' . $data_attr . $style . '>';
	
	$output .= '<div class="'.$css_class.($full_width == 'stretch_row_content_no_spaces'?' vc_row-no-padding':'').'" '.$data_attr_2.'>';
	
	if(strpos($css,'background-image:'))
		$output .= '<div class="row-bg-mask"></div>';
	
	if($content_grid) $output .= '<div class="container">';
	
	$output .= wpb_js_remove_wpautop($content);
	
	if($content_grid) $output .= '</div>';
	
	$output .= '</div>'.$this->endBlockComment('row');	
	if ( ! empty( $full_width ) ) {
		$output .= '<div class="vc_row-full-width"></div>';
	}
	$output .= '</div>';
}


echo ($output);