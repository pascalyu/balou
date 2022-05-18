<?php

namespace App\Stripe;

use Stripe;
use Stripe\StripeClient as StripeStripeClient;

abstract class StripeClient
{
    protected $defaultCurrency;
    protected $testMode;
    protected $stripeClient;

    public function __construct(string $stripeSecretKey, string $defaultCurrency)
    {
        $this->stripeClient = new StripeStripeClient($stripeSecretKey);
        $this->testMode = false !== strpos($stripeSecretKey, 'sk_test_');
        $this->defaultCurrency = $defaultCurrency;
    }

    public function getStripeClient()
    {
        return $this->stripeClient;
    }

    public function getDefaultCurrency()
    {
        return $this->defaultCurrency;
    }
}
