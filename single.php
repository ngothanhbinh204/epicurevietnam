<?php
/**
 * Single template
 */
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/breadcrumb'); ?>

<section class="om-events-detail main-section">
    <div class="container">
        <div class="row">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    get_template_part('modules/single/post-detail-content');
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>