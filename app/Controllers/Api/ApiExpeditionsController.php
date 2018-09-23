<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Respect\Validation\Validator as v;
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
        $validation = $this->validator->validate($request, [
            'sender_id'   => v::notEmpty()->numeric(),
            'receiver_id' => v::notEmpty()->numeric(),
            'type'        => v::notEmpty(),
            'armies'      => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withJson([
                'error' => "Podano złe parametry",
            ]);
        }

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

        if (!$sender->sendAnyArmy($request->getParam('armies'))) {
            return $response->withJson([
                'error' => 'Wybierz jakieś wojsko',
            ]);
        }

        if (!$sender->hasEnoughArmies($request->getParam('armies'))) {
            return $response->withJson([
                'error' => 'Nie posiadasz wystarczająco wojska',
            ]);
        }

        $this->expeditions->startExpedition($sender, $receiver, $request->getParams());
    }

    public function index()
    {
        $user = $this->auth->user();

        return (new Response())->withJson([
            'user' => $user->with(['villages' => function ($query) {
                $query->with(['expeditions.receiver', 'armies']);
            }])->find($user->id),
        ]);
    }
}
