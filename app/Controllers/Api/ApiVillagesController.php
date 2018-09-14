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

        return $response->withJson([
            'status'  => 'success',
            'village' => $this->villages->find($request->getParam('id')),
        ]);
    }
}
