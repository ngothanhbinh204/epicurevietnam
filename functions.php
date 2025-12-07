<?php
define('GENERATE_VERSION', '1.1.0');
require get_template_directory() . '/inc/function-root.php';
require get_template_directory() . '/inc/function-custom.php';
require get_template_directory() . '/inc/function-field.php';
require get_template_directory() . '/inc/function-post-types.php';
require get_template_directory() . '/inc/function-cpt-fields.php';
require get_template_directory() . '/inc/function-pagination.php';
require get_template_directory() . '/inc/function-setup.php';
require get_template_directory() . '/inc/function-menu-walker.php';

// WPML Support Functions
require get_template_directory() . '/inc/function-wpml.php';

// Fix rewrite rules for custom post type taxonomies
function flush_rewrite_rules_on_activation() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'flush_rewrite_rules_on_activation');

// Custom URL structure for all custom post types
function custom_post_types_rewrite_rules() {
    // Shopping rules - with category
    add_rewrite_rule(
        '^shopping/([^/]+)/([^/]+)/?$',
        'index.php?shopping=$matches[2]',
        'top'
    );
    // Shopping rules - category archive OR post without category
    add_rewrite_rule(
        '^shopping/([^/]+)/?$',
        'index.php?shopping_category=$matches[1]&shopping_fallback=$matches[1]',
        'top'
    );
    
    // Experiences rules - with category
    add_rewrite_rule(
        '^experiences/([^/]+)/([^/]+)/?$',
        'index.php?experiences=$matches[2]',
        'top'
    );
    // Experiences rules - category archive OR post without category
    add_rewrite_rule(
        '^experiences/([^/]+)/?$',
        'index.php?experiences_category=$matches[1]&experiences_fallback=$matches[1]',
        'top'
    );
    
    // Events rules - with category
    add_rewrite_rule(
        '^events/([^/]+)/([^/]+)/?$',
        'index.php?events=$matches[2]',
        'top'
    );
    // Events rules - category archive OR post without category
    add_rewrite_rule(
        '^events/([^/]+)/?$',
        'index.php?events_category=$matches[1]&events_fallback=$matches[1]',
        'top'
    );
    
    // Vouchers rules - with category
    add_rewrite_rule(
        '^vouchers/([^/]+)/([^/]+)/?$',
        'index.php?vouchers=$matches[2]',
        'top'
    );
    // Vouchers rules - category archive OR post without category
    add_rewrite_rule(
        '^vouchers/([^/]+)/?$',
        'index.php?vouchers_category=$matches[1]&vouchers_fallback=$matches[1]',
        'top'
    );
    
    // Video rules (new URL: videos) - with category
    add_rewrite_rule(
        '^videos/([^/]+)/([^/]+)/?$',
        'index.php?video=$matches[2]',
        'top'
    );
    // Video rules - category archive OR post without category
    add_rewrite_rule(
        '^videos/([^/]+)/?$',
        'index.php?video_category=$matches[1]&video_fallback=$matches[1]',
        'top'
    );
    
    // Video rules (old URL: video - backward compatibility) - with category
    add_rewrite_rule(
        '^video/([^/]+)/([^/]+)/?$',
        'index.php?video=$matches[2]',
        'top'
    );
    // Video rules (old URL) - category archive OR post without category
    add_rewrite_rule(
        '^video/([^/]+)/?$',
        'index.php?video_category=$matches[1]&video_fallback=$matches[1]',
        'top'
    );
}
add_action('init', 'custom_post_types_rewrite_rules');

// Add query vars for all custom taxonomies
function custom_post_types_query_vars($vars) {
    $vars[] = 'shopping_category';
    $vars[] = 'experiences_category';
    $vars[] = 'events_category';
    $vars[] = 'vouchers_category';
    $vars[] = 'video_category';
    // Fallback vars for posts without category
    $vars[] = 'shopping_fallback';
    $vars[] = 'experiences_fallback';
    $vars[] = 'events_fallback';
    $vars[] = 'vouchers_fallback';
    $vars[] = 'video_fallback';
    return $vars;
}
add_filter('query_vars', 'custom_post_types_query_vars');

// Handle posts without category - check if slug is a post or a category
function handle_posts_without_category($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $fallback_mappings = [
        'video_fallback' => ['post_type' => 'video', 'taxonomy' => 'video_category', 'category_var' => 'video_category'],
        'shopping_fallback' => ['post_type' => 'shopping', 'taxonomy' => 'shopping_category', 'category_var' => 'shopping_category'],
        'experiences_fallback' => ['post_type' => 'experiences', 'taxonomy' => 'experiences_category', 'category_var' => 'experiences_category'],
        'events_fallback' => ['post_type' => 'events', 'taxonomy' => 'events_category', 'category_var' => 'events_category'],
        'vouchers_fallback' => ['post_type' => 'vouchers', 'taxonomy' => 'vouchers_category', 'category_var' => 'vouchers_category'],
    ];
    
    foreach ($fallback_mappings as $fallback_var => $config) {
        $slug = get_query_var($fallback_var);
        if (!empty($slug)) {
            // First check if it's a valid category
            $term = get_term_by('slug', $slug, $config['taxonomy']);
            if ($term && !is_wp_error($term)) {
                // It's a category, keep the taxonomy query
                return;
            }
            
            // Not a category, check if it's a post
            $post = get_page_by_path($slug, OBJECT, $config['post_type']);
            if ($post) {
                // It's a post without category, modify the query
                $query->set('post_type', $config['post_type']);
                $query->set('name', $slug);
                $query->set($config['post_type'], $slug);
                // Clear the taxonomy query
                $query->set($config['category_var'], '');
                $query->is_single = true;
                $query->is_singular = true;
                $query->is_tax = false;
                $query->is_archive = false;
            }
            break;
        }
    }
}
add_action('pre_get_posts', 'handle_posts_without_category');

// Filter post links for all custom post types
function custom_post_types_post_link($post_link, $post) {
    if (!is_object($post)) return $post_link;
    
    $post_type_taxonomies = [
        'shopping' => 'shopping_category',
        'experiences' => 'experiences_category',
        'events' => 'events_category',
        'vouchers' => 'vouchers_category',
        'video' => 'video_category'
    ];
    
    if (isset($post_type_taxonomies[$post->post_type])) {
        $taxonomy = $post_type_taxonomies[$post->post_type];
        $terms = wp_get_object_terms($post->ID, $taxonomy);
        
        // Use 'videos' for video post type, otherwise use post_type slug
        $url_slug = ($post->post_type === 'video') ? 'videos' : $post->post_type;
        
        if ($terms && !is_wp_error($terms) && !empty($terms)) {
            // Post has category - use /post-type/category/post-name/
            return home_url('/' . $url_slug . '/' . $terms[0]->slug . '/' . $post->post_name . '/');
        } else {
            // Post has NO category - use /post-type/post-name/
            return home_url('/' . $url_slug . '/' . $post->post_name . '/');
        }
    }
    
    return $post_link;
}
add_filter('post_type_link', 'custom_post_types_post_link', 1, 2);

// Filter term links for all custom taxonomies
function custom_post_types_term_link($termlink, $term) {
    $taxonomy_post_types = [
        'shopping_category' => 'shopping',
        'experiences_category' => 'experiences',
        'events_category' => 'events',
        'vouchers_category' => 'vouchers',
        'video_category' => 'videos'
    ];
    
    if (isset($taxonomy_post_types[$term->taxonomy])) {
        $post_type = $taxonomy_post_types[$term->taxonomy];
        return home_url('/' . $post_type . '/' . $term->slug . '/');
    }
    
    return $termlink;
}
add_filter('term_link', 'custom_post_types_term_link', 10, 2);

// Flush rewrite rules once to apply changes
add_action('wp_loaded', function() {
    if (!get_option('custom_post_types_rewrite_rules_flushed_v4') || isset($_GET['flush_rules'])) {
        flush_rewrite_rules();
        update_option('custom_post_types_rewrite_rules_flushed_v4', true);
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