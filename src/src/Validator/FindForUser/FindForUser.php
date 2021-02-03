<?php

namespace App\Validator\FindForUser;

use App\Entity\User;
use App\Repository\FilterForUser;
use App\Validator\Constraint;
use App\Validator\Types\BoolType;
use App\Validator\Types\ClassType;
use App\Validator\Types\ClosureType;
use App\Validator\Types\IntType;
use App\Validator\Types\StringType;
use Symfony\Component\Security\Core\User\UserInterface;

class FindForUser extends Constraint
{
    private User $user;
    private FilterForUser $repository;
    private string $columnName;
    private string $userColumn;
    private int $id;
    private bool $numeric;
    public string $message;
    private \Closure $getter;
    private bool $empty;

    public function __construct(array $options = null)
    {
        $options = $this->modifyOptions(__CLASS__, $options);
        $this->numeric = $options['numeric'];
        $this->id = $options['id'];
        $this->user = $options['user'];
        $this->repository = $options['repository'];
        $this->columnName = $options['columnName'];
        $this->userColumn = $options['userColumn'];
        $this->empty = $options['empty'];
        $this->message = $options['message'];
        $this->getter = $options['getter'];
        parent::__construct($options);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function isNumeric(): bool
    {
        return $this->numeric;
    }

    public function isEmpty(): bool
    {
        return $this->empty;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getRepository(): FilterForUser
    {
        return $this->repository;
    }

    public function getColumnName(): string
    {
        return $this->columnName;
    }

    public function getUserColumn(): string
    {
        return $this->userColumn;
    }

    protected function getDefaultOptions(): array
    {
        return [
            'numeric' => true,
            'userColumn' => 'user',
            'id' => 0,
            'getter' => self::getSimpleGetter()
        ];
    }

    /**
     * @return \Closure
     */
    public function getGetter(): \Closure
    {
        return $this->getter;
    }

    protected function getAvailableOptions(): array
    {
        return [
            'user',
            'repository',
            'columnName',
            'numeric',
            'id',
            'userColumn',
            'empty',
            'message',
            'getter'
        ];
    }

    protected function getOptionsTypes(): array
    {
        return [
            'user' => new ClassType(UserInterface::class),
            'repository' => new ClassType(FilterForUser::class),
            'id' => new IntType(),
            'columnName' => new StringType(),
            'numeric' => new BoolType(),
            'userColumn' => new StringType(),
            'empty' => new BoolType(),
            'message' => new StringType(),
            'getter' => new ClosureType()
        ];
    }

    protected function getRequired(): array
    {
        return [
            'user',
            'repository',
            'columnName',
            'empty',
            'message'
        ];
    }

    public static function getSimpleGetter(): \Closure
    {
        return static function($value) {
            return $value;
        };
    }

    public static function getIdGetter(): \Closure
    {
        return static function($value) {
            return $value->getId();
        };
    }
}
