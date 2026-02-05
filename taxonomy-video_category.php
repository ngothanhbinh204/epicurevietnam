<?php
/**
 * Taxonomy Template: Video Category
 */
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-video main-section">
    <div class="container">
        <?php 
        // Force 'video' post type for nav
        set_query_var('archive_post_type', 'video');
        get_template_part('modules/archive/archive-nav'); 
        
        // Use global query for taxonomy
        set_query_var('custom_query', $GLOBALS['wp_query']);
        ?>
        <?php get_template_part('modules/archive/video-content'); ?>
    </div>
</section>

<?php get_footer(); ?>
