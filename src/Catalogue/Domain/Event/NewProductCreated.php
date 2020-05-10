<?php
declare(strict_types=1);

namespace Task\App\Catalogue\Domain\Event;

use Task\App\Common\Event\DomainEvent;

class NewProductCreated implements DomainEvent
{
    private string $newProductId;
    private string $newProductTitle;
    private string $newProductPriceAmount;
    private string $newProductPriceCurrency;

    public function __construct(
        string $newProductId,
        string $newProductTitle,
        string $newProductPriceAmount,
        string $newProductPriceCurrency
    )
    {
        $this->newProductId = $newProductId;
        $this->newProductTitle = $newProductTitle;
        $this->newProductPriceAmount = $newProductPriceAmount;
        $this->newProductPriceCurrency = $newProductPriceCurrency;
    }

    public function getNewProductId(): string
    {
        return $this->newProductId;
    }

    public function getNewProductTitle(): string
    {
        return $this->newProductTitle;
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
