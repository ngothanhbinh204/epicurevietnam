<?php
/**
 * WPML Support Functions
 */

// Check if WPML is active
function is_wpml_active() {
    return function_exists('icl_object_id');
}

// Get current language
function get_current_language() {
    if (is_wpml_active()) {
        return ICL_LANGUAGE_CODE;
    }
    return 'vi'; // Default to Vietnamese
}

// Get language switcher
function get_language_switcher($args = array()) {
    if (!is_wpml_active()) {
        return '';
    }
    
    $defaults = array(
        'skip_missing' => 1,
        'orderby' => 'custom',
        'order' => 'asc'
    );
    
    $args = wp_parse_args($args, $defaults);
    
    return do_action('wpml_add_language_selector', $args);
}

// Custom language switcher for header
function custom_language_switcher() {
    if (!is_wpml_active()) {
        return '';
    }
    
    $languages = apply_filters('wpml_active_languages', NULL, array(
        'orderby' => 'code',
        'order' => 'desc',
        'skip_missing' => 0,
        'link_empty_to' => str_replace('&amp;', '&', $_SERVER['REQUEST_URI'])
    ));
    
    if (!$languages) {
        return '';
    }
    
    $output = '<div class="language-switcher">';
    
    foreach ($languages as $code => $language) {
        $active_class = $language['active'] ? 'active' : '';
        $output .= '<a href="' . $language['url'] . '" class="lang-link ' . $active_class . '" data-lang="' . $code . '">';
        $output .= strtoupper($code);
        $output .= '</a>';
    }
    
    $output .= '</div>';
    
    return $output;
}

// Get translated post ID
function get_translated_post_id($post_id, $lang_code = null) {
    if (!is_wpml_active()) {
        return $post_id;
    }
    
    if (!$lang_code) {
        $lang_code = get_current_language();
    }
    
    return apply_filters('wpml_object_id', $post_id, 'post', true, $lang_code);
}

// Get translated term ID
function get_translated_term_id($term_id, $taxonomy, $lang_code = null) {
    if (!is_wpml_active()) {
        return $term_id;
    }
    
    if (!$lang_code) {
        $lang_code = get_current_language();
    }
    
    return apply_filters('wpml_object_id', $term_id, $taxonomy, true, $lang_code);
}

// Register strings for translation
function register_theme_strings() {
    if (!is_wpml_active()) {
        return;
    }
    
    // Common strings that need translation
    $strings = array(
        'Read More' => 'Read More',
        'View All' => 'View All',
        'Load More' => 'Load More',
        'Search' => 'Search',
        'No results found' => 'No results found',
        'Categories' => 'Categories',
        'Tags' => 'Tags',
        'Share' => 'Share',
        'Related Posts' => 'Related Posts',
        'Back to Top' => 'Back to Top',
        'Contact Us' => 'Contact Us',
        'Send Message' => 'Send Message',
        'Name' => 'Name',
        'Email' => 'Email',
        'Phone' => 'Phone',
        'Subject' => 'Subject',
        'Message' => 'Message',
        'Send' => 'Send'
    );
    
    foreach ($strings as $key => $value) {
        do_action('wpml_register_single_string', 'theme-strings', $key, $value);
    }
}
add_action('init', 'register_theme_strings');

// Function to get translated string
function get_translated_string($string, $domain = 'theme-strings') {
    if (!is_wpml_active()) {
        return $string;
    }
    
    return apply_filters('wpml_translate_single_string', $string, $domain, $string);
}

// WPML Configuration for custom post types and taxonomies
function wpml_custom_post_types_config() {
    if (!is_wpml_active()) {
        return;
    }
    
    // Custom post types
    $post_types = array('experiences', 'shopping', 'events', 'vouchers', 'video');
    
    foreach ($post_types as $post_type) {
        do_action('wpml_register_post_type', $post_type, array(
            'translate' => 1,
            'display_as_translated' => 1
        ));
    }
    
    // Custom taxonomies
    $taxonomies = array(
        'experiences_category',
        'shopping_category', 
        'events_category',
        'vouchers_category',
        'video_category'
    );
    
    foreach ($taxonomies as $taxonomy) {
        do_action('wpml_register_taxonomy', $taxonomy, array(
            'translate' => 1
        ));
    }
}
add_action('init', 'wpml_custom_post_types_config', 99);

// Fix permalink structure for translated posts
function wpml_fix_custom_permalink_structure($permalink, $post, $leavename) {
    if (!is_wpml_active()) {
        return $permalink;
    }
    
    $post_types = array('experiences', 'shopping', 'events', 'vouchers');
    
    if (in_array($post->post_type, $post_types)) {
        $post_lang = apply_filters('wpml_element_language_code', null, array('element_id' => $post->ID, 'element_type' => 'post_' . $post->post_type));
        $current_lang = get_current_language();
        
        if ($post_lang && $post_lang !== $current_lang) {
            $default_lang = apply_filters('wpml_default_language', NULL);
            
            // Current base
            $current_base = home_url('/');
            
            // Root base (without language)
            $root = $current_base;
            if ($current_lang !== $default_lang) {
                $root = str_replace('/' . $current_lang . '/', '/', $current_base);
            }
            
            // Target base
            $target_base = $root;
            if ($post_lang !== $default_lang) {
                $target_base = $root . $post_lang . '/';
            }
            
            // Replace current base with target base in permalink
            if (strpos($permalink, $current_base) === 0) {
                $permalink = substr_replace($permalink, $target_base, 0, strlen($current_base));
            }
        }
    }
    
    return $permalink;
}
add_filter('post_link', 'wpml_fix_custom_permalink_structure', 10, 3);
add_filter('post_type_link', 'wpml_fix_custom_permalink_structure', 10, 3);

// Update menu walker for WPML
function update_menu_walker_for_wpml() {
    if (!is_wpml_active()) {
        return;
    }
    
    // This will be handled in the menu walker class
}

// ACF Field Translation Support
function acf_wpml_field_groups() {
    if (!is_wpml_active() || !function_exists('acf_add_local_field_group')) {
        return;
    }
    
    // Mark ACF field groups as translatable
    $field_groups = array(
        'select_banner',
        'class_body',
        'theme_options'
        // Add more field group keys as needed
    );
    
    foreach ($field_groups as $group) {
        do_action('wpml_register_field_group', $group);
    }
}
add_action('acf/init', 'acf_wpml_field_groups', 20);

// Ensure proper language detection
function wpml_language_detection() {
    if (!is_wpml_active()) {
        return;
    }
    
    // Force language detection on every page load
    do_action('wpml_switch_language');
}
add_action('wp', 'wpml_language_detection');