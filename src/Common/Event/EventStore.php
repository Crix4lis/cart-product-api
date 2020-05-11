<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

interface EventStore
{
    public function append(PersistableEvent $event): void;
}
