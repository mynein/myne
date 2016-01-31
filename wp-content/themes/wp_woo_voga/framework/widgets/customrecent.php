<?php 
if(!class_exists('WP_Widget_Customrecent')){
	class WP_Widget_Customrecent extends WP_Widget {
    	function WP_Widget_Customrecent() {
				$widget_ops = array('description' => 'This widget show recent post in each category you select.' );

				$this->WP_Widget('customrecent', 'WD - Recent Posts', $widget_ops);
		}
	  
		function widget($args, $instance){
			global $wpdb, $post; // call global for use in function
			
			ob_start();			
			
			extract($args); // gives us the default settings of widgets
			
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent','wpdance') : $instance['title']);
			
			$_limit = absint($instance['limit']) == 0 ? 5 : absint($instance['limit']);
			
			$type = isset($instance['type'])?$instance['type']:1;
			
			echo $before_widget; // echos the container for the widget || obtained from $args
			if($title){
				echo $before_title . $title . $after_title;
			}
			
			$args = array(
				'post_type'				=> 'post'
				,'ignore_sticky_posts'	=> 1
				,'posts_per_page'		=> $_limit
				,'post_status'			=> 'publish'
			);
			
			$recent_posts = new WP_Query($args);
			if( $recent_posts->have_posts() ){
				$num_count = $recent_posts->post_count;
				echo '<ul class="recent_posts type-'.$type.'">';
				$i = 0;
				while( $recent_posts->have_posts() ) {
					$recent_posts->the_post();
					?>
					<li class="item<?php if($i == 0) echo ' first';?><?php if(++$i == $num_count) echo ' last';?>">
						<div class="media">
							<?php if( $type == 1 ): ?>
							<div class="date-time pull-left primary-color font-second">
								<span><?php echo get_the_date('d') ?></span>
								<span><?php echo get_the_date('M') ?></span>
							</div>
							<div class="detail">
								<div class="entry-title">
									<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdance' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
										<?php echo esc_attr(get_the_title()); ?>
									</a>
								</div>
								<span class="comments-count"><?php $comments_count = wp_count_comments($post->ID); if($comments_count->approved < 10 && $comments_count->approved > 0) echo '0'; echo $comments_count->approved; ?><?php _e(' comment(s)','wpdance'); ?></span>
							</div><!-- .detail -->
							<?php else: ?>
							<div class="thumbnail">
								<?php 
								if( has_post_thumbnail() ){
									the_post_thumbnail('blog_tini_thumb',array('title'=>get_the_title()));
								}
								?>
							</div>
							<div class="detail">
								<div class="entry-title">
									<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpdance' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
										<?php echo esc_attr(get_the_title()); ?>
									</a>
								</div>
								<span class="comments-count"><i class="fa fa-comments"></i><?php $comments_count = wp_count_comments($post->ID); if($comments_count->approved < 10 && $comments_count->approved > 0) echo '0'; echo $comments_count->approved; ?></span>
								<div class="date-time">
									<span><?php echo get_the_time(get_option('date_format')); ?></span>
								</div>
							</div>
							<?php endif; ?>
						</div>
					</li>
				
					
				<?php }
				echo '</ul>';
			}
			wp_reset_postdata();
			
			echo $after_widget; // close the container || obtained from $args
			$content = ob_get_clean();

			if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

			echo $content;		
			
		}

		
		function update($new_instance, $old_instance) {
			return $new_instance;
		}

		
		function form($instance) {        

			//Defaults
			$instance = wp_parse_args( (array) $instance, array( 'title' => 'From Our Blog','type' => 1, 'limit'=>4) );
			$title = esc_attr( $instance['title'] );
			$limit = absint( $instance['limit'] );
			$type = $instance['type'];
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title','wpdance' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e( 'Type','wpdance' ); ?> : </label>
				<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
					<option value="1" <?php selected(1, $type); ?>>1</option>
					<option value="2" <?php selected(2, $type); ?>>2</option>
				</select>
			</p>			
			
			<p>
				<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e( 'Limit','wpdance' ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" />
			</p>
			
	<?php
		   
		}
	}
}
?>