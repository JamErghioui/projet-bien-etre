<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Vendor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class VendorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();

        for($i=1 ; $i<=3 ; $i++){

            $category = new Category();
            $category->setName($faker->sentence(mt_rand(2, 3)))
                ->setDescription($faker->sentence)
                ->setHighlight(false)
                ->setValidity(true);
            $manager->persist($category);

            for($j=1 ; $j<=5 ; $j++) {

                $vendor = new Vendor();

                $vendor->setDoorNumber($faker->numberBetween(0, 999))
                    ->setStreet($faker->streetName)
                    ->setBanned(false)
                    ->setEmail($faker->email)
                    ->setSubConf(false)
                    ->setSubDate($faker->dateTime)
                    ->setPassword($faker->password)
                    ->setDistrict($this->getReference('Bruxelles'))
                    ->setZipcode($this->getReference(1000))
                    ->setLocality($this->getReference('Ixelles4'));

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

    public function getDependencies()
    {
        return [
            LocalityFixtures::class
        ];
    }


}