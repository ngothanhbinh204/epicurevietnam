<?php
$newsletter_title = get_field('newsletter_title', 'options') ?: 'newsletters';
$newsletter_subtitle = get_field('newsletter_subtitle', 'options') ?: 'Sign up for our newsletters to get all our top stories delivered.';
$newsletter_placeholder = get_field('newsletter_placeholder', 'options') ?: 'Enter email';
$newsletter_button = get_field('newsletter_button', 'options') ?: 'SIGN UP';
$form_shortcode = get_field('newsletter_shortcode', 'options');

?>
<div class="main-news-letter">
    <p class="title"><?= $newsletter_title ?></p>
    <p class="sub-title"><?= $newsletter_subtitle ?></p>
    <?= do_shortcode($form_shortcode) ?>
</div>