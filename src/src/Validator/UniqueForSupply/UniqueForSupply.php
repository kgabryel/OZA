<?php

namespace App\Validator\UniqueForSupply;

use App\Repository\Supply\AlertRepository;
use App\Validator\Constraint;
use App\Validator\Types\ClassType;
use App\Validator\Types\IntType;
use App\Validator\Types\StringType;

class UniqueForSupply extends Constraint
{
    private AlertRepository $repository;
    private string $column;
    private int $id;
    public string $message;

    public function __construct(array $options = [])
    {
        $this->message = 'Błędna wartość.';
        $options = $this->modifyOptions(__CLASS__, $options);
        $this->column = $options['column'];
        $this->id = $options['id'];
        $this->repository = $options['repository'];
        parent::__construct($options);
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getRepository(): AlertRepository
    {
        return $this->repository;
    }

    protected function getDefaultOptions(): array
    {
        return [];
    }

    protected function getAvailableOptions(): array
    {
        return[
          'column',
          'id',
          'repository'
        ];
    }

    protected function getOptionsTypes(): array
    {
        return[
          'column'=>new StringType(),
          'id'=>new IntType(),
          'repository'=>new ClassType(AlertRepository::class)
        ];
    }

    protected function getRequired(): array
    {
        return $this->getAvailableOptions();
    }
}
