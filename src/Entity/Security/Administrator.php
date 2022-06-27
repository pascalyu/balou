<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\AdministratorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdministratorRepository::class)]
#[ApiResource()]
class Administrator extends AbstractUser
{
    public function __construct()
    {
        $this->setRoles(['ROLE_ADMIN']);
    }

  
}
