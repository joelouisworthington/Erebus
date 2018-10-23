<?php

namespace ACF;

/**
 * Interface BlockInterface
 * @package ACF
 */
interface BlockInterface
{
    /**
     * Initialize the block
     *
     * @return mixed
     */
    public function init();

    /**
     * Register the block with ACF
     *
     * @return mixed
     */
    public function registerBlock();

    /**
     * Render the block using HTML/Twig
     *
     * @param $block
     * @return mixed
     */
    public function renderBlock($block);
}