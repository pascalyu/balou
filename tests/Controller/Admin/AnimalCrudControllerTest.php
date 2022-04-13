<?php

namespace App\Controller\Admin;

use App\Entity\Animal\Animal;
use App\Tests\Controller\AbstractAdminTest;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AnimalCrudControllerTest extends AbstractAdminTest
{
    public function testCreateAnimal()
    {
        $client = static::createClient();
        $entityName = "Animal";
        $crawler =  $this->getCreateEntityCrawler($entityName, $client);
        $form = $crawler->selectButton('Create')->form();
        $entityNametoken = $entityName . "__token";
        $token = $this->getTokenFromCrawler($entityNametoken, $crawler);
        $animalData = ['name' => 'testAnimal', 'lifeExpectancy' => 10];
        $client->submit(
            $form,
            [
                'Animal[name]' => $animalData['name'],
                'Animal[lifeExpectancy]' => $animalData['lifeExpectancy'],
                'Animal[description]' => 'test description',
                'Animal[category]' => "1",
                'Animal[_token]' => $token
            ]
        );
        $newAnimal = self::getContainer()->get('doctrine')->getRepository(Animal::class)->findOneBy(['name' => 'testAnimal']);
        $this->assertEquals($animalData['name'], $newAnimal->getName());
        $this->assertEquals($animalData['lifeExpectancy'], $newAnimal->getLifeExpectancy());
    }
}
