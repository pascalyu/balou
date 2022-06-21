<?php

namespace App\EventSubscriber\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

trait Supports
{
    public function supports($event, $class, $route): bool
    {
        $object = $event->getControllerResult();
        
        return $object instanceof $class && $route == $event->getRequest()->get('_route');
    }
}
