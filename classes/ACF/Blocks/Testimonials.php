<?php

namespace ACF\Blocks;

use NanoSoup\Nemesis\ACF\Block;
use NanoSoup\Nemesis\ACF\BlockInterface;
use Timber\Timber;

/**
 * Class Testimonials
 * @package ACF\Blocks
 */
class Testimonials extends Block implements BlockInterface
{
    /**
     * @return mixed|void
     */
    public function init()
    {
        add_action('init', [$this, 'registerBlock']);
    }

    /**
     * @return mixed|void
     */
    public function registerBlock()
    {
        $this->newBlock('testimonial', 'Testimonial', [$this, 'renderBlock']);
    }

    /**
     * @param $block
     * @return mixed|void
     */
    public function renderBlock($block)
    {
        $vars['block'] = $block;
        $vars['fields'] = get_fields();

        $vars['fields']['avatar'] = new \Timber\Image($vars['fields']['avatar']);

        Timber::render( get_stylesheet_directory() . '/classes/ACF/Blocks/views/content-testimonials.twig', $vars );
    }
}