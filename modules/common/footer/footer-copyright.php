<?php
$copyright_text = get_field('copyright_text', 'options');
if ($copyright_text) :
	echo $copyright_text;
else :
?>
<p>Copyright <?= date('Y') ?> by Epicure Viet Nam. All right reserved. Designed by Canh Cam.</p>
<?php endif; ?>