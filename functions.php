<?php

$fieldGroups = new \ACF\FieldGroups\Testimonials();
$fieldGroups->init();

// Todo: This is for test purposes - we would need a loader
$testimonials = new \ACF\Blocks\Testimonials();
$testimonials->init();

add_filter('allowed_block_types', 'my_function');

function my_function($allowed_block_types)
{
    $blocks = acf_get_blocks();

    $allowed = [
        'core/paragraph',
        'core/heading',
        'core/image'
    ];

    foreach ($blocks as $block) {
        if (in_array(get_post_type(), $block['allowedPostTypes'])) {
            $allowed[] = $block['name'];
        }

        // This might have to be AJAX.. As you can switch and it updates - maybe steal this from ACF?
        if (in_array(get_page_template(), $block['allowedTemplates'])) {
            // ...
        }

        // Again this might be an issue look to ACF - get_page_type is NOT a real function
        if (in_array(get_page_type(), $block['allowedPages'])) {
            // ...
        }
    }

    return $allowed;
}