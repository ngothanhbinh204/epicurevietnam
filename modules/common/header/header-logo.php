<?php
/**
 * Header Logo Component
 * Usage: get_template_part('modules/common/header-logo', '', array('type' => 'top' | 'main'));
 */

$type = isset($args['type']) ? $args['type'] : 'main';

if ($type === 'top') :
    $logo = get_field('header_top_logo', 'options');
    $default_logo = get_template_directory_uri() . '/assets/img/logo.png';
else :
    $logo = get_field('header_main_logo', 'options');
    $default_logo = get_template_directory_uri() . '/assets/img/logo-w.png';
endif;
?>

<div class="logo">
    <a href="<?= home_url() ?>">
        <?php if ($logo) : ?>
            <img src="<?= get_image_attrachment($logo, 'url') ?>" alt="<?= get_bloginfo('name') ?>">
        <?php else : ?>
            <img src="<?= $default_logo ?>" alt="<?= get_bloginfo('name') ?>">
        <?php endif; ?>
    </a>
</div>