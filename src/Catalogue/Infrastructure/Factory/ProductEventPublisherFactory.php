<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Factory;

use Task\App\Catalogue\Infrastructure\EventPublisher\ProductEventPublisher;
use Task\App\Common\Event\DomainEventSubscriber;

class ProductEventPublisherFactory
{
    private static ?ProductEventPublisher $instance = null;

    public function create(DomainEventSubscriber... $eventSubscribers): ProductEventPublisher
    {
        if (self::$instance === null) {
            self::$instance = new ProductEventPublisher($eventSubscribers);
        }

        return self::$instance;
    }
}
