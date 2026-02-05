<?php
/*
Template Name: Video Page
*/
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-video main-section">
    <div class="container">
        <?php 
        set_query_var('archive_post_type', 'video');
        get_template_part('modules/archive/archive-nav'); 
        
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => 'video',
            'posts_per_page' => 12,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC'
        );
        $query = new WP_Query($args);
        set_query_var('custom_query', $query);
        ?>
        <?php get_template_part('modules/archive/video-content'); ?>
    </div>
</section>

<?php get_footer(); ?>