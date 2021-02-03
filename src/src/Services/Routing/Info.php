<?php

namespace App\Services\Routing;

class Info
{
    private array $methods;
    private string $action;
    private string $controller;

    public function __construct(array $methods, string $action, string $controller = '')
    {
        $this->methods = $methods;
        $this->action = $action;
        $this->controller = $controller;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getController(): string
    {
        return $this->controller;
    }
}