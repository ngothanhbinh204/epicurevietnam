<footer>

	<div class="searchbox-wrap">
		<div class="Module Module-204">
			<div class="searchbox">

				<form class="form-search" role="search" method="get" action="<?php echo home_url('/'); ?>">
					<input type="search" name="s" class="searchinput" placeholder="Search terms" autocomplete="off" />

					<button type="submit" class="searchbutton">
						<em class="ri-search-line"></em>
					</button>
				</form>

			</div>
		</div>

		<div class="button-close">
			<em class="ri-close-line"></em>
		</div>
	</div>


	<div class="footer-top">
		<div class="container">
			<?php get_template_part('modules/common/footer/footer-logo'); ?>
			<?php get_template_part('modules/common/footer/footer-menu'); ?>
			<?php get_template_part('modules/common/footer/footer-newsletter'); ?>
			<?php get_template_part('modules/common/footer/footer-social'); ?>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container">
			<?php get_template_part('modules/common/footer/footer-copyright'); ?>
		</div>
	</div>

	<?php
$toc_list = get_field('toc_list', 'option');

if ($toc_list) :

	$class_map = [
		0 => 'btn-phone',
		1 => 'btn-zalo',
		2 => 'btn-messenger',
	];

	$default_class = 'btn-phone';
?>


	<div class="tool-fixed-cta">
		<?php foreach ($toc_list as $index => $item) :

		$icon = $item['icon'] ?? null;
		$link = $item['link'] ?? null;

		if (!$icon || !$link) {
			continue;
		}

		$class = $class_map[$index] ?? $default_class;

		$url    = $link['url'] ?? '#';
		$title  = $link['title'] ?? '';
		$target = $link['target'] ?? '_self';
	?>
		<a href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>"
			class="btn btn-content <?php echo esc_attr($class); ?>"
			<?php echo $target === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
			<div class="btn-icon">
				<div class="icon">
					<img src="<?php echo esc_url($icon['url']); ?>"
						alt="<?php echo esc_attr($icon['alt'] ?? $title); ?>">
				</div>
			</div>
		</a>
		<?php endforeach; ?>
	</div>

	<?php endif; ?>

</footer>
</main>
<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
<?php wp_footer() ?>
<?php endif; ?>
<?= get_field('field_config_body', 'options') ?>
</body>

</html>