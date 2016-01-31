<?php 
	if(!function_exists ('get_user_role')){
		function get_user_role( $user_id ) {
			global $wpdb;
			$user = get_userdata( $user_id );
			$capabilities = $user->{$wpdb->prefix . 'capabilities'};
			if ( !isset( $wp_roles ) ){
				$wp_roles = new WP_Roles();
			}
			foreach ( $wp_roles->role_names as $role => $name ) {
				if ( array_key_exists( $role, $capabilities ) ) {
					return $role;
				}
			}
			return false;
		}
	}
	
	/* Check is easy cart page */
	if( !function_exists('wd_is_ec_page') ){
		function wd_is_ec_page(){
			$storepageid = get_option('ec_option_storepage');
			$cartpageid = get_option('ec_option_cartpage');
			$accountpageid = get_option('ec_option_accountpage');
			
			if( function_exists( 'icl_object_id' ) ){
				$storepageid = icl_object_id( $storepageid, 'page', true, ICL_LANGUAGE_CODE );
				$cartpageid = icl_object_id( $cartpageid, 'page', true, ICL_LANGUAGE_CODE );
				$accountpageid = icl_object_id( $accountpageid, 'page', true, ICL_LANGUAGE_CODE );
			}
			
			if( empty($storepageid) || empty($cartpageid) || empty($accountpageid) ){
				return false;
			}
			
			if( is_page($storepageid) || is_page($cartpageid) || is_page($accountpageid) || (isset($_GET['header']) && $_GET['header']=='ec' ) ){
				return true;
			}
			return false;
		}
	}
	
	/**
	*	Combine a input array with defaut array
	*
	**/
	if(!function_exists ('wd_valid_color')){
		function wd_valid_color( $color = '' ) {
			if( strlen(trim($color)) > 0 ) {
				$named = array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');
				if (in_array(strtolower($color), $named)) {
					return true;
				}else{
					return preg_match('/^#[a-f0-9]{6}$/i', $color);			
				}
			}
			return false;
		}
	}

	/**
	*	Combine a input array with defaut array
	*
	**/
	if(!function_exists ('wd_array_atts')){
		function wd_array_atts($pairs, $atts) {
			$atts = (array)$atts;
			$out = array();
		   foreach($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) ){
					if( is_array($atts[$name]) ){
						$out[$name] = wd_array_atts($default,$atts[$name]);
					}
					else{
						if( strlen(trim($atts[$name])) > 0 ){
							$out[$name] = $atts[$name];
						}else{
							$out[$name] = $default;
						}
					}
				}
				else{
					$out[$name] = $default;
				}	
			}
			return $out;
		}
	}
	
	if(!function_exists ('wd_array_atts_str')){
		function wd_array_atts_str($pairs, $atts) {
			$atts = (array)$atts;
			$out = array();
		   foreach($pairs as $name => $default) {
				if ( array_key_exists($name, $atts) ){
					if( strlen(trim($atts[$name])) > 0 ){
						$out[$name] = $atts[$name];
					}else{
						$out[$name] = $default;
					}
				}
				else{
					$out[$name] = $default;
				}	
			}
			return $out;
		}
	}		
	
	if(!function_exists ('show_page_slider')){
		function show_page_slider(){
			global $page_datas;
			$revolution_exists = ( class_exists('RevSlider') && class_exists('UniteFunctionsRev') );
			switch ($page_datas['page_slider']) {
				case 'revolution':
					if( $revolution_exists )
						RevSliderOutput::putSlider($page_datas['page_revolution'],"");
					break;
				case 'layerslider':
					echo do_shortcode('[layerslider id="'.$page_datas['page_layerslider'].'"]');
					break;							
				case 'none' :
					break;							
				default:
				   break;
			}	
		}
	}
		
	add_action( 'wd_before_main_container', 'wd_print_inline_script', 10 );
	if(!function_exists ('wd_print_inline_script')){
		function wd_print_inline_script(){
	?>	
		<script type="text/javascript">
			<?php if( defined('ICL_LANGUAGE_CODE') ): ?>
				var _ajax_uri = '<?php echo admin_url('admin-ajax.php?lang='.ICL_LANGUAGE_CODE, 'relative');?>';
			<?php else: ?>
				var _ajax_uri = '<?php echo admin_url('admin-ajax.php', 'relative');?>';
			<?php endif; ?>
			var _on_phone = <?php echo WD_IS_MOBILE === true ? 1 : 0 ;?>;
			var _on_tablet = <?php echo WD_IS_TABLET === true ? 1 : 0 ;?>;
			var _is_ec_page = <?php echo wd_is_ec_page()?1:0 ?>;
			//if(navigator.userAgent.indexOf(\"Mac OS X\") != -1)
			//	console.log(navigator.userAgent);
			<?php 
				global $wd_data;
				
			?>
			var _enable_sticky_menu = <?php echo absint($wd_data['wd_sticky_menu']); ?>;
			jQuery('.menu li').each(function(){
				if(jQuery(this).children('.sub-menu').length > 0) jQuery(this).addClass('parent');
			});
		</script>
	<?php
		}
	}	
	//add_action( 'wd_before_main_container', 'wd_print_ads_block', 20 );
	if(!function_exists ('wd_print_ads_block')){
		function wd_print_ads_block(){
			global $page_datas;
	?>	
			<div class="header_ads_wrapper">
				<?php 
					if( !is_home() && !is_front_page() ){
						if( !is_page() ){
							printHeaderAds();
						}else{
							if( isset($page_datas['hide_ads']) && absint($page_datas['hide_ads']) == 0 )
								printHeaderAds();
						}
						
					}
						
				?>
			</div>
	<?php
		}
	}	


	add_action( 'wd_before_body_end', 'wd_before_body_end_widget_area', 10 );
	if(!function_exists ('wd_before_body_end_widget_area')){
		function wd_before_body_end_widget_area(){
	?>	
	
		<div class="container">
				<div class="body-end-widget-area">
					<?php
						if ( is_active_sidebar( 'body-end-widget-area' ) ) : ?>
							<ul class="xoxo">
								<?php dynamic_sidebar( 'body-end-widget-area' ); ?>
							</ul>
						<?php endif; ?>						
				</div><!-- end #footer-first-area -->
		</div>
	<?php
		}
	}	
	
	add_action( 'wd_before_footer_end', 'wd_before_body_end_content', 10 );
	if(!function_exists ('wd_before_body_end_content')){
		function wd_before_body_end_content(){
		global $wd_data;
	?>	
		
		<?php if(!wp_is_mobile() && $wd_data['wd_totop']): ?>
		<div id="to-top" class="scroll-button">
			<a class="scroll-button" href="javascript:void(0)" title="<?php _e('Back to Top','wpdance');?>"></a>
		</div>
		<?php endif; ?>
		
		<!--<div class="loading-mark-up">
			<span class="loading-image"></span>
		</div>
		<span class="loading-text"></span>-->
	
	<?php
		}
	}
	
?>