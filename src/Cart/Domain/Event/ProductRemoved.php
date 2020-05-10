<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain\Event;

use Task\App\Common\Event\DomainEvent;

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
}
