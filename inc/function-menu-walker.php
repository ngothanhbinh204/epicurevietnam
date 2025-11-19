<?php
/**
 * Custom Menu Walker for multilevel menus
 */
class Custom_Menu_Walker extends Walker_Nav_Menu {
    
    // Start Level - when to start outputting markup
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    // End Level - when to end outputting markup  
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    // Start Element - output the <li> and <a> tag
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Check if item has children
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-dropdown';
        }
        
        // Add custom active state logic
        $is_current = $this->is_current_menu_item($item);
        if ($is_current) {
            $classes[] = 'active';
            $classes[] = 'current-menu-item';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    // Custom function to determine if menu item is current
    private function is_current_menu_item($item) {
        $current_url = home_url($_SERVER['REQUEST_URI']);
        $item_url = $item->url;
        
        // Exact match
        if ($current_url === $item_url) {
            return true;
        }
        
        // Check for custom post type archives
        if (is_post_type_archive()) {
            $post_type = get_post_type();
            $archive_link = get_post_type_archive_link($post_type);
            if ($item_url === $archive_link) {
                return true;
            }
        }
        
        // Check for single posts of custom post types
        if (is_single()) {
            $post_type = get_post_type();
            $archive_link = get_post_type_archive_link($post_type);
            if ($item_url === $archive_link) {
                return true;
            }
        }
        
        // Check for taxonomy pages
        if (is_tax()) {
            $queried_object = get_queried_object();
            if ($queried_object) {
                // Get the post type associated with this taxonomy
                $taxonomy = get_taxonomy($queried_object->taxonomy);
                if ($taxonomy && !empty($taxonomy->object_type)) {
                    $post_type = $taxonomy->object_type[0];
                    $archive_link = get_post_type_archive_link($post_type);
                    if ($item_url === $archive_link) {
                        return true;
                    }
                }
            }
        }
        
        // Check if current URL starts with menu item URL (for hierarchical matches)
        if (strpos($current_url, rtrim($item_url, '/')) === 0 && $item_url !== home_url('/')) {
            return true;
        }
        
        return false;
    }

    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}



?>