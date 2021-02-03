<?php

namespace App\Action\Base;

use App\Action\Template;
use App\Controller\Lists\Lists\FullController;
use App\Entity\Product\Position;
use App\Entity\Product\ProductsList;
use App\Entity\User;
use App\Form\ProductList\EditForm;
use App\Form\ProductList\ListForm;
use App\Repository\Alert\AlertRepository;
use App\Repository\Product\ListRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Product\StuffRepository;
use App\Services\Collection\AlertCollection;
use App\Transformer\ListPositionTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/** @method ProductsList getEntity()() */

/** @property ProductsList $entity */
class FullListActions extends ListActions
{
    private AlertRepository $alertRepository;

    public function __construct(
        FormFactoryInterface $factory, ListRepository $listRepository,
        TokenStorageInterface $tokenStorage, AlertRepository $alertRepository
    )
    {
        parent::__construct(
            $factory,
            $listRepository,
            $tokenStorage,
            ListForm::class,
            FullController::INDEX_TEMPLATE
        );
        $this->alertRepository = $alertRepository;
    }

    public function returnView(): Template
    {
        $this->template->addOption(
            'alerts',
            $this->alertRepository->findBy(
                [
                    'user' => $this->user,
                    'isActive' => true
                ]
            )
        );
        return parent::returnView();
    }

    public static function findProducts(
        Request $request, ProductRepository $productRepository, StuffRepository $stuffRepository,
        User $user
    ): array
    {
        $result = [
            'products' => [],
            'stuffs' => []
        ];
        $limit = 15;
        $q = $request->query->get('q');
        if ($q === null || $q === '') {
            return [];
        }
        $result['products'] = $productRepository->findByName($q, $user, $limit);
        $limit -= count($result['products']);
        if ($limit > 0) {
            $result['stuffs'] = $stuffRepository->findByName($q, $user, $limit);
        }
        return $result;
    }

    public function getAlerts(): array
    {
        return AlertCollection::fromArray($this->entity->getAlerts());
    }

    public function getPopulatedForm(ListPositionTransformer $transformer): FormInterface
    {
        $this->form->setData($this->getModel($transformer));
        return $this->form;
    }

    protected function getModel(ListPositionTransformer $transformer): array
    {
        $model = [];
        $model['name'] = $this->entity->getName();
        $model['positions'] = [];
        foreach ($this->entity->getPositions() as $position) {
            $tmp = [];
            $tmp['measure'] = $position->getMeasure()
                ->getId();
            $tmp['amount'] = $position->getMeasureValue();
            $tmp['alerts'] = [];
            if ($position->getProduct() === null) {
                $tmp['position'] = $position->getStuff()
                    ->getId();
                $tmp['type'] = 'Towar';
            } else {
                $tmp['position'] = $position->getProduct()
                    ->getId();
                $tmp['type'] = 'Produkt';
            }
            foreach ($position->getAlerts() as $alert) {
                $tmp['alerts'][] = $alert->getId();
            }
            $model['positions'][] = $transformer->reverseTransform($tmp);
        }
        return $model;
    }

    public function update(
        Request $request, FormFactoryInterface $formFactory, EntityManagerInterface $manager
    ): bool
    {
        $form = $formFactory->create(EditForm::class, null, ['method' => 'put']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $model = $form->getData();
            foreach ($this->entity->getPositions() as $position) {
                $manager->remove($position);
            }
            $manager->flush();
            $this->entity->setUser($this->user);
            $this->entity->setName($model['name']);
            foreach ($model['positions'] as $position) {
                $p = new Position();
                $p->setMeasureValue($position->getAmount());
                $p->setMeasure($position->getMeasure());
                if ($position->getType() === 'Produkt') {
                    $p->setProduct($position->getProduct());
                } else {
                    $p->setStuff($position->getStuff());
                }
                foreach ($position->getAlerts() as $alert) {
                    $p->addAlert($alert);
                    $manager->persist($alert);
                }
                $this->entity->addPosition($p);
                $manager->persist($p);
            }
            $manager->persist($this->entity);
            $manager->flush();
            return true;
        }
        return false;
    }
}