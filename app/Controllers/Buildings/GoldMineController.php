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
        $village = $this->villages->find($params['id']);

        return $this->view->render($response, 'buildings/gold_mine.twig', [
            'building' => $this->buildings->findByVillageAndType($village, 'gold_mine'),
        ]);
    }
}
