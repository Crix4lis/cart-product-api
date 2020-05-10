<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain\Event;

use Task\App\Common\Event\DomainEvent;

class ProductTitleChanged implements DomainEvent
{
    private string $productId;
    private string $newProductTitle;

    public function __construct(string $productId, string $newProductTitle)
    {
        $this->productId = $productId;
        $this->newProductTitle = $newProductTitle;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getNewProductTitle(): string
    {
        return $this->newProductTitle;
    }
}
