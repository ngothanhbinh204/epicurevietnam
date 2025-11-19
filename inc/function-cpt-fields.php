<?php
// ACF Field Groups for Custom Post Types

// Video CPT Fields
function add_video_fields()
{
    acf_add_local_field_group([
        'key' => 'group_video_fields',
        'title' => 'Video Content Fields',
        'fields' => [
            [
                'key' => 'field_video_url',
                'label' => 'Video URL',
                'name' => 'video_url',
                'type' => 'url',
                'instructions' => 'YouTube, Vimeo or direct video link',
                'required' => 0,
            ],
            [
                'key' => 'field_video_file',
                'label' => 'Upload Video File',
                'name' => 'video_file',
                'type' => 'file',
                'instructions' => 'Upload video file directly (alternative to URL)',
                'return_format' => 'id',
                'mime_types' => 'mp4,mov,avi,wmv,flv,webm',
            ],
            [
                'key' => 'field_video_background_image',
                'label' => 'Video Background/Thumbnail',
                'name' => 'video_background_image',
                'type' => 'image',
                'instructions' => 'Background image or thumbnail for video',
                'return_format' => 'id',
                'preview_size' => 'medium',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'video',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ]);
}
add_action('acf/init', 'add_video_fields');
