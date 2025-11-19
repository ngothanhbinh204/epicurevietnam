<?php
/**
 * Header Navigation Component
 * Usage: get_template_part('modules/common/header-navigation');
 */
?>

<div class="main-menu">
    <?php if (has_nav_menu('header-menu')) : ?>
    <ul class="menu-list">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'header-menu',
                'container' => false,
                'items_wrap' => '%3$s',
                'walker' => new Custom_Menu_Walker(),
                'depth' => 0
            ));
            ?>
    </ul>
    <?php endif; ?>
</div>