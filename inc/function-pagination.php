<?php

/**
 * WordPress Bootstrap Pagination
 *
 * <?php echo wp_bootstrap_pagination(array('custom_query' => $the_query)) ?>
*
* Thêm tham số sau vào WP_Query
* $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
* 'paged' => $paged
*/
function wp_bootstrap_pagination($args = array())
{

$defaults = array(
'range' => 4,
'custom_query' => FALSE,
'previous_string' => __('Trước', 'text-domain'),
'next_string' => __('Sau', 'text-domain'),
'before_output' => '<div class="post-nav">
    <ul class="pager">',
        'after_output' => '</ul>
</div>'
);

$args = wp_parse_args(
$args,
apply_filters('wp_bootstrap_pagination_defaults', $defaults)
);

$args['range'] = (int) $args['range'] - 1;
if (!$args['custom_query'])
$args['custom_query'] = @$GLOBALS['wp_query'];
$count = (int) $args['custom_query']->max_num_pages;
$page = intval(get_query_var('paged'));
$ceil = ceil($args['range'] / 2);

if ($count <= 1) return FALSE; if (!$page) $page=1; if ($count> $args['range']) {
    if ($page <= $args['range']) { $min=1; $max=$args['range'] + 1; } elseif ($page>= ($count - $ceil)) {
        $min = $count - $args['range'];
        $max = $count;
        } elseif ($page >= $args['range'] && $page < ($count - $ceil)) { $min=$page - $ceil; $max=$page + $ceil; } }
            else { $min=1; $max=$count; } $echo='' ; $previous=intval($page) - 1;
            $previous=esc_attr(get_pagenum_link($previous)); $firstpage=esc_attr(get_pagenum_link(1)); if ($firstpage &&
            (1 !=$page)) $echo .='<li class="previous hidden"><a href="' . $firstpage . '">' . __('Đầu
            tiên', 'text-domain' ) . '</a></li>' ; if ($previous && (1 !=$page)) $echo .='<li class="hidden"><a href="'
            . $previous . '" title="' . __('Trước', 'text-domain' ) . '">' . $args['previous_string'] . '</a></li>' ; if
            (!empty($min) && !empty($max)) { for ($i=$min; $i <=$max; $i++) { if ($page==$i) { $echo
            .='<li class="active"><span class="active">' . str_pad((int)$i, 2, '0' , STR_PAD_LEFT) . '</span></li>' ; }
            else { $echo .=sprintf('<li><a href="%s">%002d</a></li>', esc_attr(get_pagenum_link($i)), $i);
            }
            }
            }
            $next = intval($page) + 1;
            $next = esc_attr(get_pagenum_link($next));
            if ($next && ($count != $page)) $echo .= '<li class="hidden"><a href="' . $next . '"
                    title="' . __('Kế tiếp', 'text-domain') . '">' . $args['next_string'] . '</a></li>';
            $lastpage = esc_attr(get_pagenum_link($count));
            if ($lastpage) {
            $echo .= '<li class="next hidden"><a href="' . $lastpage . '">' . __('Cuối cùng', 'text-domain') . '</a>
            </li>';
            }
            if (isset($echo)) echo $args['before_output'] . $echo . $args['after_output'];
            }




            function custom_pagination($range = 4) {
            // Truy cập biến toàn cục $wp_query
            global $wp_query;

            // Kiểm tra nếu không có hoặc chỉ có 1 trang, thì không cần phân trang
            if (!isset($wp_query->max_num_pages) || $wp_query->max_num_pages <= 1) { return; }
                $paged=get_query_var('paged') ? absint(get_query_var('paged')) : 1; $max_pages=intval($wp_query->
                max_num_pages);

                $start_page = max(1, $paged - floor($range / 2));

                // Trang kết thúc trong phạm vi hiển thị
                $end_page = min($max_pages, $start_page + $range - 1);

                // Điều chỉnh trang bắt đầu nếu chúng ta ở gần cuối
                if ($end_page - $start_page < $range - 1) { $start_page=max(1, $end_page - $range + 1); }
                    echo '<div class="modulepager">' ; echo '<ul class="pagination">' ; for ($i=$start_page; $i
                    <=$end_page; $i++) { if ($i==$paged) { echo '<li class="PagerCurrentPageCell active">' ;
                    echo '<span class="SelectedPage" title="Navigate to Page ' . $i . '">' . $i . '</span>' ;
                    echo '</li>' ; } else { echo '<li class="PagerOtherPageCells">' ;
                    echo '<a class="ModulePager" href="' . get_pagenum_link($i) . '" title="Navigate to Page ' . $i
                    . '">' . $i . '</a>' ; echo '</li>' ; } } if ($paged < $max_pages) {
                    echo '<li class="PagerOtherPageCells">' ; echo '<a class="ModulePager NextPage" href="' .
                    get_pagenum_link($paged + 1) . '" title="Next to Page ' . ($paged + 1) . '">›</a>' ; echo '</li>' ;
                    } { echo '<li class="PagerOtherPageCells">' ; echo '<a class="ModulePager LastPage" href="' .
                    get_pagenum_link($max_pages) . '" title="Navigate to Last Page">»</a>' ; echo '</li>' ; }
                    echo '</ul>' ; echo '</div>' ; }