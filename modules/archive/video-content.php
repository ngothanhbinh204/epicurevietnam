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

// Get video URL from ACF field
function get_video_url($post_id = null) {
    if (!$post_id) $post_id = get_the_ID();
    $video_url = get_field('video_url', $post_id);
    return $video_url ? $video_url : '';
}
?>

<h1 class="main-title dotted"><?= esc_html($title) ?></h1>

<div class="news-video">
    <div class="news-body">
        <div class="row">
            <?php 
            $main_post = null;
            $side_posts = [];
            $count = 0;
            
            if (have_posts()) :
                while (have_posts() && $count < 5) : the_post();
                    $count++;
                    if ($count === 1) {
                        $main_post = get_post();
                    } else {
                        $side_posts[] = get_post();
                    }
                endwhile;
            endif;
            
            // Display main video (left caption)
            if ($main_post) :
                $video_url = get_field('video_url', $main_post->ID);
                $video_thumbnail = get_field('video_background_image', $main_post->ID);
            ?>
            <div class="col-lg-3">
                <div class="news-item news-item-video news-item-video-big">
                    <div class="caption">
                        <a class="title"
                            href="<?= get_permalink($main_post->ID) ?>"><?= get_the_title($main_post->ID) ?></a>
                        <?php if (has_excerpt($main_post->ID)): ?>
                        <div class="des">
                            <p><?= get_the_excerpt($main_post->ID) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Main video image (center) -->
            <div class="col-lg-6">
                <div class="news-item news-item-video news-item-video-big">
                    <div class="image">
                        <a href="<?= get_permalink($main_post->ID) ?>">
                            <img class="lazyload"
                                data-src="<?= $video_thumbnail ? wp_get_attachment_image_url($video_thumbnail, 'large') : get_the_post_thumbnail_url($main_post->ID, 'large') ?>"
                                alt="<?= get_the_title($main_post->ID) ?>">
                        </a>
                        <div class="icon-play">
                            <em class="mdi mdi-play-circle"></em>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Side videos (right column) -->
            <div class="col-lg-3">
                <div class="news-list row">
                    <?php 
                    foreach ($side_posts as $side_post) :
                        $video_url = get_field('video_url', $side_post->ID);
                        $video_thumbnail = get_field('video_background_image', $side_post->ID);
                    ?>
                    <div class="col-md-6 col-lg-12 news-item news-item-child news-item-video">
                        <div class="image">
                            <a href="<?= get_permalink($side_post->ID) ?>">
                                <img class="lazyload"
                                    data-src="<?= $video_thumbnail ? wp_get_attachment_image_url($video_thumbnail, 'medium') : get_the_post_thumbnail_url($side_post->ID, 'medium') ?>"
                                    alt="<?= get_the_title($side_post->ID) ?>">
                            </a>
                            <div class="icon-play">
                                <em class="mdi mdi-play-circle"></em>
                            </div>
                        </div>
                        <div class="caption">
                            <a class="title"
                                href="<?= get_permalink($side_post->ID) ?>"><?= get_the_title($side_post->ID) ?></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Get banner ads for middle section
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
        endif;
    endforeach;
endif;
?>

<div class="row">
    <div class="col-lg-8 col-xl-9">
        <div class="row news-video-bottom">
            <?php
            // Reset and show remaining videos
            wp_reset_postdata();
            rewind_posts();
            $count = 0;
            
            if (have_posts()) :
                while (have_posts()) : the_post();
                    $count++;
                    // Skip first 5 posts (already shown above)
                    if ($count <= 5) continue;
                    
                    $video_url = get_field('video_url', get_the_ID());
                    $video_thumbnail = get_field('video_background_image', get_the_ID());
            ?>
            <div class="col-sm-6 col-lg-4">
                <div class="news-item news-item-video">
                    <div class="image">
                        <a href="<?= get_permalink() ?>">
                            <img class="lazyload"
                                data-src="<?= $video_thumbnail ? wp_get_attachment_image_url($video_thumbnail, 'medium') : get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>"
                                alt="<?= get_the_title() ?>">
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
            endif;
            wp_reset_postdata();
            ?>
        </div>

        <!-- Pagination -->
        <?php custom_pagination(); ?>
    </div>

    <div class="col-lg-4 col-xl-3">
        <?php
        // Get sidebar banner ads
        $sidebar_banners = get_field('video_sidebar_banners', 'option');
        
        if (!empty($sidebar_banners)) :
        ?>
        <div class="banner-qc-list">
            <?php foreach ($sidebar_banners as $banner) :
                if (!empty($banner['banner_image']) && !empty($banner['banner_link'])) :
            ?>
            <div class="banner-item">
                <a href="<?= esc_url($banner['banner_link']) ?>">
                    <?= get_image_attrachment($banner['banner_image']) ?>
                </a>
            </div>
            <?php
                endif;
            endforeach;
            ?>
        </div>
        <?php endif; ?>
    </div>
</div>