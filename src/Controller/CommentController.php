<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/delete/{id}', name: 'app_comment_delete')]
    public function delete(Request $request, Comment $comment): Response
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
        return $this->redirect($request->headers->get('referer'));
    }

}
