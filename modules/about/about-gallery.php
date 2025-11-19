<?php
$gallery_images = get_sub_field('gallery_images');
?>
<section class="om-about-5 main-section">
    <?php if (!empty($gallery_images)): ?>
    <div class="row">
        <?php foreach ($gallery_images as $item): ?>
        <div class="col-md-6">
            <?php if (!empty($item['image'])): ?>
            <?= get_image_attrachment($item['image']) ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>