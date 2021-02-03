<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraint as Tmp;

abstract class Constraint extends Tmp
{
    public function __construct(array $options)
    {
        foreach ($this->getAvailableOptions() as $name) {
            unset($options[$name]);
        }
        parent::__construct($options);
    }

    protected function modifyOptions(string $className, array $options = null): array
    {
        if (is_null($options)) {
            $options = [];
        }
        $checker = new ConstraintChecker(
            $options,
            $this->getDefaultOptions(),
            $this->getRequired(),
            $this->getOptionsTypes(),
            $className
        );
        $checker->insertDefaults();
        $checker->checkRequired();
        $checker->checkTypes();
        return $checker->getOptions();
    }

    abstract protected function getDefaultOptions(): array;

    abstract protected function getAvailableOptions(): array;

    abstract protected function getOptionsTypes(): array;

    abstract protected function getRequired(): array;
}