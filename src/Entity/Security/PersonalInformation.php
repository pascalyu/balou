<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Security\User;
use App\Repository\PersonalInformationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation as API;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PersonalInformationRepository::class)]
#[ApiResource(
    itemOperations: [
        "get",
        "patch" => [
            'method' => 'PATCH',
            "security" => "is_granted('IS_AUTHENTICATED_FULLY') and (object.uset == user) ",
        ],
    ],
    collectionOperations: [
        "post" => [
            'method' => 'POST',
            "security" => "is_granted('IS_AUTHENTICATED_FULLY')",
        ],
    ]
)]
class PersonalInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $phoneNumber;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('create_user')]
    private $streetName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('create_user')]
    private $zipCode;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $city;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $country;

    #[ORM\Column(type: 'text', nullable: true)]
    private $presentation;
    

    #[ORM\OneToOne(inversedBy: 'personalInformation', targetEntity: User::class, cascade: ['all'])]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(?string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {


        $this->user = $user;
        if ($user->getPersonalInformation() !== $this) {
             $user->setPersonalInformation($this);
         }
 
        return $this;
    }
}
