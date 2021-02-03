<?php

namespace App\Controller;

use App\Form\RegisterForm;
use App\Services\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @return Response
     */
    public function showLogin(): Response
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @return Response
     */
    public function showRegister(): Response
    {
        $form = $this->createForm(RegisterForm::class);
        return $this->render(
            'security/register.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Request $request
     * @param RegistrationService $registration
     *
     * @return Response
     */
    public function register(
        Request $request, RegistrationService $registration
    ): Response
    {
        $form = $this->createForm(RegisterForm::class, null, ['csrf_protection' => false]);
        $form->handleRequest($request);
        if ($form->isValid()) {
            return $registration->authenticate($registration->register($form->getData()));
        }
        $this->addFlash('checked', true);
        return $this->render(
            'security/register.html.twig',
            ['form' => $form->createView()]
        );
    }

    public function logout()
    {
    }
}
