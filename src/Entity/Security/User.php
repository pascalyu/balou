<?php

namespace App\Entity\Security;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\User\OwnUserInformation;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Payment;
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


    #[ORM\OneToMany(mappedBy: 'payedBy', targetEntity: Payment::class)]
    private $payments;

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
}
