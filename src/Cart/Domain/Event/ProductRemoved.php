<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Event;

use Task\App\Common\Event\DomainEvent;
use Task\App\Common\Event\PersistableEvent;

class ProductRemoved implements DomainEvent
{
    private string $fromCartId;
    private string $productId;

    public function __construct(string $fromCartId, string $productId)
    {
        $this->fromCartId = $fromCartId;
        $this->productId = $productId;
    }

    public function getFromCartId(): string
    {
        return $this->fromCartId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getPersistableEvent(): PersistableEvent
    {
        return new PersistableEvent(
            [
                'cartId' => $this->getFromCartId(),
                'removedProductReference' => $this->getProductId(),
            ],
            'cart/product-removed'
        );
    }
}
