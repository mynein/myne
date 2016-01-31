<?php
	/* Add custom layout for post, portfolio */
	global $post;
	
	$_post_config = get_post_meta($post->ID,THEME_SLUG.'custom_post_config',true);
	$_default_post_config = array(
					'video' 					=> ''	/*$datas['layout']*/
					,'layout' 					=> '0'	/*$datas['layout']*/
					,'left_sidebar' 			=> '0'  /*$datas['left_sidebar']*/
					,'right_sidebar' 			=> '0'	/*$datas['right_sidebar'] */		
	);	
	
	if( strlen($_post_config) > 0 ){
		$_post_config = unserialize($_post_config);
		if( is_array($_post_config) && count($_post_config) > 0 ){
			$_post_config['video'] = ( isset($_post_config['video']) && strlen($_post_config['video']) > 0 ) ? $_post_config['video'] : $_default_post_config['video'];
			$_post_config['layout'] = ( isset($_post_config['layout']) && strlen($_post_config['layout']) > 0 ) ? $_post_config['layout'] : $_default_post_config['layout'];
			$_post_config['left_sidebar'] = ( isset($_post_config['left_sidebar']) && strlen($_post_config['left_sidebar']) > 0 ) ? $_post_config['left_sidebar'] : $_default_post_config['left_sidebar'];
			$_post_config['right_sidebar'] = ( isset($_post_config['right_sidebar']) && strlen($_post_config['right_sidebar']) > 0 ) ? $_post_config['right_sidebar'] : $_default_post_config['right_sidebar'];
		}
	}else{
		$_post_config = $_default_post_config;
	}

?>

<div class="select-layout area-config area-config1 wd-metabox-layout">
	<div class="area-inner">
		<div class="area-inner1">
			<div class="area-content">
					<div>
						<label>Video URL</label>	
						<div class="bg-input">
							<div class="bg-input-inner config-product">
								<input name="single_video" value="<?php echo esc_url($_post_config["video"]); ?>" type="text" />
								<span class="description">Input video URL(Vimeo, Youtube, Dailymotion)</span>
							</div>
						</div>
					</div>
					<div>
						<label>Page Layout</label>	
						<div class="bg-input select-box ">
							<div class="bg-input-inner config-product">
								<select name="single_layout" id="_single_prod_layout">
									<option value="0" <?php if( strcmp($_post_config["layout"],'0') == 0 ) echo "selected='selected'";?>>Default</option>
									<option value="0-1-0" <?php if( strcmp($_post_config["layout"],'0-1-0') == 0 ) echo "selected='selected'";?>>Fullwidth</option>
									<option value="0-1-1" <?php if( strcmp($_post_config["layout"],'0-1-1') == 0 ) echo "selected='selected'";?>>Right Sidebar</option>
									<option value="1-1-0" <?php if( strcmp($_post_config["layout"],'1-1-0') == 0 ) echo "selected='selected'";?>>Left Sidebar</option>
									<option value="1-1-1" <?php if( strcmp($_post_config["layout"],'1-1-1') == 0 ) echo "selected='selected'";?>>Left & Right Sidebar</option>
								</select>
							</div>
						</div>
					</div>
					
					<div>
						<label>Left Sidebar</label>	
						<div class="bg-input select-box ">
							<div class="bg-input-inner config-product">
								<select name="single_left_sidebar" id="_single_prod_left_sidebar">
									<option value="0" <?php if( strcmp($_post_config["left_sidebar"],'0') == 0 ) echo "selected='selected'";?>>Default</option>
									<?php
										global $default_sidebars;
										foreach( $default_sidebars as $key => $_sidebar ){
											$_selected_str = ( strcmp($_post_config["left_sidebar"],$_sidebar['id']) == 0 ) ? "selected"  : "";
											echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
										}
									?>
								</select>
							</div>
						</div>
					</div>

					<div>
						<label>Right Sidebar</label>
						<div class="bg-input select-box ">
							<div class="bg-input-inner config-product">
								<select name="single_right_sidebar" id="_single_prod_right_sidebar">
									<option value="0" <?php if( strcmp($_post_config["right_sidebar"],'0') == 0 ) echo "selected='selected'";?>>Default</option>
									<?php
										global $default_sidebars;
										foreach( $default_sidebars as $key => $_sidebar ){
											$_selected_str = ( strcmp($_post_config["right_sidebar"],$_sidebar['id']) == 0 ) ? "selected"  : "";
											echo "<option value='{$_sidebar['id']}' {$_selected_str}>{$_sidebar['name']}</option>";
										}
									?>
								</select>
							</div>
						</div>							
					</div>			
			
				<input type="hidden" name="custom_post_layout" class="change-layout" value="custom_single_post_layout"/>
			</div><!-- .area-content -->
		</div>	
	</div>	
</div><!-- .select-layout -->