<?php

session_start();

require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__ . '/env');
$dotenv->load();

$settings = require 'app/settings.php';

$app = new \Slim\App($settings);

require 'app/dependencies.php';

require 'app/routes/web.php';
require 'app/routes/api.php';

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));

$app->run();
