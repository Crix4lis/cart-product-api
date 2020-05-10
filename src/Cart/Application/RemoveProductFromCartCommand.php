<?php
declare(strict_types=1);

namespace Task\App\Cart\Application;

class RemoveProductFromCartCommand
{
    private string $toCartId;
    private string $productReferenceToRemove;

    public function __construct(string $toCartId, string $productReferenceToAdd)
    {
        $this->toCartId = $toCartId;
        $this->productReferenceToRemove = $productReferenceToAdd;
    }

    public function getToCartId(): string
    {
        return $this->toCartId;
    }

    public function getProductReferenceToRemove(): string
    {
        return $this->productReferenceToRemove;
    }
}
