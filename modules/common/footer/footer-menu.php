<?php
if (has_nav_menu('footer_menu')) :
	wp_nav_menu([
		'theme_location' => 'footer_menu',
		'container' => false,
		'menu_class' => 'menu-list',
		'fallback_cb' => false
	]);
?>

<?php endif; ?>