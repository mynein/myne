<?php 
/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since WP0001
 */
function theme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'theme_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since WP0001
 * @return int
 */
function theme_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'theme_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since WP0001
 * @return string "Continue Reading" link
 */
function theme_continue_reading_link() {
	return ' <a class="read-more bold-upper-normal" href="'. get_permalink() . '">' . __( 'Learn more', 'wpdance' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and theme_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since WP0001
 * @return string An ellipsis
 */
function theme_auto_excerpt_more( $more ) {
	return ' &hellip;' . theme_continue_reading_link();
}
//add_filter( 'excerpt_more', 'theme_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since WP0001
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function theme_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= theme_continue_reading_link();
	}
	return $output;
}
//add_filter( 'get_the_excerpt', 'theme_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in style.css. This is just
 * a simple filter call that tells WordPress to not use the default styles.
 *
 * @since WP0001
 */
add_filter( 'use_default_gallery_style', '__return_false' );

function theme_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
// Backwards compatibility with WordPress 3.0.
if ( version_compare( $GLOBALS['wp_version'], '3.1', '<' ) )
	add_filter( 'gallery_style', 'theme_remove_gallery_css' );
	
if ( ! function_exists( 'theme_comment' ) ) {
	function theme_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'wpdance' ); ?></em>
					<br />
				<?php endif; ?>

				<?php comment_text(); ?>
				
				<div class="comment-meta font-second commentmetadata">
					<span class="comment-author vcard"><?php _e('Commented by ', 'wpdance'); echo get_comment_author_link(); ?></span> /
					<span class="comment-date"><?php echo wd_relative_time($comment->comment_date); ?></span>
				</div><!-- .comment-meta .commentmetadata -->

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</div><!-- #comment-##  -->

		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		<li class="post pingback">
			<p><?php _e( 'Pingback:', 'wpdance' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'wpdance' ), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}
}

if( !function_exists('wd_relative_time') ){
	function wd_relative_time($time)
	{
		$second = 1;
		$minute = 60 * $second;
		$hour = 60 * $minute;
		$day = 24 * $hour;
		$month = 30 * $day;

		$delta = strtotime('+0 hours') - strtotime($time);
		if ($delta < 2 * $minute) {
			return __('1 min ago', 'wpdance');
		}
		if ($delta < 45 * $minute) {
			return floor($delta / $minute) . __(' min ago', 'wpdance');
		}
		if ($delta < 90 * $minute) {
			return __('1 hour ago', 'wpdance');
		}
		if ($delta < 24 * $hour) {
			return floor($delta / $hour) . __(' hours ago', 'wpdance');
		}
		if ($delta < 48 * $hour) {
			return __('yesterday', 'wpdance');
		}
		if ($delta < 30 * $day) {
			return floor($delta / $day) . __(' days ago', 'wpdance');
		}
		if ($delta < 12 * $month) {
			$months = floor($delta / $day / 30);
			return $months <= 1 ? __('1 month ago', 'wpdance') : $months . __( ' months ago', 'wpdance');
		} else {
			$years = floor($delta / $day / 365);
			return $years <= 1 ? __('1 year ago', 'wpdance') : $years . __(' years ago', 'wpdance');
		}
	}
}


function theme_remove_recent_comments_style() {
	add_filter( 'show_recent_comments_widget_style', '__return_false' );
}
add_action( 'widgets_init', 'theme_remove_recent_comments_style' );	

/******************** Start Custom Stylesheet for less-css loading ********************/
	
function enqueue_less_styles($tag, $handle) {
	global $wp_styles;		
	$match_pattern = '/\.less$/U';
	if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
		$handle = $wp_styles->registered[$handle]->handle;
		$media = $wp_styles->registered[$handle]->args;
		$_version = ( strlen($wp_styles->registered[$handle]->ver) > 0 )? $wp_styles->registered[$handle]->ver : $wp_styles->default_version;
		$href = $wp_styles->registered[$handle]->src . '?ver=' . $_version ;
		$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
		$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

		$tag = "<link rel='stylesheet/less' id='{$handle}' {$title} href='{$href}' type='text/less' media='{$media}' />\n";
	}
	return $tag;
}
add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);
?>