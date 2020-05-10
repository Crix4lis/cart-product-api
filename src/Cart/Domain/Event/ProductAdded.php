<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Event;

use Task\App\Common\Event\DomainEvent;

class ProductAdded implements DomainEvent
{
    private string $toCartId;
    private string $productAdded;

    public function __construct(string $cartId, string $productAdded)
    {
        $this->toCartId = $cartId;
        $this->productAdded = $productAdded;
    }

    public function getToCartId(): string
    {
        return $this->toCartId;
    }

    public function getProductAdded(): string
    {
        return $this->productAdded;
    }
}
