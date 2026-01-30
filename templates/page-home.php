<?php /*
Template name: Page - Home
*/ ?>
<?= get_header() ?>

<style>

</style>
<h1 class="hidden">
	<?php echo get_bloginfo('name') ?>
</h1>
<?php get_template_part('modules/common/banner')?>
<section class="main-wrapper home-news">
	<div class="container">
		<?php
    if (have_rows('home_sections')) :
        while (have_rows('home_sections')) : the_row();
            $layout = get_row_layout();
            get_template_part('modules/home/home-' . $layout);
        endwhile;
    endif;
    ?>
	</div>
</section>

<?php
$link   = get_field('popup_video_link');
$poster = get_field('popup_video_poster');
$icon   = 'ri-close-line';

$video = get_field('popup_video_file') ?: get_field('popup_video_url');

if (!$video || !$link) return;

// Detect type
$is_file    = is_video_file($video);
$youtube_id = get_youtube_id($video);
?>



<div id="popup-container" class="popup-video-container">
	<div id="popup-video" class="popup-video">

		<a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target'] ?: '_self'); ?>"
			rel="noopener noreferrer">

			<?php if ($is_file) : ?>

			<video autoplay loop muted playsinline <?php if ($poster) : ?> poster="<?php echo esc_url($poster); ?>"
				<?php endif; ?>>
				<source src="<?php echo esc_url($video); ?>" type="video/mp4">
			</video>

			<?php elseif ($youtube_id) : ?>

			<div class="iframe-wrapper">
				<iframe
					src="https://www.youtube.com/embed/<?php echo esc_attr($youtube_id); ?>?autoplay=1&mute=1&loop=1&playlist=<?php echo esc_attr($youtube_id); ?>"
					frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
				</iframe>
			</div>

			<?php endif; ?>

		</a>

		<div id="close-popup">
			<em class="<?php echo esc_attr($icon); ?>"></em>
		</div>

	</div>
</div>


<?= get_footer() ?>