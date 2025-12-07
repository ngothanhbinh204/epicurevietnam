<?php
/**
 * Product Filter & Sort Component
 * AJAX-based filtering - No page reload
 */

// Get all parent attributes (top-level terms) for filter dropdowns
$attribute_parents = get_terms(array(
    'taxonomy' => 'product_attribute',
    'hide_empty' => false,
    'parent' => 0,
    'orderby' => 'menu_order',
    'order' => 'ASC'
));

// Get current category from URL
$current_category = isset($_GET['product_category']) ? sanitize_text_field($_GET['product_category']) : '';
?>

<div class="product-filter-wrap" id="product-filters">
    <div class="filter-left">
        <span class="filter-label"><?php _e('Filter:', 'canhcamtheme') ?></span>

        <div class="wrapper-filter">
            <?php if (!empty($attribute_parents) && !is_wp_error($attribute_parents)) : ?>
            <?php foreach ($attribute_parents as $parent_attr) : 
                $child_terms = get_terms(array(
                    'taxonomy' => 'product_attribute',
                    'hide_empty' => true,
                    'parent' => $parent_attr->term_id,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));
                
                if (empty($child_terms) || is_wp_error($child_terms)) continue;
            ?>
            <div class="custom-dropdown" data-name="attr_<?= esc_attr($parent_attr->slug) ?>"
                data-default-text="<?= esc_attr($parent_attr->name) ?>">
                <div class="dropdown-toggle">
                    <span class="selected-text"><?= esc_html($parent_attr->name) ?></span>
                    <button type="button" class="clear-filter-btn" title="Xóa bộ lọc">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 1L1 9M1 1L9 9" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                    </button>
                    <span class="chevron-icon">
                        <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.140625 0.1875C0.210938 0.09375 0.304688 0.046875 0.421875 0.046875C0.492188 0.046875 0.585938 0.0703125 0.65625 0.140625L5.27344 4.38281L9.91406 0.140625C10.0547 0 10.2891 0 10.4297 0.164062C10.5703 0.304688 10.5703 0.539062 10.4062 0.679688L5.53125 5.17969C5.39062 5.32031 5.17969 5.32031 5.03906 5.17969L0.164062 0.679688C0 0.5625 0 0.328125 0.140625 0.1875Z"
                                fill="#3D3D3D" />
                        </svg>
                    </span>
                </div>
                <div class="dropdown-menu">
                    <?php foreach ($child_terms as $child) : ?>
                    <div class="dropdown-item" data-value="<?= esc_attr($child->term_id) ?>">
                        <?= esc_html($child->name) ?></div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="attr_<?= esc_attr($parent_attr->slug) ?>" class="filter-input ajax-filter"
                    value="">
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="filter-right">
        <span class="sort-label">
            <?php _e('Sort by:', 'canhcamtheme') ?>
        </span>
        <div class="custom-dropdown sort-dropdown" data-name="orderby">
            <div class="dropdown-toggle">
                <span class="selected-text">
                    <?php echo __('Latest products', 'canhcamtheme') ?>
                </span>
                <span class="chevron-icon">
                    <svg width="11" height="6" viewBox="0 0 11 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M0.140625 0.1875C0.210938 0.09375 0.304688 0.046875 0.421875 0.046875C0.492188 0.046875 0.585938 0.0703125 0.65625 0.140625L5.27344 4.38281L9.91406 0.140625C10.0547 0 10.2891 0 10.4297 0.164062C10.5703 0.304688 10.5703 0.539062 10.4062 0.679688L5.53125 5.17969C5.39062 5.32031 5.17969 5.32031 5.03906 5.17969L0.164062 0.679688C0 0.5625 0 0.328125 0.140625 0.1875Z"
                            fill="#3D3D3D" />
                    </svg>
                </span>
            </div>
            <div class="dropdown-menu">
                <div class="dropdown-item" data-value="date"><?php echo __('Latest products', 'canhcamtheme') ?></div>
                <div class="dropdown-item" data-value="price_asc"><?php echo __('Price: Low to High', 'canhcamtheme') ?>
                </div>
                <div class="dropdown-item" data-value="price_desc">
                    <?php echo __('Price: High to Low', 'canhcamtheme') ?>
                </div>
                <div class="dropdown-item" data-value="title"><?php echo __('Best-selling products', 'canhcamtheme') ?>
                </div>
            </div>
            <input type="hidden" name="orderby" class="sort-input ajax-filter" value="date">
        </div>
    </div>

    <!-- Hidden field for category -->
    <input type="hidden" id="current-category" value="<?= esc_attr($current_category) ?>">
</div>