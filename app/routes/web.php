<?php

use App\Controllers\AuthController;
use App\Controllers\FortressController;
use App\Controllers\GoldMineController;
use App\Controllers\VillagesController;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

$app->group('', function () use ($app) {
    $app->get('/login', AuthController::class . ':loginForm')->setName('auth.login');
    $app->get('/register', AuthController::class . ':registerForm')->setName('auth.register');

    $app->post('/login', AuthController::class . ':login');
    $app->post('/register', AuthController::class . ':register');
})->add(new GuestMiddleware($container));

$app->group('', function () use ($app, $container) {
    $app->get('/logout', AuthController::class . ':logout')->setName('auth.logout');

    $app->get('/villages', VillagesController::class . ':index')->setName('villages.select');

    $app->group('', function () use ($app) {
        $app->get('/twierdza/{id}', FortressController::class . ':index')->setName('building.fortress');
        $app->get('/kopalnia-zlota/{id}', GoldMineController::class . ':index')->setName('building.gold_mine');
        $app->get('/farma/{id}', FarmController::class . ':index')->setName('building.farm');
        $app->get('/koszary/{id}', FarmController::class . ':index')->setName('building.barrack');

        $app->get('/[{id:[0-9]+}]', VillagesController::class . ':show')->setName('villages.show');
    })->add(new \App\Middleware\UserIsOwnerOfVillageMiddleware($container));
})->add(new AuthMiddleware($container));
