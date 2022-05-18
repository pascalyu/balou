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
                        'name' => 'T-shirt',
                    ],
                    'unit_amount' => 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'https://example.com/success',
            'cancel_url' => 'https://example.com/cancel',
        ]);

        return $session;
    }
}
