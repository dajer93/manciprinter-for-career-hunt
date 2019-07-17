<?php

/**
 * The smart Archive Page Remove core plugin class
 */

 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The core plugin class
 */
if ( !class_exists( 'PP_Smart_Archive_Page_Remove' ) ) { 

  class PP_Smart_Archive_Page_Remove {
    
    /**
     * Instance
     *
     * @since  3
     * @var    singleton
     * @access protected
     */
    protected static $_instance = null;
    
    
    /**
     * Plugin Main File Path and Name
     * was $_file before
     * removed in v3
     */
     
    
    /**
     * Plugin Name
     *
     * @since  1
     * @var    string
     * @access private
     */
    private $plugin_name;
    
    
    /**
     * Plugin Slug
     *
     * @since  1
     * @var    string
     * @access private
     */
    private $plugin_slug;
    
    
    /**
     * Plugin Version
     *
     * @since  3
     * @var    int
     * @access private
     * was $version before
     */
    private $plugin_version;
    
    
    public $settings;
    private $option_name;
    private $settings_names;
    private $settings_samples;
    private $admin_handle;
    private $_autoloaddir;

    
    /**
     * Init the Class 
     *
     * @since 1
     * @see getInstance
     */
    protected function __construct( $settings ) {
     
      $this->plugin_file    = $settings['file'];
      $this->plugin_slug    = $settings['slug'];
      $this->plugin_name    = $settings['name'];
      $this->plugin_version = $settings['version'];
      
      $this->option_name = str_replace( '-', '_', $this->plugin_slug );
      
      $this->init();
      
    }
    
    
    /**
     * Prevent Cloning
     *
     * @since 3
     */
    protected function __clone() {}
    
    
    /**
	   * Get the Instance
     *
     * @since 3
     * @param array $settings {
     *   @type string $file    Plugin Main File Path and Name
     *   @type string $slug    Plugin Slug
     *   @type string $name    Plugin Name
     *   @type int    $version Plugin Verion
     * }
     * @return singleton
     */
    public static function getInstance( $settings ) {
     
      if ( null === self::$_instance ) {

        self::$_instance = new self( $settings );
        
      }
      
      return self::$_instance;
      
    }
    
    
    /**
	   * get plugin file
     *
     * @since 3
     * @access public
     */
    public function get_plugin_file() {
      
      return $this->plugin_file;
      
    }
    
    
    /**
	   * get plugin slug
     *
     * @since 3
     * @access public
     */
    public function get_plugin_slug() {
      
      return $this->plugin_slug;
      
    }
    
    
    /**
	   * get plugin name
     *
     * @since 3
     * @access public
     */
    public function get_plugin_name() {
      
      return $this->plugin_name;
      
    }
    
    
    /**
	   * get plugin version
     *
     * @since 3
     * @access public
     */
    public function get_plugin_version() {
      
      return $this->plugin_version;
      
    }
    
    
    /**
     * do plugin init 
     */
    private function init() {
      
      add_action( 'wp', array( $this, 'archive_remove' ) );
      add_action( 'init', array( $this, 'add_text_domain' ) );
      add_action( 'admin_init', array( $this, 'admin_init' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'admin_style' ) );
      add_action( 'admin_enqueue_scripts', array( $this, 'admin_js' ) );
      add_action( 'admin_menu', array( $this, 'admin_menu' ) );
      add_filter( 'plugin_action_links_' . plugin_basename( $this->get_plugin_file() ), array( $this, 'add_settings_links' ) ); 
      add_action( 'admin_notices', array( $this, 'admin_notices' ) );
      add_action( 'wp_ajax_pp_smart_archive_page_remove_dismiss_admin_notice', array( $this, 'dismiss_admin_notice' ) );
      
    }
    
    
    /**
     * add text domain
     */
    function add_text_domain() {  
    
      load_plugin_textdomain( 'smart-archive-page-remove' );
      
    }
    
    
    /**
     * get the settings
     */
    private function get_settings() {
      
      $this->settings = array();
      $settings = get_option( $this->option_name );
      $defaults = array(
        'author' => false,
        'category' => false,
        'tag' => false,
        'daily' => false,
        'monthly' => false,
        'yearly' => false
      );
      
      if ( $settings == '' ) {
        
        $this->settings = $defaults;
        update_option( $this->option_name, serialize( $settings ) );
        
      } else {
        
        $this->settings = shortcode_atts( $defaults, unserialize( $settings ) );
        
      }
    }
    
    
    /**
     * send an 404 error if accessing an archive page that should be removed
     */
    function archive_remove() {
      
      global $wp_query;
      
      if ( is_archive() ) {
        
        $this->get_settings();
        $archive = array(
          'author' => $wp_query->is_author(),
          'category' => $wp_query->is_category(),
          'tag' => $wp_query->is_tag(),
          'daily' => $wp_query->is_day(),
          'monthly' => $wp_query->is_month(),
          'yearly' => $wp_query->is_year()
        );
        
        foreach ( $archive as $key => $value ) {
          
          if ( $value && $this->settings[$key] ) {
            
            $wp_query->set_404();
            status_header(404);
            break;
            
          }
          
        }
        
      }
      
    }
      
    
    /**
     * init admin
     */
    function admin_init() {
      
      $this->get_settings();
      
      $this->settings_names = array(
        'author' => __( 'Author Archive Page', 'smart-archive-page-remove' ),
        'category' => __( 'Category Archive Page', 'smart-archive-page-remove' ),
        'tag' => __( 'Tag Archive Page', 'smart-archive-page-remove' ),
        'daily' => __( 'Daily Archive Page', 'smart-archive-page-remove' ),
        'monthly' => __( 'Monthly Archive Page', 'smart-archive-page-remove' ),
        'yearly' => __('Yearly Archive Page', 'smart-archive-page-remove' )
      );
      
      $terms = get_terms( 'category', array( 'orderby' => 'count', 'order' => 'desc', 'hide_empty' => 0, 'childless' => true, 'parent' => 0, 'number' => 1 ) );
      if ( count( $terms ) > 0 ) {
        
        $termsample = get_term_link( $terms[0] );
        
      } else {
        
        $termsample = trailingslashit( get_site_url( get_option( 'category_base' ) ) ) . __( 'my-category', 'smart-archive-page-remove' );
        
      }
      
      $tags = get_tags( array ( 'orderby' => 'count', 'order' => 'desc', 'hide_empty' => 0, 'number' => 1) );
      if ( count( $tags ) > 0 ) {
        
        $tagsample = get_tag_link( $tags[0]->term_id );
        
      } else {

        $tagsample = trailingslashit( get_site_url( get_option( 'tag_base' ) ) ) . __( 'my-tag', 'smart-archive-page-remove' );
        
      }
      
      $this->settings_samples = array(
        'author' => get_author_posts_url( get_current_user_id() ), 
        'category' => $termsample,
        'tag' => $tagsample,
        'daily' => get_day_link( '', '', '' ),
        'monthly' => get_month_link( '', '' ),
        'yearly' => get_year_link( '' ),
      );
      
      add_settings_section( 'smart-archive-page-remove-settings', '', array( $this, 'admin_section_title' ), 'smartarchivepageremovesettings' );
      register_setting( 'smart-archive-page-remove_settings', 'smart_archive_page_remove', array( $this, 'get_post_settings' ) );
      
      foreach ( $this->settings as $key => $value ) {
        
        $this->add_single_settings_field( $key, $this->settings_samples[$key] );
        
      }
      
    }
    
    
    /**
     * add a settings field
     */
    function add_single_settings_field( $name, $example ) {
      
      add_settings_field( 
        'smartarchivepageremovesettings_' . $name, 
        '',
        array( $this, 'admin_show_field' ), 
        'smartarchivepageremovesettings', 
        'smart-archive-page-remove-settings', 
        array( 'option_name' => $this->option_name, 'name' => $name, 'value' => $this->settings[$name], 'label_for' => $name, 'example' => $example, 'label' => $this->settings_names[$name] ) 
      );
      
    }
    
    
    /**
     * render a settings field
     */
    function admin_show_field( $args ) {
      
      echo '<p class="toggle"><input type="checkbox" name="' . $args['option_name'] . '[' . $args['name'] . ']" id="' . $args['name'] . '" value="1"' . ( ( $args['value'] == true ) ?  'checked="checked"' : '' ) . ' /><label for="' . $args['name'] . '" class="check"></label><strong>' . $args['label'] . '<strong></p><p><span style="white-space: nowrap">' . __( 'e.g.', 'smart-archive-page-remove' ) . ' <code>' . $args['example'] . '</code></span></p>';
      
    }
    
    
    /**
     * render title for settings section
     */
    function admin_section_title() {
      
      echo '<h2 class="title">' . __( 'Remove the following Archive Pages', 'smart-archive-page-remove' ) . ' <a class="dashicons dashicons-editor-help" href="https://petersplugins.com/docs/' . $this->get_plugin_slug() .'"></a></h2>';
    
    }
    
    
    /**
     * create the menu entry
     */
    function admin_menu() {
    
      $this->admin_handle = add_options_page( __( 'Archive Pages', "smart-archive-page-remove" ), __( 'Archive Pages', 'smart-archive-page-remove' ), 'manage_options', 'smartarchivepageremovesettings', array( $this, 'admin_page' ) );

    }
    
    
    /**
     * handle the POST data
     */
    function get_post_settings( $in_set ) {
      
      $out_set = array();
      
      if ( $in_set ) {
        
        foreach ( $in_set as $key => $value ) {
          
          $out_set[$key] = true;
          
        }
        
      }
      
      return serialize( $out_set );
      
    }
   
    
    /**
     * show admin page
     */
    function admin_page() {
      
      if ( !current_user_can( 'manage_options' ) )  {
        
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        
      }
      
      require_once( plugin_dir_path( $this->get_plugin_file() ) . '/inc/admin/admin-page.php' );
      
    }
    
    
    /**
     * show the nav icons on admin page
     * @since 3
     */
    function show_nav_icons( $icons ) {
       
      foreach ( $icons as $icon ) {
         
        echo '<a href="' . $icon['link'] . '" title="' . $icon['title'] . '"><span class="dashicons ' . $icon['icon'] . '"></span><span class="text">' . $icon['title'] . '</span></a>';
         
      }
      
    }
    
    
    /**
     * add admin css file
     */
    function admin_style() {
      
      if ( get_current_screen()->id == $this->admin_handle ) {
        
        wp_enqueue_style( 'pp-admin-page', plugins_url( 'assets/css/pp-admin-page-v2.css', $this->get_plugin_file() ) );
        wp_enqueue_style( 'smart-archive-page-remove-ui', plugins_url( 'assets/css/smart-archive-page-remove-ui.css', $this->get_plugin_file() ) );
        
      }
      
    }
    
    
    /**
     * add admin js file
     */
    function admin_js() {
        
      wp_enqueue_script( 'smart-archive-page-remove-ui', plugins_url( 'assets/js/smart-archive-page-remove-ui.js', $this->get_plugin_file() ), array( 'jquery' ), $this->get_plugin_version(), true );
      
    }
    
    
    /**
     * add links to plugins table
     */
    function add_settings_links( $links ) {
      
      return array_merge( $links, array( '<a href="' . admin_url( 'options-general.php?page=smartarchivepageremovesettings' ) . '" title="' . __( 'Settings', 'smart-archive-page-remove' ) . '">' . __( 'Settings', 'smart-archive-page-remove' ) . '</a>', '<a href="https://wordpress.org/support/plugin/' . $this->get_plugin_slug() . '/reviews/" title="' . __( 'Please rate plugin', 'smart-archive-page-remove' ) . '">' . __( 'Please rate plugin', 'smart-archive-page-remove' ) . '</a>' ) );
      
    }
    
    
    /**
     * show admin notices
     */
    function admin_notices() {
      
      // invite to follow me
      // v1.4 : only show message to useres with the manage_options capability
      if ( current_user_can( 'manage_options' ) && get_user_meta( get_current_user_id(), 'pp-smart-archive-page-remove-admin-notice-1', true ) != 'dismissed' ) {
        ?>
        <div class="notice is-dismissible pp-smart-archive-page-remove-admin-notice" id="pp-smart-archive-page-remove-admin-notice-1">
          <p style="min-height: 48px; background-image: url(<?php echo plugins_url( 'assets/img/pluginicon.png', $this->get_plugin_file() ); ?>); background-repeat: no-repeat; padding-left: 60px;"><strong><?php _e( 'Do you like the smart Archive Page Remove plugin?', 'smart-archive-page-remove' ); ?></strong><br /><?php _e( 'Follow me:', 'smart-archive-page-remove' ); ?> <a class="dashicons dashicons-facebook-alt" href="https://www.facebook.com/petersplugins/" title="<?php _e( 'Authors facebook Page', 'smart-archive-page-remove' ); ?>"></a></p>
        </div>
        <?php
      }
      
      // ask for rating
      // in 30 days at the earliest
      // @since 1.5
      if ( ! get_option( 'pp-smart-archive-page-remove-admin-notice-2-start' ) ) {
        update_option( 'pp-smart-archive-page-remove-admin-notice-2-start', time() + 30 * 24 * 60 * 60 );
      }
      if ( get_option( 'pp-smart-archive-page-remove-admin-notice-2-start' ) <= time() ) {
        if ( current_user_can( 'manage_options' ) && get_user_meta( get_current_user_id(), 'pp-smart-archive-page-remove-admin-notice-2', true ) != 'dismissed' ) {
          ?>
          <div class="notice is-dismissible pp-smart-archive-page-remove-admin-notice" id="pp-smart-archive-page-remove-admin-notice-2">
            <p style="min-height: 48px; background-image: url(<?php echo plugins_url( 'assets/img/pluginicon.png', $this->get_plugin_file() ); ?>); background-repeat: no-repeat; padding-left: 60px;"><?php _e( 'If you like the smart Archive Page Remove plugin please support my work with giving it a good rating so that other users know it is helpful for you. Thanks.', 'smart-archive-page-remove' ); ?><br /><a href="https://wordpress.org/support/plugin/<?php echo $this->get_plugin_slug(); ?>/reviews/#new-post" title="<?php _e( 'Please rate plugin', 'smart-archive-page-remove' ); ?>"><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span></a></p>
          </div>
          <?php
        }
      }
      
    }
    
    
    /**
     * dismiss an admin notice
     */
    function dismiss_admin_notice() {
      
      if ( isset( $_POST['pp_smart_archive_page_remove_dismiss_admin_notice'] ) ) {
        update_user_meta( get_current_user_id(), $_POST['pp_smart_archive_page_remove_dismiss_admin_notice'], 'dismissed' );
      }
      
      wp_die();
      
    }
    
    
    /**
     * uninstall plugin
     */
    function uninstall() {
      if( is_multisite() ) {
        $this->uninstall_network();
      } else {
        $this->uninstall_single();
      }
    }
    
    
    /**
     * uninstall network wide
     */
    function uninstall_network() {
      global $wpdb;
      $activeblog = $wpdb->blogid;
      $blogids = $wpdb->get_col( esc_sql( 'SELECT blog_id FROM ' . $wpdb->blogs ) );
      foreach ($blogids as $blogid) {
        switch_to_blog( $blogid );
        $this->uninstall_single();
      }
      switch_to_blog( $activeblog );
    }
    
    
    /**
     * uninstall for a single blog
     */
    function uninstall_single() {
      delete_option( $this->option_name );
    }

  }
}
 
?>