<?php
$title = get_sub_field('title');
$menu_categories = get_sub_field('menu_categories');
$voucher = get_sub_field('voucher');
$sidebar_banners = get_sub_field('sidebar_banners');

if (!$title) return;
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
                    <li class="view-all"><a href="<?= get_post_type_archive_link('vouchers') ?>">View All<em
                                class="lnr lnr-arrow-right"></em></a></li>
                </ul>
            </div>
            <div class="news-body">
                <div class="row row-25">
                    <?php if ($voucher) : ?>
                    <?php foreach ($voucher as $post) : 
                        setup_postdata($post);
                    ?>
                    <div class="col-lg-6">
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
                    <?php if (!empty($banner['link']) && !empty($banner['link']['url'])) : ?>
                    <a href="<?= esc_url($banner['link']['url']) ?>">
                        <?php if (!empty($banner['image'])) : ?>
                        <?= get_image_attachment($banner['image'], 'image'); ?>
                        <?php endif; ?>
                    </a>
                    <?php else : ?>
                    <?php if (!empty($banner['image'])) : ?>
                    <?= get_image_attachment($banner['image'], 'image'); ?>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>