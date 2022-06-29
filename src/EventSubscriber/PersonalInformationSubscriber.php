<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Security\PersonalInformation;
use App\Entity\Security\User;
use App\EventSubscriber\Traits\Supports;
use App\Sendinblue\SendinblueManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use SendinBlue\Client\Model\SendSmtpEmailTo;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class PersonalInformationSubscriber implements EventSubscriberInterface
{
    use Supports;
    private $em;
    private $sendinblueManager;
    private $verifyEmailHelper;
    private $security;


    public function __construct(EntityManagerInterface $em, SendinblueManager $sendinblueManager, VerifyEmailHelperInterface $verifyEmailHelper, Security $security)
    {
        $this->em = $em;
        $this->sendinblueManager = $sendinblueManager;
        $this->verifyEmailHelper = $verifyEmailHelper;
        $this->security = $security;
    }



    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['onUserDataUpdate', EventPriorities::PRE_WRITE],
            ]
        ];
    }
    public function onUserDataUpdate(ViewEvent $event)
    {
        if (!$this->supports(
            $event,
            PersonalInformation::class,
            'api_personal_informations_post_collection'
        )) {
            return;
        }
        /** @var User $user */
        $user = $this->security->getUser();
        if ($user->getPersonalInformation() !== null ) {
        }
        /** @var PersonalInformation $personalInformation */
        $personalInformation = $event->getControllerResult();

        $personalInformation->setUser($user);
    }
}
