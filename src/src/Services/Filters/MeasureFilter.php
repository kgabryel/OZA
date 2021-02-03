<?php

namespace App\Services\Filters;

use App\Controller\Measures\MeasuresController;
use App\Form\Filters\AlertFindForm;
use App\Form\Filters\MeasureFindForm;
use App\Model\Filters\Alert;
use App\Model\Filters\Measure;
use App\Repository\Alert\AlertRepository;
use App\Repository\MeasureRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MeasureFilter extends Filter
{
    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, MeasureRepository $repository,
        TokenStorageInterface $storage, RouterInterface $router
    )
    {
        parent::__construct(
            $factory,
            $stack,
            $repository,
            $storage,
            $router,
            MeasureFindForm::class,
            MeasuresController::INDEX_URL
        );
        $data = $this->form->getData() ?? new Measure();
        $this->builder = $this->repository->filter($this->user, $data);
    }
}