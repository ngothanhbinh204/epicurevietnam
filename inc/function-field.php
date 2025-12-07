<?php
// Custom field class for page
function add_field_custom_class_body()
{
	acf_add_local_field_group(array(
		'key' => 'class_body',
		'title' => 'Body: Add Class',
		'fields' => array(),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
				),
			),
		),
	));
	acf_add_local_field(array(
		'key' => 'add_class_body',
		'label' => 'Add class body',
		'name' => 'Add class body',
		'type' => 'text',
		'parent' => 'class_body',
	));
}
add_action('acf/init', 'add_field_custom_class_body');

//

function add_field_select_banner()
{
	acf_add_local_field_group(array(
		'key' => 'select_banner',
		'title' => 'Banner: Select Page',
		'fields' => array(),
		'location' => array(
			// Pages
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				),
			),
			// Video Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'video_category',
				),
			),
			// Shopping Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'shopping_category',
				),
			),
			// Experiences Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'experiences_category',
				),
			),
			// Events Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'events_category',
				),
			),
			// Vouchers Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'vouchers_category',
				),
			),
			// Product Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_category',
				),
			),
			// Post Category
			array(
				array(
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'category',
				),
			),
		),
	));
	acf_add_local_field(array(
		'key' => 'banner_select_page',
		'label' => 'Chọn banner hiển thị',
		'name' => 'Chọn banner hiển thị',
		'type' => 'post_object',
		'post_type' => 'banner',
		'multiple' => 1,
		'parent' => 'select_banner',
	));
}
add_action('acf/init', 'add_field_select_banner');

function add_theme_config_options()
{
	// Add the field group
	acf_add_local_field_group(array(
		'key' => 'group_theme_config',
		'title' => 'Theme Configuration',
		'fields' => array(
			// Config Tab
			array(
				'key' => 'tab_config',
				'label' => 'Config',
				'name' => 'tab_config',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_config_head',
				'label' => 'Config Head',
				'name' => 'config_head',
				'type' => 'textarea',
				'instructions' => 'Add custom code for header (CSS, meta tags, etc)',
				'required' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 4,
				'new_lines' => '',
			),
			array(
				'key' => 'field_config_body',
				'label' => 'Config Body',
				'name' => 'config_body',
				'type' => 'textarea',
				'instructions' => 'Add custom code for body (JS, tracking code, etc)',
				'required' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 4,
				'new_lines' => '',
			),
			// The Great Read Tab
			array(
				'key' => 'tab_the_great_read',
				'label' => 'The Great Read',
				'name' => 'tab_the_great_read',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_the_great_read',
				'label' => 'The Great Read Posts',
				'name' => 'the_great_read',
				'type' => 'post_object',
				'instructions' => 'Chọn các bài viết để hiển thị trong "The Great Read" sidebar',
				'post_type' => array('post', 'events', 'experiences', 'shopping', 'vouchers', 'video'),
				'multiple' => 1,
				'return_format' => 'object',
				'ui' => 1,
			),
			// Other Settings Tab
			array(
				'key' => 'tab_other_settings',
				'label' => 'Other Settings',
				'name' => 'tab_other_settings',
				'type' => 'tab',
				'placement' => 'top',
			),
			// Reserved for future settings
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'theme-settings',
				),
			),
		),
		'menu_order' => 999,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));
}
add_action('acf/init', 'add_theme_config_options');

// Header Settings Fields
function add_header_settings_fields()
{
	acf_add_local_field_group(array(
		'key' => 'group_header_settings',
		'title' => 'Header Settings',
		'fields' => array(
			// Header Top Section
			array(
				'key' => 'tab_header_top',
				'label' => 'Header Top',
				'name' => 'tab_header_top',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_header_top_logo',
				'label' => 'Logo Header Top',
				'name' => 'header_top_logo',
				'type' => 'image',
				'instructions' => 'Logo hiển thị ở phần header top',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array(
				'key' => 'field_header_banner_image',
				'label' => 'Header Banner Image',
				'name' => 'header_banner_image',
				'type' => 'image',
				'instructions' => 'Banner image hiển thị bên phải header top',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array(
				'key' => 'field_header_banner_link',
				'label' => 'Header Banner Link',
				'name' => 'header_banner_link',
				'type' => 'link',
				'instructions' => 'Link cho banner header',
				'return_format' => 'array',
			),
			// Header Main Section
			array(
				'key' => 'tab_header_main',
				'label' => 'Header Main',
				'name' => 'tab_header_main',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_header_main_logo',
				'label' => 'Logo Header Main',
				'name' => 'header_main_logo',
				'type' => 'image',
				'instructions' => 'Logo chính hiển thị ở header main (logo trắng)',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array(
				'key' => 'field_search_placeholder',
				'label' => 'Search Placeholder',
				'name' => 'search_placeholder',
				'type' => 'text',
				'instructions' => 'Placeholder text cho ô tìm kiếm',
				'default_value' => 'Tìm kiếm...',
			),
			array(
				'key' => 'field_show_language_switcher',
				'label' => 'Hiển thị Language Switcher',
				'name' => 'show_language_switcher',
				'type' => 'true_false',
				'instructions' => 'Bật/tắt hiển thị switcher ngôn ngữ',
				'default_value' => 1,
				'ui' => 1,
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'header-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
	));
}
add_action('acf/init', 'add_header_settings_fields');

// Footer Settings Fields
function add_footer_settings_fields()
{
	acf_add_local_field_group(array(
		'key' => 'group_footer_settings',
		'title' => 'Footer Settings',
		'fields' => array(
			// Footer Logo
			array(
				'key' => 'tab_footer_general',
				'label' => 'General',
				'name' => 'tab_footer_general',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_footer_logo',
				'label' => 'Footer Logo',
				'name' => 'footer_logo',
				'type' => 'image',
				'instructions' => 'Logo hiển thị trong footer',
				'return_format' => 'id',
				'preview_size' => 'medium',
				'library' => 'all',
			),
			array(
				'key' => 'field_copyright_text',
				'label' => 'Copyright Text',
				'name' => 'copyright_text',
				'type' => 'textarea',
				'instructions' => 'Văn bản copyright (để trống sẽ sử dụng mặc định)',
				'rows' => 2,
				'new_lines' => 'br',
			),
			// Newsletter Section
			array(
				'key' => 'tab_newsletter',
				'label' => 'Newsletter',
				'name' => 'tab_newsletter',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_newsletter_title',
				'label' => 'Newsletter Title',
				'name' => 'newsletter_title',
				'type' => 'text',
				'instructions' => 'Tiêu đề newsletter',
				'default_value' => 'newsletters',
			),
			array(
				'key' => 'field_newsletter_subtitle',
				'label' => 'Newsletter Subtitle',
				'name' => 'newsletter_subtitle',
				'type' => 'textarea',
				'instructions' => 'Mô tả newsletter',
				'rows' => 3,
				'default_value' => 'Sign up for our newsletters to get all our top stories delivered.',
			),
			array(
				'key' => 'field_newsletter_shortcode',
				'label' => 'Newsletter Shortcode',
				'name' => 'newsletter_shortcode',
				'type' => 'text',
				'instructions' => 'Shortcode newsletter',
				'default_value' => '',
			),

			array(
				'key' => 'field_newsletter_placeholder',
				'label' => 'Email Placeholder',
				'name' => 'newsletter_placeholder',
				'type' => 'text',
				'instructions' => 'Placeholder cho ô email',
				'default_value' => 'Enter email',
			),
			array(
				'key' => 'field_newsletter_button',
				'label' => 'Button Text',
				'name' => 'newsletter_button',
				'type' => 'text',
				'instructions' => 'Text nút đăng ký',
				'default_value' => 'SIGN UP',
			),
			// Social Links Section
			array(
				'key' => 'tab_social',
				'label' => 'Social Links',
				'name' => 'tab_social',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_social_links',
				'label' => 'Social Media Links',
				'name' => 'social_links',
				'type' => 'repeater',
				'instructions' => 'Thêm các liên kết mạng xã hội',
				'min' => 0,
				'max' => 10,
				'layout' => 'table',
				'button_label' => 'Thêm Social Link',
				'sub_fields' => array(
					array(
						'key' => 'field_social_icon',
						'label' => 'Icon Class',
						'name' => 'icon',
						'type' => 'text',
						'instructions' => 'Nhập class icon (ví dụ: ri-facebook-fill)',
						'placeholder' => 'ri-facebook-fill',
					),
					array(
						'key' => 'field_social_icon_image',
						'label' => 'Icon Image',
						'name' => 'icon_image',
						'type' => 'image',
						'instructions' => 'Hoặc chọn ảnh icon thay vì sử dụng class',
						'return_format' => 'array',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array(
						'key' => 'field_social_link',
						'label' => 'Link',
						'name' => 'link',
						'type' => 'link',
						'instructions' => 'URL của mạng xã hội',
						'required' => 1,
						'return_format' => 'array',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'footer-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
	));
}
add_action('acf/init', 'add_footer_settings_fields');

// Archive Banner Settings
function add_archive_banner_settings()
{
	acf_add_local_field_group(array(
		'key' => 'group_archive_banner_settings',
		'title' => 'Archive Banner Settings',
		'fields' => array(
			// Experiences Archive
			array(
				'key' => 'tab_experiences_banner',
				'label' => 'Trải nghiệm (Experiences)',
				'name' => 'tab_experiences_banner',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_experiences_banner',
				'label' => 'Banner cho Trải nghiệm',
				'name' => 'experiences_banner',
				'type' => 'post_object',
				'instructions' => 'Chọn banner hiển thị cho archive Trải nghiệm',
				'post_type' => array('banner'),
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
			),
			array(
				'key' => 'field_experiences_middle_banner',
				'label' => 'Banner Middle (Giữa trang)',
				'name' => 'experiences_middle_banner',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở giữa trang archive',
				'min' => 0,
				'max' => 5,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_experiences_middle_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_experiences_middle_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			array(
				'key' => 'field_experiences_sidebar_banners',
				'label' => 'Banner Sidebar (Cột bên phải)',
				'name' => 'experiences_sidebar_banners',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở sidebar bên phải',
				'min' => 0,
				'max' => 10,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_experiences_sidebar_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_experiences_sidebar_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			
			// Events Archive
			array(
				'key' => 'tab_events_banner',
				'label' => 'Sự kiện (Events)',
				'name' => 'tab_events_banner',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_events_banner',
				'label' => 'Banner cho Sự kiện',
				'name' => 'events_banner',
				'type' => 'post_object',
				'instructions' => 'Chọn banner hiển thị cho archive Sự kiện',
				'post_type' => array('banner'),
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
			),
			array(
				'key' => 'field_events_middle_banner',
				'label' => 'Banner Middle (Giữa trang)',
				'name' => 'events_middle_banner',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở giữa trang archive',
				'min' => 0,
				'max' => 5,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_events_middle_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_events_middle_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			array(
				'key' => 'field_events_sidebar_banners',
				'label' => 'Banner Sidebar (Cột bên phải)',
				'name' => 'events_sidebar_banners',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở sidebar bên phải',
				'min' => 0,
				'max' => 10,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_events_sidebar_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_events_sidebar_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			
			// Vouchers Archive
			array(
				'key' => 'tab_vouchers_banner',
				'label' => 'Ưu đãi (Vouchers)',
				'name' => 'tab_vouchers_banner',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_vouchers_banner',
				'label' => 'Banner cho Ưu đãi',
				'name' => 'vouchers_banner',
				'type' => 'post_object',
				'instructions' => 'Chọn banner hiển thị cho archive Ưu đãi',
				'post_type' => array('banner'),
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
			),
			array(
				'key' => 'field_vouchers_middle_banner',
				'label' => 'Banner Middle (Giữa trang)',
				'name' => 'vouchers_middle_banner',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở giữa trang archive',
				'min' => 0,
				'max' => 5,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_vouchers_middle_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_vouchers_middle_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			array(
				'key' => 'field_vouchers_sidebar_banners',
				'label' => 'Banner Sidebar (Cột bên phải)',
				'name' => 'vouchers_sidebar_banners',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở sidebar bên phải',
				'min' => 0,
				'max' => 10,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_vouchers_sidebar_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_vouchers_sidebar_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			
			// Shopping Archive
			array(
				'key' => 'tab_shopping_banner',
				'label' => 'Mua sắm (Shopping)',
				'name' => 'tab_shopping_banner',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_shopping_banner',
				'label' => 'Banner cho Mua sắm',
				'name' => 'shopping_banner',
				'type' => 'post_object',
				'instructions' => 'Chọn banner hiển thị cho archive Mua sắm',
				'post_type' => array('banner'),
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
			),
			array(
				'key' => 'field_shopping_middle_banner',
				'label' => 'Banner Middle (Giữa trang)',
				'name' => 'shopping_middle_banner',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở giữa trang archive',
				'min' => 0,
				'max' => 5,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_shopping_middle_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_shopping_middle_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			array(
				'key' => 'field_shopping_sidebar_banners',
				'label' => 'Banner Sidebar (Cột bên phải)',
				'name' => 'shopping_sidebar_banners',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở sidebar bên phải',
				'min' => 0,
				'max' => 10,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_shopping_sidebar_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_shopping_sidebar_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			
			// Video Archive
			array(
				'key' => 'tab_video_banner',
				'label' => 'Video',
				'name' => 'tab_video_banner',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_video_banner',
				'label' => 'Banner cho Video',
				'name' => 'video_banner',
				'type' => 'post_object',
				'instructions' => 'Chọn banner hiển thị cho archive Video',
				'post_type' => array('banner'),
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
			),
			array(
				'key' => 'field_video_middle_banner',
				'label' => 'Banner Middle (Giữa trang)',
				'name' => 'video_middle_banner',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở giữa trang archive',
				'min' => 0,
				'max' => 5,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_video_middle_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_video_middle_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			array(
				'key' => 'field_video_sidebar_banners',
				'label' => 'Banner Sidebar (Cột bên phải)',
				'name' => 'video_sidebar_banners',
				'type' => 'repeater',
				'instructions' => 'Banner hiển thị ở sidebar bên phải',
				'min' => 0,
				'max' => 10,
				'layout' => 'table',
				'button_label' => 'Thêm Banner',
				'sub_fields' => array(
					array(
						'key' => 'field_video_sidebar_banner_image',
						'label' => 'Ảnh Banner',
						'name' => 'banner_image',
						'type' => 'image',
						'return_format' => 'id',
						'preview_size' => 'medium',
					),
					array(
						'key' => 'field_video_sidebar_banner_link',
						'label' => 'Link',
						'name' => 'banner_link',
						'type' => 'url',
					),
				),
			),
			
			// Search Page Banner
			array(
				'key' => 'tab_search_banner',
				'label' => 'Trang tìm kiếm (Search)',
				'name' => 'tab_search_banner',
				'type' => 'tab',
				'placement' => 'top',
			),
			array(
				'key' => 'field_search_banner',
				'label' => 'Banner cho trang tìm kiếm',
				'name' => 'search_banner',
				'type' => 'post_object',
				'instructions' => 'Chọn banner hiển thị cho trang tìm kiếm',
				'post_type' => array('banner'),
				'allow_null' => 1,
				'multiple' => 0,
				'return_format' => 'object',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'archive-banner-settings',
				),
			),
		),
		'menu_order' => 10,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
	));
}
add_action('acf/init', 'add_archive_banner_settings');

// Add fields for single posts (contact information)
function add_single_post_contact_fields()
{
	acf_add_local_field_group(array(
		'key' => 'group_single_post_contact',
		'title' => 'Contact Information',
		'fields' => array(
			array(
				'key' => 'field_post_address',
				'label' => 'Address',
				'name' => 'address',
				'type' => 'textarea',
				'rows' => 2,
			),
			array(
				'key' => 'field_post_email',
				'label' => 'Email',
				'name' => 'email',
				'type' => 'email',
			),
			array(
				'key' => 'field_post_phone',
				'label' => 'Phone',
				'name' => 'phone',
				'type' => 'text',
				'instructions' => 'Nhập nhiều số điện thoại, phân cách bằng dấu phẩy',
			),
			array(
				'key' => 'field_post_fax',
				'label' => 'Fax',
				'name' => 'fax',
				'type' => 'text',
			),
			array(
				'key' => 'field_post_website',
				'label' => 'Website',
				'name' => 'website',
				'type' => 'url',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'events',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'experiences',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'shopping',
				),
			),
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'vouchers',
				),
			),
		),
		'menu_order' => 20,
		'position' => 'normal',
		'style' => 'default',
	));
}
add_action('acf/init', 'add_single_post_contact_fields');

// Add video URL field for video post type
function add_video_url_field()
{
	acf_add_local_field_group(array(
		'key' => 'group_video_url',
		'title' => 'Video Settings',
		'fields' => array(
			array(
				'key' => 'field_video_url',
				'label' => 'Video URL',
				'name' => 'video_url',
				'type' => 'url',
				'instructions' => 'Nhập URL video (YouTube, Vimeo, etc.) để hiển thị popup video',
				'placeholder' => 'https://www.youtube.com/watch?v=...',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'video',
				),
			),
		),
		'menu_order' => 5,
		'position' => 'side',
		'style' => 'default',
	));
}
add_action('acf/init', 'add_video_url_field');