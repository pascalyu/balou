<?php

namespace App\Tests\Controller;

use App\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractAdminTest extends WebTestCase
{
    const EMAIL_ADMIN = "admin_test1@yopmail.com";
    public const BASE_URL = "/admin";
    public const ADMIN = "admin";
    public function getCreateEntityCrawler(string $entityName, $client)
    {
        $crawler = $client->request(Request::METHOD_GET, self::BASE_URL);
        $menuLink = $crawler->filter("a:contains('$entityName')")->link();
        $crawler = $client->click($menuLink);
        $createLink = $crawler->filter("a:contains('Add $entityName')")->link();
        $crawler = $client->click($createLink);

        return $crawler;
    }

    protected function createConnectedClient($client)
    {
        $userRepository = static::getContainer()->get(AdministratorRepository::class);
        $testUser = $userRepository->findOneBy(['email' => self::EMAIL_ADMIN]);
        $client->loginUser($testUser, self::ADMIN);
        return $client;
    }

    protected function getTokenFromCrawler(string $entityNametoken, $crawler)
    {
        return $crawler->filter("#$entityNametoken")->attr('value');
    }
}
