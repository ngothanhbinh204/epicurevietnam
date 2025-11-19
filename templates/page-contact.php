<?php /*
Template name: Page - Contact
*/ ?>
<?= get_header() ?>
<h1 class="hidden">
    <?php echo get_bloginfo('name') ?>
</h1>

<?php get_template_part('modules/common/banner')?>

<section class="om-contact main-section">
    <div class="container">
        <?php
        if (have_rows('contact_sections')) :
            while (have_rows('contact_sections')) : the_row();
                $layout = get_row_layout();
                get_template_part('modules/contact/contact-' . $layout);
            endwhile;
        endif;
        ?>
    </div>
</section>
<?= get_footer() ?>