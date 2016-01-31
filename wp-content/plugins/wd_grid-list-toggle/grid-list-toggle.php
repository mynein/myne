<?php
/*
Plugin Name: WD Grid / List toggle
Plugin URI: http://www.wpdance.com/
Description: Grid / List toggle From WPDance Team
Author: Wpdance
Version: 1.0.0
Author URI: http://www.wpdance.com/
*/

/**
 * Check if WooCommerce is active
 **/
if (in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 * WD_List_Grid class
	 **/
	if (!class_exists('WD_List_Grid')) {

		class WD_List_Grid {

			public function __construct() {
				// Hooks
  				add_action( 'wp' , array( $this, 'setup_gridlist' ) , 20);

  				// Init settings
				$this->settings = array(
					array(
						'name' => __( 'Default catalog view', 'wpdance' ),
						'type' => 'title',
						'id' => 'wd_glt_options'
					),
					array(
						'name' 		=> __( 'Default catalog view', 'wpdance' ),
						'desc_tip' 	=> __( 'Display products in grid or list view by default', 'wc_list_grid_toggle' ),
						'id' 		=> 'wd_glt_default',
						'type' 		=> 'select',
						'options' 	=> array(
							'grid'  => __('Grid', 'wpdance'),
							'list' 	=> __('List', 'wpdance')
						)
					),
					array( 'type' => 'sectionend', 'id' => 'wd_glt_options' ),
				);

				// Default options
				add_option( 'wd_glt_default', 'grid' );

				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( $this, 'admin_settings' ), 20 );
				add_action( 'woocommerce_update_options_catalog', array( $this, 'save_admin_settings' ) );
				add_action( 'woocommerce_update_options_products', array( $this, 'save_admin_settings' ) );
			}

			/*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}

			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}

			// Setup
			function setup_gridlist() {
				if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
					add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts_styles' ), 20);
					add_action( 'wp_enqueue_scripts', array( $this, 'setup_scripts_script' ), 20);
					add_action( 'woocommerce_before_shop_loop', array( $this, 'gridlist_toggle_button' ), 30);
					add_action( 'woocommerce_after_subcategory', array( $this, 'gridlist_cat_desc' ) );
				}
			}

			// Scripts & styles
			function setup_scripts_styles() {
				
				if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
					wp_enqueue_style( 'jquery.isotope', plugins_url( '/assets/css/jquery.isotope.css', __FILE__ ) );
					wp_enqueue_style( 'gl-css', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
			}
			function setup_scripts_script() {
				if ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
					wp_enqueue_script( 'cookie', plugins_url( '/assets/js/jquery.cookie.min.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'grid-list-scripts', plugins_url( '/assets/js/jquery.gridlistview.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'jquery.imagesloaded', plugins_url( '/assets/js/jquery.imagesloaded.min.js', __FILE__ ), array( 'jquery' ) );
					wp_enqueue_script( 'jquery.isotope', plugins_url( '/assets/js/jquery.isotope.min.js', __FILE__ ), array( 'jquery' ) );
					add_action( 'wp_footer', array(&$this, 'gridlist_set_default_view') );
				}
			}
			function add_short_content(){
				global $product;
				$content = get_the_content($product);
				$rs = '';
				$rs .= '<div class="short-description">';
				//$rs .= strip_tags(substr($content,0,60));
				$rs .= wp_trim_words( strip_tags($content), $num_words = 8, $more = null );
				$rs .= '</div>';
				echo apply_filters('the_content', $rs);
			}
			// Toggle button
			function gridlist_toggle_button() {
				?>
					
					<nav id="options" class="gridlist-toggle">
						<ul class="option-set" data-option-key="layoutMode">
							<li data-option-value="vertical" id="list" class="goAction wd-tooltip" data-toggle="tooltip" title="<?php _e('List view', 'wpdance'); ?>">
								<i class="fa fa-th-list"></i>
							</li>
							<li data-option-value="fitRows" id="grid" class="goAction wd-tooltip" data-toggle="tooltip" title="<?php _e('Grid view', 'wpdance'); ?>">
								<i class="fa fa-th"></i>
							</li>
						</ul>
					</nav>
				<?php
			}

			function gridlist_set_default_view() {
				$default = 'grid';//get_option( 'wd_glt_default' );
				global $wd_data,$woocommerce_loop;
				$_sub_class = "col-sm-6";
				
				if( absint($wd_data['wd_prod_cat_column']) > 0 ){
					$_columns = absint($wd_data['wd_prod_cat_column']);
					$_sub_class = "col-sm-".(24/$_columns);
				}else{
					$_columns = absint($woocommerce_loop['columns']);
					$_sub_class = "col-sm-".(24/($_columns));
				}
				?>
					
					<script type="text/javascript">
						var $_sub_class = '<?php echo $_sub_class; ?>';
						jQuery(document).ready(function($){
							var $_default = '<?php echo $default; ?>';
							var $_layoutMode = 'fitRows';
							
							if (jQuery.cookie('gridcookie') == null) {
								jQuery('.products').addClass('<?php echo $default; ?>');
								jQuery('.gridlist-toggle #<?php echo $default; ?>').addClass('active');
							}
							else{
								$_default = jQuery.cookie('gridcookie');
							}
							
							if ( $_default == 'list' ){
								$_layoutMode = 'vertical';
								$('.products').removeClass('grid');
							}
							
							imagesLoaded('.products', function () {
								var $container = $('.products');
								/*
								$container.isotope({
									itemSelector: '.product',
									layoutMode: $_layoutMode
								});
								*/
								var $optionSets = $('#options .option-set'),
									$optionLinks = $optionSets.find('li');
								
								$optionLinks.click(function () {
									var $this = $(this);
									
									if ($this.hasClass('active')) {
										return false;
									}

									var $optionSet = $this.parents('.option-set');
									$optionSet.find('.active').removeClass('active');
									$this.addClass('active');

									var options = {},
										key = $optionSet.attr('data-option-key'),
										value = $this.attr('data-option-value');
									/*
									value = value === 'false' ? false : value;
									options[key] = value;
									if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
										changeLayoutMode($this, options)
									} else {
										$container.isotope(options);
									}
									*/

									return false;
								});
							});
						});
					</script>
				<?php
			}

			function gridlist_cat_desc( $category ) {
				global $woocommerce;
				echo '<div itemprop="description">';
					echo $category->description;
				echo '</div>';

			}
		}
		$WD_List_Grid = new WD_List_Grid();
	}
}
