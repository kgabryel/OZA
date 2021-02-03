<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\UserCounts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/** @method User getUser() */
abstract class BaseController extends AbstractController
{
    public const SUCCESS_MESSAGE = 'successMessage';
    public const ERROR_MESSAGE = 'errorMessage';
    private UserCounts $userCounts;

    public function __construct(
        UserCounts $userCounts
    )
    {
        $this->userCounts = $userCounts;
    }

    abstract protected function getActive(): string;

    protected function addSuccessMessage(string $message): void
    {
        $this->addFlash(self::SUCCESS_MESSAGE, $message);
    }

    protected function addErrorMessage(string $message): void
    {
        $this->addFlash(self::ERROR_MESSAGE, $message);
    }

    protected function render(string $view, array $parameters = [], Response $response = null
    ): Response
    {
        $parameters['active'] = $this->getActive();
        $parameters['counts'] = $this->userCounts->getMenuCounts();
        $parameters['activeAlerts'] = $this->userCounts->getActiveAlerts();
        return parent::render($view . '.html.twig', $parameters, $response);
    }
}