<?php 
if( !function_exists('wd_video_shortcode') ){
	function wd_video_shortcode($atts, $content = null){
		extract(shortcode_atts(array(
				'video_mp4'			=>	''
				,'video_ogg'		=>	''
				,'video_webm'		=>	''
				,'volume'			=> 0 /* 0 -> 1*/
				,'height'			=> '300'
				,'bg_opacity'		=> "0.35"
				,'bg_color'			=> 'black'
				,'bg_image'			=> ''
				,'auto_play'		=> 0
				,'loop'				=> 1
			),$atts));
			
			if( empty($video_mp4) && empty($video_ogg) && empty($video_webm) ){
				return;
			}
			
			$bg_opacity = is_numeric($bg_opacity)? $bg_opacity: 0.35;
			
			$rand_id = "wd_video_" . rand(0, 1000);
			
			$style = '';
			$style .= '#'.$rand_id.'{height:'.$height.'px;}';
			$style .= '#'.$rand_id.' .bg_overlay .bg_color{background-color:'.(($bg_color == 'black')? 'rgba(0,0,0,'.$bg_opacity.')' : 'rgba(255,255,255,'.$bg_opacity.')').';}';
			
			if( !empty($bg_image) ){
				$image_url = wp_get_attachment_url($bg_image);
				if( $image_url ){
					$style .= '#'.$rand_id.' .bg_overlay{background-image:url('.$image_url.');}';
				}
			}
			
			ob_start();
			?>
			<div class="wd_video" id="<?php echo esc_attr($rand_id); ?>">
				
				<div class="bg_overlay">
					<div class="bg_color"></div>
					<div class="cover_button <?php echo ($auto_play)?'playing':'paused'; ?>"></div>
				</div>
				
				<video height="<?php echo esc_attr($height) ?>" <?php echo ($auto_play)? 'autoplay':'' ;?> <?php echo ($loop)? 'loop':'' ;?> <?php echo !empty($bg_image)?'preload="none"':'' ?>>
					<source src="<?php echo esc_url($video_mp4); ?>" type="video/mp4">
					<source src="<?php echo esc_url($video_webm); ?>" type="video/webm">
					<source src="<?php echo esc_url($video_ogg); ?>" type="video/ogg">
				</video>
			</div>
			
			<style type="text/css">
				<?php echo $style; ?>
			</style>
			
			<script type="text/javascript">
				
				jQuery(document).ready(function() {
					"use strict";
					var rand_id = '<?php echo esc_js($rand_id); ?>';
					var video = jQuery('#'+rand_id).find('video');
					var video_dom = video.get(0);
					video.prop("volume", <?php echo esc_js($volume); ?>);
					
					var bg_color = jQuery('#'+rand_id +' .bg_color').css('background-color');
					var bg_image = jQuery('#'+rand_id +' .bg_overlay').css('background-image');
					
					<?php if( $auto_play ): ?>
						jQuery('#'+rand_id+' .cover_button').addClass('playing');
						jQuery('#'+rand_id+' .bg_color').css({'background-color': 'transparent'});
						jQuery('#'+rand_id+' .bg_overlay').css({'background-image': 'none'});
					<?php endif; ?>
					
					jQuery('#'+rand_id).bind('click', function(){
						if( video_dom.paused ) {
							jQuery(this).find('.cover_button').removeClass('paused').addClass('playing');
							jQuery(this).find('.bg_color').css({'background-color': 'transparent'});
							jQuery(this).find('.bg_overlay').css({'background-image': 'none'});
							video_dom.play();
						}
						else{
							jQuery(this).find('.cover_button').removeClass('playing').addClass('paused');
							jQuery(this).find('.bg_color').css({'background-color': bg_color});
							jQuery(this).find('.bg_overlay').css({'background-image': bg_image});
							video_dom.pause();
						}
					});

				});
			</script>
			<?php
			return ob_get_clean();
	}
}
add_shortcode('wd_video', 'wd_video_shortcode');


if(!function_exists ('ew_img_video')){
	function ew_img_video($atts){
		extract(shortcode_atts(array(
			'src_thumb'		=> 	'',
			'src_zoom_img' 	=> 	'',
			'link_video'	=>	'',
			'width_thumb' 	=> 	'190',
			'height_thumb' 	=> 	'103',
			'type'			=>	'',
			'use_lightbox'	=>	'true',
			'custom_link'	=>	'#',
			'class'			=>	'',
			'title'			=>	''
		),$atts));
		$width_div = $width_thumb + 8;
		$height_div = $height_thumb + 8;
		$left_fancy = floor(($width_div - 30)/2);
		$top_fancy = floor(($height_div - 30)/2);
		$result = "<div class='image-style {$class}' style='width:{$width_div}px;height:{$height_div}px'>";
		
		if($type == 'video'){
			if($link_video){
				if(strstr($link_video,'youtube.com') || strstr($link_video,'youtu.be')){
					 $class_fancy = ' youtube';
					 $big_video_url = 'http://www.youtube.com/watch?v='.  wp_parse_youtube_link($link_video);
				}
				else{
					$class_fancy = 'vimeo';
					$big_video_url = $link_video;
				}
				$result .= "<a class='thumbnail' href='".$custom_link."' style='width:{$width_thumb}px;height:{$height_thumb}px'>".get_thumbnail_video($link_video,$width_thumb,$height_thumb)."</a>";
				if($use_lightbox == 'true')
					$result .= "<div class='fancybox_container' style='display:none;' id='img-video-".rand(0,1000)."{$width_thumb}{$height_thumb}'>
							<a title='{$title}' class='fancybox_control {$class_fancy}' href='{$big_video_url}' style='left:{$left_fancy}px;top:{$top_fancy}px'>Lightbox</a>
						</div>";
			}
		}
		else {
			if($src_thumb)
				$result .= "<a href='{$custom_link}' class='thumbnail' style='width:{$width_thumb}px;height:{$height_thumb}px'><img width='{$width_thumb}' height='{$height_thumb}' src='{$src_thumb}'/></a>";
			if($src_zoom_img && $use_lightbox == 'true')	
				$result .= "<div class='fancybox_container' style='display:none;' id='img-video-".rand(0,1000)."{$width_thumb}{$height_thumb}'>
						<a title='{$title}' class='fancybox_control' href='{$src_zoom_img}' style='left:{$left_fancy}px;top:{$top_fancy}px'>Lightbox</a>
					</div>";
		}
		
		$result .= "</div>";
		
		return $result;
	}
}
add_shortcode('ew_img_video','ew_img_video');
?>