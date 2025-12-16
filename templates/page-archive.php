<?php
/**
 * Template Name: Archive Page Template
 */

get_header();

// Get current page ID
$page_id = get_the_ID();

// Get the post type from ACF field or custom field
// Assuming you will add an ACF field 'archive_post_type' to this page template
$post_type = get_field('archive_post_type', $page_id);

// If not set via ACF, try to guess or fallback (optional)
if (!$post_type) {
    // Fallback or error handling
    $post_type = 'post'; 
}

// Pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

// Query arguments
$args = array(
    'post_type' => $post_type,
    'post_status' => 'publish',
    'posts_per_page' => get_option('posts_per_page'), // Or custom number
    'paged' => $paged,
);

// Custom Query
$custom_query = new WP_Query($args);

// Pass variables to template parts
set_query_var('custom_query', $custom_query);
set_query_var('archive_post_type', $post_type);

?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<?php 
// Determine which content template to load based on post type
if ($post_type === 'video') {
    $section_class = 'om-video';
    $content_template = 'modules/archive/video-content';
} else {
    $section_class = 'om-whaton';
    $content_template = 'modules/archive/archive-content';
}
?>

<section class="<?= $section_class ?> main-section">
    <div class="container">
        <?php get_template_part('modules/archive/archive-nav'); ?>
        <?php get_template_part($content_template); ?>
    </div>
</section>

<?php 
// Reset Query
wp_reset_postdata();

get_footer(); 
?>