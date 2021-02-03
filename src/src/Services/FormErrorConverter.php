<?php

namespace App\Services;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;

class FormErrorConverter
{
    private FormInterface $form;
    private array $errors;

    public function __construct(FormInterface $form)
    {
        $this->errors = [];
        $this->form = $form;
    }

    public function parse(): void
    {
        foreach ($this->form->getErrors(true, false) as $error) {
            if ($error instanceof FormError) {
                $this->parseMain($error);
            }
            if ($error instanceof FormErrorIterator) {
                $this->errors[$error->getForm()
                    ->getName()] = $this->setMessages($error->getForm());
            }
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function setMessages(FormInterface $errors): array
    {
        $data = $errors->all();
        $tmp = [];
        if ($data === []) {
            foreach ($errors->getErrors() as $error) {
                $tmp[] = $error->getMessage();
            }
            return $tmp;
        }
        /** @var Form $form */
        foreach ($data as $form) {
            $tmp[$form->getName()] = $this->setMessages($form);
        }
        return $tmp;
    }

    private function parseMain(FormError $error): void
    {
        $origin = $error->getOrigin();
        if ($origin === null) {
            $key = $this->form->getName();
        } else {
            $key = $origin->getName();
        }
        $this->errors[$key][] = $error->getMessage();
    }
}