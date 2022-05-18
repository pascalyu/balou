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
    private Registry $workflowRegistry;
    private Security $security;
    private StripeManager $stripeManager;
    public function __construct(Registry $workflowRegistry, Security $security, StripeManager $stripeManager)
    {
        $this->workflowRegistry = $workflowRegistry;
        $this->security = $security;
        $this->stripeManager = $stripeManager;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['onCreatePayment', EventPriorities::PRE_WRITE],
                ['changeHeaderLocation', EventPriorities::POST_SERIALIZE],
            ]
        ];
    }

    public function onCreatePayment(ViewEvent $event)
    {
        $payment = $event->getControllerResult();
        if (!$this->supports($payment, Payment::class)) {
            return;
        }

        /** @var Payment $payment */
        $payment->setPayedBy($this->security->getUser());
        $payment->setLocationUrl($this->stripeManager->createCheckoutSession()->url);
    }

    public function changeHeaderLocation(ViewEvent $event)
    {
    }
}
