<?php

namespace App\EventSubscriber;

use App\Entity\Animal\Category;
use App\EventSubscriber\Traits\Supports;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\Common\EventSubscriber;

class CategorySubscriber implements EventSubscriberInterface
{
    use Supports;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            SoftDeleteableListener::PRE_SOFT_DELETE,
        ];
    }

    public function preSoftDelete(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        if (!($entity instanceof Category)) {
            return;
        }
        $entity->removeAnimals();
        $this->em->persist($entity);
        $this->em->flush();
    }
}
