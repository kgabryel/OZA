<?php

namespace App\Services\Routing;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Group
{
    private RouteCollection $configurator;
    private string $namePrefix;
    private string $pathPrefix;
    private string $controller;

    public function __construct(
        RouteCollection $collection, string $namePrefix = '', string $pathPrefix = ''
    )
    {
        $this->configurator = $collection;
        $this->namePrefix = $namePrefix;
        $this->pathPrefix = trim($pathPrefix, '/');
        $this->controller = '';
    }

    public function setController(string $controller): self
    {
        $this->controller = $controller;
        return $this;
    }

    public function add(string $name, Route $route, Info $info): self
    {
        $route->setMethods($info->getMethods());
        if ($route->getDefault('_controller') === null) {
            $this->addController($route, $info);
        }
        $this->configurator->add($this->namePrefix . $name, $this->modifyRoute($route));
        return $this;
    }

    private function modifyRoute(Route $route): Route
    {
        $route->setPath(trim($this->pathPrefix . '/' . trim($route->getPath(), '/'), '/'));
        return $route;
    }

    private function addController(Route $route, Info $info): Route
    {
        if ($this->controller === '' && $info->getController() === '') {
            throw new RouteException('No controller name (default or injected).');
        }
        $controllerName = $info->getController() === '' ? $this->controller : $info->getController(
        );
        $route->setDefault('_controller', $controllerName . '::' . $info->getAction());
        return $route;
    }

    public function addIndex(): self
    {
        $this->add('index', new Route('/'), new Info(['GET'], 'index'));
        return $this;
    }

    public function addCreate(): self
    {
        $this->add('create', new Route('/'), new Info(['POST'], 'create'));
        return $this;
    }

    public function addDelete(): self
    {
        $this->add('delete', new Route('/{id}'), new Info(['DELETE'], 'delete'));
        return $this;
    }

    public function addEdit(): self
    {
        $this->add('edit', new Route('/{id}/edit'), new Info(['GET'], 'edit'));
        return $this;
    }

    public function addShow(): self
    {
        $this->add('show', new Route('/{id}'), new Info(['GET'], 'show'));
        return $this;
    }

    public function addUpdate(): self
    {
        $this->add('update', new Route('/{id}'), new Info(['PUT'], 'update'));
        return $this;
    }

    public function addInfo(): self
    {
        $this->add('info', new Route('/{id}/info'), new Info(['GET'], 'getInfo'));
        return $this;
    }
}