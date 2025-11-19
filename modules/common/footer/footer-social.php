<?php
$social_links = get_field('social_links', 'options');
if ($social_links) :
?>
<ul class="social-list">
	<?php foreach ($social_links as $social) :
		if ($social['link'] && $social['icon']) :
	?>
	<li>
		<a href="<?= $social['link']['url'] ?>" <?= $social['link']['target'] ? 'target="_blank"' : '' ?>>
			<em class="<?= $social['icon'] ?>"></em>
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