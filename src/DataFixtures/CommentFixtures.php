<?php

// src/DataFixtures/CommentFixtures.php
namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();

        // Récupérer tous les articles
        $articles = $manager->getRepository(Article::class)->findAll();


        // Créer 300 commentaires aléatoirement reliés à des articles et à des utilisateurs
        for ($i = 0; $i < 300; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->text);
            $comment->setCreatedAt($faker->dateTimeThisMonth);
            $comment->setAuthor($this->getReference(UserFixtures::USER_USER_REFERENCE));
            $comment->setIsActive($faker->boolean);
            $comment->setArticle($faker->randomElement($articles));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArticleFixtures::class,
            UserFixtures::class,
        ];
    }
}

