<?php

namespace App\Action\Additional;

use App\Entity\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;

/** @method Note getEntity()() */

/** @property Note $entity */
class NoteActions extends Actions
{
    public function __construct(
        EntityManagerInterface $manager, NoteRepository $repository
    )
    {
        parent::__construct($manager, $repository);
    }
}