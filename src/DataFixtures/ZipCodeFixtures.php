<?php

namespace App\DataFixtures;

use App\Entity\ZipCode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ZipCodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $zipcodes = json_decode(file_get_contents(__DIR__.'/only-zip.json'), true);

        foreach($zipcodes as $row){
            $ref = $row['province'];
            $zipcode = new ZipCode();
            $zipcode->setNumber($row['cp'])
                ->setDistrict($this->getReference($ref));

            $manager->persist($zipcode);

            $this->addReference($row['cp'], $zipcode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            DistrictFixtures::class
        ];
    }
}
