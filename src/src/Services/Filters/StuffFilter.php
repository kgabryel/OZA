<?php

namespace App\Services\Filters;

use App\Controller\StuffsController;
use App\Form\Filters\StuffFindForm;
use App\Model\Filters\Stuff;
use App\Repository\Product\StuffRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StuffFilter extends Filter
{
    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, StuffRepository $repository,
        TokenStorageInterface $storage, RouterInterface $router
    )
    {
        parent::__construct(
            $factory,
            $stack,
            $repository,
            $storage,
            $router,
            StuffFindForm::class,
            StuffsController::INDEX_URL
        );
        $data = $this->form->getData() ?? new Stuff();
        $this->builder = $this->repository->filter($this->user, $data);
    }
}