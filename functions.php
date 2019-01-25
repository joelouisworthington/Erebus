<?php

add_filter('allowed_block_types', 'allowedBlocks');

function allowedBlocks($allowed_block_types)
{
    $blocks = acf_get_block_types();

    $allowed = [
        'core/paragraph',
        'core/heading',
        'core/image'
    ];

    foreach ($blocks as $block) {
        if (in_array(get_post_type(), $block['allowedPostTypes'])) {
            $allowed[] = $block['name'];
        }
    }

    return $allowed;
}