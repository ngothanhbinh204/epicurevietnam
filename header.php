<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap"
        rel="stylesheet">
    <?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
    <?php endif; ?>
    <?php wp_head(); ?>
    <?= get_field('field_config_head', 'options') ?>
</head>

<body <?php body_class(get_field('add_class_body', get_the_ID())) ?>>
    <header>
        <div class="top-wrap">
            <div class="container">
                <div class="main-wrap">
                    <div class="left-wrap">
                        <?php get_template_part('modules/common/header/header-logo', '', array('type' => 'top')); ?>
                    </div>
                    <div class="right-wrap">
                        <?php get_template_part('modules/common/header/header-banner'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-wrap">
            <div class="container">
                <div class="main-wrap">
                    <div class="left-wrap">
                        <?php get_template_part('modules/common/header/header-logo', '', array('type' => 'main')); ?>
                        <?php get_template_part('modules/common/header/header-navigation'); ?>
                    </div>
                    <div class="right-wrap">
                        <?php get_template_part('modules/common/header/header-search'); ?>
                        <?php get_template_part('modules/common/header/header-language'); ?>
                        <?php get_template_part('modules/common/header/header-mobile'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-wrap"></div>
        <?php get_template_part('modules/common/header/header-searchbox'); ?>
    </header>
    <div class="backdrop"></div>
    <div class="backdrop"></div>
    <main>