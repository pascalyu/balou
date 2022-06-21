<?php

namespace App\EventSubscriber\Payment;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Payment;
use App\EventSubscriber\Traits\Supports;
use App\Stripe\StripeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\Registry;

class PaymentSubscriber implements EventSubscriberInterface
{
    use Supports;
    private Registry $registry;
    private Security $security;
    private StripeManager $stripeManager;
    public function __construct(Registry $registry, Security $security, StripeManager $stripeManager)
    {
        $this->registry = $registry;
        $this->security = $security;
        $this->stripeManager = $stripeManager;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['onCreatePayment', EventPriorities::PRE_WRITE],
                ['setStripeUrl', EventPriorities::POST_WRITE]
            ]
        ];
    }

    public function onCreatePayment(ViewEvent $event)
    {
        $payment = $event->getControllerResult();
        if (!$this->supports($event, Payment::class, 'api_payments_post_collection')) {
            return;
        }
        /** @var Payment $payment */
        $payment->setPayedBy($this->security->getUser());
        $payment->setType(Payment::DONATION_TYPE);
        $payment->setPrice(100);
        $workflow = $this->registry->get($payment);
        $workflow->apply($payment, Payment::TRANSITION_CONFIRM_PAYMENT);
    }

    public function setStripeUrl(ViewEvent $event)
    {
        $payment = $event->getControllerResult();
        if (!$this->supports($event, Payment::class, 'api_payments_post_collection')) {
            return;
        }
        /** @var Payment $payment */
        $payment->setLocationUrl($this->stripeManager->createCheckoutSession($payment->getPrice(), $payment->getId())->url);
    }
}
