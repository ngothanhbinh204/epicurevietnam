<?php
$post_id = get_the_ID();
$video_url = normalize_youtube_url(get_field('video_url', $post_id));

// Always get thumbnail (featured → fallback image)
$thumbnail_image = get_video_thumbnail_image($post_id);

$author = get_the_author();
$post_date = get_the_date('j F Y');
?>

<div class="row no-gutters news-video-detail-top">
    <div class="col-lg-8">
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
// Single video banner ads
$banner_ads = get_field('video_middle_banner', 'option');

if (!empty($banner_ads)) :
    foreach ($banner_ads as $banner) :
        if (!empty($banner['banner_image']) && !empty($banner['banner_link'])) :
?>
<div class="banner-full">
    <a href="<?= esc_url($banner['banner_link']) ?>">
        <?= get_image_attachment($banner['banner_image']) ?>
    </a>
</div>
<?php
            break; // show only first banner
        endif;
    endforeach;
endif;
?>

<div class="news-video-other">
    <h2 class="main-title"><?= esc_html__('Other video', 'canhcamtheme'); ?></h2>

    <div class="main-slide">
        <div class="swiper-container">
            <div class="swiper-wrapper">

                <?php
                $related_query = new WP_Query([
                    'post_type' => 'video',
                    'posts_per_page' => 12,
                    'post__not_in' => [$post_id],
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) :
                        $related_query->the_post();

                        $related_video_url = normalize_youtube_url(get_field('video_url', get_the_ID()));
                        $related_thumb = get_video_thumbnail_image(get_the_ID());
                ?>
                <div class="swiper-slide">
                    <div class="news-item news-item-video">
                        <div class="image">
                            <a href="<?= $related_video_url ? esc_url($related_video_url) : get_permalink() ?>"
                                <?= $related_video_url ? 'data-fancybox' : '' ?>>
                                <?= $related_thumb ?>
                            </a>
                            <div class="icon-play">
                                <em class="mdi mdi-play-circle"></em>
                            </div>
                        </div>

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
            <div class="button-prev"><em class="mdi mdi-chevron-left"></em></div>
            <div class="button-next"><em class="mdi mdi-chevron-right"></em></div>
        </div>
    </div>
</div>