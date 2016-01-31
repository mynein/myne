<?php
if(!function_exists('wd_team_member')){
	if(!function_exists('string_limit_words')){
		function string_limit_words($string, $word_limit)
		{
			$words = explode(' ', $string, ($word_limit + 1));
			if(count($words) > $word_limit)
			array_pop($words);
			return implode(' ', $words);
		}
	}
	function wd_team_member($atts = array(),$content) {
		extract(shortcode_atts(array(
			'id'=>''
			,'style' => 'style1'
			,'slug' => ''
			,'except' => 50
			,'width' => '300'
			,'height' => '380'
		), $atts));
		
		//$content = do_shortcode($content);
		if( absint($id) > 0 ){
			$query = new WP_Query( array( 'post_type' => 'team', 'post__in' => array($id )) );
		}elseif( strlen(trim($slug)) > 0 ){
			$_post = get_page_by_path($slug, OBJECT, 'team');
			if( !is_null($_post) ){
				$query = new WP_Query( array( 'post_type' => 'team', 'post__in' => array($_post->ID )) );
			} else {
				return;
			}
		} else {
			return;
		}
		global $post;
		$count=0;
			if($query->have_posts()) : 
				while($query->have_posts()) : $query->the_post();
					$name = esc_html(get_the_title($post->ID));
					$post_url =  esc_url(get_permalink($post->ID));
					$role = esc_html(get_post_meta($post->ID,'wd_member_role',true));
					$email= esc_html(get_post_meta($post->ID,'wd_member_email',true));
					$phone= esc_html(get_post_meta($post->ID,'wd_member_phone',true));
					$link= esc_url(get_post_meta($post->ID,'wd_member_link',true));
					//$social= esc_html(get_post_meta($post->ID,'wd_member_social',true));
					$facebook_link= esc_url(get_post_meta($post->ID,'wd_member_facebook_link',true));
					$twitter_link= esc_url(get_post_meta($post->ID,'wd_member_twitter_link',true));
					$rss_link= esc_url(get_post_meta($post->ID,'wd_member_rss_link',true));
					$google_link= esc_url(get_post_meta($post->ID,'wd_member_google_link',true));
					$linkedlin_link= esc_url(get_post_meta($post->ID,'wd_member_linkedlin_link',true));
					$dribble_link= esc_url(get_post_meta($post->ID,'wd_member_dribble_link',true));
					$content = string_limit_words($post->post_content,$except);	
					
					if($link == '') { $link = '#'; }		
					if($email){
						$email = '<div class="wd_email primary-color">'.$email.'</div>';
					}
					if($phone){
						$phone = '<div class="wd_phone primary-color">'.$phone.'</div>';
					}
					$_social = '';
					if($facebook_link){
						$_social .= '<a class="facebook_link" href="'.$facebook_link.'"><i class="fa fa-facebook"></i></a>';
					}
					if($twitter_link){
						$_social .= '<a class="twitter_link" href="'.$twitter_link.'"><i class="fa fa-twitter"></i></a>';
					}
					if($google_link){
						$_social .= '<a class="google_link" href="'.$google_link.'"><i class="fa fa-google-plus"></i></a>';
					}
					if($rss_link){
						$_social .= '<a class="rss_link" href="'.$rss_link.'"><i class="fa fa-rss"></i></a>';
					}
					if($linkedlin_link){
						$_social .= '<a class="linkedlin_link" href="'.$linkedlin_link.'"><i class="fa fa-linkedin"></i></a>';
					}
					if($dribble_link){
						$_social .= '<a class="dribbble_link" href="'.$dribble_link.'"><i class="fa fa-dribbble"></i></a>';
					}
					ob_start();
					?>
					<div class="wd_meet_team <?php echo $style; ?>">
						<div class="team_thumnail">
							<a title="<?php echo $name; ?>" style="width:<?php echo $width; ?>px ; height:<?php echo $height; ?>px " alt="<?php echo $name; ?>" href="<?php echo $link; ?>"><?php the_post_thumbnail('wd_team_thumb'); ?> </a>
							<div class="social"><?php echo $_social; ?></div>
						</div>
						<div class="info">
							<h5><a href="<?php echo $link; ?>"><?php echo $name; ?></a></h5>
							<p class="role text-strong"><i><?php echo $role; ?></i></p>
						</div>
						<div class="info_description">
							<p class="wd_description text-strong"><?php echo $content; ?></p>
							<?php echo $email.$phone; ?>
						</div>
					</div>
					<?php
					endwhile;
				endif;
			$output = ob_get_contents();
			ob_end_clean();
			wp_reset_postdata();
			return $output;
	}
}
add_shortcode('team_member','wd_team_member');
?>