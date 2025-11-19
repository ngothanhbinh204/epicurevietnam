<?php
$section_title = get_sub_field('section_title');
$readership_items = get_sub_field('readership_items');
$section_index = get_row_index();
?>

<section class="main-section" id="about-<?= $section_index ?>">
    <?php if (!empty($section_title)): ?>
    <h2 class="main-title dotted"><?= $section_title ?></h2>
    <?php endif; ?>
    <?php if (!empty($readership_items)): ?>
    <div class="about-list">
        <?php foreach ($readership_items as $item): ?>
        <div class="about-item">
            <?php if (!empty($item['item_title'])): ?>
            <h3 class="about-title"><?= $item['item_title'] ?></h3>
            <?php endif; ?>
            <?php if (!empty($item['content'])): ?>
            <div class="full-content">
                <?= $item['content'] ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>