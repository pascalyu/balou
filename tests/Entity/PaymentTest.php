<?php

namespace App\Tests\Entity;

use App\Entity\Animal\Category;
use App\Entity\Payment;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Request;

class PaymentTest extends AbstractTest
{

    public const URL = self::API .  '/payments';
    public const CONTEXT = 'Payment';

    public function testCreatePaymentDonation()
    {
        $client = self::createClient();
        $data = [];
        $response = $client->request(Request::METHOD_POST, self::URL, ['json' => $data]);
        $responseData = $this->getData($response);

        $this->assertEquals(Payment::STATUS_WAITING_FOR_PAYMENT, $responseData['status']);
        $this->assertEquals(Payment::DONATION_TYPE, $responseData['type']);
        $this->assertNotNull($responseData['locationUrl']);
    }
}
