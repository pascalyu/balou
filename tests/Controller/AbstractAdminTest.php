<?php

namespace App\Tests\Controller;

use App\Entity\Animal\Animal;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractAdminTest extends WebTestCase
{

    public function getCreateEntityCrawler(string $entityName, $client)
    {
        $crawler = $client->request(Request::METHOD_GET, "/admin");
        $menuLink = $crawler->filter("a:contains('$entityName')")->link();
        $crawler = $client->click($menuLink);
        $createLink = $crawler->filter("a:contains('Add $entityName')")->link();
        $crawler = $client->click($createLink);
       
        return $crawler;
    }

    protected function getTokenFromCrawler(string $entityNametoken, $crawler)
    {
        return $crawler->filter("#$entityNametoken")->attr('value');
    }
}
