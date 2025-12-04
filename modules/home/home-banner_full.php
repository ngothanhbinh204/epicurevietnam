<?php
$image = get_sub_field('image');
$link = get_sub_field('link');

if (!$image) return; // Exit if no content
?>

<section class="banner-full">
    <?php if ($link) : ?>
    <a href="<?= $link['url'] ?>">
        <?= get_image_attachment($image, 'image'); ?>
    </a>
    <?php else : ?>
    <?= get_image_attachment($image, 'image'); ?>
    <?php endif; ?>
</section>