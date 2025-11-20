<?php
/**
 * Header Language Switcher Component
 * Usage: get_template_part('modules/common/header/header-language');
 */

// Check if WPML is active
if (!function_exists('icl_get_languages') || !function_exists('icl_object_id')) {
    return;
}
$current_lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en';
$lang_flag = get_field('language_flag_' . $current_lang, 'options');
$languages = apply_filters('wpml_active_languages', NULL, array(
    'orderby' => 'code',
    'order' => 'asc',
    'skip_missing' => 1 // only get languages with translations
));

$has_multiple_languages = count($languages) > 1;


if (!$has_multiple_languages) {
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
    </div>
</div>
<?php
    return;
}

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
    </div>

    <div class="dropdown-menu">
        <?php foreach($languages as $lang) : 
            if (!$lang['active']) : 
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
            </a>
        </div>
        <?php 
            endif;
        endforeach; 
        ?>
    </div>
</div>