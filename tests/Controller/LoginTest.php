<?php

namespace App\Tests\Controller;

use App\Entity\Security\Administrator;
use App\Repository\AdministratorRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginTest extends AbstractAdminTest
{

    public function testLogin()
    {
        $client = static::createClient();
        $client->request('GET', self::BASE_URL);
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertEquals("http://localhost/admin/login", $client->getRequest()->getUri());
        $client = $this->createConnectedClient($client);
        $client->request('GET', self::BASE_URL);
        $this->assertResponseIsSuccessful();
    }
}
