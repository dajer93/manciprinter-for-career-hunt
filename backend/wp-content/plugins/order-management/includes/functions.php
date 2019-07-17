<?php

/**
 * Executes the plugin
 */
function run_order_management() {
    /* Register rest routes */
    require_once plugin_dir_path( __FILE__ ) . 'routes.php';
    /** Load scripts and styles */
    require_once plugin_dir_path( __FILE__ ) . 'display.php';
    /** Add wordpress admin page for the react app */
    add_action( 'admin_menu', 'register_order_management_page' );
    
}

function register_order_management_page() {
    add_menu_page(
        'Order Management',
        'Order Management',
        'publish_posts',
        'order-management',
        'render_jam_app',
        '',
        6
    );
    add_submenu_page( 
        'order-management', 
        'Order Management', 
        'Order Management',
        'publish_posts', 
        'order-management'
    );
    add_submenu_page( 
        'order-management', 
        'Options', 
        'Options',
        'publish_posts', 
        'order-management-options',
        'render_jam_options'
    );
}
