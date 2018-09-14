<?php

use App\Controllers\Api\ApiVillagesController;

$app->group('/api', function () use ($app) {
    $app->post('/village', ApiVillagesController::class . ':show');
});
