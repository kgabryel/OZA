<?php

namespace App\Controller\Measures;

use App\Form\Measures\MainForm;
use App\Services\UserCounts;

class MainMeasuresController extends FormController
{
    protected const FORM_TEMPLATE = 'measures/main-measure';

    public function __construct(UserCounts $userCounts)
    {
        parent::__construct(
            $userCounts,
            MainForm::class
        );
    }
}
