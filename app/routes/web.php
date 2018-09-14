<?php

use App\Controllers\AuthController;
use App\Controllers\BuildingsController;
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
        $app->get('/buildings/{id}', BuildingsController::class . ':index')->setName('user.buildings');

        $app->get('/[{id}]', VillagesController::class . ':show')->setName('villages.show');
    })->add(new \App\Middleware\UserIsOwnerOfVillageMiddleware($container));
})->add(new AuthMiddleware($container));
