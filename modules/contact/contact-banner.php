<!-- <?php
$banner_image = get_sub_field('banner_image');
$title = get_sub_field('title');
?>
<section class="banner-child">
    <div class="container">
        <div class="image">
            <?php if (!empty($banner_image)): ?>
            <?= get_image_attrachment($banner_image) ?>
            <?php endif; ?>
            <?php if (!empty($title)): ?>
            <h2 class="title"><?= $title ?></h2>
            <?php endif; ?>
        </div>
    </div>
</section> -->