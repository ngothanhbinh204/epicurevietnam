<?php
$social_links = get_field('social_links', 'options');
if ($social_links) :
?>
<ul class="social-list">
	<?php foreach ($social_links as $social) :
		// Check if link exists and either icon class or icon image is provided
		$has_icon = !empty($social['icon']) || !empty($social['icon_image']);
		if ($social['link'] && $has_icon) :
	?>
	<li>
		<a href="<?= $social['link']['url'] ?>" <?= $social['link']['target'] ? 'target="_blank"' : '' ?>>
			<?php if (!empty($social['icon'])) : ?>
				<em class="<?= esc_attr($social['icon']) ?>"></em>
			<?php elseif (!empty($social['icon_image'])) : ?>
				<img src="<?= esc_url($social['icon_image']['url']) ?>" alt="<?= esc_attr($social['icon_image']['alt'] ?: 'Social icon') ?>" class="social-icon-img">
			<?php endif; ?>
		</a>
	</li>
	<?php 
		endif;
	endforeach; 
	?>
</ul>
<?php else : ?>
<ul class="social-list">
	<li><a href="#"><em class="ri-facebook-fill"></em></a></li>
	<li><a href="#"><em class="ri-instagram-line"></em></a></li>
	<li><a href="#"><em class="ri-play-circle-fill"></em></a></li>
	<li><a href="#"><em class="ri-twitter-fill"></em></a></li>
</ul>
<?php endif; ?>