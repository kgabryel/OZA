<?php

namespace App\Action\Update;

use App\Entity\Alert\Alert;
use App\Form\AlertForm;
use App\Model\Alert as Model;
use App\Repository\Alert\AlertRepository;
use Symfony\Component\Form\FormFactoryInterface;

/** @method Alert getEntity()() */

/** @property Alert $entity */
class AlertActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, AlertRepository $repository
    )
    {
        parent::__construct($factory, $repository, 'alerts\edit', AlertForm::class);
    }

    public function createForm(): Actions
    {
        $this->form = $this->factory->create(
            $this->formName,
            Model::fromEntity($this->entity),
            ['method' => 'put']
        );
        return $this;
    }
}