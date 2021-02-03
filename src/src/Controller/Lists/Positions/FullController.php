<?php

namespace App\Controller\Lists\Positions;

use App\Action\Additional\Lists\Positions\FullActions;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FullController extends PositionsController
{
    protected function getActive(): string
    {
        return '';
    }

    public function info($id, FullActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        return new JsonResponse($actions->getInfo());
    }

    public function alerts($id, FullActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        return new JsonResponse($actions->getAlerts());
    }

    public function check($id, FullActions $actions): Response
    {
        return $this->executeCheck($id, $actions);
    }

    public function uncheck($id, FullActions $actions): Response
    {
        return $this->executeUncheck($id, $actions);
    }

    public function delete($id, FullActions $actions): Response
    {
        return $this->executeDelete($id, $actions);
    }
}