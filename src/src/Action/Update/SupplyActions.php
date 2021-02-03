<?php

namespace App\Action\Update;

use App\Action\Template;
use App\Entity\Supply\Supply;
use App\Entity\User;
use App\Form\Supply\AlertForm;
use App\Form\Supply\EditForm;
use App\Model\Supply\Edit as Model;
use App\Repository\Alert\AlertRepository;
use App\Repository\Supply\SupplyRepository;
use App\Services\Makers\MakerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Action\Additional\Supply\AlertActions;

/** @method Supply getEntity()() */

/** @property Supply $entity */
class SupplyActions extends Actions
{
    private AlertRepository $alertRepository;
    private User $user;
    private AlertActions $alertActions;

    public function __construct(
        FormFactoryInterface $factory, SupplyRepository $repository, TokenStorageInterface $storage,
        AlertRepository $alertRepository, AlertActions $alertActions
    )
    {
        parent::__construct($factory, $repository, 'supplies\edit', EditForm::class);
        $this->alertRepository = $alertRepository;
        $this->user = $storage->getToken()
            ->getUser();
        $this->alertActions = $alertActions;
    }

    public function returnView(): Template
    {
        $this->template->addOption(
            'alerts',
            $this->alertRepository->findForSupply($this->user, $this->entity)
        );
        $this->template->addOption(
            'alertForm',
            $this->factory->create(
                AlertForm::class,
                null,
            )
                ->createView()
        );
        return parent::returnView();
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

    public function update(Request $request, MakerInterface $maker, $options = []): bool
    {
        $result = parent::update($request, $maker);
        if (
            $result && !$this->entity->getActive()
                ->isEmpty()
        ) {
            $this->alertActions->reactivate($this->entity);
        }
        return $result;
    }
}