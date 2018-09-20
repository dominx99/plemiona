<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class ReportsController extends Controller
{
    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $params
     */
    public function index(Request $request, Response $response, array $params)
    {
        $village = $this->villages->find($params['id']);

        return $this->view->render($response, 'villages/reports.twig', [
            'reports' => $village,
        ]);
    }

    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $params
     */
    public function show(Request $request, Response $response, array $params)
    {
        if (!$report = $this->reports->find($params['id'], ['expedition' => function ($query) {
            return $query->withTrashed();
        }])) {
            return 'nie znaleziono raportu!';
        }

        if (!$this->auth->user()->ownerOfReport($report)) {
            return 'ten raport nie jest twój!';
        }

        return $this->view->render($response, 'villages/report.twig', [
            'report' => $report,
        ]);
    }
}
