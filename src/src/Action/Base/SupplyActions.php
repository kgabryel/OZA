<?php

namespace App\Action\Base;

use App\Controller\SuppliesController;
use App\Form\Supply\SupplyForm;
use App\Services\Filters\SupplyFilter;
use Symfony\Component\Form\FormFactoryInterface;

class SupplyActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, SupplyFilter $filter
    )
    {
        parent::__construct($factory, $filter, SuppliesController::INDEX_TEMPLATE, SupplyForm::class);
    }
}