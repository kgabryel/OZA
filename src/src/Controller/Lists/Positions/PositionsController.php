<?php

namespace App\Controller\Lists\Positions;

use App\Action\Additional\Lists\Positions\PositionsActions;
use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;

abstract class PositionsController extends BaseController
{
    private const BAR_TEMPLATE = 'parts/lists/progress-bar';

    protected function executeCheck($id, PositionsActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        $actions->check();
        return $this->render(self::BAR_TEMPLATE, ['list' => $actions->getList()]);
    }

    protected function executeUncheck($id, PositionsActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        $actions->uncheck();
        return $this->render(self::BAR_TEMPLATE, ['list' => $actions->getList()]);
    }

    protected function executeDelete($id, PositionsActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        $actions->delete();
        return $this->render(self::BAR_TEMPLATE, ['list' => $actions->getList()]);
    }
}