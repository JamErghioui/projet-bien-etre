<?php

namespace App\DataFixtures;

use App\Entity\Locality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LocalityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $localities = json_decode(file_get_contents(__DIR__.'/belgique.json'), true);

        foreach($localities as $key => $row){
            $ref = $row['cp'];
            $locality = new Locality();
            $locality->setName($row['localité'])
                ->setZipcode($this->getReference($ref));

            $manager->persist($locality);

            $this->addReference($row['localité'].$key, $locality);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ZipCodeFixtures::class
        ];
    }

}
