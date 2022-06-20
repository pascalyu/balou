<?php

namespace App\Service;

use App\Entity\Payment;
use App\Repository\PaymentRepository;

class PaymentService
{
    private PaymentRepository $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function getTotalDonation(): int
    {
        $result = 0;
        $payments = $this->paymentRepository->findBy(['status' => Payment::STATUS_PAYMENT_COMPLETED]);
        foreach ($payments as $payment) {
            $result += $payment->getPrice();
        }
        return $result;
    }
}
