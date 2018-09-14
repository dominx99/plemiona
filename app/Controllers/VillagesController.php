<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class VillagesController extends Controller
{
    /**
     * @var \App\Repositories\VillageRepository
     */
    protected $villages;

    /**
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->villages = $container->get('villages');
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(): ResponseInterface
    {
        if ($redirect = $this->ifUserHasOneVillageRedirect()) {
            return $redirect;
        }

        return $this->view->render(new Response(), 'villages/select.twig', [
            'villages' => $this->villages->getForUser(),
        ]);
    }

    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show(Request $request, Response $response, array $params): ResponseInterface
    {
        if (!isset($params['id'])) {
            return $response->withRedirect($this->router->pathFor('villages.select'));
        }

        $id = $params['id'];

        if ($village = $this->villages->find($id, ['buildings'])) {
            return $this->view->render($response, 'villages/village.twig', [
                'village' => $village,
            ]);
        }

        if ($this->villages->userVillagesCount() > 1) {
            return $response->withRedirect($this->router->pathFor('villages.select'));
        }

        return $this->view->render($response, 'villages/village.twig', [
            'village' => $this->villages->first(),
        ]);
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface|false
     */
    public function ifUserHasOneVillageRedirect()
    {
        if ($this->villages->userVillagesCount() === 1) {
            return (new Response)->withRedirect($this->router->pathFor('villages.show', [
                'id' => $this->auth->user()->id,
            ]));
        }

        return false;
    }
}
