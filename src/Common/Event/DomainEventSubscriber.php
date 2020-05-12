<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

interface DomainEventSubscriber
{
    public function handle(DomainEvent $domainEvent): void;
    public function isSubscribedTo(DomainEvent $domainEvent): bool;
}
