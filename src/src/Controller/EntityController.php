<?php

namespace App\Controller;

use App\Action\Base\Actions;
use App\Action\Update\Actions as UpdateActions;
use App\Action\Additional\Actions as AdditionalActions;
use App\Services\Makers\MakerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class EntityController extends BaseController
{
    public function executeIndex(Actions $actions): Response
    {
        $template = $actions->returnView();
        return $this->render(
            $template->getName(),
            $template->getOptions()
        );
    }

    public function executeCreate(
        Request $request, MakerInterface $maker, Actions $actions, string $successMessage
    ): Response
    {
        if ($actions->create($request, $maker)) {
            $this->addSuccessMessage($successMessage);
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        return $this->executeIndex($actions);
    }

    public function executeShow($id, UpdateActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        $actions->createForm();
        $template = $actions->returnView();
        return $this->render(
            $template->getName(),
            $template->getOptions()
        );
    }

    public function executeUpdate(
        $id, Request $request, MakerInterface $maker, UpdateActions $actions, string $successMessage
    ): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            return new Response(null, 404);
        }
        $actions->update($request, $maker);
        if ($actions->update($request, $maker)) {
            $this->addSuccessMessage($successMessage);
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }
        $template = $actions->returnView();
        return $this->render(
            $template->getName(),
            $template->getOptions()
        );
    }

    public function executeDelete(
        $id, AdditionalActions $actions, string $successMessage, string $errorMessage, string $path
    ): Response
    {
        if ($actions->find($id, $this->getUser())) {
            $actions->delete();
            $this->addSuccessMessage($successMessage);
        } else {
            $this->addErrorMessage($errorMessage);
        }
        return $this->redirect($path);
    }
}