<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

class DoctrineEventStore implements EventStore
{
    public function append(PersistableEvent $event): void
    {
        // TODO: Implement append() method.
    }
}
