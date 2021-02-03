<?php

namespace App\Model;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserModel
{
    /** @var ?string */
    private $email;
    /** @var ?string */
    private $password;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return UserInterface
     */
    public function getUser(UserPasswordEncoderInterface $passwordEncoder): UserInterface
    {
        $user = new User();
        $user->setEmail($this->email);
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $this->password
            )
        );
        return $user;
    }
}