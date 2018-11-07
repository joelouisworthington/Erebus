<?php

use Timber\Timber;

while (have_posts()) : the_post();
    $context = Timber::get_context();
    $post = new \Timber\Post();
    $context['post'] = $post;

    Timber::render(array('views/page.twig'), $context);
endwhile; // End of the loop.