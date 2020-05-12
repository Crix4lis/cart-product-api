<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Task\App\Cart\Domain\Cart;
use Task\App\Common\Exception\DataLayerException;

class DoctrineEventStore extends ServiceEntityRepository implements EventStore
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * @param PersistableEvent $event
     *
     * @throws DataLayerException
     */
    public function append(PersistableEvent $event): void
    {
        $em = $this->getEntityManager();

        try {
            $em->persist($event);
        } catch (\Exception $e) {
            throw new DataLayerException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
