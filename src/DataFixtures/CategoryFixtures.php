<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for($i=1 ; $i<=5 ; $i++){
            $description = "<p>";
            $description.= join($faker->paragraphs(mt_rand(3, 6)), '</p><p>');
            $description.= "</p>";

            $category = new Category();
            $category->setName($faker->sentence(mt_rand(2, 3)))
                    ->setDescription($description)
                    ->setHighlight(false)
                    ->setValidity(true);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
