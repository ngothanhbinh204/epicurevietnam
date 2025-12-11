<?php
$post_id = get_the_ID();
$post_type = get_post_type();
$author = get_the_author();
$post_date = get_the_date('j F Y');
$thumbnail = get_the_post_thumbnail($post_id, 'full');

// Get taxonomy for this post type
$taxonomy = $post_type . '_category';
$terms = get_the_terms($post_id, $taxonomy);

// Get contact information from ACF fields
$address = get_field('address', $post_id);
$email = get_field('email', $post_id);
$phone = get_field('phone', $post_id);
$fax = get_field('fax', $post_id);
$website = get_field('website', $post_id);
?>

<div class="col-lg-8 col-xl-9">
    <div class="box-events-detail">
        <h1 class="detail-title"><?= get_the_title() ?></h1>

        <div class="info-title">
            <?php if ($author): ?>
            <p class="sub-title"><?= esc_html($author) ?></p>
            <?php endif; ?>
            <time><?= esc_html($post_date) ?></time>
            <div class="share-social"></div>
        </div>

        <div class="full-content">
            <?= apply_filters('the_content', get_the_content()) ?>
        </div>

        <?php 
        // Get tags for this post type
        $tags_taxonomy = $post_type . '_tag';
        $post_tags = get_the_terms($post_id, $tags_taxonomy);
        
        if (!empty($post_tags) && !is_wp_error($post_tags)) :
        ?>
        <div class="tags">
            <p>Tags:</p>
            <?php foreach ($post_tags as $tag) : ?>
            <a href="<?= home_url('/tag?tags=' . urlencode($tag->name)) ?>"
                title="<?= esc_attr($tag->name) ?>"><?= esc_html($tag->name) ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ($address || $email || $phone || $fax || $website): ?>
        <div class="box-contact">
            <h3 class="main-title">Contact us</h3>
            <ul class="contact-list no-pad">
                <?php if ($address): ?>
                <li>
                    <p class="title">
                        <em class="ri-map-pin-fill"></em>
                        <span><?php echo esc_html__('Address', 'canhcamtheme'); ?></span>
                    </p>
                    <p class="content"><?= esc_html($address) ?></p>
                </li>
                <?php endif; ?>

                <?php if ($email): ?>
                <li>
                    <p class="title">
                        <em class="ri-mail-fill"></em>
                        <span><?php echo esc_html__('Email', 'canhcamtheme'); ?></span>
                    </p>
                    <p class="content">
                        <a href="mailto:<?= esc_attr($email) ?>"><?= esc_html($email) ?></a>
                    </p>
                </li>
                <?php endif; ?>

                <?php if ($phone): ?>
                <li>
                    <p class="title">
                        <em class="ri-phone-fill"></em>
                        <span><?php echo esc_html__('Phone', 'canhcamtheme'); ?></span>
                    </p>
                    <p class="content">
                        <?php
                        $phones = explode(',', $phone);
                        foreach ($phones as $index => $tel) :
                            $tel = trim($tel);
                            if ($index > 0) echo ' – ';
                            ?>
                        <a href="tel:<?= esc_attr(str_replace([' ', '.', '-'], '', $tel)) ?>"><?= esc_html($tel) ?></a>
                        <?php endforeach; ?>
                    </p>
                </li>
                <?php endif; ?>

                <?php if ($fax): ?>
                <li>
                    <p class="title">
                        <em class="ri-smartphone-fill"></em>
                        <span><?php echo esc_html__('Fax', 'canhcamtheme'); ?></span>
                    </p>
                    <p class="content">
                        <a href="tel:<?= esc_attr(str_replace([' ', '.', '-'], '', $fax)) ?>"><?= esc_html($fax) ?></a>
                    </p>
                </li>
                <?php endif; ?>

                <?php if ($website): ?>
                <li>
                    <p class="title">
                        <em class="ri-global-fill"></em>
                        <span><?php echo esc_html__('Website', 'canhcamtheme'); ?></span>
                    </p>
                    <p class="content">
                        <a href="<?= esc_url($website) ?>"
                            target="_blank"><?= esc_html(str_replace(['http://', 'https://'], '', $website)) ?></a>
                    </p>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="box-related">
            <h2 class="main-title font-2 no-up"><?php echo esc_html__('Related', 'canhcamtheme'); ?></h2>
            <div class="main-slide">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <?php
                        // Get related posts (same post type, exclude current)
                        $related_args = array(
                            'post_type' => $post_type,
                            'posts_per_page' => 8,
                            'post__not_in' => array($post_id),
                            'orderby' => 'date',
                            'order' => 'DESC'
                        );
                        
                        // If post has terms, prioritize same category
                        if (!empty($terms) && !is_wp_error($terms)) {
                            $term_ids = wp_list_pluck($terms, 'term_id');
                            $related_args['tax_query'] = array(
                                array(
                                    'taxonomy' => $taxonomy,
                                    'field' => 'term_id',
                                    'terms' => $term_ids,
                                )
                            );
                        }
                        
                        $related_query = new WP_Query($related_args);
                        
                        if ($related_query->have_posts()) :
                            while ($related_query->have_posts()) : $related_query->the_post();
                                $related_thumbnail_url = get_image_post(get_the_ID(), 'url');
                        ?>
                        <div class="swiper-slide">
                            <div class="news-item">
                                <?php if ($related_thumbnail_url): ?>
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
                                        <p><?= get_the_excerpt() ?></p>
                                    </div>
                                    <?php endif; ?>
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
    </div>
</div>

<div class="col-lg-4 col-xl-3">
    <?php 
    // Get post type object and all categories for this post type
    $post_type_object = get_post_type_object($post_type);
    $all_categories = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
    ));
    
    // Get current post's category IDs for active state
    $current_term_ids = array();
    if (!empty($terms) && !is_wp_error($terms)) {
        $current_term_ids = wp_list_pluck($terms, 'term_id');
    }
    ?>

    <?php if (!empty($all_categories) && !is_wp_error($all_categories)): ?>
    <div class="box-category">
        <h2 class="main-title"><?= esc_html($post_type_object->labels->name) ?></h2>
        <ul class="menu-list no-pad">
            <?php foreach ($all_categories as $category): ?>
            <li class="<?= in_array($category->term_id, $current_term_ids) ? 'active' : '' ?>">
                <a href="<?= get_term_link($category) ?>"><?= esc_html($category->name) ?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php
    // Get "The Great Read" posts
    $great_read_posts = get_field('the_great_read', 'option');
    
    if (!empty($great_read_posts)) :
    ?>
    <div class="box-great">
        <h2 class="main-title dotted">
            <?php echo esc_html__('The Great Read', 'canhcamtheme'); ?>
        </h2>
        <div class="great-list">
            <?php foreach ($great_read_posts as $great_post) :
                $great_thumbnail_url = get_image_post($great_post->ID, 'url');
            ?>
            <div class="great-item">
                <?php if ($great_thumbnail_url): ?>
                <div class="image">
                    <a href="<?= get_permalink($great_post->ID) ?>">
                        <?php echo get_image_post($great_post->ID); ?>
                    </a>
                </div>
                <?php endif; ?>
                <div class="caption">
                    <a class="title" href="<?= get_permalink($great_post->ID) ?>">
                        <?= get_the_title($great_post->ID) ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php
    // Get sidebar banner ads for current post type
    $banner_field_name = $post_type . '_sidebar_banners';
    $sidebar_banners = get_field($banner_field_name, 'option');
    
    if (!empty($sidebar_banners)) :
    ?>
    <div class="banner-list">
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