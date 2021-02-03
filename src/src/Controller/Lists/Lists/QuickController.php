<?php

namespace App\Controller\Lists\Lists;

use App\Action\Base\QuickListActions;
use App\Services\Lists\Makers\QuickMaker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuickController extends ListsController
{
    protected const SHOW_TEMPLATE = 'quick-lists/list';
    protected const INDEX_URL = 'quick-lists.index';
    protected const EDIT_TEMPLATE = 'quick-lists/edit';
    public const INDEX_TEMPLATE = 'quick-lists/index';

    public function index(QuickListActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(QuickListActions $actions, Request $request, QuickMaker $maker): Response
    {
        return $this->executeCreate($actions, $request, $maker);
    }

    public function edit($id, QuickListActions $actions): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        return $this->render(
            self::EDIT_TEMPLATE,
            [
                'form' => $actions->getForm()
                    ->createView(),
                'id' => $id
            ]
        );
    }

    public function update(
        $id, QuickListActions $actions, Request $request, FormFactoryInterface $formFactory,
        EntityManagerInterface $manager
    ): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        $errors = $actions->update($request, $formFactory, $manager);
        if (empty($errors)) {
            return new Response(null, 204);
        }
        return new JsonResponse($errors, 400);
    }

    protected function getActive(): string
    {
        return 'quick-lists';
    }

    public function show($id, QuickListActions $actions): Response
    {
        return $this->executeShow($id, $actions);
    }

    public function delete($id, QuickListActions $actions, EntityManagerInterface $manager
    ): Response
    {
        return $this->executeDelete($id, $actions, $manager);
    }
}