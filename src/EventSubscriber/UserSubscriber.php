<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Security\User;
use App\EventSubscriber\Traits\Supports;
use App\Sendinblue\SendinblueManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SendinBlue\Client\Model\SendSmtpEmailTo;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class UserSubscriber implements EventSubscriberInterface
{
    use Supports;
    private $em;
    private $sendinblueManager;
    private $verifyEmailHelper;

    public function __construct(EntityManagerInterface $em, SendinblueManager $sendinblueManager, VerifyEmailHelperInterface $verifyEmailHelper)
    {
        $this->em = $em;
        $this->sendinblueManager = $sendinblueManager;
        $this->verifyEmailHelper = $verifyEmailHelper;
    }



    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['sendMailPostWrite', EventPriorities::POST_WRITE],
                ['onUserCreation', EventPriorities::PRE_WRITE],
            ]
        ];
    }
    public function onUserCreation(ViewEvent $event)
    {
        if (!$this->supports($event, User::class, 'api_users_post_collection')) {
            return;
        }
        /** @var User $user */
        $user = $event->getControllerResult();
        if ($user->getWantToBePetsitter()) {
            $user->setRoles(['ROLE_PETSITTER']);
        }
    }
    
    public function sendMailPostWrite(ViewEvent $event)
    {
        if (!$this->supports($event, User::class, 'api_users_post_collection')) {
            return;
        }
        $user = $event->getControllerResult();
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            'registration_confirmation_route',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId()]
        );

        $recipient = (new SendSmtpEmailTo())
            ->setName($user->getEmail())
            ->setEmail($user->getEmail());
        $this->sendinblueManager->sendFromTemplate($recipient, SendinblueManager::MAIL_CONFIRMATION, [
            'link' => $signatureComponents->getSignedUrl(),
        ]);
    }

    private function sendConfirmationMail()
    {
        //todo factoriser

    }
}
