<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class FortressController extends Controller
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Request $request, Response $response, array $params): ResponseInterface
    {
        if (!$buildings = $this->buildings->getForVillage($params['id'])) {
            return $this->view->render($response, 'errors/404.twig');
        }

        return $this->view->render($response, 'buildings/fortress.twig', [
            'fortress'  => $this->buildings->findByType('fortress'),
            'buildings' => $buildings,
        ]);
    }
}
