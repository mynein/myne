<?php 
	global $post;
	$revolution_exists = ( class_exists('RevSlider') && class_exists('UniteFunctionsRev') );
	$layerslider_exists = ( class_exists('LS_Sliders') );
	$datas = unserialize(get_post_meta($post->ID,THEME_SLUG.'page_configuration',true));
	$datas = wd_array_atts(array(
										"page_layout" 					=> '0'
										,"header_layout"				=> ''
										,"page_column"					=> '0-1-0'
										,"left_sidebar" 				=>'primary-widget-area'
										,"right_sidebar" 				=> 'primary-widget-area'
										,"page_slider" 					=> 'none'
										,"page_revolution" 				=> ''
										,"page_layerslider"				=> ''	
										,"hide_breadcrumb" 				=> 0		
										,"hide_title" 					=> 0											
										,"hide_top_content_widget_area"	=> 1											
										,"page_logo"					=> ''											
								),$datas);								
?>
<div class="page_config_wrapper">
	<div class="page_config_wrapper_inner">
		<input type="hidden" value="1" name="_page_config">
		<?php wp_nonce_field( "_update_page_config", "nonce_page_config" ); ?>
		<ul class="page_config_list">
			<li class="first">
				<p>
					<label><?php _e('Layout Style','wpdance');?> </label>
					<select name="page_layout" id="page_layout">
						<option value="0" <?php if( strcmp($datas['page_layout'],'0') == 0 ) echo "selected";?>>Inherit</option>
						<option value="wide" <?php if( strcmp($datas['page_layout'],'wide') == 0 ) echo "selected";?>>Wide</option>
						<option value="boxed" <?php if( strcmp($datas['page_layout'],'boxed') == 0 ) echo "selected";?>>Boxed</option>
					</select>
				</p> 
			</li>
			<?php 
				$main_content_show = 'style="display:none;"';
				$header_show = 'style="display:none;"';
				$footer_show = 'style="display:none;"';
				$main_slider_show = 'style="display:none;"';
				$banner_show = 'style="display:none;"';
				if( strcmp($datas['page_layout'],'wide') == 0 ) {
					$main_content_show = "";
					$header_show = "";	
					$footer_show = "";
					$main_slider_show = "";
					$banner_show ="";
				}
			?>
			<li>
				<p>
					<label><?php _e('Header Layout','wpdance');?> </label>
					<select name="header_layout" id="header_layout">
						<option value="" <?php if( strcmp($datas['header_layout'],'') == 0 ) echo "selected";?>>Inherit</option>
						<option value="v1" <?php if( strcmp($datas['header_layout'],'v1') == 0 ) echo "selected";?>>Layout 1</option>
						<option value="v2" <?php if( strcmp($datas['header_layout'],'v2') == 0 ) echo "selected";?>>Layout 2</option>
						<option value="v3" <?php if( strcmp($datas['header_layout'],'v3') == 0 ) echo "selected";?>>Layout 3</option>
					</select>
				</p> 
			</li>
			<li>
				<p>
					<label><?php _e('Page Layout','wpdance');?> </label>
					<select name="page_column" id="page_column">
						<option value="0-1-0" <?php if( strcmp($datas['page_column'],'0-1-0') == 0 ) echo "selected";?>>Fullwidth</option>
						<option value="1-1-0" <?php if( strcmp($datas['page_column'],'1-1-0') == 0 ) echo "selected";?>>Left Sidebar</option>
						<option value="0-1-1" <?php if( strcmp($datas['page_column'],'0-1-1') == 0 ) echo "selected";?>>Right Sidebar</option>
						<option value="1-1-1" <?php if( strcmp($datas['page_column'],'1-1-1') == 0 ) echo "selected";?>>Left & Right Sidebar</option>
					</select>
				</p> 
			</li>			
			<li>
				<p>
					<label><?php _e('Hide Breadcrumb','wpdance');?> </label>
					<select name="hide_breadcrumb" id="_hide_breadcrumb">
						<option value="0" <?php if( absint($datas['hide_breadcrumb']) == 0 ) echo "selected";?>>No</option>
						<option value="1" <?php if( absint($datas['hide_breadcrumb']) == 1 ) echo "selected";?>>Yes</option>
					</select>
				</p> 			
			</li>
			<li>
				<p>
					<label><?php _e('Hide Page Title','wpdance');?> </label>
					<select name="hide_title" id="_hide_title">
						<option value="0" <?php if( absint($datas['hide_title']) == 0 ) echo "selected";?>>No</option>
						<option value="1" <?php if( absint($datas['hide_title']) == 1 ) echo "selected";?>>Yes</option>
					</select>
				</p> 			
			</li>
			<li>
				<p>
					<label><?php _e('Hide Top Content Widget Area','wpdance');?> </label>
					<select name="hide_top_content_widget_area" id="_hide_top_content_widget_area">
						<option value="0" <?php if( absint($datas['hide_top_content_widget_area']) == 0 ) echo "selected";?>>No</option>
						<option value="1" <?php if( absint($datas['hide_top_content_widget_area']) == 1 ) echo "selected";?>>Yes</option>
					</select>
				</p> 			
			</li>
			

			<li>
				<p>
					<label><?php _e('Left Sidebar','wpdance');?> </label>
					<select name="left_sidebar" id="_left_sidebar">
						<?php
							global $default_sidebars;
							foreach( $default_sidebars as $key => $_sidebar ){
								$_selected_str = ( strcmp($datas["left_sidebar"],$_sidebar['id']) == 0 ) ? "selected='selected'"  : "";
								echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
							}
						?>
					</select>
				</p> 
			</li>
			<li>
				<p>
					<label><?php _e('Right Sidebar','wpdance');?> </label>
					<select name="right_sidebar" id="_right_sidebar">
						<?php
							global $default_sidebars;
							foreach( $default_sidebars as $key => $_sidebar ){
								$_selected_str = ( strcmp($datas["right_sidebar"],$_sidebar['id']) == 0 ) ? "selected='selected'"  : "";
								echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
							}
						?>
					</select>
				</p> 
			</li>			
			
			<li>
				<p>
					<label><?php _e('Page Slider','wpdance');?> </label>
					<select name="page_slider" id="page_slider">
						<option value="none" <?php if( strcmp($datas['page_slider'],'none') == 0 ) echo "selected";?>>No Slider</option>
						<?php if( $revolution_exists ):?>
						<option value="revolution" <?php if( strcmp($datas['page_slider'],'revolution') == 0 ) echo "selected";?>>Revolution Slider</option>
						<?php endif; ?>
						<?php if( $layerslider_exists):?>
						<option value="layerslider" <?php if( strcmp($datas['page_slider'],'layerslider') == 0 ) echo "selected";?>>Layer Slider</option>
						<?php endif; ?>
					</select>
				</p> 			
			</li>
			<?php if( $revolution_exists ): ?>
			<li>
				<p>
					<label><?php _e('Revolution Slider','wpdance');?> </label>
					<?php
						$slider = new RevSlider();
						$arrSliders = $slider->getArrSlidersShort();
						$sliderID = $datas['page_revolution'];
						if(count($arrSliders) > 0):
					?>
					<?php echo UniteFunctionsRev::getHTMLSelect($arrSliders,$sliderID,'name="page_revolution" id="page_revolution_id"',true); ?>					
					<?php 
						else:
							echo '<strong>Please Create A Revolution Slider.</strong>';
						endif;
					?>
				</p> 			
			</li>
			<?php endif;?>
			<?php if( $layerslider_exists):?>
			<li>
				<p>
					<label><?php _e('LayerSlider','wpdance');?> </label>
					
					<?php
						$arr_layerSliders = LS_Sliders::find();
						
						$sliderID = $datas['page_layerslider'];
						$layer_html = '';
						if(count($arr_layerSliders) > 0) :
							$layer_html .= '<select name="page_layerslider" id="page_layerslider_id">';
							$selected = '';
							foreach($arr_layerSliders as $layer){
								if($layer['id'] == $datas['page_layerslider']){
									$page_layerslider = 'selected="selected"';
								}	
								$layer_html .= '<option '.$selected.' value="'.$layer['id'].'">'.$layer['name'].'</option>';
							}
							$layer_html.='</select>';
						else:
							$layer_html .= '<span>Please Create A Layer Slider.</span>';
						endif;
					?>
					<?php echo ($layer_html); ?>
				</p> 			
			</li>
			<?php endif;?>
			<li>
				<p>
					<label><?php _e('Page Logo','wpdance');?> </label>
					<input type="text" name="page_logo" id="_page_logo" value="<?php echo esc_attr($datas['page_logo']) ?>" class="upload_field" />
					<input type="button" class="button button-primary upload_button" value="Select image" />
					<input type="button" class="button clear_button" value="Clear image" <?php echo (strlen($datas['page_logo']) == 0)?'disabled':'' ?> />
					<?php if( strlen($datas['page_logo']) > 0 ): ?>
					<img src="<?php echo esc_url($datas['page_logo']); ?>" class="preview_image" />
					<?php endif; ?>
				</p> 			
			</li>		
		</ul>
	</div>
</div>
