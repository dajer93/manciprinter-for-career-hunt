<?php

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
    pll_register_string( 'jam', '/etlap' );
}