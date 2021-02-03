<?php

namespace App\Controller\Measures;

use App\Action\Additional\MeasureActions;
use App\Controller\EntityController;
use App\Messages\MeasureMessages;
use App\Services\Filters\MeasureFilter;
use App\Services\Makers\AssignedMaker;
use App\Services\Presentation\MeasurePresentation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Action\Update\MeasureActions as UpdateActions;
use App\Action\Additional\MeasureActions as AdditionalActions;

class MeasuresController extends EntityController
{
    public const INDEX_URL = 'measures.index';

    protected function getActive(): string
    {
        return 'measures';
    }

    public function index(MeasureFilter $filter): Response
    {
        $findForm = $filter->getForm();
        return $this->render(
            'measures/index',
            [
                'paginator' => $filter->paginate(),
                'findForm' => $findForm->createView()
            ]
        );
    }

    public function getInfo($id, MeasureActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        return new JsonResponse(MeasurePresentation::fromEntity($actions->getEntity()));
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
            MeasureMessages::getMessage(MeasureMessages::UPDATE_CORRECT)
        );
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            MeasureMessages::getMessage(MeasureMessages::DELETE_CORRECT),
            MeasureMessages::getMessage(MeasureMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }
}
