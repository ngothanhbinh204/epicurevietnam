<?php
/**
 * Taxonomy Template: Default (Shopping, Experiences, Events, etc.)
 */
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-whaton main-section">
    <div class="container">
        <?php
        // Detect post type from the current taxonomy term
        $term = get_queried_object();
        $taxonomy = get_taxonomy($term->taxonomy);
        $post_type = isset($taxonomy->object_type[0]) ? $taxonomy->object_type[0] : 'post';
        
        set_query_var('archive_post_type', $post_type);
        get_template_part('modules/archive/archive-nav'); 
        ?>

        <?php 
        // For taxonomy pages, the main query is already correct, so we don't need a custom query
        // But the module expects 'custom_query' var if not using global
        // We can just set custom_query to global wp_query to be explicit or leave it null (module handles fallback)
        set_query_var('custom_query', $GLOBALS['wp_query']);
        
        get_template_part('modules/archive/default-content'); 
        ?>
    </div>
</section>

<?php get_footer(); ?>
