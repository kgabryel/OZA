<?php

namespace App\Action\Base;

use App\Action\Template;
use App\Controller\StuffsController;
use App\Form\StuffForm;
use App\Services\Filters\StuffFilter;
use Symfony\Component\Form\FormFactoryInterface;

class StuffActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, StuffFilter $filter
    )
    {
        parent::__construct($factory, $filter, StuffsController::INDEX_TEMPLATE, StuffForm::class);
    }

    public function returnView(int $limit = 10): Template
    {
        return parent::returnView($limit);
    }
}