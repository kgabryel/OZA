<?php

namespace App\Controller;

use App\Action\Base\StuffActions;
use App\Messages\StuffMessages;
use App\Services\Makers\SimpleMaker;
use App\Services\Presentation\StuffPresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Action\Update\StuffActions as UpdateActions;
use App\Action\Additional\StuffActions as AdditionalActions;

class StuffsController extends EntityController
{
    public const INDEX_URL = 'stuffs.index';
    public const INDEX_TEMPLATE = 'stuffs/index';

    protected function getActive(): string
    {
        return 'stuffs';
    }

    public function index(StuffActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(StuffActions $actions, Request $request, SimpleMaker $maker): Response
    {
        return $this->executeCreate(
            $request,
            $maker,
            $actions,
            StuffMessages::getMessage(StuffMessages::CREATED_CORRECTLY)
        );
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

    public function update($id, UpdateActions $actions, Request $request, SimpleMaker $maker
    ): Response
    {
        return $this->executeUpdate(
            $id,
            $request,
            $maker,
            $actions,
            StuffMessages::getMessage(StuffMessages::UPDATE_CORRECT)
        );
    }

    public function getInfo($id, AdditionalActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        return new JsonResponse(StuffPresentation::fromEntity($actions->getEntity()));
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            StuffMessages::getMessage(StuffMessages::DELETE_CORRECT),
            StuffMessages::getMessage(StuffMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }
}