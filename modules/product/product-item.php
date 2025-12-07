<?php
/**
 * Product Item Component
 * Card hiển thị thông tin sản phẩm
 */

$product_id = get_the_ID();
$product_price = get_field('product_price', $product_id);
$product_old_price = get_field('product_old_price', $product_id);
$product_sku = get_field('product_sku', $product_id);
$product_is_new = get_field('product_is_new', $product_id);
$product_is_featured = get_field('product_is_featured', $product_id);

// Format price function (check if not already declared)
if (!function_exists('format_price_vnd')) {
    function format_price_vnd($price) {
        if (empty($price)) return '';
        return number_format($price, 0, ',', '.') . 'đ';
    }
}
?>

<div class="product-item">
    <?php // Badges ?>
    <!-- <?php if ($product_is_new || $product_is_featured) : ?>
    <div class="product-badges">
        <?php if ($product_is_new) : ?>
        <span class="badge badge-new">New</span>
        <?php endif; ?>
        <?php if ($product_is_featured) : ?>
        <span class="badge badge-featured">Featured</span>
        <?php endif; ?>
    </div>
    <?php endif; ?> -->

    <?php // Product Image ?>
    <div class="product-image">
        <a>
            <?php if (has_post_thumbnail()) : ?>
            <?= get_image_post($product_id) ?>
            <?php else : ?>
            <img src="<?= get_template_directory_uri() ?>/img/placeholder-product.jpg" alt="<?= get_the_title() ?>">
            <?php endif; ?>
        </a>
    </div>

    <?php // Product Info ?>
    <div class="product-info">
        <h3 class="product-title">
            <a><?= get_the_title() ?></a>
        </h3>
        <div class="product-price-wrap">
            <?php if ($product_price) : ?>
            <span class="product-price"><?= format_price_vnd($product_price) ?></span>
            <?php endif; ?>

            <?php if ($product_old_price && $product_old_price > $product_price) : ?>
            <span class="product-old-price"><?= format_price_vnd($product_old_price) ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>