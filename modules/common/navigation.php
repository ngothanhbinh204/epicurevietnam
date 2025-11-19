<?php
/**
 * Navigation menu template with multilevel support
 * Usage: get_template_part('modules/common/navigation', '', array('menu_location' => 'header-menu', 'menu_class' => 'main-menu'));
 */

$menu_location = isset($args['menu_location']) ? $args['menu_location'] : 'header-menu';
$menu_class = isset($args['menu_class']) ? $args['menu_class'] : 'main-navigation';
$container_class = isset($args['container_class']) ? $args['container_class'] : '';

if (has_nav_menu($menu_location)) :
?>
<nav class="<?= esc_attr($container_class) ?>">
    <?php
    wp_nav_menu(array(
        'theme_location' => $menu_location,
        'container' => false,
        'menu_class' => $menu_class,
        'walker' => new Custom_Menu_Walker(),
        'depth' => 0, // Allow unlimited depth
        'fallback_cb' => false
    ));
    ?>
</nav>
<?php endif; ?>