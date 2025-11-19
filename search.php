<?php get_header() ?>

<h1 class="hidden"><?php echo get_bloginfo('name') ?></h1>

<?php get_template_part('modules/common/banner'); ?>

<div id="ctl00_divCenter" class="middle-fullwidth">
    <div class="container">
        <div class="search-page">
            <div class="search-page-top">
                <div class="page-header">
                    <h1>Search</h1>
                </div>
                <div id="ctl00_mainContent_divResults" class="wrap01 searchresultsummary">
                    <?php 
                    global $wp_query;
                    $total_posts = $wp_query->found_posts;
                    $posts_per_page = get_option('posts_per_page');
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $from = (($paged - 1) * $posts_per_page) + 1;
                    $to = min($paged * $posts_per_page, $total_posts);
                    ?>
                    Displaying Results
                    <span style="font-weight:bold;"><?= $from ?></span>-<span
                        style="font-weight:bold;"><?= $to ?></span>
                    of
                    <span style="font-weight:bold;"><?= $total_posts ?></span>
                    For
                    <span class="searchqueryterm" style="font-weight:bold;"><?= esc_html(get_search_query()) ?></span>
                </div>
                <div class="searchcontrols">
                    <div class="form-inline mrt10">
                        <form role="search" method="get" action="<?= esc_url(home_url('/')) ?>">
                            <div class="form-group">
                                <input type="text" value="<?= esc_attr(get_search_query()) ?>" name="s" maxlength="255"
                                    size="50" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Search" class="seachpage-btn btn btn-default">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="pnlInternalSearch">
                <div class="searchresults">
                    <?php
                    // Pagination at top
                    if (function_exists('custom_pagination')) {
                        custom_pagination();
                    }
                    ?>
                    <div class="clear"></div>

                    <?php if (have_posts()) : ?>
                    <dl class="searchresultlist">
                        <?php while (have_posts()) : the_post(); ?>
                        <dd class="searchresult">
                            <div class="NeatHtml"
                                style="overflow: hidden; position: relative; border: none; padding: 0; margin: 0;">
                                <div>
                                    <h3>
                                        <a href="<?= get_permalink() ?>" title="<?= esc_attr(get_the_title()) ?>">
                                            <?php
                                            // Get post type and category for breadcrumb style title
                                            $post_type = get_post_type();
                                            $categories = '';
                                            
                                            if ($post_type !== 'post') {
                                                // For custom post types, get their categories
                                                $taxonomy = $post_type . '_category';
                                                $terms = get_the_terms(get_the_ID(), $taxonomy);
                                                if ($terms && !is_wp_error($terms)) {
                                                    $categories = $terms[0]->name . ' > ';
                                                }
                                            } else {
                                                // For regular posts, get categories
                                                $post_categories = get_the_category();
                                                if (!empty($post_categories)) {
                                                    $categories = $post_categories[0]->name . ' > ';
                                                }
                                            }
                                            
                                            echo esc_html($categories . get_the_title());
                                            ?>
                                        </a>
                                    </h3>
                                    <div class="searchresultdesc">
                                        <?php 
                                        $excerpt = get_the_excerpt();
                                        if (!$excerpt) {
                                            $excerpt = wp_trim_words(get_the_content(), 30, '...');
                                        }
                                        
                                        // Highlight search terms in excerpt
                                        $search_query = get_search_query();
                                        if ($search_query) {
                                            $excerpt = preg_replace('/(' . preg_quote($search_query, '/') . ')/i', '<span class="searchterm">$1</span>', $excerpt);
                                        }
                                        
                                        echo $excerpt;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </dd>
                        <?php endwhile; ?>
                    </dl>

                    <?php else: ?>
                    <div class="no-results">
                        <p>No results found for "<?= esc_html(get_search_query()) ?>"</p>
                    </div>
                    <?php endif; ?>

                    <?php
                    // Pagination at bottom
                    if (function_exists('custom_pagination')) {
                        custom_pagination();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer() ?>