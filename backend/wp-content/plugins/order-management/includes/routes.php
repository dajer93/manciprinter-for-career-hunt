<?php
/* register rest api route */
add_action( 'rest_api_init', 'register_order_management_rest_routes' );

/*
 * Register routes
 * GET  /order-management/foods
 * GET  /order-management/state
 * POST /order-management/state
 */
function register_order_management_rest_routes(){
	register_rest_route( 'order-management', '/foods', array(
		'methods' => 'GET',
        'callback' => 'get_foods'
    ));
    if ( ORDER_MANAGEMENT_ENABLE_AUTH === true ) {
        register_rest_route( 'order-management', '/state', array(
            'methods' => 'GET',
            'callback' => 'get_state',
            'permission_callback' => 'get_items_permissions_check'
        ));
        register_rest_route( 'order-management', '/state', array(
            'methods' => 'POST',
            'callback' => 'set_state',
            'permission_callback' => 'get_items_permissions_check'
        ));
    } else {
        register_rest_route( 'order-management', '/state', array(
            'methods' => 'GET',
            'callback' => 'get_state',
        ));
        register_rest_route( 'order-management', '/state', array(
            'methods' => 'POST',
            'callback' => 'set_state',
        ));
    }
 
}

function get_items_permissions_check( $request ) {
    return current_user_can( 'edit_posts' );
}

/**
 * Get data of foods to display in the order management app.
 */
function get_foods() {
    $foods = array();
    /** WP_Query arguments */
    $query_args    = array(
        'posts_per_page'    => 400,
        'post_type'         => 'project',
        'post_status'       => 'private',
        'orderby'           => 'menu_order'
    );
    /** Get foods query */
    $query1 = new WP_Query( $query_args );
    /** WP_Query arguments */
    $query_args    = array(
        'posts_per_page'    => 400,
        'post_type'         => 'project',
        'post_status'       => 'publish',
        'orderby'           => 'menu_order'
    );
    /** Get foods query */
    $query2 = new WP_Query( $query_args );
    $query = array_merge($query1->posts, $query2->posts);
    $hungarian = array();
    foreach($query as $post){
        if ( pll_get_post_language($post->ID) === 'hu' ){
            array_push($hungarian, $post);
        }
    }
    /** Iterate through the post results of the query */
    foreach($hungarian as $post){
        /** Find out the name of the category */
        $category_detail = get_the_terms( $post->ID, 'project_category' );
        $category = $category_detail[0];
        /** Only push foods with category */
        if ( $category->name ) {
            $food = array(
                "id"        => strval($post->ID),
                "price"     => (int) filter_var(get_post_meta($post->ID, 'price')[0], FILTER_SANITIZE_NUMBER_INT),
                "category"  => $category->name,
                "name"      => array(
                    "hu" => str_replace("Magán: ", "", $post->post_title),
                    "en" => str_replace("Private: ", "", get_the_title(pll_get_post($post->ID, 'en'))),
                )
            );
            array_push($foods, $food);
        }
    }
    return $foods;
}

function get_state() {
    return get_option( 'order_management_state' );
}

function set_state() {
    $candidate = $_POST['state'];
    if ( gettype($candidate) !== 'string') die();
    return update_option( 'order_management_state', json_decode(stripslashes($candidate)) );
}

?>