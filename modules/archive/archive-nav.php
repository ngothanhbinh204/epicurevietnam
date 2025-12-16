<?php
// Get current post type
$post_type = get_query_var('archive_post_type') ? get_query_var('archive_post_type') : get_post_type();

// Get taxonomies for this post type
$taxonomies = get_object_taxonomies($post_type, 'objects');

if (!empty($taxonomies)) :
    foreach ($taxonomies as $taxonomy) :
        // Skip built-in taxonomies and tag taxonomies
        if (in_array($taxonomy->name, ['post_tag', 'post_format'])) continue;
        
        // Skip tag taxonomies to avoid duplicate breadcrumbs
        $tag_taxonomies = ['experiences_tag', 'shopping_tag', 'events_tag', 'vouchers_tag', 'translation_priority'];
        if (in_array($taxonomy->name, $tag_taxonomies)) continue;
        
        // Get terms for this taxonomy
        $terms = get_terms(array(
            'taxonomy' => $taxonomy->name,
            'hide_empty' => true,
        ));
        
        if (!empty($terms) && !is_wp_error($terms)) :
            $current_term = get_queried_object();
            $current_term_id = ($current_term && isset($current_term->term_id)) ? $current_term->term_id : 0;
?>
<?php get_template_part('modules/common/breadcrumb'); ?>

<!-- <ul class="about-nav">
    <?php foreach ($terms as $term) : 
        $term_link = get_term_link($term);
        $active_class = ($current_term_id == $term->term_id) ? ' active' : '';
    ?>
    <li class="<?= $active_class ?>">
        <a href="<?= esc_url($term_link) ?>"><?= esc_html($term->name) ?></a>
    </li>
    <?php endforeach; ?>
</ul> -->

<div class="about-nav-container">

    <button class="nav-btn nav-prev cat-nav-arrow cat-nav-prev">
        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 1L1 7L7 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"></path>
        </svg>
    </button>

    <div class="about-nav-gradient left"></div>
    <div class="about-nav-gradient right"></div>

    <ul class="about-nav">
        <?php foreach ($terms as $term) : 
        $term_link = get_term_link($term);
        $active_class = ($current_term_id == $term->term_id) ? ' active' : '';
    ?>
        <li class="<?= $active_class ?>">
            <a href="<?= esc_url($term_link) ?>"><?= esc_html($term->name) ?></a>
        </li>
        <?php endforeach; ?>
    </ul>

    <button class="nav-btn nav-next cat-nav-arrow cat-nav-next">
        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round"></path>
        </svg>
    </button>

</div>

<?php
        endif;
    endforeach;
endif;
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const container = document.querySelector(".about-nav-container");
    const nav = container.querySelector(".about-nav");
    const btnPrev = container.querySelector(".nav-prev");
    const btnNext = container.querySelector(".nav-next");
    const gradientLeft = container.querySelector(".about-nav-gradient.left");
    const gradientRight = container.querySelector(".about-nav-gradient.right");

    if (!nav) return;

    function checkOverflow() {
        const overflowing = nav.scrollWidth > nav.clientWidth;

        if (overflowing) {
            container.classList.add("show-nav-ui");
        } else {
            container.classList.remove("show-nav-ui");
        }

        // Ẩn/hiện nút
        btnPrev.style.opacity = nav.scrollLeft <= 0 ? "0.3" : "1";
        btnNext.style.opacity = nav.scrollLeft + nav.clientWidth >= nav.scrollWidth - 5 ? "0.3" : "1";

        // Gradient
        gradientLeft.style.opacity = nav.scrollLeft <= 0 ? "0" : "1";
        gradientRight.style.opacity =
            nav.scrollLeft + nav.clientWidth >= nav.scrollWidth - 5 ? "0" : "1";
    }

    // Nút next/prev
    btnNext.addEventListener("click", () => {
        nav.scrollBy({
            left: 250,
            behavior: "smooth"
        });
    });

    btnPrev.addEventListener("click", () => {
        nav.scrollBy({
            left: -250,
            behavior: "smooth"
        });
    });

    // Cập nhật UI khi scroll
    nav.addEventListener("scroll", checkOverflow);

    nav.addEventListener("mouseleave", () => {
        isDown = false;
    });

    nav.addEventListener("mouseup", () => {
        isDown = false;
    });

    nav.addEventListener("mousemove", (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - nav.offsetLeft;
        const walk = (x - startX) * 1; // tốc độ kéo
        nav.scrollLeft = scrollLeft - walk;
    });

    // Resize window → update lại
    window.addEventListener("resize", checkOverflow);

    // Chạy lần đầu
    checkOverflow();
});
</script>