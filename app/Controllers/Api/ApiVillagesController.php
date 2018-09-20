<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use Slim\Http\Request;
use Slim\Http\Response;

class ApiVillagesController extends Controller
{
    public function show(Request $request, Response $response): Response
    {
        $validation = $this->validator->validate($request, [
            'id' => v::notEmpty(),
        ]);

        if ($validation->failed()) {
            return $response->withJson([
                'status' => 'failed',
                'errors' => $validation->getErrors(),
            ]);
        }

        $village = $this->villages->find($request->getParam('id'), [
            'buildingTimings' => function ($query) {
                $query->with('building');
            },
            'armyTimings'     => function ($query) {
                $query->with('army');
            },
        ]);

        return $response->withJson([
            'status'  => 'success',
            'village' => $village,
        ]);
    }
}
