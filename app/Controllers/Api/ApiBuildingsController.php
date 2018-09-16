<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiBuildingsController extends Controller
{
    public function upgrade(Request $request, Response $response)
    {
        // TODO: add validation

        if (!$village = $this->villages->find($request->getParam('village_id'))) {
            return $response->withJson([
                'error' => 'Nie znaleziono wioski o tym ID' . $request->getParam('village_id'),
            ]);
        }

        if (!$building = $this->buildings->findByVillage($village, $request->getParam('building_id'))) {
            return $response->withJson([
                'error' => 'Nie znaleziono budynku o tym ID: ' . $request->getParam('building_id'),
            ]);
        }

        if (!$building->canUpgrade()) {
            return $response->withJson([
                'error' => 'Budynek osiągnął maksymalny poziom',
            ]);
        }

        if (!$village->buildingCopeRequirements($building)) {
            return $response->withJson([
                'error' => 'Nie spełniasz wymagan do ulepszenia tego budynku',
            ]);
        }

        if (!$timing = $this->timings->createBuildingIfPossible($village, $building)) {
            return $response->withJson([
                'error' => 'Budynek jest już budowie lub limit budynków w kolejce został osiągnięty!',
            ]);
        }

        $this->timings->makeBuildingActiveIfPossible($village, $timing);

        return $response->withJson([
            'status' => 'success',
        ]);
    }
}
