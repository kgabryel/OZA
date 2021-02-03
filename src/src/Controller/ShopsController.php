<?php

namespace App\Controller;

use App\Action\Additional\ShopActions as AdditionalActions;
use App\Action\Base\ShopActions;
use App\Action\Update\ShopActions as UpdateActions;
use App\Messages\ShopsMessages;
use App\Services\Makers\AssignedMaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopsController extends EntityController
{
    public const INDEX_URL = 'shops.index';
    public const INDEX_TEMPLATE = 'shops/index';

    protected function getActive(): string
    {
        return 'shops';
    }

    public function index(ShopActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(ShopActions $actions, Request $request, AssignedMaker $maker): Response
    {
        return $this->executeCreate(
            $request,
            $maker,
            $actions,
            ShopsMessages::getMessage(ShopsMessages::CREATED_CORRECTLY)
        );
    }

    public function show($id, UpdateActions $actions): Response
    {
        return $this->executeShow($id, $actions);
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            ShopsMessages::getMessage(ShopsMessages::DELETE_CORRECT),
            ShopsMessages::getMessage(ShopsMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }

    public function update($id, UpdateActions $actions, Request $request, AssignedMaker $maker
    ): Response
    {
        return $this->executeUpdate(
            $id,
            $request,
            $maker,
            $actions,
            ShopsMessages::getMessage(ShopsMessages::UPDATE_CORRECT)
        );
    }
}