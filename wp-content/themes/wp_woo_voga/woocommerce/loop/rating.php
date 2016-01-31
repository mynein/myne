<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;
?>

<?php if ( $rating_html = $product->get_rating_html() ) : ?>
	<?php //echo $rating_html; 
			$rating = $product->get_average_rating();
			
			$rating_html = '<div class="loop-rating">';
			
				$rating_html .= '<div class="star-rating" title="' . sprintf( __( 'Rated %s out of 5', 'wpdance' ), $rating ) . '">';

					$rating_html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"><strong class="rating">' . $rating . '</strong> ' . __( 'out of 5', 'wpdance' ) . '</span>';
				
				$rating_html .= '</div>';
				
				$rating_html .= '<span class="count">('.$product->get_rating_count().')</span>';
			
			$rating_html .= '</div>';

			echo $rating_html;
	?>
<?php endif; ?>