<?php

/**
 * This function runs when the user deactivates the plugin.
 */
function order_management_deactivation(){
  delete_option( 'order_management_state' );
  delete_option( 'order_management_pincode' );
}

