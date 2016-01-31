<?php
/*
Plugin Name: WD ShortCode
Plugin URI: http://www.wpdance.com/
Description: ShortCode From WPDance Team
Author: Wpdance
Version: 1.0.4
Author URI: http://www.wpdance.com/
*/
class WD_Shortcode
{
	protected $arrShortcodes = array();
	public function __construct(){
		$this->constant();
		add_action('wp_enqueue_scripts', array( $this, 'init_script' ));
		
		require_once plugin_dir_path( __FILE__ ).'functions.php';
		
		$this->initArrShortcodes();
		$this->initShortcodes();
		
		add_action( 'admin_head' , array($this, 'add_google_tracking'), 9999);
		
		/* Fix bbp_setup_current_user was called incorrectly */
		if( class_exists('bbPress') ){
			remove_action( 'set_current_user', 'bbp_setup_current_user',10);
			add_action( 'set_current_user', create_function('','do_action( "bbp_setup_current_user" );'),10);
		}
	}

	protected function initArrShortcodes(){
		$this->arrShortcodes = array('feature_product_slider', 'best_selling_product','top_rated_product','top_rated_product_slider'
		,'recent_product_slider','recent_product','best_selling_product_slider','sale_product','sale_product_slider','top_product'
		,'typography','feedburner','countdown','wd_testimonial','recent_post','recent_post_slider'
		,'bt_multitab','bt_alerts','bt_buttons','wd_features','wd_features_slider','feature_wpdance'
		,'bt_progress_bars','quote','google_map','symbol','pricing_table','code','banner','milestone','image_video');
	}
	
	protected function initShortcodes(){
		foreach($this->arrShortcodes as $shortcode){
			if( file_exists(SC_ShortCode."/{$shortcode}.php") ){
				require_once SC_ShortCode."/{$shortcode}.php";
			}	
		}
	}

	public function init_script(){
		global $post;
	
		wp_enqueue_script('jquery');

		wp_register_style( 'shortcode', SC_CSS.'/shortcode.css');
		wp_enqueue_style('shortcode');

		if( isset($post->post_content) && has_shortcode( $post->post_content, 'wd_countdown') ){
			wp_register_style( 'css.countdown', SC_CSS.'/jquery.countdown.css');
			wp_enqueue_style('css.countdown');
		}
		
		wp_register_style( 'owl.carousel', SC_CSS.'/owl.carousel.min.css');
		wp_enqueue_style('owl.carousel');	
				
		wp_register_script( 'bootstrap', SC_JS.'/bootstrap.js');
		wp_enqueue_script('bootstrap');
		
		wp_register_script( 'wd_shortcode', SC_JS.'/wd_shortcode.js',false,false,true);
		wp_enqueue_script('wd_shortcode');
		
		if( isset($post->post_content) && has_shortcode( $post->post_content, 'wd_countdown') ){
			wp_register_script( 'jquery.countdown', SC_JS.'/jquery.countdown.js',false,false,true);
			wp_enqueue_script('jquery.countdown');
		}
		
		wp_register_script( 'owl.carousel', SC_JS.'/owl.carousel.min.js',false,false,true);
		wp_enqueue_script('owl.carousel');
		
		
	}
	
	protected function constant(){
		define('SC_BASE'	,  	plugins_url( '', __FILE__ ));
		define('SC_ShortCode'	, 	plugin_dir_path( __FILE__ ) . 'shortcode'	);
		define('SC_JS'		, 	SC_BASE . '/js'			);
		define('SC_CSS'		, 	SC_BASE . '/css'		);
		define('SC_IMAGE'	, 	SC_BASE . '/images'		);
	}

	function add_google_tracking(){
		?>
		<script>

		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');



		  ga('create', 'UA-55571446-5', 'auto');

		  ga('require', 'displayfeatures');

		  ga('send', 'pageview');



		</script>
		<?php
	}
}	

$_wd_shortcode = new WD_Shortcode;
?>