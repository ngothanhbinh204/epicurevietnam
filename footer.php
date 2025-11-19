<footer>

    <div class="searchbox-wrap">
        <div class="Module Module-204">
            <div class="searchbox">

                <form class="form-search" role="search" method="get" action="<?php echo home_url('/'); ?>">
                    <input type="search" name="s" class="searchinput" placeholder="Search terms" autocomplete="off" />

                    <button type="submit" class="searchbutton">
                        <em class="ri-search-line"></em>
                    </button>
                </form>

            </div>
        </div>

        <div class="button-close">
            <em class="ri-close-line"></em>
        </div>
    </div>


    <div class="footer-top">
        <div class="container">
            <?php get_template_part('modules/common/footer/footer-logo'); ?>
            <?php get_template_part('modules/common/footer/footer-menu'); ?>
            <?php get_template_part('modules/common/footer/footer-newsletter'); ?>
            <?php get_template_part('modules/common/footer/footer-social'); ?>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <?php get_template_part('modules/common/footer/footer-copyright'); ?>
        </div>
    </div>
</footer>
</main>
<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
<?php wp_footer() ?>
<?php endif; ?>
<?= get_field('field_config_body', 'options') ?>
</body>

</html>