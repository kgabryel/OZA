<?php

namespace App\Action;

class Template
{
    private string $name;
    private array $options;

    public function __construct(string $name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function addOption(string $key, $value): self
    {
        $this->options[$key] = $value;
        return $this;
    }
}