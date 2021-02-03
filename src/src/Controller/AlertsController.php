<?php

namespace App\Controller;

use App\Action\Base\AlertActions;
use App\Action\Update\AlertActions as UpdateActions;
use App\Action\Additional\AlertActions as AdditionalActions;
use App\Messages\AlertMessages;
use App\Services\Collection\AlertCollection;
use App\Services\Makers\AssignedMaker;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlertsController extends EntityController
{
    public const INDEX_URL = 'alerts.index';
    public const INDEX_TEMPLATE = 'alerts/index';

    protected function getActive(): string
    {
        return 'alerts';
    }

    public function index(AlertActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(AlertActions $actions, Request $request, AssignedMaker $maker): Response
    {
        return $this->executeCreate(
            $request,
            $maker,
            $actions,
            AlertMessages::getMessage(AlertMessages::CREATED_CORRECTLY)
        );
    }

    public function activate($id, AdditionalActions $actions): Response
    {
        return $this->changeStatus($id, $actions, true);
    }

    public function deactivate($id, AdditionalActions $actions): Response
    {
        return $this->changeStatus($id, $actions, false);
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            AlertMessages::getMessage(AlertMessages::DELETE_CORRECT),
            AlertMessages::getMessage(AlertMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }

    public function show($id, UpdateActions $actions): Response
    {
        return $this->executeShow($id, $actions);
    }

    public function update($id, UpdateActions $actions, Request $request, AssignedMaker $maker
    ): Response
    {
        return $this->executeUpdate(
            $id,
            $request,
            $maker,
            $actions,
            AlertMessages::getMessage(AlertMessages::UPDATE_CORRECT)
        );
    }

    private function changeStatus($id, AdditionalActions $actions, bool $status): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        if (!$actions->changeStatus($status)) {
            return new Response(null, 400);
        }
        return new JsonResponse(
            AlertCollection::fromArray(
                $this->getUser()
                    ->getActiveAlerts()
                    ->toArray()
            )
        );
    }
}