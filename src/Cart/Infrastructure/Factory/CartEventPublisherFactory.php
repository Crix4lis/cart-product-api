<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\Factory;

use Task\App\Cart\Infrastructure\EventPublisher\CartEventPublisher;
use Task\App\Common\Event\DomainEventSubscriber;

class CartEventPublisherFactory
{
    private static ?CartEventPublisher $instance = null;

    public function create(DomainEventSubscriber... $eventSubscribers): CartEventPublisher
    {
        if (self::$instance === null) {
            self::$instance = new CartEventPublisher($eventSubscribers);
        }

        return self::$instance;
    }
}
