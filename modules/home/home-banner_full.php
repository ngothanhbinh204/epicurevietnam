<?php
$image = get_sub_field('image');
$link = get_sub_field('link');

if (!$image) return; // Exit if no content
?>

<section class="banner-full">
    <?php if ($link) : ?>
    <a href="<?= $link['url'] ?>">
        <img class="lazyload" data-src="<?= get_image_attrachment($image, 'url') ?>" alt="">
    </a>
    <?php else : ?>
    <img class="lazyload" data-src="<?= get_image_attrachment($image, 'url') ?>" alt="">
    <?php endif; ?>
</section>