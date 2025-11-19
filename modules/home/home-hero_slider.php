<?php
$title = get_sub_field('title');
$featured_posts = get_sub_field('featured_posts');

if (!$title || !$featured_posts) return; // Exit if no content
?>
<section class="home-slide main-section news-speed">
    <div class="">
        <h1 class="main-title"><?= $title ?></h1>
        <div class="main-slide">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php if ($featured_posts) : ?>
                    <?php foreach ($featured_posts as $post) : 
							setup_postdata($post);
							$post_id = $post->ID;
							$post_type = get_post_type($post_id);
							
							// Get post type name for display
							$category_name = '';
							if ($post_type === 'post') {
								$category_name = 'News'; // Or 'Blog', 'Articles', etc.
							} else {
								$post_type_object = get_post_type_object($post_type);
								$category_name = $post_type_object ? $post_type_object->labels->name : ucfirst($post_type);
							}
							
							// Handle video post type - get video URL and appropriate image
							$is_video = ($post_type === 'video');
							$video_url = $is_video ? get_field('video_url', $post_id) : '';
							$post_link = $video_url ? $video_url : get_permalink($post_id);
							
							// Get image based on post type
							$post_image = '';
							if ($is_video) {
								// For videos: prioritize thumbnail, fallback to video_background_image field
								if (has_post_thumbnail($post_id)) {
									$post_image = get_image_post($post_id);
								} else {
									$video_background_image = get_field('video_background_image', $post_id);
									if ($video_background_image) {
										$post_image = get_image_attachment($video_background_image);
									}
								}
							} else {
								// For other post types: use thumbnail
								if (has_post_thumbnail($post_id)) {
									$post_image = get_image_post($post_id);
								}
							}
							
							$post_excerpt = get_the_excerpt($post_id) ?: wp_trim_words(get_the_content($post_id), 30);
						?>
                    <div class="swiper-slide">
                        <div class="news-item news-item-big">
                            <div class="image">
                                <a href="<?= get_permalink($post_id) ?>">
                                    <?php if ($post_image) : ?>
                                    <?= $post_image ?>
                                    <?php else : ?>
                                    <img class="lazyload"
                                        data-src="<?= get_template_directory_uri() ?>/assets/img/default-image.jpg"
                                        alt="<?= get_the_title($post_id) ?>">
                                    <?php endif; ?>
                                    <?php if ($is_video) : ?>
                                    <div class="icon-play"><em class="mdi mdi-play-circle"></em></div>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="caption">
                                <?php if ($category_name) : ?>
                                <p class="category"><?= $category_name ?></p>
                                <?php endif; ?>
                                <a class="title"
                                    href="<?= get_permalink($post_id) ?>"><?= get_the_title($post_id) ?></a>
                                <div class="des">
                                    <p><?= $post_excerpt ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; 
						wp_reset_postdata();
						?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="main-pagination"></div>
            <div class="main-button">
                <div class="button-prev"><em class="lnr lnr-chevron-left"></em></div>
                <div class="button-next"><em class="lnr lnr-chevron-right"></em></div>
            </div>
        </div>
    </div>
</section>