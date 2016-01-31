<?php

	if(!function_exists('banner_shortcode_function')){
		function banner_shortcode_function($atts,$content){
			extract(shortcode_atts(array(
				'link_url'				=> "#" 
				,'bg_image' 			=> ""
				,'title'				=> "Title"  
				,'subtitle'				=> ""
				,'padding_subtitle'		=> 0
				,'desc'					=> ""				
				,'sep_padding'			=> "12%"
				,'color'				=> "#fff"
				,'style_responsive'		=> "vertical-responsive"
			),$atts));
			ob_start();
			?>
			
			<div class="shortcode_wd_banner <?php echo esc_attr($style_responsive) ?>">
				<a class="shortcode_wd_banner_inner" title="<?php echo esc_attr($title) ?>" href="<?php echo esc_url($link_url) ?>" >
					
					<img alt="<?php echo esc_attr($title) ?>" src="<?php echo esc_url($bg_image); ?>" />
					
					<div class="group-title" style="padding:<?php echo esc_attr($sep_padding); ?>">
						<div class="heading-title banner-sub-title" style="color:<?php echo esc_attr($color);?>;padding:<?php echo esc_attr($padding_subtitle) ?> "><?php echo esc_html($subtitle); ?></div>
						
						<div class="heading-title banner-title" style="color:<?php echo esc_attr($color); ?>"><?php echo esc_html($title); ?></div>
					</div>
					<div style="color:<?php echo esc_attr($color); ?>" class="desc"><?php echo esc_html($desc); ?></div>
					
				</a>
			</div>
					
			<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	}
	add_shortcode('banner','banner_shortcode_function');
?>