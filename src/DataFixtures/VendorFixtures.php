<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Locality;
use App\Entity\Postal;
use App\Entity\Town;
use App\Entity\Vendor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class VendorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for($i=1 ; $i<=3 ; $i++){

           //$description = "<p>";
            //$description.= join($faker->paragraphs(mt_rand(3, 6)), '</p><p>');
            //$description.= "</p>";

            $category = new Category();
            $category->setName($faker->sentence(mt_rand(2, 3)))
                ->setDescription($faker->sentence)
                ->setHighlight(false)
                ->setValidity(true);
            $manager->persist($category);

            for($j=1 ; $j<=5 ; $j++) {

                $postal = new Postal();
                $postal->setPostalCode($faker->numberBetween(2000, 5000));

                $manager->persist($postal);

                $locality = new Locality();
                $locality->setLocalityName($faker->city);

                $manager->persist($locality);

                $town = new Town();
                $town->setTownName($faker->citySuffix);

                $manager->persist($town);

                $vendor = new Vendor();

                $vendor->setPostalCode($postal)
                    ->setLocalityName($locality)
                    ->setTownName($town)
                    ->setDoorNumber($faker->numberBetween(0, 999))
                    ->setStreet($faker->streetName)
                    ->setBanned(false)
                    ->setEmail($faker->email)
                    ->setSubConf(false)
                    ->setSubDate($faker->dateTime)
                    ->setPassword($faker->password);

                $vendor->setContactMail($faker->companyEmail)
                    ->setName($faker->name)
                    ->setPhone($faker->phoneNumber)
                    ->setVat($faker->bankAccountNumber)
                    ->setWebsite($faker->url)
                    ->addCategory($category);

                $manager->persist($vendor);
            }
        }
        $manager->flush();
    }
}
