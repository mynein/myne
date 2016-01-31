<?php $rand_id = rand(0, 1000); ?>
<form role="search" method="get" id="searchform-<?php echo esc_attr($rand_id); ?>" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text"><?php _e( 'Search for:', 'wpdance' ); ?></label>
		<input type="text" value="<?php echo get_search_query(); ?>" data-default="<?php _e('search something...', 'wpdance'); ?>" name="s" id="s-<?php echo esc_attr($rand_id); ?>" class="search-input" />
		<input type="submit" id="searchsubmit-<?php echo esc_attr($rand_id); ?>" value="<?php echo _e( 'Search', 'wpdance' ); ?>" />
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>