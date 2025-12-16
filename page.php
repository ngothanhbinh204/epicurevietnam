<?php get_header() ?>
<div id="ctl00_divCenter" class="middle-fullwidth">

    <?php get_template_part('modules/common/banner')?>
    <?php get_template_part('modules/common/breadcrumb')?>

    <section class="om-whaton main-section">
        <div class="container">
            <div class="Module Module-202">
                <div class="ModuleContent">
                    <h1 class="main-title dotted">
                        <?php the_title() ?>
                    </h1>
                    <div class="row box-whaton-top">
                    </div>
                    <div class="banner-full-append">
                        <div class="banner-full Module Module-203">
                            <div class="ModuleContent">
                                <div class="om-events-detail">
                                    <div class="box-events-detail">
                                        <div class="full-content">
                                            <?php
                                            while (have_posts()) : the_post();
                                                the_content();
                                            endwhile;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>
<?php get_footer() ?>