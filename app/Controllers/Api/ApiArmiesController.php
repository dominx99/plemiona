<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiArmiesController extends Controller
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function recruit(Request $request, Response $response): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'village_id' => v::notEmpty()->numeric(),
            'army_id'    => v::notEmpty()->numeric(),
            'amount'     => v::notEmpty()->numeric()->min(1),
        ]);

        if ($validation->failed()) {
            return $response->withJson([
                'error' => 'Przesłano złe parametry',
            ]);
        }

        if (!$village = $this->villages->find($request->getParam('village_id'))) {
            return $response->withJson([
                'error' => 'Nie znaleziono wioski o tym ID' . $request->getParam('village_id'),
            ]);
        }

        if (!$army = $this->armies->findByVillage($village, $request->getParam('army_id'))) {
            return $response->withJson([
                'error' => 'Nie znaleziono armi o tym ID: ' . $request->getParam('army_id'),
            ]);
        }

        if (!$village->armyCopeRequirements($army)) {
            return $response->withJson([
                'error' => 'Nie spełniasz wymagan, żeby rekrutować to wojsko',
            ]);
        }

        if (!$village->hasEnoughFoodForArmy($army, $request->getParam('amount'))) {
            return $response->withJson([
                'error' => 'Nie masz wystarczająco jedzenia :(',
            ]);
        }

        if (!$timing = $this->timings->createArmyIfPossible($village, $army, $request->getParam('amount'))) {
            return $response->withJson([
                'error' => 'Osiągnięto limit trenowanych jednostek jednocześnie!',
            ]);
        }

        $this->timings->makeArmyActiveIfPossible($village, $timing);

        return $response->withJson([
            'status' => 'success',
        ]);
    }
}
