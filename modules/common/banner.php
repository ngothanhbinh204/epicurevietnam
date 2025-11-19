<?php
if (is_search()) {
	// For search pages, get search banner from theme options
	$banner = get_field('search_banner', 'option');
	if ($banner) {
		$banner = array($banner); 
	}
} elseif (is_post_type_archive()) {
	$post_type = get_post_type();
	
	// Map post type to options field name
	$banner_field_map = array(
		'experiences' => 'experiences_banner',
		'events' => 'events_banner',
		'vouchers' => 'vouchers_banner',
		'shopping' => 'shopping_banner',
		'video' => 'video_banner',
	);
	
	// Get banner from options if post type is mapped
	if (isset($banner_field_map[$post_type])) {
		$banner = get_field($banner_field_map[$post_type], 'option');
		if ($banner) {
			$banner = array($banner); 
		}
	}
} else {
	// For pages and taxonomy archives, use the existing logic
	$id_category = get_queried_object()->term_id ?? null;
	$taxonomy = get_queried_object()->taxonomy ?? null;
	
	if ($id_category) {
		$id = $taxonomy . '_' . $id_category;
	} else {
		$id = get_the_ID();
	}
	$banner = get_field('banner_select_page', $id);
}
?>
<?php if (!empty($banner)) : ?>
<?php foreach ($banner as $item) : 
		$banner_id = is_object($item) ? $item->ID : $item;
		$banner_image = get_image_attachment(get_post_thumbnail_id($banner_id), 'image');
		$banner_title = get_the_title($banner_id);
		
		// Check if we're on the homepage
		$is_homepage = is_front_page() || is_home() || is_search();
		$section_class = $is_homepage ? 'banner-child hidden-backdrop' : 'banner-child';
	?>
<section class="<?= $section_class ?>">
    <div class="container">
        <div class="image">
            <?php if (!empty($banner_image)): ?>
            <?= $banner_image ?>
            <?php endif; ?>
            <?php if (!empty($banner_title) && !$is_homepage): ?>
            <h2 class="title"><?= $banner_title ?></h2>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>
<?php endif; ?>