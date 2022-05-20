<?php

namespace App\Stripe;

use Stripe\Checkout\Session;

class StripeManager extends StripeClient
{
    public function getBalance()
    {
        return $this->getStripeClient()->balance->retrieve();
    }

    public function createCheckoutSession()
    {
        $session = $this->getStripeClient()->checkout->sessions->create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->getDefaultCurrency(),
                    'product_data' => [
                        'name' => 'Donation for Balou',
                    ],
                    'unit_amount' => 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:3000/thanks',
            'cancel_url' => 'http://localhost:3000/',
        ]);

        return $session;
    }
}
