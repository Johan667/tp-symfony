<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Entity\User;


class UserFixtures extends Fixture
{
    public const AUTHOR_USER_REFERENCE = 'author-user';
    public const USER_USER_REFERENCE = 'author-user-user';

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName);
            $user->setPassword($faker->password);
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt($faker->dateTimeThisMonth);
            $user->setUpdatedAt($faker->dateTimeThisMonth);

            $manager->persist($user);
        }

        for ($i = 0; $i < 10; $i++) {
            $admin = new User();
            $admin->setEmail($faker->email());
            $admin->setUsername($faker->userName);
            $admin->setPassword($faker->password);
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setCreatedAt($faker->dateTimeThisMonth);
            $admin->setUpdatedAt($faker->dateTimeThisMonth);

            $manager->persist($admin);
        }

        for ($i = 0; $i < 20; $i++) {
            $author = new User();
            $author->setEmail($faker->email());
            $author->setUsername($faker->userName);
            $author->setPassword($faker->password);
            $author->setRoles(['ROLE_AUTHOR']);
            $author->setCreatedAt($faker->dateTimeThisMonth);
            $author->setUpdatedAt($faker->dateTimeThisMonth);

            $manager->persist($author);


        }

        $manager->flush();
        $this->addReference(self::USER_USER_REFERENCE, $user);
        $this->addReference(self::AUTHOR_USER_REFERENCE, $author);
    }
}
