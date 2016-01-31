<?php
/*
Plugin Name: 404page
Plugin URI: http://smartware.cc/free-wordpress-plugins/404page/
Description: Custom 404 the easy way! Set any page as custom 404 error page. No coding needed. Works with every Theme.
Version: 1.4
Author: smartware.cc
Author URI: http://smartware.cc
License: GPL2
*/

/*  Copyright 2013-2015  smartware.cc  (email : sw@smartware.cc)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

class Smart404Page {
  public $plugin_name;
  public $plugin_slug;
  public $version;
  public $settings;
  
	public function __construct() {
		$this->plugin_name = '404page';
    $this->plugin_slug = '404page';
		$this->version = '1.4';
    $this->get_settings();
    $this->init();
	} 
  
  // get all settings
  private function get_settings() {
    $this->settings = array();
    $this->settings['404page_page_id'] = $this->get_404page_id();
  }
  
  private function init() {
    add_action( 'init', array( $this, 'add_text_domains' ) );
    add_filter( '404_template', array( $this, 'show404' ) );
    add_action( 'admin_init', array( $this, 'admin_init' ) );
    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    add_action( 'admin_head', array( $this, 'admin_css' ) );
    add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_settings_link' ) ); 
  }
  
  // redirect 404 page
  function show404( $template ) {
    global $wp_query;
    $template404 = $template;
    $pageid = $this->settings['404page_page_id'];
    if ( $pageid > 0 ) {
      $wp_query = null;
      $wp_query = new WP_Query();
      $wp_query->query( 'page_id=' . $pageid );
      $wp_query->the_post();
      $template404 = get_page_template();
      rewind_posts();
    }
    return $template404;
  }
  
    // init the admin section
  function admin_init() {
    add_settings_section( '404page-settings', '', array( $this, 'admin_section_title' ), '404page_settings_section' );
    register_setting( '404page_settings', '404page_page_id' );
    add_settings_field( '404page_settings_404page', __( 'Page to be displayed as 404 page', '404page' ) , array( $this, 'admin_404page' ), '404page_settings_section', '404page-settings', array( 'label_for' => '404page_page_id' ) );
  }
  
  // add css
  function admin_css() {
    echo '<style type="text/css">#select404page" {width: 100%}</style>';
  }
  
  // handle the settings field
  function admin_404page() {
    if ( $this->settings['404page_page_id'] < 0 ) {
      echo '<div class="error form-invalid" style="line-height: 3em">' . __( 'The page you have selected as 404 page does not exist anymore. Please choose another page.', '404page' ) . '</div>';
    }
    wp_dropdown_pages( array( 'name' => '404page_page_id', 'id' => 'select404page', 'echo' => 1, 'show_option_none' => __( '&mdash; NONE (WP default 404 page) &mdash;', '404page'), 'option_none_value' => '0', 'selected' => $this->settings['404page_page_id'] ) );
  }
  
  // echo title for settings section
  function admin_section_title() {
    echo '<p><strong>' . __( 'Settings' ) . '</strong>&nbsp;<a class="dashicons dashicons-editor-help" href="http://smartware.cc/docs/404page/"></a></p><hr />';
  }
  
  // adds the options page to admin menu
  function admin_menu() {
    $page_handle = add_options_page( __( '404 Error Page', "404page" ), __( '404 Error Page', '404page' ), 'manage_options', '404pagesettings', array( $this, 'admin_page' ) );
    add_action( 'admin_print_scripts-' . $page_handle, array( $this, 'admin_js' ) );
  }
  
  // adds javascript to the 404page settings page
  function admin_js() {
    wp_enqueue_script( '404pagejs', plugins_url( '/404page.js', __FILE__ ), 'jquery', $this->version, true );
  }
 
  // creates the options page
  function admin_page() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2><?php _e('404 Error Page', '404page'); ?></h2>
      <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
          <div id="post-body-content">
            <div class="meta-box-sortables ui-sortable">
              <form method="post" action="options.php">
                <div class="postbox">
                  <div class="inside">
                    <p style="line-height: 32px; padding-left: 40px; background-image: url(<?php echo plugins_url( 'pluginicon.png', __FILE__ ); ?>); background-repeat: no-repeat;">404page Version <?php echo $this->version; ?></p>
                  </div>
                </div>
                <div class="postbox">
                  <div class="inside">
                    <?php
                      settings_fields( '404page_settings' );
                      do_settings_sections( '404page_settings_section' );
                      submit_button(); 
                    ?>
                    <p class="submit"><input type="button" name="edit_404_page" id="edit_404_page" class="button secondary" value="<?php _e( 'Edit Page', '404page' ); ?>"></p>
                    <div id="404page_current_value" style="display: none"><?php echo $this->get_404page_id(); ?></div>
                    <div id="404page_edit_link" style="display: none"><?php echo get_edit_post_link( $this->get_404page_id() ); ?></div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <?php { $this->show_meta_boxes(); } ?>
        </div>
        <br class="clear">
      </div>    
    </div>
    <?php
  }
  
  // returns the id of the 404 page if one is defined, returns 0 if none is defined, returns -1 if the defined page id does not exist
  private function get_404page_id() {  
    $pageid = get_option( '404page_page_id', 0 );
    if ( $pageid != 0 ) {
      $page = get_post( $pageid );
      if ( !$page || $page->post_status != 'publish' ) {
        $pageid = -1;
      }
    }
    return $pageid;
  }
  
  // addd text domains
  function add_text_domains() {  
    load_plugin_textdomain( '404page_general', false, basename( dirname( __FILE__ ) ) . '/languages' );
    load_plugin_textdomain( '404page', false, basename( dirname( __FILE__ ) ) . '/languages' );
  }
  
  // show meta boxes
  function show_meta_boxes() {
    ?>
    <div id="postbox-container-1" class="postbox-container">
      <div class="meta-box-sortables">
        <div class="postbox">
          <h3><span><?php _e( 'Like this Plugin?', '404page_general' ); ?></span></h3>
          <div class="inside">
            <ul>
              <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="https://wordpress.org/plugins/<?php echo $this->plugin_slug; ?>/"><?php _e( 'Please rate the plugin', '404page_general' ); ?></a></li>
              <li><div class="dashicons dashicons-admin-home"></div>&nbsp;&nbsp;<a href="http://smartware.cc/free-wordpress-plugins/<?php echo $this->plugin_slug; ?>/"><?php _e( 'Plugin homepage', '404page_general'); ?></a></li>
              <li><div class="dashicons dashicons-admin-home"></div>&nbsp;&nbsp;<a href="http://smartware.cc/"><?php _e( 'Author homepage', '404page_general' );?></a></li>
              <li><div class="dashicons dashicons-googleplus"></div>&nbsp;&nbsp;<a href="http://g.smartware.cc/"><?php _e( 'Authors Google+ Page', '404page_general' ); ?></a></li>
              <li><div class="dashicons dashicons-facebook-alt"></div>&nbsp;&nbsp;<a href="http://f.smartware.cc/"><?php _e( 'Authors facebook Page', '404page_general' ); ?></a></li>
            </ul>
          </div>
        </div>
        <div class="postbox">
          <h3><span><?php _e( 'Need help?', '404page_general' ); ?></span></h3>
          <div class="inside">
            <ul>
              <li><div class="dashicons dashicons-book-alt"></div>&nbsp;&nbsp;<a href="http://smartware.cc/docs/<?php echo $this->plugin_slug; ?>/"><?php _e( 'Take a look at the Plugin Doc', '404page_general' ); ?></a></li>
              <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="http://wordpress.org/plugins/<?php echo $this->plugin_slug; ?>/faq/"><?php _e( 'Take a look at the FAQ section', '404page_general' ); ?></a></li>
              <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="http://wordpress.org/support/plugin/<?php echo $this->plugin_slug; ?>/"><?php _e( 'Take a look at the Support section', '404page_general'); ?></a></li>
              <li><div class="dashicons dashicons-admin-comments"></div>&nbsp;&nbsp;<a href="http://smartware.cc/contact/"><?php _e( 'Feel free to contact the Author', '404page_general' ); ?></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php
  }
  
  // add a link to settings page in plugin list
  function add_settings_link( $links ) {
    return array_merge( $links, array( '<a href="' . admin_url( 'options-general.php?page=404pagesettings' ) . '">' . __( 'Settings' ) . '</a>') );
  }

}

$smart404page = new Smart404Page();
?>