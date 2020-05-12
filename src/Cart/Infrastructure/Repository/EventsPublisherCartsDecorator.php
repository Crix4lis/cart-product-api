<?php
declare(strict_types=1);

namespace Task\App\Cart\Infrastructure\Repository;

use Task\App\Cart\Domain\Cart;
use Task\App\Cart\Domain\Carts;
use Task\App\Common\Event\AbstractEventPublisherRepositoryDecorator;
use Task\App\Common\Event\DomainEventPublisher;
use Task\App\Common\Event\EventStore;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class EventsPublisherCartsDecorator extends AbstractEventPublisherRepositoryDecorator implements Carts
{
    private Carts $products;

    public function __construct(Carts $carts, EventStore $eventStore, DomainEventPublisher $eventPublisher)
    {
        parent::__construct($eventStore, $eventPublisher);
        $this->products = $carts;
    }

    /**
     * @param string $cartId
     * @return Cart
     *
     * @throws NotFoundException
     */
    public function getById(string $cartId): Cart
    {
        return $this->products->getById($cartId);
    }

    /**
     * @param Cart $cart
     *
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function save(Cart $cart): void
    {
        $eventsToPublish = $cart->getEvents();
        $cart->clearEvents();

        foreach ($eventsToPublish as $domainEvent) {
            //persist but do not flush yet
            $this->eventStore->append($domainEvent->getPersistableEvent());
        }
        //flashes all objects (carts and events)
        $this->products->save($cart);

        //when changes are saved within single transaction and there was no error, publish events
        foreach ($eventsToPublish as $domainEvent) {
            $this->eventPublisher->publish($domainEvent);
        }
    }
}
