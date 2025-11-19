<?php
$title = get_sub_field('title');
$event_category = get_sub_field('event_category');
$menu_categories = get_sub_field('menu_categories');
$events = get_sub_field('events');
$sidebar_banners = get_sub_field('sidebar_banners');

if (!$title) return; // Exit if no content
?>

<section class="news-list-block-2 news-speed">
    <div class="row">
        <div class="col-lg-8 col-xl-9">
            <div class="news-head">
                <h3 class="main-title"><?= $title ?></h3>
                <ul class="news-menu-list">
                    <?php if ($menu_categories) : ?>
                    <?php foreach ($menu_categories as $category) : ?>
                    <li><a href="<?= get_term_link($category) ?>"><?= $category->name ?></a></li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <li class="view-all"><a href="<?= get_post_type_archive_link('events') ?>">View All<em
                                class="lnr lnr-arrow-right"></em></a></li>
                </ul>
            </div>
            <div class="news-body">
                <div class="row row-25">
                    <?php if ($events) : ?>
                    <?php foreach ($events as $post) : 
							setup_postdata($post);
							$event_date_start = get_field('event_date_start', $post->ID);
							$event_location = get_field('event_location_name', $post->ID);
						?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="news-item">
                            <div class="image">
                                <a href="<?= get_permalink() ?>">
                                    <img class="lazyload"
                                        data-src="<?= get_the_post_thumbnail_url($post, 'medium_large') ?>"
                                        alt="<?= get_the_title() ?>">
                                </a>
                            </div>
                            <div class="caption">
                                <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                <div class="des">
                                    <!-- <?php if ($event_date_start) : ?>
												<p><strong>Date:</strong> <?= date('M j, Y', strtotime($event_date_start)) ?></p>
											<?php endif; ?>
											<?php if ($event_location) : ?>
												<p><strong>Location:</strong> <?= $event_location ?></p>
											<?php endif; ?> -->
                                    <?= get_the_excerpt() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xl-3">
            <div class="banner-qc-list">
                <?php if ($sidebar_banners) : ?>
                <?php foreach ($sidebar_banners as $banner) : ?>
                <div class="banner-item">
                    <a href="<?= $banner['link']['url'] ?>">
                        <img class="lazyload" data-src="<?= get_image_attrachment($banner['image'], 'url') ?>" alt="">
                    </a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>