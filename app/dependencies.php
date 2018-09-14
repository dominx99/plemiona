<?php

use App\Models\User;
use App\Models\Village;
use App\Observers\UserObserver;
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

$container['config'] = function () {
    return new \App\Config();
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('views', [
        'cache' => false,
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));
    $view->addExtension(new \App\Twig\ConfigExtension($container->get('config')));

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
User::observe(UserObserver::class);

v::with('App\Validation\\Rules\\');
