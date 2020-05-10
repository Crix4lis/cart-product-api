<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain\Event;

use Task\App\Common\Event\DomainEvent;

class ProductRemoved implements DomainEvent
{
    private string $removedProductId;

    public function __construct(string $removedProductId)
    {
        $this->removedProductId = $removedProductId;
    }

    public function getRemovedProductId(): string
    {
        return $this->removedProductId;
    }
}
