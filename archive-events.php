<?php
/**
 * Archive template for Events
 */
get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-whaton main-section">
    <div class="container">
        <?php get_template_part('modules/archive/archive-nav'); ?>
        <?php get_template_part('modules/archive/archive-content'); ?>
    </div>
</section>

<?php get_footer(); ?>