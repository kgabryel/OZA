<?php

namespace App\Action\Base;

use App\Controller\ProductsController;
use App\Form\Product\ProductForm;
use App\Services\Filters\ProductFilter;
use Symfony\Component\Form\FormFactoryInterface;

class ProductActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, ProductFilter $filter
    )
    {
        parent::__construct(
            $factory,
            $filter,
            ProductsController::INDEX_TEMPLATE,
            ProductForm::class
        );
    }
}