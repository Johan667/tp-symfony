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

        // Récupérer tous les utilisateurs qui n'ont pas les rôles ROLE_ADMIN ou ROLE_AUTHOR
        $users = $manager->getRepository(User::class)->findBy(['roles' => ['ROLE_USER']]);

        // Créer 300 commentaires aléatoirement reliés à des articles et à des utilisateurs
        for ($i = 0; $i < 300; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->text);
            $comment->setCreatedAt($faker->dateTimeThisMonth);
            $comment->setIsActive($faker->boolean);
            $comment->setArticle($faker->randomElement($articles));
            $comment->setAuthor($faker->randomElement($users));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
            UserFixtures::class,
        ];
    }
}

