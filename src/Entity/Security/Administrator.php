<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministratorRepository::class)]
#[ORM\Table(name: '`administrator`')]
#[ApiResource()]
class Administrator extends User
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
