<?php
// Custom Post Types and Taxonomies

// 1. Experiences (What's On/Experiences)
create_post_type('experiences', [
	'name' => 'Experiences',
	'singular_name' => 'Experience',
	'slug' => 'experiences',
	'icon' => 'dashicons-star-filled',
	'menu_position' => 5,
	'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author', 'page-attributes'],
	'has_archive' => true,
	'publicly_queryable' => true,
	'show_in_rest' => true,
	'rewrite' => [
		'slug' => 'experiences',
		'with_front' => false
	],
	'description' => 'Manage experiences and activities'
]);
create_taxonomy('experiences_category', [
	'name' => 'Experience Categories',
	'singular_name' => 'Category',
	'object_type' => ['experiences'],
	'slug' => 'experiences-category',
	'hierarchical' => true,
	'show_in_rest' => true,
	'rewrite' => false, // Disable default rewrite, we'll handle it custom
	'description' => 'Categorize experiences by region and theme'
]);

create_taxonomy('experiences_tag', [
	'name' => 'Experience Tags',
	'singular_name' => 'Tag',
	'object_type' => ['experiences'],
	'slug' => 'experience-tag',
	'hierarchical' => false,
	'show_in_rest' => true,
	'description' => 'Tags for experiences'
]);

// 2. Video
create_post_type('video', [
	'name' => 'Videos',
	'singular_name' => 'Video',
	'slug' => 'videos',
	'icon' => 'dashicons-video-alt3',
	'menu_position' => 6,
	'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author'],
	'has_archive' => true,
	'publicly_queryable' => true,
	'show_in_rest' => true,
	'rewrite' => [
		'slug' => 'videos',
		'with_front' => false
	],
	'description' => 'Quản lý video content'
]);

// 3. Shopping
create_post_type('shopping', [
	'name' => 'Shopping',
	'singular_name' => 'Shopping Item',
	'slug' => 'shopping',
	'icon' => 'dashicons-cart',
	'menu_position' => 7,
	'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author'],
	'has_archive' => true,
	'publicly_queryable' => true,
	'show_in_rest' => true,
	'rewrite' => [
		'slug' => 'shopping',
		'with_front' => false
	],
	'description' => 'Manage shopping Shopping Item'
]);

create_taxonomy('shopping_category', [
	'name' => 'Shopping Categories',
	'singular_name' => 'Category',
	'object_type' => ['shopping'],
	'slug' => 'shopping-category',
	'hierarchical' => true,
	'show_in_rest' => true,
	'rewrite' => false, // Disable default rewrite, we'll handle it custom
	'description' => 'Categorize shopping Shopping Item'
]);

// 4. Events
create_post_type('events', [
	'name' => 'Events',
	'singular_name' => 'Event',
	'slug' => 'events',
	'icon' => 'dashicons-calendar-alt',
	'menu_position' => 8,
	'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author'],
	'has_archive' => true,
	'publicly_queryable' => true,
	'show_in_rest' => true,
	'rewrite' => [
		'slug' => 'events',
		'with_front' => false
	],
	'description' => 'Manage events and activities'
]);

create_taxonomy('events_category', [
	'name' => 'Event Categories',
	'singular_name' => 'Category',
	'object_type' => ['events'],
	'slug' => 'events-category',
	'hierarchical' => true,
	'show_in_rest' => true,
	'rewrite' => false, // Disable default rewrite, we'll handle it custom
	'description' => 'Categorize events by type'
]);

// 5. Vouchers
create_post_type('vouchers', [
	'name' => 'Vouchers',
	'singular_name' => 'Voucher',
	'slug' => 'vouchers',
	'icon' => 'dashicons-tickets-alt',
	'menu_position' => 9,
	'supports' => ['title', 'editor', 'thumbnail', 'custom-fields', 'author'],
	'has_archive' => true,
	'publicly_queryable' => true,
	'show_in_rest' => true,
	'rewrite' => [
		'slug' => 'vouchers',
		'with_front' => false
	],
	'description' => 'Quản lý vouchers và khuyến mãi'
]);

create_taxonomy('vouchers_category', [
	'name' => 'Voucher Categories',
	'singular_name' => 'Category',
	'object_type' => ['vouchers'],
	'slug' => 'vouchers-category',
	'hierarchical' => true,
	'show_in_rest' => true,
	'rewrite' => false, // Disable default rewrite, we'll handle it custom
	'description' => 'Categorize vouchers by type'
]);