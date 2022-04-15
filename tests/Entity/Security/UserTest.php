<?php

namespace App\Tests\Entity\Security;

use App\Entity\Security\User;
use App\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends AbstractTest
{
    public const URL = '/users';
    public const CONTEXT = 'user';

    public function testPostCreateUser()
    {
        $client = self::createClient();
        $email = "test2@yopamil.com";
        $data = [
            "email" => $email,
            "plainPassword" => $email
        ];
        $response = $client->request(Request::METHOD_POST, self::URL, ['json' => $data]);
        $responseData = $this->getData($response);
        /** @var User $user */
        $user =  self::getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(User::class)->findOneBy(['email' => $email]);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($email, $responseData['email']);
    }

    /**
     * @@dataProvider providerLoginCall
     */
    public function testLoginCall(array $jsonData, int $responseExpectation)
    {
        static::createClient()->request('POST', '/authentication_token', ['json' => $jsonData]);
        $this->assertResponseStatusCodeSame($responseExpectation);
    }

    public function providerLoginCall()
    {
        return [
            [
                [
                    'email' => self::USER_EMAIL,
                    'password' => self::USER_PASSWORD,
                ],
                Response::HTTP_OK
            ],
            [
                [
                    'email' => self::USER_EMAIL,
                    'password' => "wrong password",
                ],
                Response::HTTP_UNAUTHORIZED
            ],
            [
                [
                    'email' => 'wrong@email.com',
                    'password' => self::USER_EMAIL,
                ],
                Response::HTTP_UNAUTHORIZED
            ]
        ];
    }
}
