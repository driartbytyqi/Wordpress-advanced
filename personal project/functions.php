<?php

// Register custom post types for About Us, Rate Us, and Profile
function ppt_register_custom_post_types() {
	// About Us
	register_post_type('about_us', array(
		'labels' => array(
			'name' => __('About Us'),
			'singular_name' => __('About Us')
		),
		'public' => true,
		'has_archive' => false,
		'show_in_menu' => true,
		'supports' => array('title', 'editor'),
	));

	// Rate Us
	register_post_type('rate_us', array(
		'labels' => array(
			'name' => __('Rate Us'),
			'singular_name' => __('Rate Us')
		),
		'public' => true,
		'has_archive' => false,
		'show_in_menu' => true,
		'supports' => array('title', 'editor', 'comments'),
	));

	// Profile
	register_post_type('profile', array(
		'labels' => array(
			'name' => __('Profile'),
			'singular_name' => __('Profile')
		),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'supports' => array('title', 'editor', 'author'),
	));
}
add_action('init', 'ppt_register_custom_post_types');


