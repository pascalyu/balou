<?php

namespace App\Controller\Admin;

use App\Entity\Animal\Animal;
use App\Repository\AnimalRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class AnimalCrudControllerTest extends WebTestCase
{
    public  function testCreateAnimal()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, "/admin");
        $menuLink = $crawler->filter('a:contains("Animal")')->link();
        $crawler = $client->click($menuLink);
        $createLink = $crawler->filter('a:contains("Add Animal")')->link();
        $crawler = $client->click($createLink);
        $form = $crawler->selectButton('Create')->form();
        $token = $crawler->filter('#Animal__token')->attr('value');
        $animalData = ['name' => 'testAnimal'];
        $client->submit(
            $form,
            [
                'Animal[name]' => $animalData['name'],
                'Animal[lifeExpectancy]' => 10,
                'Animal[description]' => 'test description', 'Animal[category]' => 1, 'Animal[category]' => 1, 'Animal[_token]' => $token
            ]
        );
        $newAnimal = self::getContainer()->get('doctrine')->getRepository(Animal::class)->findOneBy(['name' => 'testAnimal']);

        $this->assertEquals($animalData['name'], $newAnimal->getName());
    }
}
