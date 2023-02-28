<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Controle Blog');
    }

    public function configureMenuItems(): iterable
    {
        if ($this->isGranted('ROLE_AUTHOR')) {
            yield MenuItem::linkToCrud('Categorie', 'fa-solid fa-language', Category::class);
        } else {
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
            yield MenuItem::linkToCrud('Utilisateur', 'fa-solid fa-user', User::class);
            yield MenuItem::linkToCrud('Article', 'fa-sharp fa-solid fa-message', Article::class);
            yield MenuItem::linkToCrud('Commentaire', 'fa-solid fa-comment', Comment::class);
            yield MenuItem::linkToCrud('Categorie', 'fa-solid fa-language', Category::class);
        }
    }
}
