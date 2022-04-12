<?php

namespace App\EventSubscriber\Traits;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

trait Supports
{
    public function supports($entity, $class)
    {
        return $entity instanceof $class;
    }
}
