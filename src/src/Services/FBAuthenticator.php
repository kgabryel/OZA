<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class FBAuthenticator
{
    private Facebook $facebook;
    private array $userInfo;
    private User $user;
    private string $path;
    public const FB_ACCOUNT_TYPE = 2;

    public function __construct(Facebook $facebook, string $path)
    {
        $this->userInfo = [];
        $this->facebook = $facebook;
        $this->path = $path;
    }

    public function redirect(): RedirectResponse
    {
        $helper = $this->facebook->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl($this->path);
        return new RedirectResponse($loginUrl);
    }

    /**
     * @return $this
     * @throws FacebookSDKException
     */
    public function getUserInfo(): self
    {
        $helper = $this->facebook->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken();
        $response = $this->facebook->get('/me?fields=email,id,name', $accessToken);
        $this->userInfo = $response->getDecodedBody();
        return $this;
    }

    public function userExists(UserRepository $repository): bool
    {
        return $repository->findOneBy(
                [
                    'fbId' => $this->userInfo['id'],
                    'userType' => self::FB_ACCOUNT_TYPE
                ]
            ) !== null;
    }

    public function createUser(EntityManagerInterface $manager): self
    {
        $this->user = new User();
        $this->user->setUserType(self::FB_ACCOUNT_TYPE);
        $this->user->setEmail($this->userInfo['email'] ?? '');
        $this->user->setName($this->userInfo['name'] ?? '');
        $this->user->setFbId($this->userInfo['id']);
        $this->user->setPassword('');
        $manager->persist($this->user);
        $manager->flush();
        return $this;
    }

    public function getUser(UserRepository $repository): self
    {
        $this->user = $repository->findOneBy(
            [
                'fbId' => $this->userInfo['id'],
                'userType' => self::FB_ACCOUNT_TYPE
            ]
        );
        return $this;
    }

    public function authenticate(
        TokenStorageInterface $tokenStorage, Session $session
    ): void
    {
        $token = new UsernamePasswordToken($this->user, null, 'main', $this->user->getRoles());
        $tokenStorage->setToken($token);
        $session->set('_security_main', serialize($token));
    }
}