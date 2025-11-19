<?php
if (has_nav_menu('footer_menu')) :
	wp_nav_menu([
		'theme_location' => 'footer_menu',
		'container' => false,
		'menu_class' => 'menu-list',
		'fallback_cb' => false
	]);
else :
?>
<ul class="menu-list">
	<li><a href="<?= home_url('/about-us') ?>">About us</a></li>
	<li><a href="<?= home_url('/contact-us') ?>">Contact us</a></li>
	<li><a href="<?= home_url('/terms-conditions') ?>">Terms & conditions</a></li>
	<li><a href="<?= home_url('/privacy-policy') ?>">Privacy policy</a></li>
</ul>
<?php endif; ?>