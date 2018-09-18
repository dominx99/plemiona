<?php

use App\Controllers\Api\ApiArmiesController;
use App\Controllers\Api\ApiBuildingsController;
use App\Controllers\Api\ApiExpeditionsController;
use App\Controllers\Api\ApiVillagesController;

$app->group('/api', function () use ($app) {
    $app->post('/village', ApiVillagesController::class . ':show');

    $app->post('/upgrade/building', ApiBuildingsController::class . ':upgrade');

    $app->post('/recruit', ApiArmiesController::class . ':recruit');

    $app->post('/expedition', ApiExpeditionsController::class . ':create');

    $app->post('/user/expeditions', ApiExpeditionsController::class . ':index');
});
