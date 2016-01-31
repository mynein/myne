<?php
/**
 * EW Video Widget
 */
if(!class_exists('WP_Widget_Ew_video')){
	class WP_Widget_Ew_video extends WP_Widget{

		function WP_Widget_Ew_video(){
			$widgetOps = array(
				"classname"   => "ew-video",
				"description" => "Add any type of Videos as a widget.",
			);
			$controlOps = array(
				"width"   => 190,
				"height"  => 140,
				"id_base" => "video-widget"
			);
			$this->WP_Widget("video-widget", "WD - Videos", $widgetOps, $controlOps);
		}

		function widget($args, $instance){
			extract($args);

			$title = apply_filters("widget_title", $instance["title"]);
			$count = absint($instance["count"]);

			echo $before_widget;
			echo $before_title . $title . $after_title;

			for ($i = 1; $i <= $count; $i++) { ?>
			<?php
			if ($i == 1) { $class = "open"; } else { $class = "hide"; } ?>
			<div class="<?php echo $class; ?>" id="ew-video-cat-<?php echo $i; ?>">

			<?php if ($instance["video" . $i]) { // Do we embed a video from a website?
				$videocode = $instance["video" . $i];
				$videocode = preg_replace("/(width\s*=\s*[\"\'])[0-9]+([\"\'])/i", "$1 268 $2", $videocode);
				$videocode = preg_replace("/(height\s*=\s*[\"\'])[0-9]+([\"\'])/i", "$1 160 $2", $videocode);
				$videocode = str_replace("<embed","<param name='wmode' value='transparent'></param><embed",$videocode);
				$videocode = str_replace("<embed","<embed wmode='transparent' ",$videocode); 
				
				/***********new youtube embed with iframe********/
				if(strstr($videocode,'youtube.com') || strstr($videocode,'youtu.be')){
					if(preg_match('/<iframe.*?src=[\"\'](.*?)[\"\'].*?/ism',$videocode,$match)){
						$oldCode = $match[1];
						if(strstr($videocode,'?')){
							$newCode = $oldCode.'&wmode=transparent';
						}else{
							$newCode = $oldCode.'?wmode=transparent';
						}
						$videocode = str_replace($oldCode,$newCode,$videocode); 
					}

				}
				/***********new youtube embed with iframe********/			
				?>
				<p class="description"><?php echo $instance["video" . $i . "-desc"] ?></p>
				<div class="cover"><?php echo "$videocode";  ?></div>
				<?php }
				 else {
					echo "Could not generate embed. Please try it again.";
				}
				?>
			</div>
			<?php } ?>

			<ul class="items">
				<?php for ($i = 1; $i <= $count; $i++) { ?>
				<?php if ($i == 1) { $class="active"; } ?>
				<li>
				  <a class="bold-upper-big <?php echo esc_attr($class); ?>" href="#ew-video-cat-<?php echo $i; ?>"><?php echo $instance["video" . $i . "-title"]; ?></a>
				</li>

				<?php $class = ""; } ?>
			</ul>
			<script type="text/javascript">
			//<![CDATA[
			jQuery(function($) {
				$("document").ready(function() {
					"use strict";
					$(".ew-video li a").click(function() {
						$(".ew-video .open").addClass("hide").removeClass("open");
						$(".ew-video " + $(this).attr("href")).addClass("open").removeClass("hide");
						$(".ew-video li a.active").removeClass("active");
						$(this).addClass("active");
						return false;
					})
				});
			});
			//]]>	
			</script>
		<?php
			echo $after_widget;
		}

		function form($instance)
		{
			$defaults = array(
				"title" => "Video Widget",
				"count" => "3"
			);
			$instance = wp_parse_args((array) $instance, $defaults);
		?>
			<p>
				<label for="<?php echo $this->get_field_id("title"); ?>">Title</label>
				<input id="<?php echo $this->get_field_id("title"); ?>" class="widefat" name="<?php echo $this->get_field_name("title"); ?>" value="<?php echo esc_attr($instance["title"]); ?>" style="width: 96%;" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id("count"); ?>">Videos</label>
				<select id="<?php echo $this->get_field_id("count"); ?>" name="<?php echo $this->get_field_name("count"); ?>" value="<?php echo esc_attr($instance["count"]); ?>" style="width: 100%;">
					<?php for ($i = 2; $i <= 10; $i++) {
						$active = "";
						if ($instance["count"] == $i) {
							$active = "selected=\"selected\"";
						} ?>
						<option <?php echo $active; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php } ?>
				</select>
				<span class="description" style="font-size:11px;">Make sure to specify exact number of videos, otherwise the widget won't work.</span>
			</p>

		<?php for ($i = 1; $i <= $instance["count"]; $i++) { 
		
				$instance["video" . $i] = isset($instance["video" . $i]) ? $instance["video" . $i] : '';
				$instance["video" . $i . "-title"] = isset($instance["video" . $i . "-title"]) ? $instance["video" . $i . "-title"] : '';
				$instance["video" . $i . "-desc"] = isset($instance["video" . $i . "-desc"]) ? $instance["video" . $i . "-desc"] : '';
			?>
			<p>
			<label for="<?php echo $this->get_field_id("video" . $i); ?>"><strong>Video #<?php echo $i; ?> Embed Code</strong></label>

			<textarea id="<?php echo $this->get_field_id("video" . $i); ?>" class="widefat" name="<?php echo $this->get_field_name("video" . $i); ?>" rows="6"><?php echo htmlspecialchars($instance["video" . $i]); ?></textarea>
			</p>

			<p>
			<label for="<?php echo $this->get_field_id("video" . $i . "-title"); ?>">Video #<?php echo $i; ?> title</label>
			<input id="<?php echo $this->get_field_id("video" . $i . "-title"); ?>" class="widefat" name="<?php echo $this->get_field_name("video" . $i . "-title"); ?>" value="<?php echo $instance["video" . $i . "-title"]; ?>" style="width:96%;" />
			</p>

			<p>
			<label for="<?php echo $this->get_field_id("video" . $i . "-desc"); ?>">Video #<?php echo $i; ?> description</label>
			
			<textarea id="<?php echo $this->get_field_id("video" . $i . "-desc"); ?>" class="widefat" name="<?php echo $this->get_field_name("video" . $i . "-desc"); ?>" rows="6" ><?php echo htmlspecialchars($instance["video" . $i . '-desc']); ?></textarea>
			<br/><br/></p>
		<?php }
		}
	}
}
?>