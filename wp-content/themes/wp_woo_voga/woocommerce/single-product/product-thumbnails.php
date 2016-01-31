<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce,$wd_data;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
	<div class="thumbnails list_carousel">
		<div>
			<ul class="product_thumbnails">
				<?php

					$loop = 0;
					$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

					foreach ( $attachment_ids as $attachment_id ) {

						//$classes = array( 'zoom' );
						$classes = array(  );

						if ( $loop == 0 || $loop % $columns == 0 )
							$classes[] = 'first';

						if ( ( $loop + 1 ) % $columns == 0 )
							$classes[] = 'last';

						$image_link = wp_get_attachment_url( $attachment_id );

						if ( ! $image_link )
							continue;
							
							
						$image_class = esc_attr( implode( ' ', $classes ) );
						if( $wd_data['wd_prod_cloudzoom'] == 1 && !wp_is_mobile() ){
							//$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),array( 'alt' => $image_title, 'title' => $image_title ) );
							$image_title 		= esc_attr( $product->get_title() );
							$_thumb_size =  apply_filters( 'single_product_large_thumbnail_size', 'shop_single' );
							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'wd_single_product_thumbnail_' ),array( 'alt' => $image_title, 'title' => $image_title ) );
							$image_src   = wp_get_attachment_image_src( $attachment_id, $_thumb_size );
							$image_class = $image_class." pop_cloud_zoom cloud-zoom-gallery";
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s"  rel="useZoom: \'zoom1\', smallImage: \'%s\'">%s</a></li>', $image_link, $image_class, $image_title, $image_src[0], $image ), $attachment_id, $post->ID, $image_class );
						} else {
							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'wd_single_product_thumbnail_' ) );
							$image_title = esc_attr( get_the_title( $attachment_id ) );
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li><a href="%s" class="%s" title="%s"  data-rel="prettyPhoto[product-gallery]">%s</a></li>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
						}
						$loop++;
					}

				?>
			</ul>		
			<?php //endif; ?>
		</div>
	</div>
	
	<?php if( count($attachment_ids) > 0 ) : ?>

		<script type="text/javascript" language="javascript">
		//<![CDATA[
			jQuery(document).ready(function(){
				"use strict";
				
				var _slider_datas = {
					items : 4
					,direction : 'up'
					,width : 'auto'
					,height : '150px'
					,infinite : true
					,auto : {
						play: true
						,timeoutDuration : 5000
						,duration : 800
						,delay : 3000
						,items : 1
						,pauseOnHover : true
					}
					,swipe : {
						onTouch : true
						,onMouse : true
					}
				};
				
				jQuery(window).load(function(){
					jQuery('.product_thumbnails').carouFredSel(_slider_datas);
				});
			});
			
			
		//]]>		
		</script>
	<?php endif;?>	
		
	<?php
}