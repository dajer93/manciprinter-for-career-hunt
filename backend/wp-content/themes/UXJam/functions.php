<?php

function jam_add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','jam_add_cors_http_header');


// Your php code goes here
include(get_stylesheet_directory() . '/jam-restaurant-menu.php');
// Saját JS fájl + rest api hozzáférés
add_action('wp_enqueue_scripts', 'enqueue_jam_script');
function enqueue_jam_script(){
    wp_enqueue_script('jam-script', get_stylesheet_directory_uri().'/scripts/theme.js', array('jquery'), '', true);
}

function rewrite_projects_to_menu() {
	return array(
		'feeds' => true,
		'slug' => 'menu',
		'with_front' => false,
	);
}
add_filter( 'et_project_posttype_rewrite_args', 'rewrite_projects_to_menu' );

function jam_rename_project_labels( $labels ){
    # Labels
    $labels->name = 'Étlap';
    $labels->singular_name = 'Étlap';
    $labels->add_new = 'Étel hozzáadása';
    $labels->add_new_item = 'Étel hozzáadása';
    $labels->edit_item = 'Étel szerkesztése';
    $labels->new_item = 'Étel hozzáadása';
    $labels->view_item = 'Ételek megtekintése';
    $labels->view_items = 'Ételek megtekintése';
    $labels->search_items = 'Keresés';
    $labels->not_found = 'Nincs találat';
    $labels->not_found_in_trash = 'Nincs találat';
    $labels->parent_item_colon = 'Parent news'; // Not for "post"
    $labels->archives = 'News Archives';
    $labels->attributes = 'News Attributes';
    $labels->insert_into_item = 'Insert into news';
    $labels->uploaded_to_this_item = 'Uploaded to this news';
    $labels->featured_image = 'Featured Image';
    $labels->set_featured_image = 'Set featured image';
    $labels->remove_featured_image = 'Remove featured image';
    $labels->use_featured_image = 'Use as featured image';
    $labels->filter_items_list = 'Filter news list';
    $labels->items_list_navigation = 'News list navigation';
    $labels->items_list = 'News list';

    # Menu
    $labels->menu_name = 'Étlap';
    $labels->all_items = 'Összes étel';
    $labels->name_admin_bar = 'Étlap';

    return $labels;
}
add_filter( 'post_type_labels_project', 'jam_rename_project_labels' );

if (function_exists("pll_register_string")) {
    pll_register_string( 'jam', 'Asztalfoglalás' );
    pll_register_string( 'jam', 'Étlap' );
    pll_register_string( 'jam', 'Tel.:' );
    pll_register_string( 'jam', 'Cím:' );
    pll_register_string( 'jam', 'Nyitvatartás' );
    pll_register_string( 'jam', 'H-Szo:' );
    pll_register_string( 'jam', 'V:' );
    pll_register_string( 'jam', 'Zárva' );
    pll_register_string( 'jam', 'Kapcsolat' );
    pll_register_string( 'jam', 'Teljes étlap' );
    pll_register_string( 'jam', '/etlap' );
}

function jam_get_related_foods( $food_id ) {
    remove_all_filters('posts_orderby');
    $category = wp_get_object_terms( $food_id, 'project_category' )[0]->to_array();
    $category_slug = $category['slug'];
    $query_args    = array(
        'posts_per_page' => 4,
        'post_type'      => 'project',
        'post_status'    => 'publish',
        'order'                  => 'DESC',
        'orderby'                => 'rand'
    );
    
    switch ( $category_slug ) {
        case 'eloetelek-tapasok':
            $query_args['tax_query'] = array(
        array(
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => array( 'foetelek', 'desszertek' ) 
        )
        );
        break;
        case 'starters-tapas':
            $query_args['tax_query'] = array(
        array(
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => array( 'main-courses', 'desserts' ) 
        )
        );
            break;
        case 'foetelek':
            $query_args['tax_query'] = array(
        array(
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => array( 'eloetelek-tapasok', 'desszertek' ) 
        )
        );
        case 'main-courses':
            $query_args['tax_query'] = array(
        array(
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => array( 'starters-tapas', 'desserts' ) 
        )
        );
            break;

        case 'desszertek':
            $query_args['tax_query'] = array(
        array(
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => array( 'foetelek', 'eloetelek-tapasok' ) 
        )
        );
        case 'desserts':
            $query_args['tax_query'] = array(
        array(
        'taxonomy' => 'project_category',
        'field' => 'slug',
        'terms' => array( 'main-courses', 'starters-tapas' ) 
        )
        );
            break;
        default:
            break;
    }
    foreach( get_posts($query_args) as $food ){
        ?>
        <div id="food-<?php echo esc_attr( $food->ID ); ?>" class="food-<?php echo esc_attr( $food->post_class_name ); ?> jam-menu-item">
            <div class="jam-menu-top">
                <div class="jam-menu-title">
                    <h2 class="et_pb_module_header">
                        <a href="<?php echo get_permalink( $food ); ?>" title="<?php echo esc_attr( $food->post_title ); ?>">
                            <?php echo esc_html( $food->post_title ); ?>
                        </a>
                    </h2>
                </div>
                <div class="jam-menu-price"><?php echo get_post_meta($food->ID, 'price')[0] ?></div>
            </div>
            <div class="jam-menu-bottom">
                <?php $post_content = et_strip_shortcodes( et_delete_post_first_video( $food->post_excerpt ), true ); ?>
                <div class="jam-menu-content <?php echo $with_image; ?>">
                    <?php echo apply_filters( 'the_content', $post_content ); ?>
                </div>
            </div>
            <div class="jam-menu-image">
                <?php if( wp_get_attachment_image_src( get_post_thumbnail_id( $food->ID ), 'single-post-thumbnail' )[0] ){ ?>
                <a href="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $food->ID ), 'single-post-thumbnail' )[0]; ?>" title="<?php echo esc_attr( $food->post_title ); ?>">
                    <span class="et_portfolio_image">
                        <img src="<?php echo wp_get_attachment_thumb_url( get_post_thumbnail_id($food->ID) ); ?>" alt="<?php echo esc_attr( $food->post_title ); ?>" width="1080" height="9999" />
                    </span>
                </a>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}
add_action( 'jam_related_foods', 'jam_get_related_foods' );