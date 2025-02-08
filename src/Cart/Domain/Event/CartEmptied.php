<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Event;

use Task\App\Common\Event\DomainEvent;
use Task\App\Common\Event\PersistableEvent;

class CartEmptied implements DomainEvent
{
    private string $cartId;

    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getPersistableEvent(): PersistableEvent
    {
        return new PersistableEvent(
            [
                'emptiedCartId' => $this->getCartId(),
            ],
            'cart/cart-emptied'
        );
    }
}
