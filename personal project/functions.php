<?php
// Register Custom Post Type
function register_car_post_type() {
    $labels = array(
        'name' => 'Cars',
        'singular_name' => 'Car',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Car',
        'edit_item' => 'Edit Car',
        'new_item' => 'New Car',
        'all_items' => 'All Cars',
        'view_item' => 'View Car',
        'search_items' => 'Search Cars',
        'not_found' => 'No cars found',
        'not_found_in_trash' => 'No cars found in Trash',
        'menu_name' => 'Cars'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'cars'),
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-car'
    );
    register_post_type('car', $args);
}
add_action('init', 'register_car_post_type');
?>