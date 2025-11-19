<?php
/**
 * Header Searchbox Component
 * Usage: get_template_part('modules/common/header-searchbox');
 */
?>

<div class="searchbox">
    <form role="search" method="get" action="<?= home_url('/') ?>">
        <?php 
        $search_placeholder = get_field('search_placeholder', 'options');
        $placeholder = $search_placeholder ? $search_placeholder : 'Tìm kiếm...';
        ?>
        <input type="text" name="s" placeholder="<?= esc_attr($placeholder) ?>" value="<?= get_search_query() ?>">
        <button type="submit"><em class="mdi mdi-magnify"></em></button>
    </form>
</div>