<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class UserIsOwnerOfVillageMiddleware extends Middleware
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param $next
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, $next): ResponseInterface
    {
        $route = $request->getAttribute('route');
        $id    = $route->getArgument('id');

        if (!$id) {
            return $next($request, $response);
        }

        $village = $this->container->villages->find($id);

        if (!$village->isOwner($this->container->auth->user()->id)) {
            return $response->withRedirect($this->container->router->pathFor('villages.select'));
        }

        return $next($request, $response);
    }
}
