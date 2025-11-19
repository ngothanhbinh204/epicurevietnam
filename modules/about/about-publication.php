<?php
$section_title = get_sub_field('section_title');
$publication_items = get_sub_field('publication_items');
$section_index = get_row_index();
?>
<section class="main-section" id="about-<?= $section_index ?>">
    <?php if (!empty($section_title)): ?>
    <h1 class="main-title dotted"><?= $section_title ?></h1>
    <?php endif; ?>
    <?php if (!empty($publication_items)): ?>
    <div class="about-list">
        <?php foreach ($publication_items as $item): ?>
        <div class="about-item">
            <?php if (!empty($item['item_title'])): ?>
            <h2 class="about-title"><?= $item['item_title'] ?></h2>
            <?php endif; ?>
            <div class="full-content">
                <?php if (!empty($item['images'])): ?>
                <div class="row">
                    <?php 
										$image_count = count($item['images']);
										if ($image_count == 1): ?>
                    <div class="col-12">
                        <?= get_image_attrachment($item['images'][0]['image']) ?>
                    </div>
                    <?php elseif ($image_count == 2): ?>
                    <div class="col-lg-6">
                        <?= get_image_attrachment($item['images'][0]['image']) ?>
                    </div>
                    <div class="col-lg-6">
                        <?= get_image_attrachment($item['images'][1]['image']) ?>
                    </div>
                    <?php elseif ($image_count >= 3): ?>
                    <div class="col-lg-7">
                        <?= get_image_attrachment($item['images'][0]['image']) ?>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-12">
                                <?= get_image_attrachment($item['images'][1]['image']) ?>
                            </div>
                            <div class="col-12">
                                <?= get_image_attrachment($item['images'][2]['image']) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($item['content'])): ?>
                <?= $item['content'] ?>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</section>