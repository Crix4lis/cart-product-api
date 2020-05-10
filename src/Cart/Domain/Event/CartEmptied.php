<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Event;

class CartEmptied
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
}
