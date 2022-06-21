<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Action\ConfirmPaymentAction;
use App\Entity\Security\User;
use App\Entity\Traits\TimestampableEntity;
use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentRepository::class)]
#[ApiResource(
    itemOperations: [
        "get",
        "confirm_payment" => [
            "path" => "/payments/{id}/confirm",
            "method" => "POST",
            "controller" => ConfirmPaymentAction::class,
        ]
    ],

    collectionOperations: [
        "post",

    ]
)]
class Payment
{
    use TimestampableEntity;
    public const  STATUS_CREATED = "created";
    public const  STATUS_WAITING_FOR_PAYMENT = "waiting_for_payment";
    public const  STATUS_PAYMENT_PROCESSING = "payment_processing";
    public const  STATUS_WAITING_FOR_PAYMENT_PROPOSED = "waiting_for_payment_proposed";
    public const  STATUS_PAYMENT_COMPLETED = "payment_completed";
    public const  STATUS_PAYOUT_COMPLETED = "payout_completed";
    public const  STATUS_PAYMENT_DECLINED = "payment_declined";
    public const  STATUS_CANCELED = "canceled";
    public const  STATUS_REFUNDED = "refunded";

    public const  TRANSITION_CONFIRM_PAYMENT = "confirm_payment";
    public const  TRANSITION_PROPOSE_PAYMENT = "propose_payment";
    public const  TRANSITION_COMPLETE_PAYMENT = "complete_payment";
    public const  TRANSITION_PAYOUT = "payout";
    public const  TRANSITION_DECLINE_PAYMENT = "decline_payment";
    public const  TRANSITION_CANCEL_ORDER = "cancel_order";
    public const  TRANSITION_REFUND_PAYMENT = "refund_payment";

    public const  DONATION_TYPE = "DONATION";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $price;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $status = self::STATUS_CREATED;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'payments')]
    private $payedBy;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stripeSessionId;

    private $locationUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status, $context = []): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayedBy(): ?User
    {
        return $this->payedBy;
    }

    public function setPayedBy(?User $payedBy): self
    {
        $this->payedBy = $payedBy;

        return $this;
    }

    public function getStripeSessionId(): ?string
    {
        return $this->stripeSessionId;
    }

    public function setStripeSessionId(?string $stripeSessionId): self
    {
        $this->stripeSessionId = $stripeSessionId;

        return $this;
    }

    public function getLocationUrl(): string
    {
        return $this->locationUrl;
    }

    public function setLocationUrl(string $locationUrl): self
    {
        $this->locationUrl = $locationUrl;
        return $this;
    }
}
