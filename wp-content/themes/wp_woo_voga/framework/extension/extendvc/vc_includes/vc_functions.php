<?php
// Check <= IE8
function is_IE8(){
	$u = $_SERVER['HTTP_USER_AGENT'];
	
	$isIE8  = (bool)preg_match('/msie 8./i', $u );
		
	return $isIE8;
}

// Check <= IE7
function is_IE7(){
	$u = $_SERVER['HTTP_USER_AGENT'];

	$isIE7  = (bool)preg_match('/msie 7./i', $u );
		
	return $isIE7;
}

// **********************************************************************// 
// ! Override widget title
// **********************************************************************// 
add_filter('wpb_widget_title', 'override_widget_title', 10, 2);
function override_widget_title($output = '', $params = array('')) {
  $extraclass = (isset($params['extraclass'])) ? " ".$params['extraclass'] : "";
  return '<h4 class="entry-title'.$extraclass.'">'.$params['title'].'</h4>';
}

/**
 * Description here.
 *
 */
if (!function_exists('wd_hex2rgb')) {
	function wd_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return $rgb; // returns an array with the rgb values
	}
}


/**
 * Description here.
 *
 */
function wd_stylesheet_get_opacity( $opacity = 0 ) {
	$opacity = ($opacity > 0) ? $opacity/100 : 0;
	return $opacity;
}


/**
 * Description here.
 *
 */
function wd_stylesheet_color_hex2rgb( $_color, $raw = false ) {
    
    if( is_array($_color) ) {
        $rgb_array = array_map('intval', $_color);    
    }else {

        $color = str_replace( '#', '', trim($_color) );

        if ( count($color) < 6 ) {
            $color .= $color;
        }

        $rgb_array = sscanf($color, '%2x%2x%2x');     

        if( is_array($rgb_array) && count($rgb_array) == 3 ) {
            $rgb_array = array_map('absint', $rgb_array);
        }else {
            return '';
        }
    }

    if ( !$raw ) {
        return sprintf( 'rgb(%d,%d,%d)', $rgb_array[0], $rgb_array[1], $rgb_array[2] );
    }
    return $rgb_array;
}


/**
 * Description here.
 *
 */
function wd_stylesheet_color_hex2rgba( $color, $opacity = 0 ) {

    if ( !$color ) return '';

    $rgb_array = wd_stylesheet_color_hex2rgb( $color, true );

    return sprintf( 'rgba(%d,%d,%d,%s)', $rgb_array[0], $rgb_array[1], $rgb_array[2], wd_stylesheet_get_opacity( $opacity ) );
}


function wd_register_custom_vc_scripts() {
	// register custom pie jquery plugin
	wp_register_script('vc_wd_pie', THEME_EXTENDS_EXTENDVC_URI . '/vc_extend/jquery.vc_chart.js', array('jquery', 'waypoints', 'progressCircle'));
}
//add_action('wp_enqueue_scripts', 'wd_register_custom_vc_scripts', 15);


if ( !function_exists('presscore_get_default_image') ){

	/**
	 * Get default image.
	 *
	 * Return array( 'url', 'width', 'height' );
	 *
	 * @return array.
	 */
	function presscore_get_default_image() {
		return array( THEME_URI . '/images/noimage.jpg', 1000, 1000 );
	}
}


/**
 * master get image function. 
 *
 * @param $opts array
 *
 * @return string
 */
if ( !function_exists('wd_get_thumb_img') ){
	function wd_get_thumb_img( $opts = array() ) {
		global $post;

		$default_image = presscore_get_default_image();

		$defaults = array(
			'wrap'				=> '<a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% %SIZE% %ALT% %IMG_TITLE% /></a>',
			'class'         	=> '',
			'alt'				=> '',
			'title'         	=> '',
			'custom'        	=> '',
			'img_class'     	=> '',
			'img_title'			=> '',
			'img_description'	=> '',
			'img_caption'		=> '',
			'href'				=> '',
			'img_meta'      	=> array(),
			'img_id'			=> 0,
			'options'    		=> array(),
			'default_img'		=> $default_image,
			'prop'				=> false,
			'echo'				=> true
		);
		$opts = wp_parse_args( $opts, $defaults );
		$opts = apply_filters('wd_get_thumb_img-args', $opts);

		$original_image = null;
		if ( $opts['img_meta'] ) {
			$original_image = $opts['img_meta'];
		} elseif ( $opts['img_id'] ) {
			$original_image = wp_get_attachment_image_src( $opts['img_id'], 'full' );
		}

		if ( !$original_image ) {
			$original_image = $opts['default_img'];
		}

		// proportion
		if ( $original_image && !empty($opts['prop']) && ( empty($opts['options']['h']) || empty($opts['options']['w']) ) ) {
			$_prop = $opts['prop'];
			$_img_meta = $original_image;

			if ( $_prop > 1 ) {
				$h = intval(floor($_img_meta[1] / $_prop));
				$w = intval(floor($_prop * $h));
			} else if ( $_prop < 1 ) {
				$w = intval(floor($_prop * $_img_meta[2]));
				$h = intval(floor($w / $_prop));
			} else {
				$w = $h = min($_img_meta[1], $_img_meta[2]);
			}

			if ( !empty($opts['options']['w']) ) {
				$__prop = $h / $w;
				$w = intval($opts['options']['w']);
				$h = intval(floor($__prop * $w));
			} else if ( !empty($opts['options']['h']) ) {
				$__prop = $w / $h;
				$h = intval($opts['options']['h']);
				$w = intval(floor($__prop * $h));
			}

			$opts['options']['w'] = $w;
			$opts['options']['h'] = $h;
		}

		if ( $opts['options'] ) {
			$resized_image = dt_get_resized_img( $original_image, $opts['options'] );
		} else {
			$resized_image = $original_image;
		}

		if ( $img_id = absint( $opts['img_id'] ) ) {

			if ( '' === $opts['alt'] ) {
				$opts['alt'] = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			}

			if ( '' === $opts['img_title'] ) {
				$opts['img_title'] = get_the_title( $img_id );
			}
		}

		$class = empty( $opts['class'] ) ? '' : 'class="' . esc_attr( trim($opts['class']) ) . '"';
		$title = empty( $opts['title'] ) ? '' : 'title="' . esc_attr( trim($opts['title']) ) . '"';
		$img_title = empty( $opts['img_title'] ) ? '' : 'title="' . esc_attr( trim($opts['img_title']) ) . '"';
		$img_class = empty( $opts['img_class'] ) ? '' : 'class="' . esc_attr( trim($opts['img_class']) ) . '"';

		$href = $opts['href'];
		if ( !$href ) {
			$href = $original_image[0];
		}

		$src = $resized_image[0];

		if ( empty($resized_image[3]) || !is_string($resized_image[3]) ) {
			$size = image_hwstring($resized_image[1], $resized_image[2]);
		} else {
			$size = $resized_image[3];
		}

		$output = str_replace(
			array(
				'%HREF%',
				'%CLASS%',
				'%TITLE%',
				'%CUSTOM%',
				'%SRC%',
				'%IMG_CLASS%',
				'%SIZE%',
				'%ALT%',
				'%IMG_TITLE%',
				'%RAW_TITLE%',
				'%RAW_ALT%',
				'%RAW_IMG_TITLE%',
				'%RAW_IMG_DESCRIPTION%',
				'%RAW_IMG_CAPTION'
			),
			array(
				'href="' . esc_url( $href ) . '"',
				$class,
				$title,
				strip_tags( $opts['custom'] ),
				'src="' . esc_url( $src ) . '"',
				$img_class,
				$size,
				'alt="' . esc_attr( $opts['alt'] ) . '"',
				$img_title,
				esc_attr( $opts['title'] ),
				esc_attr( $opts['alt'] ),
				esc_attr( $opts['img_title'] ),
				esc_attr( $opts['img_description'] ),
				esc_attr( $opts['img_caption'] )
			),
			$opts['wrap']
		);

		if ( $opts['echo'] ) {
			echo ($output);
			return '';
		}

		return $output;
	}
}


if ( ! function_exists( 'presscore_get_team_links_array' ) ) {

	/**
	 * Return links list for team post meta box.
	 *
	 * @return array.
	 */
	function presscore_get_team_links_array() {
		$team_links =  array(
			'link'		=> array( 'desc' => __( 'Personal blog / website', 'wpdance' ) ),
			'envelope'	=> array( 'desc' => __( 'E-mail', 'wpdance' ) ),
		);

		$common_links = presscore_get_social_icons_data();
		if ( $common_links ) {

			foreach ( $common_links as $key=>$value ) {

				if ( isset($team_links[ $key ]) ) {
					continue;
				}

				$team_links[ $key ] = array( 'desc' => $value );
			}
		}

		return $team_links;
	}

} // presscore_get_team_links_array

if ( ! function_exists( 'presscore_get_social_icons_data' ) ) {

	/**
	 * Return social icons array( 'class', 'title' ).
	 *
	 */
	function presscore_get_social_icons_data() {
		return array(
			'facebook'		=> __('Facebook', 'wpdance'),
			'twitter'		=> __('Twitter', 'wpdance'),
			'google-plus'	=> __('Google+', 'wpdance'),
			'pinterest'		=> __('Pinterest', 'wpdance'),
		);
	}

} // presscore_get_social_icons_data


if ( ! function_exists( 'presscore_get_social_icon' ) ) {

	/**
	 * Get social icon.
	 *
	 * @return string
	 */
	function presscore_get_social_icon( $icon, $url, $title = '', $classes = array(), $target = '_blank' ) {

		// check for skype
		if ( 'skype' == $icon ) {
			$url = esc_attr( $url );
		} else if ( 'envelope' == $icon && is_email($url) ) {
			$url = 'mailto:' . esc_attr($url);
			$target = '_top';
		} else {
			$url = esc_url( $url );
		}

		$classes[] = $icon;

		$output = sprintf(
			'<a title="%2$s" target="%4$s" href="%1$s" class="%3$s"><i class="fa fa-%3$s"></i></a>',
			$url,
			esc_attr( $title ),
			esc_attr( implode( ' ',  $classes ) ),
			$target
		);

		return $output;
	}

} // presscore_get_social_icon

if( !function_exists('vc_taxonomy_form_field') ){
	function vc_taxonomy_form_field($settings, $value) {

		$terms_fields = array();
		$terms_slugs = array();

		$value_arr = $value;
		if ( !is_array($value_arr) ) {
			$value_arr = array_map( 'trim', explode(',', $value_arr) );
		}

		if ( !empty($settings['taxonomy']) ) {

			$terms = get_terms( $settings['taxonomy'] );
			if ( $terms && !is_wp_error($terms) ) {

				foreach( $terms as $term ) {
					$terms_slugs[] = $term->slug;

					$terms_fields[] = sprintf(
						'<option id="%s" class="%s" value="%s" %s>%s</option>',
						$settings['param_name'] . '-' . $term->slug,
						$settings['param_name'].' '.$settings['type'],
						$term->slug,
						selected( in_array( $term->slug, $value_arr ), true, false ),
						$term->name
					);
				}
			}
		}

		return 	'<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select dropdown">'
				. '<option value=""></option>'
				. implode( $terms_fields ) 
				. '</select>';
	}
}
WpbakeryShortcodeParams::addField('wd_taxonomy', 'vc_taxonomy_form_field');
?>