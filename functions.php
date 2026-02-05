<?php
define('GENERATE_VERSION', '1.1.0');
require get_template_directory() . '/inc/function-root.php';
require get_template_directory() . '/inc/function-custom.php';
require get_template_directory() . '/inc/function-field.php';
require get_template_directory() . '/inc/function-post-types.php';
require get_template_directory() . '/inc/function-cpt-fields.php';
require get_template_directory() . '/inc/function-pagination.php';
require get_template_directory() . '/inc/function-pagination-canhcanh.php';
require get_template_directory() . '/inc/function-setup.php';
require get_template_directory() . '/inc/function-menu-walker.php';

// WPML Support Functions
require get_template_directory() . '/inc/function-wpml.php';
// Custom Rewrite Rule for Single Posts with Category (e.g. /experience/culture/my-post)
add_action('init', function() {
    // 1. Experiences
    add_rewrite_rule(
        '^experience/([^/]+)/([^/]+)/?$',
        'index.php?experiences=$matches[2]', // Matches post_name
        'top'
    );
     // 2. Shopping
     add_rewrite_rule(
        '^shopping/([^/]+)/([^/]+)/?$',
        'index.php?shopping=$matches[2]',
        'top'
    );
    // 3. Events
    add_rewrite_rule(
        '^events/([^/]+)/([^/]+)/?$',
        'index.php?events=$matches[2]',
        'top'
    );
    // 4. Vouchers
    add_rewrite_rule(
        '^vouchers/([^/]+)/([^/]+)/?$',
        'index.php?vouchers=$matches[2]',
        'top'
    );
    // 5. Video (Already handled by CPT 'videos' vs tax 'video', but if user wants video/cat/post...)
    // Current CPT slug is 'videos', Tax slug is 'video'.
    // If we want /video/cat/post -> rewrite CPT slug to 'video' or add rule.
    // User requested tax url: /experience/other (Singular).
    // Assuming user wants consistent singular base.
});


// Filter post links to include category (Hierarchy)
function custom_post_types_post_link($post_link, $post) {
    if (!is_object($post)) return $post_link;
    
    $post_type_taxonomies = [
        'shopping' => 'shopping_category',
        'experiences' => 'experiences_category',
        'events' => 'events_category',
        'vouchers' => 'vouchers_category',
        // 'video' => 'video_category' // Video seems to use 'videos' base vs 'video' tax, might stay separate.
    ];
    
    if (isset($post_type_taxonomies[$post->post_type])) {
        $taxonomy = $post_type_taxonomies[$post->post_type];
        $terms = wp_get_object_terms($post->ID, $taxonomy);
        
        // Convert 'experiences' -> 'experience' to match the rewrites
        $url_slug = $post->post_type;
        if ($post->post_type === 'experiences') $url_slug = 'experience';
        
        // If post has terms, inject the first term slug
        if ($terms && !is_wp_error($terms) && !empty($terms)) {
            // New structure: /experience/category-slug/post-slug/
            return home_url('/' . $url_slug . '/' . $terms[0]->slug . '/' . $post->post_name . '/');
        } 
        
        // If no terms, stick to default? 
        // Default CPT rewrite for 'experiences' is /experience/post-slug
        // This causes conflict with /experience/cat-slug.
        // We really prefer posts to ALWAYS be deep if possible, or we rely on partial match priority.
    }
    
    return $post_link;
}
add_filter('post_type_link', 'custom_post_types_post_link', 1, 2);

// Flush rewrite rules once to apply changes
add_action('wp_loaded', function() {
    if (!get_option('custom_post_types_rewrite_rules_flushed_v9') || isset($_GET['flush_rules'])) {
        flush_rewrite_rules();
        update_option('custom_post_types_rewrite_rules_flushed_v9', true);
    }
});

// Enqueue lazy loading script
function enqueue_lazyload_script() {
    wp_enqueue_script(
        'lazyload', 
        get_template_directory_uri() . '/scripts/lazyload.js', 
        array(), 
        GENERATE_VERSION, 
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_lazyload_script');


function is_video_file($url) {
	if (!$url) return false;

	$ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
	return in_array($ext, ['mp4', 'webm', 'ogg'], true);
}

function get_youtube_id($url) {
	if (!$url) return false;

	$patterns = [
		'~youtu\.be/([^\?&]+)~',
		'~youtube\.com/watch\?v=([^\?&]+)~',
		'~youtube\.com/embed/([^\?&]+)~',
	];

	foreach ($patterns as $pattern) {
		if (preg_match($pattern, $url, $matches)) {
			return $matches[1];
		}
	}

	return false;
}