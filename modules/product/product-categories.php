<?php
/**
 * Product Categories Navigation Component
 * Hiển thị danh mục sản phẩm dạng icon + tên
 */

// Get all product categories
$categories = get_terms(array(
    'taxonomy' => 'product_category',
    'hide_empty' => false,
    'parent' => 0, // Only top-level categories
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

// Get current category from URL
$current_category = isset($_GET['product_category']) ? sanitize_text_field($_GET['product_category']) : '';

if (!empty($categories) && !is_wp_error($categories)) :
?>
<div class="product-categories-nav">
    <button class="cat-nav-arrow cat-nav-prev" aria-label="Previous">
        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
    <div class="categories-list-wrapper">
        <div class="categories-list">
            <?php foreach ($categories as $category) : 
                $category_icon = get_field('category_icon', 'product_category_' . $category->term_id);
                $is_active = ($current_category === $category->slug) ? 'active' : '';
                $category_link = add_query_arg('product_category', $category->slug, get_permalink());
            ?>
            <a href="<?= esc_url($category_link) ?>" class="category-item <?= $is_active ?>">
                <div class="category-icon">
                    <?php if ($category_icon) : ?>
                    <?= get_image_attachment($category_icon) ?>
                    <?php else : ?>
                    <img src="<?= get_template_directory_uri() ?>/img/placeholder-icon.svg"
                        alt="<?= esc_attr($category->name) ?>">
                    <?php endif; ?>
                </div>
                <span class="category-name"><?= esc_html($category->name) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <button class="cat-nav-arrow cat-nav-next" aria-label="Next">
        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
</div>
<?php endif; ?>