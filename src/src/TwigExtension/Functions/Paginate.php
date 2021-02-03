<?php

namespace App\TwigExtension\Functions;

use App\Services\Paginator;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Paginate extends AbstractExtension
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'paginate', [
                $this,
                'execute'
            ], ['is_safe' => ['html']]
            ),
        ];
    }

    public function execute(Paginator $paginator): string
    {
        return $this->environment->render(
            'theme/pagination.html.twig',
            ['paginator' => $paginator]
        );
    }
}