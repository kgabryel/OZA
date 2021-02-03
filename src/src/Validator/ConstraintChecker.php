<?php


namespace App\Validator;

use App\Validator\Types\Type;
use Symfony\Component\Console\Exception\InvalidOptionException;

class ConstraintChecker
{
    private array $options;
    private array $defaultValues;
    private array $requiredOptions;
    /** @var Type[] */
    private array $optionsTypes;
    private string $className;

    public function __construct(
        array $options, array $defaultValues, array $requiredOptions, array $optionsTypes,
        string $class
    )
    {
        $this->options = $options;
        $this->defaultValues = $defaultValues;
        $this->requiredOptions = $requiredOptions;
        $this->optionsTypes = $optionsTypes;
        $this->className = $class;
    }

    public function insertDefaults(): void
    {
        foreach ($this->defaultValues as $key => $value) {
            if (!isset($this->options[$key])) {
                $this->options[$key] = $value;
            }
        }
    }

    public function checkRequired(): void
    {
        foreach ($this->requiredOptions as $name) {
            if (!isset($this->options[$name])) {
                throw new InvalidOptionException(
                    sprintf(
                        'The options "%s" must be set for constraint "%s".',
                        $name,
                        $this->className
                    )
                );
            }
        }
    }

    public function checkTypes(): void
    {
        /**
         * @var  Type $value
         */
        foreach ($this->optionsTypes as $key => $value) {
            if (!$value->check($this->options[$key])) {
                throw new InvalidOptionException(
                    sprintf(
                        'The options "%s" must be type of "%s" for constraint "%s".',
                        $key,
                        $value->getType(),
                        $this->className
                    )
                );
            }
        }
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}