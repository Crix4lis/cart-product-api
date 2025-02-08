<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\EventSubscriber;

use Task\App\Common\Event\DomainEvent;
use Task\App\Common\Event\DomainEventSubscriber;

class ExamplePrintHelloAllEventSubscriber implements DomainEventSubscriber
{
    public function handle(DomainEvent $domainEvent): void
    {
        print_r('HELLO! MY NAME IS ' . self::class .".");
    }

    public function isSubscribedTo(DomainEvent $domainEvent): bool
    {
        return true;
    }
}
