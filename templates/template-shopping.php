<?php
/*
Template Name: Shopping Page
*/
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-whaton main-section">
    <div class="container">
        <?php
        $post_type = 'shopping';
        set_query_var('archive_post_type', $post_type);
        get_template_part('modules/archive/archive-nav');
        ?>

        <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type'      => $post_type,
            'posts_per_page' => 12,
            'paged'          => $paged,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC'
        );
        $query = new WP_Query($args);
        set_query_var('custom_query', $query);
        ?>
        <?php get_template_part('modules/archive/default-content'); ?>
    </div>
</section>

<?php get_footer(); ?>
