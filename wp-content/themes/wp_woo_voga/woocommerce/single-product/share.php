<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php
	global $post,$wd_data;
?>
<?php do_action('woocommerce_share'); // Sharing plugins can hook into here ?>
<div class="social_sharing">
	<div class="social-des">
		<h6 class="title-social"><?php echo sprintf( __( '%s','wpdance' ), stripslashes(esc_attr($wd_data['wd_prod_share_title'])) ) ;?></h6>
		<!--<p class="content-social-des"><?php //echo stripslashes(htmlspecialchars_decode($single_prod_datas["sharing_intro"]));?></p>-->
	</div>
	
	<div class="social_icon">
		<div class="mail">
			<a href="mailto:?subject=I%20wanted%20you%20to%20see%20this%20site&amp;body=Check%20out%20this%20site%20<?php echo site_url(); ?>" title="Share by Email"><i class="fa fa-envelope-o"></i><?php _e('Email','wpdance') ?></a>
		</div>
		<div class="print">
			<a class="wd_print" href="javascript:window.print()" rel="nofollow"><i class="fa fa-print"></i><?php _e('Print','wpdance')?></a>
		</div>
		<div class="facebook">
			<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-action="like" data-show-faces="true" data-share="false"></div>
		</div>			
			
		<!-- Place this render call where appropriate -->
		<script type="text/javascript">
		  (function() {
			"use strict";
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		
		<div class="twitter">
			<a href="<?php echo "https://twitter.com/share"; ?>" class="twitter-share-button" data-count="none"></a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</div>
		<!--	
		<div class="gplus">				                
			<script  type="text/javascript"  src="https://apis.google.com/js/plusone.js"></script>
			<g:plusone size="medium"></g:plusone>
		</div>
		-->
		<?php 
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src($image_id,'full', true);
		?>
		<div>
			<a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($image_url[0]); ?>&amp;" data-pin-do="buttonPin" data-pin-config="none">
				<img alt="pinterest" src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
			</a>
			<script type="text/javascript">
				(function(d){
				  "use strict";
				  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
				  p.type = 'text/javascript';
				  p.async = true;
				  p.src = '//assets.pinterest.com/js/pinit.js';
				  f.parentNode.insertBefore(p, f);
				}(document));
			</script>
		</div>
		
	</div>              
</div>