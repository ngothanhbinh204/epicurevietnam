<?php
/**
 * Header Language Switcher Component
 * Usage: get_template_part('modules/common/header/header-language');
 */

// Check if WPML is active
if (!function_exists('icl_get_languages') || !function_exists('icl_object_id')) {
    return;
}

// Get show language switcher option
// $show_language_switcher = get_field('show_language_switcher', 'options');
// if (!$show_language_switcher) {
//     return;
// }

// Get current language from WPML
$current_lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en';

// Get current language flag
$lang_flag = get_field('language_flag_' . $current_lang, 'options');

// Get active languages from WPML
$languages = apply_filters('wpml_active_languages', NULL, array(
    'orderby' => 'code',
    'order' => 'asc',
    'skip_missing' => 0
));

// if (empty($languages) || count($languages) < 2) {
//     return;
// }
?>

<div class="main-language dropdown">
    <div class="dropdown-toggle">
        <?php if ($lang_flag) : ?>
        <img src="<?= get_image_attachment($lang_flag, 'url') ?>" alt="<?= strtoupper($current_lang) ?>"
            class="flag-current">
        <?php else : ?>
        <img src="<?= get_template_directory_uri() ?>/assets/img/flags/<?= $current_lang ?>.svg"
            alt="<?= strtoupper($current_lang) ?>" class="flag-current">
        <?php endif; ?>
        <!-- <span class="lang-code"><?= strtoupper($current_lang) ?></span> -->
    </div>

    <div class="dropdown-menu">
        <?php foreach($languages as $lang) : 
            if (!$lang['active']) : // Only show non-active languages
                $flag = get_field('language_flag_' . $lang['language_code'], 'options');
        ?>
        <div class="item">
            <a class="dropdown-item" href="<?= esc_url($lang['url']) ?>"
                title="Switch to <?= esc_attr($lang['native_name']) ?>">
                <?php if ($flag) : ?>
                <img src="<?= get_image_attachment($flag, 'url') ?>" alt="<?= strtoupper($lang['language_code']) ?>"
                    class="flag-item">
                <?php else : ?>
                <img src="<?= get_template_directory_uri() ?>/assets/img/flags/<?= $lang['language_code'] ?>.svg"
                    alt="<?= strtoupper($lang['language_code']) ?>" class="flag-item">
                <?php endif; ?>
                <!-- <span class="lang-name"><?= esc_html($lang['native_name']) ?></span>
                <span class="lang-code">(<?= strtoupper($lang['language_code']) ?>)</span> -->
            </a>
        </div>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>
</div>

<!-- <style>
.main-language.dropdown {
    position: relative;
    display: inline-block;
}

.main-language .dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
}

.main-language .dropdown-toggle:hover {
    background: #f8f9fa;
    border-color: #007cba;
}

.main-language .flag-current,
.main-language .flag-item {
    width: 24px;
    height: 16px;
    object-fit: cover;
    border-radius: 2px;
}

.main-language .lang-code {
    font-size: 14px;
    font-weight: 500;
}

.main-language .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 100%;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    display: none;
}

.main-language.dropdown:hover .dropdown-menu {
    display: block;
}

.main-language .dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    color: #333;
    text-decoration: none;
    transition: background-color 0.2s;
    border: none;
    background: none;
}

.main-language .dropdown-item:hover {
    background: #f8f9fa;
    color: #007cba;
}

.main-language .lang-name {
    flex-grow: 1;
    font-size: 14px;
}

.main-language .dropdown-item .lang-code {
    font-size: 12px;
    color: #666;
}
</style> -->