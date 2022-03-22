<?php

namespace App\Tests\Entity;

use App\Entity\Animal\Animal;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnimalTest extends AbstractTest
{

    public const URL = '/animals';
    public const CONTEXT = 'Animal';
    private const mandatoryKeys = ['@id', 'name', 'description', 'category', 'lifeExpectancy', 'firstPicture', 'createdAt'];

    public function testExistGriffon()
    {
        $animalIri = $this->findIriBy(Animal::class, ['name' => 'Griffon']);
        $this->assertIsString($animalIri);
        $this->assertTrue(true);
    }

    public function testGetAnimals()
    {
        $response = self::createPublicClient()->request(Request::METHOD_GET, self::URL);
        $items = $this->getItems($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertGreaterThan(0, count($items));
        $this->assertArrayHasKeys(self::mandatoryKeys, $items[0]);
    }

    public function testGetAnimal()
    {
        $animalIri = $this->findIriBy(Animal::class, ['name' => 'Griffon']);
        $response = self::createPublicClient()->request(Request::METHOD_GET, $animalIri);
        $item = $this->getItem($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertArrayHasKeys(self::mandatoryKeys, $item);
    }
}
