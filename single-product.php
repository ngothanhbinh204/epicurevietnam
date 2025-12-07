<?php
/**
 * Single Product Template (Dự phòng)
 * Template này đã được chuẩn bị sẵn để sử dụng khi cần kích hoạt trang chi tiết sản phẩm
 * 
 * Để kích hoạt:
 * 1. Uncomment code bên dưới
 * 2. Hoặc tạo file mới với tên single-product.php ở thư mục gốc theme
 */

get_header();

$product_id = get_the_ID();
$product_price = get_field('product_price', $product_id);
$product_old_price = get_field('product_old_price', $product_id);
$product_sku = get_field('product_sku', $product_id);
$product_gallery = get_field('product_gallery', $product_id);
$product_is_new = get_field('product_is_new', $product_id);
$product_is_featured = get_field('product_is_featured', $product_id);

// Get product categories
$categories = get_the_terms($product_id, 'product_category');

// Format price function
if (!function_exists('format_price_vnd')) {
    function format_price_vnd($price) {
        if (empty($price)) return '';
        return number_format($price, 0, ',', '.') . 'đ';
    }
}
?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php // Breadcrumb ?>
<?php get_template_part('modules/common/breadcrumb'); ?>

<section class="product-detail-page main-section">
    <div class="container">
        <div class="product-detail-wrap">
            <div class="row">
                <?php // Product Gallery ?>
                <div class="col-lg-6">
                    <div class="product-gallery">
                        <?php // Main Image ?>
                        <div class="main-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?= get_the_post_thumbnail_url($product_id, 'full') ?>" data-fancybox="product-gallery">
                                    <?= get_image_post($product_id) ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        
                        <?php // Thumbnail Gallery ?>
                        <?php if (!empty($product_gallery)) : ?>
                        <div class="gallery-thumbs">
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="thumb-item active">
                                <?= get_image_post($product_id, 'thumbnail') ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php foreach ($product_gallery as $image_id) : ?>
                            <div class="thumb-item">
                                <a href="<?= wp_get_attachment_image_url($image_id, 'full') ?>" data-fancybox="product-gallery">
                                    <?= get_image_attachment($image_id, 'thumbnail') ?>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php // Product Info ?>
                <div class="col-lg-6">
                    <div class="product-detail-info">
                        <?php // Badges ?>
                        <?php if ($product_is_new || $product_is_featured) : ?>
                        <div class="product-badges">
                            <?php if ($product_is_new) : ?>
                            <span class="badge badge-new">New</span>
                            <?php endif; ?>
                            <?php if ($product_is_featured) : ?>
                            <span class="badge badge-featured">Featured</span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php // Title ?>
                        <h1 class="product-title"><?= get_the_title() ?></h1>
                        
                        <?php // SKU ?>
                        <?php if ($product_sku) : ?>
                        <p class="product-sku">SKU: <?= esc_html($product_sku) ?></p>
                        <?php endif; ?>
                        
                        <?php // Price ?>
                        <div class="product-price-wrap">
                            <?php if ($product_price) : ?>
                            <span class="product-price"><?= format_price_vnd($product_price) ?></span>
                            <?php endif; ?>
                            
                            <?php if ($product_old_price && $product_old_price > $product_price) : 
                                $discount = round(($product_old_price - $product_price) / $product_old_price * 100);
                            ?>
                            <span class="product-old-price"><?= format_price_vnd($product_old_price) ?></span>
                            <span class="product-discount">-<?= $discount ?>%</span>
                            <?php endif; ?>
                        </div>
                        
                        <?php // Categories ?>
                        <?php if ($categories && !is_wp_error($categories)) : ?>
                        <div class="product-categories">
                            <span>Danh mục:</span>
                            <?php foreach ($categories as $index => $cat) : ?>
                                <a href="<?= get_term_link($cat) ?>"><?= esc_html($cat->name) ?></a><?= ($index < count($categories) - 1) ? ', ' : '' ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php // Excerpt ?>
                        <?php if (has_excerpt()) : ?>
                        <div class="product-excerpt">
                            <?= get_the_excerpt() ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php // Contact/Inquiry Button ?>
                        <div class="product-actions">
                            <a href="<?= home_url('/contact') ?>" class="btn btn-primary">Liên hệ tư vấn</a>
                        </div>
                        
                        <?php // Share ?>
                        <div class="product-share">
                            <span>Chia sẻ:</span>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(get_permalink()) ?>" target="_blank" class="share-facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode(get_permalink()) ?>&text=<?= urlencode(get_the_title()) ?>" target="_blank" class="share-twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode(get_permalink()) ?>&media=<?= urlencode(get_the_post_thumbnail_url()) ?>&description=<?= urlencode(get_the_title()) ?>" target="_blank" class="share-pinterest">
                                    <i class="fab fa-pinterest"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php // Product Description ?>
        <?php if (get_the_content()) : ?>
        <div class="product-description">
            <h2>Mô tả sản phẩm</h2>
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
        <?php endif; ?>
        
        <?php // Related Products ?>
        <?php
        $related_args = array(
            'post_type' => 'product',
            'posts_per_page' => 4,
            'post__not_in' => array($product_id),
            'orderby' => 'rand'
        );
        
        // Get products from same category
        if ($categories && !is_wp_error($categories)) {
            $category_ids = wp_list_pluck($categories, 'term_id');
            $related_args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_category',
                    'field' => 'term_id',
                    'terms' => $category_ids
                )
            );
        }
        
        $related_query = new WP_Query($related_args);
        
        if ($related_query->have_posts()) :
        ?>
        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <div class="product-grid">
                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                    <?php get_template_part('modules/product/product-item'); ?>
                <?php endwhile; ?>
            </div>
        </div>
        <?php 
        wp_reset_postdata();
        endif;
        ?>
    </div>
</section>

<?php get_footer(); ?>
