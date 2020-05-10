<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain;

class Product
{
    private string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function equals(Product $toProduct): bool
    {
        if ($this->getProductId() === $toProduct->getProductId()) {
            return true;
        }

        return false;
    }
}
