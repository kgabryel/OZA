<?php

namespace App\TwigExtension\Functions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Select extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'select', [
                    $this,
                    'execute'
                ]
            ),
        ];
    }

    public function execute(bool $condition, string $correct, string $incorrect): string
    {
        return $condition ? $correct : $incorrect;
    }
}