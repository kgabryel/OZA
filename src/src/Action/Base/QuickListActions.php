<?php

namespace App\Action\Base;

use App\Controller\Lists\Lists\QuickController;
use App\Entity\QuickList\QuickList;
use App\Form\QuickListForm;
use App\Model\QuickListModel;
use App\Repository\QuickList\ListRepository;
use App\Services\FormErrorConverter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/** @method QuickList getEntity()() */

/** @property QuickList $entity */
class QuickListActions extends ListActions
{
    public function __construct(
        FormFactoryInterface $factory, ListRepository $listRepository,
        TokenStorageInterface $tokenStorage
    )
    {
        parent::__construct(
            $factory,
            $listRepository,
            $tokenStorage,
            QuickListForm::class,
            QuickController::INDEX_TEMPLATE
        );
    }

    public function getForm(): FormInterface
    {
        $this->form->setData($this->getModel());
        return $this->form;
    }

    protected function getModel(): QuickListModel
    {
        $model = new QuickListModel();
        $model->setName($this->entity->getName());
        $products = new ArrayCollection();
        foreach ($this->entity->getPositions() as $position) {
            $products->add($position);
        }
        $model->setProducts($products);
        return $model;
    }

    public function update(
        Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $manager
    ): array
    {
        $form = $formFactory->create(QuickListForm::class, null, ['method' => 'put']);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
            foreach ($this->entity->getPositions() as $position) {
                $manager->remove($position);
            }
            $manager->flush();
            $this->entity->setName($model->getName());
            $this->entity->setPositions($model->getProducts());
            foreach ($this->entity->getPositions() as $position) {
                $manager->persist($position);
            }
            $manager->persist($this->entity);
            $manager->flush();
            return [];
        }
        $parser = new FormErrorConverter($form);
        $parser->parse();
        return $parser->getErrors();
    }
}