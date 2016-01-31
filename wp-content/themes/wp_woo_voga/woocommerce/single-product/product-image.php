<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product,$wd_data;
?>
<div class="image-wrapper">

	<div class="image-thumbnail-wrapper">
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>
		
		<div class="images">
			<?php do_action('wd_single_before_product_image'); ?>
			
			<?php
				if ( has_post_thumbnail() ) {

					$image_title 		= esc_attr( $product->get_title() );
					$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ),array( 'alt' => $image_title, 'title' => $image_title,'srcset' => ' ') );
					$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
					$attachment_count   = count( $product->get_gallery_attachment_ids() );

					if ( $attachment_count > 0 ) {
						$gallery = '[product-gallery]';
					} else {
						$gallery = '';
					}
					if(!is_singular('product')){
						$link = esc_attr(get_permalink($post->ID) );
						echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image" title="%s">%s</a>', $link, $image_title, $image ), $post->ID );
					} else {
						if($wd_data['wd_prod_cloudzoom'] == 1){
							if( wp_is_mobile() ){
								echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
								//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image cloud-zoom zoom" title="%s"  id=\'zoom1\' rel="position:\'inside\',showTitle:1,titleOpacity:0.5,lensOpacity:0.5,fixWidth:362,fixThumbWidth:72,fixThumbHeight:72,adjustX: 0, adjustY:0">%s</a>', $image_link, $image_title, $image ), $post->ID );
							}else{
								echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image cloud-zoom zoom on_pc" title="%s"  id=\'zoom1\' rel="position:\'right\',showTitle:1,titleOpacity:0.5,lensOpacity:0.5,fixWidth:362,fixThumbWidth:72,fixThumbHeight:72, adjustY:-4">%s</a>', $image_link, $image_title, $image ), $post->ID );
							} 
							
						} else {
							echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
						  //echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
						}
						
					}
					
				} else {

					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );

				}
			?>
			
		</div>
	</div>
	
	<?php do_action('wd_single_after_product_image'); ?>
	
</div>

