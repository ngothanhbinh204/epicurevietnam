<?php
$main_title = get_sub_field('main_title');
$description = get_sub_field('description');
$social_links = get_sub_field('social_links');
$form_shortcode = get_sub_field('form_shortcode');
$sidebar_title = get_sub_field('sidebar_title');
$contact_info_items = get_sub_field('contact_info_items');
?>
<div class="row">
    <div class="col-lg-8">
        <?php if (!empty($main_title)): ?>
        <h1 class="main-title dotted"><?= $main_title ?></h1>
        <?php endif; ?>

        <?php if (!empty($description)): ?>
        <div class="des">
            <?= $description ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($social_links)): ?>
        <ul class="social-list no-pad">
            <?php foreach ($social_links as $social): 
                $has_icon = !empty($social['icon']) || !empty($social['icon_image']);
                if (!empty($social['url']) && $has_icon):
            ?>
            <li>
                <a href="<?= esc_url($social['url']) ?>">
                    <?php if (!empty($social['icon'])) : ?>
                    <em class="<?= esc_attr($social['icon']) ?>"></em>
                    <?php elseif (!empty($social['icon_image'])) : ?>
                    <img src="<?= esc_url($social['icon_image']['url']) ?>"
                        alt="<?= esc_attr($social['icon_image']['alt'] ?: 'Social icon') ?>" class="social-icon-img">
                    <?php endif; ?>
                </a>
            </li>
            <?php endif; endforeach; ?>
        </ul>
        <?php endif; ?>

        <?php if (!empty($form_shortcode)): ?>
        <div class="main-form contact-form-wrapper">
            <?= do_shortcode($form_shortcode) ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="box-contact">
            <?php if (!empty($sidebar_title)): ?>
            <h2 class="main-title"><?= $sidebar_title ?></h2>
            <?php endif; ?>

            <?php if (!empty($contact_info_items)): ?>
            <div class="contact-list">
                <?php foreach ($contact_info_items as $item): ?>
                <div class="contact-item">
                    <?php if (!empty($item['icon'])): ?>
                    <div class="icon">
                        <em class="<?= esc_attr($item['icon']) ?>"></em>
                    </div>
                    <?php endif; ?>

                    <div class="content">
                        <?php if (!empty($item['title'])): ?>
                        <h3 class="title"><?= $item['title'] ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['content'])): 
                            $content = $item['content'];
                            $title_lower = strtolower($item['title'] ?? '');
                            
                            // Auto detect contact type and add appropriate links
                            if (strpos($title_lower, 'e-mail') !== false || strpos($title_lower, 'email') !== false) {
                                // Email - wrap each email in mailto link
                                $content = preg_replace_callback('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', function($matches) {
                                    return '<a href="mailto:' . $matches[1] . '">' . $matches[1] . '</a>';
                                }, strip_tags($content));
                            } elseif (strpos($title_lower, 'phone') !== false || strpos($title_lower, 'fax') !== false) {
                                // Phone/Fax - wrap numbers in tel links
                                $content = preg_replace_callback('/(\+?[\d\.\s\-]+)/', function($matches) {
                                    $number = $matches[1];
                                    $clean_number = preg_replace('/[^\d\+]/', '', $number);
                                    if (strlen($clean_number) >= 10) {
                                        return '<a href="tel:' . $clean_number . '">' . trim($number) . '</a>';
                                    }
                                    return $number;
                                }, strip_tags($content));
                            } elseif (strpos($title_lower, 'website') !== false) {
                                // Website - wrap URLs in external links
                                $content = preg_replace_callback('/(www\.[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/', function($matches) {
                                    $url = 'https://' . $matches[1];
                                    return '<a href="' . $url . '" target="_blank">' . $matches[1] . '</a>';
                                }, strip_tags($content));
                            } elseif (strpos($title_lower, 'address') !== false) {
                                // Address - wrap in address tag
                                $content = '<address>' . strip_tags($content, '<br><strong><em><b><i>') . '</address>';
                            } else {
                                $content = strip_tags($content, '<br><strong><em><b><i><a>');
                            }
                        ?>
                        <?php if (strpos($title_lower, 'website') !== false): ?>
                        <p class="website"><?= $content ?></p>
                        <?php else: ?>
                        <p><?= $content ?></p>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>