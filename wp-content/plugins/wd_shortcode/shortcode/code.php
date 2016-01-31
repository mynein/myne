<?php
if(!function_exists ('wd_code_function')){
	function wd_code_function($atts,$content = false){
		extract(shortcode_atts(array(
		),$atts));
		return "<div class='border-code'><div class='background-code'><pre class='code'>".htmlspecialchars($content)."</pre></div></div>";
	}
} 
add_shortcode('wd_code','wd_code_function');
?>