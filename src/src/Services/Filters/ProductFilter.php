<?php

namespace App\Services\Filters;

use App\Controller\ProductsController;
use App\Form\Filters\ProductFindForm;
use App\Model\Filters\Product;
use App\Repository\Product\ProductRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductFilter extends Filter
{
    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, ProductRepository $repository,
        TokenStorageInterface $storage, RouterInterface $router
    )
    {
        parent::__construct(
            $factory,
            $stack,
            $repository,
            $storage,
            $router,
            ProductFindForm::class,
            ProductsController::INDEX_URL
        );
        $data = $this->form->getData() ?? new Product();
        $this->builder = $this->repository->filter($this->user, $data);
    }
}