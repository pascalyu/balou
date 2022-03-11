<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AnimalTest extends KernelTestCase
{
    public function testSomething()
    {
        self::bootKernel();
        $this->assertTrue(true);
    }
}
