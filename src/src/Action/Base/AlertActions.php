<?php

namespace App\Action\Base;

use App\Controller\AlertsController;
use App\Form\AlertForm;
use App\Services\Filters\AlertFilter;
use Symfony\Component\Form\FormFactoryInterface;

class AlertActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, AlertFilter $filter
    )
    {
        parent::__construct($factory, $filter, AlertsController::INDEX_TEMPLATE, AlertForm::class);
    }
}