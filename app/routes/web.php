<?php

use App\Controllers\AuthController;
use App\Controllers\Buildings\BarrackController;
use App\Controllers\Buildings\FarmController;
use App\Controllers\Buildings\FortressController;
use App\Controllers\Buildings\GoldMineController;
use App\Controllers\Buildings\SmithyController;
use App\Controllers\PrepareDatabaseController;
use App\Controllers\ReportsController;
use App\Controllers\VillagesController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->get('/prepare', PrepareDatabaseController::class . ':prepare');
$app->get('/truncate', PrepareDatabaseController::class . ':truncate');
$app->get('/drop', PrepareDatabaseController::class . ':drop');

$app->group('', function () use ($app) {
    $app->get('/login', AuthController::class . ':loginForm')->setName('auth.login');
    $app->get('/register', AuthController::class . ':registerForm')->setName('auth.register');

    $app->post('/login', AuthController::class . ':login');
    $app->post('/register', AuthController::class . ':register');
})->add(new GuestMiddleware($container));

$app->group('', function () use ($app, $container) {
    $app->get('/logout', AuthController::class . ':logout')->setName('auth.logout');

    // ! remove this line
    $app->get('/remove', AuthController::class . ':remove')->setName('user.remove');

    $app->get('/villages', VillagesController::class . ':index')->setName('villages.select');

    $app->get('/mapa', VillagesController::class . ':map')->setName('map');

    $app->group('', function () use ($app) {
        $app->get('/twierdza/{id}', FortressController::class . ':index')->setName('building.fortress');
        $app->get('/kopalnia-zlota/{id}', GoldMineController::class . ':index')->setName('building.gold_mine');
        $app->get('/farma/{id}', FarmController::class . ':index')->setName('building.farm');
        $app->get('/koszary/{id}', BarrackController::class . ':index')->setName('building.barrack');
        $app->get('/kuznia/{id}', SmithyController::class . ':index')->setName('building.smithy');
        $app->get('/zbrojownia/{id}', SmithyController::class . ':index')->setName('building.armory');
        $app->get('/stajnia/{id}', SmithyController::class . ':index')->setName('building.stable');

        $app->get('/raporty/{id}', ReportsController::class . ':index')->setName('reports');
        $app->get('/raport/{id}', ReportsController::class . ':show')->setName('report');

        $app->get('/[{id:[0-9]+}]', VillagesController::class . ':show')->setName('villages.show');
    })->add(new \App\Middleware\UserIsOwnerOfVillageMiddleware($container));
})->add(new AuthMiddleware($container));
