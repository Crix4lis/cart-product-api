<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

abstract class AbstractEventPublisherRepositoryDecorator
{
    protected EventStore $eventStore;
    protected DomainEventPublisher $eventPublisher;

    public function __construct(EventStore $eventStore, DomainEventPublisher $eventPublisher)
    {
        $this->eventStore = $eventStore;
        $this->eventPublisher = $eventPublisher;
    }
}
