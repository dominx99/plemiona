<?php

use App\Models\Village;
use App\Observers\VillageObserver;
use App\Repositories\VillageRepository;
use Illuminate\Events\Dispatcher;
use Respect\Validation\Validator as v;

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['db']);
$capsule->setEventDispatcher(new Dispatcher());
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function () use ($capsule) {
    return $capsule;
};

$container['auth'] = function () {
    return new \App\Auth\Auth();
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('views', [
        'cache' => false,
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

$container['validator'] = function () {
    return new \App\Validation\Validator();
};

$container['buildings'] = function ($container) {
    return new \App\Repositories\BuildingRepository($container);
};

$container['villages'] = function ($container) {
    return new \App\Repositories\VillageRepository($container);
};

Village::observe(VillageObserver::class);

v::with('App\Validation\\Rules\\');
