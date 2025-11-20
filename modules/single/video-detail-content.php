<?php
$post_id = get_the_ID();
$video_url = get_field('video_url', $post_id);

// Support YouTube Shorts
if ($video_url && strpos($video_url, '/shorts/') !== false) {
    $video_url = str_replace('/shorts/', '/watch?v=', $video_url);
}

// Get image: prioritize default thumbnail, fallback to custom field
$thumbnail_image = '';
if (has_post_thumbnail($post_id)) {
    $thumbnail_image = get_image_post($post_id);
    $thumbnail_url = get_image_post($post_id, 'url');
} else {
    $video_background_image = get_field('video_background_image', $post_id);
    if ($video_background_image) {
        $thumbnail_image = get_image_attachment($video_background_image);
        $thumbnail_url = get_image_attachment($video_background_image, 'url');
    }
}
$author = get_the_author();
$post_date = get_the_date('j F Y');
?>

<div class="row no-gutters news-video-detail-top">
    <div class="col-lg-8">
        <?php if ($thumbnail_image): ?>
        <div class="image">
            <?php if ($video_url): ?>
            <a href="<?= esc_url($video_url) ?>" data-fancybox>
                <?= $thumbnail_image ?>
            </a>
            <?php else: ?>
            <?= $thumbnail_image ?>
            <?php endif; ?>
            <div class="icon-play">
                <em class="mdi mdi-play-circle"></em>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="box-content">
            <h1 class="main-title"><?= get_the_title() ?></h1>

            <div class="info-title">
                <?php if ($author): ?>
                <p class="sub-title"><?= esc_html($author) ?></p>
                <?php endif; ?>
                <time><?= esc_html($post_date) ?></time>
            </div>

            <?php if (has_excerpt()): ?>
            <div class="full-content">
                <p><?= get_the_excerpt() ?></p>
            </div>
            <?php endif; ?>

            <div class="share-social"></div>
        </div>
    </div>
</div>

<?php
// Get banner ads for single page
$banner_ads = get_field('video_middle_banner', 'option');

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
        break; // Only show first banner
        endif;
    endforeach;
endif;
?>

<div class="news-video-other">
    <h2 class="main-title"><?php echo esc_html__('Other video', 'canhcamtheme'); ?></h2>
    <div class="main-slide">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                // Get related videos (from same post type, exclude current)
                $related_args = array(
                    'post_type' => 'video',
                    'posts_per_page' => 12,
                    'post__not_in' => array($post_id),
                    'orderby' => 'date',
                    'order' => 'DESC'
                );
                
                $related_query = new WP_Query($related_args);
                
                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                        $related_video_url = get_field('video_url', get_the_ID());
                        
                        // Support YouTube Shorts
                        if ($related_video_url && strpos($related_video_url, '/shorts/') !== false) {
                            $related_video_url = str_replace('/shorts/', '/watch?v=', $related_video_url);
                        }

                        // Get image: prioritize default thumbnail, fallback to custom field
                        $related_video_image = '';
                        if (has_post_thumbnail(get_the_ID())) {
                            $related_video_image = get_image_post(get_the_ID());
                        } else {
                            $related_video_background = get_field('video_background_image', get_the_ID());
                            if ($related_video_background) {
                                $related_video_image = get_image_attachment($related_video_background);
                            }
                        }
                ?>
                <div class="swiper-slide">
                    <div class="news-item news-item-video">
                        <?php if ($related_video_image): ?>
                        <div class="image">
                            <a href="<?= $related_video_url ? esc_url($related_video_url) : get_permalink() ?>"
                                <?= $related_video_url ? 'data-fancybox' : '' ?>>
                                <?= $related_video_image ?>
                            </a>
                            <div class="icon-play">
                                <em class="mdi mdi-play-circle"></em>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="caption">
                            <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                        </div>
                    </div>
                </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>

        <div class="main-button">
            <div class="button-prev">
                <em class="mdi mdi-chevron-left"></em>
            </div>
            <div class="button-next">
                <em class="mdi mdi-chevron-right"></em>
            </div>
        </div>
    </div>
</div>