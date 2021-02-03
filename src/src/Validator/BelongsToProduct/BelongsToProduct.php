<?php

namespace App\Validator\BelongsToProduct;

use App\Entity\Product\Product;
use App\Validator\Constraint;
use App\Validator\Types\ClassType;
use App\Validator\Types\StringType;

class BelongsToProduct extends Constraint
{
    private Product $product;
    public string $message;

    public function __construct($options = null)
    {
        $options = $this->modifyOptions(__CLASS__, $options);
        $this->product = $options['product'];
        $this->message = $options['message'];
        parent::__construct($options);
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    protected function getDefaultOptions(): array
    {
        return [];
    }

    protected function getAvailableOptions(): array
    {
        return [
            'product',
            'message'
        ];
    }

    protected function getOptionsTypes(): array
    {
        return [
            'product' => new ClassType(Product::class),
            'message' => new StringType()
        ];
    }

    protected function getRequired(): array
    {
        return $this->getAvailableOptions();
    }
}
