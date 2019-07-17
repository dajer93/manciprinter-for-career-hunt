<?php

/**
 * The plugin bootstrap file
 *
 * This file is to 
 *  - generate the plugin information in the admin area,
 *  - include all the dependencies used by the plugin,
 *  - registers the activation and deactivation functions and 
 *  - defines a function that starts the plugin.
 *
 * Plugin Name:       Order Management
 * Plugin URI:        https://www.uxjam.hu/projects/order-management
 * Description:       This is an order management application for restaurant websites.
 * Version:           1.0.0
 * Author:            UX Jam
 * Author URI:        https://www.uxjam.hu
 * Text Domain:       order-management
 */

// Abort when this file is called directly.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Code to run when the user activates the plugin.
 */
function activate_order_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/activation.php';
	order_management_activation();
}

/**
 * Code to run when the user deactivates the plugin.
 */
function deactivate_order_management() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/deactivation.php';
	order_management_deactivation();
}

/**
 * Register activation action hooks.
 */
register_activation_hook( __FILE__, 'activate_order_management' );
register_deactivation_hook( __FILE__, 'deactivate_order_management' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
run_order_management();
