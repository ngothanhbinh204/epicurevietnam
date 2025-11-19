<?php
$footer_logo = get_field('footer_logo', 'options');
if ($footer_logo) :
?>
<div class="logo">
	<a href="<?= home_url('/') ?>">
		<?= get_image_attrachment($footer_logo) ?>
	</a>
</div>
<?php endif; ?>