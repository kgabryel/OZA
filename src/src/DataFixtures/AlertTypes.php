<?php

namespace App\DataFixtures;

use App\Entity\Alert\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AlertTypes extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $types = [
            [
                'Brak',
                'danger'
            ],
            [
                'Końcówka',
                'warning'
            ],
            [
                'Jeżeli jest promocja',
                'success'
            ],
            [
                'Informacja',
                'primary'
            ],
        ];
        foreach ($types as $type) {
            $manager->persist($this->create($type));
        }
        $manager->flush();
    }

    private function create(array $data): Type
    {
        $type = new Type();
        $type->setName($data[0]);
        $type->setType($data[1]);
        return $type;
    }
}
