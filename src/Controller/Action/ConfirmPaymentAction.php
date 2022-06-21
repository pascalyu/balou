<?php

namespace App\Controller\Action;

use App\Entity\Payment;
use App\Entity\PictureGallery;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Workflow\Registry;
use Vich\UploaderBundle\Entity\File;

final class ConfirmPaymentAction extends AbstractController
{
    public function __invoke(Payment $data, Registry $registry)
    {
        $payment = $data;
        $workflow = $registry->get($data);
        $workflow->apply($payment, Payment::TRANSITION_COMPLETE_PAYMENT);
        return $payment;
    }
}
