<?php

namespace App\Controllers\Buildings;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class GoldMineController extends Controller
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
        $building = $this->buildings->findByVillageAndType($village, 'gold_mine');

        $nextLevel = 'MAX';

        if ($building->canUpgrade()) {
            $nextLevel = $this->goldCalculator->calculateByLevel($village, $village->getBuildingLevel('gold_mine') + 1);
        }

        return $this->view->render($response, 'buildings/gold_mine.twig', [
            'building'   => $this->buildings->findByVillageAndType($village, 'gold_mine'),
            'now'        => $this->goldCalculator->calculate($village),
            'next_level' => $nextLevel,
        ]);
    }
}
