<?php 
	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_1', 10 );
	if(!function_exists ('wd_footer_init_widget_area_1')){
		function wd_footer_init_widget_area_1(){
			
	?>	
		<div class="first-footer-widget-area">
			<div class="container">
				<div class="row">
					<div class="col-sm-24">
					<?php if ( is_active_sidebar( 'first-footer-widget-area-1' ) ) : ?>
						<ul class="xoxo">
							<?php dynamic_sidebar( 'first-footer-widget-area-1' ); ?>
						</ul>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php 
		}
	}
	
	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_2', 15 );
	if(!function_exists ('wd_footer_init_widget_area_2')){
		function wd_footer_init_widget_area_2(){
		?>
			<div class="second-footer-widget-area">
				<div class="container">
					<div class="row">
						<div class="second-footer-widget-area-1 col-sm-6 ">
							<div>
								<?php if ( is_active_sidebar( 'second-footer-widget-area-1' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-1' ); ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
						<div class="second-footer-widget-area-2 col-sm-6 ">
							<div>
								<?php if ( is_active_sidebar( 'second-footer-widget-area-2' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-2' ); ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
						<div class="second-footer-widget-area-3 col-sm-6 ">
							<div>
								<?php if ( is_active_sidebar( 'second-footer-widget-area-3' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-3' ); ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
						<div class="second-footer-widget-area-4 col-sm-6 ">
							<div>
								<?php if ( is_active_sidebar( 'second-footer-widget-area-4' ) ) : ?>
									<ul class="xoxo">
										<?php dynamic_sidebar( 'second-footer-widget-area-4' ); ?>
									</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>							
				</div>	
			</div><!-- end #footer-second-area -->
		<?php		
		}
	}
	
	add_action( 'wd_footer_init', 'wd_footer_init_widget_area_5', 50 );
	if(!function_exists ('wd_footer_init_widget_area_5')){
		function wd_footer_init_widget_area_5(){
		global $wd_data;	
	?>	
		<div class="footer_end" >
			<div class="container">
				<div class="row">
					<div class="copy-right col-sm-12">
						<div class="copyright font-second">
							<?php echo stripslashes($wd_data['footer_text']); ?>
						</div>
					</div><!-- end #copyright -->
					<div class="payment col-sm-12">
						<ul>
						<?php 
						for( $i=1; $i<= 5; $i++ ): 
							if( isset($wd_data['wd_payment_image_'.$i]) && strlen($wd_data['wd_payment_image_'.$i]) > 0 ):
						?>
							<li><img alt="payment" title="payment" src="<?php echo esc_url($wd_data['wd_payment_image_'.$i]); ?>" /></li>
						<?php 
							endif; 
						endfor; 
						?>
						</ul>
					</div><!-- end #copyright -->
				</div>
			</div>
		</div>	
	<?php
		}
	}
	
	add_action( 'wd_footer_init', 'wd_enable_nicescroll', 1 );
	function wd_enable_nicescroll(){
		global $wd_data;
		if( isset($wd_data['wd_nicescroll']) && $wd_data['wd_nicescroll'] == 1 ):
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				"use strict";
				var obj_nice_scroll = jQuery("html").niceScroll({cursorcolor:"#000", zindex: "9999999999"});
				jQuery("#"+obj_nice_scroll.id).find("div:first").css({"width":"6px"});
			});
		</script>
		<?php		
		endif;
	}
	
	add_action( 'wp_footer', 'wd_add_custom_js', 999 );
	function wd_add_custom_js(){
		global $wd_data;
		if( isset($wd_data['wd_custom_js']) && strlen(trim($wd_data['wd_custom_js'])) > 0 ):
		?>
		<script type="text/javascript">
			<?php echo esc_js($wd_data['wd_custom_js']); ?>
		</script>
		<?php
		endif;
	}
?>