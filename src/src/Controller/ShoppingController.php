<?php

namespace App\Controller;

use App\Action\Base\ShoppingActions;
use App\Messages\ShoppingMessages;
use App\Repository\ShoppingRepository;
use App\Services\Filters\ShoppingFilter;
use App\Services\Lists\ListCreator;
use App\Services\Makers\ShoppingMaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Action\Additional\ShoppingActions as AdditionalActions;

class ShoppingController extends EntityController
{
    public const INDEX_TEMPLATE = 'shopping/index';
    public const INDEX_URL = 'shopping.index';

    protected function getActive(): string
    {
        return 'shopping';
    }

    public function index(ShoppingActions $actions): Response
    {
        return $this->executeIndex($actions);
    }

    public function create(ShoppingActions $actions, Request $request, ShoppingMaker $maker
    ): Response
    {
        return $this->executeCreate(
            $request,
            $maker,
            $actions,
            ShoppingMessages::getMessage(ShoppingMessages::CREATED_CORRECTLY)
        );
    }

    public function delete($id, AdditionalActions $actions): Response
    {
        return $this->executeDelete(
            $id,
            $actions,
            ShoppingMessages::getMessage(ShoppingMessages::DELETE_CORRECT),
            ShoppingMessages::getMessage(ShoppingMessages::DELETE_INCORRECT),
            $this->generateUrl(self::INDEX_URL)
        );
    }

    public function createFromList(
        $id, ListCreator $creator, ShoppingFilter $filter, ShoppingRepository $shoppingRepository
    ): Response
    {
        if (!$creator->findList($id)) {
            return new Response(null, 404);
        }
        $creator->setForm();
        return $this->render(
            self::INDEX_TEMPLATE,
            [
                'checked' => false,
                'createForm' => $creator->getForm()
                    ->createView(),
                'positions' => $shoppingRepository->findForUser($this->getUser()),
                'findForm' => $filter->getForm()
                    ->createView(),
                'paginator' => $filter->paginate()
            ]
        );
    }
}