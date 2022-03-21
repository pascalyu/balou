<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\PictureGallery;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PictureGallerySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => [
                ['onUploadPictureGallery', EventPriorities::PRE_WRITE],
            ]
        ];
    }

    public function onUploadPictureGallery(ViewEvent $event)
    {
        if (!$this->supports($event)) {
            return;
        }
        $pictureGallery = $event->getControllerResult();
    }
    private function supports(ViewEvent $event)
    {
        $pictureGallery = $event->getControllerResult();

        return
            $pictureGallery instanceof PictureGallery;
    }
}
