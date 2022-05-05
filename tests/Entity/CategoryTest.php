<?php

namespace App\Tests\Entity;

use App\Entity\Animal\Category;
use App\Tests\AbstractTest;

class CategoryTest extends AbstractTest
{

    public const URL =self::API .  '/categories';
    public const CONTEXT = 'Category';
    private const mandatoryKeys = ['@id', 'name', 'description'];

    public function testExistTestCategory()
    {
        $categoryIri = $this->findIriBy(Category::class, ['name' => 'test']);
        $this->assertIsString($categoryIri);
        $this->assertTrue(true);
    }

    public function testGetCategories()
    {
        $this->assertGetEntities(self::URL, self::mandatoryKeys);
    }

    public function testGetCategory()
    {
        $this->assertGetEntity(Category::class, "test", self::mandatoryKeys);
    }
}
