<?php

namespace App\Action\Update;

use App\Action\Template;
use App\Entity\User;
use App\Model\Model;
use App\Repository\FindForUser;
use App\Services\Makers\MakerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class Actions
{
    protected string $basePath;
    protected Template $template;
    protected FormInterface $form;
    protected bool $checked;
    protected $entity;
    protected FormFactoryInterface $factory;
    protected string $formName;
    protected FindForUser $repository;

    public function __construct(
        FormFactoryInterface $factory, FindForUser $repository, string $templateName, string $form
    )
    {
        $this->factory = $factory;
        $this->repository = $repository;
        $this->template = new Template($templateName);
        $this->formName = $form;
        $this->entity = null;
        $this->checked = false;
    }

    public function find($id, User $user): bool
    {
        $this->entity = $this->repository->findById($id, $user);
        return $this->entity !== null;
    }

    public function returnView(): Template
    {
        $this->template->addOption('checked', $this->checked);
        $this->template->addOption('createForm', $this->form->createView());
        $this->template->addOption('entity', $this->entity);
        return $this->template;
    }

    public function getEntity()
    {
        return $this->entity;
    }

    public function update(Request $request, MakerInterface $maker, $options = []): bool
    {
        $formOptions = ['method' => 'put'];
        $this->checked = true;
        $this->form = $this->factory->create(
            $this->formName,
            null,
            array_merge($formOptions, $options)
        );
        $this->form->handleRequest($request);
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            /** @var Model $data */
            $data = $this->form->getData();
            $data->setEntity($this->entity);
            $maker->setEntity($data)
                ->create();
            return true;
        }
        return false;
    }

    abstract public function createForm(): self;
}