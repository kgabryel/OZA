<?php

namespace App\Action\Update;

use App\Entity\Product\Stuff;
use App\Form\Product\EditForm;
use App\Model\Product\EditProduct;
use App\Repository\Product\StuffRepository;
use App\Services\Makers\MakerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/** @method Stuff getEntity()() */

/** @property Stuff $entity */
class StuffActions extends Actions
{
    public function __construct(FormFactoryInterface $factory, StuffRepository $repository)
    {
        parent::__construct($factory, $repository, 'stuffs\edit', EditForm::class);
    }

    public function update(Request $request, MakerInterface $maker, $options = []): bool
    {
        return parent::update($request, $maker, ['id' => $this->entity->getId()]);
    }

    public function createForm(): Actions
    {
        $this->form = $this->factory->create(
            $this->formName,
            EditProduct::fromEntity($this->entity),
            ['method' => 'put']
        );
        return $this;
    }
}