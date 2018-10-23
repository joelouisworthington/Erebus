<?php
namespace ACF;

/**
 * Class Block
 * @package ACF
 */
class Block
{
    /**
     * @param $name
     * @param $title
     * @param $callback
     * @param string $description
     * @param string $icon
     * @param string $category
     * @param array $keywords
     */
    public function newBlock($name, $title, $callback, $description = '', $icon = '', $category = '', $keywords = [])
    {
        // Register a testimonial ACF Block
        if (function_exists('acf_register_block')) {
            acf_register_block([
                'name' => $name,
                'title' => __($title),
                'description' => __($description),
                'render_callback' => $callback,
                'category'			=> 'common',
                'icon'				=> 'admin-comments',
                'keywords'			=> array( 'testimonial', 'quote' ),
            ]);
        }
    }
}