<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain\Event;

use Task\App\Common\Event\DomainEvent;

class ProductPriceChanged implements DomainEvent
{
    private string $productId;
    private string $newProductPriceAmount;
    private string $newProductPriceCurrency;

    public function __construct(string $productId, string $newProductPriceAmount, string $newProductPriceCurrency)
    {
        $this->productId = $productId;
        $this->newProductPriceAmount = $newProductPriceAmount;
        $this->newProductPriceCurrency = $newProductPriceCurrency;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getNewProductPriceAmount(): string
    {
        return $this->newProductPriceAmount;
    }

    public function getNewProductPriceCurrency(): string
    {
        return $this->newProductPriceCurrency;
    }
}
