<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\User\OwnUserInformation;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(
    itemOperations: [

        "get" =>
        [
            "security" => "is_granted('ROLE_ADMIN')"
        ]

    ],
    collectionOperations: [
        "post",
        "get_me" =>
        [
            "path" => "/me",
            "method" => "GET",
            "controller" => OwnUserInformation::class
        ]
    ]
)]


class User extends AbstractUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
