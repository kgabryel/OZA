<?php

namespace App\Controller;

use App\Action\Base\ProductActions;
use App\Action\Additional\ProductActions as AdditionalActions;
use App\Action\Update\ProductActions as UpdateActions;
use App\Messages\ProductMessages;
use App\Services\Makers\AssignedMaker;
use App\Services\Presentation\ProductPresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends EntityController
{
    public const INDEX_URL = 'products.index';
    public const INDEX_TEMPLATE = 'products/index';

    protected function getActive(): string
    {
        return 'products';
    }

    public function index(ProductActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(ProductActions $actions, Request $request, AssignedMaker $maker
    ): Response
    {
        return $this->executeCreate(
            $request,
            $maker,
            $actions,
            ProductMessages::getMessage(ProductMessages::CREATED_CORRECTLY)
        );
    }

    public function getInfo($id, AdditionalActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        return new JsonResponse(ProductPresentation::fromEntity($actions->getEntity()));
    }

    public function getMeasures($id, AdditionalActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        return new JsonResponse($actions->getMeasures());
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
            ProductMessages::getMessage(ProductMessages::UPDATE_CORRECT)
        );
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            ProductMessages::getMessage(ProductMessages::DELETE_CORRECT),
            ProductMessages::getMessage(ProductMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }
}