<?php
function log_dump($data)
{
	ob_start();
	var_dump($data);
	$dump = ob_get_clean();

	$highlighted = highlight_string("<?php\n" . $dump . "\n?>", true);

$formatted = '
<pre>' . substr($highlighted, 27, -8) . '</pre>';

$custom_css = 'pre {position: static;
background: #ffffff80;
// max-height: 50vh;
width: 100vw;
}
pre::-webkit-scrollbar{
width: 1rem;}';

$formatted_css = '<style>
' . $custom_css . '
</style>';
echo ($formatted_css . $formatted);
}

function empty_content($str)
{
return trim(str_replace('&nbsp;', '', strip_tags($str, '<img>'))) == '';
}

/**
* AJAX Product Filter Handler
*/
add_action('wp_ajax_filter_products', 'ajax_filter_products');
add_action('wp_ajax_nopriv_filter_products', 'ajax_filter_products');

function ajax_filter_products() {
// Verify nonce
if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'product_filter_nonce')) {
wp_send_json_error('Invalid nonce');
exit;
}

$paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
$category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
$attributes = isset($_POST['attributes']) ? $_POST['attributes'] : array();
$orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : 'date';

// Build query args
$args = array(
'post_type' => 'product',
'posts_per_page' => 12,
'paged' => $paged,
'post_status' => 'publish'
);

// Tax query array
$tax_query = array('relation' => 'AND');

// Category filter
if (!empty($category)) {
$tax_query[] = array(
'taxonomy' => 'product_category',
'field' => 'slug',
'terms' => $category
);
}

// Attribute filters
if (!empty($attributes) && is_array($attributes)) {
foreach ($attributes as $attr_id) {
$attr_id = intval($attr_id);
if ($attr_id > 0) {
$tax_query[] = array(
'taxonomy' => 'product_attribute',
'field' => 'term_id',
'terms' => $attr_id
);
}
}
}

if (count($tax_query) > 1) {
$args['tax_query'] = $tax_query;
}

// Sorting
switch ($orderby) {
case 'price_asc':
$args['meta_key'] = 'product_price';
$args['orderby'] = 'meta_value_num';
$args['order'] = 'ASC';
break;
case 'price_desc':
$args['meta_key'] = 'product_price';
$args['orderby'] = 'meta_value_num';
$args['order'] = 'DESC';
break;
case 'title':
// Best-selling products - sort by featured products first
$args['meta_key'] = 'product_is_featured';
$args['orderby'] = array(
'meta_value' => 'DESC',
'date' => 'DESC'
);
break;
default:
$args['orderby'] = 'date';
$args['order'] = 'DESC';
}

// Run query
$query = new WP_Query($args);

// Generate HTML
ob_start();

if ($query->have_posts()) {
while ($query->have_posts()) {
$query->the_post();
get_template_part('modules/product/product-item');
}
} else {
echo '<div class="no-products-found">
    <p>Không tìm thấy sản phẩm nào phù hợp.</p>
</div>';
}

$products_html = ob_get_clean();

// Generate pagination HTML
ob_start();
if ($query->max_num_pages > 1) {
$temp_query = $GLOBALS['wp_query'];
$GLOBALS['wp_query'] = $query;
if (function_exists('custom_pagination')) {
custom_pagination(4);
}
$GLOBALS['wp_query'] = $temp_query;
}
$pagination_html = ob_get_clean();

wp_reset_postdata();

wp_send_json_success(array(
'products' => $products_html,
'pagination' => $pagination_html,
'found_posts' => $query->found_posts,
'max_pages' => $query->max_num_pages,
'current_page' => $paged
));
}

/**
* Enqueue Product Filter Script
*/
add_action('wp_enqueue_scripts', 'enqueue_product_filter_scripts');

function enqueue_product_filter_scripts() {
if (is_page_template('templates/page-product.php')) {
wp_enqueue_script(
'product-filter',
get_template_directory_uri() . '/js/product-filter.js',
array('jquery'),
'1.0.0',
true
);

wp_localize_script('product-filter', 'productFilterAjax', array(
'ajaxurl' => admin_url('admin-ajax.php'),
'nonce' => wp_create_nonce('product_filter_nonce')
));
}
}

?>