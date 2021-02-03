<?php

namespace App\Action\Base;

use App\Controller\ShoppingController;
use App\Form\ShoppingForm;
use App\Services\Filters\ShoppingFilter;
use Symfony\Component\Form\FormFactoryInterface;

class ShoppingActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, ShoppingFilter $filter
    )
    {
        parent::__construct(
            $factory,
            $filter,
            ShoppingController::INDEX_TEMPLATE,
            ShoppingForm::class
        );
    }
}