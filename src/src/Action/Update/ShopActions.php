<?php

namespace App\Action\Update;

use App\Action\Template;
use App\Entity\Shop;
use App\Form\ShopForm;
use App\Model\Shop as Model;
use App\Repository\ShoppingRepository;
use App\Repository\ShopRepository;
use App\Services\Makers\MakerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/** @method Shop getEntity()() */

/** @property Shop $entity */
class ShopActions extends Actions
{
    private ShoppingRepository $shoppingRepository;

    public function __construct(
        FormFactoryInterface $factory, ShopRepository $repository,
        ShoppingRepository $shoppingRepository
    )
    {
        parent::__construct($factory, $repository, 'shops\edit', ShopForm::class);
        $this->shoppingRepository = $shoppingRepository;
    }

    public function returnView(): Template
    {
        $this->template->addOption(
            'shopping',
            $this->shoppingRepository->findBy(
                ['shop' => $this->entity->getId()],
                ['date' => 'DESC']
            )
        );
        return parent::returnView();
    }

    public function update(Request $request, MakerInterface $maker, $options = []): bool
    {
        return parent::update($request, $maker, ['id' => $this->entity->getId()]);
    }

    public function createForm(): Actions
    {
        $this->form = $this->factory->create(
            $this->formName,
            Model::fromEntity($this->entity),
            [
                'method' => 'put',
                'id' => $this->entity->getId()
            ]
        );
        return $this;
    }
}