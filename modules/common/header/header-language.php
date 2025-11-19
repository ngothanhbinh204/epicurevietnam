<?php
/**
 * Header Language Switcher Component
 * Usage: get_template_part('modules/common/header-language');
 */

$show_language_switcher = get_field('show_language_switcher', 'options');
if ($show_language_switcher) :
    $current_lang = get_language_shortcode();
    $lang_flag = get_field('language_flag_' . $current_lang, 'options');
?>

<div class="main-language dropdown">
    <div class="dropdown-toggle">
        <?php if ($lang_flag) : ?>
            <img src="<?= get_image_attrachment($lang_flag, 'url') ?>" alt="<?= strtoupper($current_lang) ?>">
        <?php else : ?>
            <img src="<?= get_template_directory_uri() ?>/assets/img/en.png" alt="EN">
        <?php endif; ?>
    </div>
    <?php if (function_exists('icl_get_languages')) : ?>
        <div class="dropdown-menu">
            <?php 
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if ($languages) :
                foreach($languages as $lang) :
                    if (!$lang['active']) :
            ?>
                    <div class="item">
                        <a class="dropdown-item" href="<?= $lang['url'] ?>">
                            <?php 
                            $flag = get_field('language_flag_' . $lang['language_code'], 'options');
                            if ($flag) : ?>
                                <img src="<?= get_image_attrachment($flag, 'url') ?>" alt="<?= strtoupper($lang['language_code']) ?>">
                            <?php endif; ?>
                        </a>
                    </div>
            <?php 
                    endif;
                endforeach; 
            endif;
            ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>