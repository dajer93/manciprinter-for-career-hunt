<?php

/**
 * The smart Archive Page Remove Plugin Loader
 *
 * @since 7
 *
 **/
 
// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Load files
 */
require_once( plugin_dir_path( __FILE__ ) . '/inc/class-smart-archive-page-remove.php' );


/**
 * Main Function
 */
function pp_smart_archive_page_remove() {

  return PP_Smart_Archive_Page_Remove::getInstance( array(
    'file'    => dirname( __FILE__ ) . '/smart-archive-page-remove.php',
    'slug'    => basename( pathinfo( __FILE__, PATHINFO_DIRNAME ) ),
    'name'    => 'smart Archive Page Remove',
    'version' => '3'
  ) );
    
}



/**
 * Run the plugin
 */
pp_smart_archive_page_remove();


?>