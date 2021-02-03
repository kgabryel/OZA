<?php

namespace App\Action\Base;

use App\Controller\ShopsController;
use App\Form\ShopForm;
use App\Services\Filters\ShopFilter;
use Symfony\Component\Form\FormFactoryInterface;

class ShopActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, ShopFilter $filter
    )
    {
        parent::__construct($factory, $filter, ShopsController::INDEX_TEMPLATE, ShopForm::class);
    }
}