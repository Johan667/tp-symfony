<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $category->setColor($faker->numberBetween(1, 9));
            $category->setCreatedAt($faker->dateTimeThisMonth);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
