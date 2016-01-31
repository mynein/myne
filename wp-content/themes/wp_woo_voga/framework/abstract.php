<?php 
class WdTheme 
{
	protected $options = array();
	protected $arrFunctions = array();
	protected $arrWidgets = array();
	protected $arrIncludes = array();
	public function __construct($options){
		$this->options = $options;
		$this->initArrFunctions();
		$this->initArrWidgets();
		$this->initArrIncludes();
		$this->constant($options);
	}

	public function init(){
		////// Active theme
		$this->hookActive($this->options['theme_slug'], array($this,'activeTheme'));

		$this->initIncludes();
		
		///// After Setup theme
		add_action( 'after_setup_theme', array($this,'wpdancesetup'));
		
		////// deactive theme
		$this->hookDeactive($this->options['theme_slug'], array($this,'deactiveTheme'));
				
		add_action('wp_enqueue_scripts',array($this,'addScripts'));
		
		add_action( 'tgmpa_register', array($this, 'register_required_plugins') );
			
		$this->initFunctions();
		$this->initWidgets();
		
		//call admin
		require_once THEME_INCLUDES.'/metaboxes.php';
		$classNameAdmin = 'AdminTheme';
		$panel = new $classNameAdmin();
		
		$this->loadImageSize();
		$this->extension();
		
		/* Include inport file */
		if( is_admin() ){
			include_once get_template_directory() . '/framework/importer/importer.php';
		}
	}
	
	protected function initArrFunctions(){
		$this->arrFunctions = array('main','video','global_var','preview_mod','ads','filter_editor','quicksand','search','markup_categories','lightbox_control',
		'breadcrumbs','sidebar','twitter_update','feed_burner','excerpt',/*'thumbnail',*/'pagination','theme_control','filter_theme','posted_in_on',
		'video','comment','theme_sidebar','custom_style','header_function','footer_function','mega_menu_column','wdmenus','woo-cart','woo-product','woo-hook','bbpress_hook','woo-account','custom_term','post_views_counter');
	}
	
	
	protected function initArrWidgets(){
		$this->arrWidgets = array('flickr','customrecent','emads','custompages','twitterupdate','multitab'
								,'ew_video','recent_comments_custom','ew_social','productaz','ew_subscriptions');
	}
	
	protected function initArrIncludes(){
		$this->arrIncludes = array('mobile_detect','twitteroauth','class-tgm-plugin-activation');
	}
	
	public function wpdancesetup() {
		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();

		// Post Format support. You can also use the legacy "gallery" or "asides" (note the plural) categories.
		//add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );


		// This theme supports a variety of post formats.
		//add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );	
		add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );		
		//add_theme_support( 'custom-header', $args ) ;
		
		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		add_theme_support( 'title-tag' );

		$defaults = array(
			'default-color'          => '',
			'default-image'          => get_template_directory_uri()."/images/default-background.png"
		);
		
		global $wp_version;
		add_theme_support( 'custom-background', $defaults );
				
		add_post_type_support( 'forum', array('thumbnail') );
		add_theme_support( 'woocommerce' );	
		if ( ! isset( $content_width ) ) $content_width = 960;
		
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain( 'wpdance', get_template_directory() . '/languages' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Navigation', 'wpdance' )
		) );
		
		register_nav_menus( array(
			'mobile' => __( 'Mobile Navigation', 'wpdance' )
		) );


		// Your changeable header business starts here
		if ( ! defined( 'HEADER_TEXTCOLOR' ) )
			define( 'HEADER_TEXTCOLOR', '' );

		// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
		if ( ! defined( 'HEADER_IMAGE' ) )
			define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

		// The height and width of your custom header. You can hook into the theme's own filters to change these values.
		// Add a filter to wpdance_header_image_width and wpdance_header_image_height to change these values.
		define( 'HEADER_IMAGE_WIDTH', apply_filters( 'wpdance_header_image_width', 940 ) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'wpdance_header_image_height', 198 ) );

		// We'll be using post thumbnails for custom header images on posts and pages.
		// We want them to be 940 pixels wide by 198 pixels tall.
		// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
		set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

		// Don't support text inside the header image.
		if ( ! defined( 'NO_HEADER_TEXT' ) )
			define( 'NO_HEADER_TEXT', true );

		// Add a way for the custom header to be styled in the admin panel that controls
		// custom headers. See wpdance_admin_header_style(), below.


		// ... and thus ends the changeable header business.
		
		
		$detect = new Mobile_Detect;
		$_is_tablet = $detect->isTablet();
		$_is_mobile = $detect->isMobile() && !$_is_tablet;
		define( 'WD_IS_MOBILE', $_is_mobile );
		define( 'WD_IS_TABLET', $_is_tablet );
		
	}
	
	protected function constant($options){
		define('DS',DIRECTORY_SEPARATOR);	
		define('THEME_NAME', $options['theme_name']);
		define('THEME_SLUG', $options['theme_slug'].'_');
		
		define('THEME_DIR', get_template_directory());
		
		define('THEME_CACHE', get_template_directory().DS.'cache_theme'.DS);
		
		define('THEME_URI', get_template_directory_uri());
		
		define('THEME_FRAMEWORK', THEME_DIR . '/framework');
		
		define('THEME_FRAMEWORK_URI', THEME_URI . '/framework');
		
		define('THEME_FUNCTIONS', THEME_FRAMEWORK . '/functions');
		
		define('THEME_WIDGETS', THEME_FRAMEWORK . '/widgets');

		define('THEME_INCLUDES', THEME_FRAMEWORK . '/includes');
		
		define('THEME_LIB', THEME_FRAMEWORK . '/lib');
		
		define('THEME_INCLUDES_URI', THEME_URI . '/framework/includes');
		
		define('THEME_EXTENSION', THEME_FRAMEWORK . '/extension');
		
		define('THEME_IMAGES', THEME_URI . '/images');
		define('THEME_CSS', THEME_URI . '/css');
		define('THEME_JS', THEME_URI . '/js');

		/*	
		define('ENABLED_FONT', false);
		define('ENABLED_COLOR', false);
		define('ENABLED_PREVIEW', false);
		define('SITE_LAYOUT', 'wide');
		*/
		
		define('USING_CSS_CACHE', true);
		
	}
	
	protected function initFunctions(){
		foreach($this->arrFunctions as $function){
			if(file_exists(THEME_FUNCTIONS."/{$function}.php"))
			{
				require_once THEME_FUNCTIONS."/{$function}.php";
			}	
		}
	}
	
	protected function extension(){
		$this->extendVC();
	}
	
	protected function initWidgets(){
		foreach($this->arrWidgets as $widget){
			if(file_exists(THEME_WIDGETS."/{$widget}.php"))
			{
				require_once THEME_WIDGETS."/{$widget}.php";
			}
		}
		add_action( 'widgets_init', array($this,'loadWidgets'));
	}
	
	protected function initIncludes(){
		foreach($this->arrIncludes as $include){
			if(file_exists(THEME_LIB."/{$include}.php")){
				require_once THEME_LIB."/{$include}.php";
			}
		}
	}
		
	public function loadWidgets(){
		foreach($this->arrWidgets as $widget)
			register_widget( 'WP_Widget_'.ucfirst($widget) );
	}
	
	public function activeTheme(){
		//Single Image
		update_option( 'shop_single_image_size', array('height'=>'800', 'width' => '625', 'crop' => 1 ));
		//Thumbnail Image
		update_option( 'shop_thumbnail_image_size', array('height'=>'130', 'width' => '100', 'crop' => 1 ));
		//Catalog Image
		update_option( 'shop_catalog_image_size', array('height'=>'474', 'width' => '370', 'crop' => 1 ));	
		
	}
	
	public function hookActive($code, $function){
		$optionKey="theme_is_activated_" . $code;
		if(!get_option($optionKey)) {
			call_user_func($function);
			update_option($optionKey , 1);
		}
	}
	
	public function deactiveTheme(){
	
	}
	
	/**
	 * @desc registers deactivation hook
	 * @param string $code : Code of the theme. This must match the value you provided in wp_register_theme_activation_hook function as $code
	 * @param callback $function : Function to call when theme gets deactivated.
	 */
	public function hookDeactive($code, $function) {
		// store function in code specific global
		$GLOBALS["wp_register_theme_deactivation_hook_function" . $code]=$function;

		// create a runtime function which will delete the option set while activation of this theme and will call deactivation function provided in $function
		$fn=create_function('$theme', ' call_user_func($GLOBALS["wp_register_theme_deactivation_hook_function' . $code . '"]); delete_option("theme_is_activated_' . $code. '");');

		// add above created function to switch_theme action hook. This hook gets called when admin changes the theme.
		// Due to wordpress core implementation this hook can only be received by currently active theme (which is going to be deactivated as admin has chosen another one.
		// Your theme can perceive this hook as a deactivation hook.)
		add_action("switch_theme", $fn);
	}
	
	public function addScripts(){
		global $is_IE, $wd_data, $post;
		
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'gg-mont', "$protocol://fonts.googleapis.com/css?family=Montserrat:300,400,700" );
		wp_enqueue_style( 'gg-source', "$protocol://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" );
		wp_enqueue_style( 'gg-arvo', "$protocol://fonts.googleapis.com/css?family=Arvo:400,700,400italic,700italic" );
		wp_enqueue_style( 'gg-fjalla-one', "$protocol://fonts.googleapis.com/css??family=Fjalla+One" );
		
		if( is_admin() ){
			wp_register_style( 'colorpicker', THEME_CSS.'/colorpicker.css');
			wp_enqueue_style('colorpicker');
		}
		//wp_register_style( 'fancybox_css', THEME_CSS.'/jquery.fancybox.css');
		//wp_enqueue_style('fancybox_css');
		
		wp_register_style( 'bootstrap', THEME_CSS.'/bootstrap.css');
		wp_enqueue_style('bootstrap');
		
		wp_register_style( 'font-awesome', THEME_FRAMEWORK_URI.'/includes/css/font-awesome.css');
		wp_enqueue_style('font-awesome');
		
		wp_register_style( 'owl.carousel', THEME_CSS.'/owl.carousel.min.css');
		wp_enqueue_style('owl.carousel');
		
		wp_enqueue_style( 'main-style', get_stylesheet_uri() );
		
		wp_register_style( 'responsive', THEME_CSS.'/responsive.css');
		wp_enqueue_style('responsive');
		
		wp_enqueue_script('jquery');	
		wp_register_script( 'bootstrap', THEME_JS.'/bootstrap.js',false,false,true);
		wp_enqueue_script('bootstrap');		
		wp_register_script( 'TweenMax', THEME_JS.'/TweenMax.min.js',false,false,true);
		wp_enqueue_script('TweenMax');
		
		if( is_admin() ){
			wp_register_script( 'bootstrap-colorpicker', THEME_JS.'/bootstrap-colorpicker.js',false,false,true);
			wp_enqueue_script('bootstrap-colorpicker');	
		}
		
		wp_register_script( 'owl.carousel', THEME_JS.'/owl.carousel.min.js',false,false,true);
		wp_enqueue_script('owl.carousel');
				
		wp_register_script( 'include-script', THEME_JS.'/include-script.js',false,false,true);
		wp_enqueue_script('include-script');

		wp_register_script( 'jquery.carouFredSel', THEME_JS.'/jquery.carouFredSel-6.2.1.min.js',false,false,true);
		wp_enqueue_script('jquery.carouFredSel');		

		wp_register_script( 'jquery-appear', THEME_JS.'/jquery.appear.js',false,false,true);
		wp_enqueue_script('jquery-appear');	
		
		if(is_singular('product')){
			wp_register_script( 'jquery.cloud-zoom', THEME_JS.'/cloud-zoom.1.0.2.js',false,false,true);
			wp_enqueue_script('jquery.cloud-zoom');		
		
		}else{
			wp_register_script( 'jquery.prettyPhoto', THEME_JS.'/jquery.prettyPhoto.min.js',false,false,true);
			wp_enqueue_script('jquery.prettyPhoto');				
			wp_register_style( 'css.prettyPhoto', THEME_CSS.'/prettyPhoto.css');
			wp_enqueue_style('css.prettyPhoto');
		}
		
		if( isset($wd_data['wd_nicescroll']) && $wd_data['wd_nicescroll'] == 1 ){
			wp_register_script( 'jquery.nicescroll', THEME_JS.'/jquery.nicescroll.js',false,false,true);
			wp_enqueue_script('jquery.nicescroll');
		}
		
		if(!is_admin()){		
			wp_register_script( 'main-js', THEME_JS.'/main.js',false,false,true);
			wp_enqueue_script('main-js');
		}
		
		$woo_header = isset($wd_data['wd_woo_header']) && $wd_data['wd_woo_header'];
		$has_woocommerce = true;
		$_actived = apply_filters( 'active_plugins', get_option( 'active_plugins' )  );
		if ( !in_array( "woocommerce/woocommerce.php", $_actived ) ) {
			$has_woocommerce = false;
		}
		
		if( !($woo_header && $has_woocommerce) ){
			wp_dequeue_script('wc_currency_converter');
		}
		
		/* Remove bbPress style */
		$bb_shortcodes = array('bbp-forum-index', 'bbp-forum-form', 'bbp-single-forum', 'bbp-topic-index'
					,'bbp-topic-form', 'bbp-single-topic', 'bbp-reply-form', 'bbp-single-reply', 'bbp-topic-tags'
					,'bbp-single-tag', 'bbp-single-view', 'bbp-search', 'bbp-search-form', 'bbp-login', 'bbp-register'
					,'bbp-lost-pass', 'bbp-stats'
					);
		$has_bb_shortcode = false;
		if( isset($post->post_content) ){
			foreach( $bb_shortcodes as $shortcode ){
				if( has_shortcode($post->post_content, $shortcode) ){
					$has_bb_shortcode = true;
					break;
				}
			}
		}
		if( function_exists('is_bbpress') && !is_bbpress() && !$has_bb_shortcode ){
			wp_dequeue_style('bbp-default');
			wp_dequeue_script('bbpress-editor');
		}
		
	}
	public function wd_vcSetAsTheme() {
		vc_set_as_theme();
	}
	//extend visual composer 
	protected function extendVC(){
		
		if (class_exists('Vc_Manager')) {
						
			add_action( 'vc_before_init',array($this,'wd_vcSetAsTheme'));
			
			vc_set_shortcodes_templates_dir(THEME_DIR ."/framework/extension/extendvc/vc_templates");
			
			vc_disable_frontend();

			$this->changing_rows_columns_classes();
		}

		// Initialising Shortcodes
		if (false||class_exists('WPBakeryVisualComposerAbstract')) {
			require_once THEME_EXTENSION. '/extendvc/vc_includes/vc_functions.php';
			require_once THEME_EXTENSION. '/extendvc/vc_includes/vc_images.php';
			//require_once THEME_EXTENSION. '/extendvc/vc_includes/vc_shortcodes.php';
			
			function requireVcExtend(){	
				$vc_generates = array('params','feature_product_slider','recent_product_slider','recent_product','best_selling_product_slider','best_selling_product'
				,'top_rated_product','top_rated_product_slider','heading','banner','testimonial','portfolio','recent_blogs','recent_blogs_slider'
				,'button','code','feature','feature-slider','feature_wpdance','slide','quote','team_member','feedbuner','countdown','pricing_table'
				,'sale_product','sale_product_slider','milestone','video');		
				foreach($vc_generates as $vc_generate){
					if(file_exists(THEME_EXTENSION."/extendvc/vc_generate/{$vc_generate}.php"))
						require_once THEME_EXTENSION. "/extendvc/vc_generate/{$vc_generate}.php";
				}	
				
			}
			add_action('init', 'requireVcExtend',2);
		}
	}
	
	//overrite row and column classes
	protected function changing_rows_columns_classes(){
		function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag) {
			if ($tag=='vc_row' || $tag=='vc_row_inner') {
				$class_string = str_replace('vc_row-fluid', 'row vc_row-fluid', $class_string);
			}

			return $class_string;
		}
		add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);
	}
	
	protected function loadImageSize(){
		if ( function_exists( 'add_image_size' ) ) {
		   // Add image size for main slideshow
		   
			add_image_size('blog_shortcode',1180,693,true); /* image for slideshow */
			add_image_size('blog_thumb',280,170,true); /* image for blog thumbnail */	
			add_image_size('blog_tini_thumb',65,40,true); /* image for blog sidebar widget */			
			add_image_size('woo_shortcode',100,100,true); /* image for testimonial */
			add_image_size('woo_feature',360,280,true); /* image for feature */
			add_image_size('wd_portfolio',640,640,true); /* image for portfolio */
			
			global $_wd_mega_configs;
			$wd_mega_menu_config = get_option(THEME_SLUG.'wd_mega_menu_config','');
			$wd_mega_menu_config_arr = unserialize($wd_mega_menu_config);
			if( is_array($wd_mega_menu_config_arr) && count($wd_mega_menu_config_arr) > 0 ){
				if ( !array_key_exists('area_number', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['area_number'] = 1;
				}
				if ( !array_key_exists('thumbnail_width', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['thumbnail_width'] = 16;
				}
				if ( !array_key_exists('thumbnail_height', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['thumbnail_height'] = 16;
				}
				if ( !array_key_exists('menu_text', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['menu_text'] = 'Menu';
				}
				if ( !array_key_exists('disabled_on_phone', $wd_mega_menu_config_arr) ) {
					$wd_mega_menu_config_arr['disabled_on_phone'] = 0;
				}		
			}else{
				$wd_mega_menu_config_arr = array(
					'area_number' => 1
					,'thumbnail_width' => 16
					,'thumbnail_height' => 16
					,'menu_text' => 'Menu'
					,'disabled_on_phone' => 0
				);
			}
			$_wd_mega_configs = $wd_mega_menu_config_arr;
			
			add_image_size('wd_menu_thumb',$_wd_mega_configs['thumbnail_width'],$_wd_mega_configs['thumbnail_height'],true); /* image for slideshow */
			
		}
	}
	
	function register_required_plugins() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// This is an example of how to include a plugin pre-packaged with a theme
			array(
				'name'     				=> 'WooCommerce', // The plugin name
				'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/woocommerce.2.4.3.zip', // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '2.4.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'WPBakery Visual Composer', // The plugin name
				'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/js_composer.zip', // The plugin source
				'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '4.6.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'WD Grid / List toggle', // The plugin name
				'slug'     				=> 'wd_grid-list-toggle', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_grid-list-toggle.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Feature By Woothemes', // The plugin name
				'slug'     				=> 'features-by-woothemes', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/features-by-woothemes.1.4.4.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.4.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Testimonials By Woothemes', // The plugin name
				'slug'     				=> 'testimonials-by-woothemes', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/testimonials-by-woothemes.1.5.4.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.5.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Yith Woocommerce Compare', // The plugin name
				'slug'     				=> 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/yith-woocommerce-compare.2.0.2.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '2.0.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Yith Woocommerce Wishlist', // The plugin name
				'slug'     				=> 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/yith-woocommerce-wishlist.2.0.10.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '2.0.10', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Contact Form 7', // The plugin name
				'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/contact-form-7.4.2.2.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '4.2.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Revolution Slider', // The plugin name
				'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/revslider.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '5.0.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Regenerate Thumbnails', // The plugin name
				'slug'     				=> 'regenerate-thumbnails', // The plugin slug (typically the folder name)
				'source'   				=> 'https://downloads.wordpress.org/plugin/regenerate-thumbnails.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '2.2.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Quickshop By Wpdance', // The plugin name
				'slug'     				=> 'wd_quickshop', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_quickshop.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'Product Color By Wpdance', // The plugin name
				'slug'     				=> 'wd_product-color', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_product-color.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'WD ShortCode', // The plugin name
				'slug'     				=> 'wd_shortcode', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_shortcode.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'WD Slide', // The plugin name
				'slug'     				=> 'wd_slide', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_slide.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'WD Portfolio', // The plugin name
				'slug'     				=> 'wd_portfolio', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_portfolio.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
			,array(
				'name'     				=> 'WD Team', // The plugin name
				'slug'     				=> 'wd_team', // The plugin slug (typically the folder name)
				'source'   				=> get_stylesheet_directory() . '/framework/plugins/wd_team.zip', // The plugin source
				'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
				'version' 				=> '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
				'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
			)
		);

		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       		=> 'wpdance',         	// Text domain - likely want to be the same as your theme.
			'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
			'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
			'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
			'menu'         		=> 'install-required-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> __( 'Install Required Plugins', 'wpdance' ),
				'menu_title'                       			=> __( 'Install Plugins', 'wpdance' ),
				'installing'                       			=> __( 'Installing Plugin: %s', 'wpdance' ), // %1$s = plugin name
				'oops'                             			=> __( 'Something went wrong with the plugin API.', 'wpdance' ),
				'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
				'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
				'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
				'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
				'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
				'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
				'return'                           			=> __( 'Return to Required Plugins Installer', 'wpdance' ),
				'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'wpdance' ),
				'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'wpdance' ), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);

		tgmpa( $plugins, $config );

	}
}
?>