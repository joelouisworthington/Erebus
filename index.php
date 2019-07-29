<?php
global $wp_query;

use Timber\Timber;

require_once "controllers/IndexController.php";

$page = IndexController::indexAction();

Timber::render($page['templates'], $page['context']);
