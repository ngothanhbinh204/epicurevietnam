<?php
$title = get_sub_field('title');
$contact_items = get_sub_field('contact_items');
$section_index = get_row_index();
?>
<section class="main-section" id="about-<?= $section_index ?>">
    <div class="box-contact">
        <?php if (!empty($title)): ?>
        <h3 class="main-title"><?= $title ?></h3>
        <?php endif; ?>
        <?php if (!empty($contact_items)): ?>
        <ul class="contact-list no-pad">
            <?php foreach ($contact_items as $item): ?>
            <li>
                <p class="title">
                    <?php if (!empty($item['icon'])): ?>
                    <em class="<?= $item['icon'] ?>"></em>
                    <?php endif; ?>
                    <?php if (!empty($item['label'])): ?>
                    <span><?= $item['label'] ?></span>
                    <?php endif; ?>
                </p>
                <?php if (!empty($item['content'])): 
                    $content = strip_tags($item['content'], '<a><br><strong><em><b><i>');
                    $content = trim($content);
                    
                    $label_lower = strtolower($item['label'] ?? '');
                    $output = '';
                    
                    if (strpos($label_lower, 'email') !== false) {
                        $email = strip_tags($content);
                        $output = '<a href="mailto:' . $email . '">' . $email . '</a>';
                    } elseif (strpos($label_lower, 'phone') !== false || strpos($label_lower, 'fax') !== false) {
                        $output = preg_replace_callback('/(\+?[\d\.\s\-]+)/', function($matches) {
                            $number = $matches[1];
                            $clean_number = preg_replace('/[^\d\+]/', '', $number);
                            return '<a href="tel:' . $clean_number . '">' . trim($number) . '</a>';
                        }, strip_tags($content));
                    } elseif (strpos($label_lower, 'website') !== false) {
                        // Website - add external link
                        $url = strip_tags($content);
                        if (!preg_match('/^https?:\/\//', $url)) {
                            $url = 'https://' . $url;
                        }
                        $display_url = preg_replace('/^https?:\/\//', '', strip_tags($content));
                        $output = '<a href="' . $url . '" target="_blank">' . $display_url . '</a>';
                    } else {
                        $output = $content;
                    }
                ?>
                <p class="content"><?= $output ?></p>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</section>