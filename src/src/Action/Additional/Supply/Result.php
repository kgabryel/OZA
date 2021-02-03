<?php

namespace App\Action\Additional\Supply;

class Result
{
    private array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isCorrect(): bool
    {
        return $this->errors === [];
    }
}