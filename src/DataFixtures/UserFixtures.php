<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\User;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName);
            $user->setPassword($faker->password);
            $user->setRoles([$faker->randomElement(['ROLE_ADMIN', 'ROLE_USER','ROLE_AUTHOR'])]);
            $user->setCreatedAt($faker->dateTimeThisMonth);
            $user->setUpdatedAt($faker->dateTimeThisMonth);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
