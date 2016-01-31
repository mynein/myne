<?php
	/* Add custom layout for post, portfolio */
	global $post,$single_prod_datas;
	$single_product_config = get_option(THEME_SLUG.'single_product_config','');
	$single_product_config = unserialize($single_product_config);

?>

<div class="select-layout area-config area-config1">
	<div class="area-inner">
		<div class="area-inner1">
			<h3 class="area-title"><?php _e('Additional Information','wpdance'); ?></h3>
			<?php $this->showTooltip(__("Additional Information",'wpdance'),__('This content show on top of left/right sidebar. Product must have a sidebar.','wpdance')); ?>
			
			<?php
				$wd_ads_sidebars = maybe_unserialize( get_post_meta( $post->ID, THEME_SLUG.'product_ads_sidebar', true ) );
				$wd_ads_count = sizeof( $wd_ads_sidebars );
				$i=-1;
			?>
			<div class="wd_area-content">
				<div class="wd_area_wrapper" >
							<?php 
								if($wd_ads_sidebars && $wd_ads_count > 0):
									foreach($wd_ads_sidebars as $wd_ads_sidebar ) {
										//if ( ! $wd_ads_sidebar['name'] )
										//	continue;
							?>
										<div class="wd_item_ads">
											<div class="wd_ads_sidebar">
												<div class="wd_ads_remove_bt">
													<button type="button" class="button wd_remove_ads_sidebar"><?php _e( 'Remove', 'wpdance' ); ?></button>
												</div>	
												<div>
													<div class="wd_ads_title">
														<label><?php _e( 'Title', 'wpdance' ); ?>:</label>
														<input type="text" name="wd_ads_name[]" class="attribute_position" value="<?php echo esc_attr($wd_ads_sidebar['name']); ?>" />
													</div>
													<div class="wd_ads_cont">
														<label><?php _e( 'Content', 'wpdance' ); ?>:</label>
														<textarea name="wd_ads_content[]" cols="40" rows="2"><?php echo esc_html($wd_ads_sidebar['content']); ?></textarea>
													</div>
													<div class="wd_ads_pos">
														<label><?php _e( 'Position', 'wpdance' ); ?>:</label>
														<select name="wd_ads_position[]">
															<option <?php if($wd_ads_sidebar['position'] == 'left') { echo 'selected="selected"'; } ?> value="left">Left</option>
															<option <?php if($wd_ads_sidebar['position'] == 'right') { echo 'selected="selected"'; } ?> value="right">Right</option>
														</select>
													</div>
												</div>
											</div>
										</div>
							<?php 
									}
								endif;
							?>
				</div>
				<p class="wd_toolbar">
					<button type="button" class="button button-primary wd_add_new_ads_sidebar"><?php _e( 'Add', 'wpdance' ); ?></button>
				</p>				
			
				<input type="hidden" name="custom_product_ads_sidebar" class="change-layout" value="custom_single_prod_ads_sidebar"/>
			</div><!-- .area-content -->
		</div>	
	</div>	
</div><!-- .select-layout -->