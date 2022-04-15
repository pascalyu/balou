<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response as ApiResponse;
use App\Entity\Animal\Animal;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public const USER_EMAIL = "user_test1@yopmail.com";
    public const USER_PASSWORD = "user_test1@yopmail.com";

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()
            ->get('doctrine')
            ->getManager();
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

    protected function assertGetEntities($url, $mandatoryKeys): void
    {
        $response = self::createPublicClient()->request(Request::METHOD_GET, $url);
        $items = $this->getItems($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertGreaterThan(0, count($items));
        $this->assertArrayHasKeys($mandatoryKeys, $items[0]);
    }

    protected function assertGetEntity($className, $fixtureName, $mandatoryKeys)
    {
        $animalIri = $this->findIriBy($className, ['name' => $fixtureName]);
        $response = self::createPublicClient()->request(Request::METHOD_GET, $animalIri);
        $item = $this->getItem($response);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertArrayHasKeys($mandatoryKeys, $item);
    }
}
