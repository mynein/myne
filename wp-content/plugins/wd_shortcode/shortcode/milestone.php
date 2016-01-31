<?php
function wd_milestone_shortcode($atts, $content){
	extract( shortcode_atts(array(
					'number'			=>  '0'
					,'symbol'			=> ''
					,'subject'			=> ''
				), $atts)
			);
	if( !is_numeric($number) ){
		$number = 0;
	}
	
	ob_start();
	?>
	<div class="wd_milestone">
		<?php if( !empty($symbol) ): ?>
		<div class="symbol">
			<span class="<?php echo esc_attr($symbol); ?>"></span>
		</div>
		<?php endif; ?>
		<div class="number" data-num="<?php echo esc_attr($number) ?>">
			<?php echo esc_html($number); ?>
		</div>
		<div class="subject">
			<?php echo esc_html($subject); ?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('wd_milestone', 'wd_milestone_shortcode');
?>