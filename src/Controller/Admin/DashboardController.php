<?php

namespace App\Controller\Admin;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Category;
use App\Entity\Payment;
use App\Entity\PictureGallery;
use App\Entity\Security\Administrator;
use App\Entity\Security\User;
use App\Repository\PaymentRepository;
use App\Service\PaymentService;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('/bundles/EasyAdmin/page/content.html.twig', ['totalDonation' =>
        $this->paymentService->getTotalDonationReadable()]);
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
