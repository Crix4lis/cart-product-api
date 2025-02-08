<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Infrastructure\Repository;

use Task\App\Catalogue\Domain\Product;
use Task\App\Catalogue\Domain\Products;
use Task\App\Common\Event\AbstractEventPublisherRepositoryDecorator;
use Task\App\Common\Event\DomainEventPublisher;
use Task\App\Common\Event\EventStore;
use Task\App\Common\Exception\ConflictException;
use Task\App\Common\Exception\DataLayerException;
use Task\App\Common\Exception\NotFoundException;

class EventsPublisherProductsDecorator extends AbstractEventPublisherRepositoryDecorator implements Products
{
    private Products $products;

    public function __construct(Products $products, EventStore $eventStore, DomainEventPublisher $eventPublisher)
    {
        parent::__construct($eventStore, $eventPublisher);
        $this->products = $products;
    }

    /**
     * @param string $productId
     * @return Product
     *
     * @throws NotFoundException
     */
    public function getById(string $productId): Product
    {
        return $this->products->getById($productId);
    }

    /**
     * @param Product $product
     *
     * @throws ConflictException
     * @throws DataLayerException
     */
    public function save(Product $product): void
    {
        $eventsToPublish = $product->getEvents();
        $product->clearEvents();

        foreach ($eventsToPublish as $domainEvent) {
            //persist but do not flush yet
            $this->eventStore->append($domainEvent->getPersistableEvent());
        }
        //flashes all objects (products and events)
        $this->products->save($product);

        //when changes are saved within single transaction and there was no error, publish events
        foreach ($eventsToPublish as $domainEvent) {
            $this->eventPublisher->publish($domainEvent);
        }
    }
}
