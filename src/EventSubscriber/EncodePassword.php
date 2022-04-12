<?php

namespace App\EventSubscriber;

use App\Entity\Security\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EncodePassword implements EventSubscriber
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $this->hashPassword($entity);
    }


    private function hashPassword(User $entity): void
    {
        if (!$entity->getPlainPassword()) {
            return;
        }
        $encoded = $this->passwordEncoder->hashPassword(
            $entity,
            $entity->getPlainPassword()
        );

        $entity->setPassword($encoded);
    }
}
