<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\User\OwnUserInformation;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Payment;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
        "post" => [
            'validation_groups' => ['create_user']
        ],
        "get_me" =>
        [
            "path" => "/me",
            "method" => "GET",
            "controller" => OwnUserInformation::class,
            "normalization_context" => ["groups" => ["owner_data"]],
        ]

    ]
)]


class User extends AbstractUser
{

    #[ORM\OneToMany(mappedBy: 'payedBy', targetEntity: Payment::class)]
    private $payments;

    #[ORM\Column(type: 'boolean')]
    private $isEnabled = false;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }
    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setPayedBy($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getPayedBy() === $this) {
                $payment->setPayedBy(null);
            }
        }

        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
