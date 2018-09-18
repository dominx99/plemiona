<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiExpeditionsController extends Controller
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @return \Slim\Http\Response
     */
    public function create(Request $request, Response $response)
    {
        // ! data validation

        if (!$sender = $this->villages->find($request->getParam('sender_id'))) {
            return $response->withJson([
                'error' => "Wioska o tym ID nie istnieje",
            ]);
        }

        if (!$receiver = $this->villages->find($request->getParam('receiver_id'))) {
            return $response->withJson([
                'error' => "Wioska o tym ID nie istnieje",
            ]);
        }

        if (!$sender->hasEnoughArmies($request->getParam('armies'))) {
            return $response->withJson([
                'error' => 'Nie posiadasz wystarczająco wojska',
            ]);
        }

        $this->expeditions->startExpedition($sender, $receiver, $request->getParams());
    }
}
