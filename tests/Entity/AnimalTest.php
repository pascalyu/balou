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
        $mandatoryKeys = ['@id', 'name', 'description', 'category', 'lifeExpectancy', 'firstPicture'];
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertGreaterThan(0, count($items));
        $this->assertArrayHasKeys($mandatoryKeys, $items[0]);
    }
}
