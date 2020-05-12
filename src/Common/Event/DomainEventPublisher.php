<?php
declare(strict_types=1);

namespace Task\App\Common\Event;

abstract class DomainEventPublisher
{
    /** @var DomainEventSubscriber[] */
    private array $subscribers = [];

    /**
     * @param DomainEventSubscriber[] $subscribers
     */
    public function __construct(array $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function __clone()
    {
        throw new\BadMethodCallException('Clone is not supported');
    }

    public function publish(DomainEvent $anEvent)
    {
        foreach($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($anEvent)) {
                $subscriber->handle($anEvent);
            }
        }
    }
}
