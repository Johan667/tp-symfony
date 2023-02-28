<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // trouver le role AUTHOR
        $authorUser = $manager->getRepository(User::class)->findOneBy(['roles' => ['ROLE_AUTHOR']]);


        for ($i = 0; $i < 100; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence);
            $article->setContent($faker->text);
            $article->setAuthor($authorUser);
            $article->setSlug($faker->sentence);
            $article->setStatus($faker->numberBetween(1, 4));
            $article->setCreatedAt($faker->dateTimeThisMonth);
            $article->setUpdatedAt($faker->dateTimeThisMonth);

            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
