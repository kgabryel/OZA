<?php

namespace App\Services;

use App\Model\UserModel;
use App\Security\FormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationService
{
    private const PROVIDER = 'main';
    private Request $request;
    private GuardAuthenticatorHandler $guardHandler;
    private FormAuthenticator $authenticator;
    private EntityManagerInterface $manager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(
        RequestStack $requestStack, GuardAuthenticatorHandler $guardHandler,
        FormAuthenticator $authenticator, EntityManagerInterface $manager,
        UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->guardHandler = $guardHandler;
        $this->authenticator = $authenticator;
        $this->manager = $manager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function register(UserModel $model): UserInterface
    {
        $user = $model->getUser($this->passwordEncoder);
        $this->manager->persist($user);
        $this->manager->flush();
        return $user;
    }

    public function authenticate(UserInterface $user): ?Response
    {
        return $this->guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $this->request,
            $this->authenticator,
            self::PROVIDER
        );
    }
}