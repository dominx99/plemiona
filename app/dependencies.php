<?php

use App\Models\Expedition;
use App\Models\User;
use App\Models\Village;
use App\Observers\ExpeditionObserver;
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

    $view->getEnvironment()->addGlobal('auth', $container->get('auth'));

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

$container['timings'] = function ($container) {
    return new \App\Repositories\TimingRepository($container);
};

$container['armies'] = function ($container) {
    return new \App\Repositories\ArmyRepository($container);
};

$container['expeditions'] = function ($container) {
    return new \App\Repositories\ExpeditionRepository($container);
};

$container['reports'] = function ($container) {
    return new \App\Repositories\ReportRepository($container);
};

$container['buildingUpgrador'] = function ($container) {
    return new \App\Services\BuildingUpgrador($container);
};

$container['goldCalculator'] = function ($container) {
    return new \App\Services\GoldCalculator($container->get('config'));
};

$container['foodCalculator'] = function ($container) {
    return new \App\Services\FoodCalculator($container->get('config'));
};

$container['roadCalculator'] = function ($container) {
    return new \App\Services\RoadCalculator($container->get('config'));
};

Village::observe(VillageObserver::class);
User::observe(UserObserver::class);
Expedition::observe(ExpeditionObserver::class);

v::with('App\Validation\\Rules\\');
