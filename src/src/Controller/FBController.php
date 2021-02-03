<?php

namespace App\Controller;

use App\Messages\LoginErrors;
use App\Repository\UserRepository;
use App\Services\FBAuthenticator;
use App\Services\FBFactory;
use Doctrine\ORM\EntityManagerInterface;
use Facebook\Exceptions\FacebookSDKException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class FBController extends AbstractController
{
    private const FB_URL = 'fb.login';
    private const LOGIN_SHOW_URL = 'login.show';
    private const HOME_URL = 'home.index';

    public function __construct(SessionInterface $session)
    {
        $session->start();
    }

    public function auth()
    {
        try {
            $authenticator = new FBAuthenticator(
                FBFactory::getInstance(),
                $this->generateUrl(self::FB_URL, [], UrlGeneratorInterface::ABSOLUTE_URL)
            );
        } catch (FacebookSDKException $e) {
            $this->addFlash(
                BaseController::ERROR_MESSAGE,
                LoginErrors::getError(LoginErrors::FB_ERROR)
            );
            return new RedirectResponse($this->generateUrl(self::LOGIN_SHOW_URL));
        }
        return $authenticator->redirect();
    }

    public function login(
        EntityManagerInterface $manager, TokenStorageInterface $tokenStorage, Session $session,
        UserRepository $repository
    )
    {
        try {
            $authenticator = new FBAuthenticator(
                FBFactory::getInstance(),
                $this->generateUrl(self::FB_URL, [], UrlGeneratorInterface::ABSOLUTE_URL)
            );
            $authenticator->getUserInfo();
        } catch (FacebookSDKException $e) {
            $this->addFlash(
                BaseController::ERROR_MESSAGE,
                LoginErrors::getError(LoginErrors::FB_ERROR)
            );
            return new RedirectResponse($this->generateUrl(self::LOGIN_SHOW_URL));
        }
        if (!$authenticator->userExists($repository)) {
            $authenticator->createUser($manager);
        } else {
            $authenticator->getUser($repository);
        }
        $authenticator->authenticate($tokenStorage, $session);
        return new RedirectResponse($this->generateUrl(self::HOME_URL));
    }
}
