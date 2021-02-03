<?php

namespace App\Services\Filters;

use App\Controller\AlertsController;
use App\Form\Filters\AlertFindForm;
use App\Model\Filters\Alert;
use App\Repository\Alert\AlertRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AlertFilter extends Filter
{
    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, AlertRepository $repository,
        TokenStorageInterface $storage, RouterInterface $router
    )
    {
        parent::__construct(
            $factory,
            $stack,
            $repository,
            $storage,
            $router,
            AlertFindForm::class,
            AlertsController::INDEX_URL
        );
        $data = $this->form->getData() ?? new Alert();
        $this->builder = $this->repository->filter($this->user, $data);
    }
}