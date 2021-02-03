<?php

namespace App\Controller\Lists\Lists;

use App\Action\Base\FullListActions;
use App\Messages\ListErrors;
use App\Messages\ListMessages;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\StuffRepository;
use App\Services\Lists\Makers\FullMaker;
use App\Transformer\ListPositionTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FullController extends ListsController
{
    protected const SHOW_TEMPLATE = 'lists/list';
    protected const INDEX_URL = 'lists.index';
    protected const EDIT_TEMPLATE = 'lists/edit';
    public const INDEX_TEMPLATE = 'lists/index';

    public function index(FullListActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(FullListActions $actions, Request $request, FullMaker $maker): Response
    {
        return $this->executeCreate($actions, $request, $maker);
    }

    public function findProducts(
        Request $request, ProductRepository $productRepository, StuffRepository $stuffRepository
    ): Response
    {
        return new JsonResponse(
            FullListActions::findProducts(
                $request,
                $productRepository,
                $stuffRepository,
                $this->getUser()
            )
        );
    }

    public function edit($id, FullListActions $actions, ListPositionTransformer $transformer
    ): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        $form = $actions->getPopulatedForm($transformer);
        return $this->render(
            self::EDIT_TEMPLATE,
            [
                'form' => $form->createView(),
                'id' => $id
            ]
        );
    }

    public function show($id, FullListActions $actions): Response
    {
        return $this->executeShow($id, $actions);
    }

    public function update(
        $id, FullListActions $actions, Request $request, FormFactoryInterface $formFactory,
        EntityManagerInterface $manager
    ): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        if ($actions->update($request, $formFactory, $manager)) {
            $this->addSuccessMessage(ListMessages::getMessage(ListMessages::UPDATE_CORRECT));
        } else {
            $this->addErrorMessage(ListErrors::getError(ListErrors::UPDATE_ERROR));
        }
        return $this->redirect($this->generateUrl(self::INDEX_URL));
    }

    protected function getActive(): string
    {
        return 'lists';
    }

    public function alerts($id, FullListActions $actions): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        return new JsonResponse($actions->getAlerts());
    }

    public function delete($id, FullListActions $actions, EntityManagerInterface $manager): Response
    {
        return $this->executeDelete($id, $actions, $manager);
    }
}