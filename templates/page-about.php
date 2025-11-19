<?php /*
Template name: Page - About
*/ ?>
<?= get_header() ?>
<h1 class="hidden">
    <?php echo get_bloginfo('name') ?>
</h1>

<?php get_template_part('modules/common/banner')?>
<?php get_template_part('modules/about/about-nav')?>

<section class="om-about">
    <div class="container">
        <?php
        if (have_rows('about_sections')) :
            while (have_rows('about_sections')) : the_row();
                $layout = get_row_layout();
                get_template_part('modules/about/about-' . $layout);
            endwhile;
        endif;
        ?>
    </div>
</section>
<?= get_footer() ?>