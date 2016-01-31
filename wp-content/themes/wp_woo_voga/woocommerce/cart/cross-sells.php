<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $woocommerce, $product;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', 8 ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= apply_filters( 'woocommerce_cross_sells_columns', 4 );

if ( $products->have_posts() ) : ?>

	<div class="cross_sells">
		<header class="title-wrapper">
			<h3 class="heading-title"><?php _e( 'You may be interested in', 'wpdance' ); ?></h3>
		</header>
		<div class="cross_wrapper">
		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>			
		</div>
		<script type="text/javascript" language="javascript">
		//<![CDATA[
			jQuery(document).ready(function() {
				"use strict";
				var $_this = jQuery('.cross_wrapper');		
				var owl = $_this.find('.products').owlCarousel({
					item : 4
					,responsive		:{
						0:{
							items:1
						},
						480:{
							items:2
						},
						768:{
							items: 3
						},
						992:{
							items: 4
						},
						1200:{
							items:4
						}
					}
					,nav : true
					,navText		: [ '<', '>' ]
					,dots			: false
					,loop			: true
					,lazyload		:true
					,margin			: 40
					,onInitialized: function(){
						$_this.addClass('loaded').removeClass('loading');
					}
				});
			});	
		//]]>	
		</script>
		
	</div>

<?php endif;

wp_reset_postdata();