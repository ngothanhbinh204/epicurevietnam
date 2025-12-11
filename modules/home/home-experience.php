<?php
$title = get_sub_field('title');
$experience_category = get_sub_field('experience_category');
$menu_categories = get_sub_field('menu_categories');
$featured_experience = get_sub_field('featured_experience');
$experience_posts = get_sub_field('experience_posts');
$sidebar_title = get_sub_field('sidebar_title');
$sidebar_banners = get_sub_field('sidebar_banners');

if (!$title) return; // Exit if no content
?>

<section class="news-list-block-1 news-speed">
    <div class="">
        <div class="line-top"></div>
        <section class="news-list-block-1 news-speed">
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <div class="news-head">
                        <h2 class="main-title"><?= $title ?></h2>
                        <ul class="news-menu-list">
                            <?php if ($menu_categories) : ?>
                            <?php foreach ($menu_categories as $category) : ?>
                            <li><a href="<?= get_term_link($category) ?>"><?= $category->name ?></a></li>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            <li class="view-all"><a href="<?= get_post_type_archive_link('experiences') ?>">View All<em
                                        class="lnr lnr-arrow-right"></em></a></li>
                        </ul>
                    </div>
                    <div class="news-wrap row row-25">
                        <div class="news-left col-lg-6">
                            <?php if ($featured_experience && !empty($featured_experience)) : 
                                $post = $featured_experience[0]; 
                                setup_postdata($post);
                            ?>
                            <div class="news-item">
                                <div class="image">
                                    <a href="<?= get_permalink() ?>">

                                        <?php echo get_image_post(get_the_ID()); ?>
                                    </a>
                                </div>
                                <div class="caption">
                                    <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                    <div class="des">
                                        <?= get_the_excerpt() ?>
                                    </div>
                                </div>
                            </div>
                            <?php wp_reset_postdata(); endif; ?>
                        </div>
                        <div class="news-right col-lg-6">
                            <div class="news-list row">
                                <?php if ($experience_posts) : ?>
                                <?php foreach ($experience_posts as $post) : 
                                        setup_postdata($post);
                                    ?>
                                <div class="news-item col-md-6 col-lg-12 news-item-child">
                                    <div class="image">
                                        <a href="<?= get_permalink() ?>">
                                            <?php echo get_image_post(get_the_ID()); ?>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <a class="title" href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php wp_reset_postdata(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <h2 class="main-title"><?= $sidebar_title ?></h2>
                    <div class="banner-qc-list">
                        <?php if ($sidebar_banners) : ?>
                        <?php foreach ($sidebar_banners as $banner) : ?>
                        <div class="banner-item">
                            <a href="<?= $banner['link']['url'] ?>">
                                <?= get_image_attachment($banner['image'], 'image'); ?>
                            </a>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>