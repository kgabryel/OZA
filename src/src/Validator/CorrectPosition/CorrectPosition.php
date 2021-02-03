<?php

namespace App\Validator\CorrectPosition;

use App\Entity\User;
use App\Validator\Constraint;
use App\Validator\Types\ClassType;

class CorrectPosition extends Constraint
{
    private User $user;
    public string $message;

    public function __construct($options = null)
    {
        $this->message = 'Wybrany produkt nie jest poprawny.';
        $options = $this->modifyOptions(__CLASS__, $options);
        $this->user = $options['user'];
        parent::__construct($options);

    }

    public function getUser(): User
    {
        return $this->user;
    }

    protected function getDefaultOptions(): array
    {
        return [];
    }

    protected function getAvailableOptions(): array
    {
        return [
            'user'
        ];
    }

    protected function getOptionsTypes(): array
    {
        return [
            'user' => new ClassType(User::class)
        ];
    }

    protected function getRequired(): array
    {
        return $this->getAvailableOptions();
    }
}
