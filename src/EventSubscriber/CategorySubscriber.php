<?php

namespace App\EventSubscriber;

use App\Entity\Animal\Category;
use App\EventSubscriber\Traits\Supports;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Doctrine\Common\EventSubscriber;

class CategorySubscriber implements EventSubscriber
{
    use Supports;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public  function getSubscribedEvents()
    {
        return [
            SoftDeleteableListener::PRE_SOFT_DELETE,
        ];
    }

    public function preSoftDelete(LifecycleEventArgs $event)
    {
        $entity = $event->getObject();
        if (!$this->supports($entity, Category::class)) {
            return;
        }
        $entity->removeAnimals();
        $this->em->persist($entity);
        $this->em->flush();
    }
}
