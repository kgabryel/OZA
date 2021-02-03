<?php

namespace App\Services;

use App\Entity\Measure;
use App\Entity\Product\Product;
use App\Entity\Product\Stuff;
use App\Repository\MeasureRepository;

class MeasureFinder
{
    private MeasureRepository $repository;

    public function __construct(MeasureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function get(?Product $product, ?Stuff $stuff, int $id): ?Measure
    {
        if ($product === null && $stuff === null) {
            return null;
        }
        if ($product === null) {
            $product = $stuff->getProduct();
        }
        return $this->repository->findProductByIdAndUser($product, $id);
    }
}