<?php
	function toRGB($Hex){
		if (substr($Hex,0,1) == "#")
			$Hex = substr($Hex,1);
			
			

		$R = substr($Hex,0,2);
		$G = substr($Hex,2,2);
		$B = substr($Hex,4,2);

		$R = hexdec($R);
		$G = hexdec($G);
		$B = hexdec($B);

		$RGB['R'] = $R;
		$RGB['G'] = $G;
		$RGB['B'] = $B;

		return $RGB;
	}

	add_action('of_save_options_after','save_custom_style',10000);
	add_action('wp_enqueue_scripts', 'custom_style_inline_script');
	function save_custom_style( $data = array() ){
		$check_custom = 0;
		//wrong input type
		if( !is_array($data) ){
			return -1;
		}
		$cache_file = THEME_CACHE.'custom.css';	
		$data_style = $data['data'];			
		try{	
		
			ob_start();
			//font
			if (file_exists(THEME_DIR."/config_xml/font_config.xml")) {	
				$objXML = simplexml_load_file(THEME_DIR."/config_xml/font_config.xml");
				foreach ($objXML->children() as $child) {	//items
					$name =  $child->name;
					$slug =  $child->slug; 
					$type =  $child->type; 
					$std =  $child->std; 
					$selector =  $child->selector;
					if( gettype($selector->node) == 'object' ){
						$selector_child = $selector->children();
					}
					
					if( !isset($data_style["wd_".$slug."_googlefont_enable"]) ){
						continue;
					}
					
					$font_name = $data_style["wd_".$slug."_googlefont_enable"] == 1 ? esc_attr( $data_style["wd_".$slug."_family"] ) : esc_attr( $data_style["wd_".$slug."_googlefont"] );

					if((strtolower($font_name) != strtolower($std)) || ($data_style["wd_".$slug."_googlefont_enable"] == 0 && $type == "family_font") || ($data_style["wd_".$slug."_googlefont_enable"] == 1 && $type == "google_font")){
						if( isset($selector_child->selector_normal) ){
							echo $selector_child->selector_normal.'{';
							echo 'font-family: "' . $font_name . '";';
							echo '}'."\n";
						}
						if( isset($selector_child->selector_important) ){
							echo $selector_child->selector_important.'{';
							echo 'font-family: "' . $font_name . '" !important;';
							echo '}'."\n";
						}
						if( !(isset($selector_child->selector_normal) && isset($selector_child->selector_important)) ){
							echo $selector.'{';
							echo 'font-family: "' . $font_name . '";';
							echo '}'."\n";
						}
						
						$check_custom = 1;
					}
				}
			}
			
			$xml_file = isset($data_style["wd_color_scheme"]) && strlen(trim($data_style["wd_color_scheme"])) > 0 ? $data_style["wd_color_scheme"] : 'color_default';
			//color
			if (file_exists(THEME_DIR."/config_xml/".$xml_file.".xml")) {	
				$objXML_color = simplexml_load_file(THEME_DIR."/config_xml/".$xml_file.".xml");
				foreach ($objXML_color->children() as $child) {	 //items_setting => general
					$group_name = (string)$child->text;						//text
					foreach ($child->items->children() as $childofchild) { //items => item
					
						$name =  (string)$childofchild->name;				//name
						$slug =  (string)$childofchild->slug; 				//slug
						$std =  (string)$childofchild->std; 				//std
						
						$css = '';
						if($childofchild->getName()=='background_item'){
						
							if( !isset($data_style['wd_'.$slug.'_image']) ){
								continue;
							}
							
							if($data_style["wd_".$slug.'_image']){
								$data_style = apply_filters('of_options_after_load', $data_style);
								$css .= 'background-image: url("'.esc_url($data_style["wd_".$slug.'_image']).'");'; 
							}
							if($data_style["wd_".$slug.'_repeat'] && $data_style["wd_".$slug.'_repeat'] != "repeat"){
								$css .= 'background-repeat: '.$data_style["wd_".$slug.'_repeat'].';' ;
							}
							if($data_style["wd_".$slug.'_position'] && $data_style["wd_".$slug.'_position'] != "left top"){
								$css .=  'background-position: '.$data_style["wd_".$slug.'_position'].';';
							}
						}
						
						if( !isset($data_style["wd_".$slug]) ){
							continue;
						}
						
						//if value difference or  background item && css exist
						if($xml_file != 'color_default' || $data_style["wd_".$slug] != $std || ( ($childofchild->getName()=='background_item') && strlen(trim($css)) >0 )){
							$frontend =  $childofchild->frontend;	//frontend		
							foreach ($frontend->children() as $childoffrontend) {	//frondend => f*
								$attr = $childoffrontend->attribute;
								$selector = $childoffrontend->selector;
								if( gettype($selector->node) == 'object' ){
									$selector_child = $selector->children();
								}	
									if( isset($selector_child->selector_normal) ){
										echo $selector_child->selector_normal.'{';
										if($xml_file != 'color_default' || $data_style["wd_".$slug] != $std){
											echo $attr.': '.$data_style["wd_".$slug].';';
										}
										echo $css;
										echo '}'."\n";
									}
									if( isset($selector_child->selector_important) ){
										echo $selector_child->selector_important.'{';
										if($xml_file != 'color_default' || $data_style["wd_".$slug] != $std){
											echo $attr.': '.$data_style["wd_".$slug].' !important;';
										}
										echo $css;
										echo '}'."\n";
									}
									if( !(isset($selector_child->selector_normal) && isset($selector_child->selector_important)) ){
										echo $selector.'{';
										if($xml_file != 'color_default' || $data_style["wd_".$slug] != $std){
											echo $attr.': '.$data_style["wd_".$slug].';';
										}
										echo $css;
										echo '}'."\n";
									}
									
									$check_custom = 1;
							}	
						}			
					}
				}	
			}
			if(isset($data_style["wd_custom_css"]) && strlen(trim($data_style["wd_custom_css"])) > 0){
				echo $data_style["wd_custom_css"];
				$check_custom = 1;
			}		
			?>
			<?php 
			$file = @fopen($cache_file, 'w');
			if( $file != false ){
				@fwrite($file, ob_get_contents()); 
				@fclose($file); 
			}else{
				define('USING_CSS_CACHE', false);
			}
			update_option(THEME_SLUG.'custom_style', ob_get_contents());
			update_option(THEME_SLUG.'custom_check', $check_custom);
			update_option(THEME_SLUG.'color_select', $xml_file);
			//ob_end_flush();		
			ob_end_clean();
			
			return USING_CSS_CACHE == true ? 1 : 0;
		}catch(Excetion $e){
			// $result = new StdClass();
			// $result->status = array();
			// return $result;
			return -1;
		}
	}
		
	function wd_load_gg_fonts() {
		global $wd_font_name,$wd_font_size;	
		$font_size_str = "";
		if( isset($wd_font_size) && strlen($wd_font_size) > 0 ){
			$font_size_str = ":{$wd_font_size}";
		}
		if( isset($wd_font_name) && strlen( $wd_font_name ) > 0 ){
			$font_name_id = strtolower($wd_font_name);
			$protocol = is_ssl() ? 'https' : 'http';
			wp_enqueue_style( "goodly-{$font_name_id}", "{$protocol}://fonts.googleapis.com/css?family={$wd_font_name}{$font_size_str}" );		
		}
	}		
		
	function custom_style_inline_script(){
		global $wd_data;
		$check_custom = get_option(THEME_SLUG.'custom_check');
		if($check_custom == 0) { return; }
		global $wd_font_name,$wd_font_size;	
		
		//font
		if (file_exists(THEME_DIR."/config_xml/font_config.xml")) {	
			$objXML = simplexml_load_file(THEME_DIR."/config_xml/font_config.xml");
			foreach ($objXML->children() as $child) {	//items
				$name =  $child->name;
				$slug =  $child->slug; 
				$type =  $child->type; 
				$std =  $child->std; 
				$selector =  $child->selector;
				
				$font_name =  esc_attr( $wd_data["wd_".$slug."_googlefont"] );
				$font_name  = str_replace( " ", "+", $font_name );

				if( $wd_data["wd_".$slug."_googlefont_enable"] == 0 && strcmp($font_name,'none') != 0 ){
						$wd_font_name = trim( $font_name );
						//$wd_font_size = trim( $font_weight );
						wd_load_gg_fonts();
				}

			}
		}
		if( USING_CSS_CACHE == false ){
			global $custom_style;
			echo '<style type="text/css">';
			echo get_option(THEME_SLUG.'custom_style', '');
			echo '</style>';
		}		
	}
		
			
		
	function include_cache_css(){
		global $wd_data;
		$custom_cache_file = THEME_CACHE.'custom.css';
		$custom_cache_file_uri = THEME_URI.'/cache_theme/custom.css';
		$check_custom = get_option(THEME_SLUG.'custom_check');
		if (file_exists($custom_cache_file) && $check_custom == 1) {
			wp_register_style( 'custom-style',$custom_cache_file_uri );
			wp_enqueue_style('custom-style');
		}
		
	}

	if( USING_CSS_CACHE == true ){
		add_action('wp_enqueue_scripts','include_cache_css',999999999);
	}	
?>