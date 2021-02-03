<?php

namespace App\Services\Filters;

use App\Controller\SuppliesController;
use App\Form\Filters\SupplyFindForm;
use App\Model\Filters\Supply;
use App\Repository\Supply\SupplyRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SupplyFilter extends Filter
{
    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, SupplyRepository $repository,
        TokenStorageInterface $storage, RouterInterface $router
    )
    {
        parent::__construct(
            $factory,
            $stack,
            $repository,
            $storage,
            $router,
            SupplyFindForm::class,
            SuppliesController::INDEX_URL
        );
        $data = $this->form->getData() ?? new Supply();
        $this->builder = $this->repository->filter($this->user, $data);
    }
}