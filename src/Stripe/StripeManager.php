<?php

namespace App\Stripe;

use Stripe\Checkout\Session;

class StripeManager extends StripeClient
{
    public function getBalance()
    {
        return $this->getStripeClient()->balance->retrieve();
    }

    public function createCheckoutSession(int $amount, string $id)
    {
        $session = $this->getStripeClient()->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->getDefaultCurrency(),
                    'product_data' => [
                        'name' => 'Donation for Balou',
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:3000/donation_confirm/' . $id,
            'cancel_url' => 'http://localhost:3000/',
        ]);

        return $session;
    }
}
