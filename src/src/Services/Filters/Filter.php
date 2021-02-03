<?php

namespace App\Services\Filters;

use App\Repository\Paginable;
use App\Services\Paginator;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class Filter
{
    protected FormInterface $form;
    protected Paginable $repository;
    protected QueryBuilder $builder;
    protected int $page;
    protected Request $request;
    protected RouterInterface $router;
    protected UserInterface $user;
    protected string $pathName;

    public function __construct(
        FormFactoryInterface $factory, RequestStack $stack, Paginable $repository,
        TokenStorageInterface $storage, RouterInterface $router, string $formName, string $pathName
    )
    {
        $this->pathName = $pathName;
        $this->form = $factory->create($formName);
        $this->router = $router;
        $this->repository = $repository;
        $this->request = $stack->getCurrentRequest();
        $this->form->handleRequest($this->request);
        $this->user = $storage->getToken()
            ->getUser();
        $this->page = $this->request->query->get('page') ?? 1;
    }

    public function paginate(int $limit = 10): Paginator
    {
        $paginator = $this->repository->paginate($this->builder, $this->page, $limit);
        $paginator->setUrl(
            $this->request->getUriForPath(
                $this->router->generate($this->pathName)
            )
        );
        return $paginator;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}