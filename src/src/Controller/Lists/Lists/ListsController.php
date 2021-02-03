<?php

namespace App\Controller\Lists\Lists;

use App\Action\Base\ListActions;
use App\Controller\BaseController;
use App\Messages\ListMessages;
use App\Services\Lists\Makers\Maker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class ListsController extends BaseController
{
    protected const SHOW_TEMPLATE = '';
    protected const INDEX_URL = '';
    protected ServiceEntityRepository $repository;

    protected function executeIndex(ListActions $actions): Response
    {
        $template = $actions->returnView();
        return $this->render(
            $template->getName(),
            $template->getOptions()
        );
    }

    protected function executeCreate(ListActions $actions, Request $request, Maker $maker): Response
    {
        if ($actions->createList($request, $maker)) {
            $this->addSuccessMessage(ListMessages::getMessage(ListMessages::CREATED_CORRECTLY));
            return $this->redirect($this->generateUrl(static::INDEX_URL));
        }
        return $this->executeIndex($actions);
    }

    public function executeDelete($id, ListActions $actions, EntityManagerInterface $manager
    ): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        $actions->remove($manager);
        return new Response(null, 204);
    }

    public function executeShow($id, ListActions $actions): Response
    {
        if (!$actions->find($id)) {
            return new Response(null, 404);
        }
        return $this->render(
            static::SHOW_TEMPLATE,
            ['list' => $actions->getEntity()]
        );
    }
}