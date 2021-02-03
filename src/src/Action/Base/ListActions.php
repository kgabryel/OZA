<?php

namespace App\Action\Base;

use App\Action\Template;
use App\Entity\Product\ProductsList;
use App\Entity\QuickList\QuickList;
use App\Entity\User;
use App\Repository\FindForUser;
use App\Services\Lists\Makers\Maker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class ListActions
{
    protected FormInterface $form;
    protected bool $createChecked;
    protected Template $template;
    protected User $user;
    /** @var ProductsList|QuickList */
    protected $entity;
    protected FindForUser $listRepository;

    public function __construct(
        FormFactoryInterface $factory, FindForUser $listRepository,
        TokenStorageInterface $tokenStorage, string $form, string $templateName
    )
    {
        $this->user = $tokenStorage->getToken()
            ->getUser();
        $this->listRepository = $listRepository;
        $this->form = $factory->create($form);
        $this->template = new Template($templateName);
        $this->createChecked = false;
    }

    public function createList(Request $request, Maker $maker): bool
    {
        $this->createChecked = true;
        $this->form->handleRequest($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $maker->set($this->form->getData())
                ->create();
            return true;
        }
        return false;
    }

    public function returnView(): Template
    {
        $this->template->addOption(
            'lists',
            $this->listRepository->findBy(['user' => $this->user], ['createdAt' => 'desc'])
        );
        $this->template->addOption('createChecked', $this->createChecked);
        $this->template->addOption('form', $this->form->createView());
        return $this->template;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function find($id): bool
    {
        $this->entity = $this->listRepository->findById($id, $this->user);
        return $this->entity !== null;
    }

    public function remove(EntityManagerInterface $manager): void
    {
        $manager->remove($this->entity);
        $manager->flush();
    }
}