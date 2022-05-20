<?php

namespace App\Controller\Admin;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Category;
use App\Entity\Payment;
use App\Entity\PictureGallery;
use App\Entity\Security\Administrator;
use App\Entity\Security\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Balou');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Animal', 'fas fa-list', Animal::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('PictureGallery', 'fas fa-list', PictureGallery::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Admin', 'fas fa-list', Administrator::class);
        yield MenuItem::linkToCrud('Payment', 'fas fa-list', Payment::class);

    }
}
