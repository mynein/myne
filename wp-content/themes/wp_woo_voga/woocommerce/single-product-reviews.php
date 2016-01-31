<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() )
	return;
?>
<div id="reviews"><?php

	echo '<div id="comments">';
	
	if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ){

			$average = $product->get_average_rating();

			echo '<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">';

			echo '<div class="star-rating" title="'.sprintf(__( 'Rated %s out of 5', 'wpdance' ), $average ).'"><span style="width:'.( ( $average / 5 ) * 100 ) . '%"><strong itemprop="ratingValue" class="rating">'.$average.'</strong> '.__( 'out of 5', 'wpdance' ).'</span></div>';

			echo '<h3>'.sprintf( _n('%s review for %s', '%s reviews for %s', $count, 'wpdance'), '<span itemprop="ratingCount" class="count">'.$count.'</span>', wptexturize($post->post_title) ).'</h3>';

			echo '</div>';

	} else {

		echo '<h3>'.__( 'Reviews', 'wpdance' ).'</h3>';

	}

	$title_reply = '';

	if ( have_comments() ) :

		echo '<ol class="commentlist">';

			wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) );

		echo '</ol>';

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<?php
				echo '<nav class="woocommerce-pagination">';
					paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
						'prev_text' 	=> '&larr;',
						'next_text' 	=> '&rarr;',
						'type'			=> 'list',
					) ) );
				echo '</nav>';
			?>	
			<!--<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Previous', 'wpdance' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Next <span class="meta-nav">&rarr;</span>', 'wpdance' ) ); ?></div>
			</div>-->
		<?php endif;

		//echo '<p class="add_review"><a href="#review_form" class="inline show_review_form button" title="' . __( 'Add Your Review', 'wpdance' ) . '">' . __( 'Add Review', 'wpdance' ) . '</a></p>';

	//else :

		//echo '<p class="woocommerce-noreviews noreviews">'.__( 'There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'wpdance' ).'</p>';

	endif;

	

	echo '</div>';
	
	if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : 
		
		$commenter = wp_get_current_commenter();
		?>
		<div id="review_form_wrapper">
			<div id="review_form">
				<?php
					$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'wpdance' ) : __( 'Be the first to review', 'wpdance' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => __( 'Leave a Reply to %s', 'wpdance' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'wpdance' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'wpdance' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => __( 'Submit Review', 'wpdance' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);
					
					if ( get_option('woocommerce_enable_review_rating') === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Rating', 'wpdance' ) .'</label><select name="rating" id="rating">
							<option value="">'.__( 'Rate&hellip;', 'wpdance' ).'</option>
							<option value="5">'.__( 'Perfect', 'wpdance' ).'</option>
							<option value="4">'.__( 'Good', 'wpdance' ).'</option>
							<option value="3">'.__( 'Average', 'wpdance' ).'</option>
							<option value="2">'.__( 'Not that bad', 'wpdance' ).'</option>
							<option value="1">'.__( 'Very Poor', 'wpdance' ).'</option>
						</select></p>';

					}
					
					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'wpdance' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>' . wp_nonce_field( 'woocommerce-comment_rating', '_wpnonce', true, false ) . '</p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>	
			</div>
		</div>
	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'wpdance' ); ?></p>
	
	<?php endif; 
?>
</div>
<div class="clear"></div>