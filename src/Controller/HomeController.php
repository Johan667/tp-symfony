<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $lastArticle = $this->entityManager->getRepository(Article::class)->findBy([], ['createdAt' => 'DESC'], 10);
        $categories = $this->entityManager
            ->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->innerJoin('c.articles', 'a')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();

        return $this->render('home/index.html.twig', [
            'categories'=>$categories,
            'lastArticle'=>$lastArticle,
        ]);
    }
}
