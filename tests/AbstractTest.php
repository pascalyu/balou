<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response as ApiResponse;


abstract class AbstractTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function setUp(): void
    {
        self::bootKernel();
    }

    protected function createPublicClient(): Client
    {
        return static::createClient();
    }

    protected function assertCollection(string $context, string $iri): void
    {
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertJsonContains([
            '@context' => '/contexts/' . $context,
            '@id'      => $iri,
            '@type'    => 'hydra:Collection',
        ]);
    }

    protected function assertArrayHasKeys(array $keys, array $array): void
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array);
        }
    }

    protected function assertItem(string $context, string $iri): void
    {
        $this->assertJsonContains([
            '@context' => '/contexts/' . $context,
            '@id'      => $iri,
            '@type'    => $context,
        ]);
    }

    protected function assertDenied(): void
    {
        $this->assertJsonContains([
            "@context" => "/contexts/Error",
            "@type" => "hydra:Error",
            "hydra:title" => "An error occurred",
            "hydra:description" => "Access Denied."
        ]);
    }

    protected function getItems(ApiResponse $response): array
    {
        $content = json_decode($response->getContent(), true);

        return $content['hydra:member'];
    }
    protected function getItem(ApiResponse $response): array
    {
        return $this->getData($response);
    }

    protected function getAssertViolation(string $propertyPath, string $msg): callable
    {
        return function () use ($propertyPath, $msg) {
            $this->assertViolation($propertyPath, $msg);
        };
    }

    protected function assertViolation(string $propertyPath, ?string $msg = null)
    {
        $violation = array_merge(["propertyPath" => $propertyPath], $msg ? ['message' => $msg] : []);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->assertJsonContains(["violations" => [$violation]]);
    }

    protected function getData(ApiResponse $response): array
    {
        return json_decode($response->getContent(), true);
    }

    protected function assertDateDesc(array $items, string $field)
    {
        $date = null;
        foreach ($items as $item) {
            $itemDate = new \DateTime($item[$field]);
            if ($date) {
                $this->assertGreaterThanOrEqual($itemDate, $date);
            }
            $date = $itemDate;
        }
    }
    protected function assertDateAsc(array $items, string $field)
    {
        $date = null;
        foreach ($items as $item) {
            $itemDate = new \DateTime($item[$field]);
            if ($date) {
                $this->assertLessThanOrEqual($itemDate, $date);
            }
            $date = $itemDate;
        }
    }
}
