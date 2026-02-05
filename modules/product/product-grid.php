<?php
/**
 * Product Grid Component
 * AJAX-enabled product grid
 */

// Get pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
if ($paged == 1 && isset($_GET['paged'])) {
    $paged = intval($_GET['paged']);
}
if ($paged == 1 && get_query_var('page')) {
    $paged = get_query_var('page');
}

// Build query args
$args = array(
    'post_type' => 'product',
    'posts_per_page' => 2,
    'paged' => $paged,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

// Apply category filter from URL
if (isset($_GET['product_category']) && !empty($_GET['product_category'])) {
    $args['tax_query'][] = array(
        'taxonomy' => 'product_category',
        'field' => 'slug',
        'terms' => sanitize_text_field($_GET['product_category'])
    );
}

// Create query
$product_query = new WP_Query($args);
?>

<div class="product-grid-wrap" id="product-grid-container">
    <!-- Loading overlay -->
    <div class="loading-overlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>

    <?php if ($product_query->have_posts()) : ?>
    <div class="product-grid" id="product-grid">
        <?php while ($product_query->have_posts()) : $product_query->the_post(); ?>
        <?php get_template_part('modules/product/product-item'); ?>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div class="product-pagination" id="product-pagination">
        <?php 
        if (function_exists('custom_pagination')) {
            $temp_query = $GLOBALS['wp_query'];
            $GLOBALS['wp_query'] = $product_query;
            custom_pagination(4);
            $GLOBALS['wp_query'] = $temp_query;
        }
        ?>
    </div>

    <!-- Hidden data for AJAX -->
    <input type="hidden" id="max-pages" value="<?= $product_query->max_num_pages ?>">
    <input type="hidden" id="current-page" value="<?= $paged ?>">

    <?php wp_reset_postdata(); ?>

    <?php else : ?>
    <div class="no-products" id="no-products">
        <p>Không tìm thấy sản phẩm nào.</p>
    </div>
    <?php endif; ?>
</div>