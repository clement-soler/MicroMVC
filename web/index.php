<?php
// Requires
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/models/article.class.php';

$app = new Silex\Application();

require __DIR__.'/../app/config/config.php';
require __DIR__.'/../app/app.php';
require __DIR__.'/../app/routes.php';

$app->run();

