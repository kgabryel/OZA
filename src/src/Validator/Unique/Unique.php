<?php

namespace App\Validator\Unique;

use App\Validator\Constraint;
use App\Validator\Types\ClassType;
use App\Validator\Types\StringType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

class Unique extends Constraint
{

    public string $message;
    private string $column;
    private ServiceEntityRepositoryInterface $repository;

    public function __construct(array $options = [])
    {
        $this->message = 'Podana wartość jest już wykorzystywana.';
        $options = $this->modifyOptions(__CLASS__, $options);
        $this->column = $options['column'];
        $this->repository = $options['repository'];
        parent::__construct($options);
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getRepository(): ServiceEntityRepositoryInterface
    {
        return $this->repository;
    }

    protected function getDefaultOptions(): array
    {
        return [];
    }

    protected function getAvailableOptions(): array
    {
        return [
            'column',
            'repository'
        ];
    }

    protected function getOptionsTypes(): array
    {
        return [
            'column' => new StringType(),
            'repository' => new ClassType(ServiceEntityRepositoryInterface::class)
        ];
    }

    protected function getRequired(): array
    {
        return $this->getAvailableOptions();
    }
}
