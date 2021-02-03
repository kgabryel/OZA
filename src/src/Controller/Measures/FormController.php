<?php

namespace App\Controller\Measures;

use App\Controller\BaseController;
use App\Messages\MeasureMessages;
use App\Services\Makers\AssignedMaker;
use App\Services\UserCounts;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class FormController extends BaseController
{
    protected const FORM_TEMPLATE = '';
    protected bool $checked;
    protected FormInterface $form;
    protected string $formName;

    public function __construct(
        UserCounts $userCounts, string $formName
    )
    {
        parent::__construct($userCounts);
        $this->checked = false;
        $this->formName = $formName;
    }

    protected function getActive(): string
    {
        return 'measures';
    }

    /**
     * @return Response
     */
    public function show(): Response
    {
        $this->form = $this->createForm($this->formName);
        return $this->returnView();
    }

    /**
     * @param Request $request
     * @param AssignedMaker $maker
     *
     * @return Response
     */
    public function create(Request $request, AssignedMaker $maker): Response
    {
        $this->form = $this->createForm($this->formName);
        $this->form->handleRequest($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $maker->setEntity($this->form->getData())
                ->create();
            $this->addSuccessMessage(
                MeasureMessages::getMessage(MeasureMessages::CREATED_CORRECTLY)
            );
            return $this->redirect($this->generateUrl(MeasuresController::INDEX_URL));
        }
        $this->checked = true;
        return $this->returnView();
    }

    protected function returnView(): Response
    {
        return $this->render(
            static::FORM_TEMPLATE,
            [
                'form' => $this->form->createView(),
                'checked' => $this->checked
            ]
        );
    }
}
