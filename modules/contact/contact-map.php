<?php
$map_iframe = get_sub_field('map_iframe');
?>
<?php if (!empty($map_iframe)): ?>
<div class="col-12">
    <div class="main-maps">
        <?= $map_iframe ?>
    </div>
</div>
<?php endif; ?>
