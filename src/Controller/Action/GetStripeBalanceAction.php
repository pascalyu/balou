<?php

namespace App\Controller\Action;

use App\Entity\PictureGallery;
use App\Stripe\StripeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class GetStripeBalanceAction extends AbstractController
{
    #[Route('/get_balance_t', name: 'get_balance_t')]
    public function __invoke(StripeManager $stripeManagement)
    {
        $a= $stripeManagement->getBalance();
    }
}
