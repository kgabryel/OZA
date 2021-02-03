<?php


namespace App\Services\Filters;

use App\Controller\ShoppingController;
use App\Form\Filters\ShoppingFindForm;
use App\Model\Filters\Shopping;
use App\Repository\ShoppingRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ShoppingFilter extends Filter
{

    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, ShoppingRepository $repository,
        TokenStorageInterface $storage, RouterInterface $router
    )
    {
        parent::__construct(
            $factory,
            $stack,
            $repository,
            $storage,
            $router,
            ShoppingFindForm::class,
            ShoppingController::INDEX_URL
        );
        $data = $this->form->getData() ?? new Shopping();
        $this->builder = $this->repository->filter($this->user, $data);
    }

}