<?php
/**
 * EW Social Widget
 */
if(!class_exists('WP_Widget_Ew_social')){
	class WP_Widget_Ew_social extends WP_Widget {

		function WP_Widget_Ew_social() {
			$widgetOps = array('classname' => 'widget_social', 'description' => __('Display Social Profiles','wpdance'));
			$controlOps = array('width' => 400, 'height' => 350);
			$this->WP_Widget('ew_social', __('WD - Social Profiles','wpdance'), $widgetOps, $controlOps);
		}

		function widget( $args, $instance ) {
			extract($args);
			$title = esc_attr(apply_filters( 'widget_title', $instance['title'] ));
			$rss_id = esc_attr($instance['rss_id']);
			$twitter_id = esc_attr($instance['twitter_id']);
			$facebook_id = esc_attr($instance['facebook_id']);
			$pin_id = esc_attr($instance['pin_id']);
			$google_id = esc_attr($instance['google_id']);			
			?>
			<?php echo $before_widget;?>
			<?php echo $before_title . $title . $after_title;?>
			<div class="social-icons">
				<ul>
					<li class="icon-facebook"><a class="fa fa-facebook" href="http://www.facebook.com/<?php echo esc_attr($facebook_id); ?>" target="_blank" title="<?php _e('Become our fan', 'wpdance'); ?>" ></a></li>				
					<li class="icon-twitter"><a class="fa fa-twitter" href="http://twitter.com/<?php echo esc_attr($twitter_id); ?>" target="_blank" title="<?php _e('Follow us', 'wpdance'); ?>" ></a></li>
					<li class="icon-pin"><a class="fa fa-pinterest" href="http://www.pinterest.com/<?php echo esc_attr($pin_id); ?>" target="_blank" title="<?php _e('See Us', 'wpdance'); ?>" ></a></li>
					<li class="icon-google"><a class="fa fa-google" href="https://plus.google.com/u/0/<?php echo esc_attr($google_id); ?>" target="_blank" title="<?php _e('Get updates', 'wpdance'); ?>" ></a></li>
					<li class="icon-rss"><a class="fa fa-rss" href="http://feeds.feedburner.com/<?php echo esc_attr($rss_id); ?>" target="_blank" title="<?php _e('Get updates', 'wpdance'); ?>" ></a></li>		
				</ul>
			</div>

			<?php
			echo $after_widget;
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['rss_id'] = $new_instance['rss_id'];
			$instance['twitter_id'] =  $new_instance['twitter_id'];
			$instance['facebook_id'] =  $new_instance['facebook_id'];
			$instance['pin_id'] =  $new_instance['pin_id'];	
			$instance['google_id'] =  $new_instance['google_id'];			
			$instance['title'] =  $new_instance['title'];
			//$instance['desc'] =  $new_instance['desc'];		
		//	$instance['vimeo_id'] =  $new_instance['vimeo_id'];
	//		$instance['flickr_id'] =  $new_instance['flickr_id'];					
			
			
			return $instance;
		}

		function form( $instance ) { 
			$instance = wp_parse_args( (array) $instance, array( 'title' => 'Find Us On','rss_id' => 'Rss ID', 'twitter_id' => 'Twitter ID', 'facebook_id' => 'Facebook ID', 'pin_id' => 'Pin ID' ) );
			$rss_id = esc_attr($instance['rss_id']);
			$twitter_id = esc_attr(format_to_edit($instance['twitter_id']));
			$facebook_id = esc_attr(format_to_edit($instance['facebook_id']));
			$pin_id = esc_attr(format_to_edit($instance['pin_id']));
			$google_id = esc_attr(format_to_edit($instance['google_id']));				
				
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Enter your title','wpdance'); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></p>

			<p><label for="<?php echo $this->get_field_id('rss_id'); ?>"><?php _e('Enter your Rss','wpdance'); ?> : </label>
			<input class="widefat" id="<?php echo $this->get_field_id('rss_id'); ?>" name="<?php echo $this->get_field_name('rss_id'); ?>" type="text" value="<?php echo esc_attr($rss_id); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('twitter_id'); ?>"><?php _e('Enter your Twitter ID','wpdance'); ?> : </label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('twitter_id'); ?>" name="<?php echo $this->get_field_name('twitter_id'); ?>" value="<?php echo esc_attr($twitter_id); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('facebook_id'); ?>"><?php _e('Enter your Facebook ID','wpdance'); ?> : </label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('facebook_id'); ?>" value="<?php echo esc_attr($facebook_id); ?>" /></p>
			<p><label for="<?php echo $this->get_field_id('pin_id'); ?>"><?php _e('Enter your Pinterest ID','wpdance'); ?> : </label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('pin_id'); ?>" value="<?php echo esc_attr($pin_id); ?>" /></p>		
			<p><label for="<?php echo $this->get_field_id('google_id'); ?>"><?php _e('Enter your Google+ ID','wpdance'); ?> : </label>
			<input class="widefat" type="text" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('google_id'); ?>" value="<?php echo esc_attr($google_id); ?>" /></p>					
			<?php }
	}
}

