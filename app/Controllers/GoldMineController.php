<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class GoldMineController extends Controller
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(Request $request, Response $response, array $args): ResponseInterface
    {
        return $this->view->render($response, 'buildings/gold_mine.twig');
    }
}
