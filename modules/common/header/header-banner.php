<?php
/**
 * Header Top Banner Component
 * Usage: get_template_part('modules/common/header-banner');
 */

$header_banner_image = get_field('header_banner_image', 'options');
$header_banner_link = get_field('header_banner_link', 'options');

if ($header_banner_image) :
?>
<div class="image">
    <a href="<?= $header_banner_link['url'] ?? '#' ?>" <?= $header_banner_link['target'] ? 'target="_blank"' : '' ?>>
        <?= get_image_attrachment($header_banner_image, 'image') ?>
    </a>
</div>
<?php endif; ?>