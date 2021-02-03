<?php

namespace App\TwigExtension\Functions;

use App\Entity\Supply\Alert;
use App\Repository\Supply\AlertRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PreviousAlert extends AbstractExtension
{
    private AlertRepository $repository;

    public function __construct(AlertRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'previousAlert', [
                    $this,
                    'execute'
                ]
            ),
        ];
    }

    public function execute(Alert $alert): string
    {
        /** @var Alert $result */
        $result = $this->repository->createQueryBuilder('a')
            ->select('a')
            ->where('a.supply = :supply')
            ->andWhere('a.amount < :amount')
            ->setParameter(
                'supply',
                $alert->getSupply()
                    ->getId()
            )
            ->setParameter('amount', $alert->getAmount())
            ->orderBy('a.amount', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        if ($result !== null) {
            return $result->getAmount() . ' ' . $alert->getSupply()
                    ->getProduct()
                    ->getMeasure()
                    ->getShortcut();
        }
        return '-';
    }
}