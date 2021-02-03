<?php

namespace App\Action\Base;

use App\Action\Template;
use App\Services\Filters\Filter;
use App\Services\Makers\MakerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class Actions
{
    protected string $basePath;
    protected Template $template;
    protected FormInterface $createForm;
    protected Filter $filter;
    protected bool $checked;
    protected Request $request;

    public function __construct(
        FormFactoryInterface $factory, Filter $filter, string $templateName, string $createForm
    )
    {
        $this->createForm = $factory->create($createForm);
        $this->filter = $filter;
        $this->template = new Template($templateName);
        $this->checked = false;
    }

    public function create(Request $request, MakerInterface $maker): bool
    {
        $this->checked = true;
        $this->createForm->handleRequest($request);
        if ($this->createForm->isSubmitted() && $this->createForm->isValid()) {
            $maker->setEntity($this->createForm->getData())
                ->create();
            return true;
        }
        return false;
    }

    public function returnView(int $limit = 10): Template
    {
        $this->template->addOption('checked', $this->checked);
        $this->template->addOption('paginator', $this->filter->paginate($limit));
        $this->template->addOption(
            'findForm',
            $this->filter->getForm()
                ->createView()
        );
        $this->template->addOption('createForm', $this->createForm->createView());
        return $this->template;
    }
}