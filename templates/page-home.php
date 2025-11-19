<?php /*
Template name: Page - Home
*/ ?>
<?= get_header() ?>
<h1 class="hidden">
    <?php echo get_bloginfo('name') ?>
</h1>
<?php get_template_part('modules/common/banner')?>
<section class="main-wrapper home-news">
    <div class="container">
        <?php
    if (have_rows('home_sections')) :
        while (have_rows('home_sections')) : the_row();
            $layout = get_row_layout();
            get_template_part('modules/home/home-' . $layout);
        endwhile;
    endif;
    ?>
    </div>
</section>
<?= get_footer() ?>