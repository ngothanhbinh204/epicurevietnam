<?php
/**
 * Custom Tags Page Template
 */
get_header();

// Get the tag filter from URL parameter
$tag_filter = isset($_GET['tags']) ? sanitize_text_field($_GET['tags']) : '';

?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<section class="om-whaton main-section">
    <div class="container">
        <?php get_template_part('modules/common/breadcrumb'); ?>

        <div class="whaton-list news-list-pages main-section">
            <div class="container">

                <?php if (empty($tag_filter)): ?>
                <div class="all-tagged-posts">
                    <div class="row">
                        <?php
                            $tag_taxonomies = ['experiences_tag', 'shopping_tag', 'events_tag', 'vouchers_tag'];
                            $tax_query = array('relation' => 'OR');
                            
                            foreach ($tag_taxonomies as $taxonomy) {
                                $tax_query[] = array(
                                    'taxonomy' => $taxonomy,
                                    'operator' => 'EXISTS',
                                );
                            }
                            
                            $args = array(
                                'post_type' => array('experiences', 'shopping', 'events', 'vouchers'),
                                'posts_per_page' => 12,
                                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                                'tax_query' => $tax_query,
                                'meta_query' => array(
                                    array(
                                        'key' => '_thumbnail_id',
                                        'compare' => 'EXISTS'
                                    )
                                )
                            );
                            
                            $all_posts_query = new WP_Query($args);
                            
                            if ($all_posts_query->have_posts()) :
                                while ($all_posts_query->have_posts()) : $all_posts_query->the_post();
                                    $thumbnail_url = get_image_post(get_the_ID(), 'url');
                            ?>
                        <div class="col-md-4">
                            <article class="news-item news-item-top">
                                <?php if ($thumbnail_url): ?>
                                <div class="image">
                                    <a href="<?= get_permalink() ?>" title="<?= get_the_title() ?>">
                                        <?php echo get_image_post(get_the_ID()); ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <div class="caption">
                                    <a class="title" href="<?= get_permalink() ?>" title="<?= get_the_title() ?>">
                                        <?= get_the_title() ?>
                                    </a>
                                    <?php if (has_excerpt()): ?>
                                    <div class="des">
                                        <p><?= get_the_excerpt() ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>
                        <?php
                                endwhile;
                                
                                if ($all_posts_query->max_num_pages > 1) :
                            ?>
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                <?php
                                     if (function_exists('custom_pagination')) {
                                    custom_pagination();
                                }
                                    ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php
                                wp_reset_postdata();
                            else:
                            ?>
                        <div class="col-12">
                            <p>No tagged posts found.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div> <?php else: ?>
                <div class="tag-posts">
                    <div class="row">
                        <?php
                            $tag_taxonomies = ['experiences_tag', 'shopping_tag', 'events_tag', 'vouchers_tag'];
                            $tax_query = array('relation' => 'OR');
                            
                            foreach ($tag_taxonomies as $taxonomy) {
                                $tax_query[] = array(
                                    'taxonomy' => $taxonomy,
                                    'field'    => 'name',
                                    'terms'    => $tag_filter,
                                );
                            }
                            
                            $args = array(
                                'post_type' => array('experiences', 'shopping', 'events', 'vouchers'),
                                'posts_per_page' => 12,
                                'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                                'tax_query' => $tax_query,
                                'meta_query' => array(
                                    array(
                                        'key' => '_thumbnail_id',
                                        'compare' => 'EXISTS'
                                    )
                                )
                            );
                            
                            $tag_query = new WP_Query($args);
                            
                            if ($tag_query->have_posts()) :
                                while ($tag_query->have_posts()) : $tag_query->the_post();
                                    $thumbnail_url = get_image_post(get_the_ID(), 'url');
                            ?>
                        <div class="col-md-4">
                            <article class="news-item news-item-top">
                                <?php if ($thumbnail_url): ?>
                                <div class="image">
                                    <a href="<?= get_permalink() ?>" title="<?= get_the_title() ?>">
                                        <?php echo get_image_post(get_the_ID()); ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                                <div class="caption">
                                    <a class="title" href="<?= get_permalink() ?>" title="<?= get_the_title() ?>">
                                        <?= get_the_title() ?>
                                    </a>
                                    <?php if (has_excerpt()): ?>
                                    <div class="des">
                                        <p><?= get_the_excerpt() ?></p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>
                        <?php
                                endwhile;
                                
                                // Pagination
                                if ($tag_query->max_num_pages > 1) :
                            ?>
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                <?php
                                     if (function_exists('custom_pagination')) {
                                    custom_pagination();
                                }
                                    ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php
                                wp_reset_postdata();
                            else:
                            ?>
                        <div class="col-12">
                            <p>No posts found with the tag "<?= esc_html($tag_filter) ?>".</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>