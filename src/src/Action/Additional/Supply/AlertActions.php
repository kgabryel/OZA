<?php

namespace App\Action\Additional\Supply;

use App\Action\Additional\Actions;
use App\Entity\Supply\Alert;
use App\Entity\Supply\Supply;
use App\Form\Supply\AlertForm;
use App\Repository\Supply\AlertRepository;
use App\Services\FormErrorConverter;
use App\Services\Makers\MakerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/** @method Alert getEntity()() */
/** @property Alert $entity */

/** @property AlertRepository $repository */
class AlertActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, AlertRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }

    public function reactivate(?Supply $supply = null): void
    {
        /** @var Supply $supply */
        $supply ??= $this->entity->getSupply();
        foreach ($supply->getAlerts() as $supplyAlert) {
            $alert = $supplyAlert->getAlert();
            $alert->deactivate();
            $this->manager->persist($alert);
        }
        $this->manager->flush();
        $supplyAlert = $this->repository->findAlertToActivate(0, $supply);
        if ($supplyAlert !== null) {
            $alert = $supplyAlert->getAlert();
            $alert->activate();
            $this->manager->persist($alert);
            $this->manager->flush();
        }
    }

    public function delete(): void
    {
        /** @var \App\Entity\Alert\Alert $alert */
        $alert = $this->entity->getAlert();
        $reactivate = $alert->isActive();
        parent::delete();
        if ($reactivate) {
            $alert->deactivate();
            $this->manager->persist($alert);
            $this->manager->flush();
            $this->reactivate();
        }
    }

    public function create(
        Request $request, FormFactoryInterface $factory, Supply $supply, MakerInterface $maker
    ): Result
    {
        $form = $factory->create(AlertForm::class, null, ['id' => $supply->getId()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data->setSupply($supply);
            $maker->setEntity($data)
                ->create();
            $this->reactivate($supply);
            return new Result();
        }
        $parser = new FormErrorConverter($form);
        $parser->parse();
        $errors = [];
        foreach ($parser->getErrors() as $error) {
            foreach ($error as $val) {
                $errors[] = $val;
            }
        }
        return new Result($errors);
    }
}