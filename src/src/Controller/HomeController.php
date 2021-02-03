<?php

namespace App\Controller;

use App\Action\Additional\NoteActions;
use App\Form\NoteForm;
use App\Messages\NoteMessages;
use App\Repository\Alert\AlertRepository;
use App\Repository\NoteRepository;
use App\Services\Makers\AssignedMaker;
use App\Services\UserCounts;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends BaseController
{
    private const INDEX_URL = 'home.index';
    private const INDEX_TEMPLATE = 'home/index';
    private bool $checked;

    public function __construct(UserCounts $userCounts)
    {
        parent::__construct($userCounts);
        $this->checked = false;
    }

    public function index(NoteRepository $noteRepository, AlertRepository $alertRepository
    ): Response
    {
        $form = $this->createForm(NoteForm::class);
        return $this->renderIndex($form, $alertRepository, $noteRepository);
    }

    public function delete($id, NoteActions $actions): Response
    {
        if (!$actions->find($id, $this->getUser())) {
            $this->addErrorMessage(NoteMessages::getMessage(NoteMessages::DELETE_INCORRECT));
        } else {
            $this->addSuccessMessage(NoteMessages::getMessage(NoteMessages::DELETE_CORRECT));
            $actions->delete();
        }
        return $this->redirect($this->generateUrl(self::INDEX_URL));
    }

    public function create(
        Request $request, NoteRepository $noteRepository, AlertRepository $alertRepository,
        AssignedMaker $maker
    ): Response
    {
        $form = $this->createForm(NoteForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $maker->setEntity($form->getData())
                ->create();
            $this->addSuccessMessage(NoteMessages::getMessage(NoteMessages::CREATED_CORRECTLY));
            return $this->redirect($this->generateUrl(self::INDEX_URL));
        }
        $this->checked = true;
        return $this->renderIndex($form, $alertRepository, $noteRepository);
    }

    private function renderIndex(
        FormInterface $form, AlertRepository $alertRepository, NoteRepository $noteRepository
    ): Response
    {
        $notes = $noteRepository->findBy(['user' => $this->getUser()]);
        $alerts = $alertRepository->findBy(
            [
                'user' => $this->getUser(),
                'isActive' => true
            ]
        );
        return $this->render(
            self::INDEX_TEMPLATE,
            [
                'notes' => $notes,
                'alerts' => $alerts,
                'createForm' => $form->createView(),
                'checked' => $this->checked
            ]
        );
    }

    protected function getActive(): string
    {
        return '';
    }
}
