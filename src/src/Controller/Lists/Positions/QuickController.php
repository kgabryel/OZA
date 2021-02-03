<?php

namespace App\Controller\Lists\Positions;

use App\Action\Additional\Lists\Positions\QuickActions;
use Symfony\Component\HttpFoundation\Response;

class QuickController extends PositionsController
{
    protected function getActive(): string
    {
        return '';
    }

    public function check($id, QuickActions $actions): Response
    {
        return $this->executeCheck($id, $actions);
    }

    public function uncheck($id, QuickActions $actions): Response
    {
        return $this->executeUncheck($id, $actions);
    }

    public function delete($id, QuickActions $actions): Response
    {
        return $this->executeDelete($id, $actions);
    }
}