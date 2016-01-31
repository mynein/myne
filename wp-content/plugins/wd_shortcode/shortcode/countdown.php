<?php
if(!function_exists ('wd_countdown')){
	function wd_countdown($atts,$content = false){
		extract(shortcode_atts(array(
			'day' => '20',
			'month' => '10',
			'year' => '2014'
		),$atts));
		$_random_id = rand();	
		$date_to = $year .'-'.$month.'-'.$day;
		$date_to = date( 'm/d/Y H:i:s', strtotime($date_to));
		ob_start();	
?>
		<div id="countdown<?php echo $_random_id;?>"></div>
		<script type="text/javascript">
			jQuery(document).ready(function ($) { 
				jQuery('#countdown<?php echo esc_js($_random_id); ?>').countdown({
					until: new Date(<?php echo esc_js($year); ?>, <?php echo esc_js($month); ?> - 1, <?php echo esc_js($day); ?>)
				});
			});
		 </script>
<?php	
		$ret_html = ob_get_contents();
		ob_end_clean();
		return $ret_html;
	}
} 
add_shortcode('wd_countdown','wd_countdown');
?>