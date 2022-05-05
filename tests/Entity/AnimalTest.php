<?php

namespace App\Tests\Entity;

use App\Entity\Animal\Animal;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnimalTest extends AbstractTest
{

    public const URL = self::API . '/animals';
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
        $this->assertGetEntities(self::URL, self::mandatoryKeys);
    }

    public function testGetAnimal()
    {
        $this->assertGetEntity(Animal::class, 'Griffon', self::mandatoryKeys);
    }
}
