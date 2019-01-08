<?php

namespace App\DataFixtures;

use App\Entity\District;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DistrictFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // La key est inutile . Bravo
        $provinces = [
            'bx'=>'Bruxelles',
            'bw'=>'Brabant Wallon',
            'bf'=>'Brabant Flamand',
            'an'=>'Anvers',
            'lb'=>'Limbourg',
            'lg'=>'Liege',
            'na'=>'Namur',
            'ha'=>'Hainaut',
            'lx'=>'Luxembourg',
            'fx'=>'Flandre-Occidentale',
            'fr'=>'Flandre-Orientale'
        ];

        foreach($provinces as $province){
            $district = new District();
            $district->setName($province);
            $manager->persist($district);

            $this->addReference($province, $district);
        }

        $manager->flush();
    }
}
