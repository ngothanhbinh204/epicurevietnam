<?php
$queried_object = get_queried_object();
$title = '';

// Get title based on current view
if (is_tax() || is_category()) {
    $title = single_term_title('', false);
} elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
} else {
    $title = get_the_archive_title();
}
?>

<h1 class="main-title dotted"><?= esc_html($title) ?></h1>

<div class="row box-whaton-top">
    <?php 
    $count = 0;
    if (have_posts()) :
        while (have_posts() && $count < 6) : the_post();
            $count++;
            $item_class = ($count <= 2) ? 'news-item-top' : 'news-item-bottom';
            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
    ?>
    <div class="col-md-6">
        <div class="news-item <?= $item_class ?>">
            <?php if ($thumbnail): ?>
            <div class="image">
                <a href="<?= get_permalink() ?>">
                    <?php echo get_image_post(get_the_ID()); ?>
                </a>
            </div>
            <?php endif; ?>
            <div class="caption">
                <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                <?php if (has_excerpt()): ?>
                <div class="des">
                    <?= get_the_excerpt() ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php 
        endwhile;
    endif;
    wp_reset_postdata();
    ?>
</div>

<?php
// Get banner ads for middle section based on post type
$post_type = get_post_type();
$banner_field_name = $post_type . '_middle_banner';
$banner_ads = get_field($banner_field_name, 'option');

if (!empty($banner_ads)) :
    foreach ($banner_ads as $banner) :
        if (!empty($banner['banner_image']) && !empty($banner['banner_link'])) :
?>
<div class="banner-full">
    <a href="<?= esc_url($banner['banner_link']) ?>">
        <?= get_image_attrachment($banner['banner_image']) ?>
    </a>
</div>
<?php
        endif;
    endforeach;
endif;
?>

<div class="row box-whaton-bottom">
    <div class="col-lg-8 col-xl-9">
        <div class="whaton-list">
            <?php
            // Rewind query to show remaining posts
            rewind_posts();
            $count = 0;
            
            if (have_posts()) :
                while (have_posts()) : the_post();
                    $count++;
                    // Skip first 6 posts (already shown above)
                    if ($count <= 6) continue;
                    
                    $thumbnail = get_the_post_thumbnail(get_the_ID(), 'full');
            ?>
            <div class="news-item">
                <?php if ($thumbnail): ?>
                <div class="image">
                    <a href="<?= get_permalink() ?>">
                        <?php echo get_image_post(get_the_ID()); ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="caption">
                    <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                    <?php if (has_excerpt()): ?>
                    <div class="des">
                        <?= get_the_excerpt() ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                endwhile;
            endif;
            ?>
        </div>


    </div>

    <div class="col-lg-4 col-xl-3">
        <?php
        // Get sidebar banner ads based on post type
        $post_type = get_post_type();
        $sidebar_field_name = $post_type . '_sidebar_banners';
        $sidebar_banners = get_field($sidebar_field_name, 'option');
        
        if (!empty($sidebar_banners)) :
        ?>
        <div class="banner-qc-list">
            <?php foreach ($sidebar_banners as $banner) :

        // Lấy dữ liệu
        $image = !empty($banner['banner_image']) ? $banner['banner_image'] : null;
        $link  = !empty($banner['banner_link'])  ? $banner['banner_link']  : null;

        if (!$image) {
            continue;
        }
    ?>
            <div class="banner-item">
                <?php if ($link) : ?>
                <a href="<?= esc_url($link) ?>">
                    <?= get_image_attrachment($image) ?>
                </a>
                <?php else : ?>
                <?= get_image_attrachment($image) ?>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>

    <?php
        // Pagination
        if (function_exists('custom_pagination')) {
            custom_pagination();
        }
        ?>
</div>