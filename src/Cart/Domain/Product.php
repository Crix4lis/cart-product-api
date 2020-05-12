<?php
declare(strict_types=1);

namespace Task\App\Cart\Domain;

use Webmozart\Assert\Assert;

class Product
{
    private string $surrogateId;
    private string $productId;

    /**
     * @param string $productId
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $productId)
    {
        Assert::uuid($productId);
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
