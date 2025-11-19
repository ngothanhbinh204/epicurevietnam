<?php
// Get current post type
$post_type = get_post_type();

// Get taxonomies for this post type
$taxonomies = get_object_taxonomies($post_type, 'objects');

if (!empty($taxonomies)) :
    foreach ($taxonomies as $taxonomy) :
        // Skip built-in taxonomies and tag taxonomies
        if (in_array($taxonomy->name, ['post_tag', 'post_format'])) continue;
        
        // Skip tag taxonomies to avoid duplicate breadcrumbs
        $tag_taxonomies = ['experiences_tag', 'shopping_tag', 'events_tag', 'vouchers_tag'];
        if (in_array($taxonomy->name, $tag_taxonomies)) continue;
        
        // Get terms for this taxonomy
        $terms = get_terms(array(
            'taxonomy' => $taxonomy->name,
            'hide_empty' => true,
        ));
        
        if (!empty($terms) && !is_wp_error($terms)) :
            $current_term = get_queried_object();
            $current_term_id = ($current_term && isset($current_term->term_id)) ? $current_term->term_id : 0;
?>
<?php get_template_part('modules/common/breadcrumb'); ?>

<ul class="about-nav">
    <?php foreach ($terms as $term) : 
        $term_link = get_term_link($term);
        $active_class = ($current_term_id == $term->term_id) ? ' active' : '';
    ?>
    <li class="<?= $active_class ?>">
        <a href="<?= esc_url($term_link) ?>"><?= esc_html($term->name) ?></a>
    </li>
    <?php endforeach; ?>
</ul>
<?php
        endif;
    endforeach;
endif;
?>