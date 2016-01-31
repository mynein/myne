<?php 
	if(!function_exists('features_wpdance_function')){
		function features_wpdance_function($atts,$content){
			extract(shortcode_atts(array(
				'image'			=> ''
				,'title'		=> ''
				,'desc'			=> ''
				,'min_height'	=> '0'
				,'link'			=> '#'
				,'text_more'	=> ''
			),$atts));
			
			ob_start();
			?>
			<div class="wd_shortcode_feature_wpdance" style="min-height:<?php echo esc_attr($min_height) ?>">
				<div class="feature_wpdance_wrapper">
					<img alt="<?php echo esc_attr($title) ?>" src="<?php echo esc_url($image) ?>" />
					<h3 class="font-second"><?php echo esc_html($title) ?></h3>
					<div class="desc"><?php echo esc_html($desc) ?></div>
					<div class="more-link"><a class="more" href="<?php echo esc_url($link) ?>"><?php echo esc_html($text_more); ?></a></div>
				</div>
			</div>
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
	add_shortcode('feature_wpdance','features_wpdance_function');
?>