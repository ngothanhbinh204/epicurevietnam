<?php
/**
 * Single template for Video posts
 */
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-video-detail main-section">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post();
                get_template_part('modules/single/video-detail-content');
            endwhile;
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
