<?php 
class AdminTheme extends WdTheme
{
	protected $tabs = array();
	
	protected $arrLayout = array();
		
	public function __construct(){
		$this->constants();
		$this->resetArrLayout();
		//add_action('admin_init',array($this,'loadJSCSS'));
		add_action('admin_enqueue_scripts',array($this,'loadJSCSS'), 100);
		////// load custom field ///////
		require_once THEME_INCLUDES.'/custom_fields.php';
		$classCustomFields = 'CustomFields';
		$customFields = new $classCustomFields();

		//$this->AddCustomSidebarLayoutTagCat();
	}
	
	public function constants(){
		define('THEME_INCLUDES_JS_URI', THEME_INCLUDES_URI . '/js');
		define('THEME_INCLUDES_CSS_URI', THEME_INCLUDES_URI . '/css');
		define('THEME_INCLUDES_IMAGES', THEME_INCLUDES . '/images');

		define('THEME_INCLUDES_FUNCTIONS', THEME_INCLUDES . '/functions');
		define('THEME_ADMIN_OPTIONS', THEME_INCLUDES . '/options');
		define('THEME_ADMIN_METABOXES', THEME_INCLUDES . '/metaboxes');
		define('THEME_ADMIN_DOCS', THEME_INCLUDES . '/docs');
		
		define('THEME_INCLUDES_METABOXES', THEME_INCLUDES . '/metaboxes');
		
		
		// the option name custom sidebar(layout) for category and tag
 		define('MY_CATEGORY_SIDEBAR', THEME_SLUG.'my_category_sidebar_option');
		define('MY_TAG_SIDEBAR', THEME_SLUG.'my_tag_sidebar_option');
	}
	
	protected function setArrLayout($array = array()){
		$this->arrLayout = $array;
	}

	/* Set defaulr value for array layout */
	protected function resetArrLayout(){
		$this->setArrLayout(array(
			'1column'		=>	array(	'image'	=>	'i_1column.png', 		'title'	=>	__('Content - No Sidebar','wpdance')	),
			'2columns-left'	=>	array(	'image'	=>	'i_3columns_right.png', 	'title'	=>	__('Content - Left Sidebar','wpdance')),
			'2columns-right'=>	array(	'image'	=>	'i_3columns_left.png', 'title'	=>	__('Content - Right Sidebar','wpdance')),
		));
		
	}
	
	protected function getArrLayout(){
		return $this->arrLayout;
	}
	
	public function inline_js(){
	?>
	    <script type="text/javascript">
		//<![CDATA[
			var template_path = '<?php echo get_template_directory_uri(); ?>';
		//]]>
		</script>
	<?php
	}


	
	/* Add custom sidebar and layout for tag and category */
	protected function AddCustomSidebarLayoutTagCat(){
		add_filter('edit_category_form', array($this,'generateCategoryFields'),0);
		add_action('edit_tag_form_fields',array($this,'generateTagFields'),0);
		add_filter('edited_terms', array($this,'updateCategoryTagFields'));
		add_filter('deleted_term_taxonomy', array($this,'removeCategoryTagFields'));
	}
	
	/* Generate Custom Sidebar and Layout for category */
	public function generateCategoryFields($tag) {
		require_once THEME_ADMIN_TPL.'/custom_sidebar_layout/category.php';
	}
	
	/* Generate Custom Sidebar and Layout for tag */
	public function generateTagFields($tag) {
		require_once THEME_ADMIN_TPL.'/custom_sidebar_layout/tag.php';
	}
	
	/* Save custom sidebar and layout for category and tag */
	function updateCategoryTagFields($term_id) {
			$tag_extra_fields = get_option(MY_CATEGORY_SIDEBAR);
			$tag_extra_fields[$term_id]['cat_post_sidebar'] = strip_tags($_POST['cat_post_sidebar']);
			$tag_extra_fields[$term_id]['cat_post_layout'] = strip_tags($_POST['cat_post_layout']);
			update_option(MY_CATEGORY_SIDEBAR, $tag_extra_fields);
	}
	
	/* Remove custom sidebar and layout of a tag(category) when it is removed */
	public function removeCategoryTagFields($term_id) {
			$tag_extra_fields = get_option(MY_CATEGORY_SIDEBAR);
			unset($tag_extra_fields[$term_id]);
			update_option(MY_CATEGORY_SIDEBAR, $tag_extra_fields);
	}
	
	protected function showTooltip($title,$content){	
		include THEME_INCLUDES_FUNCTIONS.'/tooltip.php';
	}
	
	public function loadJSCSS(){
		wp_enqueue_script('jquery');
		wp_enqueue_script("jquery-ui-core");
		wp_enqueue_script("jquery-ui-widget");
		wp_enqueue_script("jquery-ui-tabs");
		wp_enqueue_script("jquery-ui-mouse");
		wp_enqueue_script("jquery-ui-sortable");
		wp_enqueue_script("jquery-ui-slider");
		wp_enqueue_script("jquery-ui-accordion");
		wp_enqueue_script("jquery-effects-core");
		wp_enqueue_script("jquery-effects-slide");
		wp_enqueue_script("jquery-effects-blind");	
		wp_register_script( 'jqueryform', THEME_INCLUDES_JS_URI.'/jquery.form.js');
		wp_enqueue_script('jqueryform');

		wp_register_script( 'tab', THEME_INCLUDES_JS_URI.'/tab.js');
		wp_enqueue_script('tab');
		
		wp_register_script( 'page_config_js', THEME_INCLUDES_JS_URI.'/page_config.js');
		wp_enqueue_script('page_config_js');
		
		wp_register_script( 'product_config', THEME_INCLUDES_JS_URI.'/product_config.js');
		wp_enqueue_script('product_config');
		
		wp_register_style( 'config_css', THEME_INCLUDES_CSS_URI.'/admin.css');
		wp_enqueue_style('config_css');
		 

		/// Start Fancy Box
		wp_register_style( 'fancybox_css', THEME_CSS.'/jquery.fancybox.css');
		wp_enqueue_style('fancybox_css');		
		wp_register_script( 'fancybox_js', THEME_JS.'/jquery.fancybox.pack.js');
		wp_enqueue_script('fancybox_js');	
		/// End Fancy Box		
		
		wp_register_style( 'colorpicker', THEME_CSS.'/colorpicker.css');
		wp_enqueue_style('colorpicker');		
		wp_register_script( 'bootstrap-colorpicker', THEME_JS.'/bootstrap-colorpicker.js');
		wp_enqueue_script('bootstrap-colorpicker');	
		
		global $is_admin_menu;
				
		wp_register_style( 'font-awesome', THEME_INCLUDES_CSS_URI.'/font-awesome.css');
		wp_enqueue_style('font-awesome');	

		wp_enqueue_script('plupload-all');
		
		wp_enqueue_script('utils');
		wp_enqueue_script('plupload');
		wp_enqueue_script('plupload-html5');
		wp_enqueue_script('plupload-flash');
		wp_enqueue_script('plupload-silverlight');
		wp_enqueue_script('plupload-html4');
		wp_enqueue_script('media-views');
		wp_enqueue_script('wp-plupload');
		
		
		wp_enqueue_script('thickbox');
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
	
		
		wp_register_script( 'logo_upload', THEME_INCLUDES_JS_URI.'/logo-upload.js');
		wp_enqueue_script('logo_upload');
		
		
	}
}
?>