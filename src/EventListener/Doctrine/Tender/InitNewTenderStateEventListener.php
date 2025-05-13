<?php

namespace App\EventListener\Doctrine\Tender;

use App\Entity\Tender;
use App\Type\Tender\TenderStateEnum;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::prePersist, entity: Tender::class)]
class InitNewTenderStateEventListener
{
    public function __invoke(Tender $tender, LifecycleEventArgs $event): void
    {
        if (null !== $tender->getState()) {
            return;
        }

        $tender->setState(TenderStateEnum::INIT);
    }
}
