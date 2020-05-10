<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Event;

use Task\App\Common\Event\DomainEvent;

class NewCartCreated implements DomainEvent
{
    private string $newCartId;
    private string $cartProductReference;

    public function __construct(string $newCartId, string $cartProductReference)
    {
        $this->newCartId = $newCartId;
        $this->cartProductReference = $cartProductReference;
    }

    public function getNewCartId(): string
    {
        return $this->newCartId;
    }

    public function getCartProductReference(): string
    {
        return $this->cartProductReference;
    }
}
