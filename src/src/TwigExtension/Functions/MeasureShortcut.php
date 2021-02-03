<?php

namespace App\TwigExtension\Functions;

use App\Repository\MeasureRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MeasureShortcut extends AbstractExtension
{
    private MeasureRepository $repository;

    public function __construct(MeasureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'measureShortcut', [$this, 'execute']
            ),
        ];
    }

    public function execute($id = null): string
    {
        if ($id === null) {
            return '?';
        }
        $measure = $this->repository->find($id);
        return $measure !== null ? $measure->getShortcut() : '?';
    }
}