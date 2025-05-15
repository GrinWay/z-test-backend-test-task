<?php

namespace App\EventListener\Doctrine\Tender;

use App\Entity\Tender;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

#[AsEntityListener(event: Events::prePersist, entity: Tender::class)]
class SwitchOffAutoGenerateIdForSetIdEventListener
{
    public function __construct(
        private readonly EntityManagerInterface    $em,
        private readonly PropertyAccessorInterface $pa,
    )
    {
    }

    public function __invoke(Tender $tender, LifecycleEventArgs $event): void
    {
        $id = $this->pa->getValue($tender, 'id');
        if (null === $id) {
            return;
        }

        $classMetadata = $this->em->getClassMetadata(\get_class($tender));
        $classMetadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }
}
