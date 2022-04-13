<?php

namespace App\Test\EventSubscriber;

use App\Entity\Animal\Animal;
use App\Entity\Animal\Category;
use App\EventSubscriber\CategorySubscriber;
use App\EventSubscriber\Traits\Supports;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gedmo\SoftDeleteable\SoftDeleteableListener;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategorySubscriberTest extends WebTestCase
{
    const  UNIQ_CATEGORY_NAME = 'UNIQ_CATEGORY_NAME';


    public function testEventSubscription()
    {
        $this->assertContains(SoftDeleteableListener::PRE_SOFT_DELETE, CategorySubscriber::getSubscribedEvents());
    }

    public function testPreSoftDelete()
    {
        $categoryMock = $this->getMockBuilder(Category::class)->getMock();
        $categoryMock->expects($this->once())
            ->method('removeAnimals');

        $eventMock = $this->getMockBuilder(LifecycleEventArgs::class)->disableOriginalConstructor()->getMock();
        $eventMock->expects($this->once())
            ->method('getObject')
            ->willReturn($categoryMock);

        $emMock = $this->getMockBuilder(EntityManagerInterface::class)->getMockForAbstractClass();
        $emMock->expects($this->once())
            ->method('persist');
        $emMock->expects($this->once())
            ->method('flush');

        /** @var EntityManagerInterface $emMock */
        /** @var LifecycleEventArgs $eventMock */
        (new CategorySubscriber($emMock))->preSoftDelete($eventMock);
    }
}
