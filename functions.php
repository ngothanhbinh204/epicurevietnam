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
    // Shopping rules
    add_rewrite_rule(
        '^shopping/([^/]+)/?$',
        'index.php?shopping_category=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^shopping/([^/]+)/([^/]+)/?$',
        'index.php?shopping=$matches[2]',
        'top'
    );
    
    // Experiences rules
    add_rewrite_rule(
        '^experiences/([^/]+)/?$',
        'index.php?experiences_category=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^experiences/([^/]+)/([^/]+)/?$',
        'index.php?experiences=$matches[2]',
        'top'
    );
    
    // Events rules
    add_rewrite_rule(
        '^events/([^/]+)/?$',
        'index.php?events_category=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^events/([^/]+)/([^/]+)/?$',
        'index.php?events=$matches[2]',
        'top'
    );
    
    // Vouchers rules
    add_rewrite_rule(
        '^vouchers/([^/]+)/?$',
        'index.php?vouchers_category=$matches[1]',
        'top'
    );
    add_rewrite_rule(
        '^vouchers/([^/]+)/([^/]+)/?$',
        'index.php?vouchers=$matches[2]',
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
    return $vars;
}
add_filter('query_vars', 'custom_post_types_query_vars');

// Filter post links for all custom post types
function custom_post_types_post_link($post_link, $post) {
    if (!is_object($post)) return $post_link;
    
    $post_type_taxonomies = [
        'shopping' => 'shopping_category',
        'experiences' => 'experiences_category',
        'events' => 'events_category',
        'vouchers' => 'vouchers_category'
    ];
    
    if (isset($post_type_taxonomies[$post->post_type])) {
        $taxonomy = $post_type_taxonomies[$post->post_type];
        $terms = wp_get_object_terms($post->ID, $taxonomy);
        if ($terms && !is_wp_error($terms)) {
            return home_url('/' . $post->post_type . '/' . $terms[0]->slug . '/' . $post->post_name . '/');
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
        'vouchers_category' => 'vouchers'
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
    if (!get_option('custom_post_types_rewrite_rules_flushed') || isset($_GET['flush_rules'])) {
        flush_rewrite_rules();
        update_option('custom_post_types_rewrite_rules_flushed', true);
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