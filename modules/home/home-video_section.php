<?php
$title = get_sub_field('title');
$video_category = get_sub_field('video_category');
$menu_categories = get_sub_field('menu_categories');
$view_all_link = get_sub_field('view_all_link');
$featured_video = get_sub_field('featured_video');
$main_video = get_sub_field('main_video');
$video_list = get_sub_field('video_list');

if (!$title) return; // Exit if no content
?>

<section class="news-video">
    <div class="news-head">
        <h2 class="main-title"><?= $title ?></h2>
        <ul class="news-menu-list">
            <?php if ($menu_categories) : ?>
            <?php foreach ($menu_categories as $category) : ?>
            <li><a href="<?= get_term_link($category) ?>"><?= $category->name ?></a></li>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($view_all_link) : ?>
            <li class="view-all">
                <a href="<?= $view_all_link['url'] ?>"><?= $view_all_link['title'] ?><em
                        class="lnr lnr-arrow-right"></em></a>
            </li>
            <?php else : ?>
            <li class="view-all">
                <a href="<?= get_post_type_archive_link('video') ?>">View All<em class="lnr lnr-arrow-right"></em></a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="news-body">
        <div class="row">
            <div class="col-lg-3">
                <?php if ($featured_video && !empty($featured_video)) : 
					$post = $featured_video[0]; 
					setup_postdata($post);
				?>
                <div class="news-item news-item-video news-item-video-big">
                    <div class="caption">
                        <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                        <div class="des">
                            <?= get_the_excerpt() ?>
                        </div>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <?php if ($main_video && !empty($main_video)) : 
					$post = $main_video[0]; 
					setup_postdata($post);
					$video_url = get_field('video_url', $post->ID);
					// Get image: prioritize default thumbnail, fallback to custom field
					$video_image = '';
					if (has_post_thumbnail($post->ID)) {
						$video_image = get_image_post($post->ID);
					} else {
						$video_background_image = get_field('video_background_image', $post->ID);
						if ($video_background_image) {
							$video_image = get_image_attachment($video_background_image);
						}
					}
				?>
                <div class="news-item news-item-video news-item-video-big">
                    <div class="image">
                        <a href="<?= $video_url ? $video_url : get_permalink() ?>">
                            <?php if ($video_image): ?>
                            <?= $video_image ?>
                            <?php endif; ?>
                            <div class="icon-play"><em class="mdi mdi-play-circle"></em></div>
                        </a>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <div class="col-lg-3">
                <div class="news-list row">
                    <?php if ($video_list) : ?>
                    <?php foreach ($video_list as $post) : 
							setup_postdata($post);
							$video_url = get_field('video_url', $post->ID);
							// Get image: prioritize default thumbnail, fallback to custom field
							$list_video_image = '';
							if (has_post_thumbnail($post->ID)) {
								$list_video_image = get_image_post($post->ID);
							} else {
								$video_background_image = get_field('video_background_image', $post->ID);
								if ($video_background_image) {
									$list_video_image = get_image_attachment($video_background_image);
								}
							}
						?>
                    <div class="col-md-6 col-lg-12 news-item news-item-child news-item-video">
                        <div class="image">
                            <a href="<?= $video_url ? $video_url : get_permalink() ?>">
                                <?php if ($list_video_image): ?>
                                <?= $list_video_image ?>
                                <?php endif; ?>
                                <div class="icon-play"><em class="mdi mdi-play-circle"></em></div>
                            </a>
                        </div>
                        <div class="caption">
                            <a class="title"
                                href="<?= $video_url ? $video_url : get_permalink() ?>"><?= get_the_title() ?></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>