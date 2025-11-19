<?php
$banner_image = get_sub_field('banner_image');
$title = get_sub_field('title');
$nav_items = [];
$about_sections = get_field('about_sections');

if ($about_sections) :
    $index = 1;
    foreach ($about_sections as $section) :
        $layout = $section['acf_fc_layout'];
        $section_title = '';
        
        switch ($layout) {
            case 'publication':
                $section_title = $section['section_title'] ?? 'Our Publication';
                break;
            case 'team':
                $section_title = $section['section_title'] ?? 'Our Team';
                break;
            case 'readership':
                $section_title = $section['section_title'] ?? 'Readership & Distribution';
                break;
            case 'contact':
                $section_title = $section['title'] ?? 'Contact Us';
                break;
        }
        
        if (!empty($section_title)) {
            $nav_items[] = [
                'title' => $section_title,
                'id' => 'about-' . $index
            ];
        }
        
        $index++;
    endforeach;
endif;
?>
<?php get_template_part('modules/common/breadcrumb'); ?>

<?php if (!empty($nav_items)): ?>
<div class="main-nav-mb">
    <div class="container">
        <div class="toggle">
            <p class="category">Danh mục</p><em class="lnr lnr-chevron-down"></em>
        </div>
        <ul class="about-nav">
            <?php foreach ($nav_items as $item): ?>
            <li><a href="#<?= $item['id'] ?>"><?= $item['title'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endif; ?>