<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Form\CommentType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/article', name: 'app_article')]
    public function index(): Response
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', [
            'articles'=>$articles,
        ]);
    }

    /**
     * @Route("/articles/category/{category}", name="app_article_by_category")
     * @ParamConverter("category", class="App\Entity\Category")
     */
    public function articlesByCategory(Category $category)
    {
        $articles = $this->entityManager
            ->getRepository(Article::class)
            ->findByCategory($category);

        return $this->render('article/ArticleCategory.html.twig', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }


    #[Route('/article/{slug}', name: 'app_article_slug')]
    public function show($slug, Request $request): Response
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['slug' => $slug]);
        $comments = $this->entityManager->getRepository(Comment::class)->findby(['article'=>$article]);

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $date = new DateTimeImmutable();

            $comment
                ->setContent($commentForm->get('content')->getData())
                ->setAuthor($this->getUser())
                ->setCreatedAt($date)
                ->setIsActive(true)
                ->setArticle($article);


            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_article_slug', ['slug' => $article->getSlug()]);

        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm'=>$commentForm,
            'comments'=>$comments,
        ]);
    }


    #[Route('/article', name: 'app_article_search')]
    public function searchArticle(): Response
    {
        return $this->render('article/search.html.twig', [

        ]);
    }
}
