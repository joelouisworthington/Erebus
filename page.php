<?php

use Timber\Timber;

$context = Timber::get_context();
$post = new \Timber\Post();
$context['post'] = $post;

Timber::render(array('views/page.twig'), $context);