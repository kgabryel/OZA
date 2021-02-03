<?php

namespace App\Controller;

use App\Action\Additional\Supply\AlertActions;
use App\Action\Additional\Supply\SupplyActions as AdditionalActions;
use App\Action\Base\SupplyActions;
use App\Messages\AlertMessages;
use App\Messages\SupplyMessages;
use App\Action\Update\SupplyActions as UpdateActions;
use App\Services\Makers\SimpleMaker;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SuppliesController extends EntityController
{
    public const INDEX_URL = 'supply.index';
    private const SHOW_URL = 'supply.show';
    public const INDEX_TEMPLATE = 'supplies/index';

    protected function getActive(): string
    {
        return 'supply';
    }

    public function index(SupplyActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(SupplyActions $actions, Request $request, SimpleMaker $maker): Response
    {
        return $this->executeCreate(
            $request,
            $maker,
            $actions,
            SupplyMessages::getMessage(SupplyMessages::CREATED_CORRECTLY)
        );
    }

    public function show($id, UpdateActions $actions): Response
    {
        return $this->executeShow($id, $actions);
    }

    public function update($id, Request $request, UpdateActions $actions, SimpleMaker $maker
    ): Response
    {
        return $this->executeUpdate(
            $id,
            $request,
            $maker,
            $actions,
            SupplyMessages::getMessage(SupplyMessages::UPDATE_CORRECT)
        );
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            SupplyMessages::getMessage(SupplyMessages::DELETE_CORRECT),
            SupplyMessages::getMessage(SupplyMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }

    public function deleteAlert($id, AlertActions $actions, Request $request): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            AlertMessages::getMessage(AlertMessages::DELETE_CORRECT),
            AlertMessages::getMessage(AlertMessages::DELETE_INCORRECT),
            $request->headers->get('referer')
        );
    }

    public function createAlert(
        $id, Request $request, AlertActions $actions, AdditionalActions $supplyActions,
        FormFactoryInterface $factory, SimpleMaker $maker
    ): Response
    {
        if (!$supplyActions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        $supply = $supplyActions->getEntity();
        $result = $actions->create($request, $factory, $supply, $maker);
        if ($result->isCorrect()) {
            $this->addSuccessMessage(SupplyMessages::getMessage(SupplyMessages::ALERT_ADDED));
        } else {
            foreach ($result->getErrors() as $error) {
                $this->addErrorMessage($error);
            }
        }
        return $this->redirect($this->generateUrl(self::SHOW_URL, ['id' => $supply->getId()]));
    }
}