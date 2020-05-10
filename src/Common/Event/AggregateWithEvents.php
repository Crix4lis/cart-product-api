<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

interface AggregateWithEvents
{
    /** @return DomainEvent[] */
    public function getEvents(): array;
    public function clearEvents(): void;
}
