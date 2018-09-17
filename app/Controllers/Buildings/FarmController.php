<?php

namespace App\Controllers\Buildings;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class FarmController extends Controller
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Request $request, Response $response, array $params): ResponseInterface
    {
        $village  = $this->villages->find($params['id']);
        $building = $this->buildings->findByVillageAndType($village, 'farm');

        $nextLevel = 'MAX';

        if ($building->canUpgrade()) {
            $nextLevel = $this->foodCalculator->calculateByLevel($village, $village->getBuildingLevel('farm') + 1);
        }

        return $this->view->render($response, 'buildings/farm.twig', [
            'building'   => $this->buildings->findByVillageAndType($village, 'farm'),
            'now'        => $this->foodCalculator->calculate($village),
            'next_level' => $nextLevel,
        ]);
    }
}
