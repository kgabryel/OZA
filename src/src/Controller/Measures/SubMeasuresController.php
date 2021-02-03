<?php

namespace App\Controller\Measures;

use App\Form\Measures\SubForm;
use App\Services\UserCounts;

class SubMeasuresController extends FormController
{
    protected const FORM_TEMPLATE = 'measures/sub-measure';

    public function __construct(UserCounts $userCounts)
    {
        parent::__construct(
            $userCounts,
            SubForm::class
        );
    }
}
