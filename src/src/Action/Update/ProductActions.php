<?php

namespace App\Action\Update;

use App\Entity\Product\Product;
use App\Form\Product\EditForm;
use App\Model\Product\EditProduct;
use App\Repository\Product\ProductRepository;
use App\Services\Makers\MakerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/** @method Product getEntity()() */

/** @property Product $entity */
class ProductActions extends Actions
{
    public function __construct(
        FormFactoryInterface $factory, ProductRepository $repository
    )
    {
        parent::__construct($factory, $repository, 'products\edit', EditForm::class);
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

    public function update(Request $request, MakerInterface $maker, $options = []): bool
    {
        return parent::update($request, $maker, ['id' => $this->entity->getId()]);
    }
}