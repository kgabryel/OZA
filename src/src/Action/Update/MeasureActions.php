<?php

namespace App\Action\Update;

use App\Entity\Measure;
use App\Form\Measures\EditForm;
use App\Model\Measures\Edit;
use App\Repository\MeasureRepository;
use App\Services\Makers\MakerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/** @method Measure getEntity()() */

/** @property Measure $entity */
class MeasureActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, MeasureRepository $repository
    )
    {
        parent::__construct($factory, $repository, 'measures\edit', EditForm::class);
    }

    public function createForm(): Actions
    {
        $this->form = $this->factory->create(
            $this->formName,
            Edit::fromEntity($this->entity),
            ['method' => 'put']
        );
        return $this;
    }

    public function update(Request $request, MakerInterface $maker, $options = []): bool
    {
        return parent::update($request, $maker, ['id' => $this->entity->getId()]);
    }
}