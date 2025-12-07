<?php
/*
Template Name: Product Page
*/

get_header();
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="product-page main-section">
    <div class="container">
        <?php // Product Categories Navigation ?>
        <?php get_template_part('modules/product/product-categories'); ?>
        
        <?php // Filter & Sort ?>
        <?php get_template_part('modules/product/product-filter'); ?>
        
        <?php // Product Grid ?>
        <?php get_template_part('modules/product/product-grid'); ?>
    </div>
</section>

<?php get_footer(); ?>