<?php

/**
 * WordPress Bootstrap Pagination
 *
 * <?php echo wp_bootstrap_pagination(array('custom_query' => $the_query)) ?>
 *
 * Thêm tham số sau vào WP_Query
 * $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
 * 'paged' => $paged
 */

/**
 * Micco Custom Pagination
 * 
 * Replicating HTML structure of wp_bootstrap_pagination:
 * <div class="post-nav">
 *     <ul class="pager">
 *         <li class="previous hidden"><a href="...">First</a></li>
 *         <li class="hidden"><a href="...">Prev</a></li>
 *         <li class="active"><span class="active">01</span></li>
 *         <li><a href="...">02</a></li>
 *         <li class="hidden"><a href="...">Next</a></li>
 *     </ul>
 * </div>
 * 
 * Usage: <?php canhcam_pagination(); ?> or <?php canhcam_pagination($custom_query); ?>
 * 
 * @param WP_Query|null $custom_query Optional custom WP_Query object
 * @param array $args Optional arguments
 */
/**
 * Micco Custom Pagination
 * 
 * Output HTML structure:
 * <div class="modulepager">
 *     <ul class="pagination">
 *         <li><a href="#" class="PrevPage">‹</a></li>
 *         <li class="active"><span>1</span></li>
 *         <li><a href="#">2</a></li>
 *         <li><a href="#" class="NextPage">›</a></li>
 *         <li><a href="#" class="LastPage">»</a></li>
 *     </ul>
 * </div>
 * 
 * Usage: <?php canhcam_pagination(); ?> or <?php canhcam_pagination($custom_query); ?>
 * 
 * @param WP_Query|null $custom_query Optional custom WP_Query object
 * @param array $args Optional arguments
 */
function canhcam_pagination($custom_query = null, $args = array()) {
    // Default arguments
    $defaults = array(
        'range'           => 4,
        'custom_query'    => $custom_query,
        'prev_text'       => '‹',
        'next_text'       => '›',
        'last_text'       => '»',
        'first_text'      => '«',
    );
    
    $args = wp_parse_args($args, $defaults);
    
    // Get the query object
    if (!$args['custom_query']) {
         $args['custom_query'] = @$GLOBALS['wp_query'];
    }
    
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = max(1, get_query_var('paged'));
    $range = (int) $args['range'];
    
    if ($count <= 1) return;
    
    $start_page = max(1, $page - floor($range / 2));
    $end_page   = min($count, $start_page + $range - 1);

    if ($end_page - $start_page < $range - 1) {
        $start_page = max(1, $end_page - $range + 1);
    }
    
    echo '<div class="modulepager"><ul class="pagination">';
    
    // First Page
    if ($start_page > 1) {
        // Optional: User didn't request First Page explicitly in the snippet but it's good practice or we can omit.
        // The requested snippet had LastPage. I will include FirstPage for symmetry if start > 1.
        // Actually user snippet: <div class="modulepager"><ul class="pagination"><li class="active"><span>1</span>...
        // It didn't show FirstPage because it was on page 1.
        // I will add FirstPage if start_page > 1 for better UX.
        echo '<li><a href="' . get_pagenum_link(1) . '" class="FirstPage">' . $args['first_text'] . '</a></li>';
    }

    // Previous
    if ($page > 1) {
        echo '<li><a href="' . get_pagenum_link($page - 1) . '" class="PrevPage">' . $args['prev_text'] . '</a></li>';
    }

    // Loop
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $page) {
            echo '<li class="active"><span>' . $i . '</span></li>';
        } else {
            echo '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
        }
    }

    // Next
    if ($page < $count) {
        echo '<li><a href="' . get_pagenum_link($page + 1) . '" class="NextPage">' . $args['next_text'] . '</a></li>';
    }

    // Last Page
    // The user's snippet shows LastPage explicitly.
    if ($page < $count) {
        echo '<li><a href="' . get_pagenum_link($count) . '" class="LastPage">' . $args['last_text'] . '</a></li>';
    }

    echo '</ul></div>';
}

/**
 * Simple Micco Pagination (no prev/next, no dots)
 * 
 * Output exactly like the HTML structure provided:
 * <div class="pagination flex-center">
 *     <ul>
 *         <li><a href="#">1</a></li>
 *         <li><a href="#">2</a></li>
 *     </ul>
 * </div>
 * 
 * @param WP_Query|null $custom_query Optional custom WP_Query object
 */
function canhcam_pagination_simple($custom_query = null) {
    if ($custom_query === null) {
        global $wp_query;
        $custom_query = $wp_query;
    }
    $total_pages = (int) $custom_query->max_num_pages;
    if ($total_pages <= 1) {
        return;
    }
    $current_page = max(1, get_query_var('paged'));
    $output = '<div class="pagination flex-center mt-base">';
    $output .= '<ul>';
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            $output .= '<li class="active"><span>' . $i . '</span></li>';
        } else {
            $output .= '<li><a href="' . esc_url(get_pagenum_link($i)) . '">' . $i . '</a></li>';
        }
    }
    
    $output .= '</ul>';
    $output .= '</div>';
    
    echo $output;
}
