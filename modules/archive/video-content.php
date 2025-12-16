<?php
/**
 * Video Archive Layout
 */

$custom_query = get_query_var('custom_query');
$query = $custom_query ? $custom_query : $GLOBALS['wp_query'];

/* ---------------------------
 * Title
 * --------------------------- */
$title = '';

if (is_tax() || is_category()) {
    $title = single_term_title('', false);
} elseif (is_post_type_archive()) {
    $title = post_type_archive_title('', false);
} elseif ($custom_query) {
    $title = get_the_title();
} else {
    $title = get_the_archive_title();
}
?>

<h1 class="main-title dotted"><?= esc_html($title) ?></h1>

<?php
/* ---------------------------
 * Collect first 5 posts
 * --------------------------- */
$main_post  = null;
$side_posts = [];
$count      = 0;

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        $count++;
        if ($count === 1) {
            $main_post = get_post();
        } elseif ($count <= 5) {
            $side_posts[] = get_post();
        } else {
            break;
        }
    endwhile;
endif;

// Don't reset postdata yet if we are using custom query and want to continue loop?
// Actually the original code did wp_reset_postdata();
// But here we are just collecting posts.
// If we use custom query, we should probably not reset if we want to continue?
// But the original code breaks the loop.
// And then later it does NOT rewind. It continues?
// Wait, let's check the original code again.
wp_reset_postdata();
?>

<div class="news-video">
    <div class="news-body">
        <div class="row">

            <?php if ($main_post) : ?>
            <!-- LEFT -->
            <div class="col-lg-3">
                <div class="news-item news-item-video news-item-video-big">
                    <div class="caption">
                        <a class="title" href="<?= esc_url(get_permalink($main_post->ID)) ?>">
                            <?= esc_html(get_the_title($main_post->ID)) ?>
                        </a>
                        <?php if (has_excerpt($main_post->ID)) : ?>
                        <div class="des">
                            <p><?= esc_html(get_the_excerpt($main_post->ID)) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- CENTER -->
            <div class="col-lg-6">
                <div class="news-item news-item-video news-item-video-big">
                    <div class="image">
                        <a href="<?= esc_url(get_permalink($main_post->ID)) ?>">
                            <?= get_image_post($main_post->ID); ?>
                        </a>
                        <div class="icon-play">
                            <em class="mdi mdi-play-circle"></em>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- RIGHT -->
            <div class="col-lg-3">
                <div class="news-list row">
                    <?php if (!empty($side_posts)) : ?>
                    <?php foreach ($side_posts as $side_post) : ?>
                    <div class="col-md-6 col-lg-12 news-item news-item-child news-item-video">
                        <div class="image">
                            <a href="<?= esc_url(get_permalink($side_post->ID)) ?>">
                                <?= get_image_post($side_post->ID); ?>
                            </a>
                            <div class="icon-play">
                                <em class="mdi mdi-play-circle"></em>
                            </div>
                        </div>
                        <div class="caption">
                            <a class="title" href="<?= esc_url(get_permalink($side_post->ID)) ?>">
                                <?= esc_html(get_the_title($side_post->ID)) ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
/* ---------------------------
 * Middle Banner
 * --------------------------- */
$banner_ads = get_field('video_middle_banner', 'option');

if (!empty($banner_ads)) :
    foreach ($banner_ads as $banner) :
        if (empty($banner['banner_image'])) continue;

        $link = $banner['banner_link'] ?? '';
?>
<div class="banner-full">
    <?php if ($link) : ?>
    <a href="<?= esc_url($link) ?>">
        <?= get_image_attrachment($banner['banner_image']); ?>
    </a>
    <?php else : ?>
    <?= get_image_attrachment($banner['banner_image']); ?>
    <?php endif; ?>
</div>
<?php
    endforeach;
endif;
?>

<div class="row">

    <!-- MAIN CONTENT -->
    <div class="col-lg-8 col-xl-9">
        <div class="row news-video-bottom">
            <?php
            $query->rewind_posts();
            $count = 0;

            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $count++;
                    if ($count <= 5) continue;
            ?>
            <div class="col-sm-6 col-lg-4">
                <div class="news-item news-item-video">
                    <div class="image">
                        <a href="<?= esc_url(get_permalink()) ?>">
                            <?= get_image_post(get_the_ID()); ?>
                        </a>
                        <div class="icon-play">
                            <em class="mdi mdi-play-circle"></em>
                        </div>
                    </div>
                    <div class="caption">
                        <a class="title" href="<?= esc_url(get_permalink()) ?>">
                            <?= esc_html(get_the_title()) ?>
                        </a>
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
        if (function_exists('custom_pagination')) {
            if ($custom_query) {
                $temp_query = $GLOBALS['wp_query'];
                $GLOBALS['wp_query'] = $custom_query;
                custom_pagination();
                $GLOBALS['wp_query'] = $temp_query;
            } else {
                custom_pagination();
            }
        }
        ?>
    </div>

    <!-- SIDEBAR -->
    <div class="col-lg-4 col-xl-3">
        <?php
        $sidebar_banners = get_field('video_sidebar_banners', 'option');

        if (!empty($sidebar_banners)) :
        ?>
        <div class="banner-qc-list">
            <?php foreach ($sidebar_banners as $banner) :
                if (empty($banner['banner_image'])) continue;

                $link = $banner['banner_link'] ?? '';
            ?>
            <div class="banner-item">
                <?php if ($link) : ?>
                <a href="<?= esc_url($link) ?>">
                    <?= get_image_attrachment($banner['banner_image']); ?>
                </a>
                <?php else : ?>
                <?= get_image_attrachment($banner['banner_image']); ?>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

</div>